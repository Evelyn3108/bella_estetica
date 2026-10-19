<?= $head ?>
<?= $topbar ?>

    <div class="row g-3 mb-4">
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="card card-stat p-3 bg-white">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <span class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">TOTAL VENTAS</span>
              <h2 class="fw-bold mb-0 mt-1 text-dark"><?=count($ventas)?></h2>
            </div>
            <div class="stat-icon bg-icon-blue"><i class="fa-solid fa-box-archive"></i></div>
          </div>
        </div>
      </div>
    </div>


    <div class="table-container table-responsive">
      <table class="table mb-0 align-middle">
        <thead>
          <tr>
            <th>VENDEDOR</th>
            <th>CLIENTE</th>
            <th>FECHA VENTA</th>
            <th>PRECIO VENTA</th>
            <th>ESTADO</th>
            <th class="text-center">ACCIONES</th>
          </tr>
        </thead>
        <tbody class="fw-semibold text-secondary">
            <?php
                foreach ($ventas as $v) {
                    $id = $v->id_venta;
                    $cliente = $v->cliente;
                    $vendedor = $v->vendedor;
                    $fecha = $v->fecha_venta;
                    $precio = number_format($v->precio_venta,2,',','.');
                    $estado = $v->estado;

                    if ($estado == 0) {
                        $estado_final = '<span class="badge-stock badge-out">&bull; Inactivo</span>';
                    }else{
                        $estado = '<span class="badge-stock badge-ok">Activo</span>';
                    }

                    echo '<tr>
                        <td>'.$vendedor.'</td>
                        <td class="text-dark fw-bold">'.strtoupper($cliente).'</td>
                        <td>'.$fecha.'</td>
                        <td>$'.$precio.'</td>
                        <td class="text-dark fw-bold">'.$estado.'</td>
                        <td class="text-center">
                          <a href="'.$ruta.'ventas/ver_venta/'.$id.'" class="btn btn-action"><i class="fa-regular fa-eye"></i></a>
                          <a href="'.$ruta.'ventas/eliminar_venta/'.$id.'" class="btn btn-action"><i class="fa-regular fa-trash-can"></i></a>
                        </td>
                    </tr>';
                }
            ?>
        </tbody>
      </table>
    </div>

  </div>
<?= $footer ?>
