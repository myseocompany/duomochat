@foreach($meta_fields as $field)
  <div class="col-sm-3">
    <div class="form-group">
      <label>{{ $field['label'] }}</label>

      @switch($field['type'])


        @case('Texto Corto')
          @php
            $val = $field['value'] ?? '';
            if (is_numeric($val)) {
              $val = number_format($val, 0, ',', '.');
            }
          @endphp
          <input type="text" class="form-control text-end format-thousands" name="meta_{{ $field['master_meta_datas_id'] }}" value="{{ $val }}">
          @break

        @case('Texto largo')
          <textarea class="form-control" name="meta_{{ $field['master_meta_datas_id'] }}">{{ $field['value'] ?? '' }}</textarea>
          @break

        @case('Select')
          <select name="meta_{{ $field['master_meta_datas_id'] }}" class="form-control">
            <option value="">Seleccione...</option>
            @foreach($field['options'] as $opt)
              <option value="{{ $opt->id }}" {{ $opt->selected ? 'selected' : '' }}>{{ $opt->name }}</option>
            @endforeach
          </select>
          @break

        @case('Radio')
          @foreach($field['options'] as $opt)
            <div class="form-check">
              <input class="form-check-input" type="radio" name="meta_{{ $field['master_meta_datas_id'] }}" value="{{ $opt->id }}" {{ $opt->selected ? 'checked' : '' }}>
              <label class="form-check-label">{{ $opt->name }}</label>
            </div>
          @endforeach
          @break

        @case('Checkbox')
          @foreach($field['options'] as $opt)
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="meta_{{ $field['master_meta_datas_id'] }}[]" value="{{ $opt->id }}" {{ $opt->selected ? 'checked' : '' }}>
              <label class="form-check-label">{{ $opt->name }}</label>
            </div>
          @endforeach
          @break

        @case('Archivo')
          <input type="file" class="form-control" name="meta_{{ $field['master_meta_datas_id'] }}">
          @break

        @default
          <input type="text" class="form-control" name="meta_{{ $field['master_meta_datas_id'] }}" value="{{ $field['value'] ?? '' }}">
      @endswitch

    </div>
  </div>
@endforeach

<script>
  function formatNumber(n) {
    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  document.querySelectorAll('.format-thousands').forEach(input => {
    let raw = input.value.replace(/\./g, '');
    if (!isNaN(raw) && raw !== '') {
      input.value = formatNumber(raw);
    }

    input.addEventListener('input', () => {
      let val = input.value.replace(/\D/g, '');
      input.value = formatNumber(val);
    });
  });
</script>
