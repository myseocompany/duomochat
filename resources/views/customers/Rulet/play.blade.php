<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<input type="button" value="Hacer girar" style="float:left; background-color: #579A9B; border: none;
    color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;" id='spin'/>
<canvas id="canvas" width="500" height="500"></canvas>
    <script>
       var options =  [
"Perdiste","Perdiste", "Perdiste", 
"Producto original",
"Perdiste","Perdiste", "Perdiste",
"Mini Kit",
"Perdiste", "Perdiste", "Perdiste",
"Hidratación", 
"Perdiste", "Perdiste", "Perdiste",
 "Alta frecuencia",
 "Perdiste", "Perdiste", "Perdiste",
"Mascarilla facial",
 "Perdiste","Perdiste", "Perdiste",
"Mini Kit"];
var startAngle = 0;
var arc = Math.PI / (options.length / 2);
var spinTimeout = null;
var spinArcStart = 10;
var spinTime = 0;
var spinTimeTotal = 0;
var ctx;
var maxRadius = 190;
document.getElementById("spin").addEventListener("click", 
spin);
function byte2Hex(n) {
  var nybHexString = "0123456789ABCDEF";
  return String(nybHexString.substr((n >> 4) & 0x0F,1)) + nybHexString.substr(n & 0x0F,1);
}
function RGB2Color(r,g,b) {
	return '#' + byte2Hex(r) + byte2Hex(g) + byte2Hex(b);
}
function getColor(item, maxitem) {
  var phase = 0;
  var center = 128;
  var width = 127;
  var frequency = Math.PI*2/maxitem;
  
  red   = Math.sin(frequency*item+2+phase) * width + center;
  green = Math.sin(frequency*item+0+phase) * width + center;
  blue  = Math.sin(frequency*item+4+phase) * width + center;
  
  return RGB2Color(red,green,blue);
}
function drawRouletteWheel() {
  var canvas = document.getElementById("canvas");
  if (canvas.getContext) {
    var outsideRadius = maxRadius - 10;
    var textRadius = 110;
    var insideRadius = 0;
    ctx = canvas.getContext("2d");
    ctx.clearRect(0,0,400,400);
    ctx.strokeStyle = "black";
    ctx.lineWidth = 1;
    ctx.font = '14px Arial';
    
    
    for(var i = 0; i < options.length; i++) {
      var angle = startAngle + i * arc;
      //ctx.fillStyle = colors[i];
      ctx.fillStyle = getColor(i, options.length);
      
      
      ctx.beginPath();
      //ctx.moveTo(outsideRadius, outsideRadius);
      ctx.arc(maxRadius, maxRadius, outsideRadius, angle, angle + arc, false);
      ctx.arc(maxRadius, maxRadius, insideRadius, angle + arc, angle, true);
      ctx.stroke();
      ctx.fill();
      ctx.save();
      ctx.shadowOffsetX = -0.4;
      ctx.shadowOffsetY = -0.4;
      ctx.shadowBlur    = 1;
      ctx.shadowColor   = "rgb(220,220,220)";
      ctx.fillStyle = "white";
      ctx.translate(maxRadius + Math.cos(angle + arc / 2) * textRadius, 
                    maxRadius + Math.sin(angle + arc / 2) * textRadius);
      ctx.rotate(angle + 60.36 / 2 + Math.PI / 2);
      var text = options[i];
      ctx.fillText(text,  (-ctx.measureText(text).width / 2)+20, 5);
      ctx.restore();
    } 
    //Arrow
    ctx.fillStyle = "black";
    ctx.beginPath();
    ctx.moveTo(maxRadius - 4, maxRadius - (outsideRadius + 5));
    ctx.lineTo(maxRadius + 4, maxRadius - (outsideRadius + 5));
    ctx.lineTo(maxRadius + 4, maxRadius - (outsideRadius - 5));
    ctx.lineTo(maxRadius + 9, maxRadius - (outsideRadius - 5));
    ctx.lineTo(maxRadius + 0, maxRadius - (outsideRadius - 13));
    ctx.lineTo(maxRadius - 9, maxRadius - (outsideRadius - 5));
    ctx.lineTo(maxRadius - 4, maxRadius - (outsideRadius - 5));
    ctx.lineTo(maxRadius - 4, maxRadius - (outsideRadius + 5));
    ctx.fill();
  }
}
function spin() {
  spinAngleStart = Math.random() * 10 + 10;
  spinTime = 0;
  spinTimeTotal = Math.random() * 3 + 4 * 1000;
  rotateWheel();
  $("#spin").hide();
}
function rotateWheel() {
  spinTime += 30;
  if(spinTime >= spinTimeTotal) {
    stopRotateWheel();
    return;
  }
  var spinAngle = spinAngleStart - easeOut(spinTime, 0, spinAngleStart, spinTimeTotal);
  startAngle += (spinAngle * Math.PI / 180);
  drawRouletteWheel();
  spinTimeout = setTimeout('rotateWheel()', 30);
}
function stopRotateWheel() {
  clearTimeout(spinTimeout);
  var degrees = startAngle * 180 / Math.PI + 90;
  var arcd = arc * 180 / Math.PI;
  var index = Math.floor((360 - degrees % 360) / arcd);
  ctx.save();
  ctx.fillStyle = "white";
  ctx.font = 'bold 30px Helvetica, Arial';
  var text = options[index]
  ctx.fillText(text, maxRadius - ctx.measureText(text).width / 2, maxRadius + 10);
  ctx.restore();
  }
function getScore(index){
    scoring = 0;
    switch (index) {
        case 0:
            scoring = 1;
            break;
        case 2:
            scoring = 2;
            break;
        case 4:
            scoring = 3;
            break;
        case 6:
            scoring = -1;
            break;
    
        default:
            scoring = 0;
            break;
    }
    return scoring;
}
function easeOut(t, b, c, d) {
  var ts = (t/=d)*t;
  var tc = ts*t;
  return b+c*(tc + -3*ts + 3*t);
}
drawRouletteWheel();
        
    </script>