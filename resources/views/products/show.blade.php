@extends('layout')

@section('content')
<h1>{{$model->name}} @if(isset($model->category)) {{$model->category->name}} @endif</h1>

<form class="form-group">
<div class="row">
    <div class="col-sm-6">
      <img src="/{{$model->image_url}}" alt="">
      "{{$model->image_url}}"
    </div>
    <!-- detalle del producto -->
    <div class=col-sm-6>
      <div class="col-sm-12">
        <div class="row">
          <label>Nombre:</label>
          <input readonly name="name" name="name" class="form-control" value="{{$model->name}}">
        </div>
      </div>
      <div class="col-sm-12">
        <div class="row">
          <label>Referencia:</label>
          <input readonly name="reference" name="reference" class="form-control" value="{{$model->reference}}">
        </div>
      </div>
      <div class="col-sm-12">
        <div class="row">
          <label>Precio:</label>
          <input readonly name="price" name="price" class="form-control" value="{{$model->price}}">
        </div>
      </div>
      <div class="col-sm-12">
        <div class="row">
          <label>Categoria:</label>
          @if(isset($model->category))
          <input readonly name="category_id" name="category_id" class="form-control" value="{{$model->category->name}}">
          @endif  
        </div>
      </div>
      <div class="col-sm-12">
        <div class="row">
          <label>Estado:</label>
          @if(isset($model->status))
          <input readonly name="status" name="status" class="form-control" value="{{$model->status->name}}">
          @else
            sin estado
          @endif 
        </div>
      </div>
      <div class="col-sm-12">
        <div class="row">
          <label>Cantidad:</label>
          @if(isset($model->quantity))
          <input readonly name="quantity" name="quantity" class="form-control" value="{{$model->quantity}}">
          @else
            sin estado
          @endif 
        </div>
      </div>
    </div>
    <!-- fin del detalle -->
  </div>
	
</form>

<div class="nav_var"><a href="/products/{{$model->id}}/edit"><span class="btn btn-primary btn-sm">Editar</span> </a></div>
@endsection