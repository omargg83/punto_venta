<?php
	require_once("db_.php");
	$idventa=$_REQUEST['id'];
	$pd = $db->venta($idventa);
	$id=$pd['idventa'];
	$idcliente=$pd['idcliente'];
	$idtienda=$pd['idtienda'];
	$iddescuento=$pd['iddescuento'];
	$lugar=$pd['lugar'];
	$entregar=$pd['entregar'];
	$dentrega=$pd['dentrega'];
	$estado=$pd['estado'];
	$fecha=$pd['fecha'];

	$cliente=$db->cliente($idcliente);
	$nombre_cli=$cliente->profesion." ".$cliente->nombre." ".$cliente->apellidop." ".$cliente->apellidom;
	$correo_cli=$cliente->correo;
	$telefono_cli=$cliente->telefono;

	$pedido = $db->ventas_pedido($idventa);

	set_include_path('../librerias15/pdf2/src/'.PATH_SEPARATOR.get_include_path());
	include 'Cezpdf.php';

	$pdf = new Cezpdf('letter','portrait','color',array(255,255,255));
	$pdf->selectFont('Helvetica');

	$pdf->ezText("Cliente: ".$nombre_cli,10);
	$pdf->ezText("Fecha: ".$fecha,10);

	$data=array();
	$contar=0;

	foreach($pedido as $ped){
		$data[$contar]=array(
			'NO.'=>$contar+1,
			'Nombre'=>$ped['nombre'],
			'Cantidad'=>number_format($ped['v_cantidad']),
			'Precio'=>number_format($ped['v_precio'],2),
			'C. Presupuestal'=>"",
			'Cargo'=>""
		);
		$contar++;
	}
	$pdf->ezTable($data,"","",array('xPos'=>'left','xOrientation'=>'right','cols'=>array(
	'No.'=>array('width'=>20),
	'Nombre'=>array('width'=>50),
	'Cantidad'=>array('width'=>180),
	'Precio'=>array('width'=>180)
	),'fontSize' => 8));

	$pdf->ezStream();
?>
