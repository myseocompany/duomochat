@extends('layoutExcel')
@section('content')
@if (count($model) > 0)
@foreach($model as $item)
57{{ $item->phone_wp }},{{ ucfirst(strtolower(explode(' ', $item->name)[0])) }},{{ mb_convert_case(mb_strtolower(preg_replace('/\s+/', ' ', $item->name)), MB_CASE_TITLE, 'UTF-8') }},{{$item->id}}
@endforeach @endif  @endsection