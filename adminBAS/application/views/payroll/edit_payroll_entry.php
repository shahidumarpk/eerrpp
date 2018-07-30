
<?php 
$session_post_data = $this->session->userdata('add-page-data');

//print_r($_GET['type']);
//exit;
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

 <link rel="stylesheet" href="docsupport/style.css">
  <link rel="stylesheet" href="<?php echo SURL; ?>assets/css/chosen.css">

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
        <div class="col-md-12" style="min-height:1300px;">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit PayRoll Entry</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_payroll_frm" method="POST" action="<?php echo SURL?>payroll/manage_payrolls/edit_payroll_entry_process" enctype="multipart/form-data">
                <div class="tab-content border-none padding-none">
                  <div id="cms_main_contents" class="tab-pane active">
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
                    <div class="col-md-4" style="">
                          <label for="standard-list1">Select User</label>
                          
                         <select name="user_name" id="user_name" data-placeholder="Choose a name..." class="chosen-select"  style="" tabindex="4" >
            <option value=""></option>
            
            <?php  for($i=0; $i<$admin_user_count; $i++) {
				$selected = 0;
				 if($admin_user_arr[$i]['id']  == $payroll_arr['user_id'] ){
				$selected = 'selected="selected"';
}?>
            
            <option
            
            
            
             <?php echo $selected; ?> value="<?php echo $admin_user_arr[$i]['id'] ?>"><?php echo $admin_user_arr[$i]['first_name']." ".$admin_user_arr[$i]['last_name']." (".$admin_user_arr[$i]['short_name'].")"; ?></option>
            
            <?php } ?>
          </select>   
	                     </div>
                         </div>
                   </div>
                   
                   </div>
                   <div class="row form-group">
                              
                              <div class="row">
                              <div class="col-md-6">
                                <label class="col-md-1">Date</label>
                              </div>
                               </div>
                              
                              <div class="row">
                               <div class="col-md-6">
                               <div class="col-lg-6" id="todate">
            <div class="input-group"><input type="text" readonly style="cursor:pointer;" 
           name="transaction_date" id="transaction_date" class="form-control" value="<?php 
		   echo date("m/d/Y", strtotime($payroll_arr['transaction_date'])); ?>" />
           <span class="input-group-addon">
           <span id="targetto" onclick="create_date('todate')" 
           class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                          </div>
                          </div>
                             
                         </div>
                     <div class="form-group">
                        <label for="title">Amount</label>
                        <input type="text" name="amount" id="amount"  class="form-control" value=<?php echo stripslashes($payroll_arr['amount']) ?>>
                      </div>
                      
                      
                       <div class= "form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control"  name="description"  id="description" rows="3" ><?php echo stripslashes($payroll_arr['description']) ?></textarea>
                      </div>
                     
                       <div class="row form-group">
                       <div class="col-md-5">
                        <label for="standard-list1">Transaction Status</label>
                         <select class="form-control" name="status" id="status_id"  >
            <option value="relaxation" <?php ($payroll['transaction_status'] == 'relaxation') ? 'selected' : '' ?>>
            Relaxation</option>
            <option value="confirm" <?php echo ($payroll_arr['transaction_status'] == 'confirm') ? 'selected' : ''?>>Confirm</option>
            <option value="cancel" <?php echo ($payroll_arr['transaction_status'] == 'cancel') ? 'selected' : ''?>>Cancel</option>
           
          </select>          </div>
        
          </div>
                            <div class="row form-group">
                        <div class="col-md-5">
                        <label for="standard-list1">Transaction Type</label>
                         <select class="form-control" name="type" id="type_id"  >
       
                        
           
       
                
                           <option value="fine" <?php echo ($payroll_arr['transaction_type'] == 'fine') ? 'selected' : ''?>>Fine</option>
       
                           <option value="incentive" <?php echo ($payroll_arr['transaction_type'] == 'incentive') ? 'selected' : ''?>>Incentive</option>
       
              
            <option value="tardy" <?php echo ($payroll_arr['transaction_type'] == 'tardy') ? 'selected' : ''?> >Tardy</option>
       
            
       
            
           
          </select>
                   
                    </div>
                             </div>                     
                  </div>
                  
                 
                   <input type="hidden" name="t_id" value="<?php echo $payroll_arr['transaction_id'] ?>" >
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="update_PayRoll" id="update_PayRoll" value=" Update Payroll" title="Click to Update Edited PayRoll" />
                    </div>
                </div>
                
              </form>
            </div>            
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End: Content --> 
  
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> <?php echo $INC_header_script_footer;?>
<script src="<?php echo SURL; ?>assets/js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>


<link href="<?php echo CSS ;?>select2.css" rel="stylesheet"/>
<script src="<?php echo JS ; ?>select2.js"></script>
<script>
$(document).ready(function() { $("#todate").select2(); });
</script>
<!--
<script>
$(document).ready(function() { $("#city_holders").select2(); });
</script>
<script>
$(document).ready(function() { $("#forum_id").select2(); });
</script>-->



<script type='text/javascript'>
        var rowNum = 0;
function add_layer_html(frm) {
 rowNum ++;
 var row = '<div id="rowNum'+rowNum+'"><div class="form-group">
 <label for="page_title">Attachments </label><input type="file" id="attachments" name="attachments[]"></div><input type="button" class="btn btn-danger" value="Remove" onclick="removeRow('+rowNum+');" style="margin-left:15px;"><div class="clearfix">&nbsp;</div><div class="clearfix">&nbsp;</div></div></div>';
 jQuery('#item').append(row);
}

function removeRow(rnum) {
 jQuery('#rowNum'+rnum).remove();
}

</script>    
   

</body>
</html>