@extends('layout')

@section('content')


<script src="//cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<h1>Editar email</h1>
<form method="POST" action="/emails/{{$model->id}}/update">
    {{ csrf_field() }}
    <div class="container">
        <div class="row form-group">
            <div class="col-md-6">

            <input type="hidden" id="id" name="id" value="{{$model->id}}">

                <label for="subject">Asunto:</label>
                <input type="text" class="form-control" id="subject" name="subject" placeholder="Asunto" required="required" value="{{$model->subject}}">
                <!--
                <label for="view">Nombre plantilla:</label>
                <input type="text" class="form-control" id="view" name="view" placeholder="Nombre email" required="required" value="{{$model->view}}">
-->


            </div>

            <div class="col-md-6">

                <label for="subject">Programado para:</label>

                <input class="form-control" type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{$model->getDateInput($model->scheduled_at)}}" >  
                

            </div>
            <div class="col-md-6">

                <label for="subject">Enviado a:</label>

                <select class="form-control" name="audience_id">
                    @foreach($audiences as $item)
                    <option value="{{$item->id}}" @if($item->id==$model->audience_id) selected @endif>{{$item->name}}</option>
                    @endforeach
                </select>  
                

            </div>
            
            <div class="col-md-12">
                <label for="content">Contenido:</label>
                <textarea name="content" class="form-control" id="content" name="content" cols="30" rows="50">{{$model->content}}</textarea>
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