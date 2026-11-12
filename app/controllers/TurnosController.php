<?php

namespace app\controllers;

use \Controller;
use \Response;
use \DataBase;
use app\models\TurnosModel;
use app\models\ServiciosModel;
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

        // 1. Obtener ID del usuario desde la sesión de forma segura
        $id_usuario = $_SESSION['USER']['id_usuario'] 
                   ?? $_SESSION['id_usuario'] 
                   ?? $_SESSION['USER']['id'] 
                   ?? null;

        if (!$id_usuario && isset($_SESSION['USER']['mail'])) {
            $user = UserModel::findEmail($_SESSION['USER']['mail']);
            if (is_array($user) && isset($user[0])) { $user = $user[0]; }
            $id_usuario = is_object($user) ? ($user->id ?? 1) : ($user['id'] ?? 1);
            $_SESSION['USER']['id_usuario'] = $id_usuario;
        }

        // Si no está logueado, lo mandamos al login
        if (!$id_usuario) {
            header("Location: " . self::$path . "account/login");
            exit;
        }

        // 2. Procesar el formulario enviado por la vista
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_servicio     = filter_input(INPUT_POST, 'id_servicio', FILTER_VALIDATE_INT) ?: 1;
            $id_especialista = filter_input(INPUT_POST, 'id_especialista', FILTER_VALIDATE_INT) ?: 1;
            $fecha           = trim($_POST['fecha'] ?? '');
            $hora            = trim($_POST['hora'] ?? '');

            if (!empty($fecha) && !empty($hora)) {
                // --- VALIDACIÓN DE DÍAS DE ATENCIÓN ---
                $servicioInfo = ServiciosModel::getServicioById($id_servicio);
                if (is_array($servicioInfo) && isset($servicioInfo['resultado'])) {
                    $servicioInfo = $servicioInfo['resultado'][0] ?? null;
                }
                $arrServ = (array)$servicioInfo;

                // Días configurados (1 = Lunes, 2 = Martes, ..., 6 = Sábado)
                $diasHabilitados = !empty($arrServ['dias_atencion']) 
                    ? explode(',', $arrServ['dias_atencion']) 
                    : ['1', '2', '3', '4', '5', '6'];

                $diaSemanaSeleccionado = (int)date('w', strtotime($fecha)); // 0 = Domingo, 1 = Lunes, ...

                // Bloquea domingos o días que no atienda el especialista
                if ($diaSemanaSeleccionado === 0 || !in_array((string)$diaSemanaSeleccionado, $diasHabilitados)) {
                    header("Location: " . self::$path . "home/detalleServicio?id=" . $id_servicio . "&error=dia_no_disponible");
                    exit;
                }

                // --- VALIDACIONES DE DISPONIBILIDAD ---
                // Si el método tieneTurnoMismoHorario existe, valida que el cliente no duplique turnos
                if (method_exists(TurnosModel::class, 'tieneTurnoMismoHorario') && TurnosModel::tieneTurnoMismoHorario($id_usuario, $fecha, $hora)) {
                    header("Location: " . self::$path . "home/detalleServicio?id=" . $id_servicio . "&error=turno_duplicado");
                    exit;
                }

                // Valida que el especialista esté libre
                if (method_exists(TurnosModel::class, 'comprobarDisponibilidad') && !TurnosModel::comprobarDisponibilidad($id_especialista, $fecha, $hora)) {
                    header("Location: " . self::$path . "home/detalleServicio?id=" . $id_servicio . "&error=horario_ocupado");
                    exit;
                }

                // Insertar el turno en la base de datos
                $guardado = TurnosModel::insertarTurno($id_usuario, $id_servicio, $id_especialista, $fecha, $hora);

                if ($guardado) {
                    header("Location: " . self::$path . "user/perfilUsuario?reserva=ok");
                    exit;
                }
            }
        }

        header("Location: " . self::$path . "home/homeServicios");
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
            $usr = UserModel::findEmail($_SESSION['USER']['mail']);
            if (is_array($usr) && isset($usr[0])) { $usr = $usr[0]; }
            $id_usuario = is_object($usr) ? ($usr->id ?? 1) : ($usr['id'] ?? 1);
        }

        $id_turno = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id_turno && $id_usuario) {
            TurnosModel::cancelarTurno($id_turno, $id_usuario);
        }

        header("Location: " . self::$path . "user/perfilUsuario?cancelado=ok");
        exit;
    }
}