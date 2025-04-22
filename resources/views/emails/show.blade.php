@extends('layout')

@section('content')


<script src="//cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<h1>Ver email</h1>
    {{ csrf_field() }}
    <div class="container">
        <div class="row form-group">
            <div class="col-md-6">

            <input type="hidden" id="id" name="id" value="{{$model->id}}">

                <label for="subject">Asunto:</label>
                <input type="text" class="form-control" id="subject" name="subject" placeholder="Asunto" required="required" value="{{$model->subject}}" disabled="disabled">
<!--
                <label for="view">Nombre plantilla:</label>
                <input type="text" class="form-control" id="view" name="view" placeholder="Nombre email" required="required" value="{{$model->view}}"  disabled="disabled">
-->


            </div>

            <div class="col-md-6">

                <label for="subject">Programado para:</label>
                <input class="form-control" type="datetime-local" name="scheduled_at" id="scheduled_at"disabled="disabled"  value="{{$model->getDateInput($model->scheduled_at)}}" >  
                



            </div>

            <div class="col-md-6">

                <label for="subject">Enviar a:</label>
                <input class="form-control" type="text" name="scheduled_at" id="scheduled_at"disabled="disabled"  value="@if(isset($model->audience)){{$model->audience->name}}@endif" >  
                



            </div>
            <div class="col-md-12">
                <label for="content">Contenido:</label>
                {!!$model->content!!}
                
            
            </div>
        </div>
        <div>
            <br>
            <a href="/emails/{{$model->id}}/edit" value="Borrador" id="save" name="save">Editar</a>
            &nbsp;|&nbsp;
            <a href="/emails/{{$model->id}}/storeAudience" value="Borrador" id="store" name="store">Guardar</a>
            &nbsp;|&nbsp;
            <a href="/emails/send" value="Borrador" id="store" name="store">Enviar</a>
        </div>

<h2>Acciones de envio</h2>
<div id="pending_actions">
<?php $cont=1; ?>
@if(isset($actions))
    @foreach($actions as $item)
    <div class="row">
        <div class="col-md-1">{{$cont++}}</div>
        <div class="col-md-3">@if( isset($item->customer) ){{$item->created_at }} {{$item->customer->mail}}@endif</div>
        <div class="col-md-4"> <a href="/customers/{{$item->customer_id}}/show">{{$item->getCustomerName()}}</a></div>
        <div class="col-md-4"> @if(isset($item->type)) {{$item->type->name}} @endif</div>
        
    </div>

    @endforeach
@endif

</div>

<h2>Envio</h2>
<div id="pending_actions">
<?php $cont=1; ?>
@if(isset($model->email_queue))
    <div class="row">
        <div class="col-md-1">No</div>
        <!-- <div class="col-md-3">@if(isset($item->customer)){{$item->customer->name}} @endif</div> -->
        <div class="col-md-4">email </div>
        <div class="col-md-3">fecha programado</div>
        <div class="col-md-3">fecha enviado</div>
        
        <div class="col-md-1">@if(isset($item->status)){{$item->status->name}}@endif </div>
        
    </div>
    @foreach($model->email_queue as $item)
    <div class="row">
        <div class="col-md-1">{{$cont++}}</div>
        <!-- <div class="col-md-3">@if(isset($item->customer)){{$item->customer->name}} @endif</div> -->
        <div class="col-md-4"><a href="/customers/{{$item->user_id}}/show">{{$item->email}}</a> </div>
        <div class="col-md-3">{{$item->available_at}}</div>
        <div class="col-md-3">{{$item->sended_at}}</div>
        
        <div class="col-md-1">@if(isset($item->status)){{$item->status->name}}@endif </div>
        
    </div>

    @endforeach
@endif
</div>
@endsection