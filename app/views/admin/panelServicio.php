<?= $head ?>
<?= $topbar ?>

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
<?= $footer ?>
