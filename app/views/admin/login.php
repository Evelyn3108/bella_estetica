<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrador - Bella Estética</title>
    <!-- Estilos generales unificados del proyecto -->
    <link rel="stylesheet" href="<?= $ruta; ?>css/estilos.css?v=20">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
                
                <!-- Tarjeta Principal Canvas -->
                <div class="landing-canvas-card p-4 p-md-5">
                    
                    <!-- Encabezado con Icono Terracota -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 60px; height: 60px; background-color: var(--caja-suave);">
                            <i class="bi bi-shield-lock fs-2" style="color: var(--terracota-principal);"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.02em;">Panel de Control</h3>
                        <p class="text-muted small mb-0">Acceso exclusivo para administración</p>
                    </div>

                    <!-- Mensaje de Error -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2 px-3 small d-flex align-items-center mb-4 rounded-3 border-0 shadow-sm" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-6"></i>
                            <div><?= htmlspecialchars($error); ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Formulario de Ingreso -->
                    <form action="<?= $ruta; ?>admin/login" method="POST">
                        
                        <!-- Correo -->
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label small fw-bold text-dark mb-1">Correo Institucional</label>
                            <div class="input-group login-input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email" 
                                       class="form-control border-start-0" 
                                       id="email" 
                                       name="email" 
                                       value="<?= htmlspecialchars($datos['email'] ?? ''); ?>" 
                                       placeholder="admin@bella.com" 
                                       required>
                            </div>
                        </div>

                        <!-- Contraseña con Ojito -->
                        <div class="mb-4 text-start">
                            <label for="password" class="form-label small fw-bold text-dark mb-1">Contraseña</label>
                            <div class="input-group login-input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control border-start-0 border-end-0" 
                                       id="password" 
                                       name="password" 
                                       placeholder="••••••••" 
                                       required>
                                <button class="btn btn-outline-secondary border-start-0 bg-white" 
                                        type="button" 
                                        onclick="toggleAdminPass()" 
                                        style="border-color: var(--borde-suave); color: #8c827a;">
                                    <i id="icono-admin-pass" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Botón Principal en Terracota -->
                        <div class="mb-3">
                            <button type="submit" class="btn-solid-terracota w-100 py-2 fs-6 shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                            </button>
                        </div>
                    </form>

                    <!-- Enlace inferior -->
                    <div class="text-center mt-4 pt-3 border-top" style="border-color: var(--borde-suave) !important;">
                        <a href="<?= $ruta; ?>home" class="small text-muted text-decoration-none d-inline-flex align-items-center">
                            <i class="bi bi-arrow-left me-1"></i> Volver al sitio público
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleAdminPass() {
            const input = document.getElementById('password');
            const icono = document.getElementById('icono-admin-pass');
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