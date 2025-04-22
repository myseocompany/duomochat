@extends('layout')

@section('content')
<div><a href="/orders">Ordenes</a> >> ver</div>
<h1>Orden {{$model->id}}</h1>

<div><a href="/orders/{{$model->id}}/quote">Cotización</a></div>

<h2>Productos en la orden</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Producto</th><th>Nombre</th><th>Valor</th>
		</tr>
	
	</thead>
	<tbody>
		@if(isset($model->product)) <?php $item = $model->product; ?>
		<tr>
			<td>@if(isset($item->type)){{$item->type->name}}@endif</td><td>{{$item->name}}</td><td>$ {{number_format($item->price,0)}}</td>
		</tr>
		@endif
		@if(isset($model->parking)) <?php $item = $model->parking; ?>
		<tr>
			<td>@if(isset($item->type)){{$item->type->name}}@endif</td><td>{{$item->name}}</td><td>$ {{number_format($item->price,0)}}</td>
		</tr>
		@endif
		@if(isset($model->deposit)) <?php $item = $model->deposit; ?>
		<tr>
			<td>@if(isset($item->type)){{$item->type->name}}@endif</td><td>{{$item->name}}</td><td>$ {{number_format($item->price,0)}}</td>
		</tr>
		@endif

		@if($model->finishes_value>0) 
		<tr>
			<td>Acabados</td><td></td><td>$ {{number_format($model->finishes_value,0)}}</td>
		</tr>
		@endif
		@if(isset($model->product)&&($model->product->height_over_price>0)) <?php $item = $model->product; ?>
		<tr>
			<td>Prima de altura</td><td>{{$item->name}}</td><td>$ {{number_format($item->height_over_price,0)}}</td>
		</tr>
		@endif
		<!--
		<form action="/orderProducts/" method="POST">
			{{ csrf_field() }}
			<tr>
			<td>
				<select id="product_type_id" onchange="updateOrderProducts();" class="form-control">
					<option>Seleccione un tipo de producto</option>
					@foreach($product_types as $item)
					<option id="{{$item->id}}">{{$item->name}}</option>
					@endforeach
				</select>

			</td>
			<td><input type="" name="" id="" class="form-control"></td>
			<td><input type="" name="" id="" class="form-control"></td>
			
		</tr>
		</form>
	-->
		<tr>
			<td></td><td class="text-right"><strong>Subtotal</strong></td><td>$ {{number_format($model->getSubtotal(""), 0)}}</td>
		</tr>
		<tr>
			<td></td><td class="text-right"><strong>Descuento / Intereses</strong></td><td>$ {{number_format($model->discount_interest, 0)}}</td>
		</tr>
		<tr>
			<td></td><td class="text-right display-4">Total</td><td class=" display-4">$ {{number_format($model->getTotal(), 0)}}</td>
		</tr>
	</tbody>
</table>
<br>
<br>

<div class="row">
	<div class="col-md-6 col-sm-12 group-container">
		<h3 class="title">Cierre financiero</h3>
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6">[+]Valor total:</label>
					<div readonly id="" name="" class="col-6" value="{{$model->subsidy}}">$ {{number_format($model->getTotal(), 0)}}</div>
				</div>
			</div>
			
			<div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6">[-]Cuota inicial:</label>
					<div readonly id="" name="" class="col-6" value="{{$model->subsidy}}">$ {{number_format($model->initial_installment, 0)}}</div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6">[-]Crédito:</label>
					<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ {{number_format($model->credit_value, 0)}}</div>
				</div>
			</div>
			
			<div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6">Saldo:</label>
					<div readonly id="" name="" class="col-6" value="{{$model->credit_date}}">$ {{number_format($model->getTotal()-$model->getDebits()-$model->credit_value,0)}}</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-12 group-container">
		<h3 class="title">Cuota inicial</h3>
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6">[+]Cuota inicial:</label>
					<div readonly id="" name="" class="col-6" value="{{$model->subsidy}}">$ {{number_format($model->initial_installment, 0)}}</div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6">[-]Cesantias:</label>
					<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ {{number_format($model->getDebitsSavings(), 0)}}</div>
				</div>
			</div>
			
			<div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6">[-]Recursos propios:</label>
					<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ {{number_format($model->getDebits(),0)}}</div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6">[-]Ahorro programado:</label>
					<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ </div>
				</div>
			</div>

			
			<div class="col-md-12 col-sm-12">
				<div class="row">
					<label class="col-6">[-]Subsidio:</label>
					<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ {{number_format($model->getDebitsSubsidy(), 0)}}</div>
				</div>
			</div>				
		</div>
	</div>
