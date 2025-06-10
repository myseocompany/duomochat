<aside class="w-64 bg-white border-r p-4">
    <h2 class="text-lg font-bold mb-4">Acciones</h2>

    
    <!-- Filtros -->
    <form action="/actions/" method="GET" id="filter_form" class="flex flex-col gap-3">
        @include('actions.dashboard')
        <input type="hidden" name="range_type" id="range_type" value="{{ $request->range_type }}">

        <div>
            <select name="filter" class="custom-select w-full text-sm" id="filter" onchange="update()">
                <option value="">Seleccione tiempo</option>
                <option value="0" @if ($request->filter == "0") selected @endif>hoy</option>
                <option value="-1" @if ($request->filter == "-1") selected @endif>ayer</option>
                <option value="thisweek" @if ($request->filter == "thisweek") selected @endif>esta semana</option>
                <option value="lastweek" @if ($request->filter == "lastweek") selected @endif>semana pasada</option>
                <option value="lastmonth" @if ($request->filter == "lastmonth") selected @endif>mes pasado</option>
                <option value="currentmonth" @if ($request->filter == "currentmonth") selected @endif>este mes</option>
                <option value="-7" @if ($request->filter == "-7") selected @endif>últimos 7 días</option>
                <option value="-30" @if ($request->filter == "-30") selected @endif>últimos 30 días</option>
            </select>
        </div>

        <div>
            <input class="form-control input-date w-full text-sm" type="date" id="from_date" name="from_date" value="{{ $request->from_date }}">
        </div>

        <div>
            <input class="form-control input-date w-full text-sm" type="date" id="to_date" name="to_date" value="{{ $request->to_date }}">
        </div>

        <div class="flex items-center gap-2">
            <input value="true" @if(isset($request->pending) && $request->pending) checked @endif class="form-check-input" type="checkbox" id="pending" name="pending">
            <label for="pending" class="form-check-label text-sm font-semibold">Pendientes</label>
        </div>

        <div>
            <select name="type_id" class="custom-select w-full text-sm" id="type_id">
                <option value="">Tipo acción...</option>
                @foreach($action_options as $item)
                    <option value="{{ $item->id }}" @if ($request->type_id == $item->id) selected @endif>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <select name="user_id" class="custom-select w-full text-sm" id="user_id">
                <option value="">Todos los usuarios</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @if ($request->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <input class="form-control w-full text-sm" type="text" placeholder="Busca o escribe" id="action_search" name="action_search" value="{{ $request->get('action_search') }}">
        </div>

        <div>
            <input type="submit" class="btn btn-sm btn-primary w-full text-sm" value="Filtrar">
        </div>
    </form>
</aside>

<style>
.input-date {
    max-width: 100%;
}
.custom-select, .form-control {
    max-width: 100%;
}
</style>
<script>
function submitWithRange(value) {
    document.getElementById('range_type').value = value;
    document.getElementById('filter_form').submit();
}
</script>
