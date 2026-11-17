<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código - Bella Estética</title>
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
                            <i class="bi bi-shield-check fs-3"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Verificar Código</h4>
                        <p class="text-muted small mb-0">
                            Ingresá el código de 6 dígitos que enviamos a 
                            <strong class="text-dark"><?= htmlspecialchars($email ?? 'tu correo'); ?></strong>.
                        </p>
                    </div>

                    <!-- Alerta de error si el código es incorrecto -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2 px-3 small d-flex align-items-center mb-4 rounded-3" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2 fs-6"></i>
                            <div><?= htmlspecialchars($error); ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Formulario -->
                    <form action="<?= $ruta; ?>account/verificarCodigo" method="POST">
                        <div class="mb-4 text-center">
                            <label for="codigo" class="form-label small fw-bold text-secondary mb-2">
                                Código de Seguridad
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg text-center fw-bold bg-light" 
                                   id="codigo" 
                                   name="codigo" 
                                   placeholder="000000" 
                                   maxlength="6" 
                                   inputmode="numeric"
                                   pattern="[0-9]{6}"
                                   autocomplete="off" 
                                   required
                                   style="letter-spacing: 0.6rem; font-size: 1.5rem; border-color: var(--borde-suave);">
                        </div>

                        <button type="submit" 
                                class="btn w-100 py-2 fw-semibold text-white shadow-sm" 
                                style="background-color: var(--terracota-principal, #a05a42); border-radius: 8px;">
                            Validar Código
                        </button>
                    </form>

                    <!-- Enlace para volver -->
                    <div class="text-center mt-4 pt-3 border-top" style="border-color: var(--borde-suave) !important;">
                        <a href="<?= $ruta; ?>account/login" class="small link-terracota text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i> Volver al inicio de sesión
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>