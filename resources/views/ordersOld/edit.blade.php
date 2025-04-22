@extends('layout')

@section('content')


<h1>Orden {{$model->id}}</h1>




<form class="form-group" action="/orders/{{$model->id}}/update" method="POST">
  {{ csrf_field() }}
    <div class="row">

      <div class="col-md-6 col-sm-12 group-container">
        <h3 class="title">Inmueble</h3>
        <div class="row">
          


          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Inmueble:</label>
              <select id="product_id" name="product_id" class="col-6 form-control">
                <option>Seleccione un inmueble</option>
                @if(isset($model->product_id))
                <option value="{{$model->product_id}}" selected="selected">@if(isset($model->product)) {{$model->product->name}} @endif</option>
                @endif
                @foreach($products as $item)
                <option value="{{$item->id}}" @if($model->product_id==$item->id) selected="selected" @endif>{{$item->name}}</option>
                

                @endforeach
              </select>

            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Cuota inicial:</label>
              <input id="initial_installment" name="initial_installment" class="col-6" 
              value="{{$model->initial_installment}}">
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Acabados:</label>
              <input id="finishes_value" name="finishes_value" class="col-6" value="{{$model->finishes_value}}">
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Descuentos/Interéses:</label>
              <input id="discount_interest" name="discount_interest" class="col-6" value="{{$model->discount_interest}}">
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-sm-12 group-container">
        <h3 class="title">Adicionales</h3>
        <div class="row">


          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Parqueadero:</label>
              <select id="parking_id" name="parking_id" class="col-6 form-control">
                <option>Seleccione un parqueadero</option>
                @if(isset($model->parking_id))
                <option value="{{$model->parking_id}}" selected="selected">@if(isset($model->parking)) {{$model->parking->name}} @endif</option>
                @endif
                @foreach($parkings as $item)
                <option value="{{$item->id}}" @if($model->parking_id==$item->id) selected="selected" @endif>{{$item->name}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Deposito:</label>
              <select id="deposit_id" name="deposit_id" class="col-6 form-control">
                <option>Seleccione un depósito</option>
                @if(isset($model->deposit_id))
                <option value="{{$model->deposit_id}}" selected="selected">@if(isset($model->deposit)) {{$model->deposit->name}} @endif</option>
                @endif

                @foreach($deposits as $item)
                <option value="{{$item->id}}" @if($model->deposit_id==$item->id) selected="selected" @endif>{{$item->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          
          
        </div>
      </div>
      
      <div class="col-md-6 col-sm-12 group-container">
        <h3 class="title">Subsidio</h3>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Subsidio:</label>
              <input id="subsidy" name="subsidy" class="col-6" value="{{$model->subsidy}}">
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Estado:</label>
              <input id="subsidy_status" name="subsidy_status" class="col-6" value="{{$model->subsidy_status}}">
            </div>
          </div>
          
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Fecha:</label>
              <input id="subsidy_date" name="subsidy_date" class="col-6" value="{{$model->subsidy_date}}">
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Valor:</label>
              <input id="subsidy_value" name="subsidy_value" class="col-6" value="{{$model->subsidy_value}}">
            </div>
          </div>
        </div>
      </div>  

      <div class="col-md-6 col-sm-12 group-container">
        <h3 class="title">Crédito</h3>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Crédito:</label>
              <input id="credit" name="credit" class="col-6" value="{{$model->credit}}">
            </div>
          </div>

          
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Estado:</label>
              <input id="credit_status" name="credit_status" class="col-6" value="{{$model->credit_status}}">
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Valor:</label>
              <input id="credit_value" name="credit_value" class="col-6" value="{{$model->credit_value}}">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 group-container">
        <h3 class="title">Otros</h3>
        <div class="row">

          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Escritura:</label>
              <input id="real_state_note" name="real_state_note" class="col-6" value="{{$model->real_state_note}}">
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Entregas:</label>
              <input id="releases" name="releases" class="col-6" value="{{$model->releases}}">
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Encargo:</label>
              <input id="fiduciary_commission" name="fiduciary_commission" class="col-6" value="{{$model->fiduciary_commission}}">
            </div>
          </div>

        </div>
      </div>
      <div class="col-md-6 col-sm-12 group-container">
        <h3 class="title">Cliente</h3>
        <div class="row">
          


          <div class="col-md-12 col-sm-12">
            <div class="row">
              <label class="col-6">Nombre:</label>
              <input id="customers" name="customers" class="col-6 form-control" @if(isset($model->customer)) value="{{$model->customer->name}}" @endif>
              
              <input type="hidden" name="customer_id" id="customer_id" value="{{$model->customer_id}}">
              
            </div>
          </div>
          
          
        </div>
      </div>
      
      
    </div>

  <div><input type="submit" name="" class="btn btn-primary" style="display: block; margin: 0 auto;"></div>
</form>


@include('orders.autocomplete')

<script type="text/javascript">
  
  var customers = [@foreach ($customers as $item) "{{ucwords(strtolower($item->name))}}", @endforeach];
  var customers_id = [
  @foreach ($customers as $item) "{{ucwords(strtolower($item->id))}}", @endforeach];

  autocomplete(document.getElementById("customers"), customers);
</script>

@endsection
