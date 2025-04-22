Date.prototype.GetFirstDayOfWeek = function(date) {
    date = new Date(date);
    var day = date.getDay() || 7;  
    if( day !== 1 ) 
        date.setHours(-24 * (day - 1)); 
    return date;
    
}

Date.prototype.GetLastDayOfWeek = function(date) {
    date = new Date(date);
    var day = date.getDay() || 7;  
    if( day !== 1 ) 
        date.setHours(-24 * (day - 1));
    date.setDate(date.getDate() + 6); 
    return date;
}

function getThisWeek(){
  
  var firstday = new Date().GetFirstDayOfWeek(new Date());
  var lastday = new Date().GetLastDayOfWeek(new Date());
  
  $('#from_date').val(dateToString(firstday));
  $('#to_date').val(dateToString(lastday));

}


function getLastWeek(){
  var date = new Date();
  date.setDate(date.getDate()-7);  
  var firstday = new Date().GetFirstDayOfWeek(date);
  var lastday = new Date().GetLastDayOfWeek(date);
  
  $('#from_date').val(dateToString(firstday));
  $('#to_date').val(dateToString(lastday));

}

function dateToString(date){

  var dd = date.getDate();
  var mm = date.getMonth()+1; //January is 0!
  var yyyy = date.getFullYear();

  if(dd<10) {dd = '0'+dd} 

  if(mm<10) {mm = '0'+mm} 

  
  //alert(yyyy + '-' + mm + '-' + dd);
  return yyyy + '-' + mm + '-' + dd;
}

function getDate(interval){
  var date = new Date();
  date.setDate(date.getDate() + interval);

  return dateToString(date);
}


function getLastMonth(){
	var date = new Date();
	date.setDate(0);
	$('#to_date').val(dateToString(date));

	date.setDate(1);
	$('#from_date').val(dateToString(date));
  	
}

function getCurrentMonth(){

	var date = new Date();
	var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
	var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

	var date = new Date();
	date.setDate(0);
	$('#to_date').val(dateToString(lastDay));

	date.setDate(1);
	$('#from_date').val(dateToString(firstDay));
  	
}

function update(){
    filter = $( "#filter option:selected" ).val();
    
   
    switch (filter){
      case "": $('#from_date').val(""); $('#to_date').val(""); break;
      case "1": $('#from_date').val(getDate(1)); $('#to_date').val(getDate(1)); break;
      case "0": $('#from_date').val(getDate(0)); $('#to_date').val(getDate(0)); break;
      case "-1": $('#from_date').val(getDate(-1)); $('#to_date').val(getDate(-1)); break;
      case "thisweek":getThisWeek(); break;
      case "-7":$('#from_date').val(getDate(-6)); $('#to_date').val(getDate(0)); break;
      case "-30":$('#from_date').val(getDate(-30)); $('#to_date').val(getDate(-1)); break;
      case "lastweek":getLastWeek(); break;
      case "lastmonth":getLastMonth();break;
      case "currentmonth":getCurrentMonth();break;

    }
  }


  function rfmOption(){
    rfm = $( "#rfm_id option:selected" ).val();
    

    switch (rfm){
      case "1":
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)
     
      

        $("#recency_points option[value=5]").prop("selected", 'selected'); 
        $("#frequency_points option[value=4]" ).prop("selected", 'selected'); 
        $("#recency_points option[value=5]").prop("selected", 'selected'); 
        $("#frequency_points option[value=5]" ).prop("selected", 'selected'); 
     
      break;


      case "2":
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)

        $("#recency_points option[value=3]").prop("selected", 'selected'); 
        $("#frequency_points option[value=5]" ).prop("selected", 'selected'); 
        $("#recency_points option[value=4]").prop("selected", 'selected'); 
        $("#frequency_points option[value=5]" ).prop("selected", 'selected'); 
     
      break;
      case "3":
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)

        $("#recency_points option[value=1]").prop("selected", 'selected'); 
        $("#frequency_points option[value=5]" ).prop("selected", 'selected'); 
        $("#recency_points option[value=2]").prop("selected", 'selected'); 
        $("#frequency_points option[value=5]" ).prop("selected", 'selected'); 
     
      break;
      case "4":
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)

       
        $("#recency_points option[value=3]").prop("selected", 'selected'); 
        $("#frequency_points option[value=4]" ).prop("selected", 'selected'); 
        $("#recency_points option[value=4]").prop("selected", 'selected'); 
        $("#frequency_points option[value=5]" ).prop("selected", 'selected'); 
     
      break;

      case "5":
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)

       
        $("#recency_points option[value=4]").prop("selected", 'selected'); 
        $("#frequency_points option[value=3]" ).prop("selected", 'selected'); 
        $("#recency_points option[value=4]").prop("selected", 'selected'); 
        $("#frequency_points option[value=3]" ).prop("selected", 'selected'); 
          break;

      case "6":
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)

       
        $("#recency_points option[value=3]").prop("selected", 'selected'); 
        $("#frequency_points option[value=1]" ).prop("selected", 'selected'); 
        $("#recency_points option[value=4]").prop("selected", 'selected'); 
        $("#frequency_points option[value=2]" ).prop("selected", 'selected'); 
           break;

      case "7":
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)

       
        $("#recency_points option[value=1]").prop("selected", 'selected'); 
        $("#frequency_points option[value=5]" ).prop("selected", 'selected'); 
        $("#recency_points option[value=2]").prop("selected", 'selected'); 
        $("#frequency_points option[value=5]" ).prop("selected", 'selected'); 
         break;

      case "8":
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)

       
        $("#recency_points option[value=1]").prop("selected", 'selected'); 
        $("#frequency_points option[value=4]" ).prop("selected", 'selected'); 
        $("#recency_points option[value=2]").prop("selected", 'selected'); 
        $("#frequency_points option[value=4]" ).prop("selected", 'selected'); 
      break;
      case "9":
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)

       
        $("#recency_points option[value=1]").prop("selected", 'selected'); 
        $("#frequency_points option[value=3]" ).prop("selected", 'selected'); 
        $("#recency_points option[value=3]").prop("selected", 'selected'); 
        $("#frequency_points option[value=3]" ).prop("selected", 'selected'); 
        break;
      case "10":
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)
        $("#recency_points option:selected").prop("selected", false)
        $("#frequency_points option:selected" ).prop("selected", false)

       
        $("#recency_points option[value=1]").prop("selected", 'selected'); 
        $("#frequency_points option[value=1]" ).prop("selected", 'selected'); 
        $("#recency_points option[value=3]").prop("selected", 'selected'); 
        $("#frequency_points option[value=2]" ).prop("selected", 'selected'); 
        break;



    }

}


function totalDiscount(){
  
  if($('#dscto').val() != 0)
 $('#totalProduct').val( ((100-$('#dscto').val())/100) * $('#price').val()  * $('#quantity').val());
 else
 $('#totalProduct').val($('#price').val()* $('#quantity').val());
}



function cleanFilter(){
      filter = $( '#filter option[value=""]' ).attr('selected', 'selected');
}

function changeStatus(id){
  $('#status_id').val(id);
  $('#filter_form').submit();
  console.log(id);
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})