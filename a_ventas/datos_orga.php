<?php
	require_once("../control_db.php");
	if (isset($_REQUEST['function'])){$function=$_REQUEST['function'];}	else{ $function="";}


	if(strlen($function)>0){
		echo $function();
	}

	 function reporte3(){
		$sagyc = new Sagyc();
		$desde=$_REQUEST['desde'];
		$hasta=$_REQUEST['hasta'];
		$desde = date("Y-m-d", strtotime($desde))." 00:00:00";
		$hasta = date("Y-m-d", strtotime($hasta))." 23:59:59";

		$sql="SELECT month(fecha) as mes, sum(total) as total FROM et_venta where fecha BETWEEN '$desde' AND '$hasta' group by year(fecha), month(fecha);";
		$response=$sagyc->general($sql);
		$arreglo=array();
		for($i=0;$i<count($response);$i++){
			$arreglo[$i]=array('mes'=>$response[$i]['mes'], 'total'=>$response[$i]['total']);
		}
		echo json_encode($arreglo);
	}



?>
