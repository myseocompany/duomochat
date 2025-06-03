<div class="bg-white shadow rounded-xl p-4">
  <h3 class="text-lg font-semibold mb-4">Línea de tiempo</h3>
  <ul class="space-y-4">
    @foreach($actions as $action)
      <li class="border-l-4 border-blue-500 pl-4">
        <div class="text-sm text-gray-500">
          @if(isset($action->due_date))
            Hoy
          {{ $action->due_date->format('d M Y H:i') }}
          @endif
          @if($action->creator)
            — <span class="italic text-gray-600">{{ $action->creator->name }}</span>
          @else
            — <span class="italic text-gray-400">Automático</span>
          @endif
        </div>
        <div class="font-semibold">{{ $action->type->name ?? 'Acción' }}</div>
        <p class="text-gray-700 text-sm">{{ $action->note }}</p>
      </li>
    @endforeach
  </ul>
</div>
