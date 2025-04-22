@extends('layout')

@section('content')
<h1>{{$model->name}} @if(isset($model->category)) {{$model->category->name}} @endif</h1>

<form class="form-group" action="/products/{{$model->id}}/update" method="POST">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-sm-12">
      <div class="row">
        <label>Nombre:</label>
        <input id="name" name="name" class="form-control" value="{{$model->name}}">
      </div>
    </div>
    <div class="col-sm-12">
      <div class="row">
        <label>Referencia:</label>
        <input id="reference" name="reference" class="form-control" value="{{$model->reference}}">
      </div>
    </div>
    <div class="col-sm-12">
      <div class="row">
        <label>Cantidad:</label>
        <input id="quantity" name="quantity" class="form-control" value="{{$model->quantity}}">
      </div>
    </div>
    <div class="col-sm-12">
      <div class="row">
        <label>Precio:</label>
        <input id="price" name="price" class="form-control" value="{{$model->price}}">
      </div>
    </div>
    <div class="col-sm-12">
      <div class="row">
        <label for="image_url">Imagen:</label>
        <input type="file" id="image_url" name="image_url" class="form-control">
      </div>
    </div>
    <div class="col-sm-12">
      <div class="row">
        <label>Estado:</label>
        <select id="category_id" name="category_id" class="form-control" required="required">
          <option>Seleccione un estado...</option>
          @foreach($statuses as $item)
          <option value="{{$item->id}}" >{{$item->name}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-sm-12">
      <div class="row">
        <label>Categoria:</label>
        
        <select id="category_id" name="category_id" class="form-control" required="required">
          <option>Seleccione una categoria...</option>
          @foreach($categories as $item)
          <option value="{{$item->id}}" @if($model->category_id==$item->id) selected="selected" @endif>{{$item->description}}</option>
          @endforeach
        </select>
      </div>
    </div>

    
  </div>
    
<div class="nav_var">
  <input type="submit" name="" class="btn btn-primary btn-sm" value="Enviar">
</div>

</form>
@endsection