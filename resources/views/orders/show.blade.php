@php
    \Carbon\Carbon::setLocale('es');
@endphp
@extends('layout')

@section('content')
<div><a href="/orders">Ordenes</a> >> ver</div>
<h1>Orden {{$model->id}}</h1>


<div class="col-md-12 col-sm-12">
		<a href="/orders/{{$model->id}}/edit">
			Editar 
		</input>
		</a>
		|
		<a href="/orders/{{ $model->id }}/delete"> Eliminar</a>

	</div>
<form action="/orders/{{$model->id}}/update" method="POST" class="form-group">
{{csrf_field()}}	
	<div class="row">
		@if(isset($model->customer))
		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Cliente</h3>
			<div class="row">

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Nombre:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->customer->name}}">
						<a href="/customers/{{$model->customer->id}}/show">{{$model->customer->name}}</a>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Cédula:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->customer->document}}">{{$model->customer->document}}</div>
					</div>
				</div>
				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Teléfono:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->customer->phone}}">{{$model->customer->phone}}</div>
					</div>
				</div>
				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Email:</label>
						<div readonly id="email" name="email" class="col-6" value="{{$model->customer->email}}">{{$model->customer->email}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Dirección:</label>
						<div readonly id="address" name="address" class="col-6" value="{{$model->customer->address}}">{{$model->customer->address}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Cumpleaños:</label>
						<div readonly id="address" name="address" class="col-6" value="{{$model->customer->birthday}}">{{$model->customer->birthday}}</div>
					</div>
				</div>
			
				
			</div>
		</div>
		


		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Entrega</h3>
			<div class="row">

			
		
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Destinatario:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_name}}"><a href="/customers/{{$model->customer->id}}/show">{{$model->customer->name}}</a></div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">--:</label>
						<div readonly id="" name="" class="col-6" value="">--</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Teléfono:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_phone}}">{{$model->delivery_phone}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Email:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_email}}">{{$model->delivery_email}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Dirección:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_address}}">{{$model->delivery_address}}</div>
					</div>
				</div>



			</div>
		</div>
		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Detalles</h3>
			<div class="row">

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Fecha:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_date}}">
							{{$model->delivery_date}}
				
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Estado:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_address}}">
							<select name="status_id" id="status_id" onchange="this.form.submit()" class="form-control">
								<option>Selecciona...</option>
								
							
								@foreach($statuses as $item)
								<option value="{{$item->id}}" @if($model->status_id == $item->id) selected="selected" @endif>{{$item->name}}</option>
								@endforeach
							</select>
						</div>
						<input type="hidden" id="order_id" name="order_id" value="{{$model->id}}" ></td>
				
					</div>
				</div>			
				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Medio de pago:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_address}}">
							<select name="payment_id" id="payment_id" onchange="this.form.submit()" class="form-control">
								
								<option value="">Selecciona...</option>
								
								@foreach($payments as $item)
								<option value="{{$item->id}}" @if($model->payment_id == $item->id) selected="selected" @endif>{{$item->name}}</option>
								@endforeach
							</select>
						</div>
						<input type="hidden" id="order_id" name="order_id" value="{{$model->id}}" ></td>
				
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Fuente:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_address}}">
							<select name="source_id" id="source_id" onchange="this.form.submit()" class="form-control">
								
								<option value="">Selecciona...</option>
								
								@foreach($sources as $item)
								<option value="{{$item->id}}" @if($model->source_id == $item->id) selected="selected" @endif>{{$item->name}}</option>
								@endforeach
							</select>
						</div>
						<input type="hidden" id="order_id" name="order_id" value="{{$model->id}}" ></td>
				
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6"> Atendido por:	</label>
						<div readonly id="" name="" class="col-6">
							
							@if(isset($model->user) && $model->user_id !="") {{$model->user->name}} @endif	
						</div>
					
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6"> Formulado por:	</label>
						<div readonly id="" name="" class="col-6">
						@foreach($referal as $item)		
							@if($model->referal_user_id == $item->id)
								{{$item->name}}
							@endif
						@endforeach
							</div>
					
					</div>
				</div>
			 <div class="col-md-12 col-sm-12">
				<div class="row">

				<label > Notas:</label>
					<div readonly id="" name="" class="col-6">
						{{$model->notes}}
					</div>
				</div>
				</div>
			 <div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6"> Localización:	</label>
					<div readonly id="" name="" class="col-6">
						<input class="form-control" readonly id="latitude" name="latitude"  value="{{$model->latitude}}"><br>
						<input class="form-control" readonly id="longitude" name="longitude" value="{{$model->longitude}}">
					</div>
				

				@if($model->latitude && $model->longitude)
				<!-- Leaflet CSS -->
				<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

				<!-- Leaflet JS -->
				<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
				<div id="map" style="width: 100%; height: 400px;"></div>
				<script>
					@endif
    @if($model->latitude && $model->longitude)
    // Inicializar el mapa solo si hay latitud y longitud
    var map = L.map('map').setView([{{$model->latitude}}, {{$model->longitude}}], 15);

    // Cargar el mapa base desde OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Añadir un marcador en la ubicación
    L.marker([{{$model->latitude}}, {{$model->longitude}}]).addTo(map)
        .bindPopup('<b>Ubicación de entrega</b><br>{{$model->delivery_address}}')
        .openPopup();
    @endif
