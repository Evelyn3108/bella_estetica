<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Bella Estética</title>
    
    <!-- Enlace exclusivo a la hoja de estilos unificada -->
    <link rel="stylesheet" href="../css/estilos.css?v=16">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                
                <!-- Tarjeta Principal Canvas -->
                <div class="landing-canvas-card p-4 p-md-5">
                    
                    <!-- Encabezado -->
                    <div class="text-center mb-4">
                        <i class="bi bi-flower1 fs-2" style="color: var(--terracota-principal) !important;"></i>
                        <h3 class="fw-bold text-dark mb-2 text-nowrap" style="letter-spacing: -0.02em;">Creá tu cuenta</h3>
                        <p class="text-muted small mb-0">Completá tus datos para agendar tus turnos online</p>
                    </div>
            <!-- Alertas de error o éxito -->
                    <?php 
                        $mensajeError = '';
                        if (!empty($error_msg['email'])) {
                            $mensajeError = $error_msg['email'];
                        } elseif (!empty($error_msg['pass'])) {
                            $mensajeError = $error_msg['pass'];
                        } elseif (!empty($error_msg['password'])) {
                            $mensajeError = $error_msg['password'];
                        } elseif (!empty($error) && !is_bool($error) && $error !== 1) {
                            $mensajeError = $error;
                        } elseif (!empty($error)) {
                            $mensajeError = 'Por favor, verificá los datos ingresados.';
                        }
                    ?>

                    <?php if (!empty($mensajeError)): ?>
                        <div class="alert alert-danger py-2 px-3 small d-flex align-items-center mb-4 rounded-3" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2 fs-6"></i>
                            <div><?= htmlspecialchars($mensajeError); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($exito)): ?>
                        <div class="alert alert-success py-2 px-3 small d-flex align-items-center mb-4 rounded-3" role="alert">
                            <i class="bi bi-check-circle-fill me-2 fs-6"></i>
                            <div><?= htmlspecialchars($exito); ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Formulario de Registro -->
                    <form action="registro" method="POST">
                        
                        <div class="row g-2 mb-3">
                            <!-- Nombre -->
                            <div class="col-md-6 text-start">
                                <label for="nombre" class="form-label small fw-bold text-dark mb-1">Nombre</label>
                                <div class="input-group login-input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="nombre" 
                                           name="nombre" 
                                           placeholder="Nombre"
                                           value="<?= htmlspecialchars($datos['nombre'] ?? ''); ?>" 
                                           required>
                                </div>
                            </div>

                            <!-- Apellido -->
                            <div class="col-md-6 text-start">
                                <label for="apellido" class="form-label small fw-bold text-dark mb-1">Apellido</label>
                                <div class="input-group login-input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="apellido" 
                                           name="apellido" 
                                           placeholder="Apellido" 
                                           value="<?= htmlspecialchars($datos['apellido'] ?? ''); ?>" 
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label small fw-bold text-dark mb-1">Correo Electrónico</label>
                            <div class="input-group login-input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       placeholder="ejemplo@correo.com" 
                                       value="<?= htmlspecialchars($datos['email'] ?? ''); ?>" 
                                       required>
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div class="mb-3 text-start">
                            <label for="telefono" class="form-label small fw-bold text-dark mb-1">Teléfono</label>
                            <div class="input-group login-input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="tel" 
                                       class="form-control" 
                                       id="telefono" 
                                       name="telefono" 
                                       placeholder="3412345678" 
                                       value="<?= htmlspecialchars($datos['telefono'] ?? ''); ?>">
                            </div>
                        </div>

                   <!-- Contraseñas en dos columnas con el mismo candadito -->
                    <div class="row g-2 mb-2">
                        <!-- Contraseña -->
                        <div class="col-md-6 text-start">
                            <label for="password" class="form-label small fw-bold text-dark mb-1">Contraseña *</label>
                            <div class="input-group login-input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       placeholder="••••••••" 
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="toggleClave('password', 'icono-pass')" 
                                        style="border-color: var(--borde-suave); background-color: transparent;">
                                    <i id="icono-pass" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Repetir Contraseña -->
                        <div class="col-md-6 text-start">
                            <label for="password_repeat" class="form-label small fw-bold text-dark mb-1">Repetir Contraseña *</label>
                            <div class="input-group login-input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_repeat" 
                                       name="password_repeat" 
                                       placeholder="••••••••" 
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="toggleClave('password_repeat', 'icono-repeat')" 
                                        style="border-color: var(--borde-suave); background-color: transparent;">
                                    <i id="icono-repeat" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                         <!-- Cartel de requisitos -->
                        <div class="p-2 mb-4 rounded-3 text-start small" style="background-color: var(--caja-suave); border: 1px solid var(--borde-suave); color: var(--texto-oscuro); font-size: 0.8rem; line-height: 1.4;">
                        <i class="bi bi-info-circle-fill me-1" style="color: var(--terracota-principal);"></i>
                        La contraseña debe tener entre <strong>8 y 15 caracteres</strong>, al menos una <strong>mayúscula</strong>, un <strong>número</strong> y un <strong>carácter especial</strong>.
                        </div>

                        <!-- Botón Registrarse -->
                        <div class="mb-3">
                            <button type="submit" class="btn-solid-terracota w-100 py-2 fs-6 shadow-sm">
                             Registrarse
                            </button>
                        </div>
                    </form>

                    <!-- Pie de Tarjeta -->
                    <div class="text-center mt-4 pt-3 border-top" style="border-color: var(--borde-suave) !important;">
                        <span class="text-muted small">¿Ya tenés una cuenta?</span> 
                        <a href="login" class="link-terracota ms-1 small">
                            Iniciá sesión acá
                        </a>
                    </div>

                </div>

                <!-- Volver al Inicio -->
                <div class="text-center mt-3">
                    <a href="../home" class="text-muted small text-decoration-none d-inline-flex align-items-center">
                        <i class="bi bi-arrow-left me-1"></i> Volver a la página principal
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleClave(inputId, iconId) {
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
</body>
</html>