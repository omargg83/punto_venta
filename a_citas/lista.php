<?php
	require_once("db_.php");
	$pd = $db->citas_lista();
	echo "<div class='container-fluid' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br><h5>Citas</h5>";
	echo "<hr>";
?>
		<div class="content table-responsive table-full-width" >
			<table id='x_lista' class='dataTable compact hover row-border' style='font-size:10pt;'>
			<thead>
			<th>#</th>
			<th>Citas</th>
			<th>Cliente</th>
			<th>Fecha</th>
			<th>Estado</th>
			<th>Cubículo</th>
			<th>Servicio</th>
			</tr>
			</thead>
			<tbody>
			<?php
				if (count($pd)>0){
					foreach($pd as $key){
						echo "<tr id='".$key->idcitas."' class='edit-t'>";
						echo "<td>";
							echo "<div class='btn-group'>";
								echo "<button class='btn btn-outline-secondary btn-sm' id='edit_comision' title='Editar' data-lugar='a_citas/editar'><i class='fas fa-pencil-alt'></i></i></button>";
								if($key->estatus!="REALIZADA"){
									echo "<button class='btn btn-outline-secondary btn-sm' id='eliminar_pedido' data-lugar='a_citas/db_' data-destino='a_citas/lista' data-id='".$key->idcitas."' data-funcion='borrar_cita' data-div='trabajo'><i class='far fa-trash-alt'></i></button>";
								}

							echo "</div>";
						echo "</td>";
						echo "<td>".$key->idcitas."</td>";

						if($key->idcliente){
							$cli=$db->cliente($key->idcliente);
							$nombre=$cli->profesion." ".$cli->nombre." ".$cli->apellidop." ".$cli->apellidom;
						}
						else{
							$nombre="";
						}
						echo "<td>".$nombre."</td>";
						echo "<td>".fecha($key->fecha,2)."</td>";
						echo "<td>".$key->estatus."</td>";
						echo "<td>".$key->cubiculo."</td>";
						echo "<td>".$key->servicio."</td>";

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
		lista("x_lista");
	} );
</script>
