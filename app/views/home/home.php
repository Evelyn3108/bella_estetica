<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios y Tratamientos</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --rosa-principal: #e5989b;
            --rosa-hover: #b5838d;
            --rosa-fondo: #fff5f5;
            --texto-oscuro: #4a3b3c;
        }
        body {
            background-color: var(--rosa-fondo);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--texto-oscuro);
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--texto-oscuro) !important;
        }
        .btn-brand {
            background-color: var(--rosa-principal);
            border-color: var(--rosa-principal);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 18px;
            transition: all 0.2s ease;
        }
        .btn-brand:hover {
            background-color: var(--rosa-hover);
            border-color: var(--rosa-hover);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(229, 152, 155, 0.4);
        }
        .card-service {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(74, 59, 60, 0.05);
            background: #ffffff;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            overflow: hidden;
        }
        .card-service:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 30px rgba(74, 59, 60, 0.1);
        }
        .service-icon-box {
            height: 120px;
            background: linear-gradient(135deg, #fce8e8, #f7d6d7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--rosa-principal);
            font-size: 2.8rem;
        }
        .badge-chip {
            background-color: var(--rosa-fondo);
            color: var(--rosa-hover);
            border: 1px solid #ebd4d4;
            font-weight: 600;
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 0.82rem;
        }
        .price-tag {
            color: var(--rosa-principal);
            font-size: 1.4rem;
            font-weight: 800;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-flower1 fs-2 me-1" style="color: var(--rosa-principal);"></i> Bella Estética
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navServicios">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navServicios">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" style="color: var(--rosa-principal);" href="#">
                            <i class="bi bi-grid me-1"></i> Catálogo de Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="perfil_turnos.php">
                            <i class="bi bi-person-circle me-1"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-danger btn-sm px-3 rounded-pill" href="login.php">
                            <i class="bi bi-box-arrow-right me-1"></i> Salir
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container my-5">
        
        <!-- ENCABEZADO DE BIENVENIDA -->
        <div class="text-center mb-5">
            <span class="badge-chip text-uppercase mb-2 d-inline-block">Experiencia & Bienestar</span>
            <h1 class="fw-bold mt-2 mb-2" style="color: var(--texto-oscuro);">Nuestros Servicios</h1>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Elegí el tratamiento ideal para vos, consultá los detalles de atención y reservá tu horario en sencillos pasos.
            </p>
        </div>

        <!-- GRILLA DE SERVICIOS -->
        <div class="row g-4">

            <!-- Servicio 1: Manicura Completa -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-service h-100 d-flex flex-column">
                    <div class="service-icon-box">
                      
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold mb-0">Manicura Completa</h5>
                            </div>
                            <p class="text-muted small mb-4">
                                Limado, remoción de cutículas, exfoliación profunda y esmaltado semipermanente con colores a elección.
                            </p>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3">
                                <div>
                                    <span class="text-muted small d-block">Precio</span>
                                    <span class="price-tag">$20.500</span>
                                </div>
                                <span class="badge-chip">
                                    <i class="bi bi-clock me-1"></i> 45 min
                                </span>
                            </div>
                            <div class="text-center">
                                <a href="detalle_servicio.php" class="btn btn-brand w-100">
                                    <i class="bi bi-calendar-plus me-1"></i> Reservar Turno
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Servicio 2: Masaje Descontracturante -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-service h-100 d-flex flex-column">
                    <div class="service-icon-box">
                       
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold mb-0">Masaje Corporal</h5>
                            </div>
                            <p class="text-muted small mb-4">
                                Sesión intensiva para aliviar contracturas musculares, puntos de tensión y reducir la sobrecarga del estrés diario.
                            </p>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3">
                                <div>
                                    <span class="text-muted small d-block">Precio</span>
                                    <span class="price-tag">$40.000</span>
                                </div>
                                <span class="badge-chip">
                                    <i class="bi bi-clock me-1"></i> 60 min
                                </span>
                            </div>
                            <div class="text-center">
                                <a href="detalle_servicio.php" class="btn btn-brand w-100">
                                    <i class="bi bi-calendar-plus me-1"></i> Reservar Turno
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Servicio 3: Limpieza Facial Profunda -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-service h-100 d-flex flex-column">
                    <div class="service-icon-box">
                     
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold mb-0">Limpieza Facial</h5>
                            </div>
                            <p class="text-muted small mb-4">
                                Higienización profunda, extracción de impurezas, exfoliación dérmica, hidratación y máscara según tu tipo de piel.
                            </p>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3">
                                <div>
                                    <span class="text-muted small d-block">Precio</span>
                                    <span class="price-tag">$23.000</span>
                                </div>
                                <span class="badge-chip">
                                    <i class="bi bi-clock me-1"></i> 50 min
                                </span>
                            </div>
                            <div class="text-center">
                                <a href="detalle_servicio.php" class="btn btn-brand w-100">
                                    <i class="bi bi-calendar-plus me-1"></i> Reservar Turno
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Servicio 4: Lifting de Pestañas -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-service h-100 d-flex flex-column">
                    <div class="service-icon-box">
                       
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-between flex-grow-1">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold mb-0">Lifting Pestañas</h5>
                            </div>
                            <p class="text-muted small mb-4">
                                Elevación y arqueado de tus pestañas naturales desde la raíz, complementado con tinte negro y baño de nutrición.
                            </p>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3">
                                <div>
                                    <span class="text-muted small d-block">Precio</span>
                                    <span class="price-tag">$25.000</span>
                                </div>
                                <span class="badge-chip">
                                    <i class="bi bi-clock me-1"></i> 60 min
                                </span>
                            </div>
                            <div class="text-center">
                                <a href="detalle_servicio.php" class="btn btn-brand w-100">
                                    <i class="bi bi-calendar-plus me-1"></i> Reservar Turno
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>