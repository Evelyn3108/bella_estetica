<?php

namespace app\controllers;

use \Controller;
use app\models\UserModel;



class UserController extends Controller
{
	/*  .....................
	Atributos Principales
	.....................
*/
	protected $token;
	protected $email;
	protected $password;
	protected $nombre;
	protected $apellido;
	protected $tipo;
	protected $activo;

	/*  .....................
	FIN - Atributos Principales
	.....................
*/

	/*obtiene todos los datos de un usuarios por id o por email según dato ingresado*/
	public static function getUser($emailOrId)
	{
		if (filter_var($emailOrId, FILTER_VALIDATE_EMAIL)) {
			# obtener datos de usuario por Email
			$userData = UserModel::findEmail($emailOrId);
			// var_dump($userData);
		}
		return $userData;
	}

	#----------------Valicaciones de campos de formularios

	/* Valida si el e-mail asociado a un Usuario se encuentra en estado Activo */
    public static function checkActivo($userEmail)
    {
        $datosUsuario = UserModel::findEmail($userEmail);

        if ($datosUsuario) {
            // 1. Si tu base de datos tiene columna 'fecha_baja':
            if (isset($datosUsuario->fecha_baja) && !empty($datosUsuario->fecha_baja)) {
                return 'El usuario se encuentra dado de baja';
            }

            // 2. Si tu base de datos tiene columna 'estado':
            if (isset($datosUsuario->estado) && $datosUsuario->estado != '1') {
                return 'El usuario no se encuentra activo';
            }

            // 3. Si tu base de datos tiene 'estado_logico':
            if (isset($datosUsuario->estado_logico) && $datosUsuario->estado_logico != '1') {
                return 'El usuario no se encuentra activo';
            }

            // Si el registro existe y no está dado de baja, retorna true
            return true;
        }

        return false;
    }

