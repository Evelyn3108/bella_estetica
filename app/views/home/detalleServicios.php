<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Turno - Bella Estética</title>
    
    <!-- Bootstrap 5 CSS e Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="../css/estilos.css?v=35">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
        <div class="container">
           <a class="navbar-brand d-flex align-items-center text-dark text-decoration-none gap-2" href="home">
                <i class="bi bi-flower1 fs-2" style="color: var(--terracota-principal) !important;"></i>
                <div class="d-flex flex-column justify-content-center">
                    <span class="brand-title">BELLA ESTÉTICA</span>
                    <small class="brand-subtitle text-uppercase">Salud & Bienestar</small>
              </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navDetalle">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navDetalle">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link text-secondary fw-semibold d-flex align-items-center gap-1" href="homeServicios">
                            <i class="bi bi-grid"></i> Catálogo de Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary fw-semibold d-flex align-items-center gap-1" href="../usuario/perfilUsuario">
                            <i class="bi bi-person-circle"></i> Mi Perfil
                        </a>
                    </li>
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
                </ul>
            </div>
        </div>
    </nav>
<?php
        // Detección automática de la imagen del tratamiento según su nombre
        $nombreMin = strtolower($servicio->nombre_servicio ?? '');
        $foto = 'limpiezaFacial.jpg';

        if (strpos($nombreMin, 'manicur') !== false || strpos($nombreMin, 'mano') !== false || strpos($nombreMin, 'uña') !== false) {
            $foto = 'manicura.jpg';
        } elseif (strpos($nombreMin, 'masaje') !== false || strpos($nombreMin, 'corporal') !== false) {
            $foto = 'masaje.jpg';
        } elseif (strpos($nombreMin, 'lifting') !== false || strpos($nombreMin, 'pestaña') !== false || strpos($nombreMin, 'ceja') !== false) {
            $foto = 'Lifting.jpg';
        }
    ?>

    <!-- CONTENEDOR PRINCIPAL: Split Screen simétrico -->
    <main class="container my-4 my-lg-5">
        <div class="row g-0 rounded-4 overflow-hidden shadow-lg border" style="min-height: 580px; background-color: #ffffff;">
            
            <!-- MITAD IZQUIERDA: Portada visual con degradé y datos del servicio -->
            <div class="col-lg-6 position-relative text-white p-4 p-md-5 d-flex flex-column justify-content-between" 
                 style="background: linear-gradient(180deg, rgba(30, 20, 20, 0.45) 0%, rgba(30, 20, 20, 0.88) 100%), url('<?= $ruta; ?>img/<?= $foto; ?>') center/cover no-repeat;">
                
                <!-- Encabezado superior izquierdo -->
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge rounded-pill px-3 py-2 text-uppercase" style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(6px); font-size: 0.75rem; letter-spacing: 0.05em;">
                        Tratamiento Exclusivo
                    </span>
                    <span class="small" style="background-color: rgba(0,0,0,0.3); padding: 5px 12px; border-radius: 20px;">
                        <i class="bi bi-clock me-1"></i> <?= htmlspecialchars($servicio->duracion ?? '45'); ?> min
                    </span>
                </div>

                <!-- Bloque central e inferior de información -->
                <div class="my-4">
                    <h1 class="display-6 fw-bold mb-3" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        <?= htmlspecialchars($servicio->nombre_servicio ?? 'Servicio'); ?>
                    </h1>
                    
                    <p class="small text-light mb-4" style="line-height: 1.7; max-width: 90%; opacity: 0.95;">
                        <?= htmlspecialchars(!empty($servicio->descripcion) ? $servicio->descripcion : 'Belleza y cuidado de uñas, tratamiento de cutículas y esmaltado semipermanente de larga duración.'); ?>
                    </p>

                    <!-- Valor del tratamiento -->
                    <div class="p-3 rounded-3" style="background-color: rgba(255, 255, 255, 0.12); backdrop-filter: blur(8px); display: inline-block;">
                        <span class="small d-block text-white-50 text-uppercase" style="font-size: 0.7rem; font-weight: 600;">Inversión del servicio</span>
                        <strong class="fs-3 text-white">
                            $<?= number_format($servicio->precio ?? 0, 2, ',', '.'); ?>
                        </strong>
                    </div>
                </div>

                <!-- Enlace inferior para cambiar de tratamiento -->
                <div>
                    <a href="<?= $ruta; ?>home/homeServicios" class="text-white text-decoration-none small d-inline-flex align-items-center gap-2" style="opacity: 0.85;">
                        <i class="bi bi-arrow-left"></i> Volver al catálogo de servicios
                    </a>
                </div>
            </div>

            <!-- MITAD DERECHA: Datos de atención y formulario de reserva -->
            <!-- COLUMNA DERECHA: Idéntica a la imagen de referencia -->
                <div class="col-md-6 p-4 p-lg-5 d-flex flex-column justify-content-between bg-white">
                    <div>
                        <!-- Encabezado con Badge -->
                        <div class="mb-4 text-start">
                            <span class="badge rounded-pill px-3 py-1 mb-2" style="background-color: #f3e5d8; color: #a05a42; font-size: 0.75rem; font-weight: 600;">
                                Agenda Digital
                            </span>
                            <h3 class="fw-bold mb-1" style="color: #2b2320;">Reservá tu Turno</h3>
                            <p class="text-muted small mb-0">Completá la fecha y horario disponible para confirmar tu cita.</p>
                        </div>

                        <!-- Recuadros de Especialista y Consultorio asignados -->
                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <div class="p-3 rounded-3 bg-white border text-start shadow-xs">
                                    <span class="text-muted d-block small mb-1" style="font-size: 0.75rem;">Especialista a cargo:</span>
                                    <strong class="small text-dark d-flex align-items-center">
                                        <i class="bi bi-person-fill me-1" style="color: #a05a42;"></i>
                                        <?= htmlspecialchars(trim(($servicio->esp_nombre ?? $servicio->nombre_especialista ?? '') . ' ' . ($servicio->esp_apellido ?? $servicio->apellido_especialista ?? 'Valentina Gómez'))); ?>
                                    </strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-3 bg-white border text-start shadow-xs">
                                    <span class="text-muted d-block small mb-1" style="font-size: 0.75rem;">Consultorio asignado:</span>
                                    <strong class="small text-dark d-flex align-items-center">
                                        <i class="bi bi-geo-alt me-1" style="color: #a05a42;"></i>
                                        <?= htmlspecialchars($servicio->consultorio ?? 'Consultorio 4'); ?>
                                    </strong>
                                </div>
                            </div>
                        </div>

                       <!-- Formulario de Reserva con validación de domingos -->
                        <form id="formReserva" action="<?= $ruta; ?>turnos/reservar" method="POST" onsubmit="return validarYConfirmar();">
                            <input type="hidden" name="id_servicio" value="<?= htmlspecialchars($servicio->id ?? '4'); ?>">
                            <input type="hidden" name="id_especialista" value="<?= htmlspecialchars($servicio->id_especialista ?? '4'); ?>">

                            <!-- 1. Seleccioná el Día -->
                            <div class="mb-3 text-start">
                                <label for="fecha" class="form-label small fw-bold text-dark">
                                    <i class="bi bi-calendar3 me-1" style="color: #a05a42;"></i> 1. Seleccioná el Día *
                                </label>
                                <input type="date" id="fecha" name="fecha" class="form-control py-2 shadow-none" min="<?= date('Y-m-d'); ?>" required onchange="comprobarDomingo(this)">
                                <div id="alertaDomingo" class="text-danger small mt-1 d-none fw-semibold">
                                    <i class="bi bi-exclamation-circle me-1"></i> Los domingos no atendemos. Por favor elegí de lunes a sábados.
                                </div>
                            </div>

                            <!-- 2. Horarios Disponibles -->
                            <div class="mb-4 text-start">
                                <label for="hora" class="form-label small fw-bold text-dark">
                                    <i class="bi bi-clock me-1" style="color: #a05a42;"></i> 2. Horarios Disponibles *
                                </label>
                                <select id="hora" name="hora" class="form-select py-2 shadow-none" required>
                                    <option value="" selected disabled>-- Elegí una franja horaria --</option>
                                    <option value="09:00:00">09:00 hs</option>
                                    <option value="10:00:00">10:00 hs</option>
                                    <option value="11:00:00">11:00 hs</option>
                                    <option value="14:00:00">14:00 hs</option>
                                    <option value="15:00:00">15:00 hs</option>
                                    <option value="16:00:00">16:00 hs</option>
                                    <option value="17:00:00">17:00 hs</option>
                                </select>
                            </div>

                            <button type="submit" class="btn w-100 py-3 text-white fw-bold shadow-sm" style="background-color: #a05a42; border-radius: 8px;">
                                <i class="bi bi-calendar-check me-2"></i> Confirmar y Agendar Turno
                            </button>
                        </form>
                    </div>

                    <!-- Pie de la tarjeta -->
                    <div class="text-center text-muted small mt-4 pt-3 border-top">
                        <i class="bi bi-shield-check text-success me-1"></i> El turno quedará registrado a tu nombre de forma inmediata.
                    </div>
                </div>

        </div>
    </main>

    <!-- FOOTER INSTITUCIONAL -->
    <footer class="bg-white border-top py-4 mt-auto" style="border-color: #f0ebeb !important;">
        <div class="container text-center">
            <p class="mb-1 fw-semibold text-dark small">
                <i class="bi bi-flower1 me-1" style="color: var(--terracota-principal, #b2614a);"></i> Bella Estética
            </p>
            <small class="text-muted">&copy; <?= date('Y'); ?> Bella Estética. Belleza, cuidado y bienestar integral.</small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para bloquear domingos y pedir confirmación -->
    <script>
        const inputFecha = document.getElementById('fecha');

        // Si el usuario cambia la fecha, revisamos si es domingo
        if (inputFecha) {
            inputFecha.addEventListener('change', function() {
                if (!this.value) return;
                // Creamos la fecha en horario local
                const partes = this.value.split('-');
                const fechaElegida = new Date(partes[0], partes[1] - 1, partes[2]);
                
                // 0 = Domingo
                if (fechaElegida.getDay() === 0) {
                    alert('Los domingos la estética permanece cerrada. Por favor, elegí un día de lunes a sábado.');
                    this.value = '';
                }
            });
        }

        // Validación final al enviar el formulario
        function validarYConfirmar() {
            const fechaVal = document.getElementById('fecha').value;
            const horaVal = document.getElementById('hora').value;

            if (!fechaVal || !horaVal) {
                alert('Por favor seleccioná fecha y horario.');
                return false;
            }

            const partes = fechaVal.split('-');
            const fechaElegida = new Date(partes[0], partes[1] - 1, partes[2]);
            if (fechaElegida.getDay() === 0) {
                alert('Los domingos no atendemos. Seleccioná una fecha de lunes a sábado.');
                return false;
            }

            return confirm('¿Confirmás la reserva de tu turno en la fecha y horario seleccionados?');
        }
    </script>
    
</body>
</html>