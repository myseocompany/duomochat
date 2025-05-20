<div class="bg-white shadow rounded-xl p-4">
  <h3 class="text-lg font-semibold mb-4">Notas e Intereses</h3>

  <div class="space-y-2">
    @if($model->notes)
    <div class="text-sm text-gray-800">{{ $model->notes }}</div>
    @endif

    <div class="text-sm text-gray-700">
      <p><strong>Presupuesto:</strong> {{ $model->budget ?? 'N/A' }}</p>
      <p><strong>Habitaciones:</strong> {{ $model->rooms ?? 'N/A' }}</p>
      <p><strong>Proyecto:</strong> {{ $model->project->name ?? 'N/A' }}</p>
    </div>

    @if(isset($pending_actions) && $pending_actions->count())
      <div class="mt-4">
        <h4 class="text-sm font-semibold">Pendientes</h4>
        <ul class="list-disc list-inside text-sm text-gray-600">
          @foreach($pending_actions as $item)
            <li>{{ $item->note }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>
</div>
