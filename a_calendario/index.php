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
      editable: true,
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
      slotDuration: "00:30:00",
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
      events: {
        url: 'a_calendario/eventos.php?tipo='+tipo,
        failure: function() {
          document.getElementById('script-warning').style.display = 'block'
        }
      },
      dateClick: function(info) {
        console.log('Date: ' + info);
       },
      eventClick: function(info) {
        $('#myModal').modal('show');
        $("#modal_form").load("a_calendario/info.php?id="+info.event.id);
      },
      eventDrop: function (info) { // this function is called when something is dropped
        //alert(info.event.title + " was dropped on " + info.event.start.toISOString());
        console.log(info.event);

        alert(info.event.start.toLocaleString());
        alert(info.event.end.toLocaleString());

        $.confirm({
          title: 'Cliente',
          content: '¿Desea mover la cita seleccionada?',
          buttons: {
            Mover: function () {
              $.ajax({
                data:  {
                  "horario":info.event.start.toLocaleString(),
                  "idcita":info.event.id,
                  "function":"cambiar_dia"
                },
                url:   "a_calendario/db_.php",
                type:  'post',
                success:  function (response) {
                  var datos = JSON.parse(response);
                  if (datos.error==0){
                    Swal.fire({
                      type: 'success',
                      title: "Se modificó correctamente",
                      showConfirmButton: false,
                      timer: 1000
                    });
                  }
                  else{
                    info.revert();
                  }
                }
              });
            },
            Cancelar: function () {
              info.revert();
            }
          }
        });
      },
      eventResize: function(info) {
        console.log(info.event);

        alert(info.event.start.toLocaleString());
        alert(info.event.end.toLocaleString());

        $.confirm({
          title: 'Cliente',
          content: '¿Desea mover la cita seleccionada?',
          buttons: {
            Mover: function () {
              $.ajax({
                data:  {
                  "horario":info.event.start.toLocaleString(),
                  "horario2":info.event.end.toLocaleString(),
                  "idcita":info.event.id,
                  "function":"cambiar_hora"
                },
                url:   "a_calendario/db_.php",
                type:  'post',
                success:  function (response) {
                  console.log(response);
                  var datos = JSON.parse(response);
                  if (datos.error==0){
                    Swal.fire({
                      type: 'success',
                      title: "Se modificó correctamente",
                      showConfirmButton: false,
                      timer: 1000
                    });
                  }
                  else{
                    info.revert();
                  }
                }
              });
            },
            Cancelar: function () {
              info.revert();
            }
          }
        });
      }
    });
    calendar.render();
  }


</script>
