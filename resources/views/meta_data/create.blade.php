@extends('layout_metadata')
@section('content')
<br>
<center><h1>{{$customers->name}}</h1></center>

<div class="container mt-4">
<form method="POST"  action="/metadata/{{$customers->id}}/save">
	 {{ csrf_field() }}

	<table class="table">
		<tbody>
			<input type="hidden" name="campaign_id" value="{{$campaign->id}}">

			@if(isset($campaign->SemanticMetaData))
			@foreach($campaign->SemanticMetaData as $item)
		
			<tr>
				<td>
					<table class="table table-hover">
								<tr>			
									<td><h2>{{$item->value}}</h2></td>

								</tr>
						<tr>

							@if(true)
							<?php //dd($item->customerMetaDataChildren); ?>
							@foreach($item->SemanticMetaDataChildren as $SemanticMetaData)<!-- hijos -->
							
								@if($item->id==$SemanticMetaData->parent_id)

									<tr>
										<td>

										@if($item->isMultiple())
											<input type="{{$item->getInputType()}}" 
											name="meta_{{$SemanticMetaData->id}}"  >
												 {{$SemanticMetaData->value}}
											  
											 @else
											  	<strong>{{$SemanticMetaData->value}}</strong>
											  	@if($item->getInputType()=='text')
											  		@if($SemanticMetaData->parent_id==31)
																										
																 <div class="row" id="{{$SemanticMetaData->id}}">

															 	</div>
											  				
											  			@else	

												 		<input type="{{$item->getInputType()}}"  required="required" name="meta_{{$SemanticMetaData->id}}" class="input" value="" >
												 	@endif	
												 				
												@else
												{{$SemanticMetaData->value}}

												@if($item->getInputType()=='file')

												@else
													<textarea id="msg" required="required" name="meta_{{$SemanticMetaData->id}}" class="textinput" value=""  ></textarea>
												 @endif	
											 @endif		
										@endif
											
										</td>
									</tr>
								@endif
						
							@endforeach	
							@endif
				 
						</tr>
					</table>
				</td>
			</tr>
			@endforeach
				@endif
		</tbody>

	</table>

	<center>
			<input type="submit" class="btn btn-primary" value="Guardar">
	</center>
</form>
</div>

<style>
	.table td, .table th {
    border-top: 1px solid #f4f4f8 !important;
	}

	body {
    background-color: #f4f4f8;
	}
		
		.textinput {
			width: 100%;
			min-height: 75px;
			outline: none;
			resize: none;
		}
		.input {
			width: 100%;
			min-height: 40px;
			outline: none;
			resize: none;
			
		}
	section#main-content {
    margin: 0px 0px 0px 0px !important;
}

	</style>
@endsection


