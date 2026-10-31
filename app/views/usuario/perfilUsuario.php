<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Bella Estética</title>
    <!-- Único archivo de estilos enlazado (contiene Bootstrap, iconos y variables terracota) -->
    <link rel="stylesheet" href="<?= $ruta; ?>css/estilos.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 mb-4">
        <div class="container" style="max-width: 1050px;">
            <a class="navbar-brand d-flex align-items-center text-dark text-decoration-none gap-2 fw-bold" href="<?= $ruta; ?>home/homeServicios">
                <i class="bi bi-flower1 fs-3" style="color: var(--terracota-principal, #a05a42);"></i>
                <span>BELLA ESTÉTICA</span>
            </a>
            <div class="ms-auto d-flex gap-3 align-items-center">
                <a href="<?= $ruta; ?>home/homeServicios" class="text-secondary small text-decoration-none">
                    <i class="bi bi-grid me-1"></i> Catálogo de Servicios
                </a>
                <a href="<?= $ruta; ?>user/perfilUsuario" class="fw-bold small text-decoration-none" style="color: var(--terracota-principal, #a05a42);">
                    <i class="bi bi-person-circle me-1"></i> Mi Perfil
                </a>
                <a href="<?= $ruta; ?>account/salir" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                    Cerrar Sesión
                </a>
            </div>
        </div>
    </nav>

    <!-- CONTENEDOR PRINCIPAL -->
    <main class="container mb-5 flex-grow-1" style="max-width: 1050px;">

        <!-- ALERTAS DE ESTADO -->
        <?php if (!empty($reservaOk)): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> ¡Turno agendado con éxito! Podés revisarlo en tus próximas citas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['cancelado']) && $_GET['cancelado'] === 'ok'): ?>
            <div class="alert alert-warning alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i> El turno fue cancelado y se movió al historial.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['datos']) && $_GET['datos'] === 'ok'): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> Datos de contacto actualizados correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($passwordOk)): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <i class="bi bi-shield-check me-2"></i> Tu contraseña se actualizó correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error_pass'])): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php 
                    if ($_GET['error_pass'] === 'actual') echo "La contraseña actual es incorrecta.";
                    elseif ($_GET['error_pass'] === 'coincidencia') echo "Las nuevas contraseñas no coinciden.";
                    elseif ($_GET['error_pass'] === 'formato') echo "La contraseña debe tener entre 8 y 15 caracteres, al menos una mayúscula, un número y un símbolo especial.";
                    else echo "Ocurrió un error al actualizar la contraseña.";
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- CABECERA DE USUARIO -->
        <div class="card border-0 rounded-4 shadow-sm p-4 mb-4 bg-white d-flex flex-row align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold fs-3" 
                 style="width: 60px; height: 60px; background-color: var(--terracota-principal, #a05a42);">
                <?= strtoupper(substr($usuario['nombre'] ?: ($usuario['email'] ?? 'U'), 0, 1)); ?>
            </div>
            <div>
                <h4 class="fw-bold mb-0 text-dark"><?= htmlspecialchars(trim(($usuario['nombre'] ?? '') . ' ' . ($usuario['apellido'] ?? '')) ?: 'Mi Perfil'); ?></h4>
                <small class="text-muted"><i class="bi bi-envelope me-1"></i><?= htmlspecialchars($usuario['email'] ?? ''); ?></small>
            </div>
        </div>

        <!-- PESTAÑAS (TABS) -->
        <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
            <div class="card-header bg-white border-bottom pt-3 px-4">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-turnos" type="button">
                            <i class="bi bi-calendar-check me-2"></i>Turnos Agendados
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-historial" type="button">
                            <i class="bi bi-clock-history me-2"></i>Historial
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-cuenta" type="button">
                            <i class="bi bi-person-gear me-2"></i>Mi Cuenta & Seguridad
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4 tab-content">

                <!-- 1. PESTAÑA: TURNOS AGENDADOS -->
                <div class="tab-pane fade show active" id="tab-turnos">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark mb-0">Próximas citas</h6>
                        <a href="<?= $ruta; ?>home/homeServicios" class="btn btn-sm btn-outline-secondary rounded-pill px-3">+ Agendar nuevo</a>
                    </div>

                    <?php if (empty($turnosActivos)): ?>
                        <p class="text-center text-muted py-4 small">No tenés turnos programados por el momento.</p>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($turnosActivos as $t): ?>
                                <?php
                                    $arr = is_object($t) ? get_object_vars($t) : (is_array($t) ? $t : []);
                                    if (empty($arr)) continue;

                                    $nombreServ = $arr['nombre_servicio'] ?? 'Servicio Estético';
                                    $consul     = $arr['consultorio'] ?? 'Consultorio';
                                    $espNombre  = trim(($arr['esp_nombre'] ?? '') . ' ' . ($arr['esp_apellido'] ?? ''));
                                    $horaVal    = $arr['hora'] ?? '';
                                    $fechaVal   = $arr['fecha'] ?? '';
                                    $horaFmt    = !empty($horaVal) ? substr($horaVal, 0, 5) . ' hs' : '--:-- hs';
                                    $fechaFmt   = !empty($fechaVal) ? date('d/m/Y', strtotime($fechaVal)) : '--/--/----';
                                    $estadoVal  = strtolower($arr['estado'] ?? 'pendiente');
                                    $idTurno    = $arr['id'] ?? 0;
                                ?>
                                <div class="p-3 rounded-3 border bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($nombreServ); ?></h6>
                                        <div class="text-muted small d-flex flex-wrap gap-3">
                                            <?php if (!empty($espNombre)): ?>
                                                <span><i class="bi bi-person me-1" style="color: var(--terracota-principal, #a05a42);"></i><?= htmlspecialchars($espNombre); ?></span>
                                            <?php endif; ?>
                                            <span><i class="bi bi-geo-alt me-1" style="color: var(--terracota-principal, #a05a42);"></i><?= htmlspecialchars($consul); ?></span>
                                            <span><i class="bi bi-clock me-1" style="color: var(--terracota-principal, #a05a42);"></i><?= htmlspecialchars($horaFmt); ?></span>
                                            <span><i class="bi bi-calendar-event me-1" style="color: var(--terracota-principal, #a05a42);"></i><?= htmlspecialchars($fechaFmt); ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge rounded-pill bg-warning text-dark px-3 py-2 text-uppercase" style="font-size: 0.72rem;">
                                            <?= htmlspecialchars($estadoVal); ?>
                                        </span>
                                        <a href="<?= $ruta; ?>turnos/cancelar?id=<?= $idTurno; ?>" 
                                           class="btn btn-outline-danger btn-sm rounded-pill px-3" 
                                           onclick="return confirm('¿Seguro que deseas cancelar este turno?');">
                                            Cancelar
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- 2. PESTAÑA: HISTORIAL -->
                <div class="tab-pane fade" id="tab-historial">
                    <?php if (empty($historial)): ?>
                        <p class="text-center text-muted py-4 small">No hay turnos registrados en el historial todavía.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small text-uppercase text-muted">
                                    <tr>
                                        <th>Servicio</th>
                                        <th>Especialista</th>
                                        <th>Consultorio</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historial as $h): ?>
                                        <?php 
                                            $arrH = is_object($h) ? get_object_vars($h) : (is_array($h) ? $h : []);
                                            if (empty($arrH)) continue;
                                            $hServ  = $arrH['nombre_servicio'] ?? '-';
                                            $hEsp   = trim(($arrH['esp_nombre'] ?? '') . ' ' . ($arrH['esp_apellido'] ?? ''));
                                            $hCons  = $arrH['consultorio'] ?? '-';
                                            $hFecha = !empty($arrH['fecha']) ? date('d/m/Y', strtotime($arrH['fecha'])) : '-';
                                            $hHora  = !empty($arrH['hora']) ? substr($arrH['hora'], 0, 5) . ' hs' : '-';
                                            $hEst   = strtolower($arrH['estado'] ?? 'cancelado');
                                        ?>
                                        <tr>
                                            <td class="fw-bold text-dark"><?= htmlspecialchars($hServ); ?></td>
                                            <td class="small text-muted"><?= htmlspecialchars($hEsp ?: '-'); ?></td>
                                            <td class="small text-muted"><?= htmlspecialchars($hCons); ?></td>
                                            <td class="small text-muted"><?= htmlspecialchars($hFecha); ?></td>
                                            <td class="small text-muted"><?= htmlspecialchars($hHora); ?></td>
                                            <td>
                                                <span class="badge rounded-pill px-2 py-1 <?= ($hEst === 'cancelado') ? 'bg-danger text-white' : 'bg-secondary text-white'; ?>">
                                                    <?= htmlspecialchars($hEst); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- 3. PESTAÑA: MI CUENTA & SEGURIDAD -->
                <div class="tab-pane fade" id="tab-cuenta">
                    <div class="row g-4">
                        <!-- Datos de Contacto -->
                        <div class="col-lg-6 pe-lg-4 border-end">
                            <h6 class="fw-bold mb-3 text-dark">
                                <i class="bi bi-person me-2" style="color: var(--terracota-principal, #a05a42);"></i>Datos de Contacto
                            </h6>
                            <form action="<?= $ruta; ?>user/actualizarDatos" method="POST">
                                <div class="mb-2">
                                    <label class="form-label small text-muted fw-bold">Nombre</label>
                                    <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($usuario['nombre'] ?? ''); ?>" readonly>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small text-muted fw-bold">Apellido</label>
                                    <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($usuario['apellido'] ?? ''); ?>" readonly>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small text-muted fw-bold">Correo</label>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email'] ?? ''); ?>" required>
                                </div>
                                <div class="mb-3">
                                 <label class="form-label small text-muted fw-bold">Teléfono</label>
                                 <input type="tel" name="telefono" class="form-control" value="<?= htmlspecialchars($usuario['telefono'] ?? ''); ?>" placeholder="Ej: 3415679821">
                                </div>
                                <button type="submit" class="btn text-white fw-semibold px-4 py-2 shadow-sm" style="background-color: var(--terracota-principal, #a05a42); border-radius: 8px;">
                                    <i class="bi bi-save me-1"></i> Guardar Cambios
                                </button>
                            </form>
                        </div>

                        <!-- Cambiar Contraseña -->
                        <div class="col-lg-6 ps-lg-4">
                            <h6 class="fw-bold mb-3 text-dark">
                                <i class="bi bi-shield-lock me-2" style="color: var(--terracota-principal, #a05a42);"></i>Cambiar Contraseña
                            </h6>
                            <form action="<?= $ruta; ?>user/cambiarContrasenia" method="POST">
                                <!-- Contraseña Actual -->
                                <div class="mb-2">
                                    <label class="form-label small text-muted fw-bold">Contraseña Actual *</label>
                                    <div class="input-group">
                                        <input type="password" name="pass_actual" id="pass_actual" class="form-control" required placeholder="••••••••">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePass('pass_actual', 'eye_act')">
                                            <i id="eye_act" class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Nueva Contraseña -->
                                <div class="mb-2">
                                    <label class="form-label small text-muted fw-bold">Nueva Contraseña *</label>
                                    <div class="input-group">
                                        <input type="password" name="pass_nueva" id="pass_nueva" class="form-control" required placeholder="••••••••">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePass('pass_nueva', 'eye_new')">
                                            <i id="eye_new" class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Repetir Contraseña -->
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-bold">Repetir Nueva Contraseña *</label>
                                    <div class="input-group">
                                        <input type="password" name="pass_rep" id="pass_rep" class="form-control" required placeholder="••••••••">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePass('pass_rep', 'eye_rep')">
                                            <i id="eye_rep" class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Cartel de requisitos -->
                                <div class="p-2 mb-3 rounded-3 small bg-light border text-muted" style="font-size: 0.8rem; line-height: 1.4;">
                                    <i class="bi bi-info-circle-fill me-1" style="color: var(--terracota-principal, #a05a42);"></i>
                                    La contraseña debe tener entre <strong>8 y 15 caracteres</strong>, al menos una <strong>mayúscula</strong>, un <strong>número</strong> y un <strong>carácter especial</strong>.
                                </div>

                                <button type="submit" class="btn text-white fw-semibold px-4 py-2 shadow-sm" style="background-color: var(--terracota-principal, #a05a42); border-radius: 8px;">
                                    <i class="bi bi-key me-1"></i> Actualizar Contraseña
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <footer class="bg-white border-top py-3 text-center small text-muted mt-auto">
        &copy; <?= date('Y'); ?> Bella Estética. Belleza, cuidado y bienestar integral.
    </footer>

    <!-- Bootstrap 5 JS Bundle y Script para mostrar contraseñas -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePass(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icono = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icono.classList.remove('bi-eye');
                icono.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icono.classList.remove('bi-eye-slash');
                icono.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>