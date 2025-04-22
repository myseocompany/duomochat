<div>
  @if($group->count()!=0)
  <ul class="groupbar bb_hbox">
  
    @foreach($group as $item)
    <li class="groupBarGroup" style="background-color: {{$item->color}}; width: <?php 
        if($group->count()!=0){
          echo 100/$group->count();
        }
     ?>%">
      <h4>{{$item->count}} / $ {{number_format( $item->price / 1000000, 0) }}M</h4>
      
     
      <div><a href="#" onclick="changeStatus({{$item->id}})">{{$item->name}}</a></div>
    </li>          
    @endforeach
  </ul>
  @else
    Sin Estados
  @endif
</div>