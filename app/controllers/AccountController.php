<?php

namespace app\controllers;
require_once __DIR__ . '/../librerias/Mailer.php';

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
            $ruta = self::$path . 'home/homeServicios';
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

            // 1. Validación de formato de Email
            $email = trim($datos['email']);
            $emailValidation = UserController::checkEmpty($email, 'e-mail', 5, 50);

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

            // 2. Validación de Contraseña
            $passwordValidation = UserController::checkEmpty($datos['pass'], 'contraseña', 6, 60);
            if ($passwordValidation !== true) {
                $error_msg['pass'] = 'El correo o la contraseña son incorrectos.';
                $error = true;
            }

            // 3. Verificación de credenciales en Base de Datos
            if (!$error) {
                $checkUsuario = UserController::getUser($email);

                // Verificamos si existe el usuario
                if ($checkUsuario === false || empty($checkUsuario)) {
                    $error = true;
                    $error_msg['email'] = 'El correo o la contraseña son incorrectos.';
                } else {
                    // Tomamos el hash de contraseña (sea que la columna se llame password o pass)
                    $hashGuardado = $checkUsuario->password ?? $checkUsuario->pass ?? '';

                    if (!password_verify($datos['pass'], $hashGuardado)) {
                        $error = true;
                        $error_msg['pass'] = 'El correo o la contraseña son incorrectos.';
                    } else {
                        // Verificamos si está activo
                        $activoValidation = UserController::checkActivo($email);
                        if ($activoValidation !== true) {
                            $error_msg['email'] = is_string($activoValidation) ? $activoValidation : 'La cuenta se encuentra inactiva.';
                            $error = true;
                        }
                    }
                }
            }

            // 4. Inicio de Sesión y Redirección al Catálogo
            if (!$error) {
                $_POST['email'] = trim($_POST['email']);
                $logueo = SessionController::setSessionData($_POST['email']);

                if ($logueo === true) {
                    static::path();
                    
                    // Si es administrador puede ir a su panel, si es cliente a su catálogo
                    if (isset($_SESSION['USER']['type']) && $_SESSION['USER']['type'] === 'administrador') {
                        $ruta = self::$path . 'admin/panelServicio';
                    } else {
                        $ruta = self::$path . 'home/homeServicios';
                    }

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

    // 1. PASO 1: Solicitud de correo y envío de código
    public function actionRecuperarContrasenia()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        static::path();

        $error = false;
        $email = $_POST['email'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($email);

            if (empty($email)) {
                $error = 'Por favor, ingresá tu correo electrónico.';
            } else {
                $usuario = UserModel::findEmail($email);
                if (is_array($usuario) && isset($usuario[0])) {
                    $usuario = $usuario[0];
                }

                if (!$usuario) {
                    $error = 'El correo electrónico no se encuentra registrado.';
                } else {
                    // Generamos código aleatorio de 6 dígitos
                    $codigo = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                    $nombre = is_object($usuario) ? ($usuario->nombre ?? 'Cliente') : ($usuario['nombre'] ?? 'Cliente');
                    $idUsr  = is_object($usuario) ? ($usuario->id ?? 0) : ($usuario['id'] ?? 0);

                    // Guardamos datos temporales en sesión
                    $_SESSION['RECUPERO'] = [
                        'id'         => $idUsr,
                        'email'      => $email,
                        'codigo'     => $codigo,
                        'verificado' => false
                    ];

                    // Enviamos el mail por Brevo
                    \app\librerias\Mailer::enviarCodigoRecuperacion($email, $nombre, $codigo);

                    header("Location: " . self::$path . "account/verificarCodigo");
                    exit;
                }
            }
        }

        Response::render($this->viewDir(__NAMESPACE__), 'recuperarContrasenia', [
            "head"   => SiteController::head(),
            "footer" => SiteController::footer(),
            "ruta"   => self::$path,
            "error"  => $error,
            "email"  => $email
        ]);
    }

    // 2. PASO 2: Validación del código de 6 dígitos
    public function actionVerificarCodigo()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        static::path();

        if (empty($_SESSION['RECUPERO']['email'])) {
            header("Location: " . self::$path . "account/recuperarContrasenia");
            exit;
        }

        $error = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigoIngresado = trim($_POST['codigo'] ?? '');

            if (empty($codigoIngresado)) {
                $error = 'Por favor, ingresá el código de 6 dígitos.';
            } elseif ($codigoIngresado !== $_SESSION['RECUPERO']['codigo']) {
                $error = 'El código ingresado es incorrecto. Verificá tu correo.';
            } else {
                $_SESSION['RECUPERO']['verificado'] = true;
                header("Location: " . self::$path . "account/nuevaContrasenia");
                exit;
            }
        }

        Response::render($this->viewDir(__NAMESPACE__), 'verificarCodigo', [
            "head"   => SiteController::head(),
            "footer" => SiteController::footer(),
            "ruta"   => self::$path,
            "error"  => $error,
            "email"  => $_SESSION['RECUPERO']['email']
        ]);
    }

    // 3. PASO 3: Guardar la nueva contraseña
    public function actionNuevaContrasenia()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        static::path();

        if (empty($_SESSION['RECUPERO']['verificado']) || $_SESSION['RECUPERO']['verificado'] !== true) {
            header("Location: " . self::$path . "account/recuperarContrasenia");
            exit;
        }

        $error = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $passNueva = $_POST['password'] ?? '';
            $passRep   = $_POST['password_repeat'] ?? '';

            if ($passNueva !== $passRep) {
                $error = 'Las contraseñas no coinciden.';
            } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,15}$/', $passNueva)) {
                $error = 'La contraseña debe tener entre 8 y 15 caracteres, una mayúscula, un número y un carácter especial.';
            } else {
                $idUsuario = $_SESSION['RECUPERO']['id'];
                UserModel::actualizarPassword($idUsuario, $passNueva);

                // Limpiamos la sesión temporal de recupero
                unset($_SESSION['RECUPERO']);

                header("Location: " . self::$path . "account/login?recupero=ok");
                exit;
            }
        }

        Response::render($this->viewDir(__NAMESPACE__), 'nuevaContrasenia', [
            "head"   => SiteController::head(),
            "footer" => SiteController::footer(),
            "ruta"   => self::$path,
            "error"  => $error
        ]);
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