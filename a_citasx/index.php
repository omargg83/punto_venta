<?php
	require_once("db_.php");

	echo "<nav class='navbar navbar-expand-lg navbar-light bg-light'>

	<a class='navbar-brand' ><i class='fas fa-users'></i> Citas</a>

	  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='principal' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	  </button>
		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
			<ul class='navbar-nav mr-auto'>";

			echo "<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='calendario' onclick='calendar_load(1)'><i class='fas fa-list-ul'></i><span>Calendario</span></a></li>";

			echo"<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_comision' data-lugar='a_citas/editar_cita'><i class='fas fa-list-ul'></i><span>Nuevo</span></a></li>";


			echo "</ul>";

			echo "<form class='form-inline my-2 my-lg-0' id='consulta_avanzada' action='' data-destino='a_personal/lista' data-funcion='guardar' data-div='trabajo'>
			<input class='form-control mr-sm-2' type='search' placeholder='Busqueda global' aria-label='Search' name='valor' id='valor'>
			<div class='btn-group'>
			<button class='btn btn-outline-secondary btn-sm' type='submit' title='Buscar' ><i class='fas fa-search'></i></button>
			</div>
			</form>";
		echo "
	  </div>
	</nav>";

	echo "<div id='trabajo' >";


  echo "</div>";
?>
<script>

$(function(){
	calendar_load(1);
});

function calendar_load(tipo){
  var fecha = new Date();

	$('#trabajo').html("");

  var calendarEl = document.getElementById('trabajo');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
    defaultView: 'dayGridMonth',
    defaultDate: fecha,
    buttonText:{
      today:    'Hoy',
      month:    'Mes',
      week:     'Semana',
      day:      'Dia',
      list:     'Lista'
    },
    locale: 'es',

    minTime: "09:00:00",
    maxTime: "18:00:00",
    slotDuration: "00:05:00",
    businessHours: {
      start: '9:00',
      end: '18:00',
    },
    hiddenDays: [ 0, 6 ],
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    dateClick: function(info) {
      console.log('Date: ' + info);
     },
     eventClick: function(info) {
      $('#myModal').modal('show');
      $("#modal_form").load("a_citas/editar_cita.php?id="+info.event.id);
    },
    events: {
    url: 'citas/eventos.php?tipo='+tipo,
     failure: function() {
      document.getElementById('script-warning').style.display = 'block'
      }
    }
  });
  calendar.render();
}
</script>
