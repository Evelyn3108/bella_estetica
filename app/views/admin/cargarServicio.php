<?= $head ?>
<?= $topbar ?>

    <!-- FORMULARIO DE CARGA -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card card-custom p-4 p-md-5">

                    <div class="mb-4 text-center">
                        <span class="section-badge text-uppercase mb-2">Gestión del Catálogo</span>
                        <h2 class="fw-bold mt-1">Cargar Nuevo Servicio y Agenda</h2>
                        <p class="text-muted small">Definí los detalles del tratamiento, el especialista asignado y sus bandas horarias de atención.</p>
                    </div>

                    <!-- El formulario enviará los datos hacia el controlador que inserte en SERVICIOS -->
                    <form action="" method="POST">

                        <!-- BLOQUE 1: DATOS DEL TRATAMIENTO -->
                        <h5 class="fw-bold mb-3 pb-2 border-bottom text-secondary">
                            <i class="bi bi-tag me-1" style="color: var(--rosa-principal);"></i> 1. Datos Generales del Servicio
                        </h5>
                        <div class="row g-3 mb-4">

                           <!-- Nombre del Servicio con Menú Desplegable -->
                            <div class="col-md-8">
                                <label for="nombre_servicio" class="form-label small fw-bold">Nombre del Servicio *</label>
                                <select id="nombre_servicio" name="nombre_servicio" class="form-select" required>
                                    <option value="" selected disabled>-- Elegir un tratamiento disponible --</option>
                                    <option value="Manicura Completa">Manicura Completa</option>
                                    <option value="Manicura Rusa con Esmaltado">Manicura Rusa con Esmaltado</option>
                                    <option value="Lifting de Pestañas">Lifting de Pestañas</option>
                                    <option value="Perfilado y Laminado de Cejas">Perfilado y Laminado de Cejas</option>
                                    <option value="Limpieza Facial Profunda">Limpieza Facial Profunda</option>
                                    <option value="Peeling Químico / Punta de Diamante">Peeling Químico / Punta de Diamante</option>
                                    <option value="Masaje Descontracturante">Masaje Descontracturante</option>
                                    <option value="Masaje Relajante con Aromaterapia">Masaje Relajante con Aromaterapia</option>
                                    <option value="Drenaje Linfático Manual">Drenaje Linfático Manual</option>
                                </select>
                                <div class="form-text small">Seleccioná uno de los tratamientos predefinidos del centro.</div>
                            </div>

                            <!-- Especialista Asignado (FK) -->
                            <div class="col-md-4">
                                <label for="id_especialista" class="form-label small fw-bold">Especialista Asignado *</label>
                                <select id="id_especialista" name="id_especialista" class="form-select" required>
                                    <option value="" selected disabled>-- Seleccionar --</option>
                                    <option value="1">Romina Paz (Manicura)</option>
                                    <option value="2">Laura Ríos (Cosmetología)</option>
                                    <option value="3">Sofía Martínez (Masajes)</option>
                                </select>
                            </div>

                            <!-- Precio -->
                            <div class="col-md-4">
                                <label for="precio" class="form-label small fw-bold">Precio ($ ARS) *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">$</span>
                                    <input type="number" step="0.01" id="precio" name="precio" class="form-control" placeholder="2500.00" required>
                                </div>
                            </div>

                            <!-- Duración en minutos -->
                            <div class="col-md-4">
                                <label for="duracion" class="form-label small fw-bold">Duración Estimada (minutos) *</label>
                                <input type="number" id="duracion" name="duracion" class="form-control" placeholder="45" required min="15" step="5">
                            </div>

                            <!-- Consultorio Físico -->
                            <div class="col-md-4">
                                <label for="consultorio" class="form-label small fw-bold">Consultorio / Box *</label>
                                <input type="text" id="consultorio" name="consultorio" class="form-control" placeholder="Ej: Sala 1" required>
                            </div>

                        </div>

                        <!-- BLOQUE 2: DISPONIBILIDAD Y HORARIOS -->
                        <h5 class="fw-bold mb-3 pb-2 border-bottom text-secondary">
                            <i class="bi bi-clock-history me-1" style="color: var(--rosa-principal);"></i> 2. Horarios y Fechas de Atención
                        </h5>
                        <div class="row g-3 mb-4">

                            <!-- Hora Inicio -->
                            <div class="col-md-3 col-sm-6">
                                <label for="hora_inicio" class="form-label small fw-bold">Hora Inicio *</label>
                                <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" required value="09:00">
                            </div>

                            <!-- Hora Fin -->
                            <div class="col-md-3 col-sm-6">
                                <label for="hora_fin" class="form-label small fw-bold">Hora Fin *</label>
                                <input type="time" id="hora_fin" name="hora_fin" class="form-control" required value="18:00">
                            </div>

                            <!-- Fecha Desde -->
                            <div class="col-md-3 col-sm-6">
                                <label for="fecha_desde" class="form-label small fw-bold">Vigencia Desde *</label>
                                <input type="date" id="fecha_desde" name="fecha_desde" class="form-control" required>
                            </div>

                            <!-- Fecha Hasta -->
                            <div class="col-md-3 col-sm-6">
                                <label for="fecha_hasta" class="form-label small fw-bold">Vigencia Hasta *</label>
                                <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control" required>
                            </div>

                        </div>

                        <!-- Botón centrado para guardar -->
                        <div class="text-center mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-brand px-5">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Guardar Servicio
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
<?= $footer ?>
