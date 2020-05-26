<?php
	require_once("db_.php");
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}

	$nombre="";
	$apellidop="";
	$apellidom="";
	$telefono="";
	$correo="";
	$profesion="";

	if($id>0){
		$pd = $db->cliente($id);
		$nombre=$pd->nombre;
		$apellidop=$pd->apellidop;
		$apellidom=$pd->apellidom;
		$telefono=$pd->telefono;
		$correo=$pd->correo;
		$profesion=$pd->profesion;
	}

?>

<div class="container">
	<form action="" id="form_cliente" data-lugar="a_cliente/db_" data-funcion="guardar_cliente" data-destino='a_cliente/editar'>
		<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
		<div class='card'>
			<div class='card-header'>
				Editar cliente
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-3">
						<label>Profesión:</label>
							<input type="text" class="form-control form-control-sm" name="profesion" id="profesion" value="<?php echo $profesion;?>" placeholder="Profesión" required>
					</div>
					<div class="col-3">
						<label>Nombre:</label>
							<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre;?>" placeholder="Nombre" required>
					</div>
					<div class="col-3">
						<label>Apellido Paterno:</label>
							<input type="text" class="form-control form-control-sm" name="apellidop" id="apellidop" value="<?php echo $apellidop;?>" placeholder="Apellido Paterno" required>
					</div>
					<div class="col-3">
						<label>Apellido materno:</label>
							<input type="text" class="form-control form-control-sm" name="apellidom" id="apellidom" value="<?php echo $apellidom;?>" placeholder="Apellido materno" required>
					</div>
				</div>
				<div class='row'>
					<div class="col-3">
						<label>Teléfono:</label>
							<input type="text" class="form-control form-control-sm" name="telefono" id="telefono" value="<?php echo $telefono;?>" placeholder="Teléfono" required>
					</div>
					<div class="col-3">
						<label>Correo:</label>
							<input type="text" class="form-control form-control-sm" name="correo" id="correo" value="<?php echo $correo;?>" placeholder="Correo" required>
					</div>
				</div>
			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<div class="btn-group">
						<button class="btn btn-outline-primary btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
						<button class='btn btn-outline-primary btn-sm' id='lista_penarea' data-lugar='a_cliente/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
