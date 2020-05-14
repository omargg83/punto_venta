<?php
	require_once("db_.php");
	$tipo=$_REQUEST['tipo'];
	$citas=$db->citas_lista($tipo);
	$arreglo=array();

	$i=0;
	foreach($citas as $key){
		$hora=explode(" ",$key['fecha']);
		$color="";
		$limite=new DateTime($key['fecha']);
		if($key['tipo']==1){			///////retiro
			$limite->modify("+5 minute");
			$color="#ffd6bb";
			$texto="Retiro";
		}
		if($key['tipo']==2){			/////////credito
			$limite->modify("+10 minute");
			$color="#e1b99f";
			$texto="Credito";
		}

		$hora2=explode(" ",$limite->format('Y-m-d H:i:s'));

		$arreglo[$i]=array(
			'id'=>$key['id'],
			'title'=>$key['nombre']." ".$key['ape_pat'],
			'start'=>$hora[0]."T".$hora[1],
			'end'=>$hora2[0]."T".$hora2[1],
			'color'=>$color
		);
		$i++;
	}
	echo json_encode($arreglo);
?>
