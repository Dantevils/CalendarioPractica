@extends('app')

@section('main-content')
	<div class="container spark-screen">
		<div class="row">		
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Ordenes de Trabajo</div>
						<!--<div class="panel-body">-->
						<!--Boton Crear-->
						 <a href="{{ route('Ordenes.create')}}" class="btn btn-warning"> + <span></span></a>

							<div class="box-body">
								<table id="example1" class="table table-bordered table-striped">
					                <thead>
					                <tr>
					                 <th>ID</th>
									 <th>actividad_estado_id</th>
									 <th>equipo_id</th>
									 <th>ejecucion</th>
									 <th>actividad_tipo_id</th>
									 <th>obsercacion</th>
									 <th>operador_id</th>
									 <th>agenda_id</th>
									 <th>Accion</th>
					                </tr>
					                </thead>
               						 <tbody>
               						
              						@foreach($actividades as $varlist)
									<tr>
									 <td>{!! $varlist->id !!}</td>
									 <td>{!! $varlist->actividad_estado_id !!}</td>
									 <td>{!! $varlist->equipo_id !!}</td>
									 <td>{!! $varlist->ejecucion !!}</td>
									 <td>{!! $varlist->actividad_tipo_id !!}</td>
									 <td>{!! $varlist->obsercacion !!}</td>
									 <td>{!! $varlist->operador_id !!}</td>
									 <td>{!! $varlist->agenda_id !!}</td>
									<td>					
									{{--	<!--Boton Editar-->
									 <a href="{{ route('Convenio.edit',$varlist->id)}}" class="btn btn-warning">Editar<span class="glyphicon glyphicon-pencil"></span></a>

										<!--Boton Eliminar-->
									 <a href="{{ route('destroyConvenio.destroy',$varlist->id) }}" onclick="return confirm('¿Seguro que desea eliminar?')" class="btn btn-danger">Eliminar <span class="glyphicon glyphicon-trash"></span></a>
									</td>
									--}}

									</tr>
									@endforeach
									

            				    	 </tbody>
              					</table>
							</div>
					</div>
				</div>
			</div>
		</div>
@endsection