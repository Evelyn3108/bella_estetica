<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Bella Estética</title>
    
    <!-- Enlace exclusivo a la hoja de estilos general externa -->
    <link rel="stylesheet" href="../css/estilos.css?v=15">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
                
                <!-- Tarjeta Principal Canvas (Sin Logo) -->
                <div class="landing-canvas-card p-4 p-md-5">
                    
                    <!-- 1. Encabezado en una sola línea -->
                    <div class="text-center mb-4">
                        <i class="bi bi-flower1 fs-2" style="color: var(--terracota-principal) !important;"></i>
                        <h3 class="fw-bold text-dark mb-2 text-nowrap" style="letter-spacing: -0.02em;">¡Te damos la bienvenida!</h3>
                        <p class="text-muted small mb-0">Ingresá tu correo y contraseña para continuar</p>
                    </div>

                 <!-- Mensaje de error si falla la autenticación -->
                    <?php 
                        // Determinamos el mensaje de error que viene desde el controlador
                        $mensajeMostrar = '';
                        if (!empty($error_msg['email'])) {
                            $mensajeMostrar = $error_msg['email'];
                        } elseif (!empty($error_msg['pass'])) {
                            $mensajeMostrar = $error_msg['pass'];
                        } elseif (!empty($error) && !is_bool($error) && $error !== 1) {
                            $mensajeMostrar = $error;
                        } elseif (!empty($error)) {
                            $mensajeMostrar = 'El correo electrónico o la contraseña son incorrectos.';
                        }
                    ?>

                    <?php if (!empty($mensajeMostrar)): ?>
                        <div class="alert alert-danger py-2 px-3 small d-flex align-items-center mb-4 rounded-3" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2 fs-6"></i>
                            <div><?= htmlspecialchars($mensajeMostrar); ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- 2. Formulario de Ingreso -->
                    <form action="login" method="POST">
                        
                        <!-- Campo: Correo Electrónico -->
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label small fw-bold text-dark mb-1">Correo Electrónico</label>
                            <div class="input-group login-input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       placeholder="ejemplo@correo.com" 
                                       value="<?= htmlspecialchars($datos['email'] ?? ''); ?>" 
                                       required>
                            </div>
                        </div>

                       <!-- Campo: Contraseña con botón ver/ocultar -->
                        <div class="mb-4 text-start">
                            <label for="password" class="form-label small fw-bold text-dark mb-1">Contraseña</label>
                            <div class="input-group login-input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       placeholder="••••••••" 
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="toggleLoginPass()" 
                                        style="border-color: var(--borde-suave); background-color: transparent;">
                                    <i id="icono-login-pass" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Botón Principal Iniciar Sesión -->
                        <div class="mb-3">
                            <button type="submit" class="btn-solid-terracota w-100 py-2 fs-6 shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                            </button>
                        </div>
                    </form>

                    <!-- 3. Pie de Tarjeta: Enlaces juntos abajo con el mismo color terracota -->
                    <div class="text-center mt-4 pt-3 border-top" style="border-color: var(--borde-suave) !important;">
                        <div class="mb-2">
                            <a href="recuperarContrasenia" class="small link-terracota">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                        <div class="small">
                            <span class="text-muted">¿No tenés cuenta?</span> 
                            <a href="registro" class="link-terracota ms-1">
                                Registrate acá
                            </a>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3">
                    <a href="../home" class="text-muted small text-decoration-none d-inline-flex align-items-center">
                        <i class="bi bi-arrow-left me-1"></i> Volver a la página principal
                    </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleLoginPass() {
            const input = document.getElementById('password');
            const icono = document.getElementById('icono-login-pass');

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