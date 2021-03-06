<?php
require_once("db_.php");
$id=$_REQUEST['id'];


$pd = $db->venta($id);
$total=round($pd['total'],2);
if ($total>0){
$ati=$db->atiende();
$idusuario=$_SESSION['idpersona'];
}
else{
  echo "<div class='card'>";
  echo "<br><center>Debe agregar un producto</center>";
  echo "<div class='card-body'>";
  echo "</div>";
  echo "<div class='card-footer'>";
  echo "<button type='button' class='btn btn-outline-primary btn-sm' data-dismiss='modal'><i class='fas fa-sign-out-alt'></i>Cancelar</button>";
  echo "</div>";
  echo "</div>";
  exit();
}
?>
<form action="" id="form_venta" data-lugar="a_ventas/db_" data-funcion="finalizar_venta" data-destino='a_ventas/editar'>
  <input type='hidden' name='id' id='id' placeholder='buscar producto' value='<?php echo $id; ?>' class='form-control'>
  <div class="modal-header">
    <h5 class="modal-title">Finalizar venta</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

  <div class="modal-body" style='max-height:580px;overflow: auto;'>
    <div clas='row'>
      <div class='col-12'>
        <label>Metodo de pago</label>
        <select class="form-control" name="tipo_pago" id="tipo_pago">
          <option value="Efectivo">Efectivo</option>
          <option value="Debito">Tarjeta Debito</option>
          <option value="Credito">Tarjeta Crédito</option>
          <option value="Cupon">Cupón</option>
        </select>
      </div>


      <div class='col-12'>
        <label>Total</label>
        <input type='text' name='total_g' id='total_g' style='text-align:right' placeholder='Total' value='<?php echo $total; ?>' class='form-control' readonly>
      </div>

      <div class='col-12'>
        <label>Recibido</label>
        <input type='text' name='efectivo_g' id='efectivo_g' style='text-align:right' placeholder='Recibido' value='' class='form-control' required onchange='cambio_total()'>
      </div>

      <div class='col-12'>
        <label>Cambio</label>
        <input type='text' name='cambio_g' id='cambio_g' style='text-align:right' placeholder='Cambio' value='' class='form-control' required readonly>
      </div>

      <div class='col-12'>
        <label>Confirmar vendedor</label>
      <select class='form-control form-control-sm' name='idusuario' id='idusuario' required>
        <?php
          foreach($ati as $key){
            echo  "<option value='".$key->idusuario."' "; if($idusuario==$key->idusuario){ echo " selected";} echo ">".$key->nombre."</option>";

          }
          ?>
        </select>
      </div>

    </div>
  </div>

  <div class="modal-footer">
    <div class='btn-group'>
      <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-cash-register"></i>Finalizar</button>
      <button type="button" class="btn btn-outline-primary btn-sm" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i>Cancelar</button>
    </div>
  </div>
</form>
