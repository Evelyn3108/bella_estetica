<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios y Cuentas - Bella Estética</title>
    <link rel="stylesheet" href="<?= $ruta; ?>css/estilos.css?v=29">
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
                        <a class="nav-link nav-link-custom fw-semibold" href="<?= $ruta; ?>admin/especialistas">
                            <i class="bi bi-person-badge me-1"></i> Especialistas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active fw-bold border-bottom border-2 pb-1" style="border-color: var(--terracota-principal) !important; color: var(--terracota-principal) !important;" href="<?= $ruta; ?>admin/usuarios">
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

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container-fluid px-4 mb-5 flex-grow-1">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gy-2">
            <div>
                <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Cuentas y Usuarios</h3>
                <p class="text-muted small mb-0">Gestión de cuentas con acceso al sistema y roles asignados.</p>
            </div>
            <button class="btn-solid-terracota py-2 px-3 small rounded-3 shadow-sm d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalUsuario">
                <i class="bi bi-person-plus"></i> Nuevo Usuario
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--borde-suave) !important;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f6f1ee; color: var(--texto-oscuro);">
                        <tr class="small text-uppercase border-bottom" style="border-color: var(--borde-suave);">
                            <th class="py-3 ps-3">ID</th>
                            <th>Usuario</th>
                            <th>Correo Electrónico</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Fecha de Registro</th>
                            <th class="text-center pe-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($usuarios)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2 opacity-50" style="color: var(--terracota-principal);"></i>
                                    No se encontraron cuentas de usuario registradas.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($usuarios as $u): ?>
                                <?php 
                                    $arr = is_object($u) ? (array)$u : (is_array($u) ? $u : []);
                                    $idUser = $arr['id'] ?? $arr['id_usuario'] ?? 0;
                                    $nom    = $arr['nombre'] ?? '';
                                    $ape    = $arr['apellido'] ?? '';
                                    $email  = $arr['email'] ?? '-';
                                    $tel    = $arr['telefono'] ?? '-';
                                    $rol    = strtolower($arr['rol'] ?? 'cliente');
                                    $esAdmin = ($rol === 'administrador');

                                    // Lectura directa de fecha_alta según phpMyAdmin
                                    $fechaRaw = $arr['fecha_alta'] ?? null;
                                    if (!empty($fechaRaw) && $fechaRaw !== '0000-00-00 00:00:00') {
                                        $fechaReg = date('d/m/Y', strtotime($fechaRaw));
                                    } else {
                                        $fechaReg = 'Registrado';
                                    }

                                    $idAdminActual = $_SESSION['USER']['id_usuario'] ?? 1;
                                ?>
                                <tr class="border-bottom" style="border-color: #f7f1ee;">
                                    <td class="ps-3 text-muted small fw-semibold">#<?= $idUser; ?></td>
                                    <td class="fw-semibold text-dark"><?= htmlspecialchars(trim($nom . ' ' . $ape)); ?></td>
                                    <td><?= htmlspecialchars($email); ?></td>
                                    <td><small class="text-muted"><?= htmlspecialchars($tel ?: '-'); ?></small></td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-2 text-uppercase fw-semibold" 
                                              style="font-size: 0.7rem; <?= $esAdmin ? 'background-color: var(--caja-suave); color: var(--terracota-principal); border: 1px solid var(--borde-suave);' : 'background-color: #e2e3e5; color: #41464b;'; ?>">
                                            <?= htmlspecialchars($rol); ?>
                                        </span>
                                    </td>
                                    <td><small class="text-secondary"><?= $fechaReg; ?></small></td>
                                    <td class="text-center pe-3">
                                        <div class="d-inline-flex gap-1">
                                            <!-- Botón Editar -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-secondary rounded-3" 
                                                    title="Modificar datos"
                                                    onclick="cargarDatosEditar(<?= $idUser; ?>, '<?= htmlspecialchars(addslashes($nom)); ?>', '<?= htmlspecialchars(addslashes($ape)); ?>', '<?= htmlspecialchars(addslashes($email)); ?>', '<?= htmlspecialchars(addslashes($tel)); ?>', '<?= $rol; ?>')">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <?php if ((int)$idUser !== (int)$idAdminActual): ?>
                                                <a href="<?= $ruta; ?>admin/eliminarUsuario?id=<?= $idUser; ?>" 
                                                   class="btn btn-sm btn-outline-danger rounded-3" 
                                                   title="Eliminar usuario"
                                                   onclick="return confirm('¿Confirmás la eliminación del usuario <?= htmlspecialchars(addslashes($nom . ' ' . $ape)); ?>?');">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-outline-light text-muted border-0" disabled title="No podés eliminar tu propia cuenta">
                                                    <i class="bi bi-shield-lock"></i>
                                                </button>
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

    <!-- MODAL 1: CREAR NUEVO USUARIO -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="<?= $ruta; ?>admin/guardarUsuario" method="POST">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="fw-bold text-dark mb-0" id="modalUsuarioLabel">Crear Nueva Cuenta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2 mb-3 text-start">
                            <div class="col-6">
                                <label for="nombre_usr" class="form-label small fw-bold">Nombre *</label>
                                <input type="text" id="nombre_usr" name="nombre" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                            </div>
                            <div class="col-6">
                                <label for="apellido_usr" class="form-label small fw-bold">Apellido *</label>
                                <input type="text" id="apellido_usr" name="apellido" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                            </div>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="email_usr" class="form-label small fw-bold">Correo Electrónico *</label>
                            <input type="email" id="email_usr" name="email" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);" placeholder="correo@ejemplo.com" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="telefono_usr" class="form-label small fw-bold">Teléfono de Contacto</label>
                            <input type="tel" id="telefono_usr" name="telefono" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);" placeholder="Ej: 3415987632">
                        </div>
                        <div class="row g-2 mb-2 text-start">
                            <div class="col-6">
                                <label for="pass_usr" class="form-label small fw-bold">Contraseña *</label>
                                <input type="password" id="pass_usr" name="password" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                            </div>
                            <div class="col-6">
                                <label for="rol_usr" class="form-label small fw-bold">Rol de Acceso *</label>
                                <select id="rol_usr" name="rol" class="form-select rounded-3 shadow-none" style="border-color: var(--borde-suave);">
                                    <option value="cliente" selected>Cliente</option>
                                    <option value="administrador">Administrador</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary rounded-3 small" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn-solid-terracota py-2 px-3 rounded-3 small shadow-sm">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 2: EDITAR USUARIO -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow p-2 p-md-3">
                <form action="<?= $ruta; ?>admin/actualizarUsuario" method="POST">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="modal-header border-bottom-0 pb-2 px-3">
                        <h5 class="fw-bold text-dark mb-0" id="modalEditarUsuarioLabel">Modificar Datos de Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body px-3 py-2">
                        <!-- Nombre y Apellido -->
                        <div class="row g-2 mb-3 text-start">
                            <div class="col-6">
                                <label for="edit_nombre" class="form-label small fw-bold text-dark mb-1">Nombre *</label>
                                <input type="text" id="edit_nombre" name="nombre" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                            </div>
                            <div class="col-6">
                                <label for="edit_apellido" class="form-label small fw-bold text-dark mb-1">Apellido *</label>
                                <input type="text" id="edit_apellido" name="apellido" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                            </div>
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="mb-3 text-start">
                            <label for="edit_email" class="form-label small fw-bold text-dark mb-1">Correo Electrónico *</label>
                            <input type="email" id="edit_email" name="email" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);" required>
                        </div>

                        <!-- Teléfono y Rol -->
                        <div class="row g-2 mb-3 text-start">
                            <div class="col-7">
                                <label for="edit_telefono" class="form-label small fw-bold text-dark mb-1">Teléfono de Contacto</label>
                                <input type="tel" id="edit_telefono" name="telefono" class="form-control rounded-3 shadow-none" style="border-color: var(--borde-suave);">
                            </div>
                            <div class="col-5">
                                <label for="edit_rol" class="form-label small fw-bold text-dark mb-1">Rol *</label>
                                <select id="edit_rol" name="rol" class="form-select rounded-3 shadow-none" style="border-color: var(--borde-suave);">
                                    <option value="cliente">Cliente</option>
                                    <option value="administrador">Administrador</option>
                                </select>
                            </div>
                        </div>

                        <!-- Sección de Contraseña Ajustada -->
                        <div class="border-top pt-3 mt-2 text-start" style="border-color: var(--borde-suave) !important;">
                            <label for="edit_pass" class="form-label small fw-bold text-dark mb-1">
                                Cambiar Contraseña <span class="text-muted fw-normal">(opcional)</span>
                            </label>
                            
                            <div class="input-group mb-1">
                                <span class="input-group-text bg-light text-muted rounded-start-3" style="border-color: var(--borde-suave); border-right: none;">
                                    <i class="bi bi-key"></i>
                                </span>
                                <input type="password" 
                                       id="edit_pass" 
                                       name="password" 
                                       class="form-control rounded-end-3 shadow-none" 
                                       style="border-color: var(--borde-suave); border-left: none;" 
                                       placeholder="Dejar en blanco para mantener la actual">
                            </div>
                            
                            <small class="text-muted d-block mt-1" style="font-size: 0.75rem; line-height: 1.35;">
                                Si escribís una contraseña aquí, se reemplazará la del usuario. Si lo dejás vacío, no se modifica.
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer border-top-0 pt-3 px-3 d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary rounded-3 px-3 py-2 small fw-semibold" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn-solid-terracota py-2 px-4 rounded-3 small fw-semibold shadow-sm">
                            Guardar Cambios
                        </button>
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

    <!-- SCRIPT PARA POBLAR EL MODAL DE EDICIÓN -->
    <script>
        function cargarDatosEditar(id, nombre, apellido, email, telefono, rol) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('edit_apellido').value = apellido;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_telefono').value = (telefono === '-') ? '' : telefono;
            document.getElementById('edit_rol').value = rol;
            document.getElementById('edit_pass').value = ''; // Se limpia siempre por seguridad

            const modalEdicion = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
            modalEdicion.show();
        }
    </script>
</body>
</html>