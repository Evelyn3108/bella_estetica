<?php

namespace app\controllers;

use \Controller;
use \Response;
use app\models\TurnosModel;
use app\models\UserModel;

class TurnosController extends Controller
{
    // Constructor
    public function __construct()
    {
        self::$sessionStatus = SessionController::sessionVerificacion();
    }

   /**
     * Procesa la reserva del turno enviada desde detalleServicios.php
     */
    public function actionReservar()
    {
        // 1. Asegurar sesión activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        static::path();

        // 2. Obtener el ID del usuario buscando en las variantes de sesión
        $id_usuario = $_SESSION['USER']['id_usuario'] 
                    ?? $_SESSION['id_usuario'] 
                    ?? $_SESSION['USER']['id'] 
                    ?? $_SESSION['id'] 
                    ?? null;

        $email = $_SESSION['USER']['mail'] ?? $_SESSION['mail'] ?? $_SESSION['email'] ?? null;
        if (!$id_usuario && $email) {
            $user = null;
            if (method_exists(\app\models\UserModel::class, 'findEmail')) {
                $user = \app\models\UserModel::findEmail($email);
            } elseif (method_exists(\app\models\UserModel::class, 'getUserByEmail')) {
                $user = \app\models\UserModel::getUserByEmail($email);
            }

            if ($user) {
                $usr = (is_array($user) && isset($user[0])) ? $user[0] : $user;
                $id_usuario = is_object($usr) ? ($usr->id ?? $usr->id_user ?? 1) : ($usr['id'] ?? $usr['id_user'] ?? 1);
            }
        }

        if (!$id_usuario) {
            $id_usuario = 1;
        }

        $error = null;
        $id_servicio = filter_input(INPUT_POST, 'id_servicio', FILTER_VALIDATE_INT) ?: (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 1);

        // 3. Procesar el formulario por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_especialista = filter_input(INPUT_POST, 'id_especialista', FILTER_VALIDATE_INT) ?: 1;
            $fecha           = trim($_POST['fecha'] ?? '');
            $hora            = trim($_POST['hora'] ?? '');

            if (empty($fecha) || empty($hora)) {
                $error = "Por favor, seleccioná una fecha y un horario disponible.";
            } else {
                // Validar que no sea domingo
                $diaSemana = (int) date('w', strtotime($fecha));
                if ($diaSemana === 0) {
                    $error = "Los domingos la estética se encuentra cerrada. Por favor, seleccioná otra fecha.";
                } 
                // Validar si el cliente ya tiene un turno registrado en esa fecha y horario
                elseif (\app\models\TurnosModel::tieneTurnoMismoHorario($id_usuario, $fecha, $hora)) {
                    $error = "Ya tenés un turno registrado para este horario.";
                } else {
                    // Comprobar disponibilidad con la especialista asignada
                    $disponible = \app\models\TurnosModel::comprobarDisponibilidad($id_especialista, $fecha, $hora);

                    if (!$disponible) {
                        $error = "El horario seleccionado ya está ocupado para esa especialista. Por favor elegí otro horario.";
                    } else {
                        // Insertar turno
                        $insertado = \app\models\TurnosModel::insertarTurno($id_usuario, $id_servicio, $id_especialista, $fecha, $hora);

                        if ($insertado) {
                            header("Location: " . self::$path . "user/perfilUsuario?reserva=ok");
                            exit;
                        } else {
                            $error = "Ocurrió un error al procesar la reserva en la base de datos.";
                        }
                    }
                }
            }
        }

        // 4. Si hubo error o si entró por GET, renderiza la vista pasando la variable $error
        $servicio = null;
        if (class_exists(\app\models\ServiciosModel::class) && method_exists(\app\models\ServiciosModel::class, 'getServicioById')) {
            $servData = \app\models\ServiciosModel::getServicioById($id_servicio);
            if (is_array($servData) && isset($servData['resultado'])) {
                $servicio = $servData['resultado'][0] ?? null;
            } else {
                $servicio = is_array($servData) && isset($servData[0]) ? $servData[0] : $servData;
            }
        }

        $parametros_de_vista = [
            "ruta"        => self::$path,
            "servicio"    => $servicio,
            "error"       => $error,
            "id_servicio" => $id_servicio
        ];

        \Response::render('home/', 'detalleServicios', $parametros_de_vista);
    }

    /**
     * Obtiene los turnos pendientes o confirmados del usuario con los datos del servicio y especialista
     */
    public static function obtenerTurnosPorUsuario($id_usuario)
    {
        $sql = "SELECT t.id, t.fecha, t.hora, t.estado, 
                       s.nombre_servicio, s.duracion, s.precio, s.consultorio,
                       e.nombre AS esp_nombre, e.apellido AS esp_apellido
                FROM turnos t
                INNER JOIN servicios s ON t.id_servicio = s.id
                INNER JOIN especialista e ON t.id_especialista = e.id
                WHERE t.id_usuario = :id_usuario
                ORDER BY t.fecha ASC, t.hora ASC";

        return DataBase::getRecords($sql, [':id_usuario' => $id_usuario]);
    }

    /**
     * Cancela un turno cambiando su estado a 'cancelado'
     */
    public static function cancelarTurno($id_turno, $id_usuario)
    {
        $sql = "UPDATE turnos SET estado = 'cancelado' 
                WHERE id = :id_turno AND id_usuario = :id_usuario";

        return DataBase::query($sql, [
            ':id_turno'   => $id_turno,
            ':id_usuario' => $id_usuario
        ]);
    }

    /**
     * Cancela un turno y redirige a la vista de perfil
     */
    public function actionCancelar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        static::path();

        if (empty($_SESSION['USER']['id_usuario']) && empty($_SESSION['USER']['mail'])) {
            header("Location: " . self::$path . "account/login");
            exit;
        }

        $id_usuario = $_SESSION['USER']['id_usuario'] ?? null;
        if (!$id_usuario && isset($_SESSION['USER']['mail'])) {
            $usr = \app\models\UserModel::findEmail($_SESSION['USER']['mail']);
            if (is_array($usr) && isset($usr[0])) { $usr = $usr[0]; }
            $id_usuario = is_object($usr) ? ($usr->id ?? 1) : ($usr['id'] ?? 1);
        }

        $id_turno = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id_turno && $id_usuario) {
            \app\models\TurnosModel::cancelarTurno($id_turno, $id_usuario);
        }

        // Redirige al perfil en la pestaña de turnos con aviso
        header("Location: " . self::$path . "user/perfilUsuario?cancelado=ok");
        exit;
    }
}