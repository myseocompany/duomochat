<script type="text/javascript">
var initial_installment_percent;

var q_black_work;
var q_semi_finished;
var q_fully_finished;
var defer_months;
var value_per_million = {{App\Order::getValuePerMillon()}};

console.log("ini");

document.getElementById("initial_installment_percent").addEventListener("keyup", updateInitialInstallments); 
document.getElementById("savings_black_work").addEventListener("keyup", updateInitialInstallments); 
document.getElementById("initial_installment_subsidy_black_work").addEventListener("keyup", updateInitialInstallments); 

document.getElementById("balance_subsidy_black_work").addEventListener("keyup", updateInitialInstallments); 





function updateInput(str){
	selector = "#"+str+"_black_work";
	value = getMoneyFormat(Number($(selector).val()));
	selector = "#"+str+"_semi_finished";
	$(selector).val(value);
	selector = "#"+str+"_fully_finished";
	$(selector).val(value);
}



function calcInitialInstallmentSubTotal(){
	down_payment = Number($('#down_payment_black_work').val());
	savings = Number($('#savings_black_work').val());
	subsidy = Number($('#initial_installment_subsidy_black_work').val());
	
	q_black_work.setInitialInstallment(down_payment, savings, subsidy);
	q_fully_finished.setInitialInstallment(down_payment, savings, subsidy);
	q_semi_finished.setInitialInstallment(down_payment, savings, subsidy);


	$('#subtotal_initial_installment_black_work').val(getMoneyFormat(q_black_work.subTotal));
	$('#subtotal_initial_installment_semi_finished').val(getMoneyFormat(q_semi_finished.subTotal));
	$('#subtotal_initial_installment_fully_finished').val(getMoneyFormat(q_fully_finished.subTotal));

	$('#monthly_initial_installment_black_work').val(getMoneyFormat(q_black_work.subTotal/defer_months));
	$('#monthly_initial_installment_semi_finished').val(getMoneyFormat(q_semi_finished.subTotal/defer_months));
	$('#monthly_initial_installment_fully_finished').val(getMoneyFormat(q_fully_finished.subTotal/defer_months));

}

function calcBalance(){
	balance_subsidy = Number($('#balance_subsidy_black_work').val());
	
	updateInput('balance_subsidy');

	q_black_work.setInitialInstallment(down_payment, savings, subsidy);
	q_fully_finished.setInitialInstallment(down_payment, savings, subsidy);
	q_semi_finished.setInitialInstallment(down_payment, savings, subsidy);


	q_black_work.balance_subsidy = balance_subsidy;
	q_fully_finished.balance_subsidy = balance_subsidy;
	q_semi_finished.balance_subsidy = balance_subsidy;
	

	$('#balance_black_work').val(getMoneyFormat(q_black_work.balance));
	$('#balance_semi_finished').val(getMoneyFormat(q_semi_finished.balance));
	$('#balance_fully_finished').val(getMoneyFormat(q_fully_finished.balance));

	$('#balance_installment_black_work').val(getMoneyFormat(q_black_work.montlyUVRInstallment));
	$('#balance_installment_semi_finished').val(getMoneyFormat(q_semi_finished.montlyUVRInstallment));
	$('#balance_installment_fully_finished').val(getMoneyFormat(q_fully_finished.montlyUVRInstallment));

	$('#monthly_installment_black_work').val(getMoneyFormat(q_black_work.montlyUVRInstallmentSubTotal));
	$('#monthly_installment_semi_finished').val(getMoneyFormat(q_semi_finished.montlyUVRInstallmentSubTotal));
	$('#monthly_installment_fully_finished').val(getMoneyFormat(q_fully_finished.montlyUVRInstallmentSubTotal));

	$('#income_black_work').val(getMoneyFormat(q_black_work.montlyUVRInstallmentIncome));
	$('#income_semi_finished').val(getMoneyFormat(q_semi_finished.montlyUVRInstallmentIncome));
	$('#income_fully_finished').val(getMoneyFormat(q_fully_finished.montlyUVRInstallmentIncome));
	

}


function calcInitialInstallment(){
	value = q_black_work.initialInstallment;
	
	$('#initial_installment_black_work').val(getMoneyFormat(value));
	$('#initial_installment_semi_finished').val(getMoneyFormat(q_semi_finished.initialInstallment));
	$('#initial_installment_fully_finished').val(getMoneyFormat(q_fully_finished.initialInstallment));
}


function updateInitialInstallments(){
	initial_installment_percent = Number($("#initial_installment_percent").val())/100;
	
	$("#initial_installment_percent_text").html(initial_installment_percent*100);
	//balance_percent_text
	
	$("#balance_percent_text").html((1-initial_installment_percent)*100);

	q_black_work.initial_installment_percent = initial_installment_percent;
	q_fully_finished.initial_installment_percent = initial_installment_percent;
	q_semi_finished.initial_installment_percent = initial_installment_percent;



	updateInput("down_payment");
	updateInput("savings");
	updateInput("initial_installment_subsidy");
	
	calcInitialInstallmentSubTotal();
	calcInitialInstallment();
	calcBalance();	
}

