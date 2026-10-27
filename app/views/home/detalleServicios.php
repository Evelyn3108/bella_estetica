<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Turno - Bella Estética</title>
    
    <!-- Bootstrap 5 CSS e Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Hoja de estilos unificada en tonos Terracota y Cacao -->
    <link rel="stylesheet" href="../css/estilos.css?v=21">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark d-flex align-items-center" href="../home">
                <i class="bi bi-flower1 me-2" style="color: var(--terracota-principal);"></i> Bella Estética
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navDetalle">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navDetalle">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <li class="nav-item">
                       <a class="nav-link text-secondary" href="homeServicios">
                        <i class="bi bi-grid me-1"></i> Servicios
                       </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="../turnos/misTurnos">
                            <i class="bi bi-calendar-heart me-1"></i> Mis Turnos
                        </a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-secondary btn-sm px-3 rounded-pill" href="../account/salir">
                            <i class="bi bi-box-arrow-right me-1"></i> Salir
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENEDOR PRINCIPAL: 2 Columnas paralelas -->
    <main class="container my-5">
        <div class="row g-4 justify-content-center">
            
            <!-- COLUMNA IZQUIERDA: Detalle del Servicio -->
            <div class="col-lg-6">
                <div class="landing-canvas-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge rounded-pill px-3 py-1" style="background-color: var(--caja-suave); color: var(--terracota-principal); font-size: 0.8rem; font-weight: 600;">
                                Tratamiento Seleccionado
                            </span>
                            <span class="text-muted small">
                                <i class="bi bi-clock me-1"></i> 45 minutos
                            </span>
                        </div>

                        <h2 class="fw-bold mb-3" style="color: var(--texto-oscuro); letter-spacing: -0.02em;">Spa de Manos y Esmaltado</h2>
                        
                        <p class="text-muted small mb-4" style="line-height: 1.6;">
                            Cuidado integral de uñas que incluye limado estético, remoción de cutículas, exfoliación suave con sales aromáticas e hidratación profunda. Finaliza con esmaltado semipermanente de larga duración con color a elección.
                        </p>

                        <!-- Datos del tratamiento -->
                        <div class="p-3 rounded-3 mb-4" style="background-color: var(--caja-suave); border: 1px solid var(--borde-suave);">
                            <div class="row g-2 text-start small">
                                <div class="col-sm-6">
                                    <span class="text-muted d-block">Especialista a cargo:</span>
                                    <strong style="color: var(--texto-oscuro);">Esp. Romina Paz</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block">Consultorio:</span>
                                    <strong style="color: var(--texto-oscuro);">Sala 1 (Planta Baja)</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex justify-content-between align-items-center" style="border-color: var(--borde-suave) !important;">
                        <div>
                            <span class="text-muted small d-block">Inversión</span>
                            <strong class="fs-4" style="color: var(--terracota-principal);">$20.500</strong>
                        </div>
                       <a href="homeServicios" class="link-terracota small text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i> Elegir otro servicio
                        </a>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA: Formulario de Reserva de Turno -->
            <div class="col-lg-6">
                <div class="landing-canvas-card p-4 p-md-5 h-100">
                    
                    <div class="text-start mb-4">
                        <h4 class="fw-bold mb-1" style="color: var(--texto-oscuro);">Reservá tu cita</h4>
                        <p class="text-muted small mb-0">Seleccioná el día y horario que te quede más cómodo</p>
                    </div>

                    <form action="../turnos/reservar" method="POST">
                        <input type="hidden" name="id_servicio" value="1">
                        <input type="hidden" name="id_especialista" value="1">

                        <!-- 1. Selección de Fecha -->
                        <div class="mb-3 text-start">
                            <label for="fecha" class="form-label small fw-bold text-dark mb-1">1. Seleccioná el Día *</label>
                            <div class="input-group login-input-group">
                                <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                <input type="date" 
                                       class="form-control" 
                                       id="fecha" 
                                       name="fecha" 
                                       min="<?= date('Y-m-d'); ?>" 
                                       required>
                            </div>
                        </div>

                        <!-- 2. Selección de Horario -->
                        <div class="mb-4 text-start">
                            <label for="hora" class="form-label small fw-bold text-dark mb-1">2. Horarios Disponibles *</label>
                            <div class="input-group login-input-group">
                                <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                <select class="form-select" id="hora" name="hora" required>
                                    <option value="" selected disabled>-- Elegí una franja horaria --</option>
                                    <option value="09:00">09:00 hs</option>
                                    <option value="10:00">10:00 hs</option>
                                    <option value="11:00">11:00 hs</option>
                                    <option value="14:00">14:00 hs</option>
                                    <option value="15:00">15:00 hs</option>
                                    <option value="16:00">16:00 hs</option>
                                    <option value="17:00">17:00 hs</option>
                                </select>
                            </div>
                        </div>

                        <!-- Alerta recordatorio -->
                        <div class="p-2 mb-4 rounded-3 text-start small" style="background-color: var(--caja-suave); border: 1px solid var(--borde-suave); color: var(--texto-oscuro); font-size: 0.8rem; line-height: 1.4;">
                            <i class="bi bi-info-circle-fill me-1" style="color: var(--terracota-principal);"></i>
                            Podrás cancelar o reprogramar tu turno con anticipación desde tu panel de <strong>Mis Turnos</strong>.
                        </div>

                        <!-- Botón Confirmar Turno -->
                        <button type="submit" class="btn-solid-terracota w-100 py-2 fs-6 shadow-sm">
                            <i class="bi bi-check2-circle me-1"></i> Confirmar Turno
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>