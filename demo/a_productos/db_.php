<?php
require_once("../control_db.php");

if($_SESSION['des']==1 and strlen($function)==0)
{
	echo "<div class='alert alert-primary' role='alert'>";
	$arrayx=explode('/', $_SERVER['SCRIPT_NAME']);
	echo print_r($arrayx);
	echo "</div>";
}
class Productos extends Sagyc{
	public $nivel_personal;
	public $nivel_captura;
	public function __construct(){
		parent::__construct();

		$this->doc="a_imagenextra/";

		if(isset($_SESSION['idpersona']) and $_SESSION['autoriza'] == 1) {

		}
		else{
			include "../error.php";
			die();
		}

	}
	public function producto_buscar($texto){
		$sql="select * from productos where productos.nombre like '%$texto%'";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_OBJ);
  }

	public function productos_lista(){
		try{
			$sql="SELECT * from productos where activo=1  and idventa is null order by tipo asc,id asc limit 100";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}

	public function borrar_producto(){
		if (isset($_REQUEST['id'])){ $id=$_REQUEST['id']; }
		return $this->borrar('productos',"id",$id);
	}

	public function producto_editar($id){
		try{

			$sql="select * from productos where id=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(':id', "$id");
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function guardar_producto(){
		try{
			if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
			$arreglo =array();
			$tipo="";
			$imei="";
			if (isset($_REQUEST['codigo'])){
				$arreglo += array('codigo'=>$_REQUEST['codigo']);
			}
			if (isset($_REQUEST['nombre'])){
				$arreglo += array('nombre'=>$_REQUEST['nombre']);
			}
			if (isset($_REQUEST['unidad'])){
				$arreglo += array('unidad'=>$_REQUEST['unidad']);
			}
			if (isset($_REQUEST['marca'])){
				$arreglo += array('marca'=>$_REQUEST['marca']);
			}
			if (isset($_REQUEST['marca'])){
				$arreglo += array('marca'=>$_REQUEST['marca']);
			}
			if (isset($_REQUEST['modelo'])){
				$arreglo += array('modelo'=>$_REQUEST['modelo']);
			}
			if (isset($_REQUEST['descripcion'])){
				$arreglo += array('descripcion'=>$_REQUEST['descripcion']);
			}
			if (isset($_REQUEST['activo'])){
				$arreglo += array('activo'=>$_REQUEST['activo']);
			}
			if (isset($_REQUEST['rapido'])){
				$arreglo += array('rapido'=>$_REQUEST['rapido']);
			}
			if (isset($_REQUEST['color'])){
				$arreglo += array('color'=>$_REQUEST['color']);
			}
			if (isset($_REQUEST['material'])){
				$arreglo += array('material'=>$_REQUEST['material']);
			}
			if (isset($_REQUEST['imei'])){
				$imei=$_REQUEST['imei'];
				$arreglo += array('imei'=>$imei);
			}
			if (isset($_REQUEST['precio'])){
				$arreglo += array('precio'=>$_REQUEST['precio']);
			}
			if (isset($_REQUEST['preciocompra']) and strlen($_REQUEST['preciocompra'])>0  ){
				$arreglo += array('preciocompra'=>$_REQUEST['preciocompra']);
			}
			else{
				$arreglo += array('preciocompra'=>NULL);
			}

			if (isset($_REQUEST['tipo'])){
				$tipo=$_REQUEST['tipo'];
				$arreglo += array('tipo'=>$_REQUEST['tipo']);
			}
			$x="";

			if(strlen($imei)>0){
				$sql="select * from productos where imei=:id";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(':id', "$imei");
				$sth->execute();
				$resp=$sth->fetch(PDO::FETCH_OBJ);
				if(!$resp){

				}
				else{
					if($id==$resp->id){

					}
					else{
						return "Ya existe un producto con el IMEI";
					}
				}
			}

			if($tipo==0 or $tipo==1  or $tipo==2){
					$arreglo += array('cantidad'=>1);
			}
			if($tipo==3){
				if($id>0){
					$this->cantidad_update($id);
				}
			}
			if($tipo==4){
				$arreglo += array('cantidad'=>1);
			}


			if($id==0){

				$arreglo+=array('fechaalta'=>date("Y-m-d H:i:s"));
				$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
				$x=$this->insert('productos', $arreglo);
				$ped=json_decode($x);
				if($ped->error==0){
					$id=$ped->id;
					$codigo="9".str_pad($id, 8, "0", STR_PAD_LEFT);
					$arreglo =array();
					$arreglo = array('codigo'=>$codigo);
					$this->update('productos',array('id'=>$id), $arreglo);
				}
				return $x;
			}
			else{
				$arreglo+=array('fechamod'=>date("Y-m-d H:i:s"));
				$x=$this->update('productos',array('id'=>$id), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}

	public function genera_barras(){
		try{
			parent::set_names();
			$id=$_REQUEST['id'];
			$codigo="9".str_pad($id, 8, "0", STR_PAD_LEFT);
			$arreglo =array();

			$arreglo = array('codigo'=>$codigo);
			$arreglo+=array('fechamod'=>date("Y-m-d H:i:s"));
			$x=$this->update('productos',array('id'=>$id), $arreglo);
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function existencia_agrega(){
		try{

			if($_REQUEST['cantidad']<1){
				$arreglo =array();
				$arreglo+=array('id'=>$idproducto);
				$arreglo+=array('error'=>1);
				$arreglo+=array('terror'=>"Error de cantidad, favor de verificar");
				return json_encode($arreglo);
			}


			$id=$_REQUEST['id'];
			$idproducto=$_REQUEST['idproducto'];
			$arreglo =array();
			$arreglo = array('idproducto'=>$idproducto);
			if (isset($_REQUEST['cantidad'])){
				$arreglo += array('cantidad'=>$_REQUEST['cantidad']);
			}
			if (isset($_REQUEST['nota'])){
				$arreglo += array('nota'=>$_REQUEST['nota']);
			}
			if (isset($_REQUEST['fecha'])){
				$fx=explode("-",$_REQUEST['fecha']);
				$arreglo+=array('fecha'=>$fx['2']."-".$fx['1']."-".$fx['0']);
			}
			$x="";
			if($id==0){
				$arreglo+=array('fechaalta'=>date("Y-m-d H:i:s"));
				$arreglo+=array('idpersona'=>$_SESSION['idpersona']);
				$arreglo+=array('idtienda'=>$_SESSION['idtienda']);
				$x=$this->insert('bodega', $arreglo);
			}
			else{
				$arreglo+=array('fechamod'=>date("Y-m-d H:i:s"));
				$x=$this->update('bodega',array('id'=>$id), $arreglo);
			}
			$ped=json_decode($x);
			if($ped->error==0){
				$arreglo =array();
				$arreglo+=array('id'=>$idproducto);
				$arreglo+=array('error'=>0);
				$arreglo+=array('terror'=>0);
				$arreglo+=array('param1'=>"");
				$arreglo+=array('param2'=>"");
				$arreglo+=array('param3'=>"");
				return json_encode($arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function productos_inventario($id){
		try{
			$sql="select * from bodega where idproducto=:id order by id desc";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(':id', "$id");
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function borrar_ingreso(){
		$id=$_REQUEST['id'];
		$idproducto=$_REQUEST['idproducto'];

		$sql="SELECT * from bodega where id=:id";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":id",$id);
		$sth->execute();
		$res=$sth->fetch(PDO::FETCH_OBJ);

		$x=$this->borrar('bodega',"id",$id);

		$arreglo =array();
		$arreglo+=array('id'=>$idproducto);
		$arreglo+=array('error'=>0);
		$arreglo+=array('terror'=>0);
		return json_encode($arreglo);
	}


}
$db = new Productos();
if(strlen($function)>0){
	echo $db->$function();
}
?>
