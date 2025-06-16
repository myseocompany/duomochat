<div class="bg-white shadow rounded-xl p-6">
  <h3 class="text-xl font-semibold mb-6">Línea de tiempo</h3>
  <ul class="space-y-6">
    @foreach($actions as $action)
      @if($action->shouldShow())
      <li class="relative flex items-start justify-between border-l-4 border-blue-500 pl-4">
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
              data-toggle="modal"
              data-id="{{ $action->id }}"
              data-note="{{ $action->note }}"
              data-type-id="{{ $action->type_id }}"
              data-status-id="{{ $action->customer->status_id }}"
              data-customer-name="{{ $action->customer->name }}"
              class="w-6 h-6 rounded-full border-2 border-blue-500 text-blue-600 focus:ring-2 focus:ring-blue-400 checked:bg-blue-600 checked:border-transparent"
              onclick="this.checked=false"
            >
          </div>
          @endif
      </li>
      @endif
    @endforeach
  </ul>
</div>
