@extends('layout_metadata')

@section('content')

<form method="POST"  action="/customers/metadata/{{$customer->id}}/save" id="form_meta">
	 {{ csrf_field() }}

	 <div class="container">
			<div class="row"><div class="col"><center><h1>{{$customer->name}}</h1></center></div></div>
			<div class="row">
				<div class="col"><label>Nombre</label>
					<br>
					<input type="text" name="name" value="{{$customer->name}}">
				</div>
			</div>
			<div class="row">
				<div class="col"><label>email</label>
					<br>
					<input type="text" name="email" value="{{$customer->email}}">
				</div>
			</div>
			<div class="row">
				<div class="col"><label>fecha de nacimiento</label>
					<br>
					<input type="date" name="birthday" value="{{$customer->birthday}}">
				</div>
			</div>
			<div class="row">
				<div class="col"><label>dirección</label>
					<br>
					<input type="text" name="address" value="{{$customer->address}}">
				</div>
			</div>
			@if(isset($semantic))
				@foreach($semantic as $item)
			

						
				<div class="row">			
					<div class="col bg-secondary text-white"><h2>{{$item->value}}</h2></div>
				</div>
				
				<?php //dd($item->children()); ?>
					@if($item->children())
					
						@foreach($item->children() as $itemChild)<!-- hijos -->
						
							
							<div class="row">
									<div class="col-12">
										<label for="meta_{{$itemChild->id}}">{{$itemChild->value}}</label>
										<br>
									{!!$itemChild->getElement("meta_".$itemChild->id, "meta_".$itemChild->id, "", "", "")!!}	
									</div>
							</div>	
							
				
						@endforeach	
					@endif
			
						
					
				@endforeach
			@endif
	

	<center>
			<input type="submit" class="btn btn-primary" value="Guardar">
	</center>
	</div>
</form>


<style>
	
	input[type=text]{
			width:100%;

	}
	body {
    	background-color: #fff!important;
	}
	img#logo {
    	height: 35px;
	}
		
		
	section#main-content {
    margin: 0px 0px 0px 0px !important;
}
	#form_meta{
		background-color: #ffffff;
		
	}
	label{
		margin-top: 1rem;
	}	

	</style>
@endsection