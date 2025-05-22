<table class="table table-striped">
	<tbody>
	@foreach ($model as $item)
		<tr>
			
			
			<td>
        <div>@if(isset($item->customer->status))
        <span class="badge" style="background-color: {{$item->customer->status->color}} ">
        {{$item->customer->status->name}} 
         </span> 
        @endif</div>
        <div>
        @if($item->isPending()) 🙋‍♂️ Pendiente 
        @endif  
        <a href="/customers/{{$item->customer_id}}/show">
{{$item->created_at}} -   {{$item->getTypeName()}} </a></div>
        <a href="/customers/{{$item->customer_id}}/show">
          <h4> {{$item->getCustomerName()}}</h4>
        </a>
        <div class="action_note">{{$item->note}}</div>
        <div class="action_created"></div>
        <div class="row">
          
            @if(isset($item->customer))
          <div class="col">
            <a href="/customers/{{$item->customer_id}}/show">{{$item->customer->phone}}</a>

          </div>
          <div class="col">{{$item->customer->email}}</div>
          
            @if(isset($item->customer->project))
            
            <div class="col">{{$item->customer->project->name}}</div>
            @endif
            @if(isset($item->customer->source))
            
            <div class="col">{{$item->customer->source->name}}</div>
            @endif
          @endif
          
        </div>
        
          </td>
          <td>
          @if($item->isPending())
            

 <!-- Botón para abrir el modal -->
 <button type="button" class="btn btn-secundary btn-sm fa fa-tasks"  
    data-toggle="modal" 
    data-status-id="{{$item->customer->status_id}}"
    data-type-id="{{$item->type_id}}"
    data-note="{{$item->note}}"
    data-id="{{$item->id}}"
    data-customer-name="{{$item->customer->name}}"
    
    data-target="#pendingActionModal">
    
  </button>

          @endif
          </td>
		</tr>
	@endforeach
	</tbody>
</table>

@include('actions.modal_pending', ['item'=>null, 'model'=>null])