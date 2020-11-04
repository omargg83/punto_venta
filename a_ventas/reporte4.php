<?php
  require_once("db_.php");
  $fecha=date("d-m-Y");
  $nuevafecha = strtotime ( '-0 month' , strtotime ( $fecha ) ) ;
  $fecha1 = date ( "d-m-Y" , $nuevafecha );


?>

<form id='consulta_avanzada' action='' data-destino='a_ventas/reporte4_res' data-div='resultado'  autocomplete='off'>
  <div class='container' >
    <div class="alert alert-light" role="alert">
      <h4 class="alert-heading">CORTE DE CAJA</h4>
      <div class='row'>
        <div class='col-sm-3'>
            <label><b>Del</b></label>
            <input class="form-control fechaclass" placeholder="Desde...." type="text" id='desde' name='desde' value='<?php echo $fecha1; ?>' autocomplete="off" >
        </div>


      </div>
      <hr>
      <div class='row'>
        <div class='col-sm-4'>
          <div class='btn-group'>
            <button title='Buscar' class='btn btn-outline-warning btn-sm' id='buscar_canalizado' type='submit' id='lista_buscar'><i class='fa fa-search'></i><span> Consultar</span></button>
          <!--  <button type='button' class='btn btn-outline-primary btn-sm' onclick='imprime_pdf_corte()'><i class='fas fa-print'></i>Imprimir PDF</button> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<div id='resultado'>

</div>

<script>
$(function() {
  fechas();
  var desde= $("#desde").val();
  var hasta= $("#hasta").val();
  var estado= $("#estado").val();
});
</script>
