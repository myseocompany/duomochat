<form action="/actions/" method="GET" id="filter_form" class="flex flex-col gap-4">
    <div class="form-group">
        <select name="filter" class="custom-select w-full" id="filter" onchange="update()">
            <option value="">Seleccione tiempo</option>
            <option value="0" @if ($request->filter == "0") selected="selected" @endif>hoy</option>
            <option value="-1" @if ($request->filter == "-1") selected="selected" @endif>ayer</option>
            <option value="thisweek" @if ($request->filter == "thisweek") selected="selected" @endif>esta semana</option>
            <option value="lastweek" @if ($request->filter == "lastweek") selected="selected" @endif>semana pasada</option>
            <option value="lastmonth" @if ($request->filter == "lastmonth") selected="selected" @endif>mes pasado</option>
            <option value="currentmonth" @if ($request->filter == "currentmonth") selected="selected" @endif>este mes</option>
            <option value="-7" @if ($request->filter == "-7") selected="selected" @endif>últimos 7 días</option>
            <option value="-30" @if ($request->filter == "-30") selected="selected" @endif>últimos 30 días</option>
        </select>
    </div>

    <div class="form-group">
        <input class="form-control input-date w-full" type="date" id="from_date" name="from_date" value="{{ $request->from_date }}">
    </div>

    <div class="form-group">
        <input class="form-control input-date w-full" type="date" id="to_date" name="to_date" value="{{ $request->to_date }}">
    </div>

    <div class="form-group flex items-center gap-2">
        <input value="true" @if(isset($request->pending) && ($request->pending)) checked @endif class="form-check-input" type="checkbox" id="pending" name="pending">
        <label for="pending" class="form-check-label">Pendientes</label>
    </div>

    <div class="form-group">
        <select name="type_id" class="custom-select w-full" id="type_id">
            <option value="">Tipo acción...</option>
            @foreach($action_options as $item)
                <option value="{{ $item->id }}" @if ($request->type_id == $item->id) selected="selected" @endif>{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <select name="user_id" class="custom-select w-full" id="user_id">
            <option value="">Todos los usuarios</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @if ($request->user_id == $user->id) selected="selected" @endif>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <input class="form-control w-full" type="text" placeholder="Busca o escribe" aria-label="Cliente" id="action_search" name="action_search" value="{{ $request->get('action_search') }}">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-sm btn-primary w-full" value="Filtrar">
    </div>
</form>

<style>
.input-date {
    max-width: 200px;
}
.custom-select, .form-control {
    max-width: 220px;
}
</style>
