<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Especialistas - Bella Estética</title>
    <link rel="stylesheet" href="<?= $ruta; ?>css/estilos.css?v=27">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR ADMINISTRADOR UNIFICADO -->
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
                            <i class="bi bi-calendar3 me-1"></i> Agenda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom fw-semibold" href="<?= $ruta; ?>admin/servicios">
                            <i class="bi bi-card-checklist me-1"></i> Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active fw-bold border-bottom border-2 pb-1" style="border-color: var(--terracota-principal) !important; color: var(--terracota-principal) !important;" href="<?= $ruta; ?>admin/especialistas">
                            <i class="bi bi-person-badge me-1"></i> Especialistas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom fw-semibold" href="<?= $ruta; ?>admin/usuarios">
                            <i class="bi bi-people me-1"></i> Usuarios
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

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container-fluid px-4 mb-5 flex-grow-1">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gy-2">
            <div>
                <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Equipo Profesional</h3>
                <p class="text-muted small mb-0">Gestión de especialistas y profesionales del salón.</p>
            </div>
            <button class="btn-solid-terracota py-2 px-3 small rounded-3 shadow-sm d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEspecialista">
                <i class="bi bi-plus-circle"></i> Nuevo Especialista
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--borde-suave) !important;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f6f1ee; color: var(--texto-oscuro);">
                        <tr class="small text-uppercase border-bottom" style="border-color: var(--borde-suave);">
                            <th class="py-3 ps-3">ID</th>
                            <th>Nombre Completo</th>
                            <th>Especialidad</th>
                            <th>Estado</th>
                            <th class="text-center pe-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($especialistas)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-person-x fs-1 d-block mb-2 opacity-50" style="color: var(--terracota-principal);"></i>
                                    No hay especialistas registrados en el sistema.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($especialistas as $e): ?>
                                <?php 
                                    $arr = (array)$e; 
                                    $idEsp    = $arr['id'] ?? 0;
                                    $nombre   = htmlspecialchars(trim(($arr['nombre'] ?? '') . ' ' . ($arr['apellido'] ?? '')));
                                    $espe     = htmlspecialchars($arr['especialidad'] ?? 'General');
                                    // Comprobación de estado compatible con 'estado' y 'estado_logico'
                                    $estadoVal = (int)($arr['estado'] ?? $arr['estado_logico'] ?? 1);
                                    $esActivo  = ($estadoVal === 1);
                                ?>
                                <tr class="border-bottom <?= !$esActivo ? 'opacity-50 bg-light' : ''; ?>" style="border-color: #f7f1ee;">
                                    <td class="ps-3 text-muted small fw-semibold">#<?= $idEsp; ?></td>
                                    <td class="fw-semibold text-dark"><?= $nombre; ?></td>
                                    <td>
                                        <span class="badge bg-light text-secondary border">
                                            <?= $espe; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-2 text-uppercase fw-semibold" 
                                              style="font-size: 0.7rem; <?= $esActivo ? 'background-color: #d1e7dd; color: #0f5132;' : 'background-color: #f8d7da; color: #842029;'; ?>">
                                            <?= $esActivo ? 'Activo' : 'Inactivo'; ?>
                                        </span>
                                    </td>
                                    <td class="text-center pe-3">
                                        <div class="d-inline-flex gap-1">
                                            <!-- Botón 1: Alternar Estado (Activar / Desactivar) -->
                                            <?php if ($esActivo): ?>
                                                <a href="<?= $ruta; ?>admin/bajaEspecialista?id=<?= $idEsp; ?>&estado=0" 
                                                   class="btn btn-sm btn-outline-secondary rounded-3" 
                                                   title="Desactivar especialista">
                                                    <i class="bi bi-slash-circle"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= $ruta; ?>admin/bajaEspecialista?id=<?= $idEsp; ?>&estado=1" 
                                                   class="btn btn-sm btn-outline-success rounded-3" 
                                                   title="Reactivar especialista">
                                                    <i class="bi bi-check-circle"></i>
                                                </a>
                                            <?php endif; ?>

                                            <!-- Botón 2: Eliminar definitivamente -->
                                            <a href="<?= $ruta; ?>admin/eliminarEspecialista?id=<?= $idEsp; ?>" 
                                               class="btn btn-sm btn-outline-danger rounded-3" 
                                               title="Eliminar especialista"
                                               onclick="return confirm('¿Confirmás la eliminación definitiva de <?= htmlspecialchars(addslashes($nomEsp)); ?>?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
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

    <!-- MODAL NUEVO ESPECIALISTA -->
    <div class="modal fade" id="modalEspecialista" tabindex="-1" aria-labelledby="modalEspecialistaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="<?= $ruta; ?>admin/guardarEspecialista" method="POST">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="fw-bold text-dark mb-0" id="modalEspecialistaLabel">Alta de Especialista</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 text-start">
                            <label for="nombre" class="form-label small fw-bold">Nombre *</label>
                            <input type="text" id="nombre" name="nombre" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="apellido" class="form-label small fw-bold">Apellido *</label>
                            <input type="text" id="apellido" name="apellido" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="especialidad" class="form-label small fw-bold">Especialidad *</label>
                            <input type="text" id="especialidad" name="especialidad" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);" placeholder="Ej: Cosmetología, Masoterapia, Uñas" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary rounded-3 small" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn-solid-terracota py-2 px-3 rounded-3 small shadow-sm">Guardar Especialista</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FOOTER INSTITUCIONAL -->
    <footer class="footer-canvas py-3 text-center small mt-auto border-top" style="border-color: var(--borde-suave) !important;">
        Bella Estética &copy; <?= date('Y'); ?> &bull; Panel de Gestión Administrativa
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>