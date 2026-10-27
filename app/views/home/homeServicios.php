<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Servicios - Bella Estética</title>
    
    <!-- Bootstrap 5 CSS e Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Hoja de estilos centralizada -->
    <link rel="stylesheet" href="../css/estilos.css?v=25">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- BARRA DE NAVEGACIÓN CLIENTE -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
       <div class="collapse navbar-collapse" id="navCliente">
         <a class="navbar-brand fw-bold text-dark d-flex align-items-center" href="../home">
                <i class="bi bi-flower1 me-2" style="color: var(--terracota-principal);"></i> Bella Estética
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navDetalle">
                <span class="navbar-toggler-icon"></span>
            </button>
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" style="color: var(--terracota-principal);" href="homeServicios">
                            <i class="bi bi-grid me-1"></i> Catálogo de Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="../usuario/perfilUsuario">
                            <i class="bi bi-person-circle me-1"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-secondary btn-sm px-3 rounded-pill" href="../account/salir">
                            <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container my-5">
        
        <!-- ENCABEZADO -->
        <div class="text-center mb-5">
            <h2 class="fw-bold mt-2" style="color: var(--texto-oscuro); letter-spacing: -0.04em;">Catálogo de Servicios</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Elegí el tratamiento ideal para vos y reservá tu horario en sencillos pasos.
            </p>
        </div>

        <!-- GRILLA DE SERVICIOS -->
        <div class="row g-4">
            
            <!-- Tarjeta 1: Manicura -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column justify-content-between">
                    <div>
                        <div style="height: 170px; overflow: hidden;">
                           <img src="../img/manicura.jpg" 
                                alt="Spa de Manos" 
                                class="w-100 h-100" 
                                style="object-fit: cover;">
                        </div>
                        <div class="p-4 pb-2">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge rounded-pill px-2 py-1" style="background-color: var(--caja-suave); color: var(--terracota-principal); font-size: 0.75rem;">
                                    Uñas & Manos
                                </span>
                                <span class="text-muted small"><i class="bi bi-clock me-1"></i> 45 min</span>
                            </div>
                            <h5 class="fw-bold mb-2" style="color: var(--texto-oscuro);">Spa de Manos</h5>
                            <p class="text-muted small mb-0">
                                Cutículas, exfoliación suave, hidratación y esmaltado semipermanente de larga duración.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 pt-3 border-top d-flex align-items-center justify-content-between" style="border-color: var(--borde-suave) !important;">
                        <div>
                            <span class="text-muted small d-block">Precio</span>
                            <strong class="fs-5" style="color: var(--terracota-principal);">$2.500</strong>
                        </div>
                        <a href="detalleServicio?id=1" class="btn-solid-terracota py-2 px-3 small text-decoration-none shadow-sm rounded-3">
                            Agendar <i class="bi bi-arrow-right ms-1"></i>
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
                            <div class="d-flex justify-content-between align-items-start mb-2">
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
                    <div class="p-4 pt-3 border-top d-flex align-items-center justify-content-between" style="border-color: var(--borde-suave) !important;">
                        <div>
                            <span class="text-muted small d-block">Precio</span>
                            <strong class="fs-5" style="color: var(--terracota-principal);">$3.200</strong>
                        </div>
                        <a href="detalleServicio?id=2" class="btn-solid-terracota py-2 px-3 small text-decoration-none shadow-sm rounded-3">
                            Agendar <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 3: Masaje Corporal -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column justify-content-between">
                    <div>
                        <div style="height: 170px; overflow: hidden;">
                            <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=600&q=80" 
                                 alt="Masaje Descontracturante" 
                                 class="w-100 h-100" 
                                 style="object-fit: cover;">
                        </div>
                        <div class="p-4 pb-2">
                            <div class="d-flex justify-content-between align-items-start mb-2">
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
                    <div class="p-4 pt-3 border-top d-flex align-items-center justify-content-between" style="border-color: var(--borde-suave) !important;">
                        <div>
                            <span class="text-muted small d-block">Precio</span>
                            <strong class="fs-5" style="color: var(--terracota-principal);">$4.000</strong>
                        </div>
                        <a href="detalleServicio?id=3" class="btn-solid-terracota py-2 px-3 small text-decoration-none shadow-sm rounded-3">
                            Agendar <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 4: Lifting de Pestañas -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white d-flex flex-column justify-content-between">
                    <div>
                        <div style="height: 170px; overflow: hidden;">
                          <img src="../img/lifting.jpg" 
                               alt="Lifting de pestañas" 
                               class="w-100 h-100" 
                               style="object-fit: cover;">
                        </div>
                        <div class="p-4 pb-2">
                            <div class="d-flex justify-content-between align-items-start mb-2">
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
                    <div class="p-4 pt-3 border-top d-flex align-items-center justify-content-between" style="border-color: var(--borde-suave) !important;">
                        <div>
                            <span class="text-muted small d-block">Precio</span>
                            <strong class="fs-5" style="color: var(--terracota-principal);">$2.800</strong>
                        </div>
                        <a href="detalleServicio?id=4" class="btn-solid-terracota py-2 px-3 small text-decoration-none shadow-sm rounded-3">
                            Agendar <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>