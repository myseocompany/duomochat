@extends('empty')@section('content')
<style type="text/css">
	thead tr td:nth-child(odd){
		/*background-color: #ccc;
		*/
		font-weight: bolder;
		text-transform: uppercase;
		text-align: right;
	}
	thead tr td:nth-child(even){
		background-color: #eee;
		
	}
	tbody tr td{
		background-color: #eee;
		text-align: center;
	}

	tbody tr td:nth-child(1){
		font-weight: bolder;
		text-transform: uppercase;
		background-color: #fff;
		text-align: right;
		
	}
</style>
<table class="" border="1" id="content">
	<thead>
	<tr>
		<td colspan="4" >
			<img src="https://trujillogutierrez.com.co/site/images/logo_trujillo_gutierrez_gris_rojo.png" alt="" class="d-inline" width="200">
		</td>
	</tr>
	<td class="text-center subtitle" colspan="4"><h2>PRODUCTOS</h2></td>
	<tr>
		<td>PROYECTO</td>
		
		<td>{{ $model->product->getProjectName() }}</td>
		
		<td>FECHA</td>
		<td>{{ $model->getQuoteDate() }}</td>
		
	</tr>
	<tr>
		<td>COTIZACIÓN No</td>
		<td>{{ $model->id }}</td>
		<td>VIGENCIA</td>
		<td>{{ $model->getValidityDate() }}</td>
	</tr>
	@if(isset($model->customer))
	<tr>
		<td>NOMBRE CLIENTE</td>
		<td>{{ $model->customer->name }}</td>
		<td>CELULAR CLIENTE</td>
		<td>{{ $model->customer->phone }}</td>
	</tr>
	<tr>
		<td>EMAIL CLIENTE</td>
		<td>{{ $model->customer->email }}</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	@endif
	<!-- DATOS DEL APARTAMENTO -->
	<tr>
		@if($model->product->type_id === 1)
			<td>Apto No</td>
		@else
			<td>{{$model->product->type->name}}</td>
		@endif	
		{{-- {{dd($model->product)}} --}}
		<td>{{$model->product->name}}</td>
		<td>UBICACIÓN</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>ÁREA CONSTRUIDA</td>
		<td>{{ $model->product->built_area }}</td>
		<td>ÁREA PRIVADA</td>
		<td>{{ $model->product->private_area }}</td>
	</tr>
	<tr>
		<td>TIPO</td>
		<td>{{ $model->product->getApartmentTypeName() }}</td>
		<td>DESCRIPCION</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>FECHA ENTREGA ESTIMADA <br>(Sujeta a cumplimiento punto <br>de equilibrio de ventas)</td>
		<td>{{ \Carbon\Carbon::parse($model->product->category->delivery_date)->format('F Y') }}</td>
		<td>MESES A DIFERIR CUOTA inicial</td>
		<td>&nbsp;</td>
	</tr>
	</thead>
	<tbody>
	<td class="text-center subtitle" colspan="4"><h2>CIERRE FINANCIERO</h2></td>
	
	<tr>
		<td>&nbsp;</td>
		<td>Obra Negra</td>
		<td>Semiterminado</td>
		<td>Full Acabado</td>
	</tr>
	<tr>
		<td>Apartamento</td>
		<td>$ {{number_format($model->product->price,0)}}</td>
		<td>$ {{number_format($model->product->final_price_combo1,0)}}</td>
		<td>$ {{number_format($model->product->final_price_full_finishes,0)}}</td>
	</tr>

	<tr>
		<td>Parqueadero</td>
		<td>$ @if(isset($model->parking)){{number_format($model->parking->price,0)}} @else 0 @endif</td>
		<td>$ @if(isset($model->parking)){{number_format($model->parking->price,0)}} @else 0 @endif</td>
		<td>$ @if(isset($model->parking)){{number_format($model->parking->price,0)}} @else 0 @endif</td>
	</tr>
	<tr>
		<td>Deposito</td>
		<td>$ @if(isset($model->deposit)){{number_format($model->deposit->price,0)}} @else 0 @endif</td>
		<td>$ @if(isset($model->deposit)){{number_format($model->deposit->price,0)}} @else 0 @endif</td>
		<td>$ @if(isset($model->deposit)){{number_format($model->deposit->price,0)}} @else 0 @endif</td>
	</tr>
	<tr>
		<td>TOTAL</td>
		<td>$ {{number_format($model->getSubtotal(),0)}} </td>
		<td>$ {{number_format($model->getSubtotal(),0)}} </td>
		<td>$ {{number_format($model->getSubtotal(),0)}} </td>
	</tr>

	
	<tr>
		<td class="text-center subtitle" colspan="4"><h2>CUOTA INICIAL</h2></td>
	</tr>
	<tr>
		<td>Cuota inicial 30%</td>
		<td>$ {{number_format($model->getSubtotal()*0.3,0)}} </td>
		<td>$ {{number_format($model->getSubtotal()*0.3,0)}} </td>
		<td>$ {{number_format($model->getSubtotal()*0.3,0)}} </td>
	</tr>
	<tr>
		<td>Separación</td>
		<td>$ {{number_format($model->initial_installment,0)}} </td>
		<td>$ {{number_format($model->initial_installment,0)}} </td>
		<td>$ {{number_format($model->initial_installment,0)}} </td>
	</tr>


	<tr>
		<td>Cesantías o primas</td>
		<td>$ {{number_format($model->savings_value,0)}} </td>
		<td>$ {{number_format($model->savings_value,0)}} </td>
		<td>$ {{number_format($model->savings_value,0)}} </td>
	</tr>
	<!--
	<tr>
		<td>Subsidios</td>
		<td>$ {{number_format($model->subsidy_installment,0)}} </td>
		<td>$ {{number_format($model->subsidy_installment,0)}} </td>
		<td>$ {{number_format($model->subsidy_installment,0)}} </td>
	</tr>
