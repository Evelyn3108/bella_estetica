<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bella Estética - Centro de Cuidado & Bienestar</title>
    
    <!-- Enlace a estilos unificados externos -->
    <link rel="stylesheet" href="css/estilos.css?v=12">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- 1. NAVBAR SUPERIOR CON LA FLOR ORIGINAL -->
    <!-- 1. NAVBAR SUPERIOR CON LA FLOR EN TERRACOTA Y BOTÓN REGISTRARSE -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 mb-4">
        <div class="container" style="max-width: 1200px;">
            <a class="navbar-brand d-flex align-items-center text-dark text-decoration-none gap-2" href="home">
                <i class="bi bi-flower1 fs-2" style="color: var(--terracota-principal) !important;"></i>
                <div class="d-flex flex-column justify-content-center">
                    <span class="brand-title">BELLA ESTÉTICA</span>
                    <small class="brand-subtitle text-uppercase">Salud & Bienestar</small>
                </div>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#menuLanding">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuLanding">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-3">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active border-bottom border-2 pb-1" style="border-color: var(--terracota-principal) !important;" href="home">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#servicios">Tratamientos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#contacto">Contacto</a>
                    </li>
                </ul>
                <div class="d-flex gap-2 align-items-center">
                    <a href="account/login" class="btn-solid-terracota">
                        <i class="bi bi-person me-1"></i> Iniciar sesión
                    </a>
                    <a href="account/registro" class="btn-outline-terracota">
                        <i class="bi bi-person-plus me-1"></i> Registrarse
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. CONTENIDO PRINCIPAL -->
    <main class="container my-2 flex-grow-1" style="max-width: 1200px;">
        
        <!-- TARJETA HERO PRINCIPAL (SIN FILA DE BENEFICIOS) -->
        <div class="landing-canvas-card mb-5">
            <div class="row align-items-center g-4">
                
                <!-- Columna Izquierda: Texto -->
                <div class="col-lg-6 pe-lg-4">
                    <div class="badge-pill-soft text-uppercase mb-3">
                        <i class="bi bi-flower1 me-1"></i> Cuidado Integral Unisex
                    </div>
                    
                    <h1 class="display-5 fw-extrabold mb-3" style="font-weight: 800; line-height: 1.2;">
                        Tu bienestar y cuidado <br>
                        <span style="color: var(--terracota-principal);">en las mejores manos</span>
                    </h1>
                    
                    <p class="text-muted lead fs-6 mb-4" style="line-height: 1.7;">
                        Espacio dedicado a la estética integral. Tratamientos faciales, corporales y masajes terapéuticos brindados por profesionales en consultorios privados.
                    </p>
                    
                   <div>
                        <a href="account/login" class="btn-solid-terracota py-3 px-4 fs-6 shadow-sm">
                            <i class="bi bi-calendar-check me-2"></i> Agendar Turno
                        </a>
                    </div>
                </div>

                <!-- Columna Derecha: Imagen fotográfica armónica -->
                <div class="col-lg-6 text-center">
                    <div class="hero-image-frame">
                        <img src="img/home_facial.jpg" alt="Tratamiento de estética profesional">
                    </div>
                </div>

            </div>
        </div>

        <!-- SECCIÓN TRATAMIENTOS: TARJETA CON IMAGEN + QUÉ ES + DESCRIPCIÓN -->
        <section id="servicios" class="pb-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold mt-2 mb-2 text-dark">Nuestros Tratamientos</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">
                    Iniciá sesión o registrate para consultar la disponibilidad de turnos de cada sesión.
                </p>
            </div>

            <div class="row g-4">
                
                <!-- Tratamiento 1: Limpieza Facial -->
                <div class="col-md-6 col-lg-3">
                    <div class="card-treatment h-100">
                        <div class="treatment-img-box">
                            <img src="img/limpiezaFacial.jpg" alt="Limpieza Facial">
                        </div>
                        <div class="p-4">
                            <h5 class="fw-bold mb-2">Limpieza Facial</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Higiene dérmica profunda, extracción de impurezas, exfoliación y nutrición personalizada según tu tipo de piel.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tratamiento 2: Masaje Relajante -->
                <div class="col-md-6 col-lg-3">
                    <div class="card-treatment h-100">
                        <div class="treatment-img-box">
                            <img src="img/masaje.jpg" alt="Masaje Terapéutico">
                        </div>
                        <div class="p-4">
                            <h5 class="fw-bold mb-2">Masaje Relajante</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Sesión descontracturante con aromaterapia y aceites esenciales.
                            </p>
                        </div>
                    </div>
                </div>

               <!-- Tratamiento 3: Spa de Manos -->
                <div class="col-md-6 col-lg-3">
                    <div class="card-treatment h-100">
                        <div class="treatment-img-box">
                            <img src="img/manicura.jpg" alt="Spa de Manos">
                        </div>
                        <div class="p-4">
                           <h5 class="fw-bold mb-2">Manicura Completa</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Belleza y cuidado de uñas, tratamiento de cutículas y esmaltado semipermanente de larga duración.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tratamiento 4: Lifting de Pestañas -->
                <div class="col-md-6 col-lg-3">
                    <div class="card-treatment h-100">
                        <div class="treatment-img-box">
                            <img src="img/Lifting.jpg" alt="Lifting y Nutrición de Pestañas">
                        </div>
                        <div class="p-4">
                            <h5 class="fw-bold mb-2">Lifting de Pestañas</h5>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Arqueado y nutrición de pestañas naturales desde la raíz con tinte y keratina para realzar la mirada.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- 3. FOOTER OSCURO -->
    <footer class="footer-canvas py-5 mt-auto" id="contacto">
        <div class="container py-2" style="max-width: 1200px;">
            <div class="row g-4 justify-content-between">
                
                <div class="col-lg-4">
                    <h5 class="fw-bold text-white d-flex align-items-center mb-3">
                        <i class="bi bi-flower1 me-2" style="color: var(--terracota-principal);"></i> BELLA ESTÉTICA
                    </h5>
                    <p class="small pe-lg-4" style="line-height: 1.7;">
                        Centro de estética y cuidado integral unisex. Espacios preparados para brindarte bienestar y descanso.
                    </p>
                </div>

                <div class="col-6 col-lg-2">
                    <h6>NAVEGACIÓN</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                        <li><a href="home">Inicio</a></li>
                        <li><a href="#servicios">Tratamientos</a></li>
                    </ul>
                </div>


                <div class="col-lg-3">
                    <h6>CONTACTO</h6>
                    <ul class="list-unstyled d-flex flex-column gap-3 mb-0 small">
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt" style="color: var(--terracota-principal);"></i> Rosario, Santa Fe, Argentina
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope" style="color: var(--terracota-principal);"></i> contacto@bellaestetica.com
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-telephone" style="color: var(--terracota-principal);"></i> +54 9 341234567
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>