<?php
	require_once("db_.php");
	$pd = $db->ventas_lista();

	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br><h5>Ventas abiertas</h5>";
	echo "<hr>";
?>

<div class="content table-responsive table-full-width">
		<table id='x_venta' class='dataTable compact hover row-border' style='font-size:10pt;'>
		<thead>
		<tr>
		<th>-</th>
		<th>Numero</th>
		<th>Fecha</th>
		<th>Cliente</th>

		<th>Tienda</th>
		<th>Total</th>
		<th>Gran total</th>
		<th>Estado</th>
		</tr>
		</thead>
		<tbody>
		<?php
			foreach($pd as $key){
		?>
					<tr>
						<td>
							<div class="btn-group">
								<button class='btn btn-warning btn-sm'  id='edit_persona' is='b-link' id='nueva_venta' des='a_ventas/editar' dix='trabajo'  v_idventa='<?php echo $key->idventa; ?> ' ><i class="fas fa-pencil-alt"></i></button>
							</div>
						</td>
						<td  ><?php echo $key->idventa; ?></td>
						<td><?php echo $key->fecha; ?></td>
						<td><?php echo $key->nombre; ?></td>

						<td><?php echo $key->tienda; ?></td>
						<td align="center"><?php echo number_format($key->total,2); ?></td>
						<td align="center"><?php echo number_format($key->gtotal,2); ?></td>
						<td><?php echo $key->estado; ?></td>

					</tr>
		<?php
			}
		?>
		</tbody>
	</table>
</div>
