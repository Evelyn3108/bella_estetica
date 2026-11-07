<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($servicio) ? 'Modificar Servicio' : 'Nuevo Servicio'; ?> - Bella Estética</title>
    <!-- Estilos generales unificados del proyecto -->
    <link rel="stylesheet" href="<?= $ruta; ?>css/estilos.css?v=25">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR ADMINISTRADOR (IDÉNTICO A LA AGENDA DE TURNOS) -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 mb-4 border-bottom" style="border-color: var(--borde-suave) !important;">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="<?= $ruta; ?>admin/panel">
                <i class="bi bi-flower1 fs-3" style="color: var(--terracota-principal) !important;"></i>
                <div class="d-flex flex-column">
                    <span class="brand-title text-dark">BELLA ESTÉTICA</span>
                    <span class="badge rounded-pill text-uppercase" style="background-color: var(--caja-suave); color: var(--terracota-principal); font-size: 0.65rem; width: fit-content; padding: 2px 8px;">
                        Administración
                    </span>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navAdmin">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom fw-semibold" href="<?= $ruta; ?>admin/panel">
                            <i class="bi bi-calendar3 me-1"></i> Agenda de Turnos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active fw-bold border-bottom border-2 pb-1" style="border-color: var(--terracota-principal) !important; color: var(--terracota-principal) !important;" href="<?= $ruta; ?>admin/servicios">
                            <i class="bi bi-card-checklist me-1"></i> Gestión de Servicios
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <span class="small fw-semibold text-muted d-flex align-items-center">
                        <i class="bi bi-person-circle fs-5 me-2" style="color: var(--terracota-principal);"></i>
                        <?= htmlspecialchars($_SESSION['USER']['name'] ?? 'Administrador'); ?>
                    </span>
                    <a href="<?= $ruta; ?>session/logout" class="btn btn-sm px-3 rounded-pill fw-semibold text-decoration-none" 
                       style="background-color: transparent; border: 1px solid var(--borde-suave); color: var(--texto-muted); transition: all 0.2s;"
                       onmouseenter="this.style.backgroundColor='var(--caja-suave)'; this.style.borderColor='var(--terracota-principal)'; this.style.color='var(--terracota-principal)';"
                       onmouseleave="this.style.backgroundColor='transparent'; this.style.borderColor='var(--borde-suave)'; this.style.color='var(--texto-muted)';">
                        <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENEDOR PRINCIPAL DEL FORMULARIO -->
    <main class="container mb-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-9">

                <!-- Botón de regreso -->
                <div class="mb-3 text-start">
                    <a href="<?= $ruta; ?>admin/servicios" class="small text-muted text-decoration-none d-inline-flex align-items-center">
                        <i class="bi bi-arrow-left me-1"></i> Volver a la lista de servicios
                    </a>
                </div>

                <?php 
                    $srv = is_object($servicio) ? (array)$servicio : (is_array($servicio) ? $servicio : []);
                    $idActual      = $srv['id'] ?? '';
                    $nombreActual  = $srv['nombre_servicio'] ?? '';
                    $espActual     = $srv['id_especialista'] ?? 1;
                    $precioActual  = $srv['precio'] ?? '';
                    $duracionAct   = $srv['duracion'] ?? '45';
                    $boxActual     = $srv['consultorio'] ?? 'Consultorio 1';
                    $hInicioActual = !empty($srv['hora_inicio']) ? substr($srv['hora_inicio'], 0, 5) : '09:00';
                    $hFinActual    = !empty($srv['hora_fin']) ? substr($srv['hora_fin'], 0, 5) : '18:00';
                    $fDesdeActual  = !empty($srv['fecha_desde']) ? $srv['fecha_desde'] : date('Y-m-d');
                    $fHastaActual  = !empty($srv['fecha_hasta']) ? $srv['fecha_hasta'] : date('Y-m-d', strtotime('+1 year'));
                ?>

                <!-- Tarjeta del Formulario (Lienzo Terracota) -->
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white" style="border: 1px solid var(--borde-suave) !important;">
                    
                    <div class="text-center mb-4 pb-2 border-bottom" style="border-color: var(--borde-suave) !important;">
                        <span class="badge rounded-pill text-uppercase mb-2 px-3 py-2 fw-semibold" style="background-color: var(--caja-suave); color: var(--terracota-principal); font-size: 0.72rem; letter-spacing: 0.05em;">
                            MÓDULO DE CATÁLOGO
                        </span>
                        <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">
                            <?= !empty($idActual) ? 'Modificar Servicio' : 'Nuevo Servicio y Agenda'; ?>
                        </h2>
                        <p class="text-muted small mb-0">
                            Completá la información del tratamiento y la disponibilidad horaria de atención.
                        </p>
                    </div>

                    <!-- Formulario hacia el Controller -->
                    <form action="<?= $ruta; ?>admin/guardarServicio" method="POST">
                        
                        <?php if (!empty($idActual)): ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($idActual); ?>">
                        <?php endif; ?>

                        <!-- SECCIÓN 1: DATOS DEL TRATAMIENTO -->
                        <h6 class="fw-bold text-uppercase mb-3 d-flex align-items-center" style="color: var(--terracota-principal); font-size: 0.85rem; letter-spacing: 0.03em;">
                            <i class="bi bi-tag me-2"></i> 1. Información del Tratamiento
                        </h6>

                        <div class="row g-3 mb-4 text-start">
                            <!-- Nombre del Servicio (Desplegable) -->
                            <div class="col-md-7">
                                <label for="nombre_servicio" class="form-label small fw-bold text-dark">Nombre del Servicio *</label>
                                <select id="nombre_servicio" name="nombre_servicio" class="form-select rounded-3 shadow-none" style="border-color: var(--borde-suave);" required onchange="autocompletarEspecialista()">
                                    <option value="" disabled <?= empty($nombreActual) ? 'selected' : ''; ?>>-- Elegir un tratamiento --</option>
                                    <option value="Manicura Completa" data-esp="1" data-box="Consultorio 1" <?= ($nombreActual === 'Manicura Completa') ? 'selected' : ''; ?>>Manicura Completa (Uñas)</option>
                                    <option value="Manicura Rusa con Esmaltado" data-esp="1" data-box="Consultorio 1" <?= ($nombreActual === 'Manicura Rusa con Esmaltado') ? 'selected' : ''; ?>>Manicura Rusa con Esmaltado (Uñas)</option>
                                    <option value="Limpieza Facial Profunda" data-esp="2" data-box="Consultorio 2" <?= ($nombreActual === 'Limpieza Facial Profunda') ? 'selected' : ''; ?>>Limpieza Facial Profunda (Cosmetología)</option>
                                    <option value="Lifting de Pestañas" data-esp="2" data-box="Consultorio 2" <?= ($nombreActual === 'Lifting de Pestañas') ? 'selected' : ''; ?>>Lifting de Pestañas (Mirada)</option>
                                    <option value="Perfilado y Laminado de Cejas" data-esp="2" data-box="Consultorio 2" <?= ($nombreActual === 'Perfilado y Laminado de Cejas') ? 'selected' : ''; ?>>Perfilado y Laminado de Cejas (Mirada)</option>
                                    <option value="Masaje Descontracturante" data-esp="3" data-box="Consultorio 3" <?= ($nombreActual === 'Masaje Descontracturante') ? 'selected' : ''; ?>>Masaje Descontracturante (Corporal)</option>
                                    <option value="Masaje Relajante con Aromaterapia" data-esp="3" data-box="Consultorio 3" <?= ($nombreActual === 'Masaje Relajante con Aromaterapia') ? 'selected' : ''; ?>>Masaje Relajante con Aromaterapia (Corporal)</option>
                                    <option value="Drenaje Linfático Manual" data-esp="3" data-box="Consultorio 3" <?= ($nombreActual === 'Drenaje Linfático Manual') ? 'selected' : ''; ?>>Drenaje Linfático Manual (Corporal)</option>
                                </select>
                            </div>

                            <!-- Especialista Asignado -->
                            <div class="col-md-5">
                                <label for="id_especialista" class="form-label small fw-bold text-dark">Especialista Asignado *</label>
                                <select id="id_especialista" name="id_especialista" class="form-select rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                                    <option value="" disabled>-- Seleccionar Especialista --</option>
                                    <option value="1" <?= ((int)$espActual === 1) ? 'selected' : ''; ?>>Romina Paz (Manicura)</option>
                                    <option value="2" <?= ((int)$espActual === 2) ? 'selected' : ''; ?>>Laura Ríos (Cosmetología y Mirada)</option>
                                    <option value="3" <?= ((int)$espActual === 3) ? 'selected' : ''; ?>>Sofía Martínez (Masoterapia y Corporal)</option>
                                </select>
                            </div>

                            <!-- Precio -->
                            <div class="col-md-4">
                                <label for="precio" class="form-label small fw-bold text-dark">Precio ($ ARS) *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted" style="border-color: var(--borde-suave);">$</span>
                                    <input type="number" step="0.01" id="precio" name="precio" class="form-control shadow-none rounded-end-3" 
                                           style="border-color: var(--borde-suave);"
                                           placeholder="3500.00" value="<?= htmlspecialchars($precioActual); ?>" required>
                                </div>
                            </div>

                            <!-- Duración -->
                            <div class="col-md-4">
                                <label for="duracion" class="form-label small fw-bold text-dark">Duración (minutos) *</label>
                                <div class="input-group">
                                    <input type="number" id="duracion" name="duracion" class="form-control shadow-none rounded-start-3" 
                                           style="border-color: var(--borde-suave);"
                                           placeholder="45" min="15" step="5" value="<?= htmlspecialchars($duracionAct); ?>" required>
                                    <span class="input-group-text bg-white text-muted" style="border-color: var(--borde-suave);">min</span>
                                </div>
                            </div>

                            <!-- Consultorio -->
                            <div class="col-md-4">
                                <label for="consultorio" class="form-label small fw-bold text-dark">Consultorio / Box *</label>
                                <input type="text" id="consultorio" name="consultorio" class="form-control shadow-none rounded-3" 
                                       style="border-color: var(--borde-suave);"
                                       placeholder="Consultorio 1" value="<?= htmlspecialchars($boxActual); ?>" required>
                            </div>
                        </div>

                        <!-- SECCIÓN 2: DISPONIBILIDAD Y HORARIOS -->
                        <h6 class="fw-bold text-uppercase mb-3 mt-4 pt-3 border-top d-flex align-items-center" style="border-color: var(--borde-suave) !important; color: var(--terracota-principal); font-size: 0.85rem; letter-spacing: 0.03em;">
                            <i class="bi bi-clock-history me-2"></i> 2. Disponibilidad y Horarios de Atención
                        </h6>

                        <div class="row g-3 mb-4 text-start">
                            <!-- Hora Inicio -->
                            <div class="col-md-3 col-sm-6">
                                <label for="hora_inicio" class="form-label small fw-bold text-dark">Hora Desde </label>
                                <input type="time" id="hora_inicio" name="hora_inicio" class="form-control shadow-none rounded-3" 
                                       style="border-color: var(--borde-suave);"
                                       value="<?= htmlspecialchars($hInicioActual); ?>" required>
                            </div>

                            <!-- Hora Fin -->
                            <div class="col-md-3 col-sm-6">
                                <label for="hora_fin" class="form-label small fw-bold text-dark">Hora Hasta </label>
                                <input type="time" id="hora_fin" name="hora_fin" class="form-control shadow-none rounded-3" 
                                       style="border-color: var(--borde-suave);"
                                       value="<?= htmlspecialchars($hFinActual); ?>" required>
                            </div>

                            <!-- Fecha Desde -->
                            <div class="col-md-3 col-sm-6">
                                <label for="fecha_desde" class="form-label small fw-bold text-dark">Vigencia Desde </label>
                                <input type="date" id="fecha_desde" name="fecha_desde" class="form-control shadow-none rounded-3" 
                                       style="border-color: var(--borde-suave);"
                                       value="<?= htmlspecialchars($fDesdeActual); ?>" required>
                            </div>

                            <!-- Fecha Hasta -->
                            <div class="col-md-3 col-sm-6">
                                <label for="fecha_hasta" class="form-label small fw-bold text-dark">Vigencia Hasta </label>
                                <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control shadow-none rounded-3" 
                                       style="border-color: var(--borde-suave);"
                                       value="<?= htmlspecialchars($fHastaActual); ?>" required>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top" style="border-color: var(--borde-suave) !important;">
                            <a href="<?= $ruta; ?>admin/servicios" class="btn btn-outline-secondary px-4 rounded-3 small fw-semibold">
                                Cancelar
                            </a>
                            <button type="submit" class="btn-solid-terracota px-4 py-2 small fw-semibold rounded-3 shadow-sm">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Guardar Servicio
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </main>

    <!-- FOOTER INSTITUCIONAL -->
    <footer class="footer-canvas py-3 text-center small mt-auto border-top" style="border-color: var(--borde-suave) !important;">
        Bella Estética &copy; <?= date('Y'); ?> &bull; Panel de Gestión Administrativa
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SCRIPT DE AUTOCOMPLETADO SENCILLO -->
    <script>
        function autocompletarEspecialista() {
            const selectServicio = document.getElementById('nombre_servicio');
            const selectEsp = document.getElementById('id_especialista');
            const inputConsultorio = document.getElementById('consultorio');

            const seleccion = selectServicio.options[selectServicio.selectedIndex];
            const espId = seleccion.getAttribute('data-esp');
            const box = seleccion.getAttribute('data-box');

            if (espId) {
                selectEsp.value = espId;
            }
            if (box && (!inputConsultorio.value || inputConsultorio.value.startsWith('Consultorio'))) {
                inputConsultorio.value = box;
            }
        }
    </script>
</body>
</html>