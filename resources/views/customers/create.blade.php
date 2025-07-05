@extends('layout')

@section('content')
<h1>Crear Cliente</h1>
{{-- FORMULARIO CLIENTES --}}
<form method="POST" action="/customers">
{{ csrf_field() }}

<fieldset class="scheduler-border">
  <legend class="scheduler-border">Datos Personales:</legend>
    <div class="row">

      <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label for="name">Nombre:</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Nombre..." value="">
            </div>
          </div>

          <div class="col-sm-12">
           <div class="form-group">
            <label for="phone">Celular:</label>
            <input type="number" class="form-control" id="phone" name="phone" placeholder="Celular...">
          </div>
          
        </div>

          <div class="col-sm-12">
            <div class="form-group">
              <label for="email">Correo:</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Correo Electronico...">
            </div>
          </div>



        </div>
      </div>

      <div class="col-sm-6">
      <div class="row">
        <div class="col-sm-12"> 
          <div class="form-group">
            <label for="document">Referido por</label>
            <input type="text" class="form-control" id="refered_by" name="refered_by" placeholder="Referido por...">
          </div>
        </div>
<div class="col-sm-3">
  <div class="form-group">
    <label for="interested_product_id">Producto de interés:</label>
    <select name="interested_product_id" id="interested_product_id" class="form-control">
      <option value="">Seleccione...</option>
      @foreach ($products as $product)
        <option value="{{ $product->id }}">
          {{ $product->name }}
        </option>
      @endforeach
    </select>
  </div>
</div>
        <div class="col-sm-12">
          <div class="form-group">
            <label for="users">Asignado A:</label>
            <select name="user_id" id="user_id" class="form-control">
              <option value="">Seleccione...</option>
              @foreach ($users as $item)
              <option value="{{ $item->id }}">{{  $item->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

      </div>
    </div>

<div class="col-sm-3">
          <div class="form-group">
            <label for="customers_statuses">Estado:</label>
            <select name="status_id" id="status_id" class="form-control">
              <option value="">Seleccione...</option>
              @foreach ($customers_statuses as $item)
              <option value="{{ $item->id }}">{{  $item->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-sm-3">
          <div class="form-group">
            <label for="font_customers">Proyecto:</label>
            <select name="project_id" id="project_id" class="form-control">
              <option value="">Seleccione...</option>
              @foreach ($projects as $item)
              <option value="{{ $item->id }}">{{  $item->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        
        <div class="col-sm-3">
          <div class="form-group">
            <label for="font_customers">Origen:</label>
            <select name="source_id" id="source_id" class="form-control">
              <option value="">Seleccione...</option>
              @foreach ($customer_sources as $item)
              <option value="{{ $item->id }}">{{  $item->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
</fieldset>

  @if(isset($meta_fields) && count($meta_fields))
    <fieldset class="scheduler-border">
      <legend class="scheduler-border">Interés</legend>
      <div class="row">
        @include('customers.components.create_meta_fields')
      </div>
    </fieldset>
  @endif


  {{-- Fin datos de contacto --}}
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">Datos Adicionales:</legend>

  <div class="">
    <label for="notes">Notas:</label>
    <textarea name="notes" id="notes" placeholder="" cols="30" rows="5" class="form-control"></textarea>
  </div>
</fieldset>

<fieldset class="scheduler-border">
  <legend class="scheduler-border">Hoja de Negocio:</legend>
  <div class="row">
        
        
        
        <div class="col-sm-3">
          <div class="form-group">
            <label for="phone2">Teléfono:</label>
            <input type="number" class="form-control" id="phone2" name="phone2" placeholder="Telefono...">
          </div>
        </div>
         
        
        <div class="col-sm-3">
          <div class="form-group">
            <label for="country">País:</label>
            <input type="text" class="form-control" id="country" name="country" placeholder="País...">
          </div>
        </div>

        <div class="col-sm-3">
          <div class="form-group">
            <label for="department">Departamento:</label>
            <input type="text" class="form-control" id="department" name="department" placeholder="Departamento...">
          </div>
        </div>

        <div class="col-sm-3">
          <div class="form-group">
            <label for="city">Ciudad:</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="Ciudad...">
          </div>
        </div>
        
        <div class="col-sm-3">
          <div class="form-group">
            <label for="position">Ocupación:</label>
            <input type="text" class="form-control" id="position" name="position" placeholder="Cargo..">
          </div>    
        </div>

        <div class="col-sm-12">
          <div class="form-group">
            <label for="address">Dirección:</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Dirección...">
          </div>
        </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label for="document">CC:</label>
              <input type="text" class="form-control" id="document" name="document" placeholder="Doc Ej: C.c/DNI...">
            </div>
          </div>
<!-- Empresa donde trabaja, telefono empresa
-->
<!--
        <div class="col-sm-12">
          <div class="form-group">
            <label for="document">F. de cumpleaños:</label>
            <input type="date" class="form-control" id="birthday" name="birthday">
          </div>
        </div>
-->
        
        
  </div>

  </fieldset>
  {{-- Datos de contacto --}}
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">Datos acompañante:</legend>
    <div class="row">
      <!-- cedula, ocupacion, empresa donde trabaja, valor de la casa, valor de la sepración
        cuota inicial, cuota final, valor de la cuota, fecha de entrega 
      -->
          <div class="col-sm-3">
          <div class="form-group">
            <label for="contact_name">Nombre:</label>
            <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="Nombre del contacto" value="">
          </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label for="contact_phone2">Celular:</label>
              <input type="text" class="form-control" id="contact_phone2" name="contact_phone2" placeholder="Celular...">
            </div>
          </div>
          
          <div class="col-sm-3">
            <div class="form-group">
              <label for="contact_email">Correo Electrónico:</label>
              <input type="text" class="form-control" id="contact_email" name="contact_email" placeholder="Correo Electronico...">
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label for="contact_position">Parentesco:</label>
              <input type="text" class="form-control" id="contact_position" name="contact_position" placeholder="Parentesco..">
            </div>    
          </div>
          
    </div>
  </fieldset>
  <button type="submit" class="btn btn-primary">Enviar</button>
</form>

@endsection
