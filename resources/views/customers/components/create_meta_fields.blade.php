@foreach($meta_fields as $field)
  <div class="col-sm-3">
    <div class="form-group">
      <label>{{ $field['label'] }}</label>

      @switch($field['type'])
        @case('Texto Corto')
          <input type="text" class="form-control" name="meta_{{ $field['master_meta_datas_id'] }}" value="{{ $field['value'] ?? '' }}">
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
