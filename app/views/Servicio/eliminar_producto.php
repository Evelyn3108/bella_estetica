<?= $head ?>

  <div class="card shadow-sm border-0 rounded-4 text-center p-4" style="max-width: 480px; width: 100%;">
    
    <!-- Ícono de Éxito -->
    <div class="success-icon-box">
      <i class="fa-solid fa-circle-check"></i>
    </div>

    <!-- Mensaje Principal -->
    <h4 class="fw-bold text-dark mb-3">Producto eliminado correctamente</h4>

    <!-- Resumen del Producto Eliminado -->
    <div class="bg-light p-3 rounded-3 text-start mb-4 border">
      <div class="d-flex justify-content-between align-items-center mb-1">
        <span class="badge bg-secondary-subtle text-secondary font-monospace">#<?= $producto['id'] ?? '1' ?></span>
        <span class="small text-muted font-monospace"><?= $producto[0]->codigo_barras ?? '7798184680042' ?></span>
      </div>
      <div class="fw-bold text-dark fs-6"><?= strtoupper($producto[0]->nombre) ?? 'AROMATIZADOR TEXTIL BUBBLEGUM' ?></div>
      <div class="d-flex justify-content-between mt-2 pt-2 border-top small text-secondary">
        <span><strong>Marca:</strong> <?= $producto[0]->marca_producto ?? 'Saphirus' ?></span>
        <span><strong>Categoría:</strong> <?= $producto[0]->categoria ?? 'Limpieza' ?></span>
      </div>
    </div>

    <!-- Botón Volver -->
    <a href="<?=$ruta?>productos?mensaje=producto_eliminado" class="btn btn-primary fw-semibold rounded-3 w-100 py-2">
      <i class="fa-solid fa-arrow-left me-1"></i> Volver al listado
    </a>

  </div>

<?= $footer ?>
