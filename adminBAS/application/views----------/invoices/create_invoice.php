<?php 
$session_post_data = $this->session->userdata('add-user-data');
?>
<!DOCTYPE html>
<html>
<head>
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo $meta_title ?></title>
<meta name="keywords" content="<?php echo $meta_keywords ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo $INC_header_script_top; ?>
</head>
<body>
<!-- Start: Header -->
<header class="navbar navbar-fixed-top"><?php echo $INC_top_header; ?></header>
<!-- End: Header --> 
<!-- Start: Main -->
<div id="main"> 
  <!-- Start: Sidebar --> 
  <?php echo $INC_left_nav_panel;  ?> 
  <!-- End: Sidebar --> 
  <!-- Start: Content -->
  <section id="content"> <?php echo $INC_breadcrum?>
    <div class="container">
     <form class="cmxform" id="frm_create_invoice" method="POST" action="<?php echo SURL?>invoices/manage-invoices/create_invoice_process" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <div class="panel-title"> <span class="glyphicon glyphicons-adress_book"></span> Invoice</div>
                      <div class="pull-right">Date: <?php echo date('d F,Y');?> </div>
                    </div>
                    <div class="panel-body">
                     <?php
                        if($this->session->flashdata('err_message')){
                    ?>
                            <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
                    <?php
                        }//end if($this->session->flashdata('err_message'))
                        
                        if($this->session->flashdata('ok_message')){
                    ?>
                            <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
                    <?php 
                        }//if($this->session->flashdata('ok_message'))
                    ?>
                    <div class="row">
                    	<div class="col-md-6">
                        	<div class="row form-group">
                              <label class="col-md-4 text-right">Customer Name </label>
                              <div class="col-xs-4">
                                <div class="input-group"> 
                                 <select id="e1" name="customer_id" style="width:100%;">
                                <?php 
								for($c=0; $c < $customers_list_count ; $c++){ ?>
										<option value="<?php echo $customers_list_arr[$c]['id'] ?>"><?php echo $customers_list_arr[$c]['first_name'].' '.$customers_list_arr[$c]['last_name'] ; ?></option>
								<?php } ?>
                                </select>
	                        </div>
                            </div>
                             
                            </div>
                        </div>
                        <div class="col-md-6">
                        	<div class="row form-group">
                            &nbsp;
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                    	<div class="col-md-6">
                        	<div class="row form-group">
                              <label class="col-md-4 text-right">To</label>
                              <div class="col-xs-4">
                                <div class="input-group" id="fromdate">
                            	<input type="text" readonly="readonly" style="cursor:pointer;" name="invoice_to" id="invoice_to" class="form-control" required /><span class="input-group-addon"><span id="target" onclick="create_date('fromdate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                              
                              
                             
                              
                             
                            </div>
                        </div>
                        <div class="col-md-6">
                        	<div class="row form-group">
                              <label class="col-md-4 text-right">From</label>
                              <div class="col-xs-4" id="todate">
                                   <div class="input-group"><input type="text" readonly="readonly" style="cursor:pointer;" name="invoice_from" id="invoice_from" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                             
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="row">
                    	<div class="col-md-2">
                        	<div class="form-group">
                              <label for="Item-Name">Item</label>
                              <input id="item_name" name="item_name[]" type="text" class="form-control" placeholder="Item Name" required="">
                            </div>
                        </div>
                        <div class="col-md-4">
                        	<div class="form-group">
                              <label for="firstname">Description</label>
                              <input id="descrp" name="descrp[]" type="text" class="form-control" placeholder="Description" required="">
                            </div>
                        </div>
                        <div class="col-md-2">
                        	<div class="form-group">
                              <label for="Unit">Unit Price</label>
                              <input id="unit_price0" name="unit_price[]" type="text" class="form-control" placeholder="Unit Price" required="">
                            </div>
                        </div>
                        <div class="col-md-1">
                        	<div class="form-group">
                              <label for="Quantity">Quantity</label>
                              <input id="qty0" name="quantity[]" type="text" class="form-control" placeholder="QTY" required="" onBlur="calculate_total(document.getElementById('unit_price0').value , document.getElementById('qty0').value,'row-total0',1);">
                            </div>
                        </div>
                        <div class="col-md-2">
                        	<div class="form-group">
                              <label for="firstname">Total</label>
                              <input id="row-total0" name="row-total[]" type="text" class="form-control" placeholder="Total" required="">
                            </div>
                        </div>
                        <div class="col-md-1">
                        	&nbsp;
                        </div>
                        
                    </div>
                    <div id="itemRows"></div> 
                    <div class="clearfix">&nbsp;</div>
                    <div class="row">
                    <div class="col-md-2">
                        	<div class="form-group">
                              <input class="form-control submit btn btn-blue" type="button" value="Add More" onClick="addRow(this.form);">
                             </div>
                        </div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                     <div class="col-md-7">
                            <div class="row">
  <div class="col-xs-4">
    <div class="invoicetitle boldm">Enter Coupon Number :</div>
    <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Enter Coupon Code"><br>
