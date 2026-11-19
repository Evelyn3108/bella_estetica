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
     * Comprueba y crea las columnas 'imagen' y 'descripcion' en la tabla servicios si aún no existen
     */
    public static function asegurarColumnasServicio()
    {
        try {
            $pdo = \DataBase::connection();
            
            // 1. Columna imagen
            $checkImg = $pdo->query("SHOW COLUMNS FROM servicios LIKE 'imagen'")->fetch();
            if (!$checkImg) {
                $pdo->exec("ALTER TABLE servicios ADD COLUMN imagen VARCHAR(255) NULL DEFAULT NULL AFTER consultorio");
            }

            // 2. Columna descripcion
            $checkDesc = $pdo->query("SHOW COLUMNS FROM servicios LIKE 'descripcion'")->fetch();
            if (!$checkDesc) {
                $pdo->exec("ALTER TABLE servicios ADD COLUMN descripcion TEXT NULL DEFAULT NULL AFTER nombre_servicio");
            }
        } catch (\Throwable $e) {
            // Silencioso en caso de permisos o si ya fueron agregadas
        }
    }

    /**
     * Inserta un nuevo servicio desde el panel de administración
     */
    public static function guardarServicio($datos, $id_admin = 1)
    {
        self::asegurarColumnasServicio();

        $imagen      = !empty($datos['imagen']) ? $datos['imagen'] : null;
        $descripcion = !empty($datos['descripcion']) ? trim($datos['descripcion']) : null;

        try {
            $sql = "INSERT INTO servicios (id_especialista, nombre_servicio, descripcion, duracion, precio, consultorio, imagen, dias_atencion, hora_inicio, hora_fin, fecha_desde, fecha_hasta, estado, creado_por, fecha_alta)
                    VALUES (:id_especialista, :nombre_servicio, :descripcion, :duracion, :precio, :consultorio, :imagen, :dias_atencion, :hora_inicio, :hora_fin, :fecha_desde, :fecha_hasta, 1, :creado_por, NOW())";

            return \DataBase::execute($sql, [
                ':id_especialista' => $datos['id_especialista'],
                ':nombre_servicio' => $datos['nombre_servicio'],
                ':descripcion'     => $descripcion,
                ':duracion'        => $datos['duracion'],
                ':precio'          => $datos['precio'],
                ':consultorio'     => $datos['consultorio'],
                ':imagen'          => $imagen,
                ':dias_atencion'   => $datos['dias_atencion'],
                ':hora_inicio'     => $datos['hora_inicio'],
                ':hora_fin'        => $datos['hora_fin'],
                ':fecha_desde'     => $datos['fecha_desde'],
                ':fecha_hasta'     => $datos['fecha_hasta'],
                ':creado_por'      => $id_admin
            ]);
        } catch (\Throwable $e) {
            // Respaldo sin columnas adicionales por si existiera restricción
            try {
                $sqlSin = "INSERT INTO servicios (id_especialista, nombre_servicio, duracion, precio, consultorio, imagen, dias_atencion, hora_inicio, hora_fin, fecha_desde, fecha_hasta, estado, creado_por, fecha_alta)
                           VALUES (:id_especialista, :nombre_servicio, :duracion, :precio, :consultorio, :imagen, :dias_atencion, :hora_inicio, :hora_fin, :fecha_desde, :fecha_hasta, 1, :creado_por, NOW())";
                return \DataBase::execute($sqlSin, [
                    ':id_especialista' => $datos['id_especialista'],
                    ':nombre_servicio' => $datos['nombre_servicio'],
                    ':duracion'        => $datos['duracion'],
                    ':precio'          => $datos['precio'],
                    ':consultorio'     => $datos['consultorio'],
                    ':imagen'          => $imagen,
                    ':dias_atencion'   => $datos['dias_atencion'],
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
        self::asegurarColumnasServicio();

        $imagen      = isset($datos['imagen']) ? $datos['imagen'] : null;
        $descripcion = isset($datos['descripcion']) ? trim($datos['descripcion']) : null;

        try {
            if ($imagen !== null) {
                $sql = "UPDATE servicios SET
                            nombre_servicio    = :nombre_servicio,
                            descripcion        = :descripcion,
                            id_especialista    = :id_especialista,
                            duracion           = :duracion,
                            precio             = :precio,
                            consultorio        = :consultorio,
                            imagen             = :imagen,
                            dias_atencion      = :dias_atencion,
                            hora_inicio        = :hora_inicio,
                            hora_fin           = :hora_fin,
                            fecha_desde        = :fecha_desde,
                            fecha_hasta        = :fecha_hasta,
                            modificado_por     = :id_admin,
                            fecha_modificacion = NOW()
                        WHERE id = :id";

                return \DataBase::execute($sql, [
                    ':id'              => $id,
                    ':nombre_servicio' => $datos['nombre_servicio'],
                    ':descripcion'     => $descripcion,
                    ':id_especialista' => $datos['id_especialista'],
                    ':duracion'        => $datos['duracion'],
                    ':precio'          => $datos['precio'],
                    ':consultorio'     => $datos['consultorio'],
                    ':imagen'          => $imagen,
                    ':dias_atencion'   => $datos['dias_atencion'] ?? '1,2,3,4,5,6',
                    ':hora_inicio'     => $datos['hora_inicio'],
                    ':hora_fin'        => $datos['hora_fin'],
                    ':fecha_desde'     => $datos['fecha_desde'] ?? date('Y-m-d'),
                    ':fecha_hasta'     => $datos['fecha_hasta'] ?? date('Y-m-d', strtotime('+1 year')),
                    ':id_admin'        => $id_admin
                ]);
            } else {
                $sql = "UPDATE servicios SET
                            nombre_servicio    = :nombre_servicio,
                            descripcion        = :descripcion,
                            id_especialista    = :id_especialista,
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

                return \DataBase::execute($sql, [
                    ':id'              => $id,
                    ':nombre_servicio' => $datos['nombre_servicio'],
                    ':descripcion'     => $descripcion,
                    ':id_especialista' => $datos['id_especialista'],
                    ':duracion'        => $datos['duracion'],
                    ':precio'          => $datos['precio'],
                    ':consultorio'     => $datos['consultorio'],
                    ':dias_atencion'   => $datos['dias_atencion'] ?? '1,2,3,4,5,6',
                    ':hora_inicio'     => $datos['hora_inicio'],
                    ':hora_fin'        => $datos['hora_fin'],
                    ':fecha_desde'     => $datos['fecha_desde'] ?? date('Y-m-d'),
                    ':fecha_hasta'     => $datos['fecha_hasta'] ?? date('Y-m-d', strtotime('+1 year')),
                    ':id_admin'        => $id_admin
                ]);
            }
        } catch (\Throwable $e) {
            return false;
        }
    }           

   
}