<?php

namespace app\models;

use \Model;
use \DataBase;

class ServiciosModel extends Model
{
    /**
     * Catálogo del Cliente:
     * Trae todos los datos del servicio y especialista
     * ÚNICAMENTE si el servicio está activo (1) Y el especialista está activo (1)
     */
    public static function getServiciosActivos()
    {
        try {
            $sql = "SELECT 
                        s.*,
                        s.id,
                        s.nombre_servicio,
                        s.duracion,
                        s.precio,
                        s.consultorio,
                        s.id_especialista,
                        e.nombre AS especialista_nombre,
                        e.apellido AS especialista_apellido,
                        CONCAT(e.nombre, ' ', e.apellido) AS nombre_completo_especialista
                    FROM servicios s
                    INNER JOIN especialista e ON s.id_especialista = e.id
                    WHERE s.estado = 1 
                      AND e.estado = 1
                    ORDER BY s.id ASC";

            $res = \DataBase::getRecords($sql);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }
            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            // Respaldo en caso de que use DataBase::query directo
            try {
                return \DataBase::query($sql);
            } catch (\Throwable $ex) {
                return [];
            }
        }
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
     * Catálogo del Administrador:
     * Trae TODOS los servicios (activos e inactivos) para poder gestionarlos,
     * auditarlos y reactivarlos desde el panel.
     */
    public static function listarTodosAdmin()
    {
        try {
            $sql = "SELECT s.*, 
                           CONCAT(COALESCE(e.nombre, ''), ' ', COALESCE(e.apellido, '')) AS especialista_nombre,
                           e.estado AS especialista_estado
                    FROM servicios s
                    LEFT JOIN especialista e ON s.id_especialista = e.id
                    ORDER BY s.id DESC";

            $res = \DataBase::getRecords($sql);
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
            $sql = "INSERT INTO servicios (id_especialista, nombre_servicio, duracion, precio, consultorio, dias_atencion, hora_inicio, hora_fin, fecha_desde, fecha_hasta, estado, creado_por, fecha_alta)
                    VALUES (:id_especialista, :nombre_servicio, :duracion, :precio, :consultorio, :dias_atencion, :hora_inicio, :hora_fin, :fecha_desde, :fecha_hasta, 1, :creado_por, NOW())";

            return \DataBase::query($sql, [
                ':id_especialista' => $datos['id_especialista'],
                ':nombre_servicio' => $datos['nombre_servicio'],
                ':duracion'        => $datos['duracion'],
                ':precio'          => $datos['precio'],
                ':consultorio'     => $datos['consultorio'],
                ':dias_atencion'   => $datos['dias_atencion'],
                ':hora_inicio'     => $datos['hora_inicio'],
                ':hora_fin'        => $datos['hora_fin'],
                ':fecha_desde'     => $datos['fecha_desde'],
                ':fecha_hasta'     => $datos['fecha_hasta'],
                ':creado_por'      => $id_admin
            ]);
        } catch (\Throwable $e) {
            // Si la columna dias_atencion aún no existe en tu tabla, intenta guardar sin ella como respaldo
            try {
                $sqlSinDias = "INSERT INTO servicios (id_especialista, nombre_servicio, duracion, precio, consultorio, hora_inicio, hora_fin, fecha_desde, fecha_hasta, estado, creado_por, fecha_alta)
                               VALUES (:id_especialista, :nombre_servicio, :duracion, :precio, :consultorio, :hora_inicio, :hora_fin, :fecha_desde, :fecha_hasta, 1, :creado_por, NOW())";
                return \DataBase::query($sqlSinDias, [
                    ':id_especialista' => $datos['id_especialista'],
                    ':nombre_servicio' => $datos['nombre_servicio'],
                    ':duracion'        => $datos['duracion'],
                    ':precio'          => $datos['precio'],
                    ':consultorio'     => $datos['consultorio'],
                    ':hora_inicio'     => $datos['hora_inicio'],
                    ':hora_fin'        => $datos['hora_fin'],
                    ':fecha_desde'     => $datos['fecha_desde'],
                    ':fecha_hasta'     => $datos['fecha_hasta'],
                    ':creado_por'      => $id_admin
                ]);
            } catch (\Throwable $ex) {
                return false;
            }
        }
    }

    public static function actualizarServicio($id, $datos, $id_admin = 1)
    {
        try {
            $sql = "UPDATE servicios 
                    SET id_especialista    = :id_especialista,
                        nombre_servicio    = :nombre_servicio,
                        duracion           = :duracion,
                        precio             = :precio,
                        consultorio        = :consultorio,
                        dias_atencion      = :dias_atencion,
                        hora_inicio        = :hora_inicio,
                        hora_fin           = :hora_fin,
                        fecha_desde        = :fecha_desde,
                        fecha_hasta        = :fecha_hasta,
                        modificado_por     = :id_admin,
                        fecha_modificacion = NOW()
                    WHERE id = :id";

            return \DataBase::query($sql, [
                ':id_especialista' => $datos['id_especialista'],
                ':nombre_servicio' => $datos['nombre_servicio'],
                ':duracion'        => $datos['duracion'],
                ':precio'          => $datos['precio'],
                ':consultorio'     => $datos['consultorio'],
                ':dias_atencion'   => $datos['dias_atencion'],
                ':hora_inicio'     => $datos['hora_inicio'],
                ':hora_fin'        => $datos['hora_fin'],
                ':fecha_desde'     => $datos['fecha_desde'],
                ':fecha_hasta'     => $datos['fecha_hasta'],
                ':id_admin'        => $id_admin,
                ':id'              => $id
            ]);
        } catch (\Throwable $e) {
            // Respaldo sin la columna dias_atencion
            try {
                $sqlSinDias = "UPDATE servicios 
                               SET id_especialista    = :id_especialista,
                                   nombre_servicio    = :nombre_servicio,
                                   duracion           = :duracion,
                                   precio             = :precio,
                                   consultorio        = :consultorio,
                                   hora_inicio        = :hora_inicio,
                                   hora_fin           = :hora_fin,
                                   fecha_desde        = :fecha_desde,
                                   fecha_hasta        = :fecha_hasta,
                                   modificado_por     = :id_admin,
                                   fecha_modificacion = NOW()
                               WHERE id = :id";
                return \DataBase::query($sqlSinDias, [
                    ':id_especialista' => $datos['id_especialista'],
                    ':nombre_servicio' => $datos['nombre_servicio'],
                    ':duracion'        => $datos['duracion'],
                    ':precio'          => $datos['precio'],
                    ':consultorio'     => $datos['consultorio'],
                    ':hora_inicio'     => $datos['hora_inicio'],
                    ':hora_fin'        => $datos['hora_fin'],
                    ':fecha_desde'     => $datos['fecha_desde'],
                    ':fecha_hasta'     => $datos['fecha_hasta'],
                    ':id_admin'        => $id_admin,
                    ':id'              => $id
                ]);
            } catch (\Throwable $ex) {
                return false;
            }
        }
    }            

   
}