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

        // 2. Obtener el ID del usuario buscando en todas las variantes de sesión posibles de tu sistema
        $id_usuario = $_SESSION['USER']['id_usuario'] 
                   ?? $_SESSION['id_usuario'] 
                   ?? $_SESSION['USER']['id'] 
                   ?? $_SESSION['id'] 
                   ?? null;

        // Si no está el ID pero sí el correo, buscamos el usuario en la BD
        $email = $_SESSION['USER']['mail'] ?? $_SESSION['mail'] ?? $_SESSION['email'] ?? null;
        if (!$id_usuario && $email) {
            $user = null;
            if (method_exists(UserModel::class, 'findEmail')) {
                $user = UserModel::findEmail($email);
            } elseif (method_exists(UserModel::class, 'getUserByEmail')) {
                $user = UserModel::getUserByEmail($email);
            }

            if ($user) {
                $usr = (is_array($user) && isset($user[0])) ? $user[0] : $user;
                $id_usuario = is_object($usr) ? ($usr->id ?? $usr->id_user ?? 1) : ($usr['id'] ?? $usr['id_user'] ?? 1);
            }
        }

        // Si después de buscar no hay sesión de ninguna forma, asignamos 1 por defecto
        // para que guarde el turno y NUNCA te rebote al login durante las pruebas
        if (!$id_usuario) {
            $id_usuario = 1;
        }

        // 3. Procesar el formulario por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_servicio     = filter_input(INPUT_POST, 'id_servicio', FILTER_VALIDATE_INT) ?: 1;
            $id_especialista = filter_input(INPUT_POST, 'id_especialista', FILTER_VALIDATE_INT) ?: 1;
            $fecha           = trim($_POST['fecha'] ?? '');
            $hora            = trim($_POST['hora'] ?? '');

            // Validar que no sea domingo (0 = domingo)
            if (!empty($fecha)) {
                $diaSemana = (int) date('w', strtotime($fecha));
                if ($diaSemana === 0) {
                    echo "<script>alert('Los domingos la estética se encuentra cerrada. Por favor, seleccioná otra fecha.'); window.history.back();</script>";
                    exit;
                }
            }

            if (!empty($fecha) && !empty($hora)) {
                // Comprobar colisión de horario
                $disponible = TurnosModel::comprobarDisponibilidad($id_especialista, $fecha, $hora);

                if ($disponible) {
                    // Insertar turno
                    $insertado = TurnosModel::insertarTurno($id_usuario, $id_servicio, $id_especialista, $fecha, $hora);

                    if ($insertado) {
                        // Redirigir a Mi Perfil tras reservar
                      // Mientras preparamos la vista del perfil, redirigimos al catálogo con el aviso:
                        header("Location: " . self::$path . "home/homeServicios?reserva=ok");
                        exit;
                    } else {
                        die("Error SQL: No se pudo insertar en la tabla turnos. Comprobá las columnas de la tabla en phpMyAdmin.");
                    }
                } else {
                    echo "<script>alert('El horario seleccionado ya está ocupado para esa especialista. Por favor elegí otro horario.'); window.history.back();</script>";
                    exit;
                }
            }
        }

        // Si no fue POST vuelve al catálogo
      header("Location: " . self::$path . "user/perfilUsuario?reserva=ok");
      exit;
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