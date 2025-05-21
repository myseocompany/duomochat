<div class="sticky bottom-0 bg-white border-t z-40 px-4 pt-3 pb-4 shadow-inner">
  <form method="POST" action="/customers/{{ $model->id }}/action/store" class="space-y-3">
    @csrf
    <input type="hidden" name="customer_id" value="{{ $model->id }}">
    @if(isset($pending_action))
      <input type="hidden" name="pending_action_id" value="{{ $pending_action->id }}">
    @endif

    <textarea name="note" rows="2"
      class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-sm"
      placeholder="Escribe la nota..." required></textarea>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
      <select name="status_id" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-sm" required>
        <option value="">Estado</option>
        @foreach($statuses_options as $status)
          <option value="{{ $status->id }}">{{ $status->name }}</option>
        @endforeach
      </select>

      <select name="type_id" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-sm" required>
        <option value="">Acción</option>
        @foreach($action_options as $action)
          <option value="{{ $action->id }}">{{ $action->name }}</option>
        @endforeach
      </select>

      <input type="datetime-local" name="due_date"
        class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-sm" />
    </div>

    <button type="submit"
      class="w-full bg-blue-600 text-white font-medium py-2 rounded-md hover:bg-blue-700 transition text-sm">
      Guardar acción
    </button>
  </form>
</div>
