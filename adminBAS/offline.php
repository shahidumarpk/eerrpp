<?php
define('DEFAULT_TITLE','Welcome to BirAlSabia Admin Panel');
define('DEFAULT_META_KEYWORDS','Default Meta Keywords');
define('DEFAULT_META_DESCRIPTION','default Meta Description');

define('SITE_NAME','Inno Tech');
define('MURL','http://'.$_SERVER['HTTP_HOST'].'/erp/');
define('SURL','http://'.$_SERVER['HTTP_HOST'].'/erp/adminBAS/');
define('FRONT_SURL','http://'.$_SERVER['HTTP_HOST'].'erp/');

define('IMG',SURL.'assets/img/');
define('CSS',SURL.'assets/css/');
define('FONTS',SURL.'assets/fonts/');
define('JS',SURL.'assets/js/');
define('VENDOR',SURL.'assets/vendor/');
define('AJAX',SURL.'assets/ajax/');
define('USER_FOLDER',SURL.'assets/user_files/');
define('CUSTOMER_FOLDER',SURL.'../assets/customer_files');
define('ATTACHMENT',SURL.'../attachments/');
define('SLIDER_IMAGES',SURL.'../assets/slider.images/');
define('SIMPLE_SLIDER_IMAGES',SURL.'../assets/slider2.images/');

define('TREE',SURL.'assets/');

error_reporting(0)

?><!DOCTYPE html>
<html>
<head>

<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title>Welcome to BirAlSabia Admin Panel</title>
<meta name="keywords" content="" />
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php //echo $INC_header_script_top 

include('application/views/common/script_header.php');
include('application/views/common/script_footer.php');
;?>
</head>

<body class="screenlock-page">
<div id="main">
  <div class="container">
    <div class="row">
      <div id="page-logo"> <img src="<?php echo IMG?>logo-login.png" class="img-responsive" alt="logo"> </div>
    </div>
    <div class="row">
      <div class="panel" style="min-height:364px;">
        <div class="panel-heading">
          <div class="panel-title"> <span class="glyphicon glyphicon-lock"></span> ERP Offline - Under Maintenance
          
        
          
           </div>
        </div>
       
      
    	<div class="col-md-12" style="text-align:c" align="center">
        <br>
        <div style="font-size:16px; font-weight:bold">Yes, you are in the right place. <br>

        We are not. We are trying to get there soon. Thankyou</div>
        <br><br>
        <img src="<?php echo IMG?>under_maintenance.gif">
        <br><br>
        </div>	  
      
    
      </div>
    </div>
  </div>
</div>
<?php echo $INC_header_script_footer; ?> 

</body>
</html>
