@extends('layout')

@section('content')
<h1>Crear Tipo Producto</h1>
{{-- Formulario Tipo Productos --}}
<form action="/product_types" method="POST" enctype="multipart/form-data">
	{{csrf_field() }}
	<div class="form-group">
		<label for="name">Nombre:</label>
		<input type="text" name="name" id="name" class="form-control" placeholder="Name" value="" required="required">

		<!--<label for="parent">Parent:</label>
		<input type="text" name="parent" id="parent" class="form-control" placeholder="Parent" value="">-->

		<label for="weight">Weight:</label>
		<input type="text" name="weight" id="weight" class="form-control" placeholder="Weight" value="">

		<label for="file">Seleccione el archivo:</label>
        <input type="file" class="form-control" id="file" name="file">
              
		<!--<label for="category_id">Category:</label>
		<input type="text" name="category_id" id="category_id" class="form-control" placeholder="Category" value="">-->

        <label for="category_id">Etapa:</label>
         <select id="category_id" name="category_id" required="required" class="form-control">
          <option value="">Seleccione una categoría ...</option>
          @foreach($categories as $item)
          <option value="{{$item->id}}">{{$item->name}}</option>
          @endforeach
        </select>

        <label for="parent_id">Tipo:</label>
         <select id="parent_id" name="parent_id" required="required" class="form-control">
          <option value="">Seleccione un Tipo...</option>
          @foreach($product_types as $item)
          <option value="{{$item->id}}">{{$item->name}}</option>
          @endforeach
        </select>

	</div>
	<button type="submit" class="btn btn-primary">Crear</button>
	<a href="/product_types" class="btn btn-danger">Cancelar</a>
</form>


@endsection