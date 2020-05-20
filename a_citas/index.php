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
 				<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='new_poliza' data-lugar='a_citas/editar'><i class="fas fa-folder-plus"></i><span>Nuevo</span></a></li>
 				<li class='nav-item active'><a class='nav-link barranav' title='Mostrar todo' id='lista_prod' data-lugar='a_citas/lista'><i class="fas fa-list"></i><span>Lista</span></a></li>

      </li>

 			</ul>
 		</div>
 	  </div>
 	</nav>

<?php

   echo "<div id='trabajo' style='margin-top:5px;'>";
    include 'lista.php';
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
      }
    });
    calendar.render();
  }
  function buscar_cliente(){
    var texto=$("#prod_venta").val();
    var idcliente=$("#idcliente").val();
    var idcita=$("#idcita").val();
    if(texto.length>=-1){
      $.ajax({
        data:  {
          "texto":texto,
          "idcliente":idcliente,
          "idcita":idcita,
          "function":"busca_cliente"
        },
        url:   "a_citas/db_.php",
        type:  'post',
        beforeSend: function () {
          $("#resultadosx").html("buscando...");
        },
        success:  function (response) {
          $("#resultadosx").html(response);
          $("#prod_venta").val();
        }
      });
    }
  }
  function cliente_add(idcliente,idcita){
    $.confirm({
      title: 'Cliente',
      content: '¿Desea agregar el cliente seleccionado?',
      buttons: {
        Aceptar: function () {
          $.ajax({
            data:  {
              "idcliente":idcliente,
              "idcita":idcita,
              "function":"agrega_cliente"
            },
            url:   "a_citas/db_.php",
            type:  'post',
            success:  function (response) {
              var datos = JSON.parse(response);
              if (datos.idcliente>0){
                $("#idcliente").val(datos.idcliente);
                $("#nombre").val(datos.profesion+" "+datos.nombre+" "+datos.apellidop+" "+datos.apellidom);
                $("#correo").val(datos.correo);
                $("#telefono").val(datos.telefono);
                Swal.fire({
                  type: 'success',
                  title: "Se agregó correctamente",
                  showConfirmButton: false,
                  timer: 1000
                });
                $('#myModal').modal('hide');
              }
              else{
                $.alert(datos.terror);
              }
            }
          });
        },
        Cancelar: function () {

        }
      }
    });
  }



  function buscar_pedido(){
    var buscar = $("#buscar").val();
    $.ajax({
      data:  {
        "buscar":buscar
      },
      url:   'a_citas/lista.php',
      type:  'post',
      success:  function (response) {
        $("#trabajo").html(response);
      }
    });
  }
  function buscar_prodpedido(){
  	var texto=$("#prod_venta").val();
  	var idproducto=$("#idproducto").val();
  	var idpedido=$("#idpedido").val();
  	if(texto.length>=-1){
  		$.ajax({
  			data:  {
  				"texto":texto,
  				"idproducto":idproducto,
  				"idpedido":idpedido,
  				"function":"busca_producto"
  			},
  			url:   "a_citas/db_.php",
  			type:  'post',
  			beforeSend: function () {
  				$("#resultadosx").html("buscando...");
  			},
  			success:  function (response) {
  				$("#resultadosx").html(response);
  				$("#prod_venta").val();
  			}
  		});
  	}
  }
  function prod_add(id,idpedido){
    var cantidad=$("#cantidad_"+id).val();
    $.confirm({
      title: 'Producto',
      content: '¿Desea agregar el producto seleccionado?',
      buttons: {
        Aceptar: function () {
          $.ajax({
            data:  {
              "id":id,
              "idpedido":idpedido,
              "cantidad":cantidad,
              "function":"producto_add"
            },
            url:   "a_citas/db_.php",
            type:  'post',
            success:  function (response) {
              console.log(response);
              var datos = JSON.parse(response);
              if (datos.error==0){
                $.ajax({
                  data:  {
                    "id":datos.id
                  },
                  url:   'a_citas/editar.php',
                  type:  'post',
                  success:  function (response) {
                    $("#trabajo").html(response);
                  }
                });
                Swal.fire({
                  type: 'success',
                  title: "Se agregó correctamente",
                  showConfirmButton: false,
                  timer: 1000
                });
                $('#myModal').modal('hide');
              }
              else{
                $.alert(datos.terror);
              }
            }
          });
        },
        Cancelar: function () {
          $.alert('Canceled!');
        }
      }
    });
  }
  function buscar_cupon(){
    var texto=$("#prod_venta").val();
  	var idpedido=$("#idpedido").val();
  	if(texto.length>=-1){
  		$.ajax({
  			data:  {
  				"texto":texto,
  				"idpedido":idpedido,
  				"function":"busca_cupon"
  			},
  			url:   "a_citas/db_.php",
  			type:  'post',
  			beforeSend: function () {
  				$("#resultadosx").html("buscando...");
  			},
  			success:  function (response) {
  				$("#resultadosx").html(response);
  				$("#prod_venta").val();
  			}
  		});
  	}
  }
  function cupon_agrega(idcupon,idpedido){
    $.ajax({
      url:  "a_citas/db_.php",
      type: "POST",
      data: {
        "idcupon":idcupon,
        "idpedido":idpedido,
        "function":"cupon_busca"
      },
      success: function( response ) {
        console.log(response);
        var datos = JSON.parse(response);
        if (datos.error==0){
          Swal.fire({
              type: 'success',
              title: "Se agregó correctamente",
              showConfirmButton: false,
              timer: 1000
          });

          $.ajax({
            data:  {
              "id":idpedido
            },
            url:   'a_citas/editar.php',
            type:  'post',
            success:  function (response) {
              $("#trabajo").html(response);
            }
          });

        }
        else{
          Swal.fire({
              type: 'error',
              title: datos.terror,
              showConfirmButton: false,
              timer: 1000
          });
        }
      }
    });
  }
  function elimina_cuadmin(id,idpedido){
    $.confirm({
        title: 'Cupon',
        content: '¿Desea eliminar el cupón?',
        buttons: {
          Eliminar: function () {
            $.ajax({
              data:  {
                "id":id,
                "idpedido":idpedido,
                "function":"elimina_cupon"
              },
              url:   'a_citas/db_.php',
              type:  'post',
              timeout:3000,
              beforeSend: function () {

              },
              success:  function (response) {
                $("#trabajo").load("a_citas/editar.php?id="+idpedido);
              },
              error: function(jqXHR, textStatus, errorThrown) {

              }
            });

          },
          Cancelar: function () {

          }
        }
      });
  }
  function confirmar_web(pedido_web,idpedido){
    $.confirm({
      title: 'Cliente',
      content: '¿Desea confirmar el pedido a CT?',
      buttons: {
        Aceptar: function () {
          $.ajax({
            data:  {
              "pedido_web":pedido_web,
              "idpedido":idpedido,
              "function":"confirmar_web"
            },
            url:   "a_citas/db_.php",
            type:  'post',
            success:  function (response) {
              console.log(response);
              var datos = JSON.parse(response);
              if (datos.error==0){
                $.ajax({
                  data:  {
                    "id":idpedido
                  },
                  url:   'a_citas/editar.php',
                  type:  'post',
                  success:  function (response) {
                    $("#trabajo").html(response);
                  }
                });
                Swal.fire({
                  type: 'success',
                  title: "Se agregó correctamente",
                  showConfirmButton: false,
                  timer: 1000
                });
                $('#myModal').modal('hide');
              }
              else{
                $.ajax({
                  data:  {
                    "id":idpedido
                  },
                  url:   'a_citas/editar.php',
                  type:  'post',
                  success:  function (response) {
                    $("#trabajo").html(response);
                  }
                });
                Swal.fire({
                  type: 'error',
                  title: datos.terror,
                  showConfirmButton: false,
                  timer: 1000
                });
              }

            }
          });
        },
        Cancelar: function () {
          $.alert('Canceled!');
        }
      }
    });
  }
  function solicitar_ct(id){
    $.confirm({
      title: 'Cliente',
      content: '¿Desea procesar el pedido?, (envio de productos a CT, descuento de inventario)',
      buttons: {
        Aceptar: function () {
          $.ajax({
      			data:  {
      				"id":id,
      				"function":"pedir_ct"
      			},
      			url:   "a_citas/db_.php",
      			type:  'post',
      			beforeSend: function () {
              $("#cargando").addClass("is-active");
      			},
      			success:  function (response) {
              var datos = JSON.parse(response);
              if (datos.error==0){
                Swal.fire({
                  type: 'success',
                  title: "Pedido procesado correctamente",
                  showConfirmButton: false,
                  timer: 1000
                });
                $.ajax({
                  data:  {
                    "id":id
                  },
                  url:   'a_citas/editar.php',
                  type:  'post',
                  success:  function (response) {
                    $("#trabajo").html(response);
                  }
                });
      				}
              else{
                Swal.fire({
                  type: 'error',
                  title: datos.terror,
                  showConfirmButton: false,
                  timer: 1000
                });
              }
              $("#cargando").removeClass("is-active");
      			}
      		});
        },
        Cancelar: function () {

        }
      }
    });
  }
</script>
