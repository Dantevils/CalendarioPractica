@extends('app')

<!--Tabla de datos Google Calendar JSON-->
{{--
<table class="table table-bordered table-striped">
        <thead>
          <tr>
        <th>Zona Horaria</th>
        <th>Nombre</th>
        <th>Actividad</th>
        <th>start->date/dateTime</th>
        <th>end->date</th>
        <th>dateTime</th>
        <th>endTimeUnspecified</th>
          </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
              <tr>
            <td>{!!$result->start->timeZone!!}</td>
            <td>{!!$result->creator->displayName!!}</td>
<td>
            @foreach($result->attendees as $lala)
<p>@:{!!$lala->email!!}</p>
<p>NA:{!!$lala->displayName!!}</p>
<p>OR:{!!$lala->organizer!!}</p>
<p>RSP:{!!$lala->responseStatus!!}</p>
<p>R/:{!!$lala->comment!!}</p>
<p>-------------------------------</p>
            @endforeach
          
</td>

          
          

            <td>{!! $result->summary !!}</td>
              @if (empty($result->start->dateTime))
              <td>{!!$result->start->date!!}</td>
              @endif
              @if (empty($result->start->date))
              <td>{!!$result->start->dateTime!!}</td>
              @endif
            <td>{!!$result->end->dateTime!!}</td>
            <td>{!! $result->dateTime !!}</td>
            <td>{!! $result->colorId !!}</td>
              @if ($result->colorId == '11')
              <td>ROJO</td>
              @endif
              @if ($result->colorId == '10')
              <td>VERDE</td>
              @endif
              @if ($result->colorId == '9')
              <td>AZUL</td>
              @endif
              </tr>
              @endforeach
              </tr>
        </tbody>
</table>

--}}
@section('main-content')
 <section class="content">
	   <div class="row">
        <div class="col-md-2">
        

  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">click</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="titulo">Descripcion de tu actividad</h4>
        </div>
        <div class="modal-body">
          <!--<p id="identificador"></p>
          <p id="titulo"></p>
          <p id="description"></p>
          <p id="fecha_inicio"></p>
          <p id="fecha_fin"></p>-->

<!--
resize:none" rows="13" cols="20"
-->
         {!! Form::open(['route'=>'gcalendar.store','method'=>'POST'])!!} <!--Ruta de almacenamiento del controlador a Store-->
                        
                        <div class="form-group col-sm-3">
                            {!! Form::label('titulo', 'Tipo de Actividad') !!}
                            {!! Form::textarea('titulo',null,array('id'=>'titulo' ,'rows'=>'1' ,'cols'=>'1' ,'class'=>'form-control' ))!!}
                        </div>
                         <div class="form-group col-sm-3">
                            {!! Form::label('description', 'Description de Actividad') !!}
                            {!! Form::textarea('description',null,array('id'=>'description' ,'rows'=>'1' ,'cols'=>'1','class'=>'form-control' )) !!}
                        </div>

                         <div class="form-group col-sm-4">
                            {!! Form::label('start_date', 'Inicio Evento') !!}
                            {!! Form::textarea('start_date',null,array('id'=>'fecha_inicio' ,'rows'=>'1' ,'cols'=>'1','class'=>'form-control' )) !!}
                        </div>
                         <div class="form-group col-sm-4">
                            {!! Form::label('end_date', 'Fin Evento') !!}
                            {!! Form::textarea('end_date',null,array('id'=>'fecha_fin' ,'rows'=>'1' ,'cols'=>'1','class'=>'form-control' )) !!}
                        </div>

                        
                        <div class="form-group">

                        {!! Form::submit('Guardar',['class'=>'btn btn-success']) !!}
                        </div>

                        {!! Form::close() !!}

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
  



 <!--Ruta de Creacion-->
            <div>
             <a href="{{ route('gcalendar.create')}}" class="btn btn-warning">CREAR <span class="glyphicon glyphicon-tower"></span></a>
            </div>

          <!--Informacion Desplegable-->
            <div id="OnCalendar" class="box box-solid" visibility: hidden>
                <div class="box-header with-border">
                  <i class="fa fa-text-width"></i>
                    <h3 class="box-title">Informacion</h3>
                </div>
                  <div class="box-body">
                    <ul>
                     <li>TEXTO</li>
                    </ul>
                  </div>        
            </div>

            <!--Barra de eventos DashBorad-->
            <div class="box box-solid" >
              <div class="box-header with-border">
                <h4 class="box-title">Planificacion</h4>
              </div>
              <div class="box-body">
                <div id="external-events">
                <!--Ejemplos Basicos-->
                  <div class="external-event bg-green">Calibracion</div>
                  <div class="external-event bg-blue">Mantencion</div>
                  <div class="external-event bg-red">Reparacion</div>
                </div>
              </div>
            </div>

            <!--Seccion de creacion -->
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Crear</h3>
              </div>
              <div class="box-body">
                <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                  <ul class="fc-color-picker" id="color-chooser">
                    <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                    <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                    <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                  </ul>
                </div>
                <div class="input-group">
                  <input id="new-event" type="text" class="form-control" placeholder="Actividad">
                  <div class="input-group-btn">
                    <button id="add-new-event" type="button" class="btn btn-primary btn-flat"> + </button>
                  </div>
                </div>
              </div>
            </div>
        </div>


        <!-- Calendario -->
          <div class="col-md-10">
              <div class="box box-primary">
                <div class="box-body no-padding">
                  <div id="calendar"></div>
                </div>
              </div>
          </div>
      </div>