document.getElementById("down_payment_black_work").addEventListener("keyup", updateInitialInstallments);


function updateOptions(){
	// category id
	cid = $( "#category_id" ).val();
	
	delivery_date = categories[cid].delivery_date;
	$('#delivery_date').val(delivery_date);
	
	year = Number(delivery_date.substring(0,4));
	month = Number(delivery_date.substring(5,7))-1;
	day = Number(delivery_date.substring(8,10));

	delivery_date = new Date(year, month, day); // MM-dd-YYYY
	
	defer_months = monthDiff(today, delivery_date)-2;
	if(defer_months<=0)
		defer_months = 2;
	$('#defer_months').html(defer_months);
	// muestro todas las opciones
	$('.units').hide();
	$('.units[category_id*='+cid+']').show();

}
function updateCustomer(){
	cid = $( "#customer_id" ).val();
	console.log(cid);
	console.log(customers[cid]);
	
	$('#customer_phone').html(customers[cid].phone);
	$('#customer_email').html(customers[cid].email);

}

class Quote {
	
	initial_installment_percent;
	
	subsidy_initial_installment;
	subsidy_balance;
	down_payment;
	savings;

	constructor( apartment_price, parking_price, deposit_price, value_per_million) {
		this.apartment_price = apartment_price;
		this.parking_price = parking_price;
		this.deposit_price = deposit_price;
		this.down_payment = 0;
		this.savings = 0;
		this.subsidy_balance = 0;
		this.subsidy_initial_installment = 0;
		this.value_per_million = value_per_million;
	}
	// Propiedad Total
	calcTotal(){
		return this.apartment_price + this.parking_price + this.deposit_price;
	}

	get total(){
		return this.calcTotal();
	}

	// propiedad cuota inicial
	calcInitialInstallment(){
		//this.initial_installment_subtotal = this.total * this.initial_installment_percent;
		return this.total * this.initial_installment_percent;
	}

	get initialInstallment(){
		return this.calcInitialInstallment();
	}

	// propiedad cuota inicial
	calcBalance(){
		//this.initial_installment_subtotal = this.total * this.initial_installment_percent;
		return this.total * (1- this.initial_installment_percent);
	}

	get balance(){
		return this.calcBalance();
	}



		// propiedad cuota inicial
	calcSubTotal(){
		
		return this.calcInitialInstallment() - this.down_payment - this.savings - this.subsidy_initial_installment;
	}

	get subTotal(){
		return this.calcSubTotal()
	}
	
	// calcular pagos mensuales
	calcMontlyInitialInstallmentTotal(){

	}


	get montlyInitialInstallment(){
		return this.calcMontlyInitialInstallmentTotal()
	}

	setInitialInstallment(down_payment, savings, subsidy){
		this.down_payment = down_payment;
		this.savings = savings;
		this.subsidy_initial_installment = subsidy;
	}

		// propiedad cuota inicial
	calcMontlyUVRInstallment(){
		
		return this.calcBalance()*this.value_per_million;
	}

	get montlyUVRInstallment(){
		return this.calcMontlyUVRInstallment()
	}

		// propiedad cuota inicial
	calcMontlyUVRInstallmentSubTotal(){
		
		return this.calcMontlyUVRInstallment()-this.balance_subsidy;
	}

	get montlyUVRInstallmentSubTotal(){
		return this.calcMontlyUVRInstallmentSubTotal()
	}

		// propiedad cuota inicial
	calcMontlyUVRInstallmentIncome(){
		
		return this.calcMontlyUVRInstallment()*100/30;
	}

	get montlyUVRInstallmentIncome(){
		return this.calcMontlyUVRInstallmentIncome()
	}

}


function getMoneyFormat(str){
	return "$ " + Intl.NumberFormat("es-ES").format(Math.round(str));

}

function showValidDate(){
	var today = new Date();
	var validDate = new Date();
	validDate.setDate(today.getDate()+15);
	var month = ("0" + (validDate.getMonth() + 1)).slice(-2); 
	var date = ("0" + validDate.getDate()).slice(-2); 
	$("#valid_to").html(validDate.getFullYear()+"-"+month+'-'+date);
	console.log(validDate);
}

function gfg_Run() { 
                var a = new Date(); 
                var month = ("0" + (a.getMonth() + 1)).slice(-2); 
                var date = ("0" + a.getDate()).slice(-2); 
                el_down.innerHTML = "Date = " + date + ", Month = " + month; 
            }

$(document).ready(function(){
	showValidDate();
});

function showControl(str){
	$('#'+str+'_semi_finished').show();
	$('#'+str+'_fully_finished').show();
}

