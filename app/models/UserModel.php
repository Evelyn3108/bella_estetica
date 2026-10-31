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
		$model = new static();
		$sql = "SELECT * FROM usuario";
		$result = DataBase::query($sql);

		return $result;
	}

	public static function findEmail($email)
	{
		$model = new static();
		$sql = "SELECT * FROM {$model->table} WHERE {$model->secundaryKey} = :email";
		$params = ["email" => $email];
		$result = DataBase::getRecord($sql, $params);
		return $result;
	}

	public static function getUserByEmail($email)
	{
		$model = new static();
		$sql = "SELECT * FROM " . $model->table . " WHERE email = '$email'";
		$result = DataBase::query($sql);

		return $result;
	}
	
	public static function registrarCliente($nombre, $apellido, $email, $password, $telefono = '')
	{
    $model = new static();
    
    // Hasheamos la contraseña de forma segura
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Sentencia SQL preparada para insertar el nuevo cliente
    $sql = "INSERT INTO {$model->table} (nombre, apellido, email, password, telefono, rol) 
            VALUES (:nombre, :apellido, :email, :password, :telefono, 'cliente')";

    $params = [
        "nombre"   => $nombre,
        "apellido" => $apellido,
        "email"    => $email,
        "password" => $passwordHash,
        "telefono" => $telefono
    ];

    // Ejecutamos la consulta a través de la clase DataBase
    $result = DataBase::query($sql, $params);

    // Si la consulta fue exitosa, retornamos true explícito
    return $result ? true : false;
}
/**
     * Actualiza el correo y teléfono del usuario
     */
    public static function actualizarContacto($id, $email, $telefono)
    {
        try {
            $sql = "UPDATE usuario 
                    SET email = :email, telefono = :telefono 
                    WHERE id = :id";
            
            \DataBase::query($sql, [
                ':email'    => $email,
                ':telefono' => $telefono,
                ':id'       => $id
            ]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Actualiza la contraseña hasheada del usuario
     */
    public static function actualizarPassword($id, $nuevaPassword)
    {
        try {
            $hash = password_hash($nuevaPassword, PASSWORD_BCRYPT);
            $sql = "UPDATE usuario 
                    SET password = :password 
                    WHERE id = :id";

            \DataBase::query($sql, [
                ':password' => $hash,
                ':id'       => $id
            ]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

	/**
     * Actualiza el correo y teléfono del usuario
     */
    public static function actualizarContacto($id, $email, $telefono)
    {
        try {
            $sql = "UPDATE usuario 
                    SET email = :email, telefono = :telefono 
                    WHERE id = :id";
            
            \DataBase::query($sql, [
                ':email'    => $email,
                ':telefono' => $telefono,
                ':id'       => $id
            ]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Actualiza la contraseña hasheada del usuario
     */
    public static function actualizarPassword($id, $nuevaPassword)
    {
        try {
            $hash = password_hash($nuevaPassword, PASSWORD_BCRYPT);
            $sql = "UPDATE usuario 
                    SET password = :password 
                    WHERE id = :id";

            \DataBase::query($sql, [
                ':password' => $hash,
                ':id'       => $id
            ]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

}
