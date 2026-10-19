<?= $head ?>
<?= $topbar ?>

    <div class="row g-3 mb-4">
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="card card-stat p-3 bg-white">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <span class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">TOTAL PRODUCTOS</span>
              <h2 class="fw-bold mb-0 mt-1 text-dark"><?=count($productos)?></h2>
            </div>
            <div class="stat-icon bg-icon-blue"><i class="fa-solid fa-box-archive"></i></div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="card card-stat p-3 bg-white">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <span class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">STOCK SIN EXISTENCIA</span>
              <h2 class="fw-bold mb-0 mt-1 text-danger"><?=count($sin_stock)?></h2>
            </div>
            <div class="stat-icon bg-icon-red"><i class="fa-solid fa-triangle-exclamation"></i></div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="card card-stat p-3 bg-white">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <span class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">STOCK CRÍTICO </span>
              <h2 class="fw-bold mb-0 mt-1 text-warning"><?=count($stock_critico)?></h2>
            </div>
            <div class="stat-icon bg-icon-yellow"><i class="fa-solid fa-battery-quarter"></i></div>
          </div>
        </div>
      </div>
    </div>


    <div class="table-container table-responsive">
      <table class="table mb-0 align-middle">
        <thead>
          <tr>
            <th>CÓD. BARRAS</th>
            <th>PRODUCTO</th>
            <th>CATEGORÍA</th>
            <th>P. COSTO</th>
            <th>P. VENTA</th>
            <th class="text-center">STOCK</th>
            <th>UNIDAD</th>
            <th>MARCA</th>
            <th class="text-center">ACCIONES</th>
          </tr>
        </thead>
        <tbody class="fw-semibold text-secondary">
            <?php
                foreach ($productos as $prod) {
                    $id = $prod->id;
                    $codigo = $prod->codigo_barras;
                    $nombre = $prod->nombre;
                    $categoria = $prod->categoria;
                    $precio_costo = number_format($prod->precio_costo,2,',','.');
                    $precio_venta = number_format($prod->precio_venta,2,',','.');
                    $stock = $prod->stock_actual;
                    $stock_minimo = $prod->stock_minimo;
                    $unidad = $prod->unidad_medida;
                    $marca = $prod->marca_producto;

                    if ($stock == 0) {
                        $stock_final = '<span class="badge-stock badge-out">&bull; Agotado ('.$stock.')</span>';
                    }elseif ($stock > 0 && $stock <= $stock_minimo) {
                        $stock_final = '<span class="badge-stock badge-critical">&bull; Critico ('.$stock.')</span>';
                    }else{
                        $stock_final = '<span class="badge-stock badge-ok">'.$stock.'</span>';
                    }

                    echo '<tr>
                        <td>'.$codigo.'</td>
                        <td class="text-dark fw-bold">'.strtoupper($nombre).'</td>
                        <td>'.$categoria.'</td>
                        <td>$'.$precio_costo.'</td>
                        <td class="text-dark fw-bold">$'.$precio_venta.'</td>
                        <td class="text-center">'.$stock_final.'</td>
                        <td>'.$unidad.'</td>
                        <td class="text-dark">'.$marca.'</td>
                        <td class="text-center">
                          <a href="'.$ruta.'productos/editar_producto/'.$id.'" class="btn btn-action"><i class="fa-regular fa-pen-to-square"></i></a>
                          <a href="'.$ruta.'productos/eliminar_producto/'.$id.'" class="btn btn-action"><i class="fa-regular fa-trash-can"></i></a>
                        </td>
                    </tr>';
                }


            ?>
        </tbody>
      </table>
    </div>

  </div>
<?= $footer ?>
