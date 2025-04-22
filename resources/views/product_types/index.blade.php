@extends('layout')

@section('content')
 @if (session('statustwo'))
          <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
            {!! html_entity_decode(session('statustwo')) !!}
        </div>
  @endif
<br>
<h1 class="text-center">Tipo de Productos</h1>
    <div>
    	<a href="product_types/create" class="btn btn-success">Create</a>
    </div>
    <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Imagen</th>
          <th>Weight</th>
          <th>Tipo</th>
          <th>Categoria</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($model as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->name }}</td>
          <td><img src="https://trujillo.quirky.com.co/public/product_types/{{ $item->image_url }}" height="50" width="60"></td>
          <td>{{ $item->weight }}</td>
          <td>@if(isset($item->parent_id)) {{$item->getName($item->parent_id)}} @endif</td>
          <td>@if(isset($item->category_id)) {{$item->category->name}} @endif</td>
          <td>
            {{-- editar --}}
            <a href="/product_types/{{$item->id }}/edit"><span class="btn btn-sm btn-warning" aria-hidden="true" title="Editar">Editar</span></a>
            {{-- eliminar --}}
            <a href="/product_types/{{$item->id }}/destroy"><span class="btn btn-sm btn-danger" aria-hidden="false" title="Eliminar">Eliminar</span></a>
          </td>
        </tr>
		@endforeach
      </tbody>
    </table>
    {{ $model->links('pagination::bootstrap-4') }}
@endsection