<?php

/**
 * Clase Iniciadora, de arranque (Bootstrapping) App
 * Se encarga de procesar la URL, determinar el controlador, método y parámetros,
 * y luego invocar al método correspondiente.
 */
class App
{
    protected $controller = "app\\controllers\\HomeController";
    protected $method     = "actionIndex";
    protected $params     = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // 1. Determinar el controlador activo
        if (!isset($url[0]) || empty($url[0]) || strtolower($url[0]) === 'index') {
            $controllerActive = "HomeController";
            $controladorPorDefecto = true;
            if (isset($url[0])) {
                unset($url[0]);
            }
        } else {
            $controllerActive = ucfirst(strtolower($url[0])) . "Controller";
            $controladorPorDefecto = false;
        }

        // Ruta física del archivo del controlador
        $checkArchivoControlador = APP_PATH . "controllers/" . $controllerActive . '.php';

        // 2. Verificar existencia en el directorio principal de controladores
        if (file_exists($checkArchivoControlador)) {
            $this->controller = "\\app\\controllers\\" . $controllerActive;
            $this->controller = new $this->controller;

            if (isset($url[1])) {
                $methodName = "action" . ucfirst(strtolower($url[1]));

                if (method_exists($this->controller, $methodName)) {
                    $this->method = $methodName;
                    unset($url[1]);
                } else {
                    $this->method = 'action404';
                    unset($url[1]);
                }
            }

            unset($url[0]);
        } else {
            // 3. Buscar en subdirectorios si correspondiera
            $subDirectorioClase = str_replace('Controller', '', $controllerActive);
            $checkSubArchivo = APP_PATH . "controllers/" . strtolower($subDirectorioClase) . '/' . $controllerActive . '.php';

            if (file_exists($checkSubArchivo)) {
                $this->controller = "\\app\\controllers\\" . strtolower($subDirectorioClase) . "\\" . $controllerActive;
                $this->controller = new $this->controller;

                if (isset($url[1])) {
                    $methodName = "action" . ucfirst(strtolower($url[1]));

                    if (method_exists($this->controller, $methodName)) {
                        $this->method = $methodName;
                        unset($url[1]);
                    } else {
                        $this->method = 'action404';
                        unset($url[1]);
                    }
                }

                unset($url[0]);
            } else {
                // 4. Si no existe el controlador en ninguna carpeta, instancia HomeController
                $this->controller = new \app\controllers\HomeController();

                $methodName = isset($url[0]) ? "action" . ucfirst(strtolower($url[0])) : "actionIndex";

                if (method_exists($this->controller, $methodName)) {
                    $this->method = $methodName;
                    unset($url[0]);
                } else {
                    $this->method = 'action404';
                    unset($url[1]);
                }
            }
        }

        // 5. Parámetros restantes
        $this->params = $url ? array_values($url) : [];

        // 6. Ejecución del método si existe, o respuesta de error sin bucle
        if (method_exists($this->controller, $this->method)) {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            http_response_code(404);
            echo "<div style='text-align:center; padding:50px; font-family:sans-serif;'>";
            echo "<h2>Error 404</h2>";
            echo "<p>La página o acción solicitada no fue encontrada.</p>";
            echo "<a href='/bella_estetica/home'>Volver al Inicio</a>";
            echo "</div>";
            exit;
        }
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));
        }
        return null;
    }
}