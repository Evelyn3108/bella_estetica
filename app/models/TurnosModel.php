<?php
// app/models/TurnosModel.php

class TurnosModel {

    public static function getTurnosByCliente($id_usuario) {
        $sql = "SELECT 
                    t.id, 
                    t.fecha, 
                    t.hora, 
                    t.estado,
                    s.nombre_servicio, 
                    s.duracion, 
                    s.precio, 
                    s.consultorio,
                    e.nombre AS especialista_nombre, 
                    e.apellido AS especialista_apellido
                FROM turnos t
                INNER JOIN servicios s ON t.id_servicio = s.id
                INNER JOIN especialista e ON t.id_especialista = e.id
                WHERE t.id_usuario = :id_usuario
                ORDER BY t.fecha DESC, t.hora ASC";

        return DataBase::query($sql, [':id_usuario' => $id_usuario]);
    }

    public static function getTodosLosTurnos() {
        $sql = "SELECT 
                    t.id, 
                    t.fecha, 
                    t.hora, 
                    t.estado,
                    u.nombre AS cliente_nombre, 
                    u.apellido AS cliente_apellido, 
                    u.telefono AS cliente_telefono,
                    s.nombre_servicio, 
                    s.duracion, 
                    s.consultorio,
                    e.nombre AS esp_nombre, 
                    e.apellido AS esp_apellido
                FROM turnos t
                INNER JOIN usuario u ON t.id_usuario = u.id
                INNER JOIN servicios s ON t.id_servicio = s.id
                INNER JOIN especialista e ON t.id_especialista = e.id
                ORDER BY t.fecha ASC, t.hora ASC";

        return DataBase::query($sql);
    }

    public static function comprobarDisponibilidad($id_especialista, $fecha, $hora) {
        $sql = "SELECT COUNT(*) AS total FROM turnos 
                WHERE id_especialista = :id_especialista 
                  AND fecha = :fecha 
                  AND hora = :hora 
                  AND estado != 'cancelado'";

        $res = DataBase::getRecord($sql, [
            ':id_especialista' => $id_especialista,
            ':fecha'           => $fecha,
            ':hora'            => $hora
        ]);

        return ($res && (int)$res->total === 0);
    }

    public static function insertarTurno($id_usuario, $id_servicio, $id_especialista, $fecha, $hora) {
        $sql = "INSERT INTO turnos (
                    id_usuario, 
                    id_servicio, 
                    id_especialista, 
                    fecha, 
                    hora, 
                    estado, 
                    fecha_alta
                ) VALUES (
                    :id_usuario, 
                    :id_servicio, 
                    :id_especialista, 
                    :fecha, 
                    :hora, 
                    'pendiente', 
                    NOW()
                )";

        return DataBase::execute($sql, [
            ':id_usuario'      => $id_usuario,
            ':id_servicio'     => $id_servicio,
            ':id_especialista' => $id_especialista,
            ':fecha'           => $fecha,
            ':hora'            => $hora
        ]);
    }

    public static function actualizarEstado($id_turno, $nuevo_estado, $id_modificador) {
        $sql = "UPDATE turnos 
                SET estado = :estado, 
                    fecha_modificacion = NOW(), 
                    modificado_por = :modificado_por 
                WHERE id = :id";

        return DataBase::execute($sql, [
            ':estado'         => $nuevo_estado,
            ':modificado_por' => $id_modificador,
            ':id'             => $id_turno
        ]);
    }
}