<?php require_once '../app/views/inc/header.php'; ?>
<?php require_once '../app/views/inc/menu.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Mis Turnos Reservados</h2>
        <a href="?controller=turnos&action=reservar" class="btn btn-success">+ Solicitar Nuevo Turno</a>
    </div>

    <?php if (isset($_SESSION['exito'])): ?>
        <div class="alert alert-success"><?= $_SESSION['exito']; unset($_SESSION['exito']); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Servicio</th>
                        <th>Especialista</th>
                        <th>Consultorio</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($datos['turnos'])): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">No tienes turnos programados.</td></tr>
                    <?php else: ?>
                        <?php foreach ($datos['turnos'] as $t): ?>
                            <tr>
                                <td><?= htmlspecialchars($t['fecha']); ?></td>
                                <td><?= substr($t['hora'], 0, 5); ?> hs</td>
                                <td><strong><?= htmlspecialchars($t['nombre_servicio']); ?></strong></td>
                                <td><?= htmlspecialchars($t['especialista_nombre'] . ' ' . $t['especialista_apellido']); ?></td>
                                <td><?= htmlspecialchars($t['consultorio'] ?? '-'); ?></td>
                                <td>
                                    <span class="badge bg-<?= $t['estado'] === 'confirmado' ? 'success' : ($t['estado'] === 'cancelado' ? 'danger' : 'warning'); ?>">
                                        <?= ucfirst(htmlspecialchars($t['estado'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($t['estado'] !== 'cancelado'): ?>
                                        <a href="?controller=turnos&action=cancelar&id=<?= $t['id']; ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('¿Seguro que deseas cancelar este turno?');">
                                           Cancelar
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>