</script>

				@endif

					
				
				<script>
					@if($model->status_id == 3)
				
					document.addEventListener('DOMContentLoaded', (event) => {
    // Inicializar la captura de geolocalización cuando la página cargue
    initializeGeolocation();
});
@endif
				

function initializeGeolocation() {
    // Verificar si el navegador soporta geolocalización
    if (navigator.geolocation) {
        // Mostrar "calculando..." en los campos de entrada mientras se obtiene la geolocalización
        setCalculatingMessage();

        // Iniciar la obtención de la geolocalización
        navigator.geolocation.getCurrentPosition(onGeolocationSuccess, onGeolocationError);
    } else {
        alert("Geolocalización no es soportada por este navegador.");
    }
}

function setCalculatingMessage() {
    document.getElementById('latitude').value = "calculando...";
    document.getElementById('longitude').value = "calculando...";
}

function onGeolocationSuccess(position) {
    // Obtener la latitud y longitud
    var lat = position.coords.latitude;
    var long = position.coords.longitude;

    // Llenar los campos de entrada con los valores obtenidos
    setCoordinates(lat, long);
}

function onGeolocationError(error) {
    console.error("Error al obtener la geolocalización: ", error);
    alert("No se pudo obtener la geolocalización. Por favor, permite el acceso a la ubicación.");
    // Limpiar los mensajes "calculando..." si hay un error
    clearCalculatingMessage();
}

function setCoordinates(latitude, longitude) {
    // Llenar los campos de entrada con los valores de latitud y longitud
    document.getElementById('latitude').value = latitude;
    document.getElementById('longitude').value = longitude;
}

function clearCalculatingMessage() {
    document.getElementById('latitude').value = "";
    document.getElementById('longitude').value = "";
}


				</script>
				
				</div>
			 </div>
			 

			<!-- <div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6"> Formulado por:	</label>
					<div readonly id="" name="" class="col-6">
						
@if(isset($model->user) && $model->user_id !="") {{$model->user->name}} @endif	
					</div>
				
				</div>-->
			 </div>

			</div>
		</div>
	</div>
</form>
<br>
@include('orders.add_file', ['order_id' => $model->id])
@include('orders.file-list', ['order_id' => $model->id])
<br>

				
			


