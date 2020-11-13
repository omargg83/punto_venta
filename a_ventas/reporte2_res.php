<?php
  require_once("db_.php");
  $pd=$db->productos_vendidos();
  $row=$db->tot_productos_vendidos();
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br><h5>Ventas</h5>";
	echo "<hr>";


  $sql="select * from usuarios";
  $sth = $db->dbh->prepare($sql);
  $sth->execute();
  $res=$sth->fetchAll(PDO::FETCH_OBJ);


?>

  <div class="content table-responsive table-full-width">

    <table id='x_venta' class='dataTable compact hover row-border' style='font-size:10pt;'>
    <thead>
    <tr>
    <th>-</th>
    <th>Tipo</th>
    <th>Total Cantidad</th>
    <th>Total Monto</th>

    </tr>
    </thead>
    <tbody>
    <?php
      foreach($row as $key){
    ?>
          <tr id="<?php echo $key->totalmonto; ?>" class="edit-t">
            <td>

            </td>
            <?php
            if ($key->tipo==3){
            echo "  <td> Productos</td>";
              }

            else if ($key->tipo=='0'){
            echo "  <td> Servicios</td>";
              }

            else if ($key->tipo==''){
            echo "  <td> Citas</td>";
            }
            ?>

            <td><?php echo $key->totalcant; ?></td>
            <td><?php echo moneda($key->totalmonto); ?></td>

          </tr>
    <?php
      }
    ?>
    </tbody>
  </table>

  		<table id='x_venta2' class='dataTable compact hover row-border' style='font-size:10pt;'>
  		<thead>
  		<tr>
  		<th>-</th>
  		<th>Ticket #</th>
  		<th>Fecha</th>
  		<th>Porducto</th>
      <th>Cantidad</th>
  		<th>Precio U.</th>
  		<th>Total</th>
  		<th>Estado</th>
  		<th>Vendedor</th>

  		</tr>
  		</thead>
  		<tbody>
  		<?php
  			foreach($pd as $key){
  		?>
  					<tr id="<?php echo $key->idventa; ?>" class="edit-t">
  						<td>
  							<div class="btn-group">
  								<button class='btn btn-outline-primary btn-sm'  id='edit_persona' title='Editar' data-lugar='a_ventas/editar'><i class="fas fa-pencil-alt"></i></button>
  							</div>
  						</td>
  						<td><?php echo $key->idventa; ?></td>
  						<td><?php echo $key->fecha; ?></td>
  						<td><?php echo $key->nombre; ?></td>
              <td align="center"><?php echo $key->v_cantidad; ?></td>
  						<td align="left"><?php echo moneda($key->v_precio,2); ?></td>
  						<td align="left"><?php echo moneda($key->v_total,2); ?></td>
  						<td><?php echo $key->estado; ?></td>
  						<td><?php echo $key->vendedor; ?></td>

  					</tr>
  		<?php
  			}
  		?>
  		</tbody>
  	</table>
  </div>

  <script>
    $(document).ready( function () {
      lista("x_venta2");
    });
  </script>
