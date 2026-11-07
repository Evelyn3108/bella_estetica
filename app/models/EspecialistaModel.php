<?php
// app/models/EspecialistaModel.php

class EspecialistaModel extends Model {

    // Obtener todos los especialistas en estado activo (estado = 1)
    public function obtenerActivos() {
        $sql = "SELECT id, nombre, apellido, especialidad 
                FROM especialista 
                WHERE estado = 1 
                ORDER BY apellido ASC, nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un especialista por su ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM especialista WHERE id = :id AND estado = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    class EspecialistaModel extends Model
{
    /**
     * Lista todos los especialistas con sus campos de auditoría
     */
    public static function listarTodos()
    {
        try {
            $sql = "SELECT e.*, 
                           COALESCE(u.nombre, 'Admin') AS creador_nombre
                    FROM ESPECIALISTA e
                    LEFT JOIN USUARIO u ON e.creado_por = u.id
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
            $sql = "INSERT INTO ESPECIALISTA (nombre, apellido, especialidad, creado_por, estado_logico, fecha_creacion)
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
     * Baja/alta lógica de especialista para cuidar la integridad con turnos y servicios
     */
    public static function alternarBajaLogica($id, $nuevo_estado, $id_admin = 1)
    {
        try {
            $sql = "UPDATE ESPECIALISTA 
                    SET estado_logico = :estado,
                        modificado_por = :id_admin,
                        fecha_modificacion = NOW()
                    WHERE id = :id";

            return DataBase::query($sql, [
                ':estado'   => $nuevo_estado,
                ':id_admin' => $id_admin,
                ':id'       => $id
            ]);
        } catch (\Throwable $e) {
            return false;
        }
    }
}