<?php

namespace app\controllers;

use \Controller;
use \Response;
use \DataBase;
use app\models\UserModel;
use app\models\ServiciosModel;
use app\models\TurnosModel;


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

    public function actionHome_servicios()
    {
        static::path();

        // Trae todos los servicios activos (estado = 1) desde la base de datos
        $servicios = \app\models\ServiciosModel::getServiciosActivos();
        if (is_array($servicios) && isset($servicios['resultado'])) {
            $servicios = $servicios['resultado'];
        }

        $nombre_de_archivoDeVista = 'homeServicios';
        $parametros_de_vista = [
            "head"      => SiteController::head(),
            "footer"    => SiteController::footer(),
            "ruta"      => self::$path,
            "servicios" => is_array($servicios) ? $servicios : []
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

    public function actionHomeServicios()
    {
        static::path();

        // Solo trae tratamientos con estado = 1 y especialista activo = 1
        $servicios = \app\models\ServiciosModel::getServiciosActivos();

        $parametros = [
            "ruta"      => self::$path,
            "servicios" => $servicios
        ];

        Response::render('home/', 'homeServicios', $parametros);
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

        // Obtener ID del usuario logueado
        $id_usuario = $_SESSION['USER']['id_usuario'] 
                   ?? $_SESSION['id_usuario'] 
                   ?? $_SESSION['USER']['id'] 
                   ?? null;

        if (!$id_usuario && !empty($_SESSION['USER']['mail'])) {
            $u = UserModel::findEmail($_SESSION['USER']['mail']);
            if (is_array($u) && isset($u[0])) $u = $u[0];
            $id_usuario = is_object($u) ? ($u->id ?? null) : ($u['id'] ?? null);
        }
        if (!$id_usuario && !empty($_SESSION['USER']['email'])) {
            $u = UserModel::findEmail($_SESSION['USER']['email']);
            if (is_array($u) && isset($u[0])) $u = $u[0];
            $id_usuario = is_object($u) ? ($u->id ?? null) : ($u['id'] ?? null);
        }

        // Turnos activos agendados por este cliente
        $turnosUsuario = [];
        if ($id_usuario) {
            $turnosUsuario = TurnosModel::obtenerTurnosActivos($id_usuario);
        }

        // Turnos ocupados por el especialista asignado a este servicio
        $arrServ = is_object($servicio) ? (array)$servicio : ($servicio ?? []);
        $idEspecialista = $arrServ['id_especialista'] ?? 0;
        $turnosOcupadosEsp = [];
        if ($idEspecialista) {
            $turnosOcupadosEsp = TurnosModel::obtenerTurnosOcupadosEspecialista($idEspecialista);
        }

        $nombre_de_archivoDeVista = 'detalleServicios';
        $parametros_de_vista = [
            "head"              => SiteController::head(),
            "footer"            => SiteController::footer(),
            "ruta"              => self::$path,
            "servicio"          => $servicio,
            "turnosUsuario"     => $turnosUsuario,
            "turnosOcupadosEsp" => $turnosOcupadosEsp
        ];

        Response::render($this->viewDir(__NAMESPACE__), $nombre_de_archivoDeVista, $parametros_de_vista);
    }

}