	/*Validar de campo E-mail, Email valído, comprobar email duplicado y comprobar existencia en db*/
	public static function checkEmail($email, bool $verifyDuplicate = null, bool $verifyExistDB = null)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$result = true; // email valido
			if (isset($verifyDuplicate)) { // Validacion con chequeo de campo duplicado en base de datos
				if ($verifyDuplicate && !isset($verifyExistDB)) {
					if (UserModel::CheckEmail($email)) {
						$result = 'El <b>E-MAIL</b> ya se encuentra en uso!'; // email no valido
					} else {
						$result = true; // email valido
					}
				}
			} elseif ($verifyExistDB && !isset($verifyDuplicate)) { // Validacion con chequeo de existencia de campo en base de datos
				if (UserModel::CheckEmail($email)) {
					$result = true; // existe en la base de datos
				} else {
					$result = 'El <b>E-MAIL</b> no se encuentra registrado!'; // no existe en la base de datos
				}
			}
		} else {
			$result = 'Revise el E-mail ingresado!'; // email no valido
		}

		return $result;
	}

	public static function checkEmailModificar($email, $userId, bool $verifyDuplicate = null, bool $verifyExistDB = null)
	{
	    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	        $result = true; // email válido

	        if (isset($verifyDuplicate)) { // Validación con chequeo de campo duplicado en base de datos
	            if ($verifyDuplicate && !isset($verifyExistDB)) {
	                $existingUser = UserModel::getUserByEmail($email); // Obtener usuario con ese email

	                if ($existingUser && $existingUser[0]->id_usuario != $userId) {
	                    $result = 'El E-MAIL ya se encuentra en uso por otro usuario!'; // email no válido
	                } else {
	                    $result = true; // email válido
	                }
	            }
	        } elseif ($verifyExistDB && !isset($verifyDuplicate)) { // Validación con chequeo de existencia de campo en base de datos
	            if (UserModel::CheckEmail($email)) {
	                $result = true; // existe en la base de datos
	            } else {
	                $result = 'El E-MAIL no se encuentra registrado!'; // no existe en la base de datos
	            }
	        }
	    } else {
	        $result = 'Revise el E-mail ingresado!'; // email no válido
	    }

	    return $result;
	}


	/*Comprobar campo vacio, personalizacion de mensaje de salida, minimo de caracteres y maximo de caracteres opcional*/
	public static function checkEmpty($dato, string $campoName, int $minlength = null, int $maxlength = null)
	{

	    if (empty(trim($dato))) {
	        $result = "Por favor ingrese " . ($campoName); // campo vacío
	    } else {
	        if (isset($minlength) && isset($maxlength)) {
	            if (strlen($dato) >= $minlength && strlen($dato) <= $maxlength) {
	                $result = true; // campo no vacío con restricción de caracteres
	            } else {
	                $result = "Por favor ingrese " . ($campoName) . " entre $minlength y $maxlength caracteres!"; // longitud incorrecta
	            }
	        } elseif (isset($minlength)) {
	            if (strlen($dato) >= $minlength) {
	                $result = true; // campo no vacío con restricción mínima de caracteres
	            } else {
	                $result = "Por favor ingrese una " . ($campoName) . " mayor a $minlength caracteres!"; // longitud incorrecta
	            }
	        } else {
	            $result = true; // campo no vacío sin restricción de caracteres
	        }
	    }

	    return $result;
	}


	/*Comprobar campo vacio, personalizacion de mensaje de salida, minimo de caracteres y maximo de caracteres opcional, si opcional es TRUE puede quedar vacio*/
	public static function checkEmptyOpcional($dato, string $campoName, int $minlength = null, int $maxlength = null)
	{
		if (empty(trim($dato))) {
			$result = true; // campo vacio no obligatorio
		} else {
			if (isset($minlength) && isset($maxlength)) {
				if (strlen(trim($dato)) >= $minlength && strlen(trim($dato)) <= $maxlength) {
					$result = true; // campo no vacio con restriccion de caracteres.
				} else {
					$result = "Por favor ingrese <b>" . ucfirst($campoName) . "</b> entre $minlength y $maxlength caracteres!"; // campo vacio
				}
			} elseif (isset($minlength)) {
				if (strlen(trim($dato)) >= $minlength) {
					$result = true; // campo no vacio con restriccion de caracteres.
				} else {
					$result = "Por favor ingrese una <b>" . ucfirst($campoName) . "</b> mayor a $minlength caracteres!"; // campo vacio
				}
			} else {
				$result = true; // campo no vacio sin restriccion de caracteres
			}
		}
		return $result;
	}

	/*Comprobnar campo numerico,  personalizacion de mensaje de salida, chequeo de número minimo y maximo*/
	public static function checkNumber($number, string $campoName, int $min = null, float $max = null)
	{
		if (is_numeric($number)) {
			if (isset($min) && isset($max)) {
				if ($number >= $min && $number <= $max) {
					$result = true; // es número con rango a comprobar
				} else {
					$result = "Por favor ingrese un número entre $min y $max en: <b>" . strtoupper($campoName) . "!</b>"; // email no valido
				}
			} else {
				$result = true; // es número sin rango a comprobar
			}
		} else {
			$result = "Por favor ingrese un número en: " . $campoName . "!"; // no es un numero
		}
		return $result;
	}

	/*Comprobnar campo numerico,  personalizacion de mensaje de salida, chequeo de número minimo y maximo*/
	public static function checkNumberOpcional($number, string $campoName, int $min = null, float $max = null)
	{
		if (empty(trim($number))) {
			$result = true;  // campo vacio no obligatorio
		} else {
			if (is_numeric($number)) {
				if (isset($min) && isset($max)) {
					if ($number >= $min && $number <= $max) {
						$result = true; // es número con rango a comprobar
					} else {
						$result = "Por favor ingrese un número entre $min y $max en: <b>" . strtoupper($campoName) . "!</b>"; // email no valido
					}
				} else {
					$result = true; // es número sin rango a comprobar
				}
			} else {
				$result = "Por favor ingrese solo números en: <b>" . strtoupper($campoName) . "!</b>"; // no es un numero
			}
		}
		return $result;
	}

	/*Comprobnar campo numerico,  personalizacion de mensaje de salida, chequeo de número minimo y maximo, Chequeo de numero sin puntos ni guiones*/
	public static function checkOnlyNumero($dni, string $campoName, int $min = null, float $max = null)
	{
		if (is_numeric($dni)) {
			if (isset($min) && isset($max)) {
				if ($dni >= $min && $dni <= $max) {
					if (!preg_match('/^[0-9]*$/', $dni)) {
						$result = "Por favor ingrese un número sin puntos, comas, o guiones <b>" . strtoupper($campoName) . "!</b>"; // número no valido
					} else {
						$result = true; // es número con rango a comprobar
					}
				} else {
					$result = "Por favor ingrese un número entre $min y $max en: <b>" . strtoupper($campoName) . "!</b>"; // número no valido
				}
			} else {
				if (!preg_match('/^[0-9]*$/', $dni)) {
					$result = "Por favor ingrese un número sin puntos, comas, o guiones <b>" . strtoupper($campoName) . "!</b>"; // número no valido
				} else {
					$result = true; // es número sin rango a comprobar
				}
			}
		} else {
			$result = "Por favor ingrese solo números en: <b>" . strtoupper($campoName) . "!</b>"; // no es un numero
		}
		return $result;
	}

	public static function checkPasswword($userIdOremail, $passwordInput)
	{
		$userData = self::getUser($userIdOremail);

		$check = password_verify($passwordInput, trim($userData->password_usuario));

		if ($check === true) {
			$result = true;
		} else {
			$result = 'Usuario y/o contraseña Incorrectos';
		}

		return $result;
	}

	public static function getPasswordHash($password = null)
	{
		if (!isset($password)) {
			$password = rand(1000, 9999);
		}

		/*Se genera un HASH de contraseña*/
		$password = password_hash($password, PASSWORD_DEFAULT);
		return $password;
	}

	// En UserController.php
	public static function checkPasswordsMatch($password, $confirmation)
	{
		return $password === $confirmation;
	}


	#Fin----------------Valicaciones de campos de formularios

	/* Agregar usuario 
	EL parametro $alta_tipo puede tomar 2 valores
	- registro "por_sistema"
		- puede ser parcial ($parcial = true), datos minimos
		- completo ($parcial = null o false)
	- registro "de_usuario"
		- puede ser parcial ($parcial = true), datos minimos

	*/


	public static function deleteToken()
	{
		unset($_SESSION['acceso_valido']);
	}


	public function actionPerfilUsuario()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        static::path();

        // Control de autenticación
        if (empty($_SESSION['USER']['id_usuario']) && empty($_SESSION['USER']['mail']) && empty($_SESSION['USER']['email'])) {
            header("Location: " . self::$path . "account/login");
            exit;
        }

        $id_usuario = $_SESSION['USER']['id_usuario'] ?? null;
        $email      = $_SESSION['USER']['mail'] ?? $_SESSION['USER']['email'] ?? null;

        $nombre   = $_SESSION['USER']['name'] ?? $_SESSION['USER']['nombre'] ?? '';
        $apellido = $_SESSION['USER']['lastName'] ?? $_SESSION['USER']['apellido'] ?? '';
        $telefono = $_SESSION['USER']['telefono'] ?? '';

        // Consultamos la base de datos para traer el teléfono y datos actualizados
        if ($email) {
            try {
                $host = 'localhost';
                $db   = 'estetica_bd';
                $user = 'root';
                $pass = '';
                $dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";
                $pdo  = new \PDO($dsn, $user, $pass, [
                    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
                ]);

                $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = :email LIMIT 1");
                $stmt->execute([':email' => $email]);
                $userRow = $stmt->fetch();

                if ($userRow) {
                    $id_usuario = $userRow->id ?? $id_usuario;
                    $nombre     = !empty($userRow->nombre) ? $userRow->nombre : $nombre;
                    $apellido   = !empty($userRow->apellido) ? $userRow->apellido : $apellido;
                    // Asignamos el teléfono directo desde la base de datos
                    $telefono   = !empty($userRow->telefono) ? $userRow->telefono : $telefono;

                    // Actualizamos la sesión activa
                    $_SESSION['USER']['id_usuario'] = $id_usuario;
                    $_SESSION['USER']['name']       = $nombre;
                    $_SESSION['USER']['lastName']   = $apellido;
                    $_SESSION['USER']['telefono']   = $telefono;
                }
            } catch (\Throwable $e) {
                // En caso de falla, continúa con los datos de sesión
            }
        }

        $usuarioFinal = [
            'id'       => $id_usuario ?? 1,
            'nombre'   => !empty($nombre) ? $nombre : 'Usuario',
            'apellido' => $apellido,
            'email'    => $email ?? 'correo@ejemplo.com',
            'telefono' => $telefono
        ];

        // Obtener turnos
        $turnosActivos = [];
        $historial     = [];
        if (class_exists(\app\models\TurnosModel::class)) {
            if (method_exists(\app\models\TurnosModel::class, 'obtenerTurnosActivos')) {
                $turnosActivos = \app\models\TurnosModel::obtenerTurnosActivos($usuarioFinal['id']);
            }
            if (method_exists(\app\models\TurnosModel::class, 'obtenerHistorialTurnos')) {
                $historial = \app\models\TurnosModel::obtenerHistorialTurnos($usuarioFinal['id']);
            }
        }

        $nombre_de_archivoDeVista = 'perfilUsuario';
        $parametros_de_vista = [
            "ruta"          => self::$path,
            "usuario"       => $usuarioFinal,
            "turnosActivos" => $turnosActivos,
            "historial"     => $historial,
            "reservaOk"     => isset($_GET['reserva']) && $_GET['reserva'] === 'ok',
            "passwordOk"    => isset($_GET['pass']) && $_GET['pass'] === 'ok',
            "errorPass"     => isset($_GET['error_pass']) ? 'La contraseña actual no es correcta o las nuevas no coinciden.' : null
        ];

        \Response::render('usuario/', $nombre_de_archivoDeVista, $parametros_de_vista);
    }
	/**
     * Procesa la actualización de datos personales (email y teléfono)
     */
    public function actionActualizarDatos()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        static::path();

        if (empty($_SESSION['USER']['id_usuario']) && empty($_SESSION['USER']['mail'])) {
            header("Location: " . self::$path . "account/login");
            exit;
        }

        $id_usuario = $_SESSION['USER']['id_usuario'] ?? 1;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');

            if (!empty($email)) {
                \app\models\UserModel::actualizarContacto($id_usuario, $email, $telefono);

                // Actualizamos los datos en la sesión activa
                $_SESSION['USER']['mail']     = $email;
                $_SESSION['USER']['email']    = $email;
                $_SESSION['USER']['telefono'] = $telefono;

                header("Location: " . self::$path . "user/perfilUsuario?datos=ok");
                exit;
            }
        }

        header("Location: " . self::$path . "user/perfilUsuario");
        exit;
    }

    /**
     * Procesa el cambio de contraseña con validación de requisitos
     */
    public function actionCambiarContrasenia()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        static::path();

        if (empty($_SESSION['USER']['id_usuario']) && empty($_SESSION['USER']['mail'])) {
            header("Location: " . self::$path . "account/login");
            exit;
        }

        $id_usuario = $_SESSION['USER']['id_usuario'] ?? 1;
        $email      = $_SESSION['USER']['mail'] ?? $_SESSION['USER']['email'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pass_actual = $_POST['pass_actual'] ?? '';
            $pass_nueva  = $_POST['pass_nueva'] ?? '';
            $pass_rep    = $_POST['pass_rep'] ?? '';

            // 1. Obtener contraseña actual de la BD
            $usuarioBD = \app\models\UserModel::findEmail($email);
            if (is_array($usuarioBD) && isset($usuarioBD[0])) {
                $usuarioBD = $usuarioBD[0];
            }
            $hashActual = is_object($usuarioBD) ? ($usuarioBD->password ?? '') : ($usuarioBD['password'] ?? '');

            // 2. Validar que la contraseña actual sea correcta
            if (!password_verify($pass_actual, $hashActual)) {
                header("Location: " . self::$path . "user/perfilUsuario?error_pass=actual");
                exit;
            }

            // 3. Validar que las dos nuevas coincidan
            if ($pass_nueva !== $pass_rep) {
                header("Location: " . self::$path . "user/perfilUsuario?error_pass=coincidencia");
                exit;
            }

            // 4. Validar requisitos de complejidad (8 a 15 caracteres, 1 mayúscula, 1 número, 1 símbolo)
            if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,15}$/', $pass_nueva)) {
                header("Location: " . self::$path . "user/perfilUsuario?error_pass=formato");
                exit;
            }

            // 5. Guardar nueva contraseña
            \app\models\UserModel::actualizarPassword($id_usuario, $pass_nueva);
            header("Location: " . self::$path . "user/perfilUsuario?pass=ok");
            exit;
        }

        header("Location: " . self::$path . "user/perfilUsuario");
        exit;
    }
}