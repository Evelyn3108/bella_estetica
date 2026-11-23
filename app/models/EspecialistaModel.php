<?php

namespace app\models;

use \Model;
use \DataBase;

class EspecialistaModel extends Model
{
    /**
     * Obtiene todos los especialistas activos (estado = 1)
     * Utilizado para selectores y reservas
     */
    public static function obtenerActivos()
    {
        try {
            $sql = "SELECT id, nombre, apellido, especialidad 
                    FROM especialista 
                    WHERE estado = 1 
                    ORDER BY apellido ASC, nombre ASC";

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
     * Obtiene un especialista por su ID
     */
    public static function obtenerPorId($id)
    {
        try {
            $sql = "SELECT * FROM especialista WHERE id = :id AND estado = 1 LIMIT 1";
            return DataBase::getRecord($sql, [':id' => $id]);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function listarTodos()
    {
        try {
            $sql = "SELECT id, nombre, apellido, especialidad, fecha_alta, creado_por, estado 
                    FROM especialista 
                    WHERE estado != -1
                    ORDER BY id ASC";

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
     * Da de alta un nuevo especialista
     */
    public static function crearEspecialista($nombre, $apellido, $especialidad, $id_admin = 1)
    {
        try {
            // Intento 1: Incluyendo auditoría completa (creado_por y fecha_alta)
            $sql = "INSERT INTO especialista (nombre, apellido, especialidad, estado, creado_por, fecha_alta)
                    VALUES (:nombre, :apellido, :especialidad, 1, :id_admin, NOW())";

            return DataBase::execute($sql, [
                ':nombre'       => $nombre,
                ':apellido'     => $apellido,
                ':especialidad' => $especialidad,
                ':id_admin'     => $id_admin
            ]);
        } catch (\Throwable $e) {
            // Intento 2: Inserción básica como respaldo si no existen columnas de auditoría
            try {
                $sqlBasico = "INSERT INTO especialista (nombre, apellido, especialidad, estado)
                              VALUES (:nombre, :apellido, :especialidad, 1)";
                return DataBase::execute($sqlBasico, [
                    ':nombre'       => $nombre,
                    ':apellido'     => $apellido,
                    ':especialidad' => $especialidad
                ]);
            } catch (\Throwable $ex) {
                return false;
            }
        }
    }

    /**
     * Baja o alta lógica de especialista (estado = 1 activo, 0 inactivo)
     */
    public static function alternarBajaLogica($id, $nuevo_estado, $id_admin = 1)
    {
        try {
            // 1. Cambia el estado del especialista
            $sqlEsp = "UPDATE especialista 
                       SET estado = :estado,
                           modificado_por = :id_admin,
                           fecha_modificacion = NOW()
                       WHERE id = :id";

            DataBase::execute($sqlEsp, [
                ':estado'   => $nuevo_estado,
                ':id_admin' => $id_admin,
                ':id'       => $id
            ]);

            // 2. Sincroniza en cascada el estado de los servicios a su cargo
            $sqlServ = "UPDATE servicios 
                        SET estado = :estado,
                            modificado_por = :id_admin,
                            fecha_modificacion = NOW()
                        WHERE id_especialista = :id_especialista";

            DataBase::execute($sqlServ, [
                ':estado'          => $nuevo_estado,
                ':id_admin'        => $id_admin,
                ':id_especialista' => $id
            ]);

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
/**
     * Elimina un especialista: si no tiene historial lo borra físicamente;
     * si tiene turnos/servicios vinculados, lo desvincula y marca como eliminado (-1)
     * para preservar la integridad referencial en MySQL.
     */
    public static function eliminarEspecialista($id)
    {
        try {
            // 1. Marcamos como eliminados (-1) los servicios de ese especialista
            \DataBase::query("UPDATE servicios SET estado = -1 WHERE id_especialista = :id", [':id' => $id]);

            // 2. Intentamos el borrado físico directo del especialista
            $sql = "DELETE FROM especialista WHERE id = :id";
            \DataBase::query($sql, [':id' => $id]);

            // Verificamos si sigue existiendo por restricciones de clave foránea (turnos históricos)
            $check = \DataBase::getRecords("SELECT id FROM especialista WHERE id = :id", [':id' => $id]);
            if (is_array($check) && isset($check['resultado'])) {
                $check = $check['resultado'];
            }

            // 3. Si sigue existiendo en BD, lo marcamos con estado = -1 (Eliminado)
            if (!empty($check)) {
                \DataBase::query("UPDATE especialista SET estado = -1, fecha_modificacion = NOW() WHERE id = :id", [
                    ':id' => $id
                ]);
            }

            return true;
        } catch (\Throwable $e) {
            try {
                \DataBase::query("UPDATE servicios SET estado = -1 WHERE id_especialista = :id", [':id' => $id]);
                \DataBase::query("UPDATE especialista SET estado = -1 WHERE id = :id", [':id' => $id]);
                return true;
            } catch (\Throwable $ex) {
                return false;
            }
        }
    }
    /**
     * Actualiza los datos de un especialista existente (nombre, apellido y especialidad)
     */
    public static function actualizarEspecialista($id, $nombre, $apellido, $especialidad, $id_admin = 1)
    {
        try {
            $sql = "UPDATE especialista 
                    SET nombre             = :nombre,
                        apellido           = :apellido,
                        especialidad       = :especialidad,
                        modificado_por     = :id_admin,
                        fecha_modificacion = NOW()
                    WHERE id = :id";

            \DataBase::query($sql, [
                ':nombre'       => $nombre,
                ':apellido'     => $apellido,
                ':especialidad' => $especialidad,
                ':id_admin'     => $id_admin,
                ':id'           => $id
            ]);
            return true;
        } catch (\Throwable $e) {
            // Respaldo si la tabla no tiene columnas de auditoría
            try {
                \DataBase::query("UPDATE especialista SET nombre = :nombre, apellido = :apellido, especialidad = :especialidad WHERE id = :id", [
                    ':nombre'       => $nombre,
                    ':apellido'     => $apellido,
                    ':especialidad' => $especialidad,
                    ':id'           => $id
                ]);
                return true;
            } catch (\Throwable $ex) {
                return false;
            }
        }
    }
}