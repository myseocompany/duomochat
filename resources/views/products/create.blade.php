@extends('layout')

@section('content')
<h1>Crear Producto</h1>

<form class="form-group" action="/products" method="POST" enctype='multipart/form-data'>
  {{ csrf_field() }}
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="row">
        <label class="col-6">Nombre:</label>
        <input id="name" name="name" class="col-6 form-control">
      </div>
    </div>
    <div class="col-md-6 col-sm-12">
      <div class="row">
        <label class="col-6">Referencia:</label>
        <input id="reference" name="reference" class="col-6 form-control">
      </div>
    </div>
    <div class="col-md-6 col-sm-12">
      <div class="row">
        <label class="col-6">Precio:</label>
        <input id="price" name="price" class="col-6 form-control">
      </div>
    </div>
    <div class="col-md-6 col-sm-12">
      <div class="row">
        <label class="col-6">Cantidad:</label>
        <input id="quantity" name="quantity" class="col-6 form-control">
      </div>
    </div>
    <div class="col-md-6 col-sm-12">
      <div class="row">
        <label class="col-6">Linea:</label>
        
        <select id="category_id" name="category_id" class="col-6 form-control" required="required">
          <option>Seleccione una linea...</option>
          @foreach($categories as $item)
          <option value="{{$item->id}}" >{{$item->name}}</option>
          @endforeach
        </select>
      </div>
      <div class="row">
        <label class="col-6">Estado:</label>
        <select id="status_id" name="status_id" class="col-6 form-control" required="required">
          <option>Seleccione un estado...</option>
          @foreach($statuses as $item)
          <option value="{{$item->id}}" >{{$item->name}}</option>
          @endforeach
        </select>
      </div>
      <div class="row">
        <label class="col-6" for="image_url">Imagen:</label>
        <input type="file" id="image_url" name="image_url" class="col-6 form-control">
      </div>
    </div>
</div>
<div class="nav_var">
  <input type="submit" name="" class="btn btn-primary btn-sm" value="Enviar">
</div>

</form>
@endsection