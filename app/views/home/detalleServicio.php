<?= $head ?>
<?= $topbar ?>

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
<?= $footer ?>
