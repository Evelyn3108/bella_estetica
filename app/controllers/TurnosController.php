<?php
// app/controllers/TurnosController.php

class TurnosController extends Controller {

    private $turnosModel;
    private $serviciosModel;

    public function __construct() {
        // Cargar modelos
        $this->turnosModel = $this->model('TurnosModel');
        $this->serviciosModel = $this->model('ServiciosModel');
    }

    // Listado de turnos
    public function index() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ?controller=account&action=login');
            exit;
        }

        if ($_SESSION['rol'] === 'admin') {
            $turnos = $this->turnosModel->obtenerTodos();
            $this->view('admin/agenda_turnos', ['turnos' => $turnos]);
        } else {
            $turnos = $this->turnosModel->obtenerPorUsuario($_SESSION['usuario_id']);
            $this->view('usuario/mis_turnos', ['turnos' => $turnos]);
        }
    }

    // Formulario de reserva
    public function reservar() {
        $servicios = $this->serviciosModel->obtenerServiciosActivos();
        $this->view('turnos/formulario_reserva', ['servicios' => $servicios]);
    }

    // Procesar reserva (POST)
    public function guardar() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_servicio = filter_input(INPUT_POST, 'id_servicio', FILTER_VALIDATE_INT);
            $fecha = $_POST['fecha'];
            $hora  = $_POST['hora'];

            // Obtener datos del servicio para saber qué especialista atiende
            $servicio = $this->serviciosModel->obtenerPorId($id_servicio);

            if (!$servicio) {
                $_SESSION['error'] = "El servicio seleccionado no es válido.";
                header('Location: ?controller=turnos&action=reservar');
                exit;
            }

            $id_especialista = $servicio['id_especialista'];

            // Verificar si el especialista ya tiene turno en esa fecha y hora
            if ($this->turnosModel->existeColision($id_especialista, $fecha, $hora)) {
                $_SESSION['error'] = "El especialista ya tiene un turno reservado para esa fecha y hora.";
                header('Location: ?controller=turnos&action=reservar');
                exit;
            }

            // Registrar turno
            $datos = [
                'id_usuario'      => $_SESSION['usuario_id'],
                'id_servicio'     => $id_servicio,
                'id_especialista' => $id_especialista,
                'fecha'           => $fecha,
                'hora'            => $hora
            ];

            if ($this->turnosModel->registrarTurno($datos)) {
                $_SESSION['exito'] = "¡Turno reservado exitosamente!";
                header('Location: ?controller=turnos&action=index');
            } else {
                $_SESSION['error'] = "Ocurrió un error al agendar el turno.";
                header('Location: ?controller=turnos&action=reservar');
            }
        }
    }
}
<?php
// app/controllers/TurnosController.php

class TurnosController extends Controller {

    private $turnosModel;
    private $serviciosModel;

    public function __construct() {
        $this->turnosModel = $this->model('TurnosModel');
        $this->serviciosModel = $this->model('ServiciosModel');
    }

    // 1. Listado principal según el rol del usuario en sesión
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ?controller=account&action=login');
            exit;
        }

        if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
            $turnos = $this->turnosModel->obtenerTodos();
            $this->view('admin/agenda_turnos', ['turnos' => $turnos]);
        } else {
            $turnos = $this->turnosModel->obtenerPorUsuario($_SESSION['usuario_id']);
            $this->view('usuario/mis_turnos', ['turnos' => $turnos]);
        }
    }

    // 2. Pantalla con el formulario para solicitar turno
    public function reservar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ?controller=account&action=login');
            exit;
        }

        $servicios = $this->serviciosModel->obtenerServiciosActivos();
        $this->view('turnos/reservar', ['servicios' => $servicios]);
    }

    // 3. Procesar el formulario (POST) con validación de choques horarios
    public function guardar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_servicio = filter_input(INPUT_POST, 'id_servicio', FILTER_VALIDATE_INT);
            $fecha = trim($_POST['fecha'] ?? '');
            $hora  = trim($_POST['hora'] ?? '');

            if (!$id_servicio || empty($fecha) || empty($hora)) {
                $_SESSION['error'] = "Por favor, completa todos los campos requeridos.";
                header('Location: ?controller=turnos&action=reservar');
                exit;
            }

            // Obtener el especialista vinculado a este servicio en la BD
            $servicio = $this->serviciosModel->obtenerPorId($id_servicio);
            if (!$servicio) {
                $_SESSION['error'] = "El servicio seleccionado no existe.";
                header('Location: ?controller=turnos&action=reservar');
                exit;
            }

            $id_especialista = $servicio['id_especialista'];

            // Validar que el especialista no esté ocupado en ese horario
            if ($this->turnosModel->existeColision($id_especialista, $fecha, $hora)) {
                $_SESSION['error'] = "El horario seleccionado no está disponible para este especialista.";
                header('Location: ?controller=turnos&action=reservar');
                exit;
            }

            // Guardar el registro en la tabla turnos
            $exito = $this->turnosModel->registrarTurno([
                'id_usuario'      => $_SESSION['usuario_id'],
                'id_servicio'     => $id_servicio,
                'id_especialista' => $id_especialista,
                'fecha'           => $fecha,
                'hora'            => $hora
            ]);

            if ($exito) {
                $_SESSION['mensaje'] = "Turno agendado con éxito.";
                header('Location: ?controller=turnos&action=index');
            } else {
                $_SESSION['error'] = "No se pudo procesar la reserva. Intenta nuevamente.";
                header('Location: ?controller=turnos&action=reservar');
            }
            exit;
        }
    }

    // 4. Cancelar turno
    public function cancelar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id_turno = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $usuario_id = $_SESSION['usuario_id'] ?? 0;

        if ($id_turno) {
            $this->turnosModel->cambiarEstado($id_turno, 'cancelado', $usuario_id);
            $_SESSION['mensaje'] = "El turno ha sido cancelado.";
        }

        header('Location: ?controller=turnos&action=index');
        exit;
    }
}