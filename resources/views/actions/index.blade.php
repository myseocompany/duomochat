@extends('layout')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="flex min-h-screen">

    @include('actions.sidebar')

    @include('actions.main')

</div>

@endsection