-->
	<tr>
		<td>Valor de la cuota mensual</td>
		<td>$ {{number_format($model->initial_installment()/17,0)}} </td>
		<td>$ {{number_format($model->initial_installment()/17,0)}} </td>
		<td>$ {{number_format($model->initial_installment()/17,0)}} </td>
	</tr>

	<tr>
		<td class="text-center subtitle" colspan="4"><h2>SIMULACIÓN DE CRÉDITO</h2></td>
	</tr>
	<tr>
		<td>Crédito hipotecario 70%</td>
		<td>$ {{number_format($model->getSubtotal()*0.7,0)}} </td>
		<td>$ {{number_format($model->getSubtotal()*0.7,0)}} </td>
		<td>$ {{number_format($model->getSubtotal()*0.7,0)}} </td>
	</tr>


	<tr>
		<td>Cuota mensual 30 años UVR aprox</td>
		<td>$ {{number_format($model->getSubtotal()*7360/1000000,0)}} </td>
		<td>$ {{number_format($model->getSubtotal()*7360/1000000,0)}} </td>
		<td>$ {{number_format($model->getSubtotal()*7360/1000000,0)}} </td>
	</tr>
	<tr>
		<td>Subsidio NO VIS (primero 7 años)</td>
		<td>$ {{number_format(438000,0)}} </td>
		<td>$ {{number_format(438000,0)}} </td>
		<td>$ {{number_format(438000,0)}} </td>
	</tr>
	<tr>
		<td>Cuota mensual aprox (sin seguro de vida)</td>
		<td>$ {{number_format(($model->getSubtotal()*7360/1000000)-438000,0)}} </td>
		<td>$ {{number_format(($model->getSubtotal()*7360/1000000)-438000,0)}} </td>
		<td>$ {{number_format(($model->getSubtotal()*7360/1000000)-438000,0)}} </td>
	</tr>
	<tr>
		<td>Ingresos necesarios aprox (varían según banco)</td>
		<td>$ {{number_format((($model->getSubtotal()*7360/1000000)-438000)/0.3,0)}} </td>
		<td>$ {{number_format((($model->getSubtotal()*7360/1000000)-438000)/0.3,0)}} </td>
		<td>$ {{number_format((($model->getSubtotal()*7360/1000000)-438000)/0.3,0)}} </td>
	</tr>
	
	<tr>
		<td colspan="4">
		Los precios están sujetos a cambios y revisión por parte de la constructora, en todo caso se respetarán los precios para las ventas que se hayan separado con consignación.				
		</td>
	</tr>
	

	<td class="text-center subtitle" colspan="4"><h2>CONTACTO ASESORA COMERCIAL</h2></td>

	<tr><td>Nombre:	</td><td colspan="3">NATALIA A. MEJIA SOTO				</td></tr>
	<tr><td>Celular:</td><td colspan="3">314 7084514  /  3113409251				</td></tr>
	<tr><td>Email:</td><td colspan="3">saladeventas@trujillogutierrez.com.co / ventas@trujillogutierrez.com.co</td></tr>
	<tr><td colspan="4">www.trujillogutierrez.com.co</td></tr>
	<tr><td colspan="4">SIGUENOS EN </td></tr>
	<tr><td colspan="4">facebook.com/trujillogutierrezasociados						</td></tr>
	<tr><td colspan="4">instagram.com/trujillogutierrezsas/						</td></tr>
	
	</tbody>
</table>



@endsection