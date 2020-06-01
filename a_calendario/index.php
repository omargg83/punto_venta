<?php
  require_once("db_.php");

 ?>

 <nav class='navbar navbar-expand-sm navbar-light bg-light'>
 		  <a class='navbar-brand' ><i class="fas fa-shopping-basket"></i>Citas</a>
 		  <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
 			<span class='navbar-toggler-icon'></span>
 		  </button>
 		  <div class='collapse navbar-collapse' id='navbarSupportedContent'>
 			<ul class='navbar-nav mr-auto'>
        <div class='form-inline my-2 my-lg-0' id='daigual' action='' >
          <div class="input-group  mr-sm-2">
            <input type="text" class="form-control form-control-sm" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2"  id='buscar' onkeyup='Javascript: if (event.keyCode==13) buscar_pedido()'>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary btn-sm" type="button" onclick='buscar_pedido()'><i class='fas fa-search'></i></button>
            </div>
          </div>
				</div>
        <li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='calendario' onclick='calendar_load(1)'><i class='fas fa-list-ul'></i><span>Calendario</span></a></li>

      </li>

 			</ul>
 		</div>
 	  </div>
 	</nav>
<?php

   echo "<div id='trabajo' style='margin-top:5px;background-color:".$_SESSION['cfondo']."; '>";

   echo "</div>";

 ?>
<script type="text/javascript">

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
      eventColor: '#378006',
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
      url: 'a_citas/eventos.php?tipo='+tipo,
       failure: function() {
        document.getElementById('script-warning').style.display = 'block'
        }
      },
      editable: true,
    });
    calendar.render();
  }


</script>
