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
        // 1. Asegurar sesión iniciada
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // 2. Buscamos el usuario en el modelo de forma compatible
        $resultado = null;
        if (method_exists(UserModel::class, 'getUserByEmail')) {
            $resultado = UserModel::getUserByEmail($userEmailOrID);
        } elseif (method_exists(UserModel::class, 'findEmail')) {
            $resultado = UserModel::findEmail($userEmailOrID);
        }

        // Si vino en array indexado [0], tomamos el primer elemento
        $usr = (is_array($resultado) && isset($resultado[0])) ? $resultado[0] : $resultado;

        if (!$usr) {
            return false;
        }

        // 3. Extraemos los campos contemplando objeto o array asociativo
        $id       = is_object($usr) ? ($usr->id ?? $usr->id_user ?? $usr->id_usuario ?? 1) : ($usr['id'] ?? $usr['id_user'] ?? $usr['id_usuario'] ?? 1);
        $nombre   = is_object($usr) ? ($usr->nombre ?? '') : ($usr['nombre'] ?? '');
        $apellido = is_object($usr) ? ($usr->apellido ?? '') : ($usr['apellido'] ?? '');
        $email    = is_object($usr) ? ($usr->email ?? '') : ($usr['email'] ?? '');
        $rol      = is_object($usr) ? ($usr->rol ?? 'cliente') : ($usr['rol'] ?? 'cliente');

        // Si por alguna razón el email vino vacío en la consulta, usamos el parámetro recibido
        if (empty($email) && filter_var($userEmailOrID, FILTER_VALIDATE_EMAIL)) {
            $email = $userEmailOrID;
        }

        // 4. Guardamos los datos indispensables en la sesión
        $_SESSION['SESSION']['STATUS'] = true;
        $_SESSION['USER']['name']       = !empty($nombre) ? $nombre : 'Administrador';
        $_SESSION['USER']['lastName']   = $apellido;
        $_SESSION['USER']['mail']       = $email;
        $_SESSION['USER']['email']      = $email;
        $_SESSION['USER']['id_usuario'] = (int) $id;
        $_SESSION['USER']['type']       = strtolower(trim($rol));
        $_SESSION['USER']['rol']        = strtolower(trim($rol));

        return true;
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
/**
     * Middleware de seguridad para el Administrador
     */
    public static function onlyAdmins()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // 1. Si no inició sesión, lo mandamos al formulario de login de administrador
        if (!isset($_SESSION['SESSION']['STATUS']) || $_SESSION['SESSION']['STATUS'] !== true) {
            header("Location: /bella_estetica/admin/login");
            exit;
        }

        // 2. Si es un cliente común intentando entrar, lo mandamos al home para no rebotar
        $rol = $_SESSION['USER']['type'] ?? $_SESSION['USER']['rol'] ?? null;
        if (strtolower(trim((string)$rol)) !== 'administrador') {
            header("Location: /bella_estetica/home");
            exit;
        }

        return true;
    }
    
}