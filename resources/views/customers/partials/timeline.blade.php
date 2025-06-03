<div class="bg-white shadow rounded-xl p-4">
  <h3 class="text-lg font-semibold mb-4">Línea de tiempo</h3>
  <ul class="space-y-4">
    @foreach($actions as $action)
      <li 
        class="border-l-4 border-blue-500 pl-4 flex justify-between items-start" 
        x-data="{ 
          completed: {{ $action->completed ? 'true' : 'false' }}, 
          completeAction() {
            fetch(`/actions/{{ $action->id }}/complete`, {
              method: 'PATCH',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              },
            })
            .then(response => {
              if (!response.ok) {
                throw new Error('Error al completar la acción');
              }
              return response.json();
            })
            .then(data => {
              this.completed = true;
            })
            .catch(error => {
              alert(error.message);
            });
          }
        }"
      >
        <!-- Left Side: Action Details -->
        <div>
          <div class="text-sm text-gray-500">
            {{ $action->created_at->format('d M Y H:i') }}
            @if($action->creator)
              — <span class="italic text-gray-600">{{ $action->creator->name }}</span>
            @else
              — <span class="italic text-gray-400">Automático</span>
            @endif
          </div>
          <div class="font-semibold">
            <span x-text="completed ? '{{ $action->type->name ?? 'Acción' }} (Completada)' : '{{ $action->type->name ?? 'Acción' }}'"></span>
          </div>
          <p class="text-gray-700 text-sm">{{ $action->note }}</p>
        </div>

        <!-- Right Side: AJAX Checkbox -->
        <div class="flex items-center">
          <input 
            type="checkbox" 
            :checked="completed"
            @change="completeAction()"
            class="w-6 h-6 rounded-full border-2 border-blue-500 text-blue-600 focus:ring-2 focus:ring-blue-400 checked:bg-blue-600 checked:border-transparent"
            :disabled="completed"
          >
        </div>
      </li>
    @endforeach
  </ul>
</div>

