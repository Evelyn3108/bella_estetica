<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/menu.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h4 class="mb-0">Agendar Turno</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <form action="?controller=turnos&action=guardar" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tratamiento o Servicio</label>
                            <select name="id_servicio" class="form-select" required>
                                <option value="">Seleccione un tratamiento...</option>
                                <?php foreach ($datos['servicios'] as $serv): ?>
                                    <option value="<?= $serv['id']; ?>">
                                        <?= htmlspecialchars($serv['nombre_servicio']); ?> 
                                        ($<?= number_format($serv['precio'], 2); ?>) 
                                        — Atiende: <?= htmlspecialchars($serv['especialista_nombre'] . ' ' . $serv['especialista_apellido']); ?>
                                        (Consultorio: <?= htmlspecialchars($serv['consultorio']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Fecha</label>
                                <input type="date" name="fecha" class="form-control" min="<?= date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Hora</label>
                                <input type="time" name="hora" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Confirmar Reserva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>