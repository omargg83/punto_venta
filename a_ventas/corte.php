<?php
	require_once("db_.php");

	set_include_path('../librerias15/pdf2/src/'.PATH_SEPARATOR.get_include_path());
	include 'Cezpdf.php';

	$pdf = new Cezpdf('C7','portrait','color',array(255,255,255));
	$pdf->selectFont('Helvetica');
	// la imagen solo aparecera si antes del codigo ezStream se pone ob_end_clean como se muestra al final men
	$pdf->ezImage("../img/logoimp.jpg", 0, 60, 'none', 'center');
	$pdf->ezText("UN MUNDO PARA TUS PIES",10,array('justification' => 'center'));
	$pdf->ezText("OPERADORA PLATHEA SA DE CV",10,array('justification' => 'center'));
	$pdf->ezText("Rfc: OPL180514RA2",10,array('justification' => 'center'));
	$pdf->ezText("Blvd. Valle de San Javier # 202, Local 10 C.P.: 42086 Pachuca de Soto, Hgo.",10,array('justification' => 'center'));
	$pdf->ezText("Tel. 7716884592",10,array('justification' => 'center'));
	$pdf->ezText("Cel. 7712602184",10,array('justification' => 'center'));
	$pdf->ezText(" ",10);
//	$pdf->ezText("Fecha: ".$desde,10);
	$pdf->ezText("Expedido en: Pachuca Hgo.",10);
	$pdf->ezText(" ",10);
	$pdf->ezText("Corte de caja.",12);
	$data=array();
	$contar=0;

	$sql="select sum(et_venta.total) as total, et_venta.fecha, sum(et_venta.gtotal) as gtotal, et_venta.estado, et_venta.tipo_pago from et_venta
	left outer join et_tienda on et_tienda.id=et_venta.idtienda where et_venta.estado='Pagada' GROUP BY et_venta.tipo_pago";
	$sth = $db->dbh->prepare($sql);
	$sth->execute();
	$resSql=$sth->fetchAll(PDO::FETCH_OBJ);


	foreach($resSql as $ped){
		$data[$contar]=array(
			'NO.'=>$contar+1,
			'Fecha'=>$ped->fecha,
			'Total'=>number_format($ped->total,2),
			'Tipo de pago'=>$ped->tipo_pago
		);
		$contar++;
	}
	$pdf->ezTable($data,"","",array('xPos'=>'left','xOrientation'=>'right','cols'=>array(
	'No.'=>array('width'=>20),
	'Fecha'=>array('width'=>70),
	'Total'=>array('width'=>50),
	'Tipo de pago'=>array('width'=>40)
	),'fontSize' => 8));

	$pdf->ezText("¡Gracias por tu preferencia!",12,array('justification' => 'center'));
	if (ob_get_contents()) ob_end_clean();
	$pdf->ezStream();
?>