<br>
<br>
<h2>Productos en la orden</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Producto</th>
            
            <th class="text-center">Cantidad</th>
			<th class="text-center">Asesor</th>
			<th class="text-center">Tipo de venta</th>
			
            <th class="text-center">Valor</th>
            <th class="text-center">Descuento</th>
            <th class="text-center">Total</th>
			<th class="text-center"></th>
        </tr>
    </thead>
	<form action="/orders/{{$model->id}}/updateProducts" method="POST" class="form-group">
	{{csrf_field()}}
    <tbody>
        <?php $total = 0; ?>
        @if(isset($model->productList))
            @foreach($model->productList as $item)
                <tr>
                    <td class="text-left">
                        @if(isset($item->product))
                            {{$item->product->name}}
                        @endif
                    </td>
					<td class="text-center">{{$item->quantity}}</td>
                    
					<td class="text-center ">
						@if($item->sale_type_id==1 )  <!-- es formula -->
							@if($model->referal_user){{$model->referal_user->name}}
							@else
								Sin dermatologo
							@endif
						@else
						@if($item->user){{$item->user->name}}@endif
						@endif
					</td>

					<td class="text-center ">
						@if($item->saleType)
							{{$item->saleType->name}}
						@endif
					</td>
				
					<td class="text-center ">
						    {{$item->price}}
                        
					</td>

                    <td class="text-center">{{$item->discount}}%</td>
					
                    <td class="text-center">${{number_format($item->total, 0)}}</td>
					<td class="text-center ">
						<input value="-" data-toggle="modal" data-target="#destroy_{{$item->id}}" class="btn btn-primary btn-sm" size="1">
						<div class="modal" id="destroy_{{$item->id}}">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">¿Esta seguro que desea eliminar?</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body">
										<p>@if(isset($item->product)){{$item->product->name}}@endif</p>
										<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
										<a href="/orders/product/{{ $item->id }}/destroy"> 
										<input type="" value="Sí" data-toggle="modal" data-target="#destroy_{{$item->id}}" class="btn btn-primary" size="1"></a>
									</div>

								</div>
							</div>
						</div>
					</td>
                </tr>
                <?php $total += $item->total; ?>
            @endforeach
        @endif
    </tbody>
	</form>
    <tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td class="text-right" style="font-size: 30px;">Total</td>
		<td class="text-center" style="font-size: 30px;">${{number_format($model->getTotal(), 0)}}</td>
	</tr>
</table>

<div class="row">

<div class="col-md-12 col-sm-12" style="text-align: -webkit-right;">
		<a href="/orders/{{$model->id}}/add/product">
			<input type="button" class="btn btn-primary" value="Agregar productos" >
			
		</input>
		</a>
	</div>

</div>
<br>
<br>
<h2>Medio de pago</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Medio de pago</th><th class="text-center ">Valor</th>
			<th></th>
		</tr>
	
	</thead>
	<tbody>
	<form action="/order/payment/store" method="post">

	{{csrf_field()}}
			<tr>
				<td class="text-center ">
				<select name="payment_id" id="payment_id" style="width:100%">		
				@foreach($payments as $item)
				<option value="{{$item->id}}" @if($model->payment_id == $item->id) selected="selected" @endif>{{$item->name}}</option>
				@endforeach
				</select>
				</td>
				
				<td class="text-right"><input type="text" id="credit" name="credit" value="0" size="7">
				<input type="hidden" id="order_id" name="order_id" value="{{$model->id}}" >
				</td>
				<td class="text-center "><input type="submit" value="+" class="btn btn-primary btn-sm" size="3"></td>
			</tr>
			
		
		<?php $total=0; ?>
		</form>
	@foreach($model->transactions as $item)
	<tr>
				<td >
					@if(isset($item->payment))
						{{$item->payment->name}}
					@endif
				
				</td>
				
				<td class="text-right">
				$ {{number_format($item->credit,0,",",".")}} 	
				
				

				</td>
				<td class="text-center "><input type="submit" value="+" class="btn btn-primary btn-sm" size="3"></td>
			</tr>
			
	@endforeach

</tbody>

</table>

@include('orders.histories_list')




@endsection