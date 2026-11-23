<?php

namespace app\models;

use \Model;
use \DataBase;

class TurnosModel extends Model
{
    /**
     * Comprueba disponibilidad horaria de un especialista
     */
    public static function comprobarDisponibilidad($id_especialista, $fecha, $hora)
    {
        try {
            $sql = "SELECT id FROM turnos 
                    WHERE id_especialista = :id_especialista 
                      AND fecha = :fecha 
                      AND hora = :hora 
                      AND estado IN ('pendiente', 'confirmado') 
                    LIMIT 1";

            $params = [
                ':id_especialista' => $id_especialista,
                ':fecha'           => $fecha,
                ':hora'            => $hora
            ];

            $res = DataBase::getRecord($sql, $params);
            return empty($res);
        } catch (\Throwable $e) {
            return true;
        }
    }
    /**
     * Inserta el turno en la tabla turnos
     */
    public static function insertarTurno($id_usuario, $id_servicio, $id_especialista, $fecha, $hora)
    {
        try {
            $pdo = \DataBase::connection();

            // 1. Candado extra: evitar insertar exactamente lo mismo si ya existe en la BD
            $check = $pdo->prepare("SELECT id FROM turnos 
                                    WHERE id_usuario = :id_usuario 
                                      AND id_servicio = :id_servicio 
                                      AND fecha = :fecha 
                                      AND hora = :hora 
                                      AND estado = 'confirmado' 
                                    LIMIT 1");
            $check->execute([
                ':id_usuario'  => $id_usuario,
                ':id_servicio' => $id_servicio,
                ':fecha'       => $fecha,
                ':hora'        => $hora
            ]);

            if ($check->fetch()) {
                return true; // Ya se guardó, evitamos duplicarlo
            }

            // 2. Inserción única y directa
            $sql = "INSERT INTO turnos (id_usuario, id_servicio, id_especialista, fecha, hora, estado, fecha_alta) 
                    VALUES (:id_usuario, :id_servicio, :id_especialista, :fecha, :hora, 'confirmado', NOW())";

            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':id_usuario'      => $id_usuario,
                ':id_servicio'     => $id_servicio,
                ':id_especialista' => $id_especialista,
                ':fecha'           => $fecha,
                ':hora'            => $hora
            ]);
        } catch (\Throwable $e) {
            return false;
        }
    }
    /**
     * Trae los turnos activos (pendientes o confirmados, cuya fecha y hora aún no hayan vencido)
     */
    public static function obtenerTurnosActivos($id_usuario)
    {
        try {
            // Actualizamos previamente turnos que hayan expirado
            self::actualizarTurnosVencidos();

            // Traemos únicamente los turnos activos vigentes
            $sql = "SELECT t.id, t.fecha, t.hora, t.estado, t.id_especialista,
                           COALESCE(s.nombre_servicio, 'Servicio General') AS nombre_servicio, 
                           COALESCE(s.consultorio, 'Consultorio 1') AS consultorio, 
                           COALESCE(s.duracion, 45) AS duracion, 
                           COALESCE(s.precio, 0) AS precio,
                           COALESCE(e.nombre, '') AS esp_nombre, 
                           COALESCE(e.apellido, '') AS esp_apellido
                    FROM turnos t
                    LEFT JOIN servicios s ON t.id_servicio = s.id
                    LEFT JOIN especialista e ON t.id_especialista = e.id
                    WHERE t.id_usuario = :id_usuario 
                      AND (LOWER(TRIM(COALESCE(t.estado, ''))) IN ('pendiente', 'confirmado') OR t.estado IS NULL)
                      AND TIMESTAMP(t.fecha, t.hora) >= NOW()
                    ORDER BY t.fecha ASC, t.hora ASC";

            $res = \DataBase::getRecords($sql, [':id_usuario' => $id_usuario]);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }

            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Obtiene el historial de turnos (asistidos, cancelados o ya vencidos)
     */
    public static function obtenerHistorialTurnos($id_usuario)
    {
        try {
            $sql = "SELECT t.id, t.fecha, t.hora, 
                           CASE 
                               WHEN (LOWER(TRIM(COALESCE(t.estado, ''))) IN ('pendiente', 'confirmado') OR t.estado IS NULL) 
                                    AND TIMESTAMP(t.fecha, t.hora) < NOW()
                               THEN 'asistido' 
                               ELSE t.estado 
                           END AS estado,
                           COALESCE(s.nombre_servicio, 'Servicio General') AS nombre_servicio, 
                           COALESCE(s.consultorio, 'Consultorio 1') AS consultorio,
                           COALESCE(e.nombre, '') AS esp_nombre, 
                           COALESCE(e.apellido, '') AS esp_apellido
                    FROM turnos t
                    LEFT JOIN servicios s ON t.id_servicio = s.id
                    LEFT JOIN especialista e ON t.id_especialista = e.id
                    WHERE t.id_usuario = :id_usuario 
                      AND (
                          LOWER(TRIM(COALESCE(t.estado, ''))) IN ('asistido', 'cancelado', 'ausente')
                          OR TIMESTAMP(t.fecha, t.hora) < NOW()
                      )
                    ORDER BY t.fecha DESC, t.hora DESC";

            $res = \DataBase::getRecords($sql, [':id_usuario' => $id_usuario]);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }

            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Cancela un turno perteneciente al usuario logueado
     */
    public static function cancelarTurno($id_turno, $id_usuario)
    {
        try {
            $sql = "UPDATE turnos 
                    SET estado = 'cancelado' 
                    WHERE id = :id_turno AND id_usuario = :id_usuario";

            return \DataBase::execute($sql, [
                ':id_turno'   => $id_turno,
                ':id_usuario' => $id_usuario
            ]);
        } catch (\Throwable $e) {
            return false;
        }
    }

   /*** Verifica si el usuario ya tiene un turno registrado en esa misma fecha y hora*/
    public static function tieneTurnoMismoHorario($id_usuario, $fecha, $hora)
    {
        try {
            // Normalizamos la hora a los primeros 5 caracteres (HH:MM)
            $horaLimpia = substr(trim($hora), 0, 5);

            $sql = "SELECT id FROM turnos 
                    WHERE id_usuario = :id_usuario 
                      AND fecha = :fecha 
                      AND (TIME_FORMAT(hora, '%H:%i') = :hora OR hora LIKE :hora_like)
                      AND (LOWER(estado) IN ('pendiente', 'confirmado') OR estado IS NULL)
                    LIMIT 1";

            $params = [
                ':id_usuario' => $id_usuario,
                ':fecha'      => $fecha,
                ':hora'       => $horaLimpia,
                ':hora_like'  => $horaLimpia . '%'
            ];

            $res = \DataBase::getRecord($sql, $params);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }

            return !empty($res);
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Verifica si el usuario ya tiene un turno con este especialista en la fecha especificada
     */
    public static function tieneTurnoConEspecialistaEnFecha($id_usuario, $id_especialista, $fecha)
    {
        try {
            $sql = "SELECT id FROM turnos 
                    WHERE id_usuario = :id_usuario 
                      AND id_especialista = :id_especialista 
                      AND fecha = :fecha 
                      AND (LOWER(estado) IN ('pendiente', 'confirmado') OR estado IS NULL)
                    LIMIT 1";

            $params = [
                ':id_usuario'      => $id_usuario,
                ':id_especialista' => $id_especialista,
                ':fecha'           => $fecha
            ];

            $res = \DataBase::getRecord($sql, $params);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }

            return !empty($res);
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Asegura que la columna estado en la tabla turnos permita valores como 'ausente'
     */
    public static function asegurarColumnaEstadoTurno()
    {
        try {
            $pdo = \DataBase::connection();
            $col = $pdo->query("SHOW COLUMNS FROM turnos LIKE 'estado'")->fetch();
            if ($col && isset($col['Type']) && stripos($col['Type'], 'enum') !== false) {
                if (stripos($col['Type'], 'ausente') === false) {
                    $pdo->exec("ALTER TABLE turnos MODIFY COLUMN estado VARCHAR(50) NOT NULL DEFAULT 'confirmado'");
                }
            }
        } catch (\Throwable $e) {
            // Silencioso
        }
    }

    public static function actualizarEstadoTurno($id_turno, $nuevo_estado, $id_admin)
    {
        self::asegurarColumnaEstadoTurno();
        try {
            $sql = "UPDATE turnos 
                    SET estado = :estado, 
                        modificado_por = :id_admin,
                        fecha_modificacion = NOW()
                    WHERE id = :id";

            \DataBase::query($sql, [
                ':estado'   => $nuevo_estado,
                ':id_admin' => $id_admin,
                ':id'       => $id_turno
            ]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
    /**
     * Marca automáticamente como 'asistido' (o 'finalizado') los turnos confirmados cuya fecha y hora ya pasaron
     */
    public static function actualizarTurnosVencidos()
    {
        try {
            $sql = "UPDATE turnos 
                    SET estado = 'asistido' 
                    WHERE LOWER(TRIM(COALESCE(estado, ''))) IN ('confirmado', 'pendiente') 
                      AND TIMESTAMP(fecha, hora) < NOW()";
            \DataBase::query($sql);
        } catch (\Throwable $e) {
            // Ignorar silenciosamente si falla
        }
    }

    /**
     * Obtiene los turnos reservados que tiene un especialista para fechas futuras
     */
    public static function obtenerTurnosOcupadosEspecialista($id_especialista)
    {
        try {
            $sql = "SELECT fecha, TIME_FORMAT(hora, '%H:%i') AS hora 
                    FROM turnos 
                    WHERE id_especialista = :id_especialista 
                      AND fecha >= CURDATE() 
                      AND (LOWER(estado) IN ('pendiente', 'confirmado') OR estado IS NULL)";

            $res = \DataBase::getRecords($sql, [':id_especialista' => $id_especialista]);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }

            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            return [];
        }
    }

    // * Obtiene la agenda para el Admin filtrando opcionalmente por fecha y/o especialista//
    public static function obtenerAgendaAdmin($fecha = null, $idEspecialista = null)
    {
        try {
            // Actualizamos primero cualquier turno ya vencido
            self::actualizarTurnosVencidos();

            $sql = "SELECT t.id, 
                           t.fecha, 
                           t.hora, 
                           t.estado,
                           COALESCE(u.nombre, 'Cliente') AS cliente_nombre, 
                           COALESCE(u.apellido, '') AS cliente_apellido, 
                           COALESCE(u.telefono, '-') AS cliente_telefono,
                           COALESCE(u.email, '-') AS cliente_email,
                           COALESCE(s.nombre_servicio, 'Tratamiento') AS nombre_servicio, 
                           COALESCE(s.consultorio, 'Consultorio 1') AS consultorio,
                           COALESCE(e.nombre, '') AS esp_nombre, 
                           COALESCE(e.apellido, '') AS esp_apellido
                    FROM turnos t
                    LEFT JOIN usuario u ON t.id_usuario = u.id
                    LEFT JOIN servicios s ON t.id_servicio = s.id
                    LEFT JOIN especialista e ON t.id_especialista = e.id";

            $condiciones = [];
            $params      = [];

            if (!empty($fecha)) {
                $condiciones[]    = "DATE(t.fecha) = :fecha";
                $params[':fecha'] = $fecha;
            }

            if (!empty($idEspecialista)) {
                $condiciones[]      = "t.id_especialista = :id_esp";
                $params[':id_esp']  = (int)$idEspecialista;
            }

            if (!empty($condiciones)) {
                $sql .= " WHERE " . implode(" AND ", $condiciones);
            }

            $sql .= " ORDER BY t.fecha DESC, t.hora ASC";

            $res = \DataBase::getRecords($sql, $params);

            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }

            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            return [];
        }
    }


    /**
     * Obtiene los turnos futuros confirmados de un especialista junto con el email del cliente
     */
    public static function obtenerTurnosAfectadosPorEspecialista($id_especialista)
    {
        try {
            $sql = "SELECT t.id, t.fecha, t.hora,
                           u.nombre AS cliente_nombre, u.apellido AS cliente_apellido, u.email AS cliente_email,
                           COALESCE(s.nombre_servicio, 'Tratamiento Estético') AS nombre_servicio,
                           CONCAT(COALESCE(e.nombre, ''), ' ', COALESCE(e.apellido, '')) AS especialista_nombre
                    FROM turnos t
                    INNER JOIN usuario u ON t.id_usuario = u.id
                    LEFT JOIN servicios s ON t.id_servicio = s.id
                    LEFT JOIN especialista e ON t.id_especialista = e.id
                    WHERE t.id_especialista = :id_especialista
                      AND t.estado IN ('confirmado', 'pendiente')
                      AND t.fecha >= CURDATE()";

            $res = \DataBase::getRecords($sql, [':id_especialista' => $id_especialista]);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }
            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Cancela los turnos futuros de un especialista dado de baja
     */
    public static function cancelarTurnosPorBajaEspecialista($id_especialista, $id_admin = 1)
    {
        try {
            $pdo = \DataBase::connection();
            $sql = "UPDATE turnos 
                    SET estado = 'cancelado',
                        modificado_por = :id_admin,
                        fecha_modificacion = NOW()
                    WHERE id_especialista = :id_especialista
                      AND estado IN ('confirmado', 'pendiente')
                      AND fecha >= CURDATE()";

            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':id_admin'        => $id_admin,
                ':id_especialista' => $id_especialista
            ]);
        } catch (\Throwable $e) {
            // Respaldo por si la tabla turnos no tiene columnas de auditoría
            try {
                $pdo = \DataBase::connection();
                $stmt = $pdo->prepare("UPDATE turnos SET estado = 'cancelado' WHERE id_especialista = :id_especialista AND estado IN ('confirmado', 'pendiente') AND fecha >= CURDATE()");
                return $stmt->execute([':id_especialista' => $id_especialista]);
            } catch (\Throwable $ex) {
                return false;
            }
        }
    }

}