function hideControl(str){
	$('#'+str+'_semi_finished').hide();
	$('#'+str+'_fully_finished').hide();
}

function hideControls(){
	hideControl('price');
	hideControl('parking_price');
	hideControl('deposit_price');
	hideControl('down_payment');
	hideControl('savings');
	hideControl('initial_installment');
	hideControl('subtotal_initial');
	
	hideControl('total');
	
	hideControl('total_semi_price');
	hideControl('monthly_initial');
	hideControl('balance');
	hideControl('balance_installment');
	hideControl('deposit_price');

	hideControl('deposit_price');
	hideControl('balance_installment');
	hideControl('balance_subsidy');
	hideControl('monthly_installment');
	hideControl('income');
	hideControl('initial_installment_subsidy');
	hideControl('monthly_initial_installment');
	hideControl('subtotal_initial_installment');
	
}

function showControls(){
	showControl('price');
	showControl('parking_price');
	showControl('deposit_price');
	showControl('down_payment');
	showControl('savings');
	showControl('initial_installment');
	showControl('subtotal_initial');
	showControl('total');
	showControl('total_semi_price');
	showControl('monthly_initial');
	showControl('balance');
	showControl('balance_installment');
	showControl('deposit_price');

	showControl('deposit_price');
	showControl('balance_installment');
	showControl('balance_subsidy');
	showControl('monthly_installment');
	showControl('income');
	showControl('initial_installment_subsidy');
	showControl('monthly_initial_installment');
	showControl('subtotal_initial_installment');
	
}


function showPrice(){

	product = products[$( "#product_id" ).val()];

	

	price_black_work = Number(product.price_black_work);
	price_semi_finished = Number(product.price_semi_finished);
	console.log('semi'+price_semi_finished);
	price_fully_finished = Number(product.price_fully_finished);

	parking_price = getParkingPrice();
	deposit_price = getDepositPrice();

	q_black_work = new Quote(price_black_work, parking_price, deposit_price, value_per_million);
	q_semi_finished = new Quote(price_semi_finished, parking_price, deposit_price, value_per_million);
	q_fully_finished = new Quote(price_fully_finished, parking_price, deposit_price, value_per_million);
	if(price_semi_finished==0){
		hideControls();
	}else{
		showControls();
	}



	
	$('#price_black_work').val( getMoneyFormat(product.price_black_work) );
	$('#price_semi_finished').val( getMoneyFormat(product.price_semi_finished) );
	$('#price_fully_finished').val( getMoneyFormat(product.price_fully_finished) );

	$('#price_black_work_text').val( product.price_black_work );
	$('#price_semi_finished_text').val( product.price_semi_finished);
	$('#price_fully_finished_text').val( product.price_fully_finished );


	$('#total_black_work').val( getMoneyFormat(q_black_work.total) );
	$('#total_semi_finished').val( getMoneyFormat(q_semi_finished.total) );
	$('#total_fully_finished').val( getMoneyFormat(q_fully_finished.total) );


	$('#location').val( product.location );
	$('#built_area').val( product.built_area );
	$('#private_area').val( product.private_area );
	if(product.type!="")
		{
			$('#type').attr("src", "https://trujillo.quirky.com.co/public/product_types/" + product.type );
			$('#type').show();
		}
	else
		$('#type').hide();
	$('#notes').val( product.notes );


	updateInitialInstallments();

}

function showSubtotal() {
	var apto = document.getElementById("").value;
	var park = document.getElementById("parking_price").value;
	var depo = document.getElementById("deposit_price").value;
	var subtotal = apto + park + depo;
	

	$('#subtotal').val( "$ " +subtotal);
}

function getParkingPrice(){
	parkingPrice = 0;
	if(!isNaN( Number(parkings[$( "#parking_id" ).val()])))
		parkingPrice = Number(parkings[$( "#parking_id" ).val()]);
	
	return parkingPrice;
}

function getDepositPrice(){
	depositPrice = 0;
	if(!isNaN( Number(deposits[$( "#deposit_id" ).val()])))
		depositPrice = Number(deposits[$( "#deposit_id" ).val()]);
	
	return depositPrice;
}
function showParkingPrice() {
	price = getParkingPrice();
	$('.parking_price').val( "$ " + new Intl.NumberFormat("es-ES").format(price));
	$('#parking_price').val( price );


	showPrice();
}

function showDepositPrice() {
	price = deposits[$( "#deposit_id" ).val()];
	
	$('.deposit_price').val( "$ " +new Intl.NumberFormat("es-ES").format(price));
	$('#deposit_price').val( price);


	showPrice();
}

function monthDiff(dateFrom, dateTo) {
 return dateTo.getMonth() - dateFrom.getMonth() + 
   (12 * (dateTo.getFullYear() - dateFrom.getFullYear()))
}

function addDays(date, days) {
  var result = new Date(date);
  result.setDate(result.getDate() + days);
  return result;
}

</script>