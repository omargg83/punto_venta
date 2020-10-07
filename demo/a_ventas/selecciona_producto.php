<?php
	require_once("db_.php");
	$idproducto=$_REQUEST['idproducto'];
	$idventa=$_REQUEST['idventa'];

	$sql="SELECT * from productos where id=:id";
	$sth = $db->dbh->prepare($sql);
	$sth->bindValue(":id",$idproducto);
	$sth->execute();
	$res=$sth->fetch(PDO::FETCH_OBJ);

	echo "<form id='form_producto' is='f-submit' db='a_ventas/db_' fun='agregaventa' des='a_ventas/editar' desid='idventa' cmodal='2'>";
	echo "<input type='hidden' name='idventa' id='idventa' value='$idventa' readonly>";
	echo "<input type='hidden' name='idproducto' id='idproducto' value='$idproducto' readonly>";
	echo "<input type='hidden' name='tipo' id='tipo' value='".$res->tipo."' readonly>";
	echo "<div class='row'>";

		echo "<div class='col-12'>";
			echo "<label>Tipo:</label>";
				if($res->tipo=="0") echo " Registro (solo registra ventas, no es necesario registrar entrada)";
				if($res->tipo=="1") echo " Pago de linea";
				if($res->tipo=="2") echo " Reparación";
				if($res->tipo=="3") echo " Volúmen (Se controla el inventario por volúmen)";
				if($res->tipo=="4") echo " Unico (se controla inventario por pieza única)";
			echo "</select>";
		echo "</div>";

		echo "<div class='col-12'>";
			echo "<label>Nombre:</label>";
			echo "<input type='text' class='form-control form-control-sm' name='nombre' id='nombre' value='".$res->nombre."' readonly>";
		echo "</div>";

		if($res->tipo==1 or $res->tipo==3 or $res->tipo==4){
			echo "<div class='col-3'>";
				echo "<label>Barras</label>";
				echo "<input type='text' class='form-control form-control-sm' name='codigo' id='codigo' value='".$res->codigo."' readonly>";
			echo "</div>";
		}
		if($res->tipo==1 or $res->tipo==3 or $res->tipo==4){
			echo "<div class='col-3'>";
				echo "<label>Marca</label>";
				echo "<input type='text' class='form-control form-control-sm' name='marca' id='marca' value='".$res->marca."' readonly>";
			echo "</div>";
		}

		if($res->tipo==1 or $res->tipo==3 or $res->tipo==4){
			echo "<div class='col-3'>";
				echo "<label>Modelo</label>";
				echo "<input type='text' class='form-control form-control-sm' name='modelo' id='modelo' value='".$res->nombre."' readonly>";
			echo "</div>";
		}

		if($res->tipo==1 or $res->tipo==3 or $res->tipo==4){
			echo "<div class='col-3'>";
				echo "<label>IMEI</label>";
				echo "<input type='text' class='form-control form-control-sm' name='imei' id='imei' value='".$res->imei."' readonly>";
			echo "</div>";
		}
		echo "<div class='col-2'>";
			echo "<label>Existencia:</label>";
			echo "<input type='text' class='form-control form-control-sm' name='existencia' id='existencia' value='".$res->cantidad."' readonly>";
		echo "</div>";
		if($res->tipo==0 or $res->tipo==1 or $res->tipo==2 or $res->tipo==3 or $res->tipo==4){
			echo "<div class='col-3'>";
				echo "<label>Cantidad</label>";
				echo "<input type='text' class='form-control form-control-sm' name='cantidad' id='cantidad' value='1'";
					if($res->tipo==0 or $res->tipo==2 or $res->tipo==4){
						echo " readonly";
					}
				echo ">";
			echo "</div>";
		}
		if($res->tipo==0 or $res->tipo==1 or $res->tipo==2 or $res->tipo==3 or $res->tipo==4){
			echo "<div class='col-3'>";
				echo "<label>Precio</label>";
				echo "<input type='text' class='form-control form-control-sm' name='precio' id='precio' value='".$res->precio."' ";
					if($res->tipo==0){
						echo "";
					}
				echo ">";
			echo "</div>";
		}
		if($res->tipo==0 or $res->tipo==1 or $res->tipo==2 or $res->tipo==3 or $res->tipo==4){
			echo "<div class='col-12'>";
				echo "<label>Observaciones</label>";
				echo "<input type='text' class='form-control form-control-sm' name='observaciones' id='observaciones' value='' placeholder='Observaciones'>";
			echo "</div>";
		}
		if($res->tipo==2){
			echo "<div class='col-12'>";
				echo "<label>Cliente:</label>";
				echo "<input type='text' class='form-control form-control-sm' name='cliente' id='cliente' value='' placeholder='Cliente'>";
			echo "</div>";
		}

	echo "</div>";
	echo "<hr>";
	echo "<div class='row'>";
		echo "<div class='col-12'>";
			echo "<div class='btn-group'>";
				echo "<button type='submit' class='btn btn-warning btn-sm'><i class='fas fa-cart-plus'></i>Agregar</button>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
	echo "</form>";
?>
