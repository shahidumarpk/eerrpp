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
<header class="navbar navbar-fixed-top"> <?php echo $INC_top_header; ?> </header>
<!-- End: Header --> 
<!-- Start: Main -->
<div id="main"> 
  <!-- Start: Sidebar --> 
  <?php echo $INC_left_nav_panel; ?> 
  <!-- End: Sidebar --> 
  <!-- Start: Content -->
  <section id="content"> <?php echo $INC_breadcrum?>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div id="console-btns">
          
          <?php echo stripcslashes($page_arr['page_long_desc']); ?>
            
            <div class="row">
              <div class="col-sm-12" id="ticket_response">
                
              </div>
            </div>
           
          </div>
        </div>
      </div>
      
      
      <div class="row" style="min-height:350px;">&nbsp;</div>
    </div>
  </section>
  <!-- End: Content --> 
  
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer style="margin-top: 270px;"> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
<script language="javascript">
function fetch_tickets(){
 document.getElementById('ticket_response').innerHTML = "<img class='loading' src='<?php echo IMG ; ?>ajax-loader.gif' alt='loading...' /><br>Please wait .....";

 var request_url = "<?php echo MURL ; ?>cron_email_reader.php";
 jQuery.post(
  request_url, {flag : true}, function(responseText){
	 
  	if(responseText == '0'){
		responseText = '<div class="alert alert-info">No Ticket(s) found</div>';
  		jQuery("#ticket_response").html(responseText);  
  	}else{
  		responseText = '<div class="alert alert-success alert-dismissable">'+responseText+' Ticket(s) fetched successfully</div>';
  		jQuery("#ticket_response").html(responseText);
  	}
  }, "html"
 );
}//end check_nic_exist
</script>
</body>
</html>
