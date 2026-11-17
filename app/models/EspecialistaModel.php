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
            $sql = "SELECT * FROM especialista ORDER BY id ASC";
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
     * Elimina físicamente un especialista de la base de datos
     */
    public static function eliminarEspecialista($id)
    {
        try {
            $sql = "DELETE FROM especialista WHERE id = :id";
            return DataBase::execute($sql, [':id' => $id]);
        } catch (\Throwable $e) {
            return false;
        }
    }
}