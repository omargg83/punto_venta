<?php @session_start();

	require_once("../init.php");
	class ipsi{
		public $nivel_personal;
		public $nivel_captura;

		public function __construct(){
			date_default_timezone_set("America/Mexico_City");
			try{
				$this->dbh = new PDO("mysql:host=".SERVIDOR.";dbname=".BDD, MYSQLUSER, MYSQLPASS);
				$this->dbh->query("SET NAMES 'utf8'");
			}
			catch(PDOException $e){
				return "Database access FAILED!";
			}
		}
		public function acceso(){
			try{
				if($_SERVER['REQUEST_METHOD']!="POST"){
					return 0;
				}
				$userPOST = htmlspecialchars($_REQUEST["userAcceso"]);
				$passPOST = md5($_REQUEST["passAcceso"]);

				$sql="SELECT * FROM usuarios where user=:user and pass=:pass and activo=1";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":user",$userPOST);
				$sth->bindValue(":pass",$passPOST);
				$sth->execute();
				$CLAVE=$sth->fetch();

				if(is_array($CLAVE)){
					if($userPOST == $CLAVE['user'] and strtoupper($passPOST)==strtoupper($CLAVE['pass'])){
						$_SESSION['autoriza']=1;
						$_SESSION['nombre']=$CLAVE['nombre'];

						$_SESSION['idfondo']=$CLAVE['idfondo'];
						$_SESSION['nick']=$CLAVE['user'];
						$_SESSION['idpersona']=$CLAVE['idusuario'];
						$_SESSION['foto']=$CLAVE['file_foto'];
						$_SESSION['idtienda']=$CLAVE['idtienda'];
						$_SESSION['nivel']=$CLAVE['nivel'];

						$fecha=date("Y-m-d");
						list($anyo,$mes,$dia) = explode("-",$fecha);
						$_SESSION['n_sistema']="J&D";

						$_SESSION['cfondo']="white";
						$_SESSION['hasta']=2019;
						$_SESSION['foco']=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
						$_SESSION['cfondo']="white";

						$arr=array();
						$arr=array('acceso'=>1);
						return json_encode($arr);
					}
				}
				/////////////////////////////////////////////
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function superior($id){
			try{
				$sql="SELECT * from personal where idcargo=:id";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":id",$id);
				$sth->execute();
				return $sth->fetch(PDO::FETCH_OBJ);
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
		public function centro($idarea){
			try{
				$sql="select idcentro, area from area where idarea=:id";
				$sth = $this->dbh->prepare($sql);
				$sth->bindValue(":id",$idarea);
				$sth->execute();
				return $sth->fetch(PDO::FETCH_OBJ);
			}
			catch(PDOException $e){
				return "Database access FAILED!".$e->getMessage();
			}
		}
	}
	function clean_var($val){
		$val=htmlspecialchars(strip_tags(trim($val)));
		return $val;
	}

	$db = new ipsi();
	echo $db->acceso();

?>