</div>

<form class="form-group">
	<div class="row">
		<div class="col-md-6 col-sm-12 group-container">
			<h3 class="title">Subsidio</h3>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Subsidio:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->subsidy}}">{{$model->subsidy}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Estado:</label>
						<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">{{$model->subsidy_status}}</div>
					</div>
				</div>
				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Fecha:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->subsidy_date}}">{{$model->subsidy_date}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Valor:</label>
						<div readonly id="" name="" class="col-6" value="{{number_format($model->subsidy_value, 0)}}">$ {{number_format($model->subsidy_value, 0)}}</div>
					</div>
				</div>
			</div>
		</div>	

		<div class="col-md-6 col-sm-12 group-container">
			<h3 class="title">Crédito</h3>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Credito:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->credit}}">{{$model->credit}}</div>
					</div>
				</div>

				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Estado:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->credit_status}}">{{$model->credit_status}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Valor:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->credit_value}}">$ {{number_format($model->credit_value, 0)}}</div>
					</div>
				</div>
			</div>
		</div>

		@if(isset($model->customer))
		<div class="col-md-6 col-sm-12 group-container">
			<h3 class="title">Titular</h3>
			<div class="row">

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Nombre:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->customer->name}}">{{$model->customer->name}}</div>
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
						<label class="col-6">Telefono:</label>
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
						<label class="col-6">Direccion:</label>
						<div readonly id="address" name="address" class="col-6" value="{{$model->customer->address}}">{{$model->customer->address}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Encargo fiduciario:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->fiduciary_commission}}">{{$model->fiduciary_commission}}</div>
					</div>
				</div>
			</div>
		</div>
		@endif

		<div class="col-md-6 col-sm-12 group-container">
			<h3 class="title">Otros</h3>
			<div class="row">

				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Escritura:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->real_state_note}}">{{$model->real_state_note}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Fecha de entrega:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->releases}}">{{$model->releases}}</div>
					</div>
				</div>
				{{-- <div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Encargo fiduciario:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->fiduciary_commission}}">{{$model->fiduciary_commission}}</div>
					</div>
				</div> --}}

			</div>
		</div>
	</div>
</form>
<div class="nav_var"><a href="/orders/{{$model->id}}/edit"><span class="btn btn-primary btn-sm">Editar</span> </a></div>
<br>
<br>

<div class="row">
	<div class="col-12"><h2>Plan de pagos</h2>
	</div>
	<div class="col-12">
		<form method="POST" action="/orders/transactions" id="transaction_insert">
			<div class="form-group row">
			{{ csrf_field() }}
			<input type="hidden" id="order_id" name="order_id" value="{{$model->id}}">
				<input type="date" id="date" name="date" placeholder="Fecha" class="form-control col-2">
				<input type="text" id="description" name="description" placeholder="Concepto" class="form-control col-2">
				<input type="text" id="internal_id" name="internal_id" placeholder="No" class="form-control col-1">
				@if(isset($request))
					<?php dd($request) ?>
				@endif
				<input type="number" name="value" id="value" placeholder="Valor" class="form-control col-2" @if(isset($request->value)) value="{{$request->value}}" @endif>
				<div class="col-4">
					<div class="form-check  form-check-inline">
						
						<label class="form-check-label"><input class="form-check-input" type="radio" name="is_debit" id="is_debit" value="1" checked="checked">Debito</label>
						
					</div>
					<div class="form-check  form-check-inline">
						
						<label class="form-check-label"><input class="form-check-input" type="radio" name="is_debit" id="is_debit" value="0">Credito</label>
						
					</div>
				</div>
				<div class="col-1">
					<button type="submit" class="btn btn-primary btn-sm" >Agregar</button>
				</div>
			</div>
		</form>
	</div>
	
	<div class="col-md-6 col-sm-12">
		<h3>Debitos</h3>
		<table class="table table-sm">
			<thead>
				<tr class="thead-light"><th>Fecha</th><th>Concepto</th><th>Valor</th><th></th></tr>
			</thead>
			<tbody>
		@foreach($debits as $item)
			<tr>
				<td>{{$item->date}}</td>
				<td>{{$item->description}}</td>
				{{-- <td>{{$item->internal_id}}</td> --}}
				<td>$ {{number_format($item->debit,0)}}</td>
				<td><a type="button" class="btn btn-danger" href="/orders/transactions/{{$item->id}}/destroy">X</a></td>
				<td><a type="button" class="btn btn-primary" href="/orders/transactions/{{$item->id}}/edit">Editar</a></td>
			</tr>		

				
			
		@endforeach
		</tbody>
		</table>
	</div>
	<div class="col-md-6 col-sm-12">
	<h3>Pagos</h3>

		<table class="table table-sm">
			<thead>
				<tr><th>Fecha</th><th>Concepto</th><th>No</th><th>Valor</th></tr>
			</thead>
			<tbody>
		@foreach($credits as $item)
			<tr>
				<td>{{$item->date}}</td>
				<td>{{$item->description}}</td>
				
				<td>{{$item->internal_id}}</td>
				<td>$ {{number_format($item->credit,0)}}</td>
				<td><a type="button" class="btn btn-danger" href="/orders/transactions/{{$item->id}}/destroy">X</a></td>
				<td><a type="button" class="btn btn-primary" href="/orders/transactions/{{$item->id}}/edit">Editar</a></td>

			</tr>		
		@endforeach
			</tbody>
		</table>
	</div>

