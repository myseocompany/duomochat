@extends('layout')

@section('content')
<h1>Actualizar</h1>
{{-- Formulario de edicion --}}
<form method="POST" action="/settings/{{$model->id}}/update">
	{{csrf_field() }}
	<div class="form-group">
	    <label for="name">Nombre</label>
	    <input type="text" class="form-control" id="name" name="name" placeholder="nombre" value="{{$model->name}}" required="">
	    <label for="value">Valor</label>
	    <input type="text" class="form-control" id="value" name="value" placeholder="valor" value="{{$model->value}}" required="">
  	</div>
  <button type="submit" class="btn btn-primary">Modificar</button>
  <a href="/settings" class="btn btn-danger">Cancelar</a>
</form>
@endsection