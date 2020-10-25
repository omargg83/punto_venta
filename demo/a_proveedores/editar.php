<?php
	require_once("db_.php");
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}

	$nombre="";

	if($id>0){
		$pd = $db->provedor($id);
		$nombre=$pd->nombre;
	}

?>

<div class="container">
		<form is="f-submit" id="form_editar" db="a_proveedores/db_" fun="guardar_provedor" lug="a_cliente/editar" desid='id'>
		<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
		<div class='card'>
			<div class='card-header'>
				Editar cliente
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-3">
						<label>Nombre:</label>
							<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" required>
					</div>
				</div>
			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">

						<button class="btn btn-warning btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
						<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link'  des='a_proveedores/lista' dix='trabajo' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>

					</div>
				</div>
			</div>
		</div>
	</form>
</div>
