@extends('layout')

@section('content')

<h1>Configuración </h1>
<div class="list-group">
	<a href="/customer_statuses" class="list-group-item">Estados de los Clientes</a>
</div>
<div class="list-group">
	<a href="/users" class="list-group-item">Usuarios</a>
</div>
<div class="list-group">
	<a href="/audiences" class="list-group-item">Audiencias</a>
</div>
<div class="list-group">
	<a href="/campaigns" class="list-group-item">Campañas</a>
</div>
<div class="list-group">
	<a href="/emails" class="list-group-item">Emails</a>
</div>
<div class="list-group">
	<a href="/roles" class="list-group-item">Roles</a>
</div>
<div class="list-group">
	<a href="/action_type" class="list-group-item">Tipos de Acción</a>
</div>
<div class="list-group">
	<a href="/products" class="list-group-item"> Productos</a>
</div>
<div class="list-group">
	<a href="/product_types" class="list-group-item">Tipos de Productos</a>
</div>


<div class="list-group">
	<a href="/customer_unsubscribes" class="list-group-item">Bloquear usuarios</a>
</div>


@endsection