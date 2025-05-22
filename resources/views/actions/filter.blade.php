<form action="/actions/" method="GET" id="filter_form" class="form-inline">
    <div class="form-group">
        <select name="filter" class="custom-select" id="filter" onchange="update()">
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
        <input class="form-control input-date" type="date" id="from_date" name="from_date" onchange="cleanFilter()" value="{{$request->from_date}}">
    </div>

    <div class="form-group">
        <input class="form-control input-date" type="date" id="to_date" name="to_date" onchange="cleanFilter()" value="{{$request->to_date}}">
    </div>

    <div class="form-group">
        <input value="1" @if(isset($request->pending) && ($request->pending==1)) checked @endif class="form-check-input" type="checkbox" id="pending" name="pending" onchange="submit()">
        <label for="pending" class="form-check-label ml-2">Pendientes</label>
    </div>

    <div class="form-group">
        <select name="type_id" class="custom-select" id="type_id" onchange="submit();">
            <option value="">Tipo acción...</option>
            @foreach($action_options as $item)
                <option value="{{$item->id}}" @if ($request->type_id == $item->id) selected="selected" @endif>{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <select name="user_id" class="custom-select" id="user_id" onchange="submit();">
            <option value="">Seleccione un usuario</option>
            @foreach($users as $user)
                <option value="{{$user->id}}" @if ((isset($request->user_id)) && ($request->user_id != "") && ($request->user_id == $user->id)) selected="selected" @endif>{{$user->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <input class="form-control" type="text" placeholder="Busca o escribe" aria-label="Cliente" id="action_search" name="action_search" value="{{ $request->get('action_search') }}">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-sm btn-primary" value="Filtrar">
    </div>
</form>


    <style>
    .input-date {
        max-width: 150px;
    }
    .custom-select, .form-control {
        max-width: 200px;
    }
    #action-search {
        max-width: 250px;
    }
    #filter_form .form-group {
        margin-bottom: 0;
    }
    #filter_form .form-group + .form-group {
        margin-left: 10px;
    }
</style>
