<?= $head ?>
<?= $topbar ?>

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
                    <h<?= $footer ?>