<span style="font-weight:bold; color:#F00;" id="coupon_response"></span>
  </div>
   <div class="col-xs-2">
      <div class="invoicetitle boldm">&nbsp;</div>
     <input class="form-control submit btn btn-blue" type="button" value="Apply" onClick="is_coupon_valid(document.getElementById('coupon_code').value );">
  </div>
   <div class="col-xs-6">
   &nbsp;
  </div>
  
</div>
                     </div>
                     <div class="col-md-5">
                     	<div class="row">
                        	<div class="col-md-6">
                            <div class="invoicetitle boldm">Sub Total(USD): </div>
                            </div>
                           <div class="row">
                        	<div class="col-md-6">
                            <div class="row">	
                                	<div class="col-xs-8">
    									<input type="text" class="form-control" id="sub-total" name="sub_total" readonly>
  									</div>
  								</div>
                            </div>
                        </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                        <div class="row">
                        	<div class="col-md-6">
                            <div class="invoicetitle boldm">Discount(%):</div>
                            </div>
                           <div class="row">
                        	<div class="col-md-6">
                            <div class="row">	
                                	<div class="col-xs-8">
    									<input type="text" class="form-control" id="discount" name="discount" value="0" onBlur="calculate_grand_total();" >
  									</div>
  								</div>
                            </div>
                        </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                        <div class="row">
                        	<div class="col-md-6">
                            <div class="invoicetitle boldm">Tax(%):</div>
                            </div>
                           <div class="row">
                        	<div class="col-md-6">
                            <div class="row">	
                                	<div class="col-xs-8">
    									<input type="text" class="form-control" id="tax" name="tax" value="0" onBlur="calculate_grand_total();">
  									</div>
  								</div>
                            </div>
                        </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                        <div class="row">
                        	<div class="col-md-6">
                            <div class="invoicetitle boldm">Grant Total(USD):</div>
                            </div>
                           <div class="row">
                        	<div class="col-md-6">
                            <div class="row">	
                                	<div class="col-xs-8">
    									<input type="text" class="form-control" id="g_total" name="grand_total" readonly>
  									</div>
  								</div>
                            </div>
                        </div>
                        </div>
                     </div>
                     <div class="clearfix">&nbsp;</div>
                     <div class="pull-right" style="margin-top:20px;">
                     	<div class="row">
                        	<div class="col-md-6">
                             <input class="submit btn btn-blue2" name="create_invoice_sbt" id="create_invoice_sbt" type="submit" value="Save" >
                            </div>
                            <div class="col-md-6">
                             <input class="submit btn btn-green"  name="create_invoice_sbt" id="create_invoice_sbt" type="submit" value="Send">
                            </div>
                        </div>
                     </div>
                     
                  </div>
                </div>
              </div>
        </div>
      </form>  
    </div>
  </section>
  <!-- End: Content --> 
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
<link href="<?php echo CSS ;?>select2.css" rel="stylesheet"/>
<script src="<?php echo JS ; ?>select2.js"></script>

 <script>
