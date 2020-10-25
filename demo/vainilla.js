
////////////// Ventas
function cambio_total(){
  var total_g=$("#total_g").val();
  var efectivo_g=$("#efectivo_g").val();
  var total=(efectivo_g-total_g)*100;
  $("#cambio_g").val(Math.round(total)/100);
}
function calendar_load(tipo){
  var fecha = new Date();
  var final="";

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
    minTime: "10:00:00",
    maxTime: "18:00:00",
    slotDuration: "00:15:00",
    businessHours: {
      start: '9:00',
      end: '16:00',
    },
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    events: {
      url: 'a_citas/eventos.php?tipo='+tipo,
      failure: function() {
        document.getElementById('script-warning').style.display = 'block'
      }
    },
    dateClick: function(info) {
      console.log('Date: ' + info);
     },
    eventClick: function(info) {
      $('#myModal').modal('show');
      $("#modal_form").load("a_citas/info.php?id="+info.event.id);
    },
    eventDrop: function (info) { // this function is called when something is dropped

      if(info.event.end){
        final=info.event.end.toLocaleString();
      }

      $.confirm({
        title: 'Fechas',
        content: '¿Desea mover la cita seleccionada?',
        buttons: {
          Mover: function () {
            $.ajax({
              data:  {
                "horario":info.event.start.toLocaleString(),
                "horario2":final,
                "idcita":info.event.id,
                "function":"cambiar_hora"
              },
              url:   "a_citas/db_.php",
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

    },
    eventResize: function(info) {

      if(info.event.end){
        final=info.event.end.toLocaleString();
      }

      $.confirm({
        title: 'Fecha',
        content: '¿Desea mover la cita seleccionada?',
        buttons: {
          Mover: function () {
            $.ajax({
              data:  {
                "horario":info.event.start.toLocaleString(),
                "horario2":final,
                "idcita":info.event.id,
                "function":"cambiar_hora"
              },
              url:   "a_citas/db_.php",
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
function fondos(){
  var formData = new FormData();
  formData.append("function", "fondo_carga");
  formData.append("ctrl", "control");
  let xhr = new XMLHttpRequest();
  xhr.open('POST',"control_db.php");
  xhr.addEventListener('load',(data)=>{
    document.getElementById("fondo").innerHTML = data.target.response;
  });
  xhr.onerror = (e)=>{
  };
  xhr.send(formData);
}
function fondo(archivo){
  alert(archivo);
  var formData = new FormData();
  formData.append("function", "fondo");
  formData.append("ctrl", "control");
  formData.append("imagen", archivo);
  let xhr = new XMLHttpRequest();
  xhr.open('POST',"control_db.php");
  xhr.addEventListener('load',(data)=>{
    console.log(data.target.response);
  });
  xhr.onerror = (e)=>{
  };
  xhr.send(formData);
}
