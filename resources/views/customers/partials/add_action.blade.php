<div class="sticky bottom-0 bg-white border-t z-40 px-4 pt-3 pb-4 shadow-inner" x-data="{ schedule: false }">
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
              <option value="{{ $status->id }}" {{ $status->id == $model->status_id ? 'selected' : '' }}>
                {{ $status->name }}
              </option>
        @endforeach
      </select>

      <select name="type_id" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-sm" required>
        <option value="">Acción</option>
        @foreach($action_options as $action)
          <option value="{{ $action->id }}">{{ $action->name }}</option>
        @endforeach
      </select>
      
      <!-- Botón tipo switch -->
      <div class="flex items-center space-x-2">
        <label for="schedule-toggle" class="text-sm font-medium text-gray-700">Programar acción</label>
        <button 
          type="button" 
          id="schedule-toggle"
          @click="schedule = !schedule"
          :class="schedule ? 'bg-blue-600' : 'bg-gray-300'"
          class="relative inline-flex items-center h-6 rounded-full w-11 transition"
        >
          <span 
            :class="schedule ? 'translate-x-6' : 'translate-x-1'" 
            class="inline-block w-4 h-4 transform bg-white rounded-full transition"
          ></span>
        </button>
      </div>
    </div>

    <!-- Fecha de programación (oculta por defecto) -->
    <div class="mt-3" x-show="schedule" x-transition>
      <input 
        type="datetime-local" 
        name="due_date"
        class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-sm" 
        :required="schedule"
      />
    </div>

    <button type="submit"
      class="w-full bg-blue-600 text-white font-medium py-2 rounded-md hover:bg-blue-700 transition text-sm">
      Guardar acción
    </button>
  </form>
</div>
