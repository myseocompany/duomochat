@extends('layout')

@section('content')
<div class="container">
    <h1>{{App\Models\ProductType::getName($request->type_id)}}</h1>
    <div><a href="/products/create">Crear producto</a></div>
    <!-- Formulario de búsqueda por nombre -->
    <div class="mb-3">
        <div class="form-group row">
            <label for="input-search" class="col-sm-2 col-form-label">Buscar Producto:</label>
            <div class="col-sm-8">
                <input type="text" name="input-search" id="input-search" class="form-control" placeholder="Nombre del producto">
            </div>
        </div>
    </div>

    <!-- Tabla para móviles -->
    <div class="table-responsive-sm d-md-none">
        <table class="table">
            <tbody id="mobile-product-table">
                @foreach($model as $item)
                <tr class="product-row">
                    <td>
                        @if(isset($item->image_url))
                        <div style="max-width: 100%; overflow: hidden;">
                            <img src="{{ asset('') }}/{{$item->image_url}}" alt="{{ $item->name }}" style="width: 100%; height: auto; object-fit: cover;">
                        </div>
                        @endif
                        <h4>{{$item->name}}</h4>
                        <div>${{number_format($item->price, 0)}}</div>
                        @if($item->quantity > 1)
                        <div>{{$item->quantity}} unidades disponibles</div>
                        @else
                        <div>{{$item->quantity}} unidad disponible</div>
                        @endif
                        @if(isset($item->type))
                        <strong>Tipo:</strong> {{$item->type->name}}<br>
                        @endif
                        <div><i>@if(isset($item->category)){{$item->category->description}}@endif</i></div>
                        @if(isset($item->status))
                        <div class="product-status" style="background-color:{{$item->status->color}}">
                            {{$item->status->name}}
                        </div>
                        @endif
                        <strong>Operaciones:</strong>
                        <a href="/products/{{$item->id}}/show" class="btn btn-sm btn-info">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        @if(Auth::user()->role_id == 1)
                        <a href="/products/{{$item->id}}/edit" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tabla para escritorio -->
    <div class="table-responsive-md d-none d-md-block">
        <table class="table table-striped item-list">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Valor</th>
                    <th>Tipo</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Operaciones</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody id="desktop-product-table">
                @foreach($model as $item)
                <tr class="product-row">
                    <td class="product-name">
                        <a href="/products/{{$item->id}}/show">{{$item->name}}</a>
                    </td>
                    <td>${{number_format($item->price, 0)}}</td>
                    <td>@if(isset($item->type)){{$item->type->name}}@endif</td>
                    <td>@if(isset($item->category)){{$item->category->description}}@endif</td>
                    <td>
                        @if(isset($item->status))
                        <span class="product-status" style="background-color:{{$item->status->color}}">
                            {{$item->status->name}}
                        </span>
                        @endif
                    </td>
                    <td>
                        <a href="/products/{{$item->id}}/show" class="btn btn-sm btn-info">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        @if(Auth::user()->role_id == 1)
                        <a href="/products/{{$item->id}}/edit" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        @endif
                    </td>
                    <td>
                        @if(isset($item->image_url))
                        <img src="{{ asset('') }}/{{$item->image_url}}" alt="{{ $item->name }}" style="width: 100px; height: auto;">
                        @else
                        <span>No hay imagen</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Filtrado en vivo -->
<script>
    $(document).ready(function() {
        $('#input-search').on('input', function() {
            var searchValue = $(this).val().toLowerCase();

            // Filtrar tabla móvil
            $('#mobile-product-table .product-row').each(function() {
                var productName = $(this).text().toLowerCase();
                $(this).toggle(productName.includes(searchValue));
            });

            // Filtrar tabla escritorio
            $('#desktop-product-table .product-row').each(function() {
                var productName = $(this).find('.product-name').text().toLowerCase();
                $(this).toggle(productName.includes(searchValue));
            });
        });
    });
</script>
@endsection
