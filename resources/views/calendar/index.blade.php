@extends('app')

<!--TABLA DATOS-->
{{--
  <table id="example1" class="table table-bordered table-striped">
                          <thead>
                          <tr>

                   <th>Actividad</th>
                   <th>Inicio</th>
                   <th>Fin</th>
                   <th>Fecha</th>

                          </tr>
                          </thead>
                 <tbody>
                      @foreach($results as $result)
                  <tr>
                   <td>{!! $result->summary !!}</td>

                        @if (empty($result->start->dateTime))
                   <td>{!!$result->start->date!!}</td>
                   @endif

                        @if (empty($result->start->date))
                   <td>{!!$result->start->dateTime!!}</td>
                   @endif

                   <td>{!!$result->end->date!!}</td>
                   <td>{!! $result->dateTime !!}</td>



                  </tr>
                 @endforeach
                </tbody>
}
}
</table>
--}}

@section('main-content')
 <section class="content">
	   <div class="row">
        <div class="col-md-3">
<div>
 <a href="{{ route('gcalendar.create')}}" class="btn btn-warning">CREAR <span class="glyphicon glyphicon-tower"></span></a>
</div>

        <div id="eventContent" class="box-body" visibility: hidden>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Informacion de Actividad !</h4>
               INFORMACION
              </div>
              </div>




<div id="OnCalendar" class="box box-solid" visibility: hidden>
            <div class="box-header with-border">
              <i class="fa fa-text-width"></i>

              <h3 class="box-title">Informacion</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul>
                <li>TEXTO</li>

              </ul>
            </div>
            <!-- /.box-body -->
          </div>



<div class="box box-solid" >
            <div class="box-header with-border">
              <h4 class="box-title">Planificacion</h4>
            </div>
            <div class="box-body">
              <!-- the events -->
              <div id="external-events">
                <div class="external-event bg-green">Calibracion</div>
                <div class="external-event bg-light-blue">Mantencion</div>
                <div class="external-event bg-red">Reparacion</div>
                <div class="checkbox">
                  <label for="drop-remove">
                    <input type="checkbox" id="drop-remove">
                    Remover y arastrar
                  </label>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>

          <!-- /. box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Crear evento</h3>
            </div>
            <div class="box-body">
              <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                <ul class="fc-color-picker" id="color-chooser">
                  <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                </ul>
              </div>
              <!-- /btn-group -->
              <div class="input-group">
                <input id="new-event" type="text" class="form-control" placeholder="Nombre del evento">

                <div class="input-group-btn">
                  <button id="add-new-event" type="button" class="btn btn-primary btn-flat"> + </button>
                </div>




                <!-- /btn-group -->
              </div>
              <!-- /input-group -->
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->


</section>

@endsection

@section('script-blade')


<script>


  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
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

//events : '/myfeed.php?start=2013-12-01&end=2014-01-12&_=1386054751381',

//googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',

      // US Holidays
      //events: {'en.usa#holidaygroup.v.calendar.google.com'},

      //Eventos de Google Calendar
     // googleCalendarApiKey:'AIzaSyB_QJT_Hx861SEfa--NEef9kCTxWdJMj78',
     //   events:{

       //  googleCalendarId:'calendarior9 group.v.calendar.google.com',
      //   googleCalendarId:'google-api@calendarior9.iam.gserviceaccount.com',
            {{--googleCalendarId: 'abcd1234@group.calendar.google.com',--}}
            //className: 'gcal-event' // an option!
     //  },

 //Eventos de la BD
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

             //Eventos de googleclendar
--}}

//date('Y-m-d', strtotime($userProfileData->start_date));
//alert(date('Y-m-d',strtotime('{!$result->update!!}')));



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
          end: '{{$result->end->date}}',

//. date('l dS \o\f F Y h:i:s A', $timestamp)

            //  start:date('Y-m-d',{!$result->update!!}),
            //  start: '2017-07-25',
              backgroundColor:'#00a65a',
              borderColor:'#00a65a'
            },
          @endforeach
            ],

            //  start:'{$result->update}}',
             // end: '{$result->created}}',


          // $area = json_decode($results, true);

            //foreach($area['area'] as $i => $v)
            //{
              //  echo $v['area'].'<br/>';
            //}


            //events : '$results',

