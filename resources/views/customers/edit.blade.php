@extends('layout')

@section('content')
<h1>{{$model->name}}</h1>
<form action="/customers/{{$model->id}}/update" method="POST">
  {{ csrf_field() }}
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">Datos Personales:</legend>
    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
          <label for="name">Nombre:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Nombre..." value="{{$model->name}}">
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group">
          <label for="phone2">Celular:</label>
          <input type="text" class="form-control" id="phone" name="phone" value="{{$model->phone}}" placeholder="Celular...">
        </div>
      </div>


      <div class="col-sm-3">
        <div class="form-group">
          <label for="email">Correo Electrónico:</label>
          <input type="text" class="form-control" id="email" name="email" value="{{$model->email}}" placeholder="Correo Electronico...">
        </div>
      </div>



      <div class="col-sm-3">
        <div class="form-group">
          <label for="address">Dirección:</label>
          <input type="text" class="form-control" id="address" value="{{$model->address}}" name="address" placeholder="Dirección...">
        </div>
      </div>


      <div class="col-sm-3">
        <div class="form-group">
          <label for="document">Documento:</label>
          <input type="text" class="form-control" id="document" name="document" value="{{$model->document}}" placeholder="Doc Ej: C.c/DNI...">
        </div>
      </div>


      <div class="col-sm-3">
        <div class="form-group">
          <label for="document">Atendido por:</label>
          <select name="user_id" id="user_id" class="form-control">
            <option value="">Seleccione...</option>
            @foreach ($users as $item)
            <option value="{{$item->id}}" @if($item->id==$model->user_id)selected="selected" @endif>{{$item->name}}</option>
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
            <option value="{{$item->id}}" @if($item->id==$model->source_id)selected="selected" @endif>{{$item->name}}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group">
          <label for="project_id">Proyecto:</label>
          <select name="project_id" id="project_id" class="form-control">
            <option value="">Seleccione...</option>
            @foreach ($projects as $item)
              <option value="{{ $item->id }}" {{ (isset($model) && $model->project_id == $item->id) ? 'selected' : '' }}>
                {{ $item->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>


      <div class="col-sm-3">
        <div class="form-group">
          <label for="customers_statuses">Estado:</label>
          <select name="status_id" id="status_id" class="form-control">
            <option value="">Seleccione...</option>
            @foreach ($customer_statuses as $item)
            <option value="{{$item->id}}" @if($item->id==$model->status_id)selected="selected" @endif>{{$item->name}}</option>
            @endforeach
          </select>
        </div>
      </div>

    </div>


  </fieldset>

  @if(isset($meta_fields) && count($meta_fields))
    <fieldset class="scheduler-border">
      <legend class="scheduler-border">Características del cliente</legend>
      <div class="row">
        @include('customers.components.edit_meta_fields')
      </div>
    </fieldset>
  @endif

  {{-- Fin datos de contacto --}}
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">Datos Adicionales:</legend>
    {{-- Estado --}}
    {{-- fuente --}}

    <div class="">
      <label for="notes">Notas:</label>
      <textarea name="notes" id="notes" placeholder="" cols="30" rows="5" class="form-control">{{$model->notes}}</textarea>
    </div>
  </fieldset>

  {{-- Datos de contacto --}}
  <fieldset class="scheduler-border">
    <legend class="scheduler-border">Contactos adicionales:</legend>
    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
          <label for="contact_name">Nombre:</label>
          <input type="text" class="form-control" id="contact_name" name="contact_name" value="{{$model->contact_name}}">
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
          <label for="contact_phone2">Celular:</label>
          <input type="text" class="form-control" id="contact_phone2" name="contact_phone2" value="{{$model->contact_phone2}}">
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group">
          <label for="contact_email">Correo Electrónico:</label>
          <input type="text" class="form-control" id="contact_email" name="contact_email" value="{{$model->contact_email}}">
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
          <label for="contact_position">Parentesco:</label>
          <input type="text" class="form-control" id="contact_position" name="contact_position" value="{{$model->contact_position}}">
        </div>
      </div>

    </div>
  </fieldset>



  <fieldset class="scheduler-border">
    <legend class="scheduler-border">Otros datos:</legend>
    <div class="row">

      <div class="col-sm-3">
        <div class="form-group">
          <label for="phone">Teléfono:</label>
          <input type="text" class="form-control" id="phone2" name="phone2" value="{{$model->phone2}}" placeholder="Telefono...">
        </div>
      </div>




      <div class="col-sm-3">
        <div class="form-group">
          <label for="country">País:</label>
          <input type="text" class="form-control" id="country" value="{{$model->country}}" name="country" placeholder="País...">
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
          <label for="department">Departamento:</label>
          <input type="text" class="form-control" value="{{$model->department}}" id="department" name="department" placeholder="Ciudad...">
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
          <label for="city">Ciudad:</label>
          <input type="text" class="form-control" value="{{$model->city}}" id="city" name="city" placeholder="Ciudad...">
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group">
          <label for="business">Empresa:</label>
          <input type="text" class="form-control" id="business" value="{{$model->business}}" name="business" placeholder="Empresa...">
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
          <label for="position">Cargo:</label>
          <input type="text" class="form-control" id="position" value="{{$model->position}}" name="position" placeholder="Cargo..">
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group">
          <label for="instagram_url">Instagram:</label>
          <input type="text" class="form-control" id="instagram_url" name="instagram_url" value="{{$model->instagram_url}}" placeholder="Instagram URL">
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group">
          <label for="facebook_url">Facebook:</label>
          <input type="text" class="form-control" id="facebook_url" name="facebook_url" value="{{$model->facebook_url}}" placeholder="Facebook URL">
        </div>
      </div>


    </div>
  </fieldset>



  <button type="submit" class="btn btn-primary">Enviar</button>
</form>


@endsection