<?php
	require_once("db_.php");
	$idventa=$_REQUEST['id'];
	$pd = $db->venta($idventa);
	$id=$pd['idventa'];
	$idcliente=$pd['idcliente'];
	$idusuario=$pd['idusuario'];
	$idtienda=$pd['idtienda'];
	$iddescuento=$pd['iddescuento'];
	$lugar=$pd['lugar'];
	$entregar=$pd['entregar'];
	$dentrega=$pd['dentrega'];
	$estado=$pd['estado'];
	$fecha=$pd['fecha'];
	$subtotal=$pd['subtotal'];
	$iva=$pd['iva'];
	$total=$pd['total'];
	$tipo_pago=$pd['tipo_pago'];

	$cliente=$db->cliente($idcliente);
	$nombre_cli=$cliente->profesion." ".$cliente->nombre." ".$cliente->apellidop." ".$cliente->apellidom;
	$correo_cli=$cliente->correo;
	$telefono_cli=$cliente->telefono;

	$atendio=$db->atendio($idusuario);
	$nombre_atendio=$atendio->nombre;
	$pedido = $db->ventas_pedido($idventa);

	set_include_path('../librerias15/pdf2/src/'.PATH_SEPARATOR.get_include_path());
	include 'Cezpdf.php';

	$pdf = new Cezpdf('C7','portrait','color',array(255,255,255));
	$pdf->selectFont('Helvetica');
	// la imagen solo aparecera si antes del codigo ezStream se pone ob_end_clean como se muestra al final men
	$pdf->ezImage("../img/logoimp.jpg", 0, 60, 'none', 'center');
	$pdf->ezText("*UN MUNDO PARA TUS PIES*",10,array('justification' => 'center'));
//	$pdf->ezText("OPERADORA PLATHEA SA DE CV",10,array('justification' => 'center'));
//	$pdf->ezText("Rfc: OPL180514RA2",10,array('justification' => 'center'));
	$pdf->ezText("Blvd. Valle de San Javier # 202, Local 10 C.P.: 42086 Pachuca de Soto, Hgo.",10,array('justification' => 'center'));
//	$pdf->ezText("Tel. 7716884592",10,array('justification' => 'center'));
	$pdf->ezText("Cel. 7711188263",10,array('justification' => 'center'));
	$pdf->ezText(" ",10);
	$pdf->ezText("Cliente: ".$nombre_cli,10);
	$pdf->ezText("Fecha y hora: ".$fecha,10);
	$pdf->ezText("Expedido en: Pachuca Hgo.",10);
//	$pdf->ezText(" ",10);
	$pdf->ezText("Vendedor: ".$nombre_atendio,10);
	$pdf->ezText("Ticket #: ".$idventa,12);
	$pdf->ezText(" ",10);
	$data=array();
	$contar=0;

	foreach($pedido as $ped){
		$data[$contar]=array(
			'No.'=>$contar+1,
			'Nombre'=>$ped['nombre'],
			'Cant.'=>number_format($ped['v_cantidad']),
			'Precio'=>number_format($ped['v_total'],2)
		);
		$contar++;
	}
	$pdf->ezTable($data,"","",array('xPos'=>'left','xOrientation'=>'right','cols'=>array(
	'No.'=>array('width'=>20),
	'Nombre'=>array('width'=>75),
	'Cant.'=>array('width'=>35),
	'Precio'=>array('width'=>60)
	),'fontSize' => 8));

	$pdf->ezText("Tipo de pago: ".$tipo_pago,10);
	$pdf->ezText(" ",10);
	$pdf->ezText("Sub-Total: $".$subtotal,10,array('justification' => 'right'));
	$pdf->ezText("Iva: $".$iva,10,array('justification' => 'right'));
	$pdf->ezText("Total: $".$total,12,array('justification' => 'right'));
	$pdf->ezText(" ",8);
	$pdf->ezText("Recordamos que su servicio de podologia debe de realizarse cada 28 días",8,array('justification' => 'center'));
	$pdf->ezText("Lo esperamos pronto.",8,array('justification' => 'center'));
	//$pdf->ezText(" ",10);
	$pdf->ezText("¡Gracias por tu preferencia!",12,array('justification' => 'center'));
	if (ob_get_contents()) ob_end_clean();
	$pdf->ezStream();
?>
