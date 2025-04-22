@extends('layout_metadata')
@section('content')
<br>
<center><h1>{{$project->name}}</h1></center>

<div class="container mt-4">
	<table class="table" border="1">
		@if(isset($campaign->ProjectMetaData))
		@foreach($campaign->ProjectMetaData as $main_question)
			<tr>
				<td><h2>{{$main_question->value}}</h2></td>
				
			</tr>
			@if($main_question->ProjectMetaDataChildren)
				<tr>
					<td>
						<table>
					@foreach($main_question->ProjectMetaDataChildren as $sub_question)
						<tr>
							<td><strong>{{$sub_question->value}}</strong>
							</td>
							
							<td>{{$sub_question->getAnswer( $project->id, $sub_question )}}</td>
						</tr>
						@endforeach
					</table>
					</td>
				</tr>	
			@else
				<tr>
					<td>{{$sub_question->getAnswer( $project->id, $main_question )}}</td>
				</tr>	
			@endif
		@endforeach
		@endif
	</table>
</div>
<div class="container mt-4">
	<table class="table">
		<tbody>
			@if(isset($campaign->projectMetaData))
			@foreach($campaign->projectMetaData as $item)
			<tr class="tr_{{$item->id}}">
				<td>

					<table class="table table-hover">
						<tr >
							@if(true)
							<?php  ?>
							@foreach($item->projectMetaDataChildren as $projectMetaData)<!-- hijos -->
								@if($projectMetaData->id ==22 || $projectMetaData->id == 23 || $projectMetaData->id == 24 || $projectMetaData->id == 25)
									@else
										@if($item->id==$projectMetaData->parent_id)
											<tr>
													<td>
												@if($item->isMultiple())
														 @else
													  	<strong>{{$projectMetaData->value}}</strong><!--preguntas-->
													  	@if($item->getInputType()=='text')
													  		@if($projectMetaData->parent_id==31)
													  			@else
													  			@foreach($project_meta as $projectMeta)
																  
																 	 @if($projectMeta->meta_data_id==$projectMetaData->id)
													  				<br>
													  				<label><!--respuestas-->
																	   
													  					{{$projectMeta->value}}
													  				</label>
														  			@endif
															    @endforeach
														 	@endif	
														@else
													 @endif		
												@endif
												</td>	
											
											</tr>
										@endif
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
		<strong><label>Archivos</label></strong>
		@foreach($project_document as $projectDocument)
				@if($projectDocument->type_id==5)
	  				<br>
	  				<a href="{{$projectDocument->url}}">
	  					{{$projectDocument->url}}
	  				<a>
		  		@endif	
		@endforeach
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
		tr.tr_31 {
    display: none;
	}
tr.tr_21 {
    display: none;
}
	section#main-content {
    margin: 0px 0px 0px 0px !important;
}

	</style>
@endsection


