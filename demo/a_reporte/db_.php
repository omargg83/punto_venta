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

	public function emitidas(){
		try{

			$desde=$_REQUEST['desde'];
			$hasta=$_REQUEST['hasta'];

			$desde = date("Y-m-d", strtotime($desde))." 00:00:00";
			$hasta = date("Y-m-d", strtotime($hasta))." 23:59:59";

			$sql="select et_venta.idventa, et_venta.idtienda, et_venta.iddescuento, et_venta.factura, clientes.nombre as nombrecli, et_tienda.nombre, et_venta.total, et_venta.fecha, et_venta.gtotal, et_venta.estado from et_venta
			left outer join clientes on clientes.idcliente=et_venta.idcliente
			left outer join et_tienda on et_tienda.id=et_venta.idtienda where (et_venta.fecha BETWEEN :fecha1 AND :fecha2)";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":fecha1",$desde);
			$sth->bindValue(":fecha2",$hasta);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
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
