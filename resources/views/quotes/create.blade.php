@extends('layout')
@section('content')
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
<form class="form-group" action="{{ route('orders.store') }}" method="POST" id="quote_form">
{{ csrf_field() }}
<input type="hidden" name="status_id" id="status_id" value="1">
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
		
		<td><select id="category_id" name="category_id" class="form-control" onchange="updateOptions();">
                  <script type="text/javascript">
                    var categories = new Array();
                  </script>
                  <option>Seleccione...</option>
<script type="text/javascript">

class Category {
  constructor( name, delivery_date) {
  	this.name = name;
    this.delivery_date = delivery_date;
  }
}

@foreach($categories as $item)
	categories[{{$item->id}}] = new Category("{{$item->name}}", "{{$item->delivery_date}}".substring(0, 10));
@endforeach


</script>
                  @foreach($categories as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                  @endforeach
                </select></td>
		
		<td>FECHA</td>
		<td id="created_at">
			
			<?php 
			$mytime = Carbon\Carbon::now();
			echo $mytime->format('Y-m-d'); 
			?>
			<script type="text/javascript">
				today = new Date({{$mytime->format('Y')}}, {{intval($mytime->format('m'))-1}}, {{$mytime->format('d')}});

			</script>
			

		</td>
		
	</tr>
	<tr>
		<td>COTIZACIÓN No</td>
		<td>{{App\Order::nextID()}}</td>
		<td>VIGENCIA</td>
		<td id="valid_to"></td>
	</tr>
	<tr>
		<td>NOMBRE CLIENTE</td>
		<td>
			<input id="customers" name="customers" class="form-control">
              
              <input type="hidden" name="customer_id" id="customer_id" value="" onchange="updateCustomer()">
         </td>
		<td>CELULAR CLIENTE</td>
		<td id="customer_phone"></td>
	</tr>
	<tr>
		<td >EMAIL CLIENTE</td>
		<td id="customer_email"></td>
		<td>% DE CUOTA INICIAL</td>
		<td><input id="initial_installment_percent" name="initial_installment_percent" class="form-control" value="30"></td>
	</tr>
	
	<!-- DATOS DEL APARTAMENTO -->
	<tr>
		<td>Apartamento</td>
		<td><select id="product_id" name="product_id" class="form-control" onchange="showPrice();">
                  <script type="text/javascript">
                    var products = [];
                  </script>

	              <option>Seleccione un apartamento</option>
 <script type="text/javascript">

 


class Product {
  constructor( price_black_work, price_semi_finished, price_fully_finished, built_area, private_area, type, location, notes) {
  	this.price_black_work = price_black_work;
    this.price_semi_finished = price_semi_finished;
   	this.price_fully_finished = price_fully_finished;
   	this.built_area = built_area;
   	this.private_area = private_area;
   	this.type = type;
   	this.location = location;
   	this.notes = notes;
     
  }
}

products = new Array();


@foreach($products as $item)
	
	@if($item->price_black_work !="") price_black_work = {{$item->price_black_work}}; @else price_black_work = 0; @endif

	
	@if($item->price_semi_finished !="") price_semi_finished = {{$item->price_semi_finished}}; @else price_semi_finished = 0; @endif

	
	@if($item->price_fully_finished !="") price_fully_finished = {{$item->price_fully_finished}}; @else price_fully_finished = 0; @endif

	@if(isset($item->type)) type = "{{$item->type->image_url}}"; @else type = ""; @endif

	



	products[{{$item->id}}] = new Product(price_black_work, price_semi_finished, price_fully_finished, {{$item->built_area}}, {{$item->private_area}}, type, "{{$item->location}}", "{{$item->notes}}");
@endforeach
                  </script>
	                @foreach($products as $item)
	                	<option value="{{$item->id}}" category_id="{{$item->category_id}} @if(isset($item->category)){{$item->category->getCategoryChildren()}} @endif" class="units">{{$item->name}}</option>
                  @endforeach
	              </select></td>


	    
		<td>UBICACIÓN</td>
		<td><input type="text" name="" id="location" class="form-control" readonly></td>
	</tr>
	
	<tr>
		<td>ÁREA CONSTRUIDA</td>
		<td><input type="text" name="" id="built_area" class="form-control" readonly></td>
		<td>ÁREA PRIVADA</td>
		<td><input type="text" name="" id="private_area" class="form-control" readonly></td>
	</tr>
	<tr>
		<td>TIPO</td>
		<td><input type="text" name="" id="" class="form-control" readonly></td>
		<td>DESCRIPCION</td>
		<td><input type="text" name="notes" id="notes" class="form-control" readonly></td>
	</tr>
	<tr>
		<td>FECHA FINALIZACIÓN <br> OBRA ESTIMADA *</td>
		<td><input type="text" name="" id="delivery_date" class="form-control" readonly></td>
		<td>MESES A DIFERIR <br>CUOTA inicial</td>
		
		<td id="defer_months">
		
		</td>
	</tr>
	<tr><td colspan="4"> * Sujeta a cumplimiento punto de equilibrio de ventas</td></tr>
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
		<td>
			<label class="">Apartamento:</label>
			</td>
		<td><input type="hidden" name="price_black_work" id="price_black_work_text" class="form-control" readonly>
			<input type="text" name="" id="price_black_work" class="form-control" readonly></td>
		<td><input type="hidden" name="price_semi_finished" id="price_semi_finished_text" class="form-control" readonly>
			<input type="text" name="" id="price_semi_finished" class="form-control" readonly>
		</td>
		<td><input type="hidden" name="price_fully_finished" id="price_fully_finished_text" class="form-control" readonly>
			<input type="text" name="" id="price_fully_finished" class="form-control" readonly></td>
	</tr>

	<tr>
		<td><label>Parqueadero:</label>
			<select id="parking_id" name="parking_id" class="form-control" onchange="showParkingPrice();">
              		<script type="text/javascript">
              			var parkings = [];
              		</script>
	                <option>Seleccione un parqueadero</option>
	                <script type="text/javascript">
	                	@foreach($parkings as $item)
	                		parkings[{{$item->id}}] = {{$item->price}};
	                	@endforeach
	                </script>
	                @foreach($parkings as $item)
	                <option value="{{$item->id}}" category_id="{{$item->category_id}} @if(isset($item->category)){{$item->category->getCategoryChildren()}} @endif" class="units">@if(isset($item->type)){{$item->type->name}} @endif - {{$item->name}} </option>
	                @endforeach
	              	</select></td>
		<td><input type="hidden" name="parking_price" id="parking_price"class="form-control" readonly>
			<input type="text" name="" class="parking_price form-control" readonly></td>
		<td><input type="text" id="parking_price_semi_finished" class="parking_price form-control" readonly></td>
		<td><input type="text" id="parking_price_fully_finished" class="parking_price form-control" readonly></td>
	</tr>
	<tr>
		<td><label>Depósito:</label>
			<select id="deposit_id" name="deposit_id" class="form-control" onchange="showDepositPrice();">
	              	<script type="text/javascript">
	              		var deposits = [];
	              	</script>
	                <option>Seleccion un depósito</option>
	                <script type="text/javascript">
	                	@foreach($deposits as $item)
	                		deposits[{{$item->id}}] = {{$item->price}};
	                	@endforeach
	                </script>
	                @foreach($deposits as $item)
	                <option value="{{$item->id}}" category_id="{{$item->category_id}} @if(isset($item->category)) {{$item->category->getCategoryChildren()}} @endif" class="units">@if(isset($item->type)) {{$item->type->name}} @endif - {{$item->name}}</option>
	                @endforeach
	              </select></td>
		<td><input type="hidden" name="deposit_price" id="deposit_price" class=" form-control" readonly>
			<input type="text" name="" class="deposit_price form-control" readonly></td>
		<td><input type="text" id="deposit_price_semi_finished" class="deposit_price form-control" readonly></td>
		<td><input type="text" id="deposit_price_fully_finished" class="deposit_price form-control" readonly></td>
	</tr>
	<tr>
		<td>TOTAL</td>
		<td><input type="text" name="" id="total_black_work" class="form-control" readonly></td>
		<td><input type="text" name="" id="total_semi_finished" class="form-control" readonly></td>
		<td><input type="text" name="" id="total_fully_finished" class="form-control" readonly></td>
	</tr>

	
	<tr>
		<td class="text-center subtitle" colspan="4"><h2>CUOTA INICIAL</h2></td>
	</tr>
	<tr>
		<td>Cuota inicial <span id="initial_installment_percent_text">30</span>%</td>
		<td><input type="text" name="" id="initial_installment_black_work" class="form-control initial_installment" readonly></td>
		<td><input type="text" name="" id="initial_installment_semi_finished" class="form-control initial_installment" readonly></td>
		<td><input type="text" name="" id="initial_installment_fully_finished" class="form-control initial_installment" readonly></td>

	</tr>
	<tr>
		<td>Separación</td>
		<td><input type="text" name="down_payment" id="down_payment_black_work" class="form-control down_payment" onchange="updateInitialInstallments()" value="0"></td>
		<td><input type="text" name="" id="down_payment_semi_finished" class="form-control down_payment" readonly></td>
		<td><input type="text" name="" id="down_payment_fully_finished" class="form-control down_payment" readonly></td>

	</tr>


	<tr>
		<td>Cesantías o primas</td>
		<td><input type="text" name="savings" id="savings_black_work" class="form-control savings" onchange="updateInitialInstallments()" value="0"></td>
		<td><input type="text" name="" id="savings_semi_finished" class="form-control savings" readonly></td>
		<td><input type="text" name="" id="savings_fully_finished" class="form-control savings" readonly></td>
	</tr>

	<tr>
		<td>Subsidios</td>
		<td><input type="text" name="initial_installment_subsidy" id="initial_installment_subsidy_black_work" class="form-control initial_installment_subsidy" onchange="updateInitialInstallments()" value="0"></td>
		<td><input type="text" name="" id="initial_installment_subsidy_semi_finished" class="form-control initial_installment_subsidy" readonly></td>
		<td><input type="text" name="" id="initial_installment_subsidy_fully_finished" class="form-control initial_installment" readonly></td>
	</tr>

	<tr>
		<td>Subtotal</td>
		<td><input type="text" name="" id="subtotal_initial_installment_black_work" class="form-control subtotal_initial_installment" readonly="" value="0"></td>
		<td><input type="text" name="" id="subtotal_initial_installment_semi_finished" class="form-control subtotal_initial_installment" readonly></td>
		<td><input type="text" name="" id="subtotal_initial_installment_fully_finished" class="form-control subtotal_initial_installment" readonly></td>
	</tr>

	<tr>
		<td>Valor de la <br>cuota mensual</td>
		<td><input type="text" name="" id="monthly_initial_installment_black_work" class="form-control monthly_initial_installment" readonly="" value="0"></td>
		<td><input type="text" name="" id="monthly_initial_installment_semi_finished" class="form-control monthly_initial_installment" readonly></td>
		<td><input type="text" name="" id="monthly_initial_installment_fully_finished" class="form-control monthly_initial_installment" readonly></td>
	</tr>

	<tr>
		<td class="text-center subtitle" colspan="4"><h2>SIMULACIÓN DE CRÉDITO</h2></td>
	</tr>
	<tr>
		<td colspan="4">
		Los precios están sujetos a cambios sin previo aviso y revisión por parte de la constructora, en todo caso se respetarán los precios para las ventas que se hayan separado con consignación.				
		</td>
	</tr>
	<tr>
		<td>Crédito hipotecario <span  id="balance_percent_text">70</span>%</td>
		<td><input type="text" name="" id="balance_black_work" class="form-control balance" readonly=""></td>
		<td><input type="text" name="" id="balance_semi_finished" class="form-control balance" readonly></td>
		<td><input type="text" name="" id="balance_fully_finished" class="form-control balance" readonly></td>
	</tr>


	<tr>
		<td>Cuota mensual <br>30 años UVR aprox</td>
		<td><input type="text" name="" id="balance_installment_black_work" class="form-control balance_installment" readonly=""></td>
		<td><input type="text" name="" id="balance_installment_semi_finished" class="form-control balance_installment" readonly></td>
		<td><input type="text" name="" id="balance_installment_fully_finished" class="form-control balance_installment" readonly></td>
	</tr>
	<tr>
		<td>Subsidio NO VIS <br> (primero 7 años)</td>
		<td><input type="text" name="balance_subsidy" id="balance_subsidy_black_work" class="form-control balance_subsidy" value="0"></td>
		<td><input type="text" name="" id="balance_subsidy_semi_finished" class="form-control balance_subsidy" readonly></td>
		<td><input type="text" name="" id="balance_subsidy_fully_finished" class="form-control balance_subsidy" readonly></td>
	</tr>

	<tr>
		<td>Cuota mensual aprox <br> (sin seguro de vida)</td>
		<td><input type="text" name="" id="monthly_installment_black_work" class="form-control monthly_installment" readonly=""></td>
		<td><input type="text" name="" id="monthly_installment_semi_finished" class="form-control monthly_installment" readonly></td>
		<td><input type="text" name="" id="monthly_installment_fully_finished" class="form-control monthly_installment" readonly></td>
	</tr>
	<tr>
		<td>Ingresos necesarios aprox <br> (varían según banco)</td>
		<td><input type="text" name="" id="income_black_work" class="form-control income" readonly=""></td>
		<td><input type="text" name="" id="income_semi_finished" class="form-control income" readonly></td>
		<td><input type="text" name="" id="income_fully_finished" class="form-control income" readonly></td>
	</tr>
	
	<tr>
		<td colspan="4">
		La simulación del crédito tiene fines informativos y estimaciones de carácter general. Puede presentar variaciones según políticas de la entidad financiera.<br>
		Subsidios de vivienda y de cobertura de tasa están sujetos a vigencias y disponibilidad<br>
		Lo anterior no compromete al promotor o vendedor				
		</td>
	</tr>
	
	<td class="text-center subtitle" colspan="4"><h2>OBSERVACIONES</h2></td>
	<tr>
		<td colspan="5"><textarea name="notes" id="notes" class="form-control"></textarea></td>
	</tr>
	<tr>
		
		<td colspan="5"><img src="" id="type" width="1100" height="" style="display: none;"></td>
	</tr>
	<td class="text-center subtitle" colspan="4"><h2>CONTACTO ASESOR COMERCIAL</h2></td>

	<tr><td>Nombre:	</td><td colspan="3">{{Auth::user()->name}}</td></tr>
	<tr><td>Celular:</td><td colspan="3">{{Auth::user()->phone}}</td></tr>
	<tr><td>Email:</td><td colspan="3">{{Auth::user()->email}}</td></tr>
	<tr><td colspan="4">www.trujillogutierrez.com.co</td></tr>
	<tr><td colspan="4">SÍGUENOS EN </td></tr>
	<tr><td colspan="4">facebook.com/trujillogutierrezasociados						</td></tr>
	<tr><td colspan="4">instagram.com/trujillogutierrezsas					</td></tr>	
	</tbody>
</table>

<input type="submit" name="" class="btn btn-primary" style="display: block; margin: 0 auto;">

</form>


@include('quotes.scripts')


@include('orders.autocomplete')

<script type="text/javascript">
class Customer {
  constructor( email, phone) {
  	this.email = email;
    this.phone = phone;
  }
}
var customers = new Array();
@foreach ($customers as $item) 
	customers[{{$item->id}}] = new Customer(
		 
		"{{str_replace(array("\r", "\n"), '',  $item->email)}}", 
		"{{$item->phone}}") ;
@endforeach;

	var customers_name = [@foreach ($customers as $item) "{{ucwords(strtolower($item->name))}}", @endforeach];
var customers_id = [
@foreach ($customers as $item) "{{ucwords(strtolower($item->id))}}", @endforeach];

autocomplete(document.getElementById("customers"), customers_name);
document.getElementById("customers").addEventListener("keydown", updateCustomer);
</script>
@endsection