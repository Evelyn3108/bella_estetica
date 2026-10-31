<?php
// app/models/ServiciosModel.php

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

    /**
     * Alias para compatibilidad con el controlador
     */
    public static function obtenerPorId($id)
    {
        return self::getServicioById($id);
    }
}