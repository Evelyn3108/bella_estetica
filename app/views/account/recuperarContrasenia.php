<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Bella Estética</title>
    
    <!-- Enlace exclusivo a la hoja de estilos unificada -->
    <link rel="stylesheet" href="../css/estilos.css?v=17">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
                
                <!-- Tarjeta Principal Canvas (Sin logo, diseño directo y ordenado) -->
                <div class="landing-canvas-card p-4 p-md-5">
                    
                    <!-- Encabezado -->
                    <div class="text-center mb-4">
                        <i class="bi bi-flower1 fs-2" style="color: var(--terracota-principal) !important;"></i>
                        <h3 class="fw-bold text-dark mb-2 text-nowrap" style="letter-spacing: -0.02em;">Recuperar Contraseña</h3>
                        <p class="text-muted small mb-0">Ingresá tu correo para recibir un código de recuperación</p>
                    </div>

                    <!-- Mensajes de respuesta: Error o Éxito -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2 px-3 small d-flex align-items-center mb-4 rounded-3" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2 fs-6"></i>
                            <div><?= htmlspecialchars($error); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($exito)): ?>
                        <div class="alert alert-success py-2 px-3 small d-flex align-items-center mb-4 rounded-3" role="alert">
                            <i class="bi bi-check-circle-fill me-2 fs-6"></i>
                            <div><?= htmlspecialchars($exito); ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Formulario de Recuperación -->
                    <form action="recuperarContrasenia" method="POST">
                        
                        <!-- Campo: Correo Electrónico -->
                        <div class="mb-4 text-start">
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
                                       value="<?= htmlspecialchars($email ?? ''); ?>" 
                                       required>
                            </div>
                        </div>

                        <!-- Botón Enviar Instrucciones -->
                        <div class="mb-3">
                            <button type="submit" class="btn-solid-terracota w-100 py-2 fs-6 shadow-sm">
                                <i class="bi bi-send me-1"></i> Enviar Código
                            </button>
                        </div>
                    </form>

                    <!-- Pie de Tarjeta: Volver a Iniciar Sesión -->
                    <div class="text-center mt-4 pt-3 border-top" style="border-color: var(--borde-suave) !important;">
                        <span class="text-muted small">¿Te acordaste de tu contraseña?</span> 
                        <a href="login" class="link-terracota ms-1 small">
                            Iniciá sesión acá
                        </a>
                    </div>

                </div>

                <!-- Enlace exterior: Volver al inicio -->
                <div class="text-center mt-3">
                    <a href="../home" class="text-muted small text-decoration-none d-inline-flex align-items-center">
                        <i class="bi bi-arrow-left me-1"></i> Volver a la página principal
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>