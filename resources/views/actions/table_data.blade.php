<div class="space-y-4">
  @foreach ($model as $action)
    @php
      $customer = $action->customer;
      $status = $customer->status ?? null;
    @endphp

    <div 
      x-data="{ 
        completed: {{ $action->delivery_date ? 'true' : 'false' }},
        show: true,
        completeAction() {
          fetch(`/actions/{{ $action->id }}/complete`, {
            method: 'PATCH',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              delivery_date: new Date().toISOString().slice(0, 19).replace('T', ' ')
            })
          })
          .then(response => {
            if (!response.ok) {
              throw new Error('Error al completar la acción');
            }
            return response.json();
          })
          .then(data => {
            this.completed = true;
            setTimeout(() => { this.show = false }, 300);
          })
          .catch(error => {
            alert(error.message);
          });
        }
      }"
      x-show="show"
      x-transition
      class="bg-white shadow-sm border border-gray-200 rounded-xl p-4 relative flex justify-between items-start"
    >

      <div class="w-full">
        {{-- Estado de acción --}}
        @if($action->isPending())
          <span class="text-xs text-red-500 font-semibold">⏰ Programado para: {{ \Carbon\Carbon::parse($action->due_date)->format('d M Y H:i') }}</span>
        @endif

        {{-- Nota principal --}}
        <div class="text-lg font-bold text-gray-800 mt-1">
          {{ $action->note }}
        </div>

        {{-- Info acción --}}
        <div class="text-sm text-gray-600">
          {{ $action->getTypeName() }} 
          @if($action->creator)
            • Creado por {{ $action->creator->name }}
          @endif
        </div>

        {{-- Info cliente --}}
        <div class="mt-2 text-sm">
          <a href="/customers/{{ $action->customer_id }}/show" class="text-blue-600 font-semibold">
            {{ $customer->name }}
          </a>
          @if($status)
            <span class="ml-2 inline-block px-2 py-0.5 text-xs text-white rounded" style="background-color: {{ $status->color }}">
              {{ $status->name }}
            </span>
          @endif

          <div class="text-gray-500 text-xs mt-1">
            📞 <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a> • ✉️ {{ $customer->email }}
            @if($customer->project) • 🏡 {{ $customer->project->name }} @endif
            @if($customer->source) • 🎯 {{ $customer->source->name }} @endif
          </div>
        </div>
      </div>

      {{-- Checkbox para completar --}}
      @if($action->isPending())
        <div class="ml-4 flex-shrink-0">
          <input 
            type="checkbox" 
            :checked="completed"
            @change="completeAction()"
            class="w-6 h-6 rounded-full border-2 border-blue-500 text-blue-600 focus:ring-2 focus:ring-blue-400 checked:bg-blue-600 checked:border-transparent"
            :disabled="completed"
          >
        </div>
      @endif
    </div>
  @endforeach
</div>
