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
                        <a class="nav-link text-secondary fw-normal d-flex align-items-center gap-1" 
                           href="../usuario/perfilUsuario">
                            <i class="bi bi-person-circle"></i> Mi Perfil
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

        <!-- GRILLA DE SERVICIOS (Tal cual tu imagen de referencia) -->
        <div class="row g-4">
            
            <!-- Tarjeta 1: Spa de Manos -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column justify-content-between">
                    <div>
                        <div style="height: 170px; overflow: hidden;">
                            <img src="../img/manicura.jpg" 
                                 alt="Esmaltado Semipermanente" 
                                 class="w-100 h-100" 
                                 style="object-fit: cover;">
                        </div>
                        <div class="p-4 pb-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge rounded-pill px-2 py-1" style="background-color: var(--caja-suave); color: var(--terracota-principal); font-size: 0.75rem;">
                                    Uñas & Manos
                                </span>
                                <span class="text-muted small"><i class="bi bi-clock me-1"></i> 45 min</span>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--texto-oscuro);">Esmaltado Semipermanente</h5>
                            <p class="text-muted small mb-0">
                               Preparacion de manos, exfoliación suave, hidratación y esmaltado semipermanente de larga duración.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 pt-3 border-top d-flex align-items-center justify-content-between" style="border-color: #f5eded !important;">
                        <div>
                            <span class="text-muted small d-block">Precio</span>
                            <strong class="fs-5" style="color: var(--texto-oscuro);">$20.500</strong>
                        </div>
                        <a href="detalleServicio?id=1" class="btn-solid-terracota py-2 px-3 small text-decoration-none shadow-sm rounded-3">
                            Agendar &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2: Limpieza Facial -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column justify-content-between">
                    <div>
                        <div style="height: 170px; overflow: hidden;">
                            <img src="../img/limpiezaFacial.jpg" 
                                 alt="Limpieza Facial" 
                                 class="w-100 h-100" 
                                 style="object-fit: cover;">
                        </div>
                        <div class="p-4 pb-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge rounded-pill px-2 py-1" style="background-color: var(--caja-suave); color: var(--terracota-principal); font-size: 0.75rem;">
                                    Rostro
                                </span>
                                <span class="text-muted small"><i class="bi bi-clock me-1"></i> 50 min</span>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--texto-oscuro);">Limpieza Facial</h5>
                            <p class="text-muted small mb-0">
                                Espátula ultrasónica, extracción de impurezas, máscara descongestiva y sérum hidratante.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 pt-3 border-top d-flex align-items-center justify-content-between" style="border-color: #f5eded !important;">
                        <div>
                            <span class="text-muted small d-block">Precio</span>
                            <strong class="fs-5" style="color: var(--texto-oscuro);">$30.000</strong>
                        </div>
                        <a href="detalleServicio?id=2" class="btn-solid-terracota py-2 px-3 small text-decoration-none shadow-sm rounded-3">
                            Agendar &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 3: Masaje Corporal -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column justify-content-between">
                    <div>
                        <div style="height: 170px; overflow: hidden;">
                            <img src="../img/masaje.jpg" 
                                 alt="Masaje Corporal" 
                                 class="w-100 h-100" 
                                 style="object-fit: cover;">
                        </div>
                        <div class="p-4 pb-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge rounded-pill px-2 py-1" style="background-color: var(--caja-suave); color: var(--terracota-principal); font-size: 0.75rem;">
                                    Corporal
                                </span>
                                <span class="text-muted small"><i class="bi bi-clock me-1"></i> 60 min</span>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--texto-oscuro);">Masaje Corporal</h5>
                            <p class="text-muted small mb-0">
                                Alivio de contracturas en cuello, espalda y hombros con aceites esenciales relajantes.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 pt-3 border-top d-flex align-items-center justify-content-between" style="border-color: #f5eded !important;">
                        <div>
                            <span class="text-muted small d-block">Precio</span>
                            <strong class="fs-5" style="color: var(--texto-oscuro);">$35.000</strong>
                        </div>
                        <a href="detalleServicio?id=3" class="btn-solid-terracota py-2 px-3 small text-decoration-none shadow-sm rounded-3">
                            Agendar &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 4: Lifting Pestañas -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column justify-content-between">
                    <div>
                        <div style="height: 170px; overflow: hidden;">
                            <img src="../img/lifting.jpg" 
                                 alt="Lifting Pestañas" 
                                 class="w-100 h-100" 
                                 style="object-fit: cover;">
                        </div>
                        <div class="p-4 pb-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge rounded-pill px-2 py-1" style="background-color: var(--caja-suave); color: var(--terracota-principal); font-size: 0.75rem;">
                                    Mirada
                                </span>
                                <span class="text-muted small"><i class="bi bi-clock me-1"></i> 40 min</span>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--texto-oscuro);">Lifting Pestañas</h5>
                            <p class="text-muted small mb-0">
                                Curvatura natural desde la raíz, nutrición con keratina y tinte para realzar la mirada.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 pt-3 border-top d-flex align-items-center justify-content-between" style="border-color: #f5eded !important;">
                        <div>
                            <span class="text-muted small d-block">Precio</span>
                            <strong class="fs-5" style="color: var(--texto-oscuro);">$25.000</strong>
                        </div>
                        <a href="detalleServicio?id=4" class="btn-solid-terracota py-2 px-3 small text-decoration-none shadow-sm rounded-3">
                            Agendar &rarr;
                        </a>
                    </div>
                </div>
            </div>

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