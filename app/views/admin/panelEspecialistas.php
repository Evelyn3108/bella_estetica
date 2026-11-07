<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Especialistas - Bella Estética</title>
    <link rel="stylesheet" href="<?= $ruta; ?>css/estilos.css?v=26">
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
            <div class="collapse navbar-collapse" id="navAdmin">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-2">
                    <li class="nav-item"><a class="nav-link nav-link-custom fw-semibold" href="<?= $ruta; ?>admin/panel"><i class="bi bi-calendar3 me-1"></i> Agenda</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom fw-semibold" href="<?= $ruta; ?>admin/servicios"><i class="bi bi-card-checklist me-1"></i> Servicios</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom active fw-bold border-bottom border-2 pb-1" style="border-color: var(--terracota-principal) !important; color: var(--terracota-principal) !important;" href="<?= $ruta; ?>admin/especialistas"><i class="bi bi-person-badge me-1"></i> Especialistas</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom fw-semibold" href="<?= $ruta; ?>admin/usuarios"><i class="bi bi-people me-1"></i> Usuarios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container-fluid px-4 mb-5 flex-grow-1">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">Equipo Profesional</h3>
                <p class="text-muted small mb-0">Gestión de especialistas y profesionales del salón.</p>
            </div>
            <button class="btn-solid-terracota py-2 px-3 small rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEspecialista">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Especialista
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--borde-suave) !important;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f6f1ee; color: var(--texto-oscuro);">
                        <tr class="small text-uppercase border-bottom">
                            <th class="py-3 ps-3">ID</th>
                            <th>Nombre Completo</th>
                            <th>Especialidad</th>
                            <th>Estado</th>
                            <th class="text-center pe-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($especialistas as $e): ?>
                            <?php 
                                $arr = (array)$e; 
                                $esActivo = ((int)($arr['estado_logico'] ?? 1) === 1);
                            ?>
                            <tr class="border-bottom <?= !$esActivo ? 'opacity-50 bg-light' : ''; ?>">
                                <td class="ps-3 text-muted small fw-semibold">#<?= $arr['id']; ?></td>
                                <td class="fw-semibold text-dark"><?= htmlspecialchars($arr['nombre'] . ' ' . $arr['apellido']); ?></td>
                                <td><span class="badge bg-light text-secondary border"><?= htmlspecialchars($arr['especialidad'] ?? 'General'); ?></span></td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 text-uppercase fw-semibold" style="font-size: 0.7rem; <?= $esActivo ? 'background-color: #d1e7dd; color: #0f5132;' : 'background-color: #f8d7da; color: #842029;'; ?>">
                                        <?= $esActivo ? 'Activo' : 'Inactivo'; ?>
                                    </span>
                                </td>
                                <td class="text-center pe-3">
                                    <?php if ($esActivo): ?>
                                        <a href="<?= $ruta; ?>admin/bajaEspecialista?id=<?= $arr['id']; ?>&estado=0" class="btn btn-sm btn-outline-danger" title="Dar de baja">
                                            <i class="bi bi-slash-circle"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= $ruta; ?>admin/bajaEspecialista?id=<?= $arr['id']; ?>&estado=1" class="btn btn-sm btn-outline-success" title="Reactivar">
                                            <i class="bi bi-check-circle"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Nuevo Especialista -->
    <div class="modal fade" id="modalEspecialista" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="<?= $ruta; ?>admin/guardarEspecialista" method="POST">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-bold text-dark">Alta de Especialista</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="nombre" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Apellido *</label>
                            <input type="text" name="apellido" class="form-control rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Especialidad *</label>
                            <input type="text" name="especialidad" class="form-control rounded-3" placeholder="Ej: Cosmetología, Masoterapia" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn-solid-terracota py-2 px-3 rounded-3">Guardar Especialista</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>