<form action="/products/" method="GET" id="filter_form" class="filter-stacked">
  <div class="row">
    <div class="col-5">
      <div class="row"> 
        <div class="col-6">      
           <select name="filter" class="custom-select" id="filter" onchange="update()">
            <option value="">Seleccione tiempo</option>
            <option value="0" @if ($request->filter == "0") selected="selected" @endif>hoy</option>
            <option value="-1" @if ($request->filter == "-1") selected="selected" @endif>ayer</option>
            <option value="thisweek" @if ($request->filter == "thisweek") selected="selected" @endif>esta semana</option>
            
            <option value="lastweek" @if ($request->filter == "lastweek") selected="selected" @endif>semana pasada</option>
            <option value="lastmonth" @if ($request->filter == "lastmonth") selected="selected" @endif>mes pasado</option>
            <option value="currentmonth" @if ($request->filter == "currentmonth") selected="selected" @endif>este mes</option>
            <option value="-7" @if ($request->filter == "-7") selected="selected" @endif>ultimos 7 dias</option>
            <option value="-30" @if ($request->filter == "-30") selected="selected" @endif>ultimos 30 dias</option>
            
          </select>
        </div>
        <div class="col-6">      
        
          <input class="input-date" type="date" id="from_date" name="from_date" onchange="cleanFilter()" value="{{$request->from_date}}">
          <input class="input-date" type="date" id="to_date" name="to_date" onchange="cleanFilter()" value="{{$request->to_date}}">
        </div>
      </div>
    </div>
    <div class="col-2">       
      <select name="status_id" class="slectpicker custom-select" id="status_id" onchange="submit();">
          <option value="">Estado...</option>
          @foreach($statuses as $item)
            <option value="{{$item->id}}" @if ($request->status_id == $item->id) selected="selected" @endif>
               {{ $item->name }}
              
            </option>
          @endforeach
      </select>
    </div>
    <input type="hidden" name="type_id" @if(isset($request->type_id)) value="{{$request->type_id}}" @endif>
   
    <div class="col-2">       
        @if(isset($types))
          <select name="type_id" class="custom-select" id="type_id" onchange="submit();">
            <option value="">Tipos...</option>
            @foreach($types as $item)
              <option value="{{$item->id}}" @if ($request->type_id == $item->id) selected="selected" @endif>
                {{$item->name}}
                
              </option>
            @endforeach
          </select>
          @endif      

    </div>

    <div class="col-2">       
          @if(isset($categories))
          <select name="category_id" class="custom-select" id="category_id" onchange="submit();">
            <option value="">Categoría...</option>
            @foreach($categories as $item)
              <option value="{{$item->id}}" @if ($request->category_id == $item->id) selected="selected" @endif>
                {{$item->description}}
                
              </option>
            @endforeach
          </select>
          @endif
    </div>
    <div class="col-2">       
          <input type="" name="keyword" class="form-control" @if(isset($request->keyword)) value="{{$request->keyword}}" @endif>
    </div>
    <div class="col-1">       
          <input type="submit" class="btn btn-sm btn-primary my-2 my-sm-0" value="Filtrar" >
    </div>
  </div>
</form>
  