</div>

<div class="row">
	<div class="col-md-12 col-sm-12">
		<h2>Plan de pagos</h2>
		<table class="table table-sm">
			<thead>
				<tr><th>Fecha</th><th>Concepto</th><th>No</th><th>Debitos</th><th>Créditos</th><th>Saldo</th></tr>
			</thead>
			<tbody>
				<?php $total=0; ?>
		@foreach($transactions as $item)
			<?php $total += $item->credit-$item->debit; ?>
			<tr class="@if($total>=0) table-success @else table-danger @endif">
				
				<td>{{$item->date}}</td>
				<td>{{$item->description}}</td>
				<td>{{$item->internal_id}}</td>
				<td>$ {{number_format($item->debit,0)}}</td>
				<td>$ {{number_format($item->credit,0)}}</td>
				<td>$ {{number_format($total,0)}}</td>

			</tr>		
		@endforeach
		</tbody>
		</table>
	</div>

</div>

<br>
<div class="row">
	<div class="row justify-content-center">
		{{-- <div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Cierre financiero</h3>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">[+]Valor total:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->subsidy}}">$ {{number_format($model->getTotal(), 0)}}</div>
					</div>
				</div>
				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">[-]Cuota inicial:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->subsidy}}">$ {{number_format($model->initial_installment, 0)}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">[-]Crédito:</label>
						<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ {{number_format($model->credit_value, 0)}}</div>
					</div>
				</div>
				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Saldo:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->credit_date}}">$ {{number_format($model->getTotal()-$model->getDebits()-$model->credit_value,0)}}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-12 group-container">
			<h3 class="title">Cuota inicial</h3>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">[+]Cuota inicial:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->subsidy}}">$ {{number_format($model->initial_installment, 0)}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">[-]Cesantias:</label>
						<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ {{number_format($model->getDebitsSavings(), 0)}}</div>
					</div>
				</div>
				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">[-]Recursos propios:</label>
						<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ {{number_format($model->getDebits(),0)}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">[-]Ahorro programado:</label>
						<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ </div>
					</div>
				</div>

				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">[-]Subsidio:</label>
						<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ {{number_format($model->getDebitsSubsidy(), 0)}}</div>
					</div>
				</div>				
			</div>
		</div> --}}
		<div class="col-md-6 col-sm-12 group-container">
			<h3 class="title">Mora</h3>
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Debitos Programados:</label>
						<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ {{number_format($model->getDebits(), 0)}}</div>
					</div>
				</div>
				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Debitos a la fecha:</label>
						<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ {{number_format($model->getDebitsUntilNow(), 0)}}</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Creditos a la fecha:</label>
						<div readonly id="category_id" name="category_id" class="col-6" value="{{$model->subsidy_status}}">$ {{number_format($model->getCreditsUntilNow(), 0)}}</div>
					</div>
				</div>
				
				<div class="col-md-12 col-sm-12">
					<div class="row">
						<label class="col-6">Saldo:</label>
						<div readonly id="" name="" class="col-6" value="{{$model->credit_date}}">$ {{number_format($model->getDebitsUntilNow() - $model->getCreditsUntilNow(),0)}}</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>




<div class="nav_var"><a href="/products/{{$model->id}}/edit"><span class="btn btn-primary btn-sm">Editar</span> </a></div>
@endsection