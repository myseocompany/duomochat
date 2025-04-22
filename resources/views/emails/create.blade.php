@extends('layout')

@section('content')


<script src="//cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<h1>Crear email</h1>
<form method="POST" action="/emails">
  {{ csrf_field() }}
  <div class="container">
    <div class="row form-group">
      <div class="col-md-6">        

        <label for="subject">Asunto:</label>
        <input type="text" class="form-control" id="subject" name="subject" placeholder="Asunto" required="required">
<!--
        <label for="view">Nombre plantilla:</label>
        <input type="text" class="form-control" id="view" name="view" placeholder="Nombre email" required="required">
-->
        <label for="subject">Programado para:</label>
        <input class="form-control" type="date" name="date"><br>
        <input class="form-control" type="time" name="time">

        <label for="subject">Enviado a:</label>
        <select name="audience_id" class="form-control">
          @foreach($audiences as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
          @endforeach
        </select>

      </div>

      <div class="col-md-6">

        <label for="content">Contenido:</label>
        <textarea name="content" class="form-control" id="content" name="content" cols="30" rows="10"></textarea>
        <!--EDITOR -->
        <script>
          CKEDITOR.replace('content');
           CKEDITOR.config.allowedContent = true;
        </script>

      </div>
    </div>
    <div>
      <br>
      <button type="submit" class="btn btn-sm btn-primary " value="Borrador" id="save" name="save">Guardar</button>
    </div>

</form>

@endsection