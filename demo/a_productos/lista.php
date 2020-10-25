<?php
	require_once("db_.php");

	if(isset($_REQUEST['buscar'])){
		$texto=$_REQUEST['buscar'];
		$pd = $db->producto_buscar($texto);
	}
	else{
		$pd = $db->productos_lista();
	}

	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
?>
			<table class='table table-sm' style='font-size:10pt;'>
				<thead>
					<th>Editar</th>
					<th>Tipo</th>
					<th>Busqueda rápida</th>
					<th>Nombre</th>
					<th>Cantidad</th>
					<th>Precio compra</th>
					<th>Precio venta</th>
			</thead>
			<tbody>
			<?php

					foreach($pd as $key){
						echo "<tr>";
						echo "<td>";
						echo "<div class='btn-group'>";

						echo "<button type='button' class='btn btn-warning btn-sm' id='edit_persona' is='b-link' title='Editar' des='a_productos/editar' dix='trabajo' v_id='$key->id'><i class='fas fa-pencil-alt'></i></button>";

						echo "<button type='button' class='btn btn-warning btn-sm' id='edit_persona' is='b-print' title='Editar' des='a_productos/imprimir' dix='trabajo' v_id='$key->id' v_variable='demo' v_tipo='1'><i class='fas fa-barcode'></i></button>";

						echo "<button type='button' class='btn btn-warning btn-sm' is='b-link' db='a_productos/db_' des='a_productos/lista' fun='borrar_producto' dix='trabajo' v_id='$key->id' id='eliminar' tp='¿Desea eliminar el Producto seleccionado?'><i class='far fa-trash-alt'></i></button>";

						echo "</div>";
						echo "</td>";

						echo "<td>";
							if($key->tipo==0) echo "Registro";
							if($key->tipo==1) echo "Pago de linea";
							if($key->tipo==2) echo "Reparación";
							if($key->tipo==3) echo "Volúmen";
							if($key->tipo==4) echo "Unico";
						echo "</td>";


						echo "<td>".$key->rapido."</td>";
						echo "<td>".$key->nombre."</td>";
						echo "<td>".$key->cantidad."</td>";
						echo "<td >".moneda($key->preciocompra)."</td>";
						echo "<td >".moneda($key->precio)."</td>";
						echo '</tr>';
					}

			?>
			</tbody>
			</table>
	</div>
