<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class Pedidos extends Sagyc{

	public function __construct(){
		parent::__construct();
	}
	public function busca_cliente(){
		try{
			parent::set_names();
			$texto=$_REQUEST['texto'];
			$idcliente=$_REQUEST['idcliente'];
			$idcita=$_REQUEST['idcita'];

			$sql="SELECT * from clientes where nombre like '%$texto%' limit 100";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			echo "<table class='table table-sm'>";
			echo "<tr><th>-</th><th>Prof.</th><th>Nombre </th><th>Correo</th><th>Teléfono</th></tr>";
			foreach($sth->fetchAll(PDO::FETCH_OBJ) as $key){
				echo "<tr>";
					echo "<td>";
						echo "<div class='btn-group'>";
						echo "<button type='button' onclick='cliente_add(".$key->idcliente.",$idcita)' class='btn btn-outline-secondary btn-sm' title='Seleccionar cliente'><i class='fas fa-plus'></i></button>";
						echo "</div>";
					echo "</td>";
					echo "<td>";
							echo $key->profesion;
					echo "</td>";
					echo "<td>";
							echo $key->nombre." ".$key->apellidop." ".$key->apellidom;
					echo "</td>";
					echo "<td>";
							echo $key->correo;
					echo "</td>";
					echo "<td>";
							echo $key->telefono;
					echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function agrega_cliente(){
		try{
			parent::set_names();
			$x="";
			$idcliente=$_REQUEST['idcliente'];
			$sql="select * from clientes where idcliente=:id";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":id",$idcliente);
			$sth->execute();
			return json_encode($sth->fetch(PDO::FETCH_OBJ));
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function citas_lista(){
		try{
			parent::set_names();
			if (isset($_REQUEST['buscar']) and strlen(trim($_REQUEST['buscar']))>0){
				$texto=trim(htmlspecialchars($_REQUEST['buscar']));
				$sql="SELECT * from pedidos
				left outer join clientes on clientes.id=pedidos.idcliente
				where pedidos.id like '%$texto%' or pedidos.estatus like '%$texto%' or clientes.nombre like '%$texto' order by pedidos.id desc limit 100";
			}
			else{
				$sql="SELECT * from citas order by citas.idcitas desc";
			}
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function guardar_cita(){
		try{
			parent::set_names();
			$id=$_REQUEST['id'];
			$arreglo =array();
			$hora=$_REQUEST['hora'];
			$minuto=$_REQUEST['minuto'];
			if (!isset($_REQUEST['idcliente']) or strlen($_REQUEST['idcliente'])==0 or $_REQUEST['idcliente']==0){
				$resp=array();
				$resp+=array('id'=>0);
				$resp+=array('error'=>1);
				$resp+=array('terror'=>'Falta seleccionar cliente');
				return json_encode($resp);
			}
			if (isset($_REQUEST['fecha']) and strlen($_REQUEST['fecha'])>0){
				$fx=explode("-",$_REQUEST['fecha']);
				$arreglo+=array('fecha'=>$fx['2']."-".$fx['1']."-".$fx['0']." $hora:$minuto:00");
			}
			if (isset($_REQUEST['estatus'])){
				$arreglo+= array('estatus'=>$_REQUEST['estatus']);
			}
			if (isset($_REQUEST['idcliente'])){
				$arreglo+= array('idcliente'=>$_REQUEST['idcliente']);
			}
			if (isset($_REQUEST['observaciones'])){
				$arreglo+= array('observaciones'=>$_REQUEST['observaciones']);
			}
			if (isset($_REQUEST['cubiculo'])){
				$arreglo+= array('cubiculo'=>$_REQUEST['cubiculo']);
			}
			if (isset($_REQUEST['atiende'])){
				$arreglo+= array('atiende'=>$_REQUEST['atiende']);
			}
			if (isset($_REQUEST['servicio'])){
				$arreglo+= array('servicio'=>$_REQUEST['servicio']);
			}
			if (isset($_REQUEST['precio'])){
				$arreglo+= array('precio'=>$_REQUEST['precio']);
			}

			$x="";
			if($id==0){
				$x=$this->insert('citas', $arreglo);
			}
			else{
				$x=$this->update('citas',array('idcitas'=>$id), $arreglo);
			}
			return $x;
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function atiende(){
		try{
			$sql="select * from usuarios";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function editar_cita($id){
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

	public function borrar_cita(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		return $this->borrar('citas',"idcitas",$id);
	}
}
$db = new Pedidos();
if(strlen($function)>0){
	echo $db->$function();
}
?>
