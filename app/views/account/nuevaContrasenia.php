<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña - Bella Estética</title>
    <!-- Bootstrap 5 y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Hoja de estilos unificada del proyecto -->
    <link rel="stylesheet" href="<?= $ruta; ?>css/estilos.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <main class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
                
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    
                    <!-- Cabecera -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" 
                             style="width: 56px; height: 56px; background-color: var(--caja-suave); color: var(--terracota-principal);">
                            <i class="bi bi-key fs-3"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Nueva Contraseña</h4>
                        <p class="text-muted small mb-0">
                            Código verificado con éxito. Por favor, definí tu nueva contraseña de acceso.
                        </p>
                    </div>

                    <!-- Alerta de error si no coinciden o no cumplen requisitos -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2 px-3 small d-flex align-items-center mb-4 rounded-3" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2 fs-6"></i>
                            <div><?= htmlspecialchars($error); ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Formulario -->
                    <form action="<?= $ruta; ?>account/nuevaContrasenia" method="POST">
                        
                        <!-- Nueva Contraseña -->
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label small fw-bold text-secondary mb-1">Nueva Contraseña *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control bg-light border-start-0 border-end-0" 
                                       id="password" 
                                       name="password" 
                                       placeholder="••••••••" 
                                       required>
                                <button class="btn btn-light border border-start-0 text-muted" 
                                        type="button" 
                                        onclick="toggleNuevaPass('password', 'eye_nueva_1')">
                                    <i id="eye_nueva_1" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Repetir Nueva Contraseña -->
                        <div class="mb-3 text-start">
                            <label for="password_repeat" class="form-label small fw-bold text-secondary mb-1">Repetir Nueva Contraseña *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control bg-light border-start-0 border-end-0" 
                                       id="password_repeat" 
                                       name="password_repeat" 
                                       placeholder="••••••••" 
                                       required>
                                <button class="btn btn-light border border-start-0 text-muted" 
                                        type="button" 
                                        onclick="toggleNuevaPass('password_repeat', 'eye_nueva_2')">
                                    <i id="eye_nueva_2" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Cartel de requisitos de contraseña -->
                        <div class="p-2 mb-4 rounded-3 text-start bg-light border text-muted" style="font-size: 0.8rem; line-height: 1.4;">
                            <i class="bi bi-info-circle-fill me-1" style="color: var(--terracota-principal, #a05a42);"></i>
                            La contraseña debe tener entre <strong>8 y 15 caracteres</strong>, al menos una <strong>mayúscula</strong>, un <strong>número</strong> y un <strong>carácter especial</strong>.
                        </div>

                        <button type="submit" 
                                class="btn w-100 py-2 fw-semibold text-white shadow-sm" 
                                style="background-color: var(--terracota-principal, #a05a42); border-radius: 8px;">
                            Guardar Nueva Contraseña
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleNuevaPass(inputId, iconId) {
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