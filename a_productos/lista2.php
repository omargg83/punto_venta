<?php
	require_once("db_.php");
	$pd = $db->servicios_lista();
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br><h5>Servicios</h5>";
	echo "<hr>";
?>
		<div class="content table-responsive table-full-width" >
			<table id='x_prod2' class='dataTable compact hover row-border' style='font-size:10pt;'>
				<thead>
				<tr>
					<th>#</th>
					<th>#</th>
					<th>Tipo</th>
					<th>Busqueda rápida</th>
					<th>Nombre</th>
					<th>Costo</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if (count($pd)>0){
					$contar=1;
					foreach($pd as $key){
						echo "<tr id='".$key['id']."' class='edit-t'>";
						echo "<td>";
						echo $contar;
						$contar++;
						echo "</td>";
						echo "<td>";

							echo "<div class='btn-group'>";
								echo "<button class='btn btn-outline-primary btn-sm' id='edit_comision' title='Editar' data-lugar='a_productos/editar'><i class='fas fa-pencil-alt'></i></i></button>";
							echo "</div>";
						echo "</td>";

						echo "<td>";
							if($key["tipo"]=="0") echo "Registro";
							if($key["tipo"]=="1") echo "Pago de linea";
							if($key["tipo"]=="2") echo "Reparación";
							if($key["tipo"]=="3") echo "Volúmen";
							if($key["tipo"]=="4") echo "Unico";
						echo "</td>";


						echo "<td>".$key["rapido"]."</td>";
						echo "<td>".$key["nombre"]."</td>";
						echo "<td >".moneda($key["precio"])."</td>";
						echo "</tr>";
					}
				}
			?>
			</tbody>
			</table>
		</div>
	</div>

<script>
	$(document).ready( function () {
		lista("x_prod2");
	} );
</script>
