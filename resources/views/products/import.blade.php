@extends('layout')

@section('content')
<h1>Importar productos</h1>


<h2>Subir arhivo</h2>
	<form action="/products/bulk_store" method="post" enctype="multipart/form-data">
		  {{ csrf_field() }}

    Seleccion el archivo <code>import_products.csv</code>
    <input type="file" name="file" id="file" class="form-control">
    <input type="submit" value="Enviar" name="submit" class="btn btn-primary btn-sm">
</form>
<br>

<br>
<h2>Plantilla</h2>


<code>
NAME, PRICE, STATUS, CATEGORY, TYPE, REGITRATION, BUILT_AREA, PRIVATE_AREA, PRICE_FULLY_FINISHED, PRICE_SEMI_FINISHED, PRICE_BLACK_WORK, SET_CATEGORY<br>
0101, 167502816, disponible, Torres del Bosque Etapa 2, 2, 53.83, 46.33, 193664196, 182036916, 167502816, x



</code>
<br>
<br>
Archivo de demostración
<br>
<a href="/public/imports/import_products.csv">import_products.csv</a>
<br>


@endsection