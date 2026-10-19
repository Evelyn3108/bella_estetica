<?php

namespace app\controllers;

use \Controller;
use \Response;
use \DataBase;
use app\models\UserModel;

class HomeController extends Controller
{

	// Constructor
	public function __construct()
	{
		self::$sessionStatus = SessionController::sessionVerificacion();
	}


	public function actionIndex($var = null)
	{
		SessionController::onlyUsers();		

		$ruta = self::$path;

		static::path();
		$nombre_de_archivoDeVista = 'home';
        $parametros_de_vista = [
            "head" => SiteController::head(),
            "header" => SiteController::header(),
            "topbar" => SiteController::topbar(),
            "menu" => SiteController::menu(),
            "menu_res" => SiteController::menu_res(),
            "footer" => SiteController::footer(),
			"ruta" => $ruta,
        ]; 
        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
	}
}