@extends('layout')

@section('content')

<h1>Desuscribir</h1>

<div>
    <form action="/customer_unsubscribes/{{$model->phone}}/update" method="POST">
        <div class="row">
       {{ csrf_field() }}
            <div class="form-group col">
                <input type="text" id="phone" name="phone" class="form-control " value="{{$model->phone}}"> 
                <input type="submit" value="Enviar" class="btn btn-sm btn-primary my-2 my-sm-0 "> 

            </div>
        </div>
    </form>
</div>
@endsection