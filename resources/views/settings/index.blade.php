@extends('layout')

@section('content')
 @if (session('statustwo'))
          <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
            {!! html_entity_decode(session('statustwo')) !!}
        </div>
  @endif
<br>
<h1 class="text-center">Ajustes</h1>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Value</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>
                @foreach($model as $item)
                <tr>
                  <td>{{ $item->id }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->value }}</td>
                  <td>
                    {{-- editar --}}
                    <a href="/settings/{{$item->id }}/edit"><span class="btn btn-sm btn-warning" aria-hidden="true" title="Editar">Editar</span></a>
                  </td>
                </tr>
        @endforeach
              </tbody>
            </table>
  
@endsection