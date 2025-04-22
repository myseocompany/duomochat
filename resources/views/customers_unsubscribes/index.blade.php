@extends('layout')

@section('content')

<h1>Desuscribir</h1>
@if (session('status'))
<div class="alert alert-primary alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    {!! html_entity_decode(session('status')) !!}
</div>
@endif
<div>
    <form action="/customers_unsubscribe" method="POST" class="form-inline">
        <div class="">
            {{ csrf_field() }}
            <div class="form-group ">
                <input type="text" id="phone" name="phone" class="form-control ">
                <input type="submit" value="Enviar" class="btn btn-sm btn-primary my-2 my-sm-0 ">

            </div>
        </div>
    </form>
</div>
<table class="table table-striped table-sm">
    <thead>
        <tr>
            <td>Telefono</td>
            <td>Fecha de creación</td>
            <td>Fecha de actualizacion</td>
            <td>Acciones</td>

        </tr>
    </thead>
    <tbody>
        @foreach($model as $item)
        <tr>
            <td>{{$item->phone}}</td>
            <td>{{$item->created_at}}</td>
            <td>{{$item->updated_at}}</td>
            <td>
                <a href="/customers_unsubscribe/{{$item->phone}}/edit">Editar</a>
                |
                <a href="/customers_unsubscribe/{{$item->phone}}/destroy">Eliminar</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $model->appends(request()->input())->links() }}
@endsection