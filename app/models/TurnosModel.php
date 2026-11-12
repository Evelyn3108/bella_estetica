<?php

namespace app\models;

use \Model;
use \DataBase;

class TurnosModel extends Model
{
    /**
     * Comprueba disponibilidad horaria de un especialista
     */
    public static function comprobarDisponibilidad($id_especialista, $fecha, $hora)
    {
        try {
            $sql = "SELECT id FROM turnos 
                    WHERE id_especialista = :id_especialista 
                      AND fecha = :fecha 
                      AND hora = :hora 
                      AND estado IN ('pendiente', 'confirmado') 
                    LIMIT 1";

            $params = [
                ':id_especialista' => $id_especialista,
                ':fecha'           => $fecha,
                ':hora'            => $hora
            ];

            $res = DataBase::getRecord($sql, $params);
            return empty($res);
        } catch (\Throwable $e) {
            return true;
        }
    }

    /**
     * Inserta un turno en la base de datos
     */
    /**
     * Inserta el turno en la tabla turnos
     */
    public static function insertarTurno($id_usuario, $id_servicio, $id_especialista, $fecha, $hora)
    {
        try {
            $sql = "INSERT INTO turnos (id_usuario, id_servicio, id_especialista, fecha, hora, estado, fecha_alta) 
                    VALUES (:id_usuario, :id_servicio, :id_especialista, :fecha, :hora, 'pendiente', NOW())";

            $params = [
                ':id_usuario'      => $id_usuario,
                ':id_servicio'     => $id_servicio,
                ':id_especialista' => $id_especialista,
                ':fecha'           => $fecha,
                ':hora'            => $hora
            ];

            return \DataBase::execute($sql, $params);
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Trae los turnos del cliente para mostrarlos en su perfil
     */
    public static function obtenerTurnosActivos($id_usuario)
    {
        try {
            $sql = "SELECT t.id, t.fecha, t.hora, t.estado, t.id_especialista,
                           COALESCE(s.nombre_servicio, 'Servicio General') AS nombre_servicio, 
                           COALESCE(s.consultorio, 'Consultorio 1') AS consultorio, 
                           COALESCE(s.duracion, 45) AS duracion, 
                           COALESCE(s.precio, 0) AS precio,
                           COALESCE(e.nombre, '') AS esp_nombre, 
                           COALESCE(e.apellido, '') AS esp_apellido
                    FROM turnos t
                    LEFT JOIN servicios s ON t.id_servicio = s.id
                    LEFT JOIN especialista e ON t.id_especialista = e.id
                    WHERE t.id_usuario = :id_usuario 
                      AND (LOWER(t.estado) = 'pendiente' OR LOWER(t.estado) = 'confirmado' OR t.estado IS NULL)
                    ORDER BY t.fecha ASC, t.hora ASC";

            $res = \DataBase::getRecords($sql, [':id_usuario' => $id_usuario]);

            // Si la cátedra encapsula la respuesta en ['resultado']
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }

            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Obtiene el historial de turnos (asistidos o cancelados)
     */
    public static function obtenerHistorialTurnos($id_usuario)
    {
        try {
            $sql = "SELECT t.id, t.fecha, t.hora, t.estado, 
                           COALESCE(s.nombre_servicio, 'Servicio Estético') AS nombre_servicio, 
                           COALESCE(s.consultorio, 'Consultorio 1') AS consultorio,
                           COALESCE(e.nombre, '') AS esp_nombre, 
                           COALESCE(e.apellido, '') AS esp_apellido
                    FROM turnos t
                    LEFT JOIN servicios s ON t.id_servicio = s.id
                    LEFT JOIN especialista e ON t.id_especialista = e.id
                    WHERE t.id_usuario = :id_usuario 
                      AND t.estado IN ('asistido', 'cancelado')
                    ORDER BY t.fecha DESC, t.hora DESC";

            $res = DataBase::getRecords($sql, [':id_usuario' => $id_usuario]);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }
            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Cancela un turno perteneciente al usuario logueado
     */
    public static function cancelarTurno($id_turno, $id_usuario)
    {
        try {
            $sql = "UPDATE turnos 
                    SET estado = 'cancelado' 
                    WHERE id = :id_turno AND id_usuario = :id_usuario";
            
            DataBase::query($sql, [
                ':id_turno'   => $id_turno,
                ':id_usuario' => $id_usuario
            ]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

   /**
     * Verifica si el usuario ya tiene un turno registrado en esa misma fecha y hora
     */
    public static function tieneTurnoMismoHorario($id_usuario, $fecha, $hora)
    {
        try {
            // Normalizamos la hora a los primeros 5 caracteres (HH:MM)
            $horaLimpia = substr(trim($hora), 0, 5);

            $sql = "SELECT id FROM turnos 
                    WHERE id_usuario = :id_usuario 
                      AND fecha = :fecha 
                      AND (TIME_FORMAT(hora, '%H:%i') = :hora OR hora LIKE :hora_like)
                      AND (LOWER(estado) IN ('pendiente', 'confirmado') OR estado IS NULL)
                    LIMIT 1";

            $params = [
                ':id_usuario' => $id_usuario,
                ':fecha'      => $fecha,
                ':hora'       => $horaLimpia,
                ':hora_like'  => $horaLimpia . '%'
            ];

            $res = \DataBase::getRecord($sql, $params);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }

            return !empty($res);
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Verifica si el usuario ya tiene un turno con este especialista en la fecha especificada
     */
    public static function tieneTurnoConEspecialistaEnFecha($id_usuario, $id_especialista, $fecha)
    {
        try {
            $sql = "SELECT id FROM turnos 
                    WHERE id_usuario = :id_usuario 
                      AND id_especialista = :id_especialista 
                      AND fecha = :fecha 
                      AND (LOWER(estado) IN ('pendiente', 'confirmado') OR estado IS NULL)
                    LIMIT 1";

            $params = [
                ':id_usuario'      => $id_usuario,
                ':id_especialista' => $id_especialista,
                ':fecha'           => $fecha
            ];

            $res = \DataBase::getRecord($sql, $params);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }

            return !empty($res);
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Obtiene los turnos reservados que tiene un especialista para fechas futuras
     */
    public static function obtenerTurnosOcupadosEspecialista($id_especialista)
    {
        try {
            $sql = "SELECT fecha, TIME_FORMAT(hora, '%H:%i') AS hora 
                    FROM turnos 
                    WHERE id_especialista = :id_especialista 
                      AND fecha >= CURDATE() 
                      AND (LOWER(estado) IN ('pendiente', 'confirmado') OR estado IS NULL)";

            $res = \DataBase::getRecords($sql, [':id_especialista' => $id_especialista]);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }

            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            return [];
        }
    }

   /**
     * Obtiene la agenda para el Admin:
     * - Si se pasa una fecha (YYYY-MM-DD), filtra por ese día.
     * - Si viene vacío o null, trae todos los turnos.
     */
    public static function obtenerAgendaAdmin($fecha = null)
    {
        try {
            $sql = "SELECT t.id, 
                           t.fecha, 
                           t.hora, 
                           t.estado,
                           COALESCE(u.nombre, 'Cliente') AS cliente_nombre, 
                           COALESCE(u.apellido, '') AS cliente_apellido, 
                           COALESCE(u.telefono, '-') AS cliente_telefono,
                           COALESCE(s.nombre_servicio, 'Tratamiento') AS nombre_servicio, 
                           COALESCE(s.consultorio, 'Consultorio 1') AS consultorio,
                           COALESCE(e.nombre, '') AS esp_nombre, 
                           COALESCE(e.apellido, '') AS esp_apellido
                    FROM turnos t
                    LEFT JOIN usuario u ON t.id_usuario = u.id
                    LEFT JOIN servicios s ON t.id_servicio = s.id
                    LEFT JOIN especialista e ON t.id_especialista = e.id";

            $params = [];

            if (!empty($fecha)) {
                $sql .= " WHERE DATE(t.fecha) = :fecha";
                $params[':fecha'] = $fecha;
            }

            $sql .= " ORDER BY t.fecha DESC, t.hora ASC";

            $res = \DataBase::getRecords($sql, $params);

            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }

            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Actualiza el estado de un turno con auditoría
     */
    public static function actualizarEstadoTurno($id_turno, $nuevo_estado, $id_admin)
    {
        try {
            $sql = "UPDATE TURNOS 
                    SET estado = :estado, 
                        modificado_por = :id_admin,
                        fecha_modificacion = NOW()
                    WHERE id = :id";

            \DataBase::query($sql, [
                ':estado'   => $nuevo_estado,
                ':id_admin' => $id_admin,
                ':id'       => $id_turno
            ]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

}