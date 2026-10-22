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
}