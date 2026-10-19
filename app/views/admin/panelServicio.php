<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Servicios - Panel Administrador</title>
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
        .badge-activo {
            background-color: #d1e7dd;
            color: #0f5132;
            font-weight: 600;
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 0.8rem;
        }
        .badge-inactivo {
            background-color: #f8d7da;
            color: #842029;
            font-weight: 600;
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR ADMINISTRADOR -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-shield-lock-fill fs-4 me-2" style="color: var(--rosa-principal);"></i> ESTÉTICA Bella 
                <span class="badge bg-secondary ms-2 small" style="font-size: 0.7rem;">Admin</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navAdmin">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" style="color: var(--rosa-principal);" href="#">
                            <i class="bi bi-table me-1"></i> Lista de Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="cargar_servicio.php">
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

    <!-- CONTENEDOR PRINCIPAL -->
    <main class="container my-5">
        
        <!-- ENCABEZADO Y BOTÓN DE ALTA -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-1">Catálogo de Servicios</h2>
                <p class="text-muted small mb-0">Administrá los precios, duración, personal asignado y disponibilidad de la estética.</p>
            </div>
            <div>
                <a href="cargar_servicio.php" class="btn btn-brand">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Servicio
                </a>
            </div>
        </div>

        <!-- TARJETA CON TABLA DE SERVICIOS -->
        <div class="card card-custom p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-muted small text-uppercase">
                            <th>Tratamiento</th>
                            <th>Especialista</th>
                            <th>Consultorio</th>
                            <th>Duración</th>
                            <th>Precio</th>
                            <th>Horarios</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Servicio 1 -->
                        <tr>
                            <td>
                                <strong class="d-block text-dark">Manicura Completa</strong>
                                <small class="text-muted">Cuidado y esmaltado semipermanente</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-person me-1"></i> Romina Paz
                                </span>
                            </td>
                            <td>Sala 1</td>
                            <td>45 min</td>
                            <td class="fw-bold text-dark">$2.500</td>
                            <td><small class="text-muted">09:00 a 18:00 hs</small></td>
                            <td>
                                <span class="badge-activo">Activo</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-secondary" title="Editar servicio">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" title="Dar de baja lógica" onclick="return confirm('¿Seguro que deseas desactivar este servicio? No se eliminará del historial de turnos.');">
                                        <i class="bi bi-slash-circle"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Servicio 2 -->
                        <tr>
                            <td>
                                <strong class="d-block text-dark">Masaje Corporal</strong>
                                <small class="text-muted">Descontracturante y relajante</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-person me-1"></i> Sofía Martínez
                                </span>
                            </td>
                            <td>Sala 3</td>
                            <td>60 min</td>
                            <td class="fw-bold text-dark">$4.000</td>
                            <td><small class="text-muted">10:00 a 19:00 hs</small></td>
                            <td>
                                <span class="badge-activo">Activo</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-secondary" title="Editar servicio">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" title="Dar de baja lógica" onclick="return confirm('¿Seguro que deseas desactivar este servicio? No se eliminará del historial de turnos.');">
                                        <i class="bi bi-slash-circle"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Servicio 3 -->
                        <tr>
                            <td>
                                <strong class="d-block text-dark">Limpieza Facial</strong>
                                <small class="text-muted">Higiene dérmica e hidratación</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-person me-1"></i> Laura Ríos
                                </span>
                            </td>
                            <td>Sala 1</td>
                            <td>50 min</td>
                            <td class="fw-bold text-dark">$3.200</td>
                            <td><small class="text-muted">09:00 a 17:00 hs</small></td>
                            <td>
                                <span class="badge-activo">Activo</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-secondary" title="Editar servicio">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" title="Dar de baja lógica" onclick="return confirm('¿Seguro que deseas desactivar este servicio? No se eliminará del historial de turnos.');">
                                        <i class="bi bi-slash-circle"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Servicio 4 (Inactivo / Baja Lógica) -->
                        <tr class="table-light">
                            <td class="text-muted">
                                <strong class="d-block">Lifting de Pestañas</strong>
                                <small>Arqueado y nutrición</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-muted border">
                                    <i class="bi bi-person me-1"></i> Laura Ríos
                                </span>
                            </td>
                            <td class="text-muted">Sala 2</td>
                            <td class="text-muted">60 min</td>
                            <td class="text-muted">$2.800</td>
                            <td class="text-muted"><small>14:00 a 18:00 hs</small></td>
                            <td>
                                <span class="badge-inactivo">Inactivo</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-success" title="Reactivar servicio" onclick="return confirm('¿Deseas volver a activar este servicio en el catálogo?');">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>