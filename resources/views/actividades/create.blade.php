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
              <div class="btn-group col-sm-offset">
                  <button type="button" class="btn btn-default">Actividades</button>
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#" onclick="return confirm('Añadir Mantencion?')" >Mantencion</a></li>
                    <li><a href="#" onclick="return confirm('Añadir Visita')">Visita</a></li>
                    <li><a href="#" onclick="return confirm('Añadir Calibracion')">Calibracion</a></li>
                    <li><a href="#" onclick="return confirm('Añadir ')">Otra</a></li>
                  <!--Boton Para activiades Defecto-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        Información General 
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                <div class="box-body">
                     
               <!--Formulario de Datos Defectos-->               
                        {!! Form::open(['route'=>'gcalendar.store','method'=>'POST'])!!} <!--Ruta de almacenamiento-->
                         <!--Operador-->
                         <div class="form-group col-sm-8">
                            {!! Form::label('operador', 'Operador ') !!}
                            {!! Form::select('operador', array('Codelco El Teniente'))!!}
                        </div>
                        <!--Estacion-->
                        <div class="form-group col-sm-8">
                            {!! Form::label('estacion', 'Estacion ') !!}
                            {!! Form::select('estacion', array('Colon','Cauquenes')) !!}
                        </div>
                        <!--Estado-->
                         <div class="form-group col-sm-8">
                            {!! Form::label('estado', 'Estado ') !!}
                            {!! Form::select('estado',array('Sin agendar')) !!}
                        </div>
                         <!--Status-->
                         <div class="form-group col-sm-8">
                            {!! Form::label('status', 'Status ') !!}
                            {!! Form::select('status',array('Valor')) !!}
                        </div>
                        <!--Automatica-->
                         <div class="form-group col-sm-8">
                            {!! Form::label('auto', 'Automatica ') !!}
                            {!! Form::checkbox('auto','value') !!}
                        </div>
                        <!--Fecha Maxima-->
                            <!--Seccion de fechas-->
                        <div class="form-group  col-sm-5">
                        {!! Form::label('fecha_max', 'Fecha Maxima ') !!}
                             <div class="input-group date">
                             <div class="input-group-addon">
                             <i class="fa fa-calendar"></i>
                             </div>
                    {!! Form::text('fecha_max',null,['class'=>'form-control pull-right','id'=>'datepicker','placeholder'=>'Fecha Maxima','required']) !!}
                             </div>
                        </div>
                      {{--<div class="form-group">
                        {!! Form::submit('Guardar',['class'=>'btn btn-success']) !!}
                        <a href="#" onclick="return confirm('¿Seguro?')" class="btn btn-danger">+<span></span></a>
                        </div>  
                        {!! Form::close() !!}--}}
                    </div>
                  </div>
                </div>
                <div class="panel box box-danger">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        Actividad (MP)
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="box-body">
                         {{--{!! Form::open(['route'=>'gcalendar.store','method'=>'POST'])!!}--}}
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
                         <div class="form-group col-sm-8">
                            {!! Form::label('estado', 'Estado') !!}
                            {!! Form::select('estado',array('Sin agendar')) !!}
                        </div>
                         <!--Observaciones-->
                         <div class="form-group col-sm-8">
                            {!! Form::label('auto', 'Automatica') !!}
                            {!! Form::textarea('auto','value') !!}
                        </div>

                           <!--Repetir-->
                         <div class="form-group col-sm-8">
                            {!! Form::label('auto', 'Repetir') !!}
                            {!! Form::checkbox('estado','check')!!} <!--Booleano-->
                            {!! Form::select('estado',array('1','2','3','4','5','6','7','8')) !!}
                             {!! Form::label('auto', 'veces') !!}
                               {!! Form::select('estado',array('Dia','Semana','Mes')) !!}
                        </div>

                        <div class="form-group col-sm-8">
                <label>Rango:</label>

                <div class="input-group">
                  <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                    <span><i class="fa fa-calendar"></i>Rango</span>
                    <i class="fa fa-caret-down"></i>
                  </button>
                </div>
              </div>
                        {{--<div class="form-group">
                        {!! Form::submit('Guardar',['class'=>'btn btn-success']) !!}
                        </div>
                        <div class="form-group">
                            <a href="#" onclick="return confirm('¿Seguro?')" class="btn btn-danger">+<span class="glyphicon glyphicon-trash"></span></a>
                        </div> --}}      
                    </div>
                  </div>
                </div>
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
                     txt.
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
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
            'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
            'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
            'Todo Este Mes': [moment().startOf('month'), moment().endOf('month')],
            'Ultimo Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
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