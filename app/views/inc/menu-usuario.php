<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$rol = $_SESSION['rol'] ?? 'cliente';
?>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-light fw-bold py-3">
        Menú de Usuario
    </div>
    <div class="list-group list-group-flush">
        <!-- Opciones para Clientes -->
        <a href="?controller=usuario&action=perfilUsuario" class="list-group-item list-group-item-action d-flex align-items-center">
            <span class="me-2">👤</span> Mis Datos
        </a>
        <a href="?controller=turnos&action=reservar" class="list-group-item list-group-item-action d-flex align-items-center">
            <span class="me-2">📅</span> Solicitar Turno
        </a>
        <a href="?controller=turnos&action=index" class="list-group-item list-group-item-action d-flex align-items-center">
            <span class="me-2">📋</span> Mis Turnos
        </a>

        <!-- Opciones exclusivas si el rol es Admin -->
        <?php if ($rol === 'admin'): ?>
            <div class="list-group-item bg-light text-muted small fw-bold text-uppercase py-2">
                Panel Administrador
            </div>
            <a href="?controller=turnos&action=index" class="list-group-item list-group-item-action d-flex align-items-center">
                <span class="me-2">🗓️</span> Agenda General
            </a>
            <a href="?controller=admin&action=panelServicio" class="list-group-item list-group-item-action d-flex align-items-center">
                <span class="me-2">✨</span> Panel de Servicios
            </a>
            <a href="?controller=admin&action=cargarServicio" class="list-group-item list-group-item-action d-flex align-items-center">
                <span class="me-2">➕</span> Cargar Servicio
            </a>
        <?php endif; ?>

        <!-- Salir -->
        <a href="?controller=session&action=logout" class="list-group-item list-group-item-action text-danger d-flex align-items-center">
            <span class="me-2">🚪</span> Cerrar Sesión
        </a>
    </div>
</div>