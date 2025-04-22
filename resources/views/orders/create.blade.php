@extends('layout')

@section('content')

<div><a href="/orders">Ordenes</a> >> ver</div>
<h1>Crear Orden </h1>



<form class="form-group" action="/orders" method="POST">

{{ csrf_field() }}
	<div class="row">
		@if(isset($customer))
		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Cliente</h3>
			<div class="row">

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Nombre:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->customer->name}}">
						{{$model->customer->name}}
						
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
		
				
			</div>
		</div>
		@endif


		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Destinatario</h3>
			<div class="row">

				
		
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Nombre:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_name}}">
							<input type="text" value="{{$model->customer->name}}" id="delivery_name" name="delivery_name" class="form-control">
							<input type="hidden" value="{{$model->customer->id}}" id="customer_id" name="customer_id">
					</div>
					</div>
				</div>
				
				

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Teléfono:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_phone}}">
							{{$model->delivery_phone}}
							<input type="text" value="{{$model->customer->phone}}" id="delivery_phone" name="delivery_phone"  class="form-control">
							
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Email:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_email}}">
							<input type="text" value="{{$model->customer->email}}" id="delivery_email" name="delivery_email"  class="form-control">
							
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Dirección:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_address}}">
							<input type="text" value="{{$model->customer->address}}" id="delivery_address" name="delivery_address"  class="form-control">
							
						</div>
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
							
							<input type="date" class="form-control" id="delivery_date" name="delivery_date" placeholder="YYYY/MMM/DD" required="required" value="<?php echo date('Y-m-d');?>">

						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Estado:</label>
						<div readonly id="" name="" class="col-6" >
							
							<select name="status_id" id="status_id"  class="form-control">
								@foreach($statuses as $item)
								<option value="{{$item->id}}">{{$item->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Atendido por:</label>
						<div readonly id="" name="" class="col-6">
							<select name="user_id" id="user_id"  class="form-control">
								@foreach($users as $item)
								<option value="{{$item->id}}"  @if ($user == $item->id) selected="selected" @endif>{{$item->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Formulado por:</label>
						<div readonly id="" name="" class="col-6">
							<select name="referal_user_id" id="referal_user_id" class="form-control">
							<option value="">Seleccionar...</option>
								@foreach($referal as $item)
								<option value="{{$item->id}}">{{$item->name}}</option>
								@endforeach
								
								
							</select>
						</div>
					</div>
				</div>

				<!--
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Para:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_to}}">{{$model->delivery_to}}</div>
					</div>
				</div>

				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">De:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_from}}">{{$model->delivery_from}}</div>
					</div>
				</div>

				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Mensaje:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_message}}">{{$model->delivery_message}}</div>
					</div>
				</div>
!-->
				
				
				
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<textarea name="notes" id="notes" cols="100%" rows="4" class="form-control"></textarea>
		</div>

	</div>
	<div class="text-center"><input type="submit"  class="btn btn-primary btn-sm" value="Guardar"></div>
</form>
<br>
<br>
<!--
<h2>Productos en la orden</h2>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Producto</th><th class="text-center ">Cantidad</th><th class="text-center ">Valor</th>
			<th></th>
		</tr>
	
	</thead>
	<tbody>
			<form action="/order/products/store"  method="POST">

{{ csrf_field() }}
<input type="text">
			<tr>
				
				<td class="text-center "><input type="text" id="product" value="" size="80"></td>
				
				<td class="text-center "><input type="text" id="quantity" value="1" size="4"></td>
				<td class="text-center "><input type="text" id="price" value="0" size="7"></td>
				<td class="text-center "><input type="submit" value="+" class="btn btn-primary btn-sm" size="3"></td>
			</tr>
			</form>
			<tr>
				<td><a href="">Agregar producto +</a></td>
			</tr>
			
		<?php $total=0; ?>
		@if(isset($model->productList)) 
			@foreach($model->productList as $item)
			<tr>
				<td>@if(isset($item->product)){{$item->product->name}}@endif</td><td class="text-center ">{{$item->quantity}}</td><td class="text-center ">$ {{number_format($item->price,0)}}</td>
			</tr>
			<?php $total += $item->price; ?>
			@endforeach
		@endif
		

		<tr>
			<td colspan="2"></td><td class="text-right display-4">Total</td>
			<td class=" display-4 text-center ">$ {{number_format($model->getTotal(), 0)}}</td>
		</tr>
	</tbody>
</table>


<div class="nav_var">
	<a href="/orders/{{$model->id}}/edit"><span class="btn btn-primary btn-sm">Editar</span> </a>
</div>
<!--
<hr>
<h1>Crear Orden</h1>

<form class="form-group" action="" method="POST">

{{ csrf_field() }}

<div class="row">
		

		
		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Cliente</h3>
	 <div class="row">

				<div class="col-md-12 col-sm-12">
	      <div class="form-group">
        <label for="name">Nombre:</label>
        <input type="text" class="form-control" id="delivery_name" name="delivery_name" placeholder="Nombre..." value="{{$model->name}}">
      </div>
				</div>
				<div class="col-md-12 col-sm-12">
			 <div class="form-group">
						<label >Cédula:</label>
            <input type="text" class="form-control" id="delivery_document" name="delivery_document" placeholder="Cédula..." value="{{$model->document}}">
    </div>
				</div>
				
				<div class="col-md-12 col-sm-12">
			 <div class="form-group">
						<label >Teléfono:</label>
            <input type="text" class="form-control" id="delivery_phone" name="delivery_phone" placeholder="Teléfono..." value="{{$model->phone}}">
  	</div>
				</div>

				
			</div>
		</div>



		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Entrega</h3>
	 <div class="form-group">

				<div class="col-md-12 col-sm-12">
			 <div class="form-group">
						<label >Fecha:</label>
            <input type="text" class="form-control" id="delivery_date" name="delivery_date" placeholder="Fecha..." value="">
  		</div>
				</div>
		
				<div class="col-md-12 col-sm-12">
			 <div class="form-group">
						<label >Destinatario:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre..." value="{{$model->name}}">
  </div>
				</div>
				
				<div class="col-md-12 col-sm-12">
			 <div class="form-group">
						<label >Dirección:</label>
            <div type="text" class="form-control" id="delivery_address" name="delivery_address" placeholder="Dirección..." value="{{$model->address}}">
  	</div>
				</div>

				<div class="col-md-12 col-sm-12">
			 <div class="form-group">
						<label >Teléfono:</label>
            <input type="text" class="form-control" id="delivery_phone" name="delivery_phone" placeholder="Teléfono..." value="{{$model->phone}}">
  	</div>
				</div>

			</div>
		</div>
		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Tarjeta</h3>
	 <div class="form-group">
				<div class="col-md-12 col-sm-12">
			 <div class="form-group">
						<label >Para:</label>
						<div readonly id="" name=""  value=""></div>
					</div>
				</div>

				
				<div class="col-md-12 col-sm-12">
			 <div class="form-group">
						<label >De:</label>
						<div readonly id="" name=""  value=""></div>
					</div>
				</div>

				
				<div class="col-md-12 col-sm-12">
			 <div class="form-group">
						<label >Mensaje:</label>
						<div readonly id="" name=""  value=""></div>
					</div>
				</div>

				
				
				
			</div>
		</div>
	</div>

  <button type="submit" class="btn btn-primary">Enviar</button>
  </form>

!-->



<script>
  $( function() {
    var availableProductos = [
	@foreach($products as $item)
	'{{$item->name}}',
	@endforeach
    ];
    $( "#product" ).autocomplete({
      source: availableProductos
    });
  } );
  </script>


@endsection	