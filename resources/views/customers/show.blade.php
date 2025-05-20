@extends('layout')
@section('content')
<div class="w-full px-8 py-6">

  <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
  {{-- Columna izquierda --}}
  <div class="md:col-span-1">
    @include('customers.partials.info')
  </div>

  {{-- Columna central ampliada --}}
  <div class="md:col-span-4">
    @include('customers.partials.timeline')
    @include('customers.partials.add_action')
  </div>

  {{-- Columna derecha --}}
  <div class="md:col-span-1">
    @include('customers.partials.notes')
  </div>
</div>

</div>
  @endsection
