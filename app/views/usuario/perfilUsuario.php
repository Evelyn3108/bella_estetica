<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Bella Estética</title>
    
    <!-- Bootstrap 5 CSS e Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Hoja de estilos centralizada en tonos Terracota y Cacao -->
    <link rel="stylesheet" href="../css/estilos.css?v=28">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark d-flex align-items-center" href="../home/homeServicios">
                <i class="bi bi-flower1 me-2" style="color: var(--terracota-principal);"></i> Bella Estética
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navPerfil">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navPerfil">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="../home/homeServicios">
                            <i class="bi bi-grid me-1"></i> Catálogo de Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" style="color: var(--terracota-principal);" href="perfilUsuario">
                            <i class="bi bi-person-circle me-1"></i> Mi Perfil
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

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container my-5">
        
        <!-- TARJETA CABECERA DEL CLIENTE -->
        <div class="landing-canvas-card p-4 mb-4">
            <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fs-3 fw-bold shadow-sm" 
                     style="width: 70px; height: 70px; background-color: var(--terracota-principal);">
                    EF
                </div>
                <div class="text-center text-md-start">
                    <h2 class="fw-bold mb-1" style="color: var(--texto-oscuro);">¡Hola, Evelyn Franco!</h2>
                    <p class="text-muted mb-0 small">
                        <i class="bi bi-envelope me-1"></i> elyn.fco@gmail.com &nbsp;|&nbsp; 
                        <i class="bi bi-telephone me-1"></i> 3413059231
                    </p>
                </div>
                <div class="ms-md-auto">
                    <a href="../home/homeServicios" class="btn-solid-terracota py-2 px-3 small text-decoration-none shadow-sm rounded-3">
                        <i class="bi bi-plus-circle me-1"></i> Reservar Turno
                    </a>
                </div>
            </div>
        </div>

        <!-- PESTAÑAS: TURNOS / HISTORIAL / DATOS -->
        <ul class="nav nav-pills mb-4 gap-2" id="perfilTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4 fw-semibold" id="turnos-tab" data-bs-toggle="pill" data-bs-target="#turnos" type="button" role="tab" style="color: var(--texto-oscuro);">
                    <i class="bi bi-calendar-check me-2"></i> Mis Turnos
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 fw-semibold text-secondary" id="historial-tab" data-bs-toggle="pill" data-bs-target="#historial" type="button" role="tab">
                    <i class="bi bi-clock-history me-2"></i> Historial
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 fw-semibold text-secondary" id="datos-tab" data-bs-toggle="pill" data-bs-target="#datos" type="button" role="tab">
                    <i class="bi bi-person-gear me-2"></i> Modificar Datos
                </button>
            </li>
        </ul>

        <!-- CONTENIDO DE LAS PESTAÑAS -->
        <div class="tab-content" id="perfilTabsContent">

            <!-- 1. PESTAÑA: TURNOS ACTIVOS -->
            <div class="tab-pane fade show active" id="turnos" role="tabpanel">
                <div class="landing-canvas-card p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: var(--borde-suave) !important;">
                        <h4 class="fw-bold mb-0" style="color: var(--texto-oscuro);">
                            <i class="bi bi-calendar2-heart me-2" style="color: var(--terracota-principal);"></i> Próximas Citas Agendadas
                        </h4>
                        <span class="badge rounded-pill px-3 py-1" style="background-color: #d1e7dd; color: #0f5132; font-weight: 600;">
                            Activos
                        </span>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        <!-- Turno 1 -->
                        <div class="p-3 p-md-4 rounded-4 bg-white border d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 shadow-sm" style="border-color: var(--borde-suave) !important;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-center px-3 py-2 rounded-3 border" style="background-color: var(--caja-suave); border-color: var(--borde-suave) !important; min-width: 75px;">
                                    <span class="small fw-bold text-uppercase d-block text-muted">OCT</span>
                                    <span class="fs-3 fw-bold d-block lh-1 my-1" style="color: var(--terracota-principal);">28</span>
                                    <span class="small text-muted d-block">2026</span>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: var(--texto-oscuro);">Spa de Manos y Esmaltado</h5>
                                    <div class="text-muted small mb-2">
                                        <span><i class="bi bi-clock me-1"></i> 15:00 hs</span> &bull; 
                                        <span><i class="bi bi-geo-alt me-1"></i> Sala 1</span> &bull; 
                                        <span><i class="bi bi-person me-1"></i> Esp. Romina Paz</span>
                                    </div>
                                    <span class="badge rounded-pill px-2 py-1 small" style="background-color: #fff3cd; color: #856404; font-weight: 600;">
                                        <i class="bi bi-hourglass-split me-1"></i> Pendiente de atención
                                    </span>
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-danger btn-sm px-3 rounded-pill fw-semibold" onclick="return confirm('¿Estás seguro de que deseas cancelar este turno?');">
                                    <i class="bi bi-x-circle me-1"></i> Cancelar Cita
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. PESTAÑA: HISTORIAL -->
            <div class="tab-pane fade" id="historial" role="tabpanel">
                <div class="landing-canvas-card p-4 p-md-5">
                    <div class="mb-4 pb-2 border-bottom" style="border-color: var(--borde-suave) !important;">
                        <h4 class="fw-bold mb-1" style="color: var(--texto-oscuro);">
                            <i class="bi bi-clock-history me-2" style="color: var(--terracota-principal);"></i> Historial de Tratamientos
                        </h4>
                        <p class="text-muted small mb-0">Registro de las sesiones realizadas o canceladas con anterioridad.</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-muted small text-uppercase">
                                    <th class="py-3">Tratamiento</th>
                                    <th class="py-3">Fecha</th>
                                    <th class="py-3">Horario</th>
                                    <th class="py-3">Consultorio</th>
                                    <th class="py-3">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-dark py-3">Limpieza Facial Profunda</td>
                                    <td class="text-muted py-3">05/09/2026</td>
                                    <td class="text-muted py-3">16:00 hs</td>
                                    <td class="text-muted py-3">Sala 1</td>
                                    <td class="py-3"><span class="badge bg-secondary rounded-pill px-3 py-1">Asistido</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 3. PESTAÑA: MODIFICAR DATOS DE CONTACTO -->
            <div class="tab-pane fade" id="datos" role="tabpanel">
                <div class="landing-canvas-card p-4 p-md-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <h4 class="fw-bold mb-1" style="color: var(--texto-oscuro);">
                                <i class="bi bi-pencil-square me-2" style="color: var(--terracota-principal);"></i> Modificar Datos de Contacto
                            </h4>
                            <p class="text-muted small mb-4">Mantené tu teléfono y correo actualizados para recibir los recordatorios de tus citas.</p>

                            <form action="" method="POST">
                                <div class="row g-3">
                                    <!-- Nombre (Readonly para preservar identidad) -->
                                    <div class="col-md-6 text-start">
                                        <label class="form-label small fw-bold text-muted">Nombre</label>
                                        <input type="text" class="form-control bg-light" name="nombre" value="Evelyn" readonly>
                                    </div>
                                    <!-- Apellido (Readonly) -->
                                    <div class="col-md-6 text-start">
                                        <label class="form-label small fw-bold text-muted">Apellido</label>
                                        <input type="text" class="form-control bg-light" name="apellido" value="Franco" readonly>
                                    </div>
                                    <!-- Teléfono (Editable) -->
                                    <div class="col-md-6 text-start">
                                        <label for="telefono" class="form-label small fw-bold text-dark">Teléfono / WhatsApp *</label>
                                        <div class="input-group login-input-group">
                                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                            <input type="tel" id="telefono" name="telefono" class="form-control" value="3413059231" required>
                                        </div>
                                    </div>
                                    <!-- Email (Editable) -->
                                    <div class="col-md-6 text-start">
                                        <label for="email" class="form-label small fw-bold text-dark">Correo Electrónico *</label>
                                        <div class="input-group login-input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" id="email" name="email" class="form-control" value="elyn.fco@gmail.com" required>
                                        </div>
                                    </div>
                                    <!-- Botón Guardar -->
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn-solid-terracota px-4 py-2 fs-6 shadow-sm">
                                            <i class="bi bi-check-lg me-1"></i> Guardar Cambios
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>