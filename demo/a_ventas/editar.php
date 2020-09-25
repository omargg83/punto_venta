<?php
require_once("db_.php");
$idventa=$_REQUEST['idventa'];

$clientes = $db->clientes_lista();
//$tiendas = $db->tiendas_lista();
//$descuento = $db->descuento_lista();
$llave=date("YmdHis").rand(1,1983);

if($idventa==0){
	$idtienda=$_SESSION['idtienda'];
	$idcliente=0;
	$iddescuento=0;

	$lugar="";
	$dentrega=date("Y-m-d H:i:s");
	$entregar=0;
	$estado="Activa";
	$fecha="";
	$nombre_cli="";
	$correo_cli="";
	$telefono_cli="";
}
else{
	$pd = $db->venta($idventa);
	$idventa=$pd['idventa'];
	$idcliente=$pd['idcliente'];
	$idtienda=$pd['idtienda'];
	$iddescuento=$pd['iddescuento'];
	$lugar=$pd['lugar'];
	$entregar=$pd['entregar'];
	$dentrega=$pd['dentrega'];
	$estado=$pd['estado'];
	$fecha=$pd['fecha'];

	$cliente=$db->cliente($idcliente);
	$nombre_cli=$cliente->profesion." ".$cliente->nombre." ".$cliente->apellidop." ".$cliente->apellidom;
	$correo_cli=$cliente->correo;
	$telefono_cli=$cliente->telefono;
}
?>
<div class="container">
	<div class='card'>
		<form action="" id="form_venta" data-lugar="a_ventas/db_" data-funcion="guardar_venta" data-destino='a_ventas/editar'>
			<input type="hidden" class="form-control form-control-sm" name="llave" id="llave" value="<?php echo $llave ;?>" placeholder="Numero de compra">
			<input type="hidden" class="form-control form-control-sm" name="idcliente" id="idcliente" value="<?php echo $idcliente ;?>" placeholder="cliente">
			<div class='card-header'>Venta <?php echo $idventa; ?></div>
			<div class='card-body'>
				<div class='row'>
					<div class='col-2'>
						<label >Numero:</label>
						<input type="text" class="form-control form-control-sm" name="$idventa" id="$idventa" value="<?php echo $idventa ;?>" placeholder="Numero de compra" required readonly>
					</div>
					<div class='col-3'>
						<label>Fecha:</label>
						<input type="text" class="form-control form-control-sm" name="fecha" id="fecha" value="<?php echo $fecha ;?>" placeholder="Fecha" readonly>
					</div>

					<div class='col-3'>
						<label>Estado:</label>
						<input type="text" class="form-control form-control-sm" name="estado" id="estado" value="<?php echo $estado ;?>" placeholder="Lugar de entrega" readonly>
					</div>
				</div>
					<?php
						echo "<div class='row'>";
							echo "<div class='col-8'>";
								echo "<label>Nombre:</label>";
									echo "<input type='text' class='form-control form-control-sm' id='nombre' name='nombre' value='$nombre_cli' placeholder='Nombre del cliente' readonly>";
							echo "</div>";

							echo "<div class='col-4'>";
								echo "<label>Correo:</label>";
								echo "<input type='text' class='form-control form-control-sm' id='correo' name='correo' value='$correo_cli' readonly>";
							echo "</div>";

							echo "<div class='col-4'>";
								echo "<label>Teléfono:</label>";
								echo "<input type='text' class='form-control form-control-sm' id='telefono' name='telefono' value='$telefono_cli' readonly>";
							echo "</div>";
						echo "</div>";
					?>
			</div>
			<div class='card-footer'>
				<div class="row">
					<div class="col-sm-12">
						<div class='btn-group'>
							<?php
								if($estado=="Activa"){
									//echo "<button class='btn btn-warning btn-sm' type='submit'><i class='far fa-save'></i>Guardar</button>";

									echo "<button type='button' class='btn btn-warning btn-sm' id='cliente_add' v_idcliente='$idcliente' is='b-link' v_idventa='$idventa' des='a_ventas/form_cliente' omodal='1' title='Agregar Cliente'><i class='fas fa-user-tag'></i>Cliente</button>";
									echo "<button type='button' class='btn btn-warning btn-sm' id='producto_add' is='b-link' v_idventa='$idventa' des='a_ventas/form_producto' omodal='1' title='Agregar Producto'><i class='fab fa-product-hunt'></i>Producto</button>";



									echo "<button type='button' class='btn btn-warning btn-sm' id='winmodal_citas' data-id='0' data-id2='$idventa' data-lugar='a_ventas/form_citas'>+ <i class='far fa-calendar-check'></i>Citas</button>";

									echo "<button type='button' class='btn btn-warning btn-sm' id='winmodal_finalizar' data-id='$idventa' data-lugar='a_ventas/finalizar'><i class='fas fa-cash-register'></i> Finalizar Venta</button>";
                }
								if($estado=="Pagada"){
								//	echo "<button type='button' class='btn btn-warning btn-sm' onclick='imprime($idventa)'><i class='fas fa-print'></i>Imprimir</button>";
									echo "<button type='button' class='btn btn-warning btn-sm' onclick='imprime_pdf($idventa)'><i class='fas fa-print'></i>Imprimir PDF</button>";
									echo "<button type='button' class='btn btn-warning btn-sm' title='Nuevo' id='new_personal' data-lugar='a_ventas/editar'><i class='fas fa-plus'></i><span>Nuevo</span></a></button>";
								}
              ?>
							<button type='button' class='btn btn-warning btn-sm' id='lista_penarea' is='b-link' des='a_ventas/lista' dix='trabajo' title='regresar'><i class='fas fa-undo-alt'></i>Regresar</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<?php
			echo "<div class='card-body' id='compras'>";
				include 'lista_pedido.php';
			echo "</div>";
		?>
	</div>
</div>