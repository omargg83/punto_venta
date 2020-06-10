<?php
	require_once("db_.php");
  $id=$_REQUEST['id'];
  $fecha=date("d-m-Y");
	$hora=12;
	$minuto=0;

	$hora_fin=12;
	$minuto_fin=59;

	$cubiculo=0;
	$atiende=0;
	$servicio=0;
	$precio=0;


  $estatus="";
  $idcliente=0;
  $idenvio="";
  $idfactura="";
  $observaciones="";
  $pago="";
  $idpago="";
  $pagador="";
  $estado_pago="";

	$nombre_cli="";
	$correo_cli="";
	$telefono_cli="";
	$ati=$db->atiende();
	if($id>0){
    $row=$db->editar_cita($id);
		$fech = new DateTime($row->fecha);
		$fecha=$fech->format('d-m-Y');
		$hora=$fech->format('H');
		$minuto=$fech->format('i');

		$fech_fin = new DateTime($row->fecha_fin);

		$hora_fin=$fech_fin->format('H');
		$minuto_fin=$fech_fin->format('i');

		$estatus=$row->estatus;
		$observaciones=$row->observaciones;
		$idcliente=$row->idcliente;
		$cubiculo=$row->cubiculo;
		$atiende=$row->atiende;
		$servicio=$row->servicio;
		$precio=$row->precio;

		$cliente=$db->cliente($idcliente);
		$nombre_cli=$cliente->profesion." ".$cliente->nombre." ".$cliente->apellidop." ".$cliente->apellidom;
		$correo_cli=$cliente->correo;
		$telefono_cli=$cliente->telefono;
  }

    echo "<form id='form_comision' action='' data-lugar='a_citas/db_' data-destino='a_citas/editar' data-funcion='guardar_cita'>";
      echo "<input type='hidden' class='form-control' id='id' name='id' value='$id' placeholder='id'>";
      echo "<input type='hidden' class='form-control' id='idcliente' name='idcliente' value='$idcliente' placeholder='idcliente'>";
      echo "<div class='card'>";
        echo "<div class='card-header'>";
          echo "Cita # $id";
        echo "</div>";

        echo "<div class='card-body'>";

          echo "<div class='row'>";
            echo "<div class='col-2'>";
              echo "<label>Fecha</label>";
              echo "<input type='text' class='form-control form-control-sm fechaclass' id='fecha' name='fecha' value='$fecha'>";
            echo "</div>";

						echo "<div class='col-2'>";
			        echo "<label>Hora Inicio</label>";
			        echo "<select class='form-control form-control-sm' name='hora' id='hora'>";
								for($i=0;$i<24;$i++){
									echo  "<option value='$i' "; if($hora==$i){ echo " selected";} echo ">$i</option>";
								}
			        echo  "</select>";
			      echo "</div>";

						echo "<div class='col-2'>";
			        echo "<label>Minuto</label>";
			        echo "<select class='form-control form-control-sm' name='minuto' id='minuto'>";
								for($i=0;$i<=59;$i++){
									echo  "<option value='$i' "; if($minuto==$i){ echo " selected";} echo ">$i</option>";
								}
			        echo  "</select>";
			      echo "</div>";

						echo "<div class='col-2'>";
			        echo "<label>Hora final</label>";
			        echo "<select class='form-control form-control-sm' name='hora_fin' id='hora_fin'>";
								for($i=0;$i<24;$i++){
									echo  "<option value='$i' "; if($hora_fin==$i){ echo " selected";} echo ">$i</option>";
								}
			        echo  "</select>";
			      echo "</div>";

						echo "<div class='col-2'>";
			        echo "<label>Minuto</label>";
			        echo "<select class='form-control form-control-sm' name='minuto_fin' id='minuto_fin'>";
								for($i=0;$i<=59;$i++){
									echo  "<option value='$i' "; if($minuto_fin==$i){ echo " selected";} echo ">$i</option>";
								}
			        echo  "</select>";
			      echo "</div>";

						echo "<div class='col-3'>";
							echo "<label>Estado</label>";
							echo "<select id='estatus' name='estatus' class='form-control form-control-sm'>";
								echo "<option value='PENDIENTE'"; if($estatus=='PENDIENTE'){ echo " selected"; } echo ">PENDIENTE</option>";
								echo "<option value='PROGRAMADA'"; if($estatus=='PROGRAMADA'){ echo " selected"; } echo ">PROGRAMADA</option>";
								echo "<option value='REALIZADA'"; if($estatus=='REALIZADA'){ echo " selected"; } echo ">REALIZADA</option>";
								echo "<option value='CANCELADA'"; if($estatus=='CANCELADA'){ echo " selected"; } echo ">CANCELADA</option>";
							echo "</select>";
						echo "</div>";


					echo "</div>";

					echo "<hr>";
					echo "<div class='row'>";
						echo "<div class='col-8'>";
							echo "<label>Nombre:</label>";
								echo "<input type='text' class='form-control form-control-sm' id='nombre' name='nombre' value='$nombre_cli' placeholder='Nombre del cliente' readonly>";
						echo "</div>";

						echo "<div class='col-4'>";
							echo "<label>Correo:</label>";
							echo "<input type='text' class='form-control form-control-sm' id='correo' name='correo' value='$correo_cli' readonly>";
						echo "</div>";

						echo "<div class='col-4'>";
							echo "<label>Teléfono:</label>";
							echo "<input type='text' class='form-control form-control-sm' id='telefono' name='telefono' value='$telefono_cli' readonly>";
						echo "</div>";
					echo "</div>";

				  echo "<div class='row'>";
            echo "<div class='col-12'>";
              echo "<label>Notas de la cita</label>";
              echo "<input type='text' class='form-control form-control-sm' id='observaciones' name='observaciones' value='$observaciones' placeholder='Notas del pedido'>";
            echo "</div>";
          echo "</div>";

					echo "<div class='row'>";
						echo "<div class='col-2'>";
							echo "<label>Cubiculo</label>";
							echo "<select class='form-control form-control-sm' name='cubiculo' id='cubiculo'>";
								echo  "<option value='1' "; if($cubiculo=="1"){ echo " selected";} echo ">1</option>";
								echo  "<option value='2' "; if($cubiculo=="2"){ echo " selected";} echo ">2</option>";
								echo  "<option value='3' "; if($cubiculo=="3"){ echo " selected";} echo ">3</option>";
								echo  "<option value='4' "; if($cubiculo=="4"){ echo " selected";} echo ">4</option>";
							echo  "</select>";
						echo "</div>";

						echo "<div class='col-3'>";
							echo "<label>Atiende</label>";
							echo "<select class='form-control form-control-sm' name='atiende' id='atiende'>";
								foreach($ati as $key){
									echo  "<option value='".$key->idusuario."' "; if($atiende==$key->idusuario){ echo " selected";} echo ">".$key->nombre."</option>";
								}
							echo  "</select>";
						echo "</div>";

						echo "<div class='col-4'>";
							echo "<label>Servicio</label>";
							echo "<select id='servicio' name='servicio' class='form-control form-control-sm'>";
								echo "<option value='PODOLOGICO PREVENTIVO'"; if($servicio=='PODOLOGICO PREVENTIVO'){ echo " selected"; } echo ">PODOLOGICO PREVENTIVO</option>";
								echo "<option value='ONICOCRIPTOSIS'"; if($servicio=='ONICOCRIPTOSIS'){ echo " selected"; } echo ">ONICOCRIPTOSIS</option>";
								echo "<option value='MASAJE RELAJANTE PODAL'"; if($servicio=='MASAJE RELAJANTE PODAL'){ echo " selected"; } echo ">MASAJE RELAJANTE PODAL</option>";
								echo "<option value='MANICURA'"; if($servicio=='MANICURA'){ echo " selected"; } echo ">MANICURA</option>";
								echo "<option value='ESMALTE EN GEL'"; if($servicio=='ESMALTE EN GEL'){ echo " selected"; } echo ">ESMALTE EN GEL</option>";
								echo "<option value='APLICACION DE ESMALTE EN PIES O MANOS'"; if($servicio=='APLICACION DE ESMALTE EN PIES O MANOS'){ echo " selected"; } echo ">APLICACION DE ESMALTE EN PIES O MANOS</option>";
								echo "<option value='RETIRADO DE GEL'"; if($servicio=='RETIRADO DE GEL'){ echo " selected"; } echo ">RETIRADO DE GEL</option>";
							echo "</select>";
						echo "</div>";

						echo "<div class='col-3'>";
              echo "<label>Costo:</label>";
              echo "<input type='text' class='form-control form-control-sm' id='precio' name='precio' value='$precio' placeholder='Costo de la cita'>";
            echo "</div>";

					echo "</div>";

        echo "</div>";
        echo "<div class='card-footer'>";
          echo "<div class='btn-group'>";
							echo "<button type='submit' class='btn btn-outline-secondary btn-sm'><i class='far fa-save'></i>Guardar</button>";

							if($estatus=='PENDIENTE' or $id==0){
	            	echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cli' data-id='$idcliente' data-id2='$id' data-lugar='a_citas/form_cliente' title='Agregar Cliente' ><i class='fas fa-user-tag'></i>+ Cliente</button>";

							}


            echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='lista_cat' data-lugar='a_citas/lista' title='Regresar'><i class='fas fa-undo-alt'></i>Regresar</button>";
          echo "</div>";
        echo "</div>";




      echo "</div>";
    echo "</form>";

 ?>

 <script>
   $(function() {
     fechas();
   });
 </script>
