@extends('layout')

@section('content')
<h1>{{$model->name}}</h1>
{{-- Formulario de edicion --}}
<form method="POST" action="/product_types/{{$model->id}}/update" enctype="multipart/form-data">
	{{csrf_field() }}
	<div class="form-group">
	    <label for="name">Nombre:</label>
	    <input type="text" class="form-control" id="name" name="name" placeholder="name" value="{{$model->name}}" required="">

	    <label for="weight">Weight</label>
	    <input type="text" class="form-control" id="weight" name="weight" placeholder="weight" value="{{$model->weight}}">

	    <label for="image">Imagen Actual</label>
	    <img src="https://testtrujillo.quirky.com.co/public/product_types/{{ $model->image_url }}" height="50" width="60">
	    <br>
	    <input type="hidden" class="form-control" id="image" name="image" placeholder="image" value="{{$model->image_url}}">

	    <label for="file">Cambiar Imagen:</label>
        <input type="file" class="form-control" id="file" name="file">

        <label for="category_id">Etapa:</label>
         <select id="category_id" name="category_id" class="form-control">
          <option value="">Seleccione una categoría ...</option>
          @foreach($categories as $item)
          <option value="{{$item->id}}" @if($model->category_id==$item->id) selected="selected" @endif>{{$item->name}}</option>
          @endforeach
        </select>

        <label for="parent_id">Tipo:</label>
         <select id="parent_id" name="parent_id" class="form-control">
          <option value="">Seleccione un Tipo...</option>
          @foreach($product_types as $item)
          <option value="{{$item->id}}" @if($model->parent_id==$item->id) selected="selected" @endif>{{$item->name}}</option>
          @endforeach
        </select>
  	</div>
  <button type="submit" class="btn btn-primary">Modificar</button>
  <a href="/product_types" class="btn btn-danger">Cancelar</a>
</form>
@endsection