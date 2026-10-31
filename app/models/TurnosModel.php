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

            DataBase::query($sql, $params);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Obtiene los turnos activos (pendientes o confirmados) del cliente
     */
    public static function obtenerTurnosActivos($id_usuario)
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
                      AND (t.estado = 'pendiente' OR t.estado = 'confirmado' OR t.estado IS NULL)
                    ORDER BY t.fecha ASC, t.hora ASC";

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
     * Verifica si el cliente ya tiene un turno registrado en esa misma fecha y hora
     */
    public static function tieneTurnoMismoHorario($id_usuario, $fecha, $hora)
    {
        try {
            $sql = "SELECT id FROM turnos 
                    WHERE id_usuario = :id_usuario 
                      AND fecha = :fecha 
                      AND hora = :hora 
                      AND estado IN ('pendiente', 'confirmado') 
                    LIMIT 1";

            $params = [
                ':id_usuario' => $id_usuario,
                ':fecha'      => $fecha,
                ':hora'       => $hora
            ];

            $res = \DataBase::getRecord($sql, $params);
            return !empty($res); // Retorna true si ya tiene turno, false si está libre
        } catch (\Throwable $e) {
            return false;
        }
    }
}