/*Seccion de Eventos editable y arastables*/
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar !!!
      selectable: true,



/*Click Sobre un Evento*/
     eventClick:  function(event, jsEvent, view) {  // when some one click on any event

    //alert(jsEvent);
              // endtime = $.fullCalendar.moment(event.end).format('h:mm');
              // starttime = $.fullCalendar.moment(event.start).format('dddd, MMMM Do YYYY, h:mm');
               // var mywhen = starttime + ' - ' + endtime;
              // $('#modalTitle').html(event.title);
              // $('#modalWhen').text(mywhen);
              // $('#eventID').val(event.id);
              // $('#calendarModal').modal();


            //$("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
            //$("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
            //$("#eventInfo").html(event.title);
            $("#eventContent").show();
            },
/*Click Sobre un Lugar vacio*/
    select: function(start, end, jsEvent) {  // click on empty time slot
      alert(start);
               // endtime = $.fullCalendar.moment(end).format('h:mm');
               // starttime = $.fullCalendar.moment(start).format('dddd, MMMM Do YYYY, h:mm');
               // var mywhen = starttime + ' - ' + endtime;
               // start = moment(start).format();
               // end = moment(end).format();
               // $('#createEventModal #startTime').val(start);
               // $('#createEventModal #endTime').val(end);
               // $('#createEventModal #when').text(mywhen);
               // $('#createEventModal').modal('toggle');
                 $("#OnCalendar").show();
           },
/*Click Sobre evento y arrastrar*/
    eventDrop: function(event, delta){ // event drag and drop
 alert(event.title + 'Se Mueve' + delta + ' days\n');

// document.location.href="{! route('gcalendar.update','$foo'); !!}";
//$.ajax({
  // url: "/gcalendar/create",
//})}
//alert(JSON.stringify(event, null, 4));
//printObject(event);
//alert(event);

//console.log(event);
    {{--
        $.ajax({
          type: "POST",

          url: 'gcalendar', //action="{route('gcalendar.store')}}"
          //data: 'action=update&title='+event.title+'&start_date='+moment(event.start).format()+'&end_date='+moment(event.end).format()+'&id='+event.id ,

       data: {
        _token: '0J1mR4h3ct2bdlD4SeOfEX4f6aQ7Bee3Jjnr04zd',
         // _token: $('meta[name="_token"]').attr('content'),
        //  id: event.id,
          title: event.title,
          description: event.title,
          start_date: moment(event.start).format(),
          end_date: moment(event.end).format()
        }


 //success: function () {alert("Se ha realizado el POST con exito ");}

                //   success: function(json) {
                   //alert(json);
                //   }
        });
 --}}

       // document.location.href="{! route('gcalendar')!!}";
//document.location.href="gcalendar";
        /*
        $.ajax({
        type: "POST",
        route: "gcalendar.create",
        data: {
          id: event.id,
          title: event.id,
          start_date: event.start,
          end_date: event.end
        },
        success: function () {alert("Se ha realizado el POST con exito ");}
      });
*/

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
     // copiedEventObject.title = 'sdkjasklasjdkl';
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        copiedEventObject.backgroundColor = $(this).css("background-color");
        copiedEventObject.borderColor = $(this).css("border-color");

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove();
         alert('sdlkasdklsjdklasjdlskdjdlskdjkl');
        }
      }

    });


    /*Seccon 2*/
{{--
    $('#calendar').fullCalendar({
    eventClick: function(event, element) {

        event.title = "CLICKED!";

        $('#calendar').fullCalendar('updateEvent', event);

    }
});

    $('#calendar').fullCalendar({
    dayClick: function() {
        alert('a day has been clicked!');
    }
});
--}}
    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
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
      //alert($val);
      window.alert(val);
       alert('Ingresos de datos');
      if (val.length == 0) {
        return;

      }



      //Create events
      var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html(val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);

      //Remove event from text input
      $("#new-event").val("");
    });
  });
</script>

<!--
{{--

@yield('contentheader_description')
@yield('Padre') -> @section('Padre', 'Convenios')


--}}
-->

@endsection
