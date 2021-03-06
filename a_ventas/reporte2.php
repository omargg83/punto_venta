<?php
  require_once("db_.php");
  $fecha=date("d-m-Y");
  $nuevafecha = strtotime ( '-0 month' , strtotime ( $fecha ) ) ;
  $fecha1 = date ( "d-m-Y" , $nuevafecha );


  $sql="select * from usuarios";
  $sth = $db->dbh->prepare($sql);
  $sth->execute();
  $res=$sth->fetchAll(PDO::FETCH_OBJ);

?>

<form id='consulta_avanzada' action='' data-destino='a_ventas/reporte2_res' data-div='resultado'  autocomplete='off'>
  <div class='container' >
    <div class="alert alert-light" role="alert">
      <h4 class="alert-heading">PRODUCTOS</h4>
      <div class='row'>
        <div class='col-sm-3'>
            <label><b>Del</b></label>
            <input class="form-control fechaclass" placeholder="Desde...." type="text" id='desde' name='desde' value='<?php echo $fecha1; ?>' autocomplete="off">
        </div>

        <div class='col-sm-3'>
          <label><b>Al</b></label>
          <input class="form-control fechaclass" placeholder="Hasta...." type="text" id='hasta' name='hasta' value='<?php echo $fecha; ?>' autocomplete="off">
        </div>

        <div class='col-sm-3'>
          <label><b>Vendedor</b></label>
          <select class="form-control" name="idusuario" id="idusuario">
            <option value=""></option>
          <?php
            foreach($res as $v2){
              echo "<option value='$v2->idusuario'>$v2->nombre</option>";
            }
          ?>
      </select>
        </div>


      </div>
      <hr>
      <div class='row'>
        <div class='col-sm-4'>
          <div class='btn-group'>
            <button title='Buscar' class='btn btn-outline-warning btn-sm' id='buscar_canalizado' type='submit' id='lista_buscar'><i class='fa fa-search'></i><span> Buscar</span></button>
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
