<?php
	require_once("db_.php");

	if(isset($_REQUEST['buscar'])){
		$texto=$_REQUEST['buscar'];
		$pd = $db->clientes_buscar($texto);
	}
	else{
		$pd = $db->clientes_lista();
	}
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
?>
	<table class='table table-sm' style='font-size:10pt;'>
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
				echo "<tr>";
					echo "<td>";
					echo "<div class='btn-group'>";

					echo "<button type='button' class='btn btn-warning btn-sm' id='edit_persona' is='b-link' title='Editar' des='a_cliente/editar' dix='trabajo' v_id='$key->idcliente'><i class='fas fa-pencil-alt'></i></button>";

					echo "<button type='button' class='btn btn-warning btn-sm' is='b-link' db='a_cliente/db_' des='a_cliente/lista' fun='borrar_cliente' dix='trabajo' v_id='$key->idcliente' id='eliminar' tp='¿Desea eliminar el cliente seleccionado?'><i class='far fa-trash-alt'></i></button>";

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
