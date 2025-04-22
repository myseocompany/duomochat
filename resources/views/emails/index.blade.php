@extends('layout')

@section('content')


<!-- Lista de emails -->
<div class="row">
  <div class="container">
    <div><a href="/emails/create/">Crear <i class="fa fa-plus-square"></i></a></div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Asunto</th>
          
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php $cont = 1 ?>
        @foreach($model as $item)
        <tr>
          <td>
            {{$cont++}}
          </td>
          <td><a href="{{ env('APP_BASE') }}/emails/{{ $item->id }}/show">{{ $item->subject }}</a></td>
          <td>
            <a href="{{ env('APP_BASE') }}/emails/{{$item->id }}/show" class=" btn btn-sm btn-primary my-2 my-sm-0">Ver</a>
            <a href="{{ env('APP_BASE') }}/emails/{{$item->id }}/edit" class=" btn btn-sm btn-warning my-2 my-sm-0">Editar</a>
            <a href="{{ env('APP_BASE') }}/emails/{{$item->id }}/destroy" class=" btn btn-sm btn-danger my-2 my-sm-0">Eliminar</a>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</div>

@endsection