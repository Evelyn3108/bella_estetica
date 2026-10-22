<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <!-- Logo / Nombre del Negocio -->
        <a class="navbar-brand fw-bold" href="?controller=home&action=index">
            🌸 Bella Estética
        </a>

        <!-- Botón toggle para celulares -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Enlaces -->
        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="?controller=home&action=index">Inicio</a>
                </li>
                <!-- Tratamientos / Servicios -->
                <li class="nav-item">
                    <a class="nav-link" href="?controller=home&action=index#servicios">Servicios</a>
                </li>
                
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <!-- Si inició sesión, puede reservar y ver turnos -->
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=turnos&action=reservar">Reservar Turno</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=turnos&action=index">Mis Turnos</a>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- Sección de Cuenta / Sesión a la derecha -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="dropUsuario" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            👤 <?= htmlspecialchars($_SESSION['nombre'] ?? 'Mi Cuenta'); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropUsuario">
                            <li><a class="dropdown-item" href="?controller=usuario&action=perfilUsuario">Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="?controller=turnos&action=index">Mis Turnos</a></li>
                            
                            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header">Administración</h6></li>
                                <li><a class="dropdown-item" href="?controller=turnos&action=index">Agenda de Turnos</a></li>
                                <li><a class="dropdown-item" href="?controller=admin&action=panelServicio">Gestionar Servicios</a></li>
                            <?php endif; ?>

                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="?controller=session&action=logout">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=account&action=login">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm ms-lg-2" href="?controller=account&action=registro">Registrarse</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>