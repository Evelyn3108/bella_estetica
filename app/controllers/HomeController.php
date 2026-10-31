<?php

namespace app\controllers;

use \Controller;
use \Response;
use \DataBase;
use app\models\UserModel;
use app\models\ServiciosModel;


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

   public function actionHomeServicios()
    {
        static::path();

        $nombre_de_archivoDeVista = 'homeServicios';
        $parametros_de_vista = [
            "head"   => SiteController::head(),
            "footer" => SiteController::footer(),
            "ruta"   => self::$path
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    // Alias por si el enlace se llama en singular
    public function actionDetalleServicio()
    {
        $this->actionDetalleServicios();
    }

   public function actionDetalleServicios()
    {
        SessionController::onlyUsers();

        static::path();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header("Location: " . self::$path . "home/homeServicios");
            exit;
        }

        // Usamos el método nativo del modelo
        $servicio = ServiciosModel::getServicioById($id);

        if (!$servicio) {
            header("Location: " . self::$path . "home/homeServicios");
            exit;
        }

        $nombre_de_archivoDeVista = 'detalleServicios';
        $parametros_de_vista = [
            "head"      => SiteController::head(),
            "footer"    => SiteController::footer(),
            "ruta"      => self::$path,
            "servicio"  => $servicio
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

}