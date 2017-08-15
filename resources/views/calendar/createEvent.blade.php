@extends('app')
@section('main-content')
    <div class="container spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Creacion de Eventos</div>

                    <div class="panel-body">
                       

{{--
 <form action="{{route('gcalendar.store')}}" method="POST" role="form">
        {{-csrf_field()-}}
        <legend>
            Create Event
        </legend>
        <div class="form-group">
            <label for="title">
                Title
            </label>
            <input class="form-control" name="title" placeholder="Title" type="text">
        </div>
        <div class="form-group">
            <label for="description">
                Description
            </label>
            <input class="form-control" name="description" placeholder="Description" type="text">
        </div>
        <div class="form-group">
            <label for="start_date">
                Start Date
            </label>
            <input class="form-control" name="start_date" placeholder="Start Date" type="text">
        </div>
        <div class="form-group">
            <label for="end_date">
                End Date
            </label>
            <input class="form-control" name="end_date" placeholder="End Date" type="text">
        </div>
        <button class="btn btn-primary" type="submit">
            Submit
        </button>
 </form>--}}

               <!--Form de Dante-->                
                        {!! Form::open(['route'=>'gcalendar.store','method'=>'POST'])!!} <!--Ruta de almacenamiento del controlador a Store-->
                        
                        <div class="form-group col-sm-4">
                            {!! Form::label('title', 'Titulo') !!}
                            {!! Form::text('title',null,['class'=>'form-control','placeholder'=>'Titulo','required']) !!}
                        </div>
                         <div class="form-group col-sm-4">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::text('description',null,['class'=>'form-control','placeholder'=>'Description','required']) !!}
                        </div>
                         <div class="form-group col-sm-4">
                            {!! Form::label('start_date', 'Inicio Evento') !!}
                            {!! Form::text('start_date',null,['class'=>'form-control','placeholder'=>'Inicio','required']) !!}
                        </div>
                         <div class="form-group col-sm-4">
                            {!! Form::label('end_date', 'Fin Evento') !!}
                            {!! Form::text('end_date',null,['class'=>'form-control','placeholder'=>'Fin','required']) !!}
                        </div>

                        
                        <div class="form-group">

                        {!! Form::submit('Guardar',['class'=>'btn btn-success']) !!}
                        </div>

                        {!! Form::close() !!}
                <!--Fin form de dante-->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection