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
                </form>
            </div>
        </div>

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