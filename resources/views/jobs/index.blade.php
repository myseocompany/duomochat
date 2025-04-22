@extends('layout')

@section('content')


<table>
	<tr>
		<td>id</td>
		<td>payload</td>
		<td>available_at</td>
		<td>created_at</td>
	</tr>
	@foreach($model as $item)
		<tr>
			<td>{{$item->id}}</td>
			<td>{{$item->get_payload()}}</td>
			<td>{{$item->get_available_at()}}</td>
			<td>{{$item->created_at}}</td>
		</tr>
	@endforeach
</table>

@endsection