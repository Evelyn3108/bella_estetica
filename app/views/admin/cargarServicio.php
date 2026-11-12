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

    <!-- NAVBAR ADMINISTRACIÓN UNIFICADO -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom py-2 shadow-sm sticky-top" style="border-color: var(--borde-suave) !important;">
        <div class="container-fluid px-4">
            
            <!-- Logo con Identidad Terracota -->
            <a class="navbar-brand d-flex align-items-center me-4" href="<?= $ruta; ?>admin/agenda">
                <i class="bi bi-flower1 fs-3 me-2" style="color: var(--terracota-principal, #b2614a);"></i>
                <div>
                    <span class="fw-bold tracking-tight text-dark fs-5">BELLA ESTÉTICA</span>
                    <span class="badge rounded-pill text-uppercase ms-2 px-2 py-1 fw-semibold" 
                        style="background-color: var(--caja-suave); color: var(--terracota-principal, #b2614a); font-size: 0.65rem; letter-spacing: 0.05em;">
                        ADMINISTRACIÓN
                    </span>
                </div>
            </a>

            <!-- Botón Responsive Mobile -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#menuAdminNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Enlaces Centrales y Acciones -->
            <div class="collapse navbar-collapse" id="menuAdminNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <!-- 1. Agenda -->
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 text-secondary d-flex align-items-center gap-1" href="<?= $ruta; ?>admin/agenda">
                            <i class="bi bi-calendar3"></i> Agenda
                        </a>
                    </li>

                    <!-- 2. Servicios (Activo) -->
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 fw-semibold d-flex align-items-center gap-1 active border-bottom border-2" 
                        style="color: var(--terracota-principal, #b2614a) !important; border-color: var(--terracota-principal, #b2614a) !important;" 
                        href="<?= $ruta; ?>admin/servicios">
                            <i class="bi bi-card-checklist"></i> Servicios
                        </a>
                    </li>

                    <!-- 3. Especialistas -->
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 text-secondary d-flex align-items-center gap-1" href="<?= $ruta; ?>admin/especialistas">
                            <i class="bi bi-person-badge"></i> Especialistas
                        </a>
                    </li>

                    <!-- 4. Usuarios -->
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 text-secondary d-flex align-items-center gap-1" href="<?= $ruta; ?>admin/usuarios">
                            <i class="bi bi-people"></i> Usuarios
                        </a>
                    </li>
                </ul>

                <!-- Sección Derecha: Usuario Admin y Cerrar Sesión -->
                <div class="d-flex align-items-center gap-3">
                    <span class="small fw-semibold text-secondary d-flex align-items-center gap-1">
                        <i class="bi bi-person-circle fs-5" style="color: var(--terracota-principal, #b2614a);"></i>
                        Administrador
                    </span>

                    <a href="<?= $ruta; ?>account/salir" class="btn btn-salir btn-sm px-3 rounded-pill fw-semibold d-inline-flex align-items-center gap-1 text-decoration-none">
                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
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
                    $diasActuales  = explode(',', $srv['dias_atencion'] ?? '1,2,3,4,5,6');
                    
                    // Horarios específicos cargados (si hay una lista en dias_atencion/hora_inicio o valor por defecto)
                    $horariosGuardados = !empty($srv['hora_inicio']) ? explode(',', $srv['hora_inicio']) : ['09:00', '10:30', '14:00', '16:30'];
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
                            Completá la información del tratamiento y definí los días y horarios específicos de atención.
                        </p>
                    </div>

                    <!-- Formulario hacia el Controller -->
                    <form action="<?= $ruta; ?>admin/guardarServicio" method="POST">
                        
                        <?php if (!empty($idActual)): ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($idActual); ?>">
                        <?php endif; ?>

                        <!-- SECCIÓN 1: INFORMACIÓN DEL TRATAMIENTO -->
                        <h6 class="fw-bold text-uppercase mb-3 d-flex align-items-center" style="color: var(--terracota-principal) !important; font-size: 0.85rem; letter-spacing: 0.03em;">
                            <i class="bi bi-tag me-2"></i> 1. Información del Tratamiento
                        </h6>

                        <div class="row g-3 mb-4 text-start">
                            <!-- Nombre del Servicio: Input libre de texto -->
                            <div class="col-md-7">
                                <label for="nombre_servicio" class="form-label small fw-bold text-dark">Nombre del Servicio / Tratamiento *</label>
                                <input type="text" id="nombre_servicio" name="nombre_servicio" 
                                       class="form-control rounded-3 shadow-none" 
                                       style="border-color: var(--borde-suave);" 
                                       placeholder="Ej: Manicura Completa, Limpieza Facial, etc." 
                                       value="<?= htmlspecialchars($nombreActual); ?>" required>
                            </div>

                            <!-- Especialista Asignado (mantiene el select dinámico) -->
                            <div class="col-md-5">
                                <label for="id_especialista" class="form-label small fw-bold text-dark">Especialista Asignado *</label>
                                <select id="id_especialista" name="id_especialista" class="form-select rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                                    <option value="" disabled>-- Seleccionar Especialista --</option>
                                    <?php if (!empty($especialistas)): ?>
                                        <?php foreach ($especialistas as $esp): ?>
                                            <?php 
                                                $arrE = is_object($esp) ? (array)$esp : $esp;
                                                $idE = $arrE['id'];
                                                $nomE = trim($arrE['nombre'] . ' ' . $arrE['apellido']);
                                                $espE = $arrE['especialidad'] ?? '';
                                            ?>
                                            <option value="<?= $idE; ?>" <?= ((int)$espActual === (int)$idE) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($nomE); ?> (<?= htmlspecialchars($espE); ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1" <?= ((int)$espActual === 1) ? 'selected' : ''; ?>>Romina Paz (Manicura)</option>
                                        <option value="2" <?= ((int)$espActual === 2) ? 'selected' : ''; ?>>Laura Ríos (Cosmetología y Mirada)</option>
                                        <option value="3" <?= ((int)$espActual === 3) ? 'selected' : ''; ?>>Sofía Martínez (Masoterapia y Corporal)</option>
                                        <option value="4" <?= ((int)$espActual === 4) ? 'selected' : ''; ?>>Valentina Gómez (Lifting y Diseño de Mirada)</option>
                                    <?php endif; ?>
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
                                <label for="duracion" class="form-label small fw-bold text-dark">Duración estimada *</label>
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
                        <h6 class="fw-bold text-uppercase mb-3 mt-4 pt-3 border-top d-flex align-items-center" style="border-color: var(--borde-suave) !important; color: var(--terracota-principal) !important; font-size: 0.85rem; letter-spacing: 0.03em;">
                            <i class="bi bi-clock-history me-2"></i> 2. Disponibilidad y Horarios de Atención
                        </h6>

                       <!-- Días de Atención Semanal -->
                        <div class="mb-4 text-start">
                            <label class="form-label small fw-bold text-dark">
                                <i class="bi bi-calendar-week me-1" style="color: var(--terracota-principal, #a05a42);"></i> Días de Atención Semanal *
                            </label>
                            <div class="d-flex flex-wrap gap-3 p-3 bg-light rounded-3 border" style="border-color: #e5dede;">
                                <?php 
                                    // Convertimos $servicio a array de forma segura si viene como objeto o nulo
                                    $arrSrv = is_object($servicio) ? (array)$servicio : ($servicio ?? []);

                                    $diasTexto = $arrSrv['dias_atencion'] ?? '1,2,3,4,5,6';
                                    $diasGuardados = !empty($diasTexto) 
                                        ? explode(',', (string)$diasTexto) 
                                        : ['1', '2', '3', '4', '5', '6'];
                                    
                                    $diasSemana = [
                                        '1' => 'Lunes',
                                        '2' => 'Martes',
                                        '3' => 'Miércoles',
                                        '4' => 'Jueves',
                                        '5' => 'Viernes',
                                        '6' => 'Sábado'
                                    ];

                                    foreach ($diasSemana as $num => $nombreDia):
                                        $marcado = in_array((string)$num, $diasGuardados) ? 'checked' : '';
                                ?>
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="checkbox" name="dias[]" value="<?= $num; ?>" id="dia_<?= $num; ?>" <?= $marcado; ?>>
                                        <label class="form-check-label small fw-semibold text-dark" for="dia_<?= $num; ?>">
                                            <?= $nombreDia; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <small class="text-muted">Desmarcá los días en los que el especialista no atienda este tratamiento.</small>
                        </div>

                        <!-- Horarios Puntuales de Atención -->
                        <div class="mb-4 text-start">
                            <label class="form-label small fw-bold text-dark d-block mb-1">
                                Horarios Habilitados de Atención *
                            </label>
                            <small class="text-muted d-block mb-2">
                                Podés agregar todas las franjas horarias que atienda la profesional (ej: 10:30, 13:00, 16:30) para que el cliente elija directamente entre ellas.
                            </small>

                            <!-- Contenedor dinámico de horarios -->
                            <div id="contenedor-horarios" class="d-flex flex-wrap gap-2 mb-2">
                                <?php foreach ($horariosGuardados as $h): ?>
                                    <?php $hLimpia = trim(substr($h, 0, 5)); if (empty($hLimpia)) continue; ?>
                                    <div class="input-group input-group-sm horario-item" style="width: 145px;">
                                        <span class="input-group-text bg-white"><i class="bi bi-clock text-muted"></i></span>
                                        <input type="time" name="horarios[]" class="form-control text-center shadow-none" value="<?= $hLimpia; ?>" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="eliminarHorario(this)" title="Quitar horario">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-3 px-3 py-1" onclick="agregarHorario()">
                                <i class="bi bi-plus-lg me-1"></i> Agregar otro horario
                            </button>
                        </div>

                        <!-- Vigencia del Servicio (opcional) -->
                        <div class="row g-3 mb-4 text-start">
                            <div class="col-md-6 col-sm-6">
                                <label for="fecha_desde" class="form-label small fw-bold text-dark">Vigencia Desde </label>
                                <input type="date" id="fecha_desde" name="fecha_desde" class="form-control shadow-none rounded-3" 
                                       style="border-color: var(--borde-suave);" 
                                       value="<?= htmlspecialchars($fDesdeActual); ?>" required>
                            </div>

                            <div class="col-md-6 col-sm-6">
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
                            <button type="submit" class="btn-solid-terracota px-4 py-2 small fw-semibold rounded-3 shadow-sm border-0">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Guardar Servicio
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </main>

    <!-- JavaScript para agregar/quitar franjas horarias -->
    <script>
        function agregarHorario() {
            const contenedor = document.getElementById('contenedor-horarios');
            const div = document.createElement('div');
            div.className = 'input-group input-group-sm horario-item';
            div.style.width = '145px';
            div.innerHTML = `
                <span class="input-group-text bg-white"><i class="bi bi-clock text-muted"></i></span>
                <input type="time" name="horarios[]" class="form-control text-center shadow-none" value="12:00" required>
                <button type="button" class="btn btn-outline-danger" onclick="eliminarHorario(this)" title="Quitar horario">
                    <i class="bi bi-x"></i>
                </button>
            `;
            contenedor.appendChild(div);
        }

        function eliminarHorario(btn) {
            const items = document.querySelectorAll('.horario-item');
            if (items.length > 1) {
                btn.closest('.horario-item').remove();
            } else {
                alert('Debe haber al menos un horario habilitado.');
            }
        }
    </script>

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