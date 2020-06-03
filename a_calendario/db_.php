<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class Pedidos extends Sagyc{

	public function __construct(){
		parent::__construct();
	}
	public function citas_calendario($inicio,$fin){
		try{
			parent::set_names();
			$inicio=$inicio." 00:00:00";
			$fin=$fin." 23:59:59";
			$sql="SELECT * from citas left outer join clientes on clientes.idcliente=citas.idcliente
			where citas.fecha between '$inicio' and '$fin' order by citas.idcitas desc";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function info($id){
		try{
			parent::set_names();
			$sql="SELECT * from citas where idcitas=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(':id', "$id");
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function cambiar_dia(){
		try{
			$horario=$_REQUEST['horario'];
			$idcita=$_REQUEST['idcita'];

			$fx=explode(" ",$horario);
			$fecha=$fx[0];
			$hora=$fx[1];

			$fx=explode("/",$fecha);
			$dia=$fx[0];
			$mes=$fx[1];
			$anio=$fx[2];
			$arreglo=array();
			$arreglo+= array('fecha'=>"$anio-$mes-$dia $hora");
			$x=$this->update('citas',array('idcitas'=>$idcita), $arreglo);
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}

	}
	public function cambiar_hora(){
		try{
			$horario=$_REQUEST['horario'];
			$horario2=$_REQUEST['horario2'];
			$idcita=$_REQUEST['idcita'];

			$fx=explode(" ",$horario);
			$fecha=$fx[0];
			$hora=$fx[1];

			$fx=explode("/",$fecha);
			$dia=$fx[0];
			$mes=$fx[1];
			$anio=$fx[2];
			$fecha1=$anio."-".$mes."-".$dia." ".$hora;

			$fx=explode(" ",$horario2);
			$fecha=$fx[0];
			$hora=$fx[1];

			$fx=explode("/",$fecha);
			$dia=$fx[0];
			$mes=$fx[1];
			$anio=$fx[2];
			$fecha2=$anio."-".$mes."-".$dia." ".$hora;

			$arreglo=array();
			$arreglo+= array('fecha'=>$fecha1);
			$arreglo+= array('fecha_fin'=>$fecha2);
			$x=$this->update('citas',array('idcitas'=>$idcita), $arreglo);
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}

	}

}
$db = new Pedidos();
if(strlen($function)>0){
	echo $db->$function();
}
?>
