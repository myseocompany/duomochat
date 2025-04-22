@extends('layout')

@section('content')

<div><a href="/orders">Ordenes</a> >> ver</div>
<h1>Crear Orden </h1>



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
						<label class="col-6">Cedula:</label>
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
							
						<a href="/customers/{{$model->customer->id}}/show">{{$model->delivery_name}}</a>
							<input type="hidden" value="{{$model->customer->id}}" id="customer_id" name="customer_id">
					</div>
					</div>
				</div>
				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">---:</label>
						<div readonly id="" name="" class="col-6" value="">
						--
						</div>
					</div>
				</div>

				

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Teléfono:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_phone}}">
							{{$model->delivery_phone}}

						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Email:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_email}}">
							{{$model->delivery_email}}

						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Dirección:</label>
						<div readonly id="" name="" class="col-6" value="">
						{{$model->delivery_address}}
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
				
				<div class="col-12">
					<form action="/orders/{{$model->id}}/update" method="POST">	
						{{ csrf_field() }}	
					<div class="row">
						<label class="col-6">Estado:</label>
						<div class="col-6">
						
						
							
							<select name="status_id" id="status_id" onchange="this.form.submit()" class="form-control">
								@foreach($statuses as $item)
									<option value="{{$item->id}}" @if($model->status_id == $item->id) selected="selected" @endif >{{$item->name}}</option>
								@endforeach
							</select>
						</div>
						
						<input type="hidden" id="order_id" name="order_id" value="{{$model->id}}" ></td>
					</div>
				</form>
				</div>
			

<form action="/orders/{{$model->id}}/update" method="POST">
	{{ csrf_field() }}
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Medio de pago:</label>
						
						<div readonly id="" name="" class="col-6" value="{{$model->delivery_address}}" >
							<select name="payment_id" id="payment_id" onchange="this.form.submit()" class="form-control">
								
							
								@foreach($payments as $item)
								<option value="{{$item->id}}" @if($model->payment_id == $item->id) selected="selected" @endif>{{$item->name}}</option>
								@endforeach
							</select>
						</div>
						<input type="hidden" id="order_id" name="order_id" value="{{$model->id}}" ></td>
				
					</div>
				</div>	
</form>	
				<div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6"> Atendido por:	</label>
					<div readonly id="" name="" class="col-6">
						@if( isset($model->user) )
						{{$model->user->name}}
						@endif
					</div>
				
				</div>
			 </div>
			 <div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6"> Formulado por:	</label>
					<div readonly id="" name="" class="col-6">

						
						@if( isset($model->referal_user) || $model->referal_user !="")
						 	{{$model->referal_user->name}}
							 
						 @else
							Sin formular							 
						 @endif
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

<br>
<br>

@include('orders.add_file', ['order_id' => $model->id])
@include('orders.file-list', ['order_id' => $model->id])

<div class="row">
	<div class="col">
		
<table class="table table-striped">
	<thead>
		<tr>
			<th>Producto</th>
			<th class="text-center ">Cantidad</th>
			<th class="text-center ">Acción</th>
			<th class="text-center ">Asesor</th>
			
			
			<th class="text-center ">Valor</th>
			<th>Descuento</th>
			<th>Total</th>
			
			<th></th>
			
		</tr>
	
	</thead>
	<tbody>

		<form action="/orders/products/store"  method="POST">

			{{ csrf_field() }}
			
			<tr>
				
				<td class="text-center ">
					<input type="text" id="product" name="product" value="" size="40" required="required" class="form-control">

					<input type="hidden" id="order_id" name="order_id" value="{{$model->id}}" ></td>
				
			
				<td class="text-center ">
					<input class="form-control number" type="text" id="quantity" name="quantity" value="1" size="4" onkeyup="totalDiscount()" onchange="totalDiscount()">
				</td>
				<td class="text-center ">
					<select name="sale_type_id" id="sale_type_id" class="form-control">
						@foreach($sale_type_options as $item)
						<option value="{{$item->id}}">
							{{$item->name}}
						</option>
									
					@endforeach
					</select>

				</td>
				<td class="text-center ">
					<select name="user_id" id="user_id" class="form-control">
						@foreach($users as $item)
						<option value="{{$item->id}}" @if($model->user_id == $item->id) selected="selected" @endif>
							{{$item->name}}
						</option>
									
					@endforeach
					</select>

				</td>
				<td class="text-center "><input class="form-control number" type="number" id="price" name="price" value="" size="7" onkeyup="totalDiscount()" onchange="totalDiscount()"> </td>
				<td class="text-center "><input class="form-control number" type="number" id="dscto" name="dscto" value="0" placeholder="0" style="width: 60%; margin-right: 10px;" onkeyup="totalDiscount()" onchange="totalDiscount()"></td>
				<td class="text-center "><input class="form-control number" type="text" id="totalProduct" name="totalProduct" value="0" style="width:100px;" readonly  ></td>
				<td><input type="submit" value="+" class="btn btn-primary btn-sm" size="3"></td>
			</tr>
			
		</form>			
			
		<?php $total=0; ?>
		@if(isset($model->productList)) 
			@foreach($model->productList as $item)
			
			<tr>
				<td>@if(isset($item->product)){{$item->product->name}}@endif</td>
				<td class="text-center ">{{$item->quantity}}</td>
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
					@if($item->saleType){{$item->saleType->name}}@endif
				</td>
				
				<td class="text-center "> $ {{number_format($item->price,0)}}
				</td>
				<td class="text-center ">{{$item->discount}}%
				</td>
				<td class="text-center ">$ {{number_format($item->total,0)}} </td>
				<td>  
				<input type="submit" value="-" data-toggle="modal" data-target="#destroy_{{$item->id}}" class="btn btn-primary btn-sm" size="3">
					
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
							<input type="" value="Sí" data-toggle="modal" data-target="#destroy_{{$item->id}}" class="btn btn-primary" size="3"></a>
						 </div>

						</div>
						</div>
						</div>
					</td>
					<td></td>
			</tr>
		
			<?php $total += $item->total; ?>
			@endforeach
		@endif
		

		<tr>
			<td colspan="1"></td>
			<td class="text-right display-4">Total</td>
			<td colspan="5" class=" display-4 text-right ">$ {{number_format($model->getTotal(), 0)}}</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="6">
				{{$model->notes}}
			</td>
		</tr>
	</tbody>
</table>

<div class="row">

<div class="col-md-12 col-sm-12" style="text-align: -webkit-right;">
		<a href="/orders/{{$model->id}}/show">
			<input type="button" class="btn btn-primary" value="Guardar" >
			
		</input>
		</a>
	</div>

</div>
	</div>
</div>




<script>
	var availableProducts=[];
	var productPrices =[];
	
  $( function() {
     availableProducts = [
	@foreach($products as $item) '{{$item->name}}', @endforeach
    ];

	productPrices = [
	@foreach($products as $item) '{{$item->price}}', @endforeach
    ];

	

    $( "#product" ).autocomplete({
      source:  availableProducts
    });


  } );



  
  </script>

<script>


$("#product").on("change", function(){
	var productPrice = -1;

	var product_val = $("#product").val();
	console.log(product_val);


	index = availableProducts.indexOf(product_val);
	console.log(index);

	$("#price").val(productPrices[index])
});

</script>

@endsection	