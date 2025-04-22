@extends('layout')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">

    <h1 class="text-2xl font-bold mb-4">{{ $audience->name }}</h1>



    @livewire('audience-customer-manager', ['audienceId' => $audience->id])
    
</div>
@endsection
