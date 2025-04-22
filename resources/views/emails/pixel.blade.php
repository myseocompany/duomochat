<?php
$img = \Intervention\Image\Facades\Image::make(file_get_contents('https://myseocompany.co/img/resources/logo2.png' ));
$img->encode('png');
$type = 'png';
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
?>
<img src="{!! $base64 !!}">