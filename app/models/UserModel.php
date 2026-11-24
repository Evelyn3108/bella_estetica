<?php

namespace app\models;

use \DataBase;
use \Model;

class UserModel extends Model
{
    protected $table = "usuario";
    protected $primaryKey = "id_usuario";
    protected $secundaryKey = "email";
    public $email;

    public static function getAllUsers()
    {
        $sql = "SELECT * FROM usuario";
        return DataBase::query($sql);
    }

    public static function findEmail($email)
    {
        $sql = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
        $params = [":email" => $email];
        return DataBase::getRecord($sql, $params);
    }

    public static function getUserByEmail($email)
    {
        $sql = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
        $params = [":email" => $email];
        $res = DataBase::getRecords($sql, $params);
        if (is_array($res) && isset($res['resultado'])) {
            return $res['resultado'];
        }
        return is_array($res) ? $res : [];
    }

    /**
     * Registra un nuevo cliente desde la web pública
     */
    public static function registrarCliente($nombre, $apellido, $email, $password, $telefono = '')
    {
        try {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO usuario (nombre, apellido, email, password, telefono, rol, fecha_alta) 
                    VALUES (:nombre, :apellido, :email, :password, :telefono, 'cliente', NOW())";

            $params = [
                ":nombre"   => $nombre,
                ":apellido" => $apellido,
                ":email"    => $email,
                ":password" => $passwordHash,
                ":telefono" => $telefono
            ];

            return DataBase::execute($sql, $params);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function actualizarPassword($id, $nuevaPassword)
    {
        try {
            $hash = password_hash($nuevaPassword, PASSWORD_BCRYPT);
            $sql = "UPDATE usuario 
                    SET password = :password 
                    WHERE id = :id";

            return DataBase::execute($sql, [
                ':password' => $hash,
                ':id'       => $id
            ]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function actualizarContacto($id, $email, $telefono)
    {
        try {
            $sql = "UPDATE usuario 
                    SET email = :email, telefono = :telefono 
                    WHERE id = :id";
            
            return DataBase::execute($sql, [
                ':email'    => $email,
                ':telefono' => $telefono,
                ':id'       => $id
            ]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Permite al administrador crear cualquier tipo de usuario (cliente o administrador)
     */
    public static function crearUsuarioAdmin($nombre, $apellido, $email, $password, $telefono, $rol = 'cliente')
    {
        try {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO usuario (nombre, apellido, email, password, telefono, rol, fecha_alta)
                    VALUES (:nombre, :apellido, :email, :password, :telefono, :rol, NOW())";

            return DataBase::execute($sql, [
                ':nombre'   => $nombre,
                ':apellido' => $apellido,
                ':email'    => $email,
                ':password' => $passwordHash,
                ':telefono' => $telefono,
                ':rol'      => $rol
            ]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function listarUsuariosAdmin()
    {
        try {
            $sql = "SELECT id, nombre, apellido, email, telefono, rol, fecha_alta 
                    FROM usuario 
                    ORDER BY id DESC";

            $res = \DataBase::getRecords($sql);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }
            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            return [];
        }
    }

    public static function getUsuarioById($id)
    {
        try {
            $sql = "SELECT id, nombre, apellido, email, telefono, rol 
                    FROM usuario 
                    WHERE id = :id LIMIT 1";
            return \DataBase::getRecord($sql, [':id' => $id]);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function actualizarUsuarioAdmin($id, $nombre, $apellido, $email, $telefono, $rol, $passwordNueva = null)
    {
        try {
            if (!empty($passwordNueva)) {
                // Si el administrador escribió una nueva clave, la hasheamos y actualizamos
                $hash = password_hash($passwordNueva, PASSWORD_BCRYPT);
                $sql = "UPDATE usuario 
                        SET nombre = :nombre, 
                            apellido = :apellido, 
                            email = :email, 
                            telefono = :telefono, 
                            rol = :rol,
                            password = :password 
                        WHERE id = :id";

                return \DataBase::execute($sql, [
                    ':nombre'   => $nombre,
                    ':apellido' => $apellido,
                    ':email'    => $email,
                    ':telefono' => $telefono,
                    ':rol'      => $rol,
                    ':password' => $hash,
                    ':id'       => $id
                ]);
            } else {

                $sql = "UPDATE usuario 
                        SET nombre = :nombre, 
                            apellido = :apellido, 
                            email = :email, 
                            telefono = :telefono, 
                            rol = :rol 
                        WHERE id = :id";

                return \DataBase::execute($sql, [
                    ':nombre'   => $nombre,
                    ':apellido' => $apellido,
                    ':email'    => $email,
                    ':telefono' => $telefono,
                    ':rol'      => $rol,
                    ':id'       => $id
                ]);
            }
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function eliminarUsuario($id)
    {
        try {
            $sql = "DELETE FROM usuario WHERE id = :id";
            return \DataBase::execute($sql, [':id' => $id]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function listarClientesParaTurno()
    {
        try {
            $sql = "SELECT id, nombre, apellido, email, telefono 
                    FROM usuario 
                    WHERE rol = 'cliente' 
                    ORDER BY apellido ASC, nombre ASC";

            $res = \DataBase::getRecords($sql);
            if (is_array($res) && isset($res['resultado'])) {
                $res = $res['resultado'];
            }
            return is_array($res) ? $res : [];
        } catch (\Throwable $e) {
            return [];
        }
    }
}