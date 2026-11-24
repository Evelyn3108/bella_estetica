<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($servicio) ? 'Modificar Servicio' : 'Nuevo Servicio'; ?> - Bella Estética</title>

    <link rel="stylesheet" href="<?= $ruta; ?>css/estilos.css?v=25">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg bg-white border-bottom py-2 shadow-sm sticky-top" style="border-color: var(--borde-suave) !important;">
        <div class="container-fluid px-4">
            
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

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#menuAdminNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuAdminNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 text-secondary d-flex align-items-center gap-1" href="<?= $ruta; ?>admin/agenda">
                            <i class="bi bi-calendar3"></i> Agenda
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 fw-semibold d-flex align-items-center gap-1 active border-bottom border-2" 
                        style="color: var(--terracota-principal, #b2614a) !important; border-color: var(--terracota-principal, #b2614a) !important;" 
                        href="<?= $ruta; ?>admin/servicios">
                            <i class="bi bi-card-checklist"></i> Servicios
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 text-secondary d-flex align-items-center gap-1" href="<?= $ruta; ?>admin/especialistas">
                            <i class="bi bi-person-badge"></i> Especialistas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 text-secondary d-flex align-items-center gap-1" href="<?= $ruta; ?>admin/usuarios">
                            <i class="bi bi-people"></i> Usuarios
                        </a>
                    </li>
                </ul>

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
                    
                    // Horarios específicos cargados
                    $horariosGuardados = !empty($srv['hora_inicio']) 
                        ? array_values(array_unique(array_filter(array_map('trim', explode(',', $srv['hora_inicio']))))) 
                        : ['09:00'];
                    $fDesdeActual  = !empty($srv['fecha_desde']) ? $srv['fecha_desde'] : date('Y-m-d');
                    $fHastaActual  = !empty($srv['fecha_hasta']) ? $srv['fecha_hasta'] : date('Y-m-d', strtotime('+1 year'));
                    $imagenActual  = $srv['imagen'] ?? '';
                    $descripcionActual = $srv['descripcion'] ?? '';
                ?>

                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white" style="border: 1px solid var(--borde-suave) !important;">
                    
                    <div class="text-center mb-4 pb-2 border-bottom" style="border-color: var(--borde-suave) !important;">
                        <span class="badge rounded-pill text-uppercase mb-2 px-3 py-2 fw-semibold" style="background-color: var(--caja-suave); color: var(--terracota-principal); font-size: 0.72rem; letter-spacing: 0.05em;">
                            MÓDULO DE CATÁLOGO
                        </span>
                        <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">
                            <?= !empty($idActual) ? 'Modificar Servicio' : 'Nuevo Servicio y Agenda'; ?>
                        </h2>
                        <p class="text-muted small mb-0">
                            Completá la información del tratamiento, subí una foto representativa y definí los días y horarios específicos de atención.
                        </p>
                    </div>
                    
                    <form action="<?= $ruta; ?>admin/guardarServicio" method="POST" enctype="multipart/form-data">
                        
                        <?php if (!empty($idActual)): ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($idActual); ?>">
                        <?php endif; ?>
                        <input type="hidden" name="imagen_actual" value="<?= htmlspecialchars($imagenActual); ?>">

                        <h6 class="fw-bold text-uppercase mb-3 d-flex align-items-center" style="color: var(--terracota-principal) !important; font-size: 0.85rem; letter-spacing: 0.03em;">
                            <i class="bi bi-tag me-2"></i> 1. Información del Tratamiento
                        </h6>

                        <div class="row g-3 mb-4 text-start">

                            <div class="col-md-7">
                                <label for="nombre_servicio" class="form-label small fw-bold text-dark">Nombre del Servicio / Tratamiento *</label>
                                <input type="text" id="nombre_servicio" name="nombre_servicio" 
                                       class="form-control rounded-3 shadow-none" 
                                       style="border-color: var(--borde-suave);" 
                                       placeholder="Ej: Manicura Completa, Limpieza Facial, etc." 
                                       value="<?= htmlspecialchars($nombreActual); ?>" required>
                            </div>

                         <div class="col-md-5">
                            <label for="id_especialista" class="form-label small fw-bold text-dark">Especialista Asignado *</label>
                            <select id="id_especialista" name="id_especialista" class="form-select rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                                <option value="" disabled <?= empty($espActual) ? 'selected' : ''; ?>>-- Seleccionar Especialista --</option>
                                <?php if (!empty($especialistas)): ?>
                                    <?php foreach ($especialistas as $esp): ?>
                                        <?php 
                                            $eArr = is_object($esp) ? (array)$esp : (is_array($esp) ? $esp : []);
                                            $idE  = $eArr['id'] ?? 0;
                                            $nomE = trim(($eArr['nombre'] ?? '') . ' ' . ($eArr['apellido'] ?? ''));
                                            $area = $eArr['especialidad'] ?? '';
                                        ?>
                                        <option value="<?= $idE; ?>" <?= ((int)$espActual === (int)$idE) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($nomE); ?><?= !empty($area) ? ' (' . htmlspecialchars($area) . ')' : ''; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                         </div>

                         <div class="col-12">
                             <label for="descripcion" class="form-label small fw-bold text-dark">Descripción del Servicio / Tratamiento</label>
                             <textarea id="descripcion" name="descripcion" rows="3" 
                                       class="form-control rounded-3 shadow-none" 
                                       style="border-color: var(--borde-suave);" 
                                       placeholder="Detallá los beneficios, características o metodología del tratamiento que verán los clientes en la web..."><?= htmlspecialchars($descripcionActual); ?></textarea>
                         </div>

                            <div class="col-md-4">
                                <label for="precio" class="form-label small fw-bold text-dark">Precio </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted" style="border-color: var(--borde-suave);">$</span>
                                    <input type="number" step="0.01" id="precio" name="precio" class="form-control shadow-none rounded-end-3" 
                                           style="border-color: var(--borde-suave);" 
                                           placeholder="3500.00" value="<?= htmlspecialchars($precioActual); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="duracion" class="form-label small fw-bold text-dark">Duración estimada *</label>
                                <div class="input-group">
                                    <input type="number" id="duracion" name="duracion" class="form-control shadow-none rounded-start-3" 
                                           style="border-color: var(--borde-suave);" 
                                           placeholder="45" min="15" step="5" value="<?= htmlspecialchars($duracionAct); ?>" required>
                                    <span class="input-group-text bg-white text-muted" style="border-color: var(--borde-suave);">min</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="consultorio" class="form-label small fw-bold text-dark">Consultorio</label>
                                <select id="consultorio" name="consultorio" class="form-select rounded-3 shadow-none" 
                                        style="border-color: var(--borde-suave);" required>
                                    <?php 
                                        $consultorios = ['Consultorio 1', 'Consultorio 2', 'Consultorio 3', 'Consultorio 4'];
                                        if (!empty($boxActual) && !in_array($boxActual, $consultorios)) {
                                            $consultorios[] = $boxActual;
                                        }
                                        foreach ($consultorios as $c): 
                                    ?>
                                        <option value="<?= htmlspecialchars($c); ?>" <?= ($boxActual === $c) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($c); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-12 mt-3">
                                <label for="imagen" class="form-label small fw-bold text-dark d-flex align-items-center gap-1">
                                    <i class="bi bi-image" style="color: var(--terracota-principal);"></i> Imagen Ilustrativa del Servicio
                                    <span class="text-muted fw-normal">(se mostrará en el catálogo y detalle para el cliente)</span>
                                </label>
                                
                                <div class="d-flex flex-wrap align-items-center gap-3 p-3 bg-light rounded-3 border" style="border-color: var(--borde-suave) !important;">

                                    <div id="contenedor-preview" class="rounded-3 overflow-hidden border d-flex align-items-center justify-content-center bg-white shadow-xs" style="width: 120px; height: 85px; min-width: 120px;">
                                        <?php if (!empty($imagenActual)): ?>
                                            <?php 
                                                if (file_exists('public/img/servicios/' . $imagenActual) || file_exists('img/servicios/' . $imagenActual)) {
                                                    $srcPrev = $ruta . 'img/servicios/' . $imagenActual;
                                                } elseif (file_exists('public/img/' . $imagenActual) || file_exists('img/' . $imagenActual)) {
                                                    $srcPrev = $ruta . 'img/' . $imagenActual;
                                                } else {
                                                    $srcPrev = $ruta . 'img/servicios/' . $imagenActual;
                                                }
                                            ?>
                                            <img id="img-preview" src="<?= $srcPrev; ?>" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                        <?php else: ?>
                                            <div id="preview-placeholder" class="text-center text-muted p-2">
                                                <i class="bi bi-card-image fs-3 d-block opacity-50" style="color: var(--terracota-principal);"></i>
                                                <span style="font-size: 0.65rem;">Sin imagen</span>
                                            </div>
                                            <img id="img-preview" src="" alt="Preview" class="d-none" style="width: 100%; height: 100%; object-fit: cover;">
                                        <?php endif; ?>
                                    </div>

                                    <div class="flex-grow-1">
                                        <input type="file" id="imagen" name="imagen" class="form-control rounded-3 shadow-none form-control-sm mb-1" 
                                               accept="image/jpeg,image/png,image/webp,image/jpg" onchange="previsualizarImagen(event)" 
                                               style="border-color: var(--borde-suave);">
                                        <div class="small text-muted" style="font-size: 0.75rem;">
                                            Subí una imagen (JPG, PNG o WEBP). Si no seleccionás ninguna, el sistema asignará una imagen temática automática.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                Horarios Habilitados de Atención 
                            </label>
                            <small class="text-muted d-block mb-2">
                                Podés agregar todas las franjas horarias que atienda la profesional (ej: 10:30, 13:00, 16:30) para que el cliente elija directamente entre ellas. No se admiten horarios repetidos.
                            </small>

                            <!-- Contenedor dinámico de horarios -->
                            <div id="contenedor-horarios" class="d-flex flex-wrap gap-2 mb-2">
                                <?php foreach ($horariosGuardados as $h): ?>
                                    <?php $hLimpia = trim(substr($h, 0, 5)); if (empty($hLimpia)) continue; ?>
                                    <div class="input-group input-group-sm horario-item" style="width: 145px;">
                                        <span class="input-group-text bg-white"><i class="bi bi-clock text-muted"></i></span>
                                        <input type="time" name="horarios[]" class="form-control text-center shadow-none input-horario" value="<?= $hLimpia; ?>" required onchange="validarHorariosDuplicados()" oninput="validarHorariosDuplicados()">
                                        <button type="button" class="btn btn-outline-danger" onclick="eliminarHorario(this)" title="Quitar horario">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div id="alerta-horarios-duplicados" class="alert alert-danger py-2 px-3 small mt-2 d-none rounded-3 align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle-fill text-danger fs-6"></i>
                                <span id="alerta-horarios-duplicados-texto"></span>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-3 px-3 py-1 mt-1" onclick="agregarHorario()">
                                <i class="bi bi-plus-lg me-1"></i> Agregar otro horario
                            </button>
                        </div>

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

    <!-- SweetAlert2 y Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript para agregar/quitar y validar franjas horarias únicas -->
    <script>
        function obtenerHorariosActuales() {
            const inputs = document.querySelectorAll('input[name="horarios[]"]');
            const valores = [];
            inputs.forEach(inp => {
                const v = inp.value.trim().substring(0, 5);
                if (v) valores.push(v);
            });
            return valores;
        }

        function sugerirSiguienteHorario() {
            const actuales = obtenerHorariosActuales();
            if (actuales.length === 0) return '09:00';

            // Tomar el último horario cargado
            let ultimo = actuales[actuales.length - 1];
            let [h, m] = ultimo.split(':').map(Number);
            if (isNaN(h)) h = 9;
            if (isNaN(m)) m = 0;

            // Buscar la siguiente hora libre para evitar duplicar el valor inicial
            for (let i = 1; i <= 24; i++) {
                let nuevoH = (h + i) % 24;
                let cand = `${String(nuevoH).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
                if (!actuales.includes(cand)) {
                    return cand;
                }
            }
            return '15:00';
        }

        function validarHorariosDuplicados() {
            const inputs = Array.from(document.querySelectorAll('input[name="horarios[]"]'));
            const conteo = {};
            const duplicados = new Set();

            // Limpiar estados de error previos
            inputs.forEach(inp => {
                inp.classList.remove('is-invalid', 'border-danger');
                inp.style.borderColor = 'var(--borde-suave)';
            });

            inputs.forEach(inp => {
                const v = inp.value.trim().substring(0, 5);
                if (!v) return;
                conteo[v] = (conteo[v] || 0) + 1;
                if (conteo[v] > 1) {
                    duplicados.add(v);
                }
            });

            const alerta = document.getElementById('alerta-horarios-duplicados');
            const alertaTexto = document.getElementById('alerta-horarios-duplicados-texto');

            if (duplicados.size > 0) {
                const listaDup = Array.from(duplicados).join(', ');
                inputs.forEach(inp => {
                    const v = inp.value.trim().substring(0, 5);
                    if (duplicados.has(v)) {
                        inp.classList.add('is-invalid', 'border-danger');
                        inp.style.borderColor = '#dc3545';
                    }
                });

                if (alerta && alertaTexto) {
                    alertaTexto.innerHTML = `No se pueden ingresar dos horarios iguales. El horario <strong>${listaDup} hs</strong> ya está en la lista. Por favor, cambiá o eliminá el duplicado para no generar conflicto con los clientes.`;
                    alerta.classList.remove('d-none');
                    alerta.classList.add('d-flex');
                }
                return false;
            } else {
                if (alerta) {
                    alerta.classList.add('d-none');
                    alerta.classList.remove('d-flex');
                }
                return true;
            }
        }

        function agregarHorario() {
            const contenedor = document.getElementById('contenedor-horarios');
            const sugerido = sugerirSiguienteHorario();
            const div = document.createElement('div');
            div.className = 'input-group input-group-sm horario-item';
            div.style.width = '145px';
            div.innerHTML = `
                <span class="input-group-text bg-white"><i class="bi bi-clock text-muted"></i></span>
                <input type="time" name="horarios[]" class="form-control text-center shadow-none input-horario" value="${sugerido}" required onchange="validarHorariosDuplicados()" oninput="validarHorariosDuplicados()">
                <button type="button" class="btn btn-outline-danger" onclick="eliminarHorario(this)" title="Quitar horario">
                    <i class="bi bi-x"></i>
                </button>
            `;
            contenedor.appendChild(div);
            validarHorariosDuplicados();
        }

        function eliminarHorario(btn) {
            const items = document.querySelectorAll('.horario-item');
            if (items.length > 1) {
                btn.closest('.horario-item').remove();
                validarHorariosDuplicados();
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        text: 'Debe haber al menos un horario habilitado para el servicio.',
                        confirmButtonColor: '#b2614a'
                    });
                } else {
                    alert('Debe haber al menos un horario habilitado.');
                }
            }
        }

        // Previsualización instantánea de la imagen seleccionada
        function previsualizarImagen(event) {
            const input = event.target;
            const preview = document.getElementById('img-preview');
            const placeholder = document.getElementById('preview-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    if (placeholder) placeholder.classList.add('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Validación inicial al cargar el formulario
            validarHorariosDuplicados();

            const form = document.querySelector('form[action*="guardarServicio"]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validarHorariosDuplicados()) {
                        e.preventDefault();

                        const inputs = Array.from(document.querySelectorAll('input[name="horarios[]"]'));
                        const conteo = {};
                        const dup = new Set();
                        inputs.forEach(inp => {
                            const v = inp.value.trim().substring(0, 5);
                            if (v) {
                                conteo[v] = (conteo[v] || 0) + 1;
                                if (conteo[v] > 1) dup.add(v);
                            }
                        });
                        const dupStr = Array.from(dup).join(', ');

                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Horarios Duplicados',
                                html: `No podés guardar el servicio con horarios repetidos.<br><br>Detectamos duplicado el horario: <strong>${dupStr} hs</strong>.<br>Por favor, cambiá o eliminá el horario duplicado para no generar conflicto con los clientes al agendar turnos.`,
                                confirmButtonColor: '#b2614a'
                            });
                        } else {
                            alert(`No se pueden poner dos horarios iguales (${dupStr} hs). Por favor, cambie o elimine el duplicado.`);
                        }

                        const cont = document.getElementById('contenedor-horarios');
                        if (cont) {
                            cont.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }

                        const primerDup = inputs.find(inp => dup.has(inp.value.trim().substring(0, 5)));
                        if (primerDup) {
                            primerDup.focus();
                        }

                        return false;
                    }
                });
            }
        });
    </script>

    <!-- FOOTER INSTITUCIONAL -->
    <footer class="footer-canvas py-3 text-center small mt-auto border-top" style="border-color: var(--borde-suave) !important;">
        Bella Estética &copy; <?= date('Y'); ?> &bull; Panel de Gestión Administrativa
    </footer>

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

        // Evita que al dar 'Atrás' en el navegador tras cerrar sesión se visualice la sesión abierta
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || (window.performance && window.performance.getEntriesByType("navigation")[0]?.type === "back_forward")) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>