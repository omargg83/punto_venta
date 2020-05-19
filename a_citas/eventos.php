<?php
	require_once("db_.php");
	$tipo=$_REQUEST['tipo'];

	$start=$_REQUEST['start'];
	$end=$_REQUEST['end'];

	$inicio=explode("T",$start);
	$fin=explode("T",$end);


	$citas=$db->citas_calendario($inicio[0],$fin[0]);
	$arreglo=array();

	$i=0;
	foreach($citas as $key){
		$hora=explode(" ",$key->fecha);
		$color="";
		$limite=new DateTime($key->fecha);

		$limite->modify("+60 minute");
		$color="#ffd6bb";
		$texto="Retiro";
		$hora2=explode(" ",$limite->format('Y-m-d H:i:s'));

		$arreglo[$i]=array(
			'id'=>$key->idcitas,
			'title'=>$key->nombre,
			'start'=>$hora[0]."T".$hora[1],
			'end'=>$hora2[0]."T".$hora2[1],
			'color'=>$color
		);
		$i++;
	}
	echo json_encode($arreglo);
?>
