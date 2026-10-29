<?php 
namespace app\controllers;
use \Controller;
use app\models\UserModel;


class SessionController extends Controller
{
   
    private static function setSession(){
        #SC-01 Al primer ingreso de un usuario al sistema asigna un estado de FALSE a la variable de control STATUS
        if (!isset($_SESSION['SESSION']['STATUS'])) {
            $_SESSION['SESSION']['STATUS'] = false;
        }
    }

    public static function sessionVerificacion(){
        self::setSession();

        #SC-02 Devuelve el estado de session (Logueado o No) del usuario como un string "OnLine" o "OffLine"
        if ($_SESSION['SESSION']['STATUS']) {
            $status = 'Online';
        }else{
            $status = 'OffLine';
        }
        
        return $status;
    }

   public static function setSessionData($userEmailOrID)
    {
        // 1. Buscamos el usuario en el modelo
        if (method_exists(UserModel::class, 'getUserByEmail')) {
            $resultado = UserModel::getUserByEmail($userEmailOrID);
        } else {
            $resultado = UserModel::findEmail($userEmailOrID);
        }

        // Si vino en array indexado [0], tomamos el primer elemento
        $usr = (is_array($resultado) && isset($resultado[0])) ? $resultado[0] : $resultado;

        // 2. Extraemos los campos contemplando objeto o array asociativo
        $id       = is_object($usr) ? ($usr->id ?? $usr->id_user ?? $usr->id_usuario ?? null) : ($usr['id'] ?? $usr['id_user'] ?? $usr['id_usuario'] ?? null);
        $nombre   = is_object($usr) ? ($usr->nombre ?? '') : ($usr['nombre'] ?? '');
        $apellido = is_object($usr) ? ($usr->apellido ?? '') : ($usr['apellido'] ?? '');
        $email    = is_object($usr) ? ($usr->email ?? '') : ($usr['email'] ?? '');
        $rol      = is_object($usr) ? ($usr->rol ?? 'cliente') : ($usr['rol'] ?? 'cliente');

        // 3. Verificamos que al menos existan nombre, email e ID
        if (!empty($nombre) && !empty($email) && !empty($id)) {
            $_SESSION['SESSION']['STATUS'] = true;
            $_SESSION['USER']['name']       = $nombre;
            $_SESSION['USER']['lastName']   = $apellido;
            $_SESSION['USER']['mail']       = $email;
            $_SESSION['USER']['id_usuario'] = $id;
            $_SESSION['USER']['type']       = $rol;

            return true;
        }

        return false;
    }

    public static function onlyUsers(){
        static::path();
        $continuar = false;

        if(!isset(self::$sessionStatus)){
            echo 'Error en verificacion de sesiones';
        }  
    }

    public static function onlyLogin(){
        static::path();
        $continuar = false;

        if(!isset(self::$sessionStatus)){
            echo 'Error en verificacion de sesiones';
        }else{
            $ruta = self::$path.'account/login/';
            if (self::$sessionStatus === 'OffLine') {
                header("Location: $ruta");
            }elseif(self::$sessionStatus === 'Online'){
                $continuar = true;
            }
            return $continuar;
        }   
    }
}