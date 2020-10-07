

////////////// Ventas
function cambio_total(){
  var total_g=$("#total_g").val();
  var efectivo_g=$("#efectivo_g").val();
  var total=(efectivo_g-total_g)*100;
  $("#cambio_g").val(Math.round(total)/100);
}
