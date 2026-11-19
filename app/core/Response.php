<?php 
/**
 * Clase para mostrar las vistas
 */
class Response
{
	
	private function __construct()	{}

	public static function render($viewDir,$view, $vars = []){
		if (!headers_sent()) {
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		}
		foreach ($vars as $key => $value) {
			$$key = $value;
		}
		require APP_PATH."views/".$viewDir.$view.".php";
	}

	public static function cargarVista($viewDir,$view, $vars = []){
		if (!headers_sent()) {
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		}
		foreach ($vars as $key => $value) {
			$$key = $value;
		}
		require APP_PATH."views/".$viewDir.$view.".php";
	}
}
