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

    /**
     * Lista todos los especialistas con sus campos de auditoría para el Administrador
     */
    public static function listarTodos()
    {
        try {
            $sql = "SELECT e.*, 
                           COALESCE(u.nombre, 'Admin') AS creador_nombre
                    FROM especialista e
                    LEFT JOIN usuario u ON e.creado_por = u.id
                    ORDER BY e.id ASC";

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
     * Da de alta un nuevo especialista con auditoría
     */
    public static function crearEspecialista($nombre, $apellido, $especialidad, $id_admin = 1)
    {
        try {
            $sql = "INSERT INTO especialista (nombre, apellido, especialidad, creado_por, estado, fecha_creacion)
                    VALUES (:nombre, :apellido, :especialidad, :creado_por, 1, NOW())";

            return DataBase::query($sql, [
                ':nombre'       => $nombre,
                ':apellido'     => $apellido,
                ':especialidad' => $especialidad,
                ':creado_por'   => $id_admin
            ]);
        } catch (\Throwable $e) {
            return false;
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

            \DataBase::query($sqlEsp, [
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

            \DataBase::query($sqlServ, [
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
     * Elimina físicamente un especialista de la base de datos
     */
    public static function eliminarEspecialista($id)
    {
        try {
            $sql = "DELETE FROM especialista WHERE id = :id";
            return \DataBase::query($sql, [':id' => $id]);
        } catch (\Throwable $e) {
            return false;
        }
    }
}