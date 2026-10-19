<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Turno - Estética Bella</title>
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
        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(74, 59, 60, 0.05);
            background: #ffffff;
        }
        .service-icon-banner {
            height: 160px;
            background: linear-gradient(135deg, #fce8e8, #f7d6d7);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--rosa-principal);
            font-size: 3.5rem;
        }
        .badge-chip {
            background-color: var(--rosa-fondo);
            color: var(--rosa-hover);
            border: 1px solid #ebd4d4;
            font-weight: 600;
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 0.85rem;
        }
        .price-highlight {
            color: var(--rosa-principal);
            font-size: 1.8rem;
            font-weight: 800;
        }
        .info-pill {
            background-color: #fbf7f7;
            border-radius: 10px;
            padding: 10px 14px;
        }
        .btn-brand {
            background-color: var(--rosa-principal);
            border-color: var(--rosa-principal);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px 24px;
            transition: all 0.2s ease;
        }
        .btn-brand:hover {
            background-color: var(--rosa-hover);
            border-color: var(--rosa-hover);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(229, 152, 155, 0.4);
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
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navDetalle">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navDetalle">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="home_servicios.php">
                            <i class="bi bi-arrow-left me-1"></i> Catálogo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="perfil_turnos.php">
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

    <!-- CONTENEDOR PRINCIPAL: 2 COLUMNAS PARALELAS -->
    <main class="container my-5">
        <div class="row g-4 align-items-stretch">
            
            <!-- COLUMNA IZQUIERDA: FICHA DEL SERVICIO -->
            <div class="col-lg-6">
                <div class="card card-custom p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="service-icon-banner mb-4 shadow-sm">
                            <i class="bi bi-brush"></i>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="fw-bold mb-0">Manicura Completa</h2>
                            <span class="badge-chip">
                                <i class="bi bi-clock me-1"></i> 45 min
                            </span>
                        </div>

                        <p class="text-muted lh-base mb-4">
                            Cuidado integral de uñas que incluye limado estético, remoción de cutículas, exfoliación suave e hidratación profunda de manos, terminando con un esmaltado semipermanente de alta duración con diseño a elección.
                        </p>
                    </div>

                    <!-- Datos Técnicos: Especialista, Consultorio y Precio -->
                    <div>
                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <div class="info-pill d-flex align-items-center gap-2">
                                    <i class="bi bi-person-badge fs-4" style="color: var(--rosa-principal);"></i>
                                    <div>
                                        <span class="text-muted small d-block">Especialista</span>
                                        <strong class="small">Romina Paz</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-pill d-flex align-items-center gap-2">
                                    <i class="bi bi-geo-alt fs-4" style="color: var(--rosa-principal);"></i>
                                    <div>
                                        <span class="text-muted small d-block">Consultorio</span>
                                        <strong class="small">Sala 1</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center border-top pt-3">
                            <span class="text-muted fw-bold">Inversión final:</span>
                            <span class="price-highlight">$2.500</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA: ELECCIÓN DE DÍA Y HORARIO -->
            <div class="col-lg-6">
                <div class="card card-custom p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="mb-4">
                            <span class="badge-chip text-uppercase mb-2 d-inline-block">Reserva Directa</span>
                            <h3 class="fw-bold mb-1">Agendá tu Turno</h3>
                            <p class="text-muted small mb-0">Completá la fecha y el horario en que deseas atenderte.</p>
                        </div>

                        <form action="" method="POST">
                            
                            <!-- 1. Campo Fecha -->
                            <div class="mb-4">
                                <label for="fecha" class="form-label small fw-bold">
                                    <i class="bi bi-calendar3 me-1" style="color: var(--rosa-principal);"></i> 1. Seleccioná el Día
                                </label>
                                <input type="date" id="fecha" name="fecha" class="form-control form-control-lg fs-6" required>
                                <div class="form-text small">Días de atención: Lunes a Sábados.</div>
                            </div>

                            <!-- 2. Campo Horario -->
                            <div class="mb-4">
                                <label for="hora" class="form-label small fw-bold">
                                    <i class="bi bi-clock me-1" style="color: var(--rosa-principal);"></i> 2. Horarios Libres Disponibles
                                </label>
                                <select id="hora" name="hora" class="form-select form-select-lg fs-6" required>
                                    <option value="" selected disabled>-- Ver horarios disponibles --</option>
                                    <option value="09:00">09:00 hs</option>
                                    <option value="10:00">10:00 hs</option>
                                    <option value="11:00">11:00 hs</option>
                                    <option value="15:00">15:00 hs</option>
                                    <option value="16:00">16:00 hs</option>
                                    <option value="17:00">17:00 hs</option>
                                </select>
                                <div class="form-text small">Intervalos definidos según la duración del tratamiento.</div>
                            </div>

                            <!-- Botón Confirmar Reserva Centrado -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-brand w-75">
                                    <i class="bi bi-check2-circle me-1"></i> Confirmar Turno
                                </button>
                            </div>

                        </form>
                    </div>

                    <!-- Mensaje de aviso al pie -->
                    <div class="text-center text-muted small mt-4 border-top pt-3">
                        <i class="bi bi-shield-check me-1 text-success"></i> Tu turno quedará reservado al instante en el sistema.
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>