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

    public function actionReservar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        static::path();

        // 1. Verificación de sesión de usuario
        if (empty($_SESSION['USER']['id_usuario']) && empty($_SESSION['USER']['mail'])) {
            header("Location: " . self::$path . "account/login");
            exit;
        }

        $id_usuario = $_SESSION['USER']['id_usuario'] ?? null;
        if (!$id_usuario && isset($_SESSION['USER']['mail'])) {
            $user = null;
            if (method_exists(\app\models\UserModel::class, 'findEmail')) {
                $user = \app\models\UserModel::findEmail($_SESSION['USER']['mail']);
            } elseif (method_exists(\app\models\UserModel::class, 'getUserByEmail')) {
                $user = \app\models\UserModel::getUserByEmail($_SESSION['USER']['mail']);
            }

            $usr = (is_array($user) && isset($user[0])) ? $user[0] : $user;
            $id_usuario = is_object($usr) ? ($usr->id ?? 1) : ($usr['id'] ?? 1);
            $_SESSION['USER']['id_usuario'] = $id_usuario;
        }

        if (!$id_usuario) {
            $id_usuario = 1;
        }

        $error = null;

        // 2. Procesamiento del formulario por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_servicio     = filter_input(INPUT_POST, 'id_servicio', FILTER_VALIDATE_INT) ?: 1;
            $id_especialista = filter_input(INPUT_POST, 'id_especialista', FILTER_VALIDATE_INT) ?: 1;
            $fecha           = trim($_POST['fecha'] ?? '');
            $hora            = trim($_POST['hora'] ?? '');

            if (empty($fecha) || empty($hora) || empty($id_servicio)) {
                $error = "Por favor, seleccioná una fecha y un horario disponible.";
            } else {
                // Validación 1: Bloquear domingos (0 = Domingo)
                $diaSemana = (int) date('w', strtotime($fecha));
                if ($diaSemana === 0) {
                    $error = "Los domingos la estética permanece cerrada. Por favor, seleccioná una fecha de lunes a sábado.";
                }
                // Validación 2: Comprobar si el cliente ya tiene un turno reservado para esa fecha y hora
                elseif (\app\models\TurnosModel::tieneTurnoMismoHorario($id_usuario, $fecha, $hora)) {
                    $error = "Ya tenés un turno registrado para este horario.";
                }
                else {
                    // Validación 3: Comprobar disponibilidad de la especialista
                    $disponible = \app\models\TurnosModel::comprobarDisponibilidad($id_especialista, $fecha, $hora);

                    if (!$disponible) {
                        $error = "El horario seleccionado ya no se encuentra disponible para esta especialista. Por favor, elegí otro.";
                    } else {
                        // Inserción segura
                        $guardado = \app\models\TurnosModel::insertarTurno($id_usuario, $id_servicio, $id_especialista, $fecha, $hora);

                        if ($guardado) {
                            header("Location: " . self::$path . "usuario/perfilUsuario?reserva=ok");
                            exit;
                        } else {
                            $error = "Ocurrió un error al registrar el turno. Intentalo nuevamente.";
                        }
                    }
                }
            }
        }

        // Si falló o hubo colisión, se vuelve a cargar la vista pasando el mensaje de error
        $idServicio = $_POST['id_servicio'] ?? ($_GET['id'] ?? 1);
        $servicio   = \app\models\ServiciosModel::getServicioById($idServicio);
        if (is_array($servicio) && isset($servicio[0])) {
            $servicio = $servicio[0];
        }

        $parametros = [
            "ruta"        => self::$path,
            "servicio"    => $servicio,
            "error"       => $error,
            "id_servicio" => $idServicio
        ];

        // Se renderiza detalleServicios.php (o detalleServicio.php según tu archivo)
        \Response::render('home/', 'detalleServicios', $parametros);
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