@extends('layout')
@section('content')
<h2>Audiencia: {{$audience->name}}</h2>
<h3>Campaña: {{$campaign->name}}</h4>
<?php 

/*
function sendMessage($cel, $msg){
	$url = "https://wa.me/";
	$url .= $cel;
	$url .= "?text=".$msg;
	return $url;
}*/

function sendMessage($cel, $msg){
	$url = "https://api.whatsapp.com/send/?phone=";
	$url .= $cel;
	$url .= "&text=".$msg;
	return $url;
}

function getLink($cel, $msg){
	$html = "<a href='".$msg."'>";
	$html .="mensaje";
	$html .="</a>";
	return $html;
}
 ?>
<div class="container">
	<table class="table">
		<tr>
			<th>GUARDAR ACCIÓN</th>
			<th>VER ACCIÓN</th>
			@foreach($campaignMessage as $key => $value)
				<th>
					<?php echo "MENSAJE " . ($key + 1); ?>	
				</th>
			@endforeach
		</tr>
		@foreach($model as $item)
			@if($item->hasAValidPhone())
			<tr id="tr_{{$item->id}}">
				<td>
					<?php $msg = 'Se envió campaña: '.$campaign->name?>
					<?php $str = 'https://hdc.quirky.com.co/track_send/'.$item->id.'/'.$audience->id.'/14/'.urlencode($msg); ?>


					<a target="iframe_a_{{$item->id}}" href="{{$str}}" onclick="loadIframe({{$item->id}})">{{$item->name}}</a>
				</td>
				<td id="iframe_div_{{$item->id}}">
					
				</td>
				@foreach ($campaignMessage as $message) 
				<td>
					<?php 
						$messageEncode = urlencode($message->text);
					?>
					<a target="whatsapp" href="{{ sendMessage($item->getPhone(), $messageEncode ) }}">{{substr($message->text,0,29)}}</a>	
					<a>
						<div id="content_{{$item->id}}" style="display:none">
							{{sendMessage($item->getPhone(), $messageEncode)}}
				        </div>
			           <img  onclick="copyPassword('content_{{$item->id}}')" style="width: 20px;"  src="/img/copy.png">
			        </a>
				</td>
				@endforeach
				<?php 
				?>
			</tr>
			@endif
		@endforeach
	</table>
	{{ $model->links('pagination::bootstrap-4') }}
</div>


<script type="text/javascript">
	function loadIframe(id){
		$("#iframe_div_"+id).html("<iframe src='demo_iframe.htm' name='iframe_a_"+id+"' height='50px' width='100px' title='Iframe Example'></iframe>");
		$("#iframe_div_"+id).hide(3000);
		$("#tr_"+id).hide(3000);
	}

	function copyPassword(id_elemento) {
		console.log(id_elemento);
		var aux = document.createElement("input");

		var str = document.getElementById(id_elemento).innerHTML;
		message = str.replace("amp;", "");
		aux.setAttribute("value", message);
		document.body.appendChild(aux);
		aux.select();
		document.execCommand("copy");
		document.body.removeChild(aux);
	}
</script>
@endsection
