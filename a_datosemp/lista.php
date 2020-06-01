<?php
	require_once("db_.php");
	$pd = $db->datosemp_lista();
	echo "<div class='container' style='background-color:".$_SESSION['cfondo']."; '>";
	echo "<br>";
?>

	<table id='x_cliente' class='dataTable compact hover row-border' style='font-size:10pt;'>
	<thead>
	<th>#</th>
	<th>Razon</th>
	<th>Calle</th>
	<th>No.</th>
	</thead>
	<tbody>
		<?php
			foreach($pd as $key){
				echo "<tr id='".$key->idemp."'' class='edit-t'>";
					echo "<td>";
					echo "<div class='btn-group'>";
					echo "<button class='btn btn-outline-primary btn-sm' id='edit_persona' title='Editar' data-lugar='a_datosemp/editar'><i class='fas fa-pencil-alt'></i></button>";
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
<script>
	$(document).ready( function () {
		lista("x_datosemp");
	});
</script>
