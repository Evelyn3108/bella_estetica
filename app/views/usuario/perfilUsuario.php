<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Estética Bella</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --rosa-principal: #e5989b;
            --rosa-hover: #b5838d;
            --rosa-fondo: #fff5f5;
            --texto-oscuro: #4a3b3c;
        }
        body {
            background-color: var(--rosa-fondo);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--texto-oscuro);
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--texto-oscuro) !important;
        }
        .btn-brand {
            background-color: var(--rosa-principal);
            border-color: var(--rosa-principal);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 20px;
            transition: all 0.2s ease;
        }
        .btn-brand:hover {
            background-color: var(--rosa-hover);
            border-color: var(--rosa-hover);
            color: white;
            transform: translateY(-1px);
        }
        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(74, 59, 60, 0.05);
            background: #ffffff;
        }
        .nav-pills .nav-link {
            color: #7d6b6c;
            font-weight: 600;
            border-radius: 10px;
            padding: 10px 18px;
            margin-right: 8px;
        }
        .nav-pills .nav-link.active {
            background-color: var(--rosa-principal);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(229, 152, 155, 0.35);
        }
        .badge-pendiente {
            background-color: #fff3cd;
            color: #856404;
            font-weight: 600;
            border-radius: 30px;
            padding: 6px 12px;
        }
        .badge-confirmado {
            background-color: #d1e7dd;
            color: #0f5132;
            font-weight: 600;
            border-radius: 30px;
            padding: 6px 12px;
        }
        .date-box {
            background-color: var(--rosa-fondo);
            border: 1px solid #f1dede;
            border-radius: 12px;
            min-width: 80px;
            text-align: center;
            padding: 10px;
        }
        .avatar-circle {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #e5989b, #b5838d);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 26px;
            font-weight: bold;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="home_servicios.php">
                <i class="bi bi-flower1 fs-4 me-2" style="color: var(--rosa-principal);"></i> ESTÉTICA Bella
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navPerfil">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navPerfil">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="home.php">
                            <i class="bi bi-grid me-1"></i> Catálogo de Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" style="color: var(--rosa-principal);" href="#">
                            <i class="bi bi-person-circle me-1"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-danger btn-sm px-3 rounded-pill" href="login.php">
                            <i class="bi bi-box-arrow-right me-1"></i> Salir
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENEDOR PRINCIPAL -->
    <main class="container my-5">
        
        <!-- ENCABEZADO DE PERFIL -->
        <div class="card card-custom p-4 mb-4">
            <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                <div class="avatar-circle shadow-sm">
                    MG
                </div>
                <div class="text-center text-md-start">
                    <h2 class="fw-bold mb-1">¡Hola, María González!</h2>
                    <p class="text-muted mb-0 small">
                        <i class="bi bi-envelope me-1"></i> maria.gonzalez@correo.com &nbsp;|&nbsp; 
                        <i class="bi bi-telephone me-1"></i> +54 341 6123456
                    </p>
                </div>
                <div class="ms-md-auto">
                    <a href="home.php" class="btn btn-brand">
                        <i class="bi bi-plus-circle me-1"></i> Agendar Nuevo Turno
                    </a>
                </div>
            </div>
        </div>

        <!-- PESTAÑAS DE NAVEGACIÓN (TABS) -->
        <ul class="nav nav-pills mb-4" id="perfilTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="turnos-tab" data-bs-toggle="pill" data-bs-target="#turnos" type="button" role="tab">
                    <i class="bi bi-calendar-check me-2"></i> Próximos Turnos
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="historial-tab" data-bs-toggle="pill" data-bs-target="#historial" type="button" role="tab">
                    <i class="bi bi-clock-history me-2"></i> Historial Pasado
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="datos-tab" data-bs-toggle="pill" data-bs-target="#datos" type="button" role="tab">
                    <i class="bi bi-pencil-square me-2"></i> Datos de Contacto
                </button>
            </li>
        </ul>

        <!-- CONTENIDO DE LAS PESTAÑAS -->
        <div class="tab-content" id="perfilTabsContent">

            <!-- 1. PESTAÑA: TURNOS NUEVOS / ACTIVOS -->
            <div class="tab-pane fade show active" id="turnos" role="tabpanel">
                <div class="d-flex flex-column gap-3">

                    <!-- Turno 1 -->
                    <div class="card card-custom p-3 p-md-4">
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="date-box shadow-sm">
                                    <div class="small text-uppercase fw-bold text-muted">OCT</div>
                                    <div class="fs-3 fw-bold" style="color: var(--rosa-principal);">18</div>
                                    <div class="small text-muted">2026</div>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">Manicura Completa</h5>
                                    <div class="text-muted small mb-2">
                                        <span><i class="bi bi-clock me-1"></i> 15:00 hs</span> &bull; 
                                        <span><i class="bi bi-geo-alt me-1"></i> Consultorio Sala 1</span> &bull;
                                        <span><i class="bi bi-person me-1"></i> Esp. Romina Paz</span>
                                    </div>
                                    <span class="badge-pendiente small">
                                        <i class="bi bi-hourglass-split me-1"></i> Pendiente de atención
                                    </span>
                                </div>
                            </div>
                            <div class="text-md-end">
                                <button type="button" class="btn btn-outline-danger btn-sm px-3 rounded-pill" onclick="return confirm('¿Seguro que deseas cancelar tu turno?');">
                                    <i class="bi bi-x-circle me-1"></i> Cancelar Cita
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Turno 2 -->
                    <div class="card card-custom p-3 p-md-4">
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="date-box shadow-sm">
                                    <div class="small text-uppercase fw-bold text-muted">OCT</div>
                                    <div class="fs-3 fw-bold" style="color: var(--rosa-principal);">24</div>
                                    <div class="small text-muted">2026</div>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">Lifting de Pestañas</h5>
                                    <div class="text-muted small mb-2">
                                        <span><i class="bi bi-clock me-1"></i> 11:00 hs</span> &bull; 
                                        <span><i class="bi bi-geo-alt me-1"></i> Consultorio Sala 2</span> &bull;
                                        <span><i class="bi bi-person me-1"></i> Esp. Laura Ríos</span>
                                    </div>
                                    <span class="badge-confirmado small">
                                        <i class="bi bi-check2-circle me-1"></i> Turno Confirmado
                                    </span>
                                </div>
                            </div>
                            <div class="text-md-end">
                                <button type="button" class="btn btn-outline-danger btn-sm px-3 rounded-pill" onclick="return confirm('¿Seguro que deseas cancelar tu turno?');">
                                    <i class="bi bi-x-circle me-1"></i> Cancelar Cita
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 2. PESTAÑA: HISTORIAL ANTERIOR -->
            <div class="tab-pane fade" id="historial" role="tabpanel">
                <div class="card card-custom p-4">
                    <h