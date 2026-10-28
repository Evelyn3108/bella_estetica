<?php

namespace app\controllers;

use app\controllers\UserController;
use app\controllers\EquiposController;
use app\models\UserModel;
use \Controller;
use \Response;
use \DataBase;

class AccountController extends Controller
{
    public function __construct()
    {
        self::$sessionStatus = SessionController::sessionVerificacion();
    }

    public function actionLogin()
    {
        if (self::$sessionStatus === "Online") {
            static::path();
            $ruta = self::$path . 'productos';
            header("Location: $ruta");
            exit;
        }

        static::path();

        $error = false;
        $datos = [
            'email' => $_POST['email'] ?? '',
            'pass'  => $_POST['password'] ?? ''
        ];

        $error_msg = [
            'email' => '',
            'pass'  => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Validación Email
            $email = trim($datos['email']);
            $emailValidation = UserController::checkEmpty($email, 'e-mail', 5, 30);

            if ($emailValidation !== true) {
                $error_msg['email'] = $emailValidation;
                $error = true;
            } else {
                $emailValidation = UserController::checkEmail($email);
                if ($emailValidation !== true) {
                    $error_msg['email'] = $emailValidation;
                    $error = true;
                }
            }

            // Validación Contraseña
            $passwordValidation = UserController::checkEmpty($datos['pass'], 'contraseña', 8, 15);
            if ($passwordValidation !== true) {
                $error_msg['pass'] = 'El correo o la contraseña son incorrectos.';
                $error = true;
            }

            // Verificación de credenciales en DB si no hay errores previos
            if (!$error) {
                $checkUsuario = UserController::getUser($email);

                if ($checkUsuario === false) {
                    $error = true;
                    $error_msg['email'] = 'El correo o la contraseña son incorrectos.';
                } elseif (!password_verify($datos['pass'], $checkUsuario->password)) {
                    $error = true;
                    $error_msg['pass'] = 'El correo o la contraseña son incorrectos.';
                } else {
                    $emailValidation = UserController::checkActivo($email);
                    if ($emailValidation !== true) {
                        $error_msg['email'] = $emailValidation;
                        $error = true;
                    }
                }
            }

            // Inicio de Sesión y Redirección
            if (!$error) {
                $_POST['email'] = trim($_POST['email']);
                $logueo = SessionController::setSessionData($_POST['email']);

                if ($logueo === true) {
                    static::path();
                    $ruta = self::$path . 'productos';
                    header("Location: $ruta");
                    exit;
                }
            }
        }

        $nombre_de_archivoDeVista = 'login';
        $parametros_de_vista = [
            "head"      => SiteController::head(),
            "footer"    => SiteController::footer(),
            "ruta"      => self::$path,
            "error"     => $error,
            "error_msg" => $error_msg,
            "datos"     => $datos
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    public function actionRegistro()
    {
        if (self::$sessionStatus === "Online") {
            static::path();
            $ruta = self::$path . 'home';
            header("Location: $ruta");
            exit;
        }

        static::path();

        $error = false;
        $exito = false;

        $datos = [
            'nombre'          => $_POST['nombre'] ?? '',
            'apellido'        => $_POST['apellido'] ?? '',
            'email'           => $_POST['email'] ?? '',
            'telefono'        => $_POST['telefono'] ?? '',
            'password'        => $_POST['password'] ?? '',
            'password_repeat' => $_POST['password_repeat'] ?? ''
        ];

        $error_msg = [
            'nombre'   => '',
            'apellido' => '',
            'email'    => '',
            'telefono' => '',
            'password' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre     = trim($datos['nombre']);
            $apellido   = trim($datos['apellido']);
            $email      = trim($datos['email']);
            $telefono   = trim($datos['telefono']);
            $pass       = $datos['password'];
            $passRepeat = $datos['password_repeat'];

            // 1. Validar campos obligatorios vacíos
            if (empty($nombre) || empty($apellido) || empty($email) || empty($pass) || empty($passRepeat)) {
                $error = true;
                $error_msg['email'] = 'Por favor, completá todos los campos obligatorios.';
            } 
            // 2. Validar que las contraseñas coincidan
            elseif ($pass !== $passRepeat) {
                $error = true;
                $error_msg['email'] = 'Las contraseñas no coinciden.';
            } 
            // 3. Validar complejidad (8-15 chars, mayúscula, número, especial)
            elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,15}$/', $pass)) {
                $error = true;
                $error_msg['email'] = 'La contraseña debe tener entre 8 y 15 caracteres, al menos una mayúscula, un número y un carácter especial.';
            } 
            else {
                // 4. Verificamos existencia por email
                $existeUsuario = UserModel::findEmail($email);

                if ($existeUsuario) {
                    $error = true;
                    $error_msg['email'] = 'El correo electrónico ya se encuentra registrado.';
                } else {
                    // 5. Registramos al nuevo cliente
                    $guardado = UserModel::registrarCliente($nombre, $apellido, $email, $pass, $telefono);
                    if ($guardado) {
                        $exito = '¡Cuenta creada con éxito! Ya podés iniciar sesión.';
                        $datos = [
                            'nombre'          => '', 
                            'apellido'        => '', 
                            'email'           => '', 
                            'telefono'        => '', 
                            'password'        => '', 
                            'password_repeat' => ''
                        ];
                    } else {
                        $error = true;
                        $error_msg['email'] = 'Ocurrió un error al guardar los datos.';
                    }
                }
            }
        }

        $nombre_de_archivoDeVista = 'registro';
        $parametros_de_vista = [
            "head"      => SiteController::head(),
            "footer"    => SiteController::footer(),
            "ruta"      => self::$path,
            "error"     => $error,
            "error_msg" => $error_msg,
            "exito"     => $exito,
            "datos"     => $datos
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    public function actionRecuperarContrasenia()
    {
        if (self::$sessionStatus === "Online") {
            static::path();
            $ruta = self::$path . 'home';
            header("Location: $ruta");
            exit;
        }

        static::path();

        $error = false;
        $exito = false;
        $email = $_POST['email'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($email);

            if (empty($email)) {
                $error = 'Por favor, ingresá tu correo electrónico.';
            } else {
                $existe = UserModel::findEmail($email);
                if (!$existe) {
                    $error = 'El correo electrónico no se encuentra registrado.';
                } else {
                    $exito = 'Te enviamos las instrucciones de recuperación a tu correo electrónico.';
                    $email = '';
                }
            }
        }

        $nombre_de_archivoDeVista = 'recuperarContrasenia';
        $parametros_de_vista = [
            "head"      => SiteController::head(),
            "footer"    => SiteController::footer(),
            "ruta"      => self::$path,
            "error"     => $error,
            "exito"     => $exito,
            "email"     => $email
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    public function actionSalir()
    {
        session_destroy();
        static::path();
        $ruta = self::$path . 'account/login';
        $_SESSION['SESSION']['STATUS'] = false;
        header("Location: $ruta");
        $offline = UserModel::offline($_SESSION["USER"]["mail"]);

        
    }
}