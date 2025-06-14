<form action="/actions/" method="GET" id="filter_form" class="flex flex-col gap-4">
    @include('actions.dashboard')

    <input type="hidden" name="range_type" id="range_type" value="{{ $request->range_type }}">

    <div class="form-group">
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

    <div class="form-group">
        <input class="form-control input-date w-full text-sm" type="date" id="from_date" name="from_date" value="{{ $request->from_date }}">
    </div>

    <div class="form-group">
        <input class="form-control input-date w-full text-sm" type="date" id="to_date" name="to_date" value="{{ $request->to_date }}">
    </div>

    <div class="form-group flex items-center gap-2">
<div x-data="{ pending: {{ request()->input('pending', 'true') === 'true' ? 'true' : 'false' }} }" class="flex items-center space-x-2">
    <label for="pending-toggle" class="text-sm font-semibold text-gray-700">Pendientes</label>
    <button 
        type="button" 
        id="pending-toggle"
        @click="pending = !pending"
        :class="pending ? 'bg-blue-600' : 'bg-gray-300'"
        class="relative inline-flex items-center h-6 rounded-full w-11 transition"
    >
        <span 
            :class="pending ? 'translate-x-6' : 'translate-x-1'" 
            class="inline-block w-4 h-4 transform bg-white rounded-full transition"
        ></span>
    </button>
    <input type="hidden" name="pending" :value="pending ? 'true' : 'false'">
</div>


    </div>

    <div class="form-group">
        <select name="type_id" class="custom-select w-full text-sm" id="type_id">
            <option value="">Tipo acción...</option>
            @foreach($action_options as $item)
                <option value="{{ $item->id }}" @if ($request->type_id == $item->id) selected @endif>{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <select name="user_id" class="custom-select w-full text-sm" id="user_id">
            <option value="">Todos los usuarios</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @if ($request->user_id == $user->id) selected @endif>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <input class="form-control w-full text-sm" type="text" placeholder="Busca o escribe" id="action_search" name="action_search" value="{{ $request->get('action_search') }}">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-sm btn-primary w-full text-sm" value="Filtrar">
    </div>
</form>
