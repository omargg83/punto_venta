<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Usuario extends Sagyc{

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

	public function usuario($id){
		self::set_names();
		$sql="select * from usuarios where idusuario='$id'";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetch();
	}
	public function usuario_lista(){
    self::set_names();
		$sql="select usuarios.idusuario, usuarios.idtienda, usuarios.nombre, usuarios.user, usuarios.pass, usuarios.nivel, usuarios.activo, et_tienda.nombre as tienda  from usuarios left outer join et_tienda on et_tienda.id=usuarios.idtienda";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
  }

  public function tiendas_lista(){
		self::set_names();
		$sql="SELECT * FROM et_tienda";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}

	public function guardar_usuario(){
		$x="";
		parent::set_names();
		$arreglo =array();
		if (isset($_POST['id'])){$id=$_POST['id'];}
		if (isset($_REQUEST['nombre'])){
			$arreglo+=array('nombre'=>$_REQUEST['nombre']);
		}
		if (isset($_REQUEST['idtienda'])){
			$arreglo+=array('idtienda'=>$_REQUEST['idtienda']);
		}
		if (isset($_REQUEST['estado'])){
			$arreglo+=array('activo'=>$_REQUEST['estado']);
		}
		if (isset($_REQUEST['user'])){
			$arreglo+=array('user'=>$_REQUEST['user']);
		}
		if (isset($_REQUEST['nivel'])){
			$arreglo+=array('nivel'=>$_REQUEST['nivel']);
		}

		if($id==0){

			$x.=$this->insert('usuarios', $arreglo);
		}
		else{
			$x.=$this->update('usuarios',array('idusuario'=>$id), $arreglo);
		}
		return $x;
	}

	public function lista_acceso(){
    self::set_names();
		$sql="select *  from usuariosreg left outer join usuarios on usuarios.idusuario=usuariosreg.idpersonal order by fecha desc limit 1000";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
  }
	public function password(){
		if (isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if (isset($_REQUEST['pass1'])){$pass1=$_REQUEST['pass1'];}
		if (isset($_REQUEST['pass2'])){$pass2=$_REQUEST['pass2'];}
		if(trim($pass1)==($pass2)){
			$arreglo=array();
			$passPOST=md5(trim($pass1));
			$arreglo=array('pass'=>$passPOST);
			$x=$this->update('usuarios',array('idusuario'=>$id), $arreglo);
			return $x;
		}
		else{
			return "La contraseña no coincide";
		}
	}
}

$db = new Usuario();
if(strlen($function)>0){
	echo $db->$function();
}
