<?php
require_once("../control_db.php");

if($_SESSION['des']==1 and strlen($function)==0)
{
	echo "<div class='alert alert-primary' role='alert'>";
	$arrayx=explode('/', $_SERVER['SCRIPT_NAME']);
	echo print_r($arrayx);
	echo "</div>";
}


class Venta extends Sagyc{
	public $nivel_personal;
	public $nivel_captura;

	public function __construct(){
		parent::__construct();
		$this->doc="a_clientes/papeles/";

		if(isset($_SESSION['idpersona']) and $_SESSION['autoriza'] == 1) {

		}
		else{
			include "../error.php";
			die();
		}
	}

	public function ventas_lista(){

			$sql="select et_venta.idventa, et_venta.idtienda, et_venta.iddescuento, et_venta.factura, clientes.nombre, et_tienda.nombre as tienda, et_venta.total, et_venta.fecha, et_venta.gtotal, et_venta.estado, et_descuento.nombre as descuento from et_venta
			left outer join clientes on clientes.idcliente=et_venta.idcliente
			left outer join et_descuento on et_descuento.iddescuento=et_venta.iddescuento
			left outer join et_tienda on et_tienda.id=et_venta.idtienda where et_venta.idtienda='".$_SESSION['idtienda']."' and et_venta.estado='Activa' order by et_venta.fecha desc";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
	public function ventas_buscar($texto){
			$sql="select et_venta.idventa, et_venta.idtienda, et_venta.iddescuento, et_venta.factura, clientes.nombre, et_tienda.nombre as tienda, et_venta.total, et_venta.fecha, et_venta.gtotal, et_venta.estado, et_descuento.nombre as descuento from et_venta
			left outer join clientes on clientes.idcliente=et_venta.idcliente
			left outer join et_descuento on et_descuento.iddescuento=et_venta.iddescuento
			left outer join et_tienda on et_tienda.id=et_venta.idtienda where et_venta.idtienda='".$_SESSION['idtienda']."' and (et_venta.idventa like '%$texto%' or clientes.nombre like '%$texto%') order by et_venta.fecha desc limit 100";

			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
	  }
	public function cliente($idcliente){
		try{
			$sql="select * from clientes where idcliente='$idcliente'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}

	public function agrega_cliente(){
		try{
			$idventa=$_REQUEST['idventa'];
			$idcliente=$_REQUEST['idcliente'];
			if($idventa==0){
				$arreglo=array();
				$arreglo+=array('idcliente'=>$idcliente);
				$arreglo+=array('estado'=>"Activa");
				$date=date("Y-m-d H:i:s");
				$arreglo+=array('fecha'=>$date);
				$arreglo+=array('idusuario'=>$_SESSION['idpersona']);
				$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
				$x=$this->insert('et_venta', $arreglo);
			}
			else{
				$arreglo=array();
				$arreglo+=array('idcliente'=>$idcliente);
				$x=$this->update('et_venta',array('idventa'=>$idventa), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}

	public function venta($id){

		$this->total_venta($id);

		$sql="select * from et_venta where idventa='$id'";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetch();
	}

	public function selecciona_cita(){
		try{

			$idcita=$_REQUEST['idcita'];
			$idventa=$_REQUEST['idventa'];

			$sql="SELECT * from citas where idcitas=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$idcita);
			$sth->execute();
			$row=$sth->fetch(PDO::FETCH_OBJ);

			$fech = new DateTime($row->fecha);
			$fecha=$fech->format('d-m-Y');
			$hora=$fech->format('H');
			$minuto=$fech->format('i');

			$estatus=$row->estatus;
			$observaciones=$row->observaciones;
			$idcliente=$row->idcliente;
			$cubiculo=$row->cubiculo;
			$atiende=$row->atiende;
			$servicio=$row->servicio;
			$precio=$row->precio;

			$cliente=$this->cliente($idcliente);
			$nombre_cli=$cliente->profesion." ".$cliente->nombre." ".$cliente->apellidop." ".$cliente->apellidom;
			$correo_cli=$cliente->correo;
			$telefono_cli=$cliente->telefono;


			echo "<form id='form_producto' action='' data-lugar='a_ventas/db_' data-destino='a_ventas/editar' data-funcion='agregaventa'>";
			echo "<input type='hidden' name='idventa' id='idventa' value='$idventa' readonly>";
			echo "<input type='hidden' name='idcita' id='idcita' value='$idcita' readonly>";
			echo "<input type='hidden' name='tipo' id='tipo' value='99' readonly>";
			echo "<div class='row'>";

				echo "<div class='col-3'>";
					echo "<label>Fecha</label>";
					echo "<input type='text' class='form-control form-control-sm fechaclass' id='fechac' name='fechac' value='$fecha' readonly>";
				echo "</div>";

				echo "<div class='col-3'>";
					echo "<label>Hora</label>";
					echo "<input type='text' class='form-control form-control-sm fechaclass' id='horac' name='horac' value='$hora:$minuto' readonly>";
				echo "</div>";

				echo "<div class='col-3'>";
					echo "<label>Estado</label>";
					echo "<input type='text' class='form-control form-control-sm fechaclass' id='estadoc' name='estadoc' value='$estatus' readonly>";
				echo "</div>";

				echo "<div class='col-6'>";
					echo "<label>Nombre:</label>";
					echo "<input type='text' class='form-control form-control-sm' name='nombrec' id='nombrec' value='".$nombre_cli."' readonly>";
				echo "</div>";

				echo "<div class='col-6'>";
					echo "<label>Correo:</label>";
					echo "<input type='text' class='form-control form-control-sm' name='correoc' id='correoc' value='".$correo_cli."' readonly>";
				echo "</div>";

				echo "<div class='col-2'>";
					echo "<label>Cubiculo</label>";
					echo "<input type='text' class='form-control form-control-sm' name='cubiculoc' id='cubiculoc' value='".$cubiculo."' readonly>";
				echo "</div>";

				echo "<div class='col-4'>";
					echo "<label>Atiende</label>";
					echo "<input type='text' class='form-control form-control-sm' name='atiendec' id='atiendec' value='".$atiende."' readonly>";
				echo "</div>";

				echo "<div class='col-6'>";
					echo "<label>Servicio</label>";
					echo "<input type='text' class='form-control form-control-sm' name='servicioc' id='servicioc' value='".$servicio."' readonly>";
				echo "</div>";

				echo "<div class='col-12'>";
					echo "<label>Notas:</label>";
					echo "<input type='text' class='form-control form-control-sm' name='observacionesc' id='observacionesc' value='".$observaciones."' readonly>";
				echo "</div>";

				echo "<div class='col-3'>";
					echo "<label>Precio</label>";
					echo "<input type='text' class='form-control form-control-sm' name='precio' id='precio' value='$precio'>";
				echo "</div>";

			echo "</div>";
			echo "<hr>";
			echo "<div class='row'>";
				echo "<div class='col-12'>";
					echo "<div class='btn-group'>";
						echo "<button type='submit' class='btn btn-outline-info btn-sm'><i class='fas fa-cart-plus'></i>Agregar</button>";
						echo "<button type='button' class='btn btn-outline-primary btn-sm' data-dismiss='modal'><i class='fas fa-sign-out-alt'></i>Cerrar</button>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			echo "</form>";

		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}

	public function agregaventa(){

		$x="";
		$cliente="";
		$observaciones="";
		$cantidad="0";
		$precio="0";
		$tipo="0";
		$idventa=$_REQUEST['idventa'];

		if(isset($_REQUEST['idproducto'])){
			$idproducto=$_REQUEST['idproducto'];
			$cantidad=$_REQUEST['cantidad'];

			$sql="select * from productos where id='$idproducto'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			$res=$sth->fetch(PDO::FETCH_OBJ);
			if($res->cantidad<$cantidad){
				$arreglo =array();
				$arreglo+=array('id'=>0);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>"No hay suficientes productos en el inventario");
				return json_encode($arreglo);
			}
		}
		else{
			$cantidad=0;
		}
		if (isset($_REQUEST['observaciones'])){
			$observaciones=$_REQUEST['observaciones'];
		}

		if (isset($_REQUEST['precio'])){
			$precio=$_REQUEST['precio'];
		}
		if (isset($_REQUEST['cliente'])){
			$cliente=$_REQUEST['cliente'];
		}
		$tipo=$_REQUEST['tipo'];

		try{

			if($idventa==0){
				$arreglo=array();
				$arreglo+=array('idcliente'=>1);
				$arreglo+=array('estado'=>"Activa");
				$date=date("Y-m-d H:i:s");
				$arreglo+=array('fecha'=>$date);
				$arreglo+=array('idusuario'=>$_SESSION['idpersona']);
				$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
				$x=$this->insert('et_venta', $arreglo);
				$ped=json_decode($x);
				if($ped->error==0){
					$idventa=$ped->id;
				}
				else{
						return $x;
				}
			}


			if(isset($_REQUEST['idcita'])){
				$idcitas=$_REQUEST['idcita'];
				$sql="update bodega set idventa=$idventa where idcitas=$idcitas";
				$sth = $this->dbh->prepare($sql);
				$sth->execute();
			}

			if($tipo<80){
				$sql="SELECT * from productos where id=:id";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":id",$idproducto);
				$sth->execute();
				$res=$sth->fetch(PDO::FETCH_OBJ);

				////////////////////////////////////////////////////////
				$arreglo=array();
				$arreglo+=array('idventa'=>$idventa);
				$arreglo+=array('idproducto'=>$idproducto);
				$arreglo+=array('idpersona'=>$_SESSION['idpersona']);
				$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
				$arreglo+=array('codigo'=>$res->codigo);
				$arreglo+=array('tipo'=>$tipo);
				$arreglo+=array('nombre'=>$res->nombre);
				$arreglo+=array('observaciones'=>$observaciones);
				$arreglo+=array('cliente'=>$cliente);
				if($tipo==3){
					$arreglo+=array('cantidad'=>$cantidad*-1);
				}
				$arreglo+=array('v_cantidad'=>$cantidad);
				$arreglo+=array('v_precio'=>$precio);
				$total=$precio*$cantidad;
				$arreglo+=array('v_total'=>$total);
				if($tipo==4){
					$arreglo+=array('v_marca'=>$res->marca);
					$arreglo+=array('v_modelo'=>$res->modelo);
					$arreglo+=array('v_imei'=>$res->imei);
				}
				//$arreglo+=array('v_total'=>$total);
				$x=$this->insert('bodega', $arreglo);
				$ped=json_decode($x);

				if($ped->error==0){
					{
						$this->total_venta($idventa);
					}

					///////////////////////////////////////////////////actualiza producto tipo idn_to_unicode
					if($tipo==4){
						$sql="update productos set idventa=:idventa where id=:id";
						$sth = $this->dbh->prepare($sql);
						$sth->bindValue(":idventa",$idventa);
						$sth->bindValue(":id",$idproducto);
						$sth->execute();
					}

					if($tipo==3){
						/////////////para
					 $this->cantidad_update($idproducto);
					}




					$arreglo =array();
					$arreglo+=array('id'=>$idventa);
					$arreglo+=array('error'=>0);
					$arreglo+=array('terror'=>0);
					$arreglo+=array('param1'=>"");
					$arreglo+=array('param2'=>"");
					$arreglo+=array('param3'=>"");
					return json_encode($arreglo);
				}
				else{
						return $x;
				}
			}
			else{

				$fechac=$_REQUEST['fechac'];
				$horac=$_REQUEST['horac'];
				$estadoc=$_REQUEST['estadoc'];
				$nombrec=$_REQUEST['nombrec'];
				$correoc=$_REQUEST['correoc'];
				$cubiculoc=$_REQUEST['cubiculoc'];
				$atiendec=$_REQUEST['atiendec'];
				$servicioc=$_REQUEST['servicioc'];


				$arreglo=array();
				$arreglo+=array('observaciones'=>$observaciones);

				$nombre=$servicioc;
				$cantidad=1;

				$arreglo=array();
				$arreglo+=array('idventa'=>$idventa);
				$arreglo+=array('idpersona'=>$_SESSION['idpersona']);
				$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
				$arreglo+=array('tipo'=>$tipo);
				$arreglo+=array('nombre'=>$nombre);
				$arreglo+=array('observaciones'=>$observaciones);
				$arreglo+=array('cliente'=>$cliente);
				$arreglo+=array('cantidad'=>$cantidad);
				$arreglo+=array('v_cantidad'=>$cantidad);
				$arreglo+=array('v_precio'=>$precio);
				$total=$precio*$cantidad;
				$arreglo+=array('v_total'=>$total);
				$x=$this->insert('bodega', $arreglo);

				$arreglo =array();
				$arreglo+=array('id'=>$idventa);
				$arreglo+=array('error'=>0);
				$arreglo+=array('terror'=>0);
				$arreglo+=array('param1'=>"");
				$arreglo+=array('param2'=>"");
				$arreglo+=array('param3'=>"");
				return json_encode($arreglo);
			}
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function borrar_venta(){

		$id=$_REQUEST['id'];

		$sql="SELECT * from bodega where id=:id";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":id",$id);
		$sth->execute();
		$res=$sth->fetch(PDO::FETCH_OBJ);

		$x=$this->borrar('bodega',"id",$id);

		if($res->tipo==4){
			$sql="update productos set idventa=NULL where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$res->idproducto);
			$sth->execute();
		}

		if($res->tipo==3){
			$this->cantidad_update($res->idproducto);
		}

		$this->total_venta($res->idventa);
		return $x;
	}
	public function ventas_pedido($id){

		$sql="select * from bodega where idventa='$id' order by id desc";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}

	public function buscar($texto){

		$texto=trim($texto);
		if(strlen($texto)>0){
			$sql="select et_venta.idventa, et_venta.idtienda, et_venta.iddescuento, et_venta.factura, clientes.nombre, et_tienda.nombre, et_venta.total, et_venta.fecha, et_venta.gtotal, et_venta.estado, et_descuento.nombre as descuento from et_venta
			left outer join clientes on clientes.idcliente=et_venta.idcliente
			left outer join et_descuento on et_descuento.iddescuento=et_venta.iddescuento
			left outer join et_tienda on et_tienda.id=et_venta.idtienda where et_venta.idtienda='".$_SESSION['idtienda']."' and (et_venta.idventa like '%$texto%' or clientes.nombre like '%$texto%' or et_venta.estado like '%$texto%' or et_venta.total like '%$texto%') order by et_venta.fecha desc";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
	}
	public function clientes_lista(){

		$sql="SELECT * FROM clientes";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}
	public function tiendas_lista(){

		$sql="SELECT * FROM et_tienda where id='".$_SESSION['idtienda']."'";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}
	public function descuento_lista(){

		$sql="SELECT * FROM et_descuento";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}
	public function guardar_venta(){
		$x="";

		$arreglo =array();
		$id=$_REQUEST['id'];
		if (isset($_REQUEST['idcliente'])){
			$arreglo+=array('idcliente'=>$_REQUEST['idcliente']);
		}
		if (isset($_REQUEST['iddescuento'])){
			$arreglo+=array('iddescuento'=>$_REQUEST['iddescuento']);
		}
		if (isset($_REQUEST['lugar'])){
			$arreglo+=array('lugar'=>$_REQUEST['lugar']);
		}
		if (isset($_REQUEST['entregarp'])){
			$arreglo+=array('entregarp'=>$_REQUEST['entregarp']);
		}
		if (isset($_REQUEST['estado'])){
			$arreglo+=array('estado'=>$_REQUEST['estado']);
		}
		if (isset($_REQUEST['factura'])){
			$arreglo+=array('factura'=>$_REQUEST['factura']);
		}
		if (isset($_REQUEST['llave'])){
			$llave=$_REQUEST['llave'];
			$arreglo+=array('llave'=>$llave);
		}

		if($id==0){
			$date=date("Y-m-d H:i:s");
			$arreglo+=array('fecha'=>$date);
			$arreglo+=array('idusuario'=>$_SESSION['idpersona']);
			$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
			$this->insert('et_venta', $arreglo);

			$sql="select * from et_venta where llave='$llave' and idusuario='".$_SESSION['idpersona']."'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			$res=$sth->fetch();
			return $res['idventa'];
		}
		else{
			$x.=$this->update('et_venta',array('idventa'=>$id), $arreglo);
			{
				$sql="select sum(gtotalv) as gtotal from et_bodega where idventa=:texto";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":texto",$id);
				$sth->execute();
				$res=$sth->fetch();
				$gtotal=$res['gtotal'];

				$subtotal=$gtotal/1.16;
				$iva=$gtotal-$subtotal;

				$values = array('subtotal'=>$subtotal, 'iva'=>$iva, 'total'=>$gtotal, 'gtotal'=>$gtotal );
				$this->update('et_venta',array('idventa'=>$id), $values);
			}
		}
		return $x;
	}

	public function imprimir(){

		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		$arreglo =array();
		$arreglo+=array('imprimir'=>1);
		return $this->update('et_venta',array('idventa'=>$id), $arreglo);
	}
	public function finalizar_venta(){

		$total_g=clean_var($_REQUEST['total_g']);
		$efectivo_g=clean_var($_REQUEST['efectivo_g']);
		$cambio_g=clean_var($_REQUEST['cambio_g']);
		$tipo_pago=clean_var($_REQUEST['tipo_pago']);

		if($total_g>0){
			if($total_g<=$efectivo_g){
				if (isset($_REQUEST['idventa'])){$idventa=$_REQUEST['idventa'];}
				$arreglo =array();
				$arreglo+=array('tipo_pago'=>$tipo_pago);
				$arreglo+=array('estado'=>"Pagada");
				return $this->update('et_venta',array('idventa'=>$idventa), $arreglo);
			}
			else{
				return "favor de verificar";
			}
		}
		else{
			return "Debe de agregar un producto";
		}
	}

	
	public function productos_vendidos(){
		try{


			$idusuario=$_REQUEST['idusuario'];
			$desde=$_REQUEST['desde'];
			$hasta=$_REQUEST['hasta'];

			$desde = date("Y-m-d", strtotime($desde))." 00:00:00";
			$hasta = date("Y-m-d", strtotime($hasta))." 23:59:59";

			$sql="SELECT et_venta.idventa, et_venta.idtienda,	et_venta.iddescuento,	et_venta.factura, clientes.nombre, et_tienda.nombre, et_venta.total, et_venta.fecha, et_venta.gtotal, et_venta.estado,			bodega.v_cantidad, bodega.v_precio,	bodega.v_total,	bodega.nombre, bodega.observaciones, bodega.cliente, usuarios.nombre as vendedor FROM	bodega
				LEFT OUTER JOIN et_venta ON et_venta.idventa = bodega.idventa
				LEFT OUTER JOIN usuarios ON usuarios.idusuario = et_venta.idusuario
				left outer join productos on productos.id=bodega.idproducto
				LEFT OUTER JOIN clientes ON clientes.idcliente = et_venta.idcliente
				LEFT OUTER JOIN et_tienda ON et_tienda.id = et_venta.idtienda
				where bodega.idventa and (et_venta.fecha BETWEEN :fecha1 AND :fecha2)";
				if(strlen($idusuario)>0){
					$sql.=" and et_venta.idusuario=:idusuario";
				}
				$sql.=" order by idventa desc";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":fecha1",$desde);
			$sth->bindValue(":fecha2",$hasta);
			if(strlen($idusuario)>0){
				$sth->bindValue(":idusuario",$idusuario);
			}
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
}

$db = new Venta();
if(strlen($function)>0){
	echo $db->$function();
}