</section>

@endsection
@section('script-blade')

<script>


  $(function () {

    /*Inicializacion del Evento externo*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });

      });
    }

    ini_events($('#external-events div.external-event'));

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
    $('#calendar').fullCalendar({

      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week: 'Semana',
        day: 'Dia'
      },

 //Eventos de la BD por controlador
{{--
      events : [
          @foreach($tasks as $task)
            {
              title : '{{ $task->nombre }}',
              start:'{{$task->fecha_inicio}}',
              end: '{{$task->fecha_fin}}',
              allDay: '{{$task->allDay}}',
              url :'{{$task->url}}',
              backgroundColor:'{{$task->Color}}',
              borderColor:'{{$task->Color}}'
            },
          @endforeach
            ],           
--}}

    events : [
          @foreach($results as $result)
            {
              id: '{{$result->id}}',
              title : '{{ $result->summary }}',
            @if (empty($result->start->dateTime))
              start:'{!!$result->start->date!!}',
                   @endif

            @if (empty($result->start->date))
               start:'{!!$result->start->dateTime!!}',
                   @endif
        
            @if (empty($result->end->date))
               end:'{!!$result->end->dateTime!!}',
                   @endif

            @if (empty($result->end->dateTime))
               end:'{!!$result->end->date!!}',
                   @endif
            @if ($result->colorId == '9') //Azul
               backgroundColor:'#0073b7',//'#3c8dbc',
               borderColor:'#0073b7'//'#3c8dbc'
                @endif

            @if ($result->colorId == '10') //Verde 
              backgroundColor:'#00a65a',
              borderColor:'#00a65a'
                @endif
            @if ($result->colorId == '11') //ROJO
              backgroundColor:'#ff0000',
              borderColor:'#ff0000'
                @endif
               },
          @endforeach
            ],
//Seccion de Eventos editable y arastables
      editable: true,
      droppable: true, // Habilitamos los eventos arastreables
      selectable: true,
      //weekends: false,

/*Click Sobre un Evento*/
eventClick:  function(event, jsEvent, view) {
            $("#identificador").text(event.id);
            $("#titulo").text(event.title);
            $("#description").text(event.title); //description
            $("#fecha_inicio").text(event.start);
            $("#fecha_fin").text(event.start);
            $('#DANTEVILS').val(event.title);
            $("#myModal").modal();
},

/*Arrastramos y soltamos fuera del calendario*/
eventDragStop: function(event, jsEvent, ui, view) {
  /*Solo si nos encontramos en la ventana*/
      if (isEventOverDiv(jsEvent.clientX, jsEvent.clientY)) {
      $color = event.backgroundColor;
      $idevent = event.id;
      alert($idevent);
        //Eliminacion  de google Calendar
        $.ajax({
                method: "post",
                url: "gcalendar/ddestroy",
                data: {
                _token: "{{ csrf_token() }}",
                id: event.id, 
                },
              });
     
      //Creacion de eventos
      var event = $("<div />").text(event.title);

      event.css({"background-color": $color, "border-color": $color, "color": "#fff"}).addClass("external-event");
      //event.html(val);
      $('#external-events').prepend(event); /*Agregamos al Panel Planificacion*/
      // var el = $("<div class='external-event'>").appendTo("#external-events").text(event.title);
         event.draggable({
          zIndex: 1070,//999,
          revert: false,
         revertDuration: 0
        });
      //event.data("event", { title: event.title, id: event.id, stick: true });
      $('#calendar').fullCalendar('removeEvents',$idevent);/*Remueve el evento del FullCalendar*/
       }
     
},

/*Click Sobre evento y arrastrar*/
eventDrop: function(event, delta){ 
        $.ajax({
          method: "post",
          url: "gcalendar/uupdate",
          data: {
            _token: "{{ csrf_token() }}",
            id: event.id,
            title: event.title,
            description: event.title,
            start_date:  moment(event.start).format(),
            end_date:  moment(event.start).format()          
          },
          //success: function(response) {
          // alert(response);
         // }
        });
},

/*Click Sobre un Lugar vacio*/
select: function(start, end, jsEvent) {

 //$("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
   //         $("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
     //       $("#eventInfo").html(event.description);
       //     $("#eventLink").attr('href', event.url);

            
            //$("#myModal").dialog({ modal: true, title: 'DANTEVILS'});

     // alert(start);
               // endtime = $.fullCalendar.moment(end).format('h:mm');
               // starttime = $.fullCalendar.moment(start).format('dddd, MMMM Do YYYY, h:mm');
               // var mywhen = starttime + ' - ' + endtime;
               // start = moment(start).format();
               // end = moment(end).format();
               // $('#createEventModal #startTime').val(start);
               // $('#createEventModal #endTime').val(end);
               // $('#createEventModal #when').text(mywhen);
               // $('#createEventModal').modal('toggle');
               $("#danteinfo").text('esto es el texto');

               $("#myModal").modal();
                 //$("#OnCalendar").show();
},

{{--
    eventRender: function (event, element) {
        element.attr('href', 'javascript:void(0);');
        element.click(function() {
            $("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
            $("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
            $("#eventInfo").html(event.description);
            $("#eventLink").attr('href', event.url);
            $("#eventContent").dialog({ modal: true, title: event.title, width:350});
        });
    },
--}}
      /*Arrastrar y soltar del panel*/
drop: function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject');


        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);

        // assign it the date that was reported
        //copiedEventObject.id = $(this).id(); /*Ayuda de BD*/
        copiedEventObject.title = $(this).text();
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;

        copiedEventObject.backgroundColor = $(this).css("background-color");
        copiedEventObject.borderColor = $(this).css("border-color");
        
        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
  $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

//alert(copiedEventObject.id);
//alert(originalEventObject.title);
          // is the "remove after drop" checkbox checked?
   $.ajax({
      method: "post",
      url: "gcalendar/sstore",
      data: {
        _token: "{{ csrf_token() }}",
       // id: copiedEventObject.id,
        title: copiedEventObject.title,
        description: copiedEventObject.title, /*Cambiar esto para mas adelante*/
        start_date:  moment(copiedEventObject.start).format(),
        end_date:  moment(copiedEventObject.start).format(),
        color:  isColorGoogle(copiedEventObject.backgroundColor)
           //start_date:  copiedEventObject.start,
      //end_date:  copiedEventObject.start
       
      },
      //success: function(response) {
       // alert(response);
     // }
    });

     $(this).remove();


     // $('#calendar').fullCalendar('refetchEvents');

      
      //  $('savecalendar').
//<div class="checkbox">
  //                <label for="drop-remove">
    //                <input type="checkbox" id="drop-remove">
      //              Remover y arastrar
        //          </label>
          //      </div>
      //  if ($('#drop-remove').is(':checked')) { /*Enviar datos*/
          // if so, remove the element from the "Draggable Events" list
        //  $(this).remove();
        // alert('Removido');
        //}
}
});



    /*Creacion de eventos */
    var currColor = "#0073b7"; //Red by default #3c8dbc
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");

    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });

    $("#add-new-event").click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      /*Ingreso de datos*/
      if (val.length == 0) {
        return;
      }



      //Create events
      var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html(val);
      $('#external-events').prepend(event); /*Agregamos al Panel Planificacion*/

      //Añadir Funcionalidad de draggable
      ini_events(event);

      //Limpiar el texto de Formulario
      $("#new-event").val("");
    });


  //Obtenemos el lugar donde se encuentre el panel de planificacion
  var isEventOverDiv = function(x, y) {
    var external_events = $("#external-events");
    var offset = external_events.offset();
    offset.right = external_events.width() + offset.left;
    offset.bottom = external_events.height() + offset.top;

    // Compare
    if (
      x >= offset.left &&
      y >= offset.top &&
      x <= offset.right &&
      y <= offset.bottom
    ) {
      return true;
    }
    return false;
  }
  //Convertido de Colores ID Google
  var isColorGoogle = function(color){
alert(color);
  if (color == "rgb(221, 75, 57)" || color == "rgb(255, 0, 0)") return  11; //Reparacion - Rojo
  if (color == "rgb(0, 166, 90)")  return  10; //Calibracion - Verde
  if (color == "rgb(0, 115, 183)" || color == "rgb(60, 141, 188)" ) return 9;
  //if (color == "rgb(60, 141, 188)") return 9;  //Mantencion - azul
  return 666; /*ID No definido*/
  }

  });
</script>
@endsection
