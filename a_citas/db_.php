<?php
require_once("../control_db.php");
if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}

class Escritorio extends Sagyc{
	private $accesox;
	private $comic;
	private $editar;

	public function __construct(){
		parent::__construct();
	}
	public function citas_lista($tipo){
		try{
			self::set_names();
			$fecha=date('Y-m-d')." 00:00:00";
			$sql="select * from citas left outer join afiliados on afiliados.idfolio=citas.idfolio
			where apartado=2 and tipo='$tipo' and fecha>='$fecha'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}





	public function citas(){
		try{
			$desde=$_REQUEST['desde'];
			$hora=$_REQUEST['hora'];
			$minuto=$_REQUEST['minuto'];
			$tipo=$_REQUEST['tipo'];

			$actual=date('Y-m-d H:i:s');
			$fechax = date("Y-m-d", strtotime($desde))." $hora:$minuto:00";
			$limite=new DateTime();
			$limite->modify("+6 minute");

			$sql="select * from citas where tipo='$tipo' and fecha='$fechax' and (apartado=2 or (apartado=1 and limite>'$actual'))";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			$reg=$sth->rowCount();

			if($reg<4){
				$sql="select * from citas where tipo='$tipo' and fecha='$fechax' and (apartado=1 and limite<'$actual')";
				$sth = $this->dbh->prepare($sql);
				$sth->execute();

				$arreglo=array();
				$arreglo+=array('idfolio'=>$_SESSION['idfolio']);
				$arreglo+=array('fecha'=>$fechax);
				$arreglo+=array('caja'=>1);
				$arreglo+=array('apartado'=>1);
				$arreglo+=array('limite'=>$limite->format('Y-m-d H:i:s'));
				$arreglo+=array('fcreado'=>$actual);
				$arreglo+=array('tipo'=>$tipo);

				if($sth->rowCount()==0){
					$arreglo+=array('caja'=>1);
					$x=$this->insert('citas', $arreglo);
				}
				else{
					$tmp=$sth->fetch(PDO::FETCH_OBJ);
					$x=$this->update('citas',array('id'=>$tmp->id), $arreglo);
				}
				$cita=json_decode($x);

				$t="<div class='card'>";
					$t.="<div class='card-header'>";
						$t.="Confirmar";
					$t.="</div>";
					$t.="<div class='card-body'>";
					$t.= "<input class='form-control' type='hidden' id='tipo' name='tipo' value='$tipo' readonly>";
						$t.="<div class='row'>";
							$t.= "<div class='col-3'>";
									$t.= "<label># Cita</label>";
									$t.= "<input class='form-control' type='text' id='cita' name='cita' value='$cita->id' readonly>";
							$t.= "</div>";
							$t.= "<div class='col-3'>";
									$t.= "<label>Fecha</label>";
									$t.= "<input class='form-control' type='text' id='desde' name='desde' value='$desde' readonly>";
							$t.= "</div>";
							$t.= "<div class='col-3'>";
									$t.= "<label>Hora</label>";
									$t.= "<input class='form-control' type='text' id='hora' name='hora' value='$hora:$minuto:00' readonly>";
							$t.= "</div>";
							$t.= "<div class='col-12'>";
									$t.= "<label>Observaciones</label>";
									$t.= "<input class='form-control' type='text' id='observaciones' name='observaciones' value='' placeholder='Observaciones'>";
							$t.= "</div>";
						$t.= "</div>";
						$t.="<div class='row'>";
							$t.= "<div class='col-12'>";
								$x.="<div class='btn-group'>";
									$t.= "<button class='btn btn-warning btn-sm' type='button' onclick='confirmar_cita()'><i class='far fa-calendar-check'></i>Confirmar cita</button>";
									$t.= "<button class='btn btn-warning btn-sm' type='button' onclick='cancela_previo()'><i class='far fa-calendar-times'></i>Cancelar cita</button>";
								$t.="</div>";
							$t.="</div>";
						$t.="</div>";
					$t.="</div>";
				$t.="</div>";
				$arreglo=array('activo'=>1, 'dato'=>$x, 'tipo'=>$tipo, 'texto'=>$t);
			}
			else{
				$arreglo=array('activo'=>0, 'dato'=>"0", 'tipo'=>$tipo);
			}
			return json_encode($arreglo);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function confirmar(){
		try{
			$cita=$_REQUEST['cita'];
			$observaciones=$_REQUEST['observaciones'];
			$actual=date('Y-m-d H:i:s');
			$arreglo=array();
			$arreglo+=array('idfolio'=>$_SESSION['idfolio']);
			$arreglo+=array('fcreado'=>$actual);
			$arreglo+=array('apartado'=>2);
			$arreglo+=array('observaciones'=>$observaciones);
			$x=$this->update('citas',array('id'=>$cita), $arreglo);
			if($x){
				$arreglo=array('id'=>0,'error'=>0, 'terror'=>"");
			}
			else{
				$arreglo=array('id'=>0,'error'=>1, 'terror'=>$x);
			}
			return json_encode($arreglo);
		}
		catch(PDOException $e){
			return "Database access FAILED!".$e->getMessage();
		}
	}
	public function citas_lista($tipo){
		try{
			self::set_names();
			$fecha=date('Y-m-d')." 00:00:00";
			$sql="select * from citas left outer join afiliados on afiliados.idfolio=citas.idfolio
			where apartado=2 and tipo='$tipo' and fecha>='$fecha'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetchAll();
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function cita_ver($id){
		try{
			self::set_names();
			$fecha=date('Y-m-d')." 00:00:00";
			$sql="select citas.*, afiliados.nombre, afiliados.ape_pat, afiliados.ape_mat, afiliados.Filiacion from citas left outer join afiliados on afiliados.idfolio=citas.idfolio
			where citas.id='$id'";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();
			return $sth->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function citas_afiliados(){
		try{
			self::set_names();
			$fecha=date('Y-m-d')." 00:00:00";
			$sql="select * from citas where idfolio=:idfolio and apartado=2 and fecha>='$fecha' order by fecha desc";
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(":idfolio",$_SESSION['idfolio']);
			$sth->execute();
			return $sth->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			return "Database access FAILED! ".$e->getMessage();
		}
	}
	public function cancelar_cita(){
		$cita=$_REQUEST['cita'];
		return $this->borrar("citas","id",$cita);
	}
}

$db = new Escritorio();
if(strlen($function)>0){
  echo $db->$function();
}


?>