$(document).ready(function() { $("#e1").select2(); });
</script>
<script type='text/javascript'>
        var rowNum = 0;
function addRow(frm) {
	rowNum ++;
	counter = rowNum + 1 ;
	var row = '<div id="rowNum'+rowNum+'"><div class="row"><div class="col-md-2"><div class="form-group"><input id="item_name" name="item_name[]" type="text" class="form-control" placeholder="Item Name" required=""></div></div><div class="col-md-4"><div class="form-group"><input id="firstname" name="descrp[]" type="text" class="form-control" placeholder="Description" required=""></div></div><div class="col-md-2"><div class="form-group"><input id="unit_price'+rowNum+'" name="unit_price[]" type="text" class="form-control" placeholder="Unit Price" required=""></div></div><div class="col-md-1"><div class="form-group"><input id="qty'+rowNum+'" name="quantity[]" type="text" class="form-control" placeholder="QTY" required="" onBlur="calculate_total(document.getElementById(\'unit_price'+rowNum+'\').value,document.getElementById(\'qty'+rowNum+'\').value,\'row-total'+rowNum+'\','+counter+');"></div></div><div class="col-md-2"><div class="form-group"><input id="row-total'+rowNum+'" name="row-total[]" type="text" class="form-control" placeholder="Total" required=""></div></div><div class="col-md-1"><div class="form-group"><input type="button" class="btn btn-danger" value="X" title="Remove" onclick="removeRow('+rowNum+');" ></div></div></div></div>';
	jQuery('#itemRows').append(row);
}

function removeRow(rnum) {
	jQuery('#rowNum'+rnum).remove();
}

function calculate_total(unit_price,qty,divid,counter){
			//alert(unit_price+'======'+qty+'======'+divid);
			var row_amount = Math.round(unit_price * qty );
			document.getElementById(divid).value = row_amount ; 
			var subtotal = 0 ; 
			//if(counter > 0 ){
				for (var i = 0; i < counter; i++)
				{
						var subtotal = subtotal + document.getElementById('unit_price'+i).value * document.getElementById('qty'+i).value  ; 
				}
			document.getElementById('sub-total').value =  subtotal;
			//Discount Amount
			var discount = (subtotal)*(document.getElementById('discount').value / 100) ;      
			//Tax Amount
			var tax = (subtotal)*(document.getElementById('tax').value / 100);
			grand_total  = (subtotal - discount) + tax;
			document.getElementById('g_total').value = grand_total ;
			//sub-total
			//discount
			//tax
			//g_total
}

function calculate_grand_total(){
	subtotal = document.getElementById('sub-total').value ;
	//Discount Amount
	var discount = (subtotal)*(document.getElementById('discount').value / 100) ;      
	//Tax Amount
	var tax = (subtotal)*(document.getElementById('tax').value / 100);
	grand_total  = (subtotal - discount) + tax;
	document.getElementById('g_total').value = grand_total ;
}



function is_coupon_valid(coupon_code){

 //var ajax_loader = "<img class='loading' src='"+base_url+"application/views/assets/images/ajax-loader.gif' alt='loading...' />";
 var request_url = "<?php echo SURL ; ?>coupons/manage_coupons/is_coupon_valid/"+coupon_code;
 jQuery.post(
  request_url, {flag : true}, function(responseText){
	
	var split_response = responseText.split('|');
	//alert(split_response[0]+=====+split_response[1]);
   if(split_response[0] != ''){
	   
	jQuery("#coupon_response").html(split_response[0]);
   
   }else{
   jQuery("#coupon_response").html('');
   }
 	jQuery('#discount').val(split_response[1]);
 	
	subtotal = document.getElementById('sub-total').value ;
	//Discount Amount
	var discount = (subtotal)*(document.getElementById('discount').value / 100) ;      
	//Tax Amount
	var tax = (subtotal)*(document.getElementById('tax').value / 100);
	grand_total  = (subtotal - discount) + tax;
	document.getElementById('g_total').value = grand_total ;
  }, "html"
 );
}//end check_nic_exist
</script>    
</body>
</html>
