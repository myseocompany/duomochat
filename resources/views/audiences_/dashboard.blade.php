<div>
  @if(isset($customersGroup) && $customersGroup->count()!=0)
  <ul class="groupbar bb_hbox">
  
    @foreach($customersGroup as $item)
    <li class="groupBarGroup" style="background-color: {{$item->color}}; width: <?php 
        if($customersGroup->count()!=0){
          echo 100/$customersGroup->count();
        }
     ?>%">
      <h3>{{$item->count}}</h3>
     
      <div><a href="#" onclick="changeStatus({{$item->id}})">{{$item->name}}</a></div>
    </li>          
    @endforeach
  </ul>
  @else
    Sin Estados
  @endif
</div>