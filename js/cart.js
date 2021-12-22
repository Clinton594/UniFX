function snackbar11(mess, timeout){
  var x = document.getElementById("snackbar");
    x.innerHTML = mess;
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, timeout);
}

$(document).ready(function(){

var quantitiy=0;
   $('.quantity-right-plus-money').click(function(e){
        
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());
        
        // If is not undefined
            
            $('#quantity').val(quantity + 1);

          
            // Increment
        
    });

     $('.quantity-left-minus-money').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());
        
        // If is not undefined
      
            // Increment
            if(quantity>0){
            $('#quantity').val(quantity - 1);
            }
    });

   $('.quantity-right-plus').click(function(e){
       
        var quantity1 = parseInt($('#quantity1').val());
        //console.log(quantity1);
        var answer = quantity1 + 1;
        //console.log(answer)
        $('#quantity1').val(answer);
    });

     $('.quantity-left-minus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity1 = parseInt($('#quantity1').val());
            if(quantity1>0){
            $('#quantity1').val(quantity1 - 1);
            }
    });
});
function add_to_cart(prod){
var error = '';
//var product_available = jQuery('#product_available'+ prod).val();
var qty = parseInt(jQuery('#number'+ prod).val());
if (qty == '') {
	qty = 1;
}
$.ajax({
url:"update_quantity.php",
method:"post",
cache:false,
dataType:"json",
data:{addtoCart:1,prod:prod,qty:qty},
success:function (data) {
if ($.trim(data['status'])=="ok") {
	var name = "myShoppingCart";
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    var id = data['id'];
    $('<li class="header-cart-item flex-w flex-t m-b-12"><div class="header-cart-item-img"><img src="'+data['pic']+'" alt="IMG"></div><div class="header-cart-item-txt p-t-8"><a href="product-detail.php?id='+data['id']+'" class="header-cart-item-name m-b-18 hov-cl1 trans-04">'+data['desc']+'</a><span class="header-cart-item-info" id="genimg'+data['id']+'">'+data['qty']+' x &#8358;'+data['price']+'</span></div></li>').prependTo($('#cartitems'));
	//console.log(data);
	//console.log(data['total']);
	console.log(data);
	var total = data['total'];
	$('#totalcart').html("Total: "+"&#8358;"+ total);
  if (match){
  	var val = JSON.parse(decodeURIComponent(match[2]));
  	$('#cartnotifier').html(val.length);
  	$('#cartnotifier1').html(val.length);
  }else{
  	$('#cartnotifier').html('0');
  	$('#cartnotifier1').html('0');
  }
}else{
console.log(data);
//$('#total').html(data['total'] + parseInt(data['price']));
var total = data['total'];
	$('#totalcart').html("Total: "+"&#8358;"+ total);
$('#genimg'+data['id']).html("Total: "+parseInt(data['qty'])+' x '+data['price']);
 swal(data['desc'], " is added to cart!", "success");
 //console.log(data);
}
}
});
}

function removecart(prod){
	$.ajax({url:"update_quantity.php",
		method:"post",
		data:{removefromcart:1,prod:prod},
		success:function (data) {
		if ($.trim(data)=="ok") {setTimeout(function () {location.reload();},1000);
	}else{snackbar1(data);}}});
}

function btn_to_cart(prod){
var error = '';
//var product_available = jQuery('#product_available'+ prod).val();
var qty = parseInt(jQuery('#number'+ prod).val());
if (qty == '') {
	qty = 1;
}
$.ajax({
url:"update_quantity.php",
method:"post",
cache:false,
dataType:"json",
data:{addtoCart:1,prod:prod,qty:qty},
success:function (data) {
if ($.trim(data['status'])=="ok") {
	 setTimeout(function(){window.location.replace('shoping-cart');}, 1000);
}else{
	 setTimeout(function(){window.location.replace('shoping-cart');}, 1000);
}
}
});
}



function emptycart(){
	document.cookie = "myShoppingCart=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	window.location.reload(); 
}

function changeqty(mode,id, price){
	var number = $('#number'+id).val();
	var qty = (mode == 'removeone')? parseInt(number)-1: parseInt(number) + 1;
	var total = qty * parseInt(price);
	$.ajax({
		url:"update_quantity.php",method:"post",data:{changeqty:1,id:id,qty:qty},
		success:function (data) {
			if ($.trim(data)=="ok") {
				$('#total'+id).html('&#8358;'+total+'.00');
			}
		}
	});
}
function reload(){
	window.location.reload();
}

function setadd(id) {
	var check = id;
	var date = new Date();
    date.setTime(date.getTime() + (30*24*60*60*1000));
    expires = "; expires=" + date.toUTCString();
	document.cookie = "package="+check+", "+expires+";path=/";
	var message = check + ' selected';
	snackbar1(message, 1000);
}

function send_to_pay() {
	var name = "address";
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
	if (match){
		snackbar1('please wait while we process your payment...', 10000)
		setTimeout(function(){window.location.replace('parsers/initialize2.php');}, 2000);
	}else{
		 swal("oops!!!", "You need to provide a billing address", "error");
	}
}