<?php
	require_once("db_.php");
	if (isset($_POST['id'])){$id=$_POST['id'];} else{ $id=0;}

	$razon="";
	$calle="";
	$no="";
	$col="";
	$ciudad="";
	$estado="";

	if($id>0){
		$pd = $db->datosemp($id);
		$razon=$pd->razon;
		$calle=$pd->calle;
		$no=$pd->no;
		$col=$pd->col;
		$ciudad=$pd->ciudad;
		$estado=$pd->estado;
	}

?>

<div class="container">
	<form action="" id="form_cliente" data-lugar="a_datosemp/db_" data-funcion="guardar_datosemp" data-destino='a_datosemp/editar'>
		<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
		<div class='card'>
			<div class='card-header'>
				Editar datos empresa
			</div>
			<div class='card-body'>
				<div class='row'>
					<div class="col-3">
						<label>Razón social:</label>
							<input type="text" class="form-control form-control-sm" name="razon" id="razon" value="<?php echo $razon;?>" placeholder="Razón" required>
					</div>
					<div class="col-3">
						<label>Calle:</label>
							<input type="text" class="form-control form-control-sm" name="calle" id="calle" value="<?php echo $calle;?>" placeholder="Calle" required>
					</div>
					<div class="col-3">
						<label>No.:</label>
							<input type="text" class="form-control form-control-sm" name="no" id="no" value="<?php echo $no;?>" placeholder="Número" required>
					</div>
				</div>
				<div class='row'>
					<div class="col-3">
						<label>Colonia:</label>
							<input type="text" class="form-control form-control-sm" name="col" id="col" value="<?php echo $col;?>" placeholder="Colonia" required>
					</div>
					<div class="col-3">
						<label>Ciudad:</label>
							<input type="text" class="form-control form-control-sm" name="ciudad" id="ciudad" value="<?php echo $ciudad;?>" placeholder="Ciudad" required>
					</div>
					<div class="col-3">
						<label>Estado:</label>
							<input type="text" class="form-control form-control-sm" name="estado" id="estado" value="<?php echo $estado;?>" placeholder="Estado" required>
					</div>
				</div>
			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<div class="btn-group">
						<button class="btn btn-outline-primary btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
						<button class='btn btn-outline-primary btn-sm' id='lista_penarea' data-lugar='a_datosemp/lista' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
