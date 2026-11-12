<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Turno - Bella Estética</title>
    
    <!-- Bootstrap 5 CSS e Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="<?= $ruta; ?>css/estilos.css?v=37">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
        <div class="container-fluid px-4 px-lg-5">
           <a class="navbar-brand d-flex align-items-center text-dark text-decoration-none gap-2" href="<?= $ruta; ?>home">
                <i class="bi bi-flower1 fs-2" style="color: var(--terracota-principal, #a05a42) !important;"></i>
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
                        <a class="nav-link text-secondary fw-semibold d-flex align-items-center gap-1" href="<?= $ruta; ?>home/homeServicios">
                            <i class="bi bi-grid"></i> Catálogo de Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary fw-semibold d-flex align-items-center gap-1" href="<?= $ruta; ?>user/perfilUsuario">
                            <i class="bi bi-person-circle"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a href="<?= $ruta; ?>account/salir" 
                           class="btn btn-sm px-3 rounded-pill fw-semibold d-inline-flex align-items-center gap-1 text-decoration-none" 
                           style="background-color: transparent; border: 1px solid #dcd6d6; color: #7d6b6c; transition: all 0.2s ease-in-out;"
                           onmouseenter="this.style.backgroundColor='#fbf4f2'; this.style.borderColor='var(--terracota-principal, #b2614a)'; this.style.color='var(--terracota-principal, #b2614a)';"
                           onmouseleave="this.style.backgroundColor='transparent'; this.style.borderColor='#dcd6d6'; this.style.color='#7d6b6c';">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
        $arrServ = is_object($servicio) ? (array)$servicio : ($servicio ?? []);
        
        // Datos del servicio e identificación exacta
        $idServicio     = $arrServ['id'] ?? ($_GET['id'] ?? 1);
        $idEspecialista = $arrServ['id_especialista'] ?? 1;
        $nombreServicio = $arrServ['nombre_servicio'] ?? 'Servicio';
        $duracionMin    = $arrServ['duracion'] ?? '45';
        $precioServicio = (float)($arrServ['precio'] ?? 0);
        $consultorio    = $arrServ['consultorio'] ?? 'Consultorio 1';
        $diasAtencion   = !empty($arrServ['dias_atencion']) ? $arrServ['dias_atencion'] : '1,2,3,4,5,6';

        // Horarios configurados por el administrador
        $cadenaHorarios = !empty($arrServ['hora_inicio']) ? $arrServ['hora_inicio'] : '09:30,10:30,11:30,12:30,14:00,15:00';
        $listaHorarios  = explode(',', $cadenaHorarios);

        // Especialista a cargo
        $nombreEsp = trim(($arrServ['esp_nombre'] ?? $arrServ['nombre_especialista'] ?? '') . ' ' . ($arrServ['esp_apellido'] ?? $arrServ['apellido_especialista'] ?? ''));
        if (empty($nombreEsp)) {
            $nombreEsp = 'Especialista Asignado';
        }

        // Detección automática de la imagen del tratamiento según su nombre
        $nombreMin = strtolower($nombreServicio);
        $foto = 'limpiezaFacial.jpg';

        if (strpos($nombreMin, 'manicur') !== false || strpos($nombreMin, 'mano') !== false || strpos($nombreMin, 'uña') !== false) {
            $foto = 'manicura.jpg';
        } elseif (strpos($nombreMin, 'masaje') !== false || strpos($nombreMin, 'corporal') !== false) {
            $foto = 'masaje.jpg';
        } elseif (strpos($nombreMin, 'lifting') !== false || strpos($nombreMin, 'pestaña') !== false || strpos($nombreMin, 'ceja') !== false) {
            $foto = 'Lifting.jpg';
        }
    ?>

    <!-- CONTENEDOR PRINCIPAL FLUIDO -->
    <main class="container-fluid px-4 px-lg-5 my-4 flex-grow-1">
        <div class="row g-0 rounded-4 overflow-hidden shadow-sm border" style="min-height: 600px; background-color: #ffffff; border-color: var(--borde-suave, #ebdcd5) !important;">
            
            <!-- MITAD IZQUIERDA: Portada visual con degradé y datos del servicio -->
            <div class="col-lg-5 col-xl-5 position-relative text-white p-4 p-md-5 d-flex flex-column justify-content-between" 
                 style="background: linear-gradient(180deg, rgba(30, 20, 20, 0.45) 0%, rgba(30, 20, 20, 0.88) 100%), url('<?= $ruta; ?>img/<?= $foto; ?>') center/cover no-repeat;">
                
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge rounded-pill px-3 py-2 text-uppercase" style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(6px); font-size: 0.75rem; letter-spacing: 0.05em;">
                        Tratamiento Exclusivo
                    </span>
                    <span class="small" style="background-color: rgba(0,0,0,0.3); padding: 5px 12px; border-radius: 20px;">
                        <i class="bi bi-clock me-1"></i> <?= htmlspecialchars($duracionMin); ?> min
                    </span>
                </div>

                <div class="my-4">
                    <h1 class="display-6 fw-bold mb-3" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                        <?= htmlspecialchars($nombreServicio); ?>
                    </h1>
                    
                    <p class="small text-light mb-4" style="line-height: 1.7; max-width: 90%; opacity: 0.95;">
                        <?= htmlspecialchars(!empty($arrServ['descripcion']) ? $arrServ['descripcion'] : 'Belleza y cuidado integral con productos de primera calidad y atención personalizada.'); ?>
                    </p>

                    <div class="p-3 rounded-3" style="background-color: rgba(255, 255, 255, 0.12); backdrop-filter: blur(8px); display: inline-block;">
                        <span class="small d-block text-white-50 text-uppercase" style="font-size: 0.7rem; font-weight: 600;">Inversión del servicio</span>
                        <strong class="fs-3 text-white">
                            $<?= number_format($precioServicio, 2, ',', '.'); ?>
                        </strong>
                    </div>
                </div>

                <div>
                    <a href="<?= $ruta; ?>home/homeServicios" class="text-white text-decoration-none small d-inline-flex align-items-center gap-2" style="opacity: 0.85;">
                        <i class="bi bi-arrow-left"></i> Volver al catálogo de servicios
                    </a>
                </div>
            </div>

            <!-- MITAD DERECHA: Formulario de reserva -->
            <div class="col-lg-7 col-xl-7 p-4 p-lg-5 d-flex flex-column justify-content-between bg-white">
                <div>
                    <div class="mb-4 text-start">
                        <span class="badge rounded-pill px-3 py-1 mb-2" style="background-color: var(--caja-suave, #faeee9); color: var(--terracota-principal, #a05a42); font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">
                            Agenda Digital
                        </span>
                        <h3 class="fw-bold mb-1" style="color: #2b2320;">Reservá tu Turno</h3>
                        <p class="text-muted small mb-0">Completá la fecha y horario disponible para confirmar tu cita.</p>
                    </div>

                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <div class="p-3 rounded-3 bg-white border text-start shadow-xs">
                                <span class="text-muted d-block small mb-1" style="font-size: 0.75rem;">Especialista a cargo:</span>
                                <strong class="small text-dark d-flex align-items-center">
                                    <i class="bi bi-person-fill me-1" style="color: var(--terracota-principal, #a05a42);"></i>
                                    <?= htmlspecialchars($nombreEsp); ?>
                                </strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3 bg-white border text-start shadow-xs">
                                <span class="text-muted d-block small mb-1" style="font-size: 0.75rem;">Consultorio asignado:</span>
                                <strong class="small text-dark d-flex align-items-center">
                                    <i class="bi bi-geo-alt me-1" style="color: var(--terracota-principal, #a05a42);"></i>
                                    <?= htmlspecialchars($consultorio); ?>
                                </strong>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de Reserva -->
                    <form id="formReserva" action="<?= $ruta; ?>turnos/reservar" method="POST">
                        <input type="hidden" name="id_servicio" value="<?= htmlspecialchars($idServicio); ?>">
                        <input type="hidden" name="id_especialista" value="<?= htmlspecialchars($idEspecialista); ?>">
                        <input type="hidden" name="fecha" id="fechaSeleccionada" required>
                        <input type="hidden" name="hora" id="horaSeleccionada" required>

                        <!-- Encabezado de Mes y Navegación de Semanas -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0 text-capitalize text-dark" id="labelMesActual"></h5>
                            <div class="d-flex gap-1 align-items-center">
                                <button type="button" class="btn btn-sm rounded-circle py-0 px-2 shadow-none border" id="btnSemanaAnt" title="Semana anterior" style="color: var(--terracota-principal, #a05a42); border-color: var(--borde-suave, #ebdcd5);">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-sm rounded-circle py-0 px-2 shadow-none border" id="btnSemanaSig" title="Semana siguiente" style="color: var(--terracota-principal, #a05a42); border-color: var(--borde-suave, #ebdcd5);">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- TIRA HORIZONTAL DE DÍAS (Fuerza fila estricta con flex-nowrap) -->
                        <div class="d-flex flex-row flex-nowrap justify-content-between align-items-center gap-1 mb-4 pb-3 border-bottom overflow-x-auto" id="carruselDias">
                            <!-- Renderizado dinámicamente por JS -->
                        </div>

                        <!-- SECCIÓN HORARIOS DISPONIBLES -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-dark d-flex align-items-center gap-1 mb-2">
                                <i class="bi bi-clock" style="color: var(--terracota-principal, #a05a42);"></i> Horarios Disponibles
                            </label>

                            <!-- Bloque Mañana -->
                            <div id="seccionManana" class="mb-3 d-none">
                                <span class="text-muted small fw-semibold d-block mb-2 text-uppercase" style="font-size: 0.72rem;">Mañana</span>
                                <div class="d-flex flex-wrap gap-2" id="contenedorHorasManana"></div>
                            </div>

                            <!-- Bloque Tarde -->
                            <div id="seccionTarde" class="mb-3 d-none">
                                <span class="text-muted small fw-semibold d-block mb-2 text-uppercase" style="font-size: 0.72rem;">Tarde</span>
                                <div class="d-flex flex-wrap gap-2" id="contenedorHorasTarde"></div>
                            </div>

                            <!-- Mensaje Inicial -->
                            <div id="mensajeSinDia" class="text-muted small py-3 text-center bg-light rounded-3 border">
                                <i class="bi bi-hand-index me-1" style="color: var(--terracota-principal, #a05a42);"></i> Seleccioná un día hábil arriba para ver los horarios disponibles.
                            </div>
                        </div>

                        <!-- Botón Confirmar Turno (Terracota) -->
                        <button type="button" id="btnConfirmarTurno" class="btn btn-confirmar-reserva w-100 py-3 fw-bold rounded-3 shadow-sm" disabled>
                            <i class="bi bi-calendar-check me-2"></i> Confirmar y Agendar Turno
                        </button>
                    </form>

                </div>

                <div class="text-center text-muted small mt-4 pt-3 border-top">
                    <i class="bi bi-shield-check text-success me-1"></i> El turno quedará registrado a tu nombre de forma inmediata.
                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER INSTITUCIONAL -->
    <footer class="bg-white border-top py-4 mt-auto" style="border-color: #f0ebeb !important;">
        <div class="container-fluid px-4 px-lg-5 text-center">
            <p class="mb-1 fw-semibold text-dark small">
                <i class="bi bi-flower1 me-1" style="color: var(--terracota-principal, #b2614a);"></i> Bella Estética
            </p>
            <small class="text-muted">&copy; <?= date('Y'); ?> Bella Estética. Belleza, cuidado y bienestar integral.</small>
        </div>
    </footer>

    <!-- Bootstrap JS y SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Días de atención configurados en la base de datos (ej: [1, 3, 5, 6])
        const diasPermitidos = [<?= !empty($diasAtencion) ? $diasAtencion : '1,3,5,6'; ?>];

        // Franjas horarias configuradas para este servicio
        const listaHoras = <?= json_encode(array_values(array_filter(array_map('trim', $listaHorarios ?? [])))); ?>;

        // Turnos activos que ya tiene agendados el usuario
        const turnosActivosUsuario = <?= json_encode($turnosUsuario ?? []); ?>;

        // Turnos que tiene ocupados el especialista con cualquier cliente
        const turnosOcupadosEspecialista = <?= json_encode($turnosOcupadosEsp ?? []); ?>;

        // ID y nombre del especialista de este servicio
        const idEspecialistaActual = <?= (int)$idEspecialista; ?>;
        const nombreEspActual = <?= json_encode($nombreEsp); ?>;

        let offsetDias = 0;
        let diaElegidoStr = '';
        let horaElegidaStr = '';

        const nombresDiasCortos = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        const nombresMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        function renderizarCarrusel() {
            const carrusel = document.getElementById('carruselDias');
            if (!carrusel) return;
            carrusel.innerHTML = '';

            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            const fechaBase = new Date();
            fechaBase.setDate(hoy.getDate() + offsetDias);

            const lblMes = document.getElementById('labelMesActual');
            if (lblMes) {
                lblMes.textContent = `${nombresMeses[fechaBase.getMonth()]} ${fechaBase.getFullYear()}`;
            }

            // Renderiza 7 días en fila horizontal
            for (let i = 0; i < 7; i++) {
                const d = new Date(fechaBase);
                d.setDate(fechaBase.getDate() + i);

                const numDiaSemana = d.getDay(); // 0 = Dom, 1 = Lun, etc.
                const fechaSql = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
                
                const esPasado = d < hoy;
                const esDomingo = (numDiaSemana === 0);
                const esAtencionValida = diasPermitidos.includes(numDiaSemana);
                const estaDeshabilitado = esPasado || esDomingo || !esAtencionValida;
                const estaSeleccionado = (diaElegidoStr === fechaSql && !estaDeshabilitado);

                // Tarjeta de día (Bootstrap: d-flex flex-column align-items-center)
                const itemDia = document.createElement('div');
                itemDia.className = 'd-flex flex-column align-items-center text-center flex-fill p-1';

                // Nombre día (Dom, Lun, Mar...)
                const spanNom = document.createElement('span');
                spanNom.className = `small fw-semibold text-capitalize mb-1 ${estaDeshabilitado ? 'text-muted opacity-50' : 'text-secondary'}`;
                spanNom.style.fontSize = '0.75rem';
                if (estaSeleccionado) {
                    spanNom.className = 'small fw-bold text-capitalize mb-1';
                    spanNom.style.color = 'var(--terracota-principal, #a05a42)';
                }
                spanNom.textContent = nombresDiasCortos[numDiaSemana];

                // Botón/Círculo del número
                const btnNum = document.createElement('button');
                btnNum.type = 'button';
                btnNum.textContent = d.getDate();

                if (estaDeshabilitado) {
                    btnNum.className = 'btn btn-light rounded-circle fw-semibold text-muted opacity-50 pe-none border-0 shadow-none';
                    btnNum.style.width = '38px';
                    btnNum.style.height = '38px';
                    btnNum.style.padding = '0';
                } else if (estaSeleccionado) {
                    // Seleccionado en terracota
                    btnNum.className = 'btn rounded-circle fw-bold shadow-sm text-white border-0';
                    btnNum.style.backgroundColor = 'var(--terracota-principal, #a05a42)';
                    btnNum.style.width = '38px';
                    btnNum.style.height = '38px';
                    btnNum.style.padding = '0';
                } else {
                    // Disponible
                    btnNum.className = 'btn btn-outline-secondary rounded-circle fw-semibold border-0 text-dark';
                    btnNum.style.width = '38px';
                    btnNum.style.height = '38px';
                    btnNum.style.padding = '0';

                    btnNum.addEventListener('click', () => {
                        diaElegidoStr = fechaSql;
                        document.getElementById('fechaSeleccionada').value = fechaSql;
                        renderizarCarrusel();
                        renderizarHorarios();
                    });
                }

                itemDia.appendChild(spanNom);
                itemDia.appendChild(btnNum);
                carrusel.appendChild(itemDia);
            }
        }

        function renderizarHorarios() {
            const mensajeSinDia = document.getElementById('mensajeSinDia');
            if (mensajeSinDia) mensajeSinDia.classList.add('d-none');

            const contManana = document.getElementById('contenedorHorasManana');
            const contTarde = document.getElementById('contenedorHorasTarde');
            const secManana = document.getElementById('seccionManana');
            const secTarde = document.getElementById('seccionTarde');

            contManana.innerHTML = '';
            contTarde.innerHTML = '';
            horaElegidaStr = '';
            document.getElementById('horaSeleccionada').value = '';
            document.getElementById('btnConfirmarTurno').disabled = true;

            // 1. REGLA: No se puede seleccionar el mismo especialista el mismo día aunque sea diferente horario
            const turnoMismoEspecialista = turnosActivosUsuario.find(t => {
                const tFecha = t.fecha ? t.fecha.split(' ')[0] : '';
                const tEspId = parseInt(t.id_especialista || 0);
                return tFecha === diaElegidoStr && tEspId === idEspecialistaActual;
            });

            if (turnoMismoEspecialista) {
                secManana.classList.add('d-none');
                secTarde.classList.add('d-none');
                document.getElementById('btnConfirmarTurno').disabled = true;

                const partes = diaElegidoStr.split('-');
                const fVisual = `${partes[2]}/${partes[1]}/${partes[0]}`;

                Swal.fire({
                    title: 'Especialista ya asignado',
                    html: `Ya tenés un turno agendado con <strong>${nombreEspActual}</strong> para el día <strong>${fVisual}</strong>.<br><br>No podés seleccionar el mismo especialista el mismo día aunque sea en diferente horario.`,
                    icon: 'warning',
                    confirmButtonText: 'Elegir otra fecha',
                    confirmButtonColor: '#a05a42'
                });

                if (mensajeSinDia) {
                    mensajeSinDia.classList.remove('d-none');
                    mensajeSinDia.innerHTML = `<i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Ya tenés un turno agendado con <strong>${nombreEspActual}</strong> este día. Por favor, seleccioná otra fecha.`;
                }
                return;
            }

            let cantManana = 0;
            let cantTarde = 0;

            listaHoras.forEach(h => {
                const hLimpia = h.substring(0, 5);
                const [hora] = hLimpia.split(':').map(Number);

                const btnHora = document.createElement('button');
                btnHora.type = 'button';
                btnHora.className = 'btn slot-hora-btn btn-sm';
                btnHora.textContent = `${hLimpia} hs`;

                // 2. REGLA: Comprobar si el usuario ya tiene otro servicio agendado a este mismo horario
                const turnoMismoHorarioUsuario = turnosActivosUsuario.find(t => {
                    const tFecha = t.fecha ? t.fecha.split(' ')[0] : '';
                    const tHora = t.hora ? t.hora.substring(0, 5) : '';
                    return tFecha === diaElegidoStr && tHora === hLimpia;
                });

                // Comprobar si el especialista ya está ocupado por otro cliente
                const ocupadoPorOtro = turnosOcupadosEspecialista.some(t => {
                    const tFecha = t.fecha ? t.fecha.split(' ')[0] : '';
                    const tHora = t.hora ? t.hora.substring(0, 5) : '';
                    return tFecha === diaElegidoStr && tHora === hLimpia;
                });

                if (turnoMismoHorarioUsuario) {
                    // Si el usuario ya tiene otro turno a esa hora: botón visible pero con advertencia al hacer clic
                    btnHora.classList.add('border-warning', 'text-muted');
                    btnHora.style.backgroundColor = '#fff9f4';
                    btnHora.title = `Turno superpuesto: ${turnoMismoHorarioUsuario.nombre_servicio || 'Servicio'}`;

                    btnHora.addEventListener('click', () => {
                        const partes = diaElegidoStr.split('-');
                        const fVisual = `${partes[2]}/${partes[1]}/${partes[0]}`;
                        const nomOtro = turnoMismoHorarioUsuario.nombre_servicio || 'otro servicio';

                        Swal.fire({
                            title: 'Horario no disponible',
                            html: `Ya tenés un turno agendado para el <strong>${fVisual}</strong> a las <strong>${hLimpia} hs</strong> para el servicio <strong>"${nomOtro}"</strong>.<br><br>No podés agendar otro servicio el mismo día al mismo horario.`,
                            icon: 'warning',
                            confirmButtonText: 'Elegir otro horario',
                            confirmButtonColor: '#a05a42'
                        });
                    });
                } else if (ocupadoPorOtro) {
                    // Turno ocupado por otra persona
                    btnHora.classList.add('opacity-50', 'bg-light', 'text-muted');
                    btnHora.disabled = true;
                    btnHora.title = 'Horario ya reservado';
                } else {
                    // Horario disponible
                    btnHora.addEventListener('click', () => {
                        // Deseleccionar otras pastillas
                        document.querySelectorAll('.slot-hora-btn').forEach(b => {
                            b.classList.remove('activo');
                        });

                        // Seleccionar actual en terracota
                        btnHora.classList.add('activo');

                        horaElegidaStr = `${hLimpia}:00`;
                        document.getElementById('horaSeleccionada').value = horaElegidaStr;
                        document.getElementById('btnConfirmarTurno').disabled = false;
                    });
                }

                if (hora < 13) {
                    contManana.appendChild(btnHora);
                    cantManana++;
                } else {
                    contTarde.appendChild(btnHora);
                    cantTarde++;
                }
            });

            secManana.classList.toggle('d-none', cantManana === 0);
            secTarde.classList.toggle('d-none', cantTarde === 0);
        }

        // Flechas de navegación semanal
        const btnSig = document.getElementById('btnSemanaSig');
        if (btnSig) {
            btnSig.addEventListener('click', () => {
                offsetDias += 7;
                renderizarCarrusel();
            });
        }

        const btnAnt = document.getElementById('btnSemanaAnt');
        if (btnAnt) {
            btnAnt.addEventListener('click', () => {
                if (offsetDias >= 7) {
                    offsetDias -= 7;
                    renderizarCarrusel();
                }
            });
        }

        // Modal de Confirmación y envío del form
        const btnConfirmar = document.getElementById('btnConfirmarTurno');
        if (btnConfirmar) {
            btnConfirmar.addEventListener('click', () => {
                if (!diaElegidoStr || !horaElegidaStr) return;

                const partes = diaElegidoStr.split('-');
                const fechaVisual = `${partes[2]}/${partes[1]}/${partes[0]}`;
                const horaVisual = horaElegidaStr.substring(0, 5) + ' hs';

                Swal.fire({
                    title: '¿Confirmar reserva?',
                    html: `Estás por agendar tu turno para el día <strong>${fechaVisual}</strong> a las <strong>${horaVisual}</strong>.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, agendar turno',
                    cancelButtonText: 'Revisar datos',
                    confirmButtonColor: '#a05a42',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('formReserva').submit();
                    }
                });
            });
        }

        // Detección de mensajes de error devueltos por el backend
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('error') === 'mismo_especialista_dia') {
            Swal.fire({
                title: 'Especialista ya asignado',
                text: 'Ya tenés un turno agendado con este especialista para esa fecha. No es posible agendar dos veces con el mismo especialista el mismo día.',
                icon: 'warning',
                confirmButtonColor: '#a05a42'
            });
        } else if (urlParams.get('error') === 'turno_duplicado') {
            Swal.fire({
                title: 'Horario no disponible',
                text: 'No podés agendar otro servicio el mismo día al mismo horario.',
                icon: 'warning',
                confirmButtonColor: '#a05a42'
            });
        } else if (urlParams.get('error') === 'horario_ocupado') {
            Swal.fire({
                title: 'Horario no disponible',
                text: 'El especialista ya tiene un turno reservado en ese horario por otro cliente.',
                icon: 'info',
                confirmButtonColor: '#a05a42'
            });
        }

        document.addEventListener('DOMContentLoaded', renderizarCarrusel);
    </script>
</body>
</html>