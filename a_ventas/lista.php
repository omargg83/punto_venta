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
		<th>Factura</th>
		<th>Forma de pago</th>
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
					<tr id="<?php echo $key->idventa; ?>" class="edit-t">
						<td>
							<div class="btn-group">
								<button class='btn btn-outline-primary btn-sm'  id='edit_persona' title='Editar' data-lugar='a_ventas/editar'><i class="fas fa-pencil-alt"></i></button>
							</div>
						</td>
						<td  ><?php echo $key->idventa; ?></td>
						<td><?php echo $key->fecha; ?></td>
						<td><?php echo $key->nombre; ?></td>
						<td><?php echo $key->factura; ?></td>
						<td><?php echo $key->descuento; ?></td>
						<td><?php echo $key->tienda; ?></td>
						<td align="right"><?php echo number_format($key->total,2); ?></td>
						<td align="right"><?php echo number_format($key->gtotal,2); ?></td>
						<td><?php echo $key->estado; ?></td>

					</tr>
		<?php
			}
		?>
		</tbody>
	</table>
</div>


<script>
	$(document).ready( function () {
		lista("x_venta");
	});
</script>
