


<form action="/customers/phase/{{$model->phase_id}}/" method="GET" id="filter_form">
  <input type="hidden" name="search" id="search" @if(isset($request->search))value="{{$request->search}}"@endif>
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
    <input class="input-date" type="date" id="from_date" name="from_date" onchange="cleanFilter()" value="{{$request->from_date}}">
    <input class="input-date" type="date" id="to_date" name="to_date" onchange="cleanFilter()" value="{{$request->to_date}}">

   {{-- Combo de estados --}}
<select name="status_id" class="slectpicker custom-select" id="status_id" onchange="submit();">
      <option value="">Estado...</option>
      @foreach($customer_options as $item)
        <option value="{{$item->id}}" @if ($request->status_id == $item->id) selected="selected" @endif>
           {{ $item->name }}
          
        </option>
      @endforeach
    </select>

<!--RFM-->

      
        <select  name="rfm_group_id" class="custom-select" id="rfm_group_id" onchange="submit();">
          <option value="">Tipo de cliente</option>
         @if(isset($rfm_groups) && $rfm_groups!= "")
          @foreach($rfm_groups as $item)
            <option value="{{$item->id}}" @if ($request->rfm_group_id == $item->id) selected="selected" @endif>
               {{$item->emoji}} {{ $item->name }}
            </option>
      
          @endforeach
          @endif
        </select>
        <!--
        <select multiple name="recency_points" id="recency_points">
          <option value="">Recencia</option>
          @for ($i = 1; $i <= 5; $i++)
          <option value="{{$i}}">
               <?php echo($i); ?>
            </option>
          @endfor
        </select>

        <select multiple name="frequency_points" id="frequency_points">
        <option value="">Frecuencia</option>
        @for ($i = 1; $i <= 5; $i++)
          <option value="{{$i}}">
               <?php echo($i); ?>
            </option>
          @endfor
        </select>

      -->


    <!-- Audiencia
  @if(isset($audiences)&& ($audiences!="") )
        <select name="audience_id" class="custom-select" id="audience_id" onchange="submit();">
          <option value="">Audiencia...</option>
          @foreach($audiences as $item)
            <option value="{{$item->id}}" @if ($request->audience_id == $item->id) selected="selected" @endif>
               <?php echo substr($item->name, 0, 20); ?>@if(isset($item->customeres))
               - {{$item->customeres->count()}} @endif
              
            </option>
          @endforeach
        </select>
    @endif


-->

    <!--  
*
*    Combo de fuentes
*
    -->

    <select name="scoring" class="custom-select" id="scoring" onchange="submit();">
      <option value="">Calificación...</option>
      @for($i=1; $i<=3; $i++ )
        <option value="{{$i}}" @if (($request->scoring == $i)&&($i!=0)) selected="selected" @endif>
           {{$i}}
          
        </option>
      @endfor
    </select>
    <!--
    <select name="actions_number" class="custom-select" id="actions_number" onchange="submit();">
      <option value="">Acciones...</option>
      @for($i=1; $i<=3; $i++ )
        <option value="{{$i}}" @if (($request->actions_number == $i)&&($i!=0)) selected="selected" @endif>
           {{$i}}
          
        </option>
      @endfor
      
    </select>
-->
    <select name="source_id" class="custom-select" id="source_id" onchange="submit();">
      <option value="">Origen...</option>
      @foreach($sources as $item)
        <option value="{{$item->id}}" @if ($request->source_id == $item->id) selected="selected" @endif>
           <?php echo substr($item->name, 0, 15); ?>
          
        </option>
      @endforeach
    </select>

<select name="user_id" class="custom-select" id="user_id" onchange="submit();">
      <option value="">Usuario...</option>
      <option value="null">Sin asignar</option>
      @foreach($users as $item))
        <option value="{{$item->id}}" @if (isset($request->user_id )  && ($request->user_id != "") && ($request->user_id == $item->id)) selected="selected" @endif>
           <?php echo substr($item->name, 0, 10); ?>
          
        </option>
      @endforeach
    </select>

    

<!--
    @if(isset($projects))
    <select name="project_id" class="custom-select" id="project_id" onchange="submit();">
      <option value="">Proyecto...</option>
      @foreach($projects as $item)
        <option value="{{$item->id}}" @if ($request->project_id == $item->id) selected="selected" @endif>
           <?php echo substr($item->name, 0, 15); ?>
          
        </option>
      @endforeach
    </select>
    @endif

-->   
    <input type="text" name="search" id="search" value="{{$request->search}}" placeholder="Busca o escribe">
    <span>
      <?php $cu = $request->created_updated; ?>
      <label class="radio"> Creación 
        <input type="radio" name="created_updated" value="created" 
        @if((isset($cu)&& ($cu == 'created'))||(!isset($cu)))  checked @endif onchange="submit();"> </label> 
      <label class="radio" > Actualización 
        <input type="radio" name="created_updated" value="updated" @if(isset($request->created_updated)&& ($request->created_updated == "updated")) checked @endif onchange="submit();"> </label></span>
      <label class="radio" > Cumpleaños 
        <input type="radio" name="created_updated" value="birthday" @if(isset($request->created_updated)&& ($request->created_updated == "birthday")) checked @endif onchange="submit();"> </label></span>
    
        <input type="submit" class="btn btn-sm btn-primary my-2 my-sm-0" value="Filtrar" >
  </form>




<script>

var rfm = new Array(); 
@if(isset($rfm_groups))
    @foreach($rfm_groups as $item)

    rfm["{{$item->name}}"] =  Array( {{$item->recency_min}} ,{{$item->recency_max}},{{$item->frequency_min}}, {{$item->frequency_max}}); 
    


    @endforeach
@endif
</script>