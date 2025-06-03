<div class="bg-white shadow rounded-xl p-6">
  <h3 class="text-xl font-semibold mb-6">Línea de tiempo</h3>
  <ul class="space-y-6">
    @foreach($actions as $action)
      @if($action->shouldShow())
      <li 
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
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="relative flex items-start justify-between border-l-4 border-blue-500 pl-4"
      >
        <!-- Action content -->
        <div>
          <!-- Due date if pending -->
          @if($action->isPending())
            <div class="text-xs text-red-600 font-semibold mb-1">
              ⏰ Programado para: {{ \Carbon\Carbon::parse($action->due_date)->format('d M Y H:i') }}
            </div>
          @endif

          <!-- Main note -->
          <div class="text-lg font-bold text-gray-800 mb-1">
            {{ $action->note }}
          </div>

          <!-- Type of action -->
          <div class="text-sm text-gray-600 mb-1">
            {{ $action->type->name ?? 'Acción' }}
          </div>

          <!-- Metadata: Creator and Created Date -->
          <div class="text-xs text-gray-400 mt-2">
            Creado por 
            <span class="italic">{{ $action->creator->name ?? 'Automático' }}</span> 
            el {{ $action->created_at->format('d M Y H:i') }}
          </div>
        </div>

        <!-- Completion Checkbox -->
        @if($action->isPending())
        <div class="flex items-center ml-4">
          <input 
            type="checkbox" 
            :checked="completed"
            @change="completeAction()"
            class="w-6 h-6 rounded-full border-2 border-blue-500 text-blue-600 focus:ring-2 focus:ring-blue-400 checked:bg-blue-600 checked:border-transparent"
            :disabled="completed"
          >
        </div>
        @endif
      </li>
      @endif
    @endforeach
  </ul>
</div>
