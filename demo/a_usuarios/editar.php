<?php
	require_once("db_.php");
	if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];} else{ $id=0;}

	$tienda = $db->tiendas_lista();
	if($id>0){
		$pd = $db->usuario($id);
		$id=$pd->idusuario;
		$idtienda=$pd->idtienda;
		$user=$pd->user;
		$pass=$pd->pass;
		$nivel=$pd->nivel;
		$nombre=$pd->nombre;
		$estado=$pd->activo;
	}
	else{
		$id=0;
		$idtienda="1";
		$user="";
		$pass="";
		$nivel="1";
		$nombre="";
		$estado="1";
	}
?>
<form is="f-submit" id="form_personal" db="a_usuarios/db_" fun="guardar_usuario" des='a_usuarios/editar' desid='id'>
<div class="container">
	<div class='card'>
		<div class='card-header'>
			Usuarios
		</div>
		<div class='card-body'>
				 <div class="form-group row">
				   <label class="control-label col-sm-2" for="">Numero:</label>
				   <div class="col-sm-10">
					 <input type="text" class="form-control form-control-sm" name="id" id="id" value="<?php echo $id ;?>" placeholder="Tienda" readonly>
				   </div>
				 </div>

				 <div class="form-group row">
				   <label class="control-label col-sm-2" for="">Nombre:</label>
				   <div class="col-sm-10">
					 <input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre ;?>" placeholder="Nombre del usuario" required>
				   </div>
				 </div>

				<div class="form-group row">
				  <label class="control-label col-sm-2" for="">De:</label>
				  <div class="col-sm-10">
					<?php

						echo "<select class='form-control form-control-sm' name='idtienda' id='idtienda'>";
						echo '<option disabled>Seleccione sucursal</option>';
						foreach($tienda as $v1){
							  echo '<option value="'.$v1->id.'"';
							  if($v1->id==$idtienda){
								  echo " selected";
							  }
							  echo '>'.$v1->nombre.'</option>';
						}
					  echo "</select>";
					?>
				  </div>
				</div>


				<div class="form-group row">
				 <label class="control-label col-sm-2" for="">Estado:</label>
				  <div class="col-sm-10">
					<select class="form-control form-control-sm" name="estado" id="estado">
					  <option value="1"<?php if($estado=="1") echo "selected"; ?> >Activa</option>
					  <option value="0"<?php if($estado=="0") echo "selected"; ?> >Inactivo</option>
					</select>
				  </div>
				</div>

				 <div class="form-group row">
				   <label class="control-label col-sm-2" for="">Usuario:</label>
				   <div class="col-sm-10">
					 <input type="text" class="form-control form-control-sm" name="user" id="user" value="<?php echo $user ;?>" placeholder="Usuario" required>
				   </div>
				 </div>

				 <div class="form-group row">
				 <label class="control-label col-sm-2" for="">Nivel:</label>
				  <div class="col-sm-10">
					<select class="form-control form-control-sm" name="nivel" id="nivel">
					  <option value="1"<?php if($nivel=="1") echo "selected"; ?> >1</option>
					  <option value="2"<?php if($nivel=="2") echo "selected"; ?> >2</option>
					</select>
				  </div>
				</div>
			</div>
			<div class="card-footer">
				<div class="row">
					<div class="col-sm-12">
						<button class="btn btn-warning btn-sm" type="submit"><i class='far fa-save'></i>Guardar</button>
						<?php
							if($id>0){
								echo "<button class='btn btn-warning btn-sm' type='button' is='b-link' des='a_usuarios/form_pass' omodal='1' v_id='$id'><i class='fas fa-key'></i>Contraseña</button>";
								//echo "<button type='button' class='btn btn-warning btn-sm' id='winmodal_pass' data-id='$id' data-lugar='a_usuarios/form_pass' title='Cambiar contraseña' ><i class='fas fa-key'></i>Contraseña</button>";
							}
						?>
						<button type="button" class='btn btn-warning btn-sm' id='lista_penarea' is="b-link" des='a_usuarios/lista' dix='trabajo'><i class='fas fa-undo-alt'></i>Regresar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
