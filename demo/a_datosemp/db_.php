<?php
require_once("../control_db.php");

class Datosemp extends Sagyc{
	public $nivel_personal;
	public $nivel_captura;
	public function __construct(){
		parent::__construct();


		if(isset($_SESSION['idpersona']) and $_SESSION['autoriza'] == 1) {

		}
		else{
			include "../error.php";
			die();
		}
	}
	public function datosemp_lista(){
		try{

			$sql="SELECT * FROM datosemp";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function datosemp($id){
		try{

		  $sql="select * from datosemp where idemp=:id";
		  $sth = $this->dbh->prepare($sql);
		  $sth->bindValue(":id",$id);
		  $sth->execute();
		  return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
		  return "Database access FAILED!".$e->getMessage();
		}
	}
	public function guardar_datosemp(){
		$x="";
		$arreglo =array();

		$id=$_REQUEST['id'];
		if (isset($_REQUEST['razon'])){
			$arreglo+=array('razon'=>$_REQUEST['razon']);
		}
		if (isset($_REQUEST['calle'])){
			$arreglo+=array('calle'=>$_REQUEST['calle']);
		}
		if (isset($_REQUEST['no'])){
			$arreglo+=array('no'=>$_REQUEST['no']);
		}
		if (isset($_REQUEST['col'])){
			$arreglo+=array('col'=>$_REQUEST['col']);
		}
		if (isset($_REQUEST['ciudad'])){
			$arreglo+=array('ciudad'=>$_REQUEST['ciudad']);
		}
		if (isset($_REQUEST['estado'])){
			$arreglo+=array('estado'=>$_REQUEST['estado']);
		}

		if($id==0){
			$x=$this->insert('datosemp', $arreglo);
		}
		else{
			$x=$this->update('datosemp',array('idemp'=>$id), $arreglo);
		}
		return $x;
	}
}

$db = new Datosemp();
if(strlen($function)>0){
	echo $db->$function();
}
