<?php
	require_once("datos_orga.php");
	$desde=$_REQUEST['desde'];
	$hasta=$_REQUEST['hasta'];
?>

<div class='container-fluid'>

  <div class='row'>
    <div style='background-color: white;opacity:.8;' class='col-12'>
      <canvas id="reporte3" height='110' width='100px' >
      </canvas>
    </div>
  </div>
  <br>

</div>
<script src="./librerias15/chartjs/Chart.js"></script>

<script type="text/javascript" >

	$(document).ready(function(){
		reporte3();
	});

  function reporte3(){
    var MONTHS = ['-','Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    var parametros={
      "function":"reporte3",
			"desde":"<?php echo $desde; ?>",
			"hasta":"<?php echo $hasta; ?>"
    };
    $.ajax({
      url: "a_ventas/datos_orga.php",
      method: "GET",
      data: parametros,
      success: function(data) {
        var player = [];
        var score = [];
        var datos = JSON.parse(data);
        for (var x = 0; x < datos.length; x++) {
          player.push(MONTHS[datos[x].mes]);
          score.push(datos[x].total);
        }
        var chartdata = {
        labels: player,
        datasets : [
          {
          label: 'Monto de ventas por mes $',
          backgroundColor: ['#abd2de','rgba(119, 136, 153)','#abd2de','rgba(119, 136, 153)'
          ,'#abd2de','rgba(119, 136, 153)','#abd2de','rgba(119, 136, 153)','#abd2de','rgba(119, 136, 153)'
          ,'#abd2de','rgba(119, 136, 153)'],
          borderColor: 'rgba(200, 200, 200, 0.75)',
          hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
          hoverBorderColor: 'rgba(200, 200, 200, 1)',
          data: score
          }
        ]
        };
      var ctx = $("#reporte3");
		//	var Chart = require('../librerias15/chartjs/chart.js');
      var barGraph = new Chart(ctx, {
          type: 'bar',
          data: chartdata,
          options: {
            title: {
              display: true,
              fontSize:20,
              text: 'Monto de ventas por mes $'
            },

            legend: {
              "display": true
            },
            tooltips: {
              "enabled": true
            },
            scales: {
                yAxes: [{
                    ticks: {
                        suggestedMin: 0
                    }
                }]
            }
          }
          });
      },
      error: function(data) {

      }
     });
  };

</script>
