<?php
	require_once("db_.php");
	$pd = $db->datosemp_lista();
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
?>

	<table id='x_cliente' class='table table-sm' style='font-size:10pt;'>
	<thead>
	<th>#</th>
	<th>Razon</th>
	<th>Calle</th>
	<th>No.</th>
	</thead>
	<tbody>
		<?php
			foreach($pd as $key){
				echo "<tr>";
					echo "<td>";
					echo "<div class='btn-group'>";
					echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_datosemp/editar' dix='trabajo' v_id='$key->idemp'><i class='fas fa-pencil-alt'></i></button>";
					echo "</div>";
					echo "</td>";
					echo "<td>".$key->razon."</td>";
					echo "<td>".$key->calle."</td>";
					echo "<td>".$key->no."</td>";
				echo "</tr>";
			}
		?>
	</div>
	</tbody>
	</table>
</div>
