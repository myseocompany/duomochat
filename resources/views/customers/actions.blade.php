@if(sizeof($pending_actions) > 0)
<h2>Acciones pendientes</h2>
<input type="" name="" id="myInput" placeholder="Busca o escribe" class="form-control mr-sm-2">

<script type="text/javascript">

  $(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#pending_actions div.pending-action").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<div id="pending_actions">
    @foreach($pending_actions as $item)
    <div class="pending-action user_{{$item->creator_user_id}}">
      @if(isset($item->customer))<h3>{{$item->customer->name}} - @if(isset($item->creator)) {{$item->creator->name}} @endif 
      	- @if(isset($item->customer->project)) {{$item->customer->project->name}} @endif
      </h3>@endif
      <div class="scoring_{{$item->customer->id}}">
          <div class="stars-outer">
            <div class="stars-inner"></div>  
          </div>
      </div>
      {{-- <script type="text/javascript">
            ratings = {
              scoring : {{$model->scoring}}
              
            };

            starTotal = 3;
   
            for(rating in ratings) {  
              // 2
              starPercentage = (ratings[rating] / starTotal) * 100;
              
              // 3
              starPercentageRounded = (Math.round(starPercentage / 10) * 10)+'%';
              console.log(starPercentageRounded);

              // 4
              $('.stars-inner').width(starPercentageRounded); 
            }
      </script> --}}
      <div class="note-action">{{$item->note}}</div>
      <a href="/customers/{{$item->customer_id}}/show/?pending_action_id={{$item->id}}#pedding-action" class="due-date-action">
         Finalizar accion programada para {{$item->due_date}} 

      </a>
    </div>
    @endforeach
</div>
@endif
