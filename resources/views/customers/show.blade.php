@extends('layout')
@section('content')
<div class="w-full px-8 py-6">

<div class="grid grid-cols-1 md:grid-cols-12 gap-6">
  <!-- Panel izquierdo -->
  <div class="md:col-span-3">
    @include('customers.partials.info')
  </div>

  <!-- Centro (línea de tiempo + acciones) -->
  <div class="md:col-span-7">
    @include('customers.partials.timeline')
    @include('customers.partials.add_action')
    @include('actions.modal_pending', ['action_options' => $action_options, 'statuses_options' => $statuses_options])
  </div>

  <!-- Panel derecho -->
  <div class="md:col-span-2">
    @include('customers.partials.notes')
  </div>
</div>



</div>
  @endsection
