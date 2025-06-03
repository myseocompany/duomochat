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
        <div class="action_created text-sm text-gray-500">
          @if($item->creator)
            Creado por: {{ $item->creator->name }}
          @endif
        </div>
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
    <button
      type="button"
      class="btn btn-secondary btn-sm open-pending-modal"
      data-id="{{ $item->id }}"
      data-note="{{ htmlentities($item->note) }}"
      data-type-id="{{ $item->type_id }}"
      data-status-id="{{ $item->customer->status_id }}"
      data-customer-name="{{ $item->customer->name }}"
    >
      <i class="fa fa-tasks"></i>
    </button>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.open-pending-modal').forEach(function (button) {
          button.addEventListener('click', function () {
            const modal = document.getElementById('pendingActionModal');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            modal.querySelector('#action_id').value = this.dataset.id;
            modal.querySelector('#pending_note').textContent = this.dataset.note;
            modal.querySelector('#type_id').value = this.dataset.typeId;
            modal.querySelector('#status_id').value = this.dataset.statusId;
            modal.querySelector('#customer_name').textContent = this.dataset.customerName;
          });
        });
      });

      function closeModal() {
        const modal = document.getElementById('pendingActionModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      }

      function sendForm() {
        document.getElementById('complete_action_form').submit();
      }
    </script> 
          @endif
          </td>
		</tr>
	@endforeach
	</tbody>
</table>

@include('actions.modal_pending', ['item'=>null, 'model'=>null])

