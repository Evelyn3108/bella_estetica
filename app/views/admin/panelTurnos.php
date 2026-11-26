<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Turnos - Bella Estética</title>
    <link rel="stylesheet" href="<?= $ruta; ?>css/estilos.css?v=21">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR ADMINISTRADOR -->
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
                        <a class="nav-link nav-link-custom" href="<?= $ruta; ?>admin/panel">
                            <i class="bi bi-calendar3 me-1"></i> Agenda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="<?= $ruta; ?>admin/servicios">
                            <i class="bi bi-card-checklist me-1"></i> Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="<?= $ruta; ?>admin/especialistas">
                            <i class="bi bi-person-badge me-1"></i> Especialistas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="<?= $ruta; ?>admin/usuarios">
                            <i class="bi bi-people me-1"></i> Usuarios
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <span class="small fw-semibold text-muted d-flex align-items-center">
                        <i class="bi bi-person-circle fs-5 me-2" style="color: var(--terracota-principal);"></i>
                        <?= htmlspecialchars($_SESSION['USER']['name'] ?? 'Administrador'); ?>
                    </span>
                    <a href="<?= $ruta; ?>account/salir" class="btn btn-salir btn-sm px-3 rounded-pill fw-semibold d-inline-flex align-items-center gap-1 text-decoration-none">
                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENEDOR PRINCIPAL -->
    <main class="container-fluid px-4 mb-5 flex-grow-1">
        
        <!-- ENCABEZADO Y FILTRO -->
        <div class="row align-items-center mb-4 gy-3">
            <div class="col-lg-4 col-md-12">
                <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Agenda de Turnos</h3>
                <p class="text-muted small mb-0">
                    <?php 
                        $filtrosTexto = [];
                        if (!empty($fechaFiltro)) {
                            $filtrosTexto[] = 'fecha: <strong>' . date('d/m/Y', strtotime($fechaFiltro)) . '</strong>';
                        }
                        if (!empty($especialistaNombreFiltro)) {
                            $filtrosTexto[] = 'especialista: <strong>' . htmlspecialchars($especialistaNombreFiltro) . '</strong>';
                        }
                        if (!empty($filtrosTexto)) {
                            echo 'Mostrando citas por ' . implode(' y ', $filtrosTexto) . '.';
                        } else {
                            echo 'Listado general de todas las reservas registradas.';
                        }
                    ?>
                </p>
            </div>
            
            <div class="col-lg-8 col-md-12">
                <form action="<?= $ruta; ?>admin/panel" method="GET" class="d-flex flex-wrap justify-content-md-end align-items-center gap-2">
                    <label for="fecha" class="small fw-bold text-muted text-nowrap">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" class="form-control form-control-sm w-auto shadow-none rounded-3" 
                           style="border-color: var(--borde-suave);" 
                           value="<?= htmlspecialchars($fechaFiltro); ?>" 
                           onchange="this.form.submit()">

                    <label for="especialista" class="small fw-bold text-muted text-nowrap ms-md-1">Especialista:</label>
                    <select id="especialista" name="especialista" class="form-select form-select-sm w-auto shadow-none rounded-3" 
                            style="border-color: var(--borde-suave);" 
                            onchange="this.form.submit()">
                        <option value="">Todos los especialistas</option>
                        <?php if (!empty($especialistas)): ?>
                            <?php foreach ($especialistas as $esp): ?>
                                <?php 
                                    $eArr = is_object($esp) ? (array)$esp : $esp;
                                    $idE  = $eArr['id'] ?? 0;
                                    $nomE = trim(($eArr['nombre'] ?? '') . ' ' . ($eArr['apellido'] ?? ''));
                                    $isSelected = ($especialistaFiltro == $idE || $especialistaFiltro === $nomE);
                                ?>
                                <option value="<?= $idE; ?>" <?= $isSelected ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($nomE); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    
                    <a href="<?= $ruta; ?>admin/panel?fecha=<?= date('Y-m-d'); ?><?= !empty($especialistaFiltro) ? '&especialista=' . urlencode($especialistaFiltro) : ''; ?>" class="btn btn-sm fw-semibold rounded-3 text-decoration-none" 
                       style="background-color: var(--caja-suave); color: var(--terracota-principal); border: 1px solid var(--borde-suave);">
                        Hoy
                    </a>
                    
                    <a href="<?= $ruta; ?>admin/panel" class="btn btn-sm btn-outline-secondary rounded-3 text-decoration-none" title="Limpiar todos los filtros">
                        Ver todos
                    </a>

                    <div class="dropdown d-inline-block">
                        <button class="btn btn-sm btn-outline-success dropdown-toggle rounded-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-none" 
                                type="button" id="dropdownExportar" data-bs-toggle="dropdown" aria-expanded="false" 
                                title="<?= !empty($especialistaNombreFiltro) ? 'Exportar turnos de ' . htmlspecialchars($especialistaNombreFiltro) : 'Exportar turnos'; ?>">
                            <i class="bi bi-download"></i> Exportar
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 py-1" aria-labelledby="dropdownExportar" style="font-size: 0.85rem; border: 1px solid var(--borde-suave) !important;">
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2" 
                                   href="<?= $ruta; ?>admin/exportarTurnos?formato=excel<?= !empty($fechaFiltro) ? '&fecha=' . urlencode($fechaFiltro) : ''; ?><?= !empty($especialistaFiltro) ? '&especialista=' . urlencode($especialistaFiltro) : ''; ?>">
                                    <i class="bi bi-file-earmark-excel-fill text-success fs-6"></i> 
                                    <span>Exportar a Excel (.csv)</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2" 
                                   href="<?= $ruta; ?>admin/exportarTurnos?formato=txt<?= !empty($fechaFiltro) ? '&fecha=' . urlencode($fechaFiltro) : ''; ?><?= !empty($especialistaFiltro) ? '&especialista=' . urlencode($especialistaFiltro) : ''; ?>">
                                    <i class="bi bi-file-earmark-text-fill text-secondary fs-6"></i> 
                                    <span>Exportar a Texto (.txt)</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-sm text-white fw-semibold rounded-3 d-inline-flex align-items-center gap-1 shadow-sm" 
                            style="background-color: var(--terracota-principal);" 
                            data-bs-toggle="modal" data-bs-target="#modalNuevoTurnoManual">
                        <i class="bi bi-plus-circle"></i> Nuevo Turno
                    </button>
                </form>
            </div>
        </div>

        <!-- ALERTAS DE TURNO MANUAL -->
        <?php $status = $_GET['status'] ?? null; ?>
        <?php if ($status === 'turno_creado'): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2 px-3 border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> El turno manual fue agendado y confirmado con éxito.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($status === 'horario_ocupado'): ?>
            <div class="alert alert-warning alert-dismissible fade show rounded-3 small py-2 px-3 border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> No se pudo agendar: el especialista o el cliente ya tienen un turno ocupado en esa fecha y horario.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($status === 'dia_no_disponible'): ?>
            <div class="alert alert-warning alert-dismissible fade show rounded-3 small py-2 px-3 border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> No se pudo agendar: el especialista no atiende en el día de la semana seleccionado para ese tratamiento.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($status === 'error'): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 small py-2 px-3 border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-x-circle-fill me-2"></i> Ocurrió un error al intentar registrar el turno. Verificá los datos.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- TABLA DE TURNOS -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--borde-suave) !important;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f6f1ee; color: var(--texto-oscuro);">
                        <tr class="small text-uppercase border-bottom" style="border-color: var(--borde-suave);">
                            <th class="py-3 ps-3">Fecha</th>
                            <th class="py-3">Hora</th>
                            <th class="py-3">Cliente</th>
                            <th class="py-3">Teléfono</th>
                            <th class="py-3">Servicio</th>
                            <th class="py-3">Especialista</th>
                            <th class="py-3">Consultorio</th>
                            <th class="py-3">Estado</th>
                            <th class="py-3 text-center pe-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($turnos)): ?>
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-x fs-1 d-block mb-2 opacity-50" style="color: var(--terracota-principal);"></i>
                                    <?php 
                                        $msgVacio = [];
                                        if (!empty($fechaFiltro)) {
                                            $msgVacio[] = 'para el día ' . date('d/m/Y', strtotime($fechaFiltro));
                                        }
                                        if (!empty($especialistaNombreFiltro)) {
                                            $msgVacio[] = 'con el especialista ' . htmlspecialchars($especialistaNombreFiltro);
                                        }
                                        if (!empty($msgVacio)) {
                                            echo 'No se encontraron turnos ' . implode(' y ', $msgVacio) . '.';
                                        } else {
                                            echo 'No se encontraron turnos registrados en el sistema.';
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($turnos as $t): ?>
                                <?php 
                                    $arr = is_object($t) ? (array) $t : (is_array($t) ? $t : []);

                                    $idTurno   = $arr['id'] ?? $arr['ID'] ?? 0;
                                    $fechaRaw  = $arr['fecha'] ?? $arr['FECHA'] ?? '';
                                    $fechaFmt  = !empty($fechaRaw) ? date('d/m/Y', strtotime($fechaRaw)) : '-';
                                    
                                    $horaRaw   = $arr['hora'] ?? $arr['HORA'] ?? '';
                                    $horaFmt   = !empty($horaRaw) ? substr($horaRaw, 0, 5) . ' hs' : '--:--';
                                    
                                    $cNombre   = $arr['cliente_nombre'] ?? $arr['CLIENTE_NOMBRE'] ?? '';
                                    $cApellido = $arr['cliente_apellido'] ?? $arr['CLIENTE_APELLIDO'] ?? '';
                                    $cliente   = trim($cNombre . ' ' . $cApellido);
                                    if (empty($cliente)) { $cliente = 'Cliente Registrado'; }

                                    $telefono  = $arr['cliente_telefono'] ?? $arr['CLIENTE_TELEFONO'] ?? '-';
                                    $servicio  = $arr['nombre_servicio'] ?? $arr['NOMBRE_SERVICIO'] ?? 'Tratamiento';
                                    
                                    $eNombre   = $arr['esp_nombre'] ?? $arr['ESP_NOMBRE'] ?? '';
                                    $eApellido = $arr['esp_apellido'] ?? $arr['ESP_APELLIDO'] ?? '';
                                    $espNombre = trim($eNombre . ' ' . $eApellido);
                                    if (empty($espNombre)) { $espNombre = 'Especialista'; }

                                    $box       = $arr['consultorio'] ?? $arr['CONSULTORIO'] ?? '-';
                                    $estado    = strtolower(trim($arr['estado'] ?? $arr['ESTADO'] ?? 'confirmado'));

                                    $badgeStyle = match($estado) {
                                        'confirmado'           => 'background-color: #d1e7dd; color: #0f5132;',
                                        'asistido'             => 'background-color: #cfe2ff; color: #084298;',
                                        'cancelado'            => 'background-color: #f8d7da; color: #842029;',
                                        'ausente'              => 'background-color: #fff3cd; color: #856404;',
                                        default                => 'background-color: #e2e3e5; color: #383d41;'
                                    };
                                    $estadoDisplay = ($estado === 'pendiente') ? 'ausente' : $estado;
                                ?>
                                <tr class="border-bottom" style="border-color: #f7f1ee;">
                                    <td class="ps-3 fw-semibold text-secondary small"><?= htmlspecialchars($fechaFmt); ?></td>
                                    <td class="fw-bold text-dark"><?= htmlspecialchars($horaFmt); ?></td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= htmlspecialchars($cliente); ?></div>
                                    </td>
                                    <td><small class="text-muted"><?= htmlspecialchars($telefono); ?></small></td>
                                    <td>
                                        <span class="badge rounded-pill fw-semibold" style="background-color: var(--caja-suave); color: var(--terracota-principal); border: 1px solid var(--borde-suave);">
                                            <?= htmlspecialchars($servicio); ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($espNombre); ?></td>
                                    <td><span class="badge bg-light text-secondary border"><?= htmlspecialchars($box); ?></span></td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-2 text-uppercase fw-semibold" style="font-size: 0.72rem; <?= $badgeStyle; ?>">
                                            <?= htmlspecialchars($estadoDisplay); ?>
                                        </span>
                                    </td>
                                    <td class="text-center pe-3">
                                        <form action="<?= $ruta; ?>admin/cambiarEstadoTurno" method="POST" class="d-inline-flex">
                                            <input type="hidden" name="id_turno" value="<?= $idTurno; ?>">
                                            <input type="hidden" name="fecha_origen" value="<?= htmlspecialchars($fechaFiltro); ?>">
                                            <input type="hidden" name="especialista_origen" value="<?= htmlspecialchars($especialistaFiltro ?? ''); ?>">
                                            <select name="estado" class="form-select form-select-sm shadow-none rounded-3" 
                                                    style="border-color: var(--borde-suave); font-size: 0.85rem;" 
                                                    onchange="this.form.submit()">
                                                <option value="confirmado" <?= ($estado === 'confirmado') ? 'selected' : ''; ?>>Confirmado</option>
                                                <option value="asistido" <?= ($estado === 'asistido') ? 'selected' : ''; ?>>Asistido</option>
                                                <option value="ausente" <?= ($estado === 'ausente' || $estado === 'pendiente') ? 'selected' : ''; ?>>Ausente</option>
                                                <option value="cancelado" <?= ($estado === 'cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- FOOTER INSTITUCIONAL -->
    <footer class="footer-canvas py-3 text-center small mt-auto border-top" style="border-color: var(--borde-suave) !important;">
        Bella Estética &copy; <?= date('Y'); ?> &bull; Panel de Gestión Administrativa
    </footer>

   <!-- MODAL: AGENDAR TURNO MANUAL -->
    <div class="modal fade" id="modalNuevoTurnoManual" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark">
                        <i class="bi bi-calendar-plus me-2" style="color: var(--terracota-principal);"></i>
                        Nuevo Turno Manual
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="formTurnoManual" action="<?= $ruta; ?>admin/agendarTurnoManual" method="POST">
                    <div class="modal-body px-4 pb-3">
                        <!-- 1. Cliente -->
                        <div class="mb-3">
                            <label for="selectCliente" class="form-label small fw-bold text-dark">Cliente *</label>
                            <select id="selectCliente" name="id_usuario" class="form-select rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                                <option value="" selected disabled>-- Seleccioná un cliente registrado --</option>
                                <?php foreach (($clientes ?? []) as $cli): ?>
                                    <?php $c = is_object($cli) ? (array)$cli : $cli; ?>
                                    <option value="<?= htmlspecialchars($c['id']); ?>">
                                        <?= htmlspecialchars(($c['apellido'] ?? '') . ', ' . ($c['nombre'] ?? '') . ' (' . ($c['email'] ?? '') . ')'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text small">
                                ¿Cliente nuevo? Crealo primero desde la pestaña <a href="<?= $ruta; ?>admin/usuarios" style="color: var(--terracota-principal);">Usuarios</a>.
                            </div>
                        </div>

                        <!-- 2. Servicio -->
                        <div class="mb-3">
                            <label for="selectServicioManual" class="form-label small fw-bold text-dark">Tratamiento / Servicio *</label>
                            <select id="selectServicioManual" name="id_servicio" class="form-select rounded-3 shadow-none" style="border-color: var(--borde-suave);" required onchange="cargarHorariosServicio(this)">
                                <option value="" selected disabled>-- Seleccioná un servicio --</option>
                                <?php foreach (($servicios ?? []) as $srv): ?>
                                    <?php 
                                        $s = is_object($srv) ? (array)$srv : $srv;
                                        if (($s['estado'] ?? 1) == 0) continue; // Solo servicios activos

                                        // Toma los horarios reales guardados en hora_inicio (ej: "10:30,13:00,16:30")
                                        $horariosStr = !empty($s['hora_inicio']) 
                                            ? $s['hora_inicio'] 
                                            : (!empty($s['horarios_disponibles']) ? $s['horarios_disponibles'] : '09:00,10:00,11:00,14:00,15:00,16:00,17:00');

                                        // Días de atención configurados (1 = Lun, 2 = Mar, ..., 6 = Sab)
                                        $diasStr = !empty($s['dias_atencion']) ? $s['dias_atencion'] : '1,2,3,4,5,6';

                                        // Toma el especialista independientemente de cómo lo devuelva ServiciosModel
                                        $espFull = trim($s['especialista_nombre'] ?? (($s['esp_nombre'] ?? '') . ' ' . ($s['esp_apellido'] ?? '')));
                                    ?>
                                    <option value="<?= htmlspecialchars($s['id']); ?>" data-horarios="<?= htmlspecialchars($horariosStr); ?>" data-dias="<?= htmlspecialchars($diasStr); ?>">
                                        <?= htmlspecialchars($s['nombre_servicio']); ?><?= !empty($espFull) ? ' — (Prof. ' . htmlspecialchars($espFull) . ')' : ''; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div id="infoDiasServicio" class="form-text small mt-1 text-muted d-none">
                                <i class="bi bi-calendar-check me-1" style="color: var(--terracota-principal);"></i>
                                <span id="textoInfoDias"></span>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- 3. Fecha -->
                            <div class="col-md-6">
                                <label for="fechaManual" class="form-label small fw-bold text-dark">Fecha *</label>
                                <input type="date" id="fechaManual" name="fecha" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);" min="<?= date('Y-m-d'); ?>" required>
                                <div id="alerta-dia-manual" class="alert alert-danger py-1 px-2 small mt-2 d-none align-items-center gap-1 rounded-3 border-0" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill text-danger me-1"></i>
                                    <span id="texto-alerta-dia"></span>
                                </div>
                            </div>

                            <!-- 4. Horario -->
                            <div class="col-md-6">
                                <label for="horaManual" class="form-label small fw-bold text-dark">Horario *</label>
                                <select id="horaManual" name="hora" class="form-select rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                                    <option value="" selected disabled>-- Elegí servicio --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top-0 px-4 pb-4">
                        <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn text-white fw-semibold rounded-3 px-4" style="background-color: var(--terracota-principal);">
                            Confirmar Turno
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        const DIAS_SEMANA_MAP = {
            1: 'Lunes',
            2: 'Martes',
            3: 'Miércoles',
            4: 'Jueves',
            5: 'Viernes',
            6: 'Sábado',
            0: 'Domingo'
        };

        function formatearTextoDias(diasStr) {
            if (!diasStr || diasStr === '1,2,3,4,5,6') return 'Lunes a Sábado';
            if (diasStr === '1,2,3,4,5') return 'Lunes a Viernes';
            const partes = diasStr.split(',').map(d => d.trim()).filter(Boolean);
            if (partes.length === 0) return 'Sin días configurados';
            return partes.map(d => DIAS_SEMANA_MAP[d] || d).join(', ');
        }

        function validarDiaAtencionServicio() {
            const selectServicio = document.getElementById('selectServicioManual');
            const inputFecha = document.getElementById('fechaManual');
            const alertaDia = document.getElementById('alerta-dia-manual');
            const textoAlerta = document.getElementById('texto-alerta-dia');

            if (!inputFecha || !alertaDia || !textoAlerta) return true;

            const fechaVal = inputFecha.value;
            if (!fechaVal) {
                inputFecha.classList.remove('is-invalid');
                alertaDia.classList.add('d-none');
                alertaDia.classList.remove('d-flex');
                return true;
            }

            // Desglosar año, mes, día para evitar desfases de zona horaria UTC
            const partes = fechaVal.split('-');
            if (partes.length !== 3) return true;
            const fechaObj = new Date(parseInt(partes[0], 10), parseInt(partes[1], 10) - 1, parseInt(partes[2], 10));
            const diaSemana = fechaObj.getDay(); // 0 = Domingo, 1 = Lunes, ..., 6 = Sábado

            if (diaSemana === 0) {
                inputFecha.classList.add('is-invalid');
                textoAlerta.textContent = 'El centro no atiende los domingos. Por favor seleccioná otro día.';
                alertaDia.classList.remove('d-none');
                alertaDia.classList.add('d-flex');
                return false;
            }

            if (!selectServicio || selectServicio.selectedIndex <= 0) {
                inputFecha.classList.remove('is-invalid');
                alertaDia.classList.add('d-none');
                alertaDia.classList.remove('d-flex');
                return true;
            }

            const option = selectServicio.options[selectServicio.selectedIndex];
            const diasRaw = option.getAttribute('data-dias') || '1,2,3,4,5,6';
            const diasPermitidos = diasRaw.split(',').map(d => d.trim());

            if (!diasPermitidos.includes(String(diaSemana))) {
                inputFecha.classList.add('is-invalid');
                const diaNombre = DIAS_SEMANA_MAP[diaSemana] || 'el día seleccionado';
                const diasTexto = formatearTextoDias(diasRaw);
                textoAlerta.textContent = `El especialista no atiende los ${diaNombre}. Días de atención: ${diasTexto}.`;
                alertaDia.classList.remove('d-none');
                alertaDia.classList.add('d-flex');
                return false;
            }

            inputFecha.classList.remove('is-invalid');
            alertaDia.classList.add('d-none');
            alertaDia.classList.remove('d-flex');
            return true;
        }

        function cargarHorariosServicio(selectElem) {
            const option = selectElem.options[selectElem.selectedIndex];
            const horariosRaw = option.getAttribute('data-horarios') || '09:00,10:00,11:00,14:00,15:00,16:00,17:00';
            const diasRaw = option.getAttribute('data-dias') || '1,2,3,4,5,6';
            const listaHoras = horariosRaw.split(',');
            const selectHora = document.getElementById('horaManual');

            // Mostrar días de atención del servicio
            const infoDias = document.getElementById('infoDiasServicio');
            const textoInfoDias = document.getElementById('textoInfoDias');
            if (infoDias && textoInfoDias) {
                textoInfoDias.textContent = 'Días de atención del especialista: ' + formatearTextoDias(diasRaw);
                infoDias.classList.remove('d-none');
            }

            selectHora.innerHTML = '<option value="" selected disabled>-- Elegí hora --</option>';

            listaHoras.forEach(h => {
                const limpia = h.trim().substring(0, 5);
                if (limpia) {
                    const opt = document.createElement('option');
                    opt.value = limpia + ':00';
                    opt.textContent = limpia + ' hs';
                    selectHora.appendChild(opt);
                }
            });

            // Revalidar en caso de que ya se haya elegido una fecha antes de cambiar el servicio
            validarDiaAtencionServicio();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const inputFecha = document.getElementById('fechaManual');
            if (inputFecha) {
                inputFecha.addEventListener('change', validarDiaAtencionServicio);
                inputFecha.addEventListener('input', validarDiaAtencionServicio);
            }

            const formManual = document.getElementById('formTurnoManual');
            if (formManual) {
                formManual.addEventListener('submit', function(e) {
                    if (!validarDiaAtencionServicio()) {
                        e.preventDefault();
                        e.stopPropagation();
                        const inputF = document.getElementById('fechaManual');
                        if (inputF) inputF.focus();
                        return false;
                    }
                });
            }

            // Al cerrar el modal, resetear advertencias visuales
            const modalEl = document.getElementById('modalNuevoTurnoManual');
            if (modalEl) {
                modalEl.addEventListener('hidden.bs.modal', function() {
                    const alertaDia = document.getElementById('alerta-dia-manual');
                    const inputFecha = document.getElementById('fechaManual');
                    const infoDias = document.getElementById('infoDiasServicio');
                    if (alertaDia) {
                        alertaDia.classList.add('d-none');
                        alertaDia.classList.remove('d-flex');
                    }
                    if (inputFecha) inputFecha.classList.remove('is-invalid');
                    if (infoDias) infoDias.classList.add('d-none');
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Evita que al dar 'Atrás' en el navegador tras cerrar sesión se visualice la sesión abierta
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || (window.performance && window.performance.getEntriesByType("navigation")[0]?.type === "back_forward")) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>