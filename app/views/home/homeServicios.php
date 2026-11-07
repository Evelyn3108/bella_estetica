<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Servicios - Bella Estética</title>
    
    <!-- Hoja de estilos centralizada -->
    <link rel="stylesheet" href="../css/estilos.css?v=31">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- BARRA DE NAVEGACIÓN (Estilo sobrio y limpio como la captura) -->
    <nav class="navbar navbar-expand-lg bg-white py-3 border-bottom" style="border-color: #f0ebeb !important;">
        <div class="container">
            
           <a class="navbar-brand d-flex align-items-center text-dark text-decoration-none gap-2" href="home">
                <i class="bi bi-flower1 fs-2" style="color: var(--terracota-principal) !important;"></i>
                <div class="d-flex flex-column justify-content-center">
                    <span class="brand-title">BELLA ESTÉTICA</span>
                    <small class="brand-subtitle text-uppercase">Salud & Bienestar</small>
                </div>
            </a>
            <!-- Botón responsive -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navCliente">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Enlaces del menú -->
            <div class="collapse navbar-collapse" id="navCliente">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold d-flex align-items-center gap-1 active" 
                           style="color: var(--terracota-principal) !important;" 
                           href="homeServicios">
                            <i class="bi bi-grid"></i> Catálogo de Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="<?= $ruta; ?>user/perfilUsuario">
                         <i class="bi bi-person-circle me-1"></i> Mi Perfil
                        </a>
                    </li>
                   <!-- Botón Cerrar Sesión con hover suave en terracota -->
                    <li class="nav-item ms-lg-2">
                        <a href="../account/salir" 
                           class="btn btn-sm px-3 rounded-pill fw-semibold d-inline-flex align-items-center gap-1 text-decoration-none" 
                           style="background-color: transparent; border: 1px solid #dcd6d6; color: #7d6b6c; transition: all 0.2s ease-in-out;"
                           onmouseenter="this.style.backgroundColor='#fbf4f2'; this.style.borderColor='#b2614a'; this.style.color='#b2614a';"
                           onmouseleave="this.style.backgroundColor='transparent'; this.style.borderColor='#dcd6d6'; this.style.color='#7d6b6c';">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container my-5">
    
        <!-- ENCABEZADO -->
        <div class="text-center mb-5">
            <h1 class="fw-bold mb-2" style="color: var(--terracota-principal, #b2614a); font-size: 2.2rem; letter-spacing: -0.02em;">Catálogo de Servicios</h1>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Elegí el tratamiento ideal para vos y reservá tu horario en sencillos pasos.
            </p>
        </div>

       <!-- GRILLA DINÁMICA DE SERVICIOS -->
        <div class="row g-4 justify-content-center">
            <?php if (empty($servicios)): ?>
                <div class="col-12 text-center py-5 text-muted">
                    <i class="bi bi-flower1 fs-1 d-block mb-3" style="color: var(--terracota-principal);"></i>
                    <p class="fs-5">No hay servicios disponibles en este momento.</p>
                </div>
            <?php else: ?>
                <?php foreach ($servicios as $s): ?>
                    <?php 
                        $srv = is_object($s) ? (array)$s : (is_array($s) ? $s : []);
                        $idServicio   = $srv['id'] ?? 0;
                        $nombreServ   = $srv['nombre_servicio'] ?? 'Tratamiento';
                        $duracion     = $srv['duracion'] ?? '45';
                        $precio       = number_format((float)($srv['precio'] ?? 0), 2, ',', '.');
                        
                        // Selección de foto temática según el nombre del servicio cargado
                        $nombreMin = strtolower($nombreServ);
                        $foto = 'limpiezaFacial.jpg'; // Imagen por defecto
                        if (str_contains($nombreMin, 'manicur') || str_contains($nombreMin, 'mano') || str_contains($nombreMin, 'uña')) {
                            $foto = 'manicura.jpg';
                        } elseif (str_contains($nombreMin, 'masaje') || str_contains($nombreMin, 'corporal')) {
                            $foto = 'masaje.jpg';
                        } elseif (str_contains($nombreMin, 'lifting') || str_contains($nombreMin, 'pestaña') || str_contains($nombreMin, 'ceja')) {
                            $foto = 'Lifting.jpg';
                        }
                    ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card card-service h-100 d-flex flex-column border-0 shadow-sm rounded-4 overflow-hidden">
                            <!-- Imagen del Tratamiento -->
                            <div class="service-icon-box" style="height: 190px; overflow: hidden;">
                                <img src="<?= $ruta; ?>img/<?= $foto; ?>" 
                                     alt="<?= htmlspecialchars($nombreServ); ?>" 
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            </div>

                            <!-- Cuerpo de la Tarjeta -->
                            <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1 bg-white">
                                <div>
                                    <h5 class="fw-bold mb-2 text-dark"><?= htmlspecialchars($nombreServ); ?></h5>
                                    <p class="text-muted small mb-3" style="line-height: 1.5;">
                                        Tratamiento estético profesional personalizado en consultorios exclusivos.
                                    </p>
                                </div>

                                <div>
                                    <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3" style="border-color: #f7f1ee !important;">
                                        <div>
                                            <span class="text-muted small d-block">Inversión</span>
                                            <span class="fw-bold fs-5" style="color: var(--terracota-principal);">$<?= htmlspecialchars($precio); ?></span>
                                        </div>
                                        <span class="badge rounded-pill px-2 py-1 small" style="background-color: var(--caja-suave); color: var(--terracota-principal); font-size: 0.75rem;">
                                            <i class="bi bi-clock me-1"></i> <?= htmlspecialchars($duracion); ?> min
                                        </span>
                                    </div>

                                    <!-- Botón dinámico que traslada el ID exacto al detalle -->
                                    <div class="text-center">
                                        <a href="<?= $ruta; ?>home/detalleServicios?id=<?= $idServicio; ?>" class="btn-solid-terracota w-100 py-2 small rounded-3 text-decoration-none d-block">
                                            Agendar <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <!-- FOOTER INSTITUCIONAL DISCRETO -->
    <footer class="bg-white border-top py-4 mt-auto" style="border-color: #8a8383 !important;">
        <div class="container text-center">
            <p class="mb-1 fw-semibold text-dark small">
                <i class="bi bi-flower1 me-1" style="color: var(--terracota-principal);"></i> Bella Estética
            </p>
            <small class="text-muted">&copy; <?= date('Y'); ?> Bella Estética. Belleza, cuidado y bienestar integral.</small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>