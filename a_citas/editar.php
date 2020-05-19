<?php
	require_once("db_.php");
  $id=$_REQUEST['id'];
  $fecha=date("d-m-Y");
	$hora=0;
	$minuto=0;


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

	if($id>0){
    $row=$db->editar_cita($id);
		$fech = new DateTime($row->fecha);
		$fecha=$fech->format('d-m-Y');
		$hora=$fech->format('H');
		$minuto=$fech->format('i');

		$estatus=$row->estatus;
		$observaciones=$row->observaciones;
		$idcliente=$row->idcliente;

		$cliente=$db->cliente($idcliente);
		$nombre_cli=$cliente->nombre;
		$correo_cli=$cliente->email_prove;
  }

  echo "<div class='container'>";
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
			        echo "<label>Hora</label>";
			        echo "<select class='form-control form-control-sm' name='hora' id='hora'>";
								for($i=0;$i<24;$i++){
									echo  "<option value='$i' "; if($hora==$i){ echo " selected";} echo ">$i</option>";
								}
			        echo  "</select>";
			      echo "</div>";

						echo "<div class='col-2'>";
			        echo "<label>Hora</label>";
			        echo "<select class='form-control form-control-sm' name='minuto' id='minuto'>";
								for($i=0;$i<59;$i++){
									echo  "<option value='$i' "; if($minuto==$i){ echo " selected";} echo ">$i</option>";
								}
			        echo  "</select>";
			      echo "</div>";

						echo "<div class='col-3'>";
							echo "<label>Estado</label>";
							echo "<select id='estatus' name='estatus' class='form-control form-control-sm'>";
								echo "<option value='EN ESPERA'"; if($estatus=='EN ESPERA'){ echo " selected"; } echo ">EN ESPERA</option>";
								echo "<option value='PROCESANDO'"; if($estatus=='PROCESANDO'){ echo " selected"; } echo ">PROCESANDO</option>";
								echo "<option value='PROCESANDO PAGO'"; if($estatus=='PROCESANDO PAGO'){ echo " selected"; } echo ">PROCESANDO PAGO</option>";
								echo "<option value='PROCESANDO PAGO PENDIENTE'"; if($estatus=='PROCESANDO PAGO PENDIENTE'){ echo " selected"; } echo ">PROCESANDO PAGO PENDIENTE</option>";
								echo "<option value='PEDIDO CONFIRMADO'"; if($estatus=='PEDIDO CONFIRMADO'){ echo " selected"; } echo ">PEDIDO CONFIRMADO</option>";
							echo "</select>";
						echo "</div>";

						echo "<div class='col-3'>";
							echo "<label>Factura</label>";
							echo "<select id='factura' name='factura' class='form-control form-control-sm'>";
								echo "<option value='0'"; if($factura=='0'){ echo " selected"; } echo ">No</option>";
								echo "<option value='1'"; if($factura=='1'){ echo " selected"; } echo ">Si</option>";
							echo "</select>";
						echo "</div>";
					echo "</div>";

					echo "<hr>";
					echo "<div class='row'>";
						echo "<div class='col-8'>";
							echo "<label>Nombre:</label>";
								echo "<input type='text' class='form-control form-control-sm' id='nombre' name='nombre' value='$nombre_cli' required placeholder='Nombre del cliente' readonly>";
						echo "</div>";

						echo "<div class='col-4'>";
							echo "<label>Correo:</label>";
							echo "<input type='text' class='form-control form-control-sm' id='correo' name='correo' value='$correo_cli' required readonly>";
						echo "</div>";
					echo "</div>";

				  echo "<div class='row'>";
            echo "<div class='col-12'>";
              echo "<label>Notas de la cita</label>";
              echo "<input type='text' class='form-control form-control-sm' id='observaciones' name='observaciones' value='$observaciones' placeholder='Notas del pedido'>";
            echo "</div>";
          echo "</div>";

        echo "</div>";
        echo "<div class='card-footer'>";
          echo "<div class='btn-group'>";
							echo "<button type='submit' class='btn btn-outline-secondary btn-sm'><i class='far fa-save'></i>Guardar</button>";

							if($estatus=='EN ESPERA' or $id==0){
	            	echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='winmodal_cli' data-id='$idcliente' data-id2='$id' data-lugar='a_citas/form_cliente' title='Agregar Cliente' ><i class='fas fa-user-tag'></i>+ Cliente</button>";

							}


            echo "<button type='button' class='btn btn-outline-secondary btn-sm' id='lista_cat' data-lugar='a_citas/lista' title='Regresar'><i class='fas fa-undo-alt'></i>Regresar</button>";
          echo "</div>";
        echo "</div>";




      echo "</div>";
    echo "</form>";
  echo "</div>";
 ?>

 <script>
   $(function() {
     fechas();
   });
 </script>
