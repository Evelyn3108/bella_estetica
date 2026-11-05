<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Servicios - Bella Estética</title>
    <link rel="stylesheet" href="<?= $ruta; ?>css/estilos.css?v=22">
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

    <!-- CONTENEDOR PRINCIPAL -->
    <main class="container-fluid px-4 mb-5 flex-grow-1">
        
        <!-- ENCABEZADO Y BOTÓN DE ALTA -->
        <div class="row align-items-center mb-4 gy-3">
            <div class="col-md-7">
                <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Catálogo de Servicios</h3>
                <p class="text-muted small mb-0">Control de tratamientos, tarifas, consultorios y estado de publicación.</p>
            </div>
            
            <div class="col-md-5 text-md-end">
                <a href="<?= $ruta; ?>admin/formServicio" class="btn-solid-terracota py-2 px-3 small text-decoration-none shadow-sm rounded-3 d-inline-flex align-items-center gap-1">
                    <i class="bi bi-plus-circle"></i> Nuevo Servicio
                </a>
            </div>
        </div>

        <!-- TABLA DE SERVICIOS -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--borde-suave) !important;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f6f1ee; color: var(--texto-oscuro);">
                        <tr class="small text-uppercase border-bottom" style="border-color: var(--borde-suave);">
                            <th class="py-3 ps-3">ID</th>
                            <th class="py-3">Tratamiento</th>
                            <th class="py-3">Especialista</th>
                            <th class="py-3">Consultorio</th>
                            <th class="py-3">Duración</th>
                            <th class="py-3">Precio</th>
                            <th class="py-3">Horario</th>
                            <th class="py-3">Estado</th>
                            <th class="py-3 text-center pe-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($servicios)): ?>
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-card-heading fs-1 d-block mb-2 opacity-50" style="color: var(--terracota-principal);"></i>
                                    No hay servicios registrados en la base de datos.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($servicios as $s): ?>
                                <?php 
                                    $arr = is_object($s) ? (array) $s : (is_array($s) ? $s : []);
                                    
                                    $idServicio = $arr['id'] ?? 0;
                                    $nombreServ = $arr['nombre_servicio'] ?? 'Servicio';
                                    $espNombre  = trim(($arr['esp_nombre'] ?? '') . ' ' . ($arr['esp_apellido'] ?? ''));
                                    if (empty($espNombre)) { $espNombre = 'Sin asignar'; }
                                    
                                    $consultorio = $arr['consultorio'] ?? '-';
                                    $duracion    = ($arr['duracion'] ?? '45') . ' min';
                                    $precio      = number_format((float)($arr['precio'] ?? 0), 2, ',', '.');
                                    
                                    $hInicio     = !empty($arr['hora_inicio']) ? substr($arr['hora_inicio'], 0, 5) : '09:00';
                                    $hFin        = !empty($arr['hora_fin']) ? substr($arr['hora_fin'], 0, 5) : '18:00';
                                    $horarioFmt  = $hInicio . ' a ' . $hFin . ' hs';

                                    // Estado lógico (1: Activo, 0: Inactivo)
                                    $estadoLogico = (int)($arr['estado'] ?? $arr['estado_logico'] ?? 1);
                                    $esActivo     = ($estadoLogico === 1);
                                ?>
                                <tr class="border-bottom <?= !$esActivo ? 'opacity-50 bg-light' : ''; ?>" style="border-color: #f7f1ee;">
                                    <td class="ps-3 text-muted small fw-semibold">#<?= htmlspecialchars($idServicio); ?></td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= htmlspecialchars($nombreServ); ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-secondary border">
                                            <i class="bi bi-person me-1"></i><?= htmlspecialchars($espNombre); ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($consultorio); ?></td>
                                    <td><small class="text-muted"><?= htmlspecialchars($duracion); ?></small></td>
                                    <td class="fw-bold" style="color: var(--terracota-principal);">$<?= htmlspecialchars($precio); ?></td>
                                    <td><small class="text-secondary"><?= htmlspecialchars($horarioFmt); ?></small></td>
                                    <td>
                                        <?php if ($esActivo): ?>
                                            <span class="badge rounded-pill px-3 py-2 text-uppercase fw-semibold" style="font-size: 0.7rem; background-color: #d1e7dd; color: #0f5132;">
                                                Activo
                                            </span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill px-3 py-2 text-uppercase fw-semibold" style="font-size: 0.7rem; background-color: #f8d7da; color: #842029;">
                                                Inactivo
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center pe-3">
                                        <div class="btn-group btn-group-sm">
                                            <!-- Editar -->
                                            <a href="<?= $ruta; ?>admin/formServicio?id=<?= $idServicio; ?>" 
                                               class="btn btn-outline-secondary rounded-start-3" 
                                               title="Modificar servicio">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <!-- Baja / Alta lógica -->
                                            <?php if ($esActivo): ?>
                                                <a href="<?= $ruta; ?>admin/bajaServicio?id=<?= $idServicio; ?>&estado=0" 
                                                   class="btn btn-outline-danger rounded-end-3" 
                                                   title="Desactivar servicio (Baja lógica)"
                                                   onclick="return confirm('¿Desactivar este servicio? No se eliminarán los turnos históricos vinculados.');">
                                                    <i class="bi bi-slash-circle"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= $ruta; ?>admin/bajaServicio?id=<?= $idServicio; ?>&estado=1" 
                                                   class="btn btn-outline-success rounded-end-3" 
                                                   title="Reactivar servicio"
                                                   onclick="return confirm('¿Volver a activar este servicio en el catálogo?');">
                                                    <i class="bi bi-check-circle"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="footer-canvas py-3 text-center small mt-auto border-top" style="border-color: var(--borde-suave) !important;">
        Bella Estética &copy; <?= date('Y'); ?> &bull; Panel de Gestión Administrativa
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>