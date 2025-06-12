<div class="bg-white shadow rounded-xl p-4">
  <h3 class="text-lg font-semibold mb-4">Notas e Intereses</h3>

  <div class="space-y-2">
    @if($model->notes)
    <div class="text-sm text-gray-800">{{ $model->notes }}</div>
    @endif


<form action="{{ route('customers.update', $model->id) }}" method="POST" class="space-y-4">
  @csrf
  @method('PUT')

  <div class="space-y-2">
<form action="{{ route('customers.update', $model->id) }}" method="POST" class="space-y-4">
  @csrf
  @method('PUT')

<div class="space-y-4">
  @foreach($meta_fields as $field)
    <div class="flex flex-col gap-1">
      <label class="text-sm font-semibold text-gray-700">
        {{ $field['label'] }}
      </label>

      @if($field['type'] === 'Texto Corto' || $field['type'] === 'textarea')
        <input type="text" 
               name="meta_{{ $field['master_meta_datas_id'] }}" 
               value="{{ $field['value'] }}" 
               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 text-sm">
      @elseif($field['type'] === 'Select')
        <select name="meta_{{ $field['master_meta_datas_id'] }}" 
                class="w-full rounded-md border-gray-300 shadow-sm text-sm">
          @foreach($field['options'] as $option)
            <option value="{{ $option->id }}" {{ $option->selected ? 'selected' : '' }}>
              {{ $option->name }}
            </option>
          @endforeach
        </select>
      @endif
    </div>
  @endforeach
</div>


  <div class="mt-6 text-center">
    <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700">
      Guardar
    </button>
  </div>
</form>

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
