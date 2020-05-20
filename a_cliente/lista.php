<?php
	require_once("db_.php");
	$pd = $db->clientes_lista();
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";
?>

	<table id='x_cliente' class='dataTable compact hover row-border' style='font-size:10pt;'>
	<thead>
	<th>#</th>
	<th>Prof.</th>
	<th>Nombre</th>
	<th>Correo</th>
	<th>Telefono</th>
	</thead>
	<tbody>
		<?php
			foreach($pd as $key){
				echo "<tr id='".$key->idcliente."'' class='edit-t'>";
					echo "<td>";
					echo "<div class='btn-group'>";
					echo "<button class='btn btn-outline-primary btn-sm' id='edit_persona' title='Editar' data-lugar='a_cliente/editar'><i class='fas fa-pencil-alt'></i></button>";
					echo "</div>";
					echo "</td>";
					echo "<td>".$key->profesion."</td>";
					echo "<td>".$key->nombre." ".$key->apellidop." ".$key->apellidom."</td>";
					echo "<td>".$key->correo."</td>";
					echo "<td>".$key->telefono."</td>";
				echo "</tr>";
			}
		?>



	</div>
	</tbody>
	</table>
</div>
<script>
	$(document).ready( function () {
		lista("x_cliente");
	});
</script>
