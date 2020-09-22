<?php
	require_once("db_.php");
	$pd = $db->usuario_lista();
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
?>

	<table id='x_user' class='table' style='font-size:10pt;'>
	<thead>
	<th>Numero</th>
	<th>Nombre</th>
	<th>Usuario</th>
	<th>Nivel</th>
	<th>Tienda</th>
	<th>Activo</th>
	</thead>
	<tbody>
		<?php
			foreach($pd as $key){
				echo '<tr id="'.$key->idusuario.'" class="edit-t">';
					echo "<td>";
					echo "<button class='btn btn-warning btn-sm' is='b-link' des='a_usuarios/editar' dix='trabajo' v_id='$key->idusuario' id='edit_persona'><i class='fas fa-pencil-alt'></i></button>";
					echo "</td>";
				echo '<td>'.$key->nombre.'</td>';
				echo '<td>'.$key->user.'</td>';
				echo '<td>'.$key->nivel.'</td>';
				echo '<td>'.$key->tienda.'</td>';
				echo '<td>';
				if ($key->activo==0) { echo "Inactivo"; }
				if ($key->activo==1) { echo "Activo"; }
				echo '</td>';
				echo '</tr>';
			}
		?>
	</tbody>
	</table>
</div>
