<?php

namespace app\models;

use \Model;
use \DataBase;

class ServiciosModel extends Model
{
    public static function getServiciosActivos()
    {
        $sql = "SELECT 
                    s.id, 
                    s.nombre_servicio, 
                    s.duracion, 
                    s.precio, 
                    s.consultorio,
                    s.id_especialista,
                    e.nombre AS especialista_nombre, 
                    e.apellido AS especialista_apellido
                FROM servicios s
                INNER JOIN especialista e ON s.id_especialista = e.id
                WHERE s.estado = 1";

        return DataBase::query($sql);
    }

    public static function getServicioById($id)
    {
        $sql = "SELECT s.*, 
                       e.nombre AS esp_nombre, 
                       e.apellido AS esp_apellido,
                       e.especialidad 
                FROM servicios s
                INNER JOIN especialista e ON s.id_especialista = e.id
                WHERE s.id = :id AND s.estado = 1";

        return DataBase::getRecord($sql, [':id' => $id]);
    }

    public static function obtenerPorId($id)
    {
        return self::getServicioById($id);
    }

    /**
     * Trae todos los servicios (activos e inactivos) con su especialista asignado
     * para el panel del Administrador
     */
    public static function listarTodosAdmin()
    {
        try {
            $sql = "SELECT s.*, 
                           COALESCE(e.nombre, '') AS esp_nombre, 
                           COALESCE(e.apellido, '') AS esp_apellido,
                           COALESCE(e.especialidad, '') AS especialidad
                    FROM servicios s
                    LEFT JOIN especialista e ON s.id_especialista = e.id
                    ORDER BY s.id DESC";

            $res = DataBase::getRecords($sql);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }
            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Alterna la baja lógica de un servicio (estado: 1 activo, 0 inactivo)
     */
    public static function alternarBajaLogica($id_servicio, $nuevo_estado, $id_admin = 1)
    {
        try {
            $fechaBaja = ($nuevo_estado == 0) ? "NOW()" : "NULL";
            $sql = "UPDATE servicios 
                    SET estado = :estado,
                        fecha_baja = $fechaBaja
                    WHERE id = :id";

            DataBase::query($sql, [
                ':estado' => $nuevo_estado,
                ':id'     => $id_servicio
            ]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Inserta un nuevo servicio desde el panel de administración
     */
    public static function guardarServicio($datos, $id_admin = 1)
    {
        try {
            $sql = "INSERT INTO servicios (
                        nombre_servicio, id_especialista, duracion, precio, consultorio,
                        hora_inicio, hora_fin, fecha_desde, fecha_hasta, estado, fecha_alta
                    ) VALUES (
                        :nombre_servicio, :id_especialista, :duracion, :precio, :consultorio,
                        :hora_inicio, :hora_fin, :fecha_desde, :fecha_hasta, 1, NOW()
                    )";

            DataBase::query($sql, [
                ':nombre_servicio' => $datos['nombre_servicio'],
                ':id_especialista' => $datos['id_especialista'],
                ':duracion'        => $datos['duracion'],
                ':precio'          => $datos['precio'],
                ':consultorio'     => $datos['consultorio'],
                ':hora_inicio'     => $datos['hora_inicio'],
                ':hora_fin'        => $datos['hora_fin'],
                ':fecha_desde'     => $datos['fecha_desde'],
                ':fecha_hasta'     => $datos['fecha_hasta']
            ]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Actualiza un servicio existente
     */
    public static function actualizarServicio($id, $datos, $id_admin = 1)
    {
        try {
            $sql = "UPDATE servicios SET
                        nombre_servicio = :nombre_servicio,
                        id_especialista = :id_especialista,
                        duracion        = :duracion,
                        precio          = :precio,
                        consultorio     = :consultorio,
                        hora_inicio     = :hora_inicio,
                        hora_fin        = :hora_fin,
                        fecha_desde     = :fecha_desde,
                        fecha_hasta     = :fecha_hasta
                    WHERE id = :id";

            DataBase::query($sql, [
                ':id'              => $id,
                ':nombre_servicio' => $datos['nombre_servicio'],
                ':id_especialista' => $datos['id_especialista'],
                ':duracion'        => $datos['duracion'],
                ':precio'          => $datos['precio'],
                ':consultorio'     => $datos['consultorio'],
                ':hora_inicio'     => $datos['hora_inicio'],
                ':hora_fin'        => $datos['hora_fin'],
                ':fecha_desde'     => $datos['fecha_desde'],
                ':fecha_hasta'     => $datos['fecha_hasta']
            ]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}