<!DOCTYPE html>
<html>
<head>

<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo $meta_title ?></title>
<meta name="keywords" content="<?php echo $meta_keywords ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo $INC_header_script_top ?>
</head>

<body class="screenlock-page">
<div id="main">
<div class="container" style="width:870px; ">
<div class="row" style="padding:150px 0 0 0;">
    
    	<div class="col-md-5"> 
    <a href="<?php echo CUSTOMER_SURL?>"><img src="<?php echo IMG?>customer-login.png" class="img-responsive"></a>

    </div> 
     	<div class="col-md-2" style="margin-top:60px;">
    <img src="<?php echo IMG?>middle-logo.png" class="img-responsive">
    </div> 
     	<div class="col-md-5"> 
         <a href="<?php echo ADMIN_SURL?>"><img src="<?php echo IMG?>employeer-login.png" class="img-responsive"></a>
     </div> 

  	</div>
    
</div>
<?php echo $INC_header_script_footer; ?> 

</body>
</html>
