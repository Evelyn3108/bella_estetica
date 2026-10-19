<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Servicio - Panel Administrador</title>
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
        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(74, 59, 60, 0.05);
            background: #ffffff;
        }
        .section-badge {
            background-color: var(--rosa-fondo);
            color: var(--rosa-hover);
            border: 1px solid #ebd4d4;
            font-weight: 600;
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 0.85rem;
            display: inline-block;
        }
        .btn-brand {
            background-color: var(--rosa-principal);
            border-color: var(--rosa-principal);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px 30px;
            transition: all 0.2s ease;
        }
        .btn-brand:hover {
            background-color: var(--rosa-hover);
            border-color: var(--rosa-hover);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(229, 152, 155, 0.4);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR ADMINISTRADOR -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-shield-lock-fill fs-4 me-2" style="color: var(--rosa-principal);"></i> ESTÉTICA Bella <span class="badge bg-secondary ms-2 small" style="font-size: 0.7rem;">Admin</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navAdmin">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="panel_servicios.php">
                            <i class="bi bi-table me-1"></i> Lista de Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" style="color: var(--rosa-principal);" href="#">
                            <i class="bi bi-plus-square me-1"></i> Cargar Servicio
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-danger btn-sm px-3 rounded-pill" href="login.php">
                            <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- FORMULARIO DE CARGA -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card card-custom p-4 p-md-5">
                    
                    <div class="mb-4 text-center">
                        <span class="section-badge text-uppercase mb-2">Gestión del Catálogo</span>
                        <h2 class="fw-bold mt-1">Cargar Nuevo Servicio y Agenda</h2>
                        <p class="text-muted small">Definí los detalles del tratamiento, el especialista asignado y sus bandas horarias de atención.</p>
                    </div>

                    <!-- El formulario enviará los datos hacia el controlador que inserte en SERVICIOS -->
                    <form action="" method="POST">

                        <!-- BLOQUE 1: DATOS DEL TRATAMIENTO -->
                        <h5 class="fw-bold mb-3 pb-2 border-bottom text-secondary">
                            <i class="bi bi-tag me-1" style="color: var(--rosa-principal);"></i> 1. Datos Generales del Servicio
                        </h5>
                        <div class="row g-3 mb-4">
                            
                           <!-- Nombre del Servicio con Menú Desplegable -->
                            <div class="col-md-8">
                                <label for="nombre_servicio" class="form-label small fw-bold">Nombre del Servicio *</label>
                                <select id="nombre_servicio" name="nombre_servicio" class="form-select" required>
                                    <option value="" selected disabled>-- Elegir un tratamiento disponible --</option>
                                    <option value="Manicura Completa">Manicura Completa</option>
                                    <option value="Manicura Rusa con Esmaltado">Manicura Rusa con Esmaltado</option>
                                    <option value="Lifting de Pestañas">Lifting de Pestañas</option>
                                    <option value="Perfilado y Laminado de Cejas">Perfilado y Laminado de Cejas</option>
                                    <option value="Limpieza Facial Profunda">Limpieza Facial Profunda</option>
                                    <option value="Peeling Químico / Punta de Diamante">Peeling Químico / Punta de Diamante</option>
                                    <option value="Masaje Descontracturante">Masaje Descontracturante</option>
                                    <option value="Masaje Relajante con Aromaterapia">Masaje Relajante con Aromaterapia</option>
                                    <option value="Drenaje Linfático Manual">Drenaje Linfático Manual</option>
                                </select>
                                <div class="form-text small">Seleccioná uno de los tratamientos predefinidos del centro.</div>
                            </div>

                            <!-- Especialista Asignado (FK) -->
                            <div class="col-md-4">
                                <label for="id_especialista" class="form-label small fw-bold">Especialista Asignado *</label>
                                <select id="id_especialista" name="id_especialista" class="form-select" required>
                                    <option value="" selected disabled>-- Seleccionar --</option>
                                    <option value="1">Romina Paz (Manicura)</option>
                                    <option value="2">Laura Ríos (Cosmetología)</option>
                                    <option value="3">Sofía Martínez (Masajes)</option>
                                </select>
                            </div>

                            <!-- Precio -->
                            <div class="col-md-4">
                                <label for="precio" class="form-label small fw-bold">Precio ($ ARS) *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">$</span>
                                    <input type="number" step="0.01" id="precio" name="precio" class="form-control" placeholder="2500.00" required>
                                </div>
                            </div>

                            <!-- Duración en minutos -->
                            <div class="col-md-4">
                                <label for="duracion" class="form-label small fw-bold">Duración Estimada (minutos) *</label>
                                <input type="number" id="duracion" name="duracion" class="form-control" placeholder="45" required min="15" step="5">
                            </div>

                            <!-- Consultorio Físico -->
                            <div class="col-md-4">
                                <label for="consultorio" class="form-label small fw-bold">Consultorio / Box *</label>
                                <input type="text" id="consultorio" name="consultorio" class="form-control" placeholder="Ej: Sala 1" required>
                            </div>

                        </div>

                        <!-- BLOQUE 2: DISPONIBILIDAD Y HORARIOS -->
                        <h5 class="fw-bold mb-3 pb-2 border-bottom text-secondary">
                            <i class="bi bi-clock-history me-1" style="color: var(--rosa-principal);"></i> 2. Horarios y Fechas de Atención
                        </h5>
                        <div class="row g-3 mb-4">
                            
                            <!-- Hora Inicio -->
                            <div class="col-md-3 col-sm-6">
                                <label for="hora_inicio" class="form-label small fw-bold">Hora Inicio *</label>
                                <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" required value="09:00">
                            </div>

                            <!-- Hora Fin -->
                            <div class="col-md-3 col-sm-6">
                                <label for="hora_fin" class="form-label small fw-bold">Hora Fin *</label>
                                <input type="time" id="hora_fin" name="hora_fin" class="form-control" required value="18:00">
                            </div>

                            <!-- Fecha Desde -->
                            <div class="col-md-3 col-sm-6">
                                <label for="fecha_desde" class="form-label small fw-bold">Vigencia Desde *</label>
                                <input type="date" id="fecha_desde" name="fecha_desde" class="form-control" required>
                            </div>

                            <!-- Fecha Hasta -->
                            <div class="col-md-3 col-sm-6">
                                <label for="fecha_hasta" class="form-label small fw-bold">Vigencia Hasta *</label>
                                <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control" required>
                            </div>

                        </div>

                        <!-- Botón centrado para guardar -->
                        <div class="text-center mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-brand px-5">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Guardar Servicio
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>