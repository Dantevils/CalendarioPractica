{{--
{!!Form::select('id_ac', $varConvenio->pluck('nombre_con'), $varConvenio->pluck('id'),['class' => 'select form-control', 'required'])!!} 
--}}
@extends('app')
@section('main-content')
    <div class="container spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                   <!-- <div class="panel-heading">Ordenes de trabajo</div>-->
                        <div class="panel-body">
                            <!--Collapsible-->

      <div class="row">
        <div>
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Ordenes de trabajo</h3>
              <!--Boton Para activiades Defecto-->
              <div class="btn-group col-sm-right">
                  <button type="button" class="btn btn-default">Actividades</button>
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a id="BtnMantencion" href="#" onclick="return confirm('Añadir Mantencion')" >Mantencion</a></li>
                    <li><a id="BtnVisita" href="#" onclick="return confirm('Añadir Visita')">Visita</a></li>
                    <li><a id="BtnCalibracion" href="#" onclick="return confirm('Añadir Calibracion')">Calibracion</a></li>
                    <li><a id="BtnOtra" href="#" onclick="return confirm('Añadir ')">Otra</a></li>
                  <!--Boton Para activiades Defecto-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#General">
                        Información General 
                      </a>
                    </h4>
                  </div>
                  <div id="General" class="panel-collapse collapse in">
                <div class="box-body">
                     
                    <!--Informacion  General-->               
                {!! Form::open(['route'=>'ordenes.store','method'=>'POST'])!!} <!--Ruta de almacenamiento-->
                    <!--Operador-->
                        <div class="form-group col-sm-8">
                            {!! Form::label('operador', 'Operador ') !!}
                            {!! Form::select('operador', array('Codelco El Teniente'))!!}
                        </div>
                    <!--Prioridad-->
                        <div class="form-group col-sm-4">
                            {!! Form::label('prioridad', 'Prioridad ') !!}
                            {!! Form::select('prioridad',array('Baja','Normal','Alta')) !!}
                        </div>
                    <!--Estacion-->
                        <div class="form-group col-sm-8">
                            {!! Form::label('estacion', 'Estacion ') !!}
                            {!! Form::select('estacion', array('Colon','Cauquenes')) !!}
                        </div>
                    <!--Folio-->
                        <div class="form-group col-sm-3">
                        
                            {{-- Form::label('folio', 'Folio ') --}}
                            {!! Form::text('folio',null,['class'=> 'form-control col-sm-2','required','placeholder'=>'Codigo Folio'])!!}
                        </div>
                    <!--Estado-->
                         <div class="form-group col-sm-8">
                            {!! Form::label('estado', 'Estado ') !!}
                            {!! Form::select('estado',array('Sin agendar')) !!}
                         </div>
                    <!--Status-->
                         <div class="form-group col-sm-8">
                            {!! Form::label('status', 'Status ') !!}
                            {!!Form::select('status',array('1','2','3'),['class' => 'select form-control', 'required'])!!} 
                         </div>
                    <!--Automatica: Reiteracion-->
                         <div class="form-group col-sm-8">
                            {!! Form::label('auto', 'Automatica ') !!}
                            {!! Form::checkbox('auto','value') !!}
                         </div> 

                    <!--Fecha Maxima-->
                        <div class="form-group col-sm-5">
                        {!! Form::label('fecha_max', 'Fecha Maxima ') !!}
                             <div class="input-group date col-sm-6">
                             <div class="input-group-addon">
                             <i class="fa fa-calendar"></i>
                             </div>
                        {!! Form::text('fecha_max',null,['class'=>'form-control','id'=>'datepicker','placeholder'=>'Fecha Maxima','required']) !!}
                             </div>
                        </div>
                        </div>
                  </div>
                </div>
                    <!--Mantencion Periodica-->
                <div class="panel box box-primary" id="boxbox">
                    <div class="box-header with-border">
                    <div class="pull-right box-tools">
                  <button id="delete" type="button" class="btn btn-danger btn-sm pull-right" data-toggle="tooltip" style="margin-right: 5px;">
                  <i class="fa fa-times"></i></button>
                        <ul class="nav nav-tabs pull-right">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Principal</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Diagnostico</a></li>
                            <li><a href="#tab_3" data-toggle="tab">Detalle</a></li>
                        </ul>
                     </div>
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#Mantencion">Mantencion MP</a> 
                        </h4>
                    </div>
                    <div id="Mantencion" class="panel-collapse collapse">
                        <div class="box-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <!--Equipo-->
                                     <div class="form-group col-sm-8">
                                        {!! Form::label('equipo_mp', 'Equipo') !!}
                                        {!! Form::select('equipo_mp',array('EQ1','EQ2','EQ3')) !!}
                                    </div>
                                    <!--Tipo de actividad sobre el equipo-->
                                      <div class="form-group col-sm-8">
                                        {!! Form::label('actividad', 'Tipo de actividad') !!}
                                        {!! Form::select('actividad',array('Calibracion','Mantencion','Visita')) !!}
                                    </div>
                                    <!--Estado-->
                                     <div class="form-group col-sm-12">
                                        {!! Form::label('estado', 'Estado') !!}
                                        {!! Form::select('estado',array('Sin agendar')) !!}
                                    </div>
                                    <!--Repetir-->
                                        <div class="form-group col-sm-2">
                                                <label>Repetir  </label>
                                                <input type="checkbox" name="checkfield" onchange="CheckRepetir(this)" checked="true"> 
                                                <!--Para habilitar el formulario-->
                                        </div>                      
                                        <div class="form-group col-sm-10" id="Repetir" Visibility:hidden>  <!--visibility: hidden-->
                                        {!! Form::selectRange('Dias', 1, 25)!!}
                                        <label>Cada</label>
                                        {!! Form::select('estado',array('Dia','Semana','Mes')) !!}
                                                <label>Rango:</label>
                                                <button type="button" class="btn btn-default " id="daterange-btn"> <!--pull-right-->
                                                    <span><i class="fa fa-calendar"></i></span>
                                                    <i class="fa fa-caret-down"></i>
                                                </button>
                                        </div>
                                </div>
                                <div class="tab-pane" id="tab_2">
                                     <!--Observaciones-->
                                      <div>
                                        {!! Form::label('diagnostico', 'Diagnostico Preliminar') !!}
                                        {!! Form::textarea('diagnostico',null,array('rows'=>'1' ,'cols'=>'3','class'=>'form-control' )) !!}
                                     </div>      
                                </div>
                                <div class="tab-pane" id="tab_3">
                                     <div>
                                        {!! Form::label('detalle', 'Detalle de Trabajo') !!}
                                        {!! Form::textarea('detalle',null,array('rows'=>'1' ,'cols'=>'3','class'=>'form-control' )) !!}
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!--Calibracion-->
                    <div class="panel box box-primary">
                    <div class="box-header with-border">
                    
                       <div class="pull-right box-tools">
                  <button id="delete" type="button" class="btn btn-danger btn-sm pull-right" data-toggle="tooltip" style="margin-right: 5px;">
                  <i class="fa fa-times"></i></button>
                        <ul class="nav nav-tabs pull-right">
                            <li class="active"><a href="#tab_1_c" data-toggle="tab">Principal</a></li>
                            <li><a href="#tab_2_c" data-toggle="tab">Diagnostico</a></li>
                          
                        </ul>
                       </div>
                       
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#Calibracion">Calibracion</a> 
                        </h4>
                    </div>
                    <div id="Calibracion" class="panel-collapse collapse">
                        <div class="box-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_c">
                                  <!--Equipo-->
                                     <div class="form-group col-sm-8">
                                        {!! Form::label('equipo_mp', 'Equipo') !!}
                                        {!! Form::select('equipo_mp',array('EQ1','EQ2','EQ3')) !!}
                                    </div>
                                    <!--Equipo Generador-->
                                     <div class="form-group col-sm-8">
                                        {!! Form::label('equipo_ge', 'Equipo Generador') !!}
                                        {!! Form::select('equipo_ge',array('EQ1','EQ2','EQ3')) !!}
                                    </div>
                                    <!--Equipo Calibrador-->
                                     <div class="form-group col-sm-8">
                                        {!! Form::label('equipo_ca', 'Equipo Calibrador') !!}
                                        {!! Form::select('equipo_ca',array('EQ1','EQ2','EQ3')) !!}
                                    </div>
                                    <!--Tipo de actividad sobre el equipo-->
                                      <div class="form-group col-sm-8">
                                        {!! Form::label('actividad', 'Tipo de actividad') !!}
                                        {!! Form::select('actividad',array('Calibracion','Mantencion','Visita')) !!}
                                    </div>
                                    <!--Estado-->
                                     <div class="form-group col-sm-12">
                                        {!! Form::label('estado', 'Estado') !!}
                                        {!! Form::select('estado',array('Sin agendar')) !!}
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_2_c">
                                     <!--Observaciones-->
                                      <div>
                                        {!! Form::label('diagnostico', 'Diagnostico Preliminar') !!}
                                        {!! Form::textarea('diagnostico',null,array('rows'=>'1' ,'cols'=>'3','class'=>'form-control' )) !!}
                                     </div>      
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
             <!--Siguiente Collapse-->
                {{--
                <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        +
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse">
                    <div class="box-body">
                     COLLAPSE
                    </div>
                  </div>
                </div>
                --}}             
            </div>
          </div>
        </div>
      </div>
      <!--End Collapsible-->
                        <div class="form-group col-sm-4">
                {!! Form::submit('Guardar',['class'=>'btn btn-success']) !!}
                        </div>
                {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-blade')
<!--Añadir Mas Actividades a las Ordenes de trabajo-->
<script>
   $("#delete").click(function (e) {
      e.preventDefault();
      alert("Delete");
      var parent = $(this).parent().get(0);
      $(parent).remove();

    });

    $("#BtnMantencion").click(function (e) {
      e.preventDefault();

      val = 'Mantencion';
      
      var event = $("<div />");
      var box_title = $('<a data-toggle="collapse" data-parent="#accordion" href="#'+val+'"></a>').fadeIn('slow');
      var exd = $('<div><input type="text" class="field" name="dynamic[]" value="' + val + '" /></div>').fadeIn('slow');
     
      event.addClass("panel box box-success");//css({"background-color": currColor, "border-color": currColor, "color": "#fff"})
      event.addClass("box-header with-border");
      event.addClass("box-title").html(val).append(box_title);
      //.css({"data-toggle": collapse "data-parent": #accordion "href" : val});
    //event.addClass("panel-collapse collapse");
    //event.addClass("box-body");
      
     
       //$('#collapseThree').prepend(event); /*Agregamos al Panel*/
       //$('#accordion').prepend(event); /*Agregamos al Panel*/
      $('#accordion').append(event); /*Agregamos al Panel*/

    });
        $("#BtnVisita").click(function (e) {
      e.preventDefault();

      val = 'Visita';
      
      var event = $("<div />");
      var box_title = $('<a data-toggle="collapse" data-parent="#accordion" href="#'+val+'"></a>').fadeIn('slow');
      var exd = $('<div><input type="text" class="field" name="dynamic[]" value="' + val + '" /></div>').fadeIn('slow');
     
      event.addClass("panel box box-success");//css({"background-color": currColor, "border-color": currColor, "color": "#fff"})
      event.addClass("box-header with-border");
      event.addClass("box-title").html(val).append(box_title);
      //.css({"data-toggle": collapse "data-parent": #accordion "href" : val});
    //event.addClass("panel-collapse collapse");
    //event.addClass("box-body");
      
     
       //$('#collapseThree').prepend(event); /*Agregamos al Panel*/
       //$('#accordion').prepend(event); /*Agregamos al Panel*/
      $('#accordion').append(event); /*Agregamos al Panel*/

    });
            $("#BtnCalibracion").click(function (e) {
      e.preventDefault();

      val = 'Calibracion';
      
      var event = $("<div />");
      var box_title = $('<a data-toggle="collapse" data-parent="#accordion" href="#'+val+'"></a>').fadeIn('slow');
      var exd = $('<div><input type="text" class="field" name="dynamic[]" value="' + val + '" /></div>').fadeIn('slow');
     
      event.addClass("panel box box-success");//css({"background-color": currColor, "border-color": currColor, "color": "#fff"})
      event.addClass("box-header with-border");
      event.addClass("box-title").html(val).append(box_title);
      //.css({"data-toggle": collapse "data-parent": #accordion "href" : val});
    //event.addClass("panel-collapse collapse");
    //event.addClass("box-body");
      
     
       //$('#collapseThree').prepend(event); /*Agregamos al Panel*/
       //$('#accordion').prepend(event); /*Agregamos al Panel*/
      $('#accordion').append(event); /*Agregamos al Panel*/

    });
      $("#BtnOtra").click(function (e) {
      e.preventDefault();

      val = 'Otras Actividades';
      
      var event = $("<div />");
     // var box_title =$("");
      var exd = $('<div><input type="text" class="field" name="dynamic[]" value="' + val + '" /></div>').fadeIn('slow');
     
      event.addClass("panel box box-success");//css({"background-color": currColor, "border-color": currColor, "color": "#fff"})
      event.addClass("box-header with-border");
     // event.addClass("box-title").html(val).append(box_title);
      //.css({"data-toggle": collapse "data-parent": #accordion "href" : val});
    //event.addClass("panel-collapse collapse");
    //event.addClass("box-body");
      
     
       //$('#collapseThree').prepend(event); /*Agregamos al Panel*/
       //$('#accordion').prepend(event); /*Agregamos al Panel*/
  
  //    $('#accordion').append(event); /*Agregamos al Panel*/


  //$("panel box box-success").clone().append("#accordion");
  //$('#accordion').clone().appendTo('panel box box-success');

  //$("#boxbox").clone().removeClass("box-title").appendTo("#accordion");

  //$("").clone().appendTo("");
 var cls = $("box-title").clone();
 cls.find("#id").replaceWith('Otras');
var accord = $("#boxbox").clone();
//accord.find("box-title").replaceWith("");
accord.removeClass("box-title");
accord.addClass("box-title").replaceWith(cls);
$("#accordion").append(accord);

//  $("#boxbox").clone().appendTo("#accordion");

    });



</script>


<!---->

<!--Script Alerta-->
<script>
    function CheckRepetir(checkboxElem) {
  if (checkboxElem.checked) {
    $("#Repetir").show();
   
  } else {
   $("#Repetir").hide();
  }
}
</script>
  <!--Habilitacion de Datepicker y creacion de script-->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({changeMonth: true,changeYear: true});
    $( "#datepicker" ).datepicker( "option", "dateFormat", 'yy-mm-dd');/*Configuracion de fecha en ISO 8601*/
  } );
</script>

<script>
  $( function() {
    $( "#datepicker2" ).datepicker({changeMonth: true,changeYear: true});
    $( "#datepicker2" ).datepicker( "option", "dateFormat", 'yy-mm-dd');/*Configuracion de fecha en ISO 8601*/
  } );

/*Date RangePicker*/
$('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Hoy': [moment(), moment()],
            'Mañana': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            //'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
            //'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
            'Todo Este Mes': [moment().startOf('month'), moment().endOf('month')]
            //'Ultimo Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

</script>

<!--Habilitacion de dataTables-->
<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
@endsection