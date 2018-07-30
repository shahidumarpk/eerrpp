<?php 
$session_post_data = $this->session->userdata('add-page-data');
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
        <div class="col-md-12" style="min-height:1280px;">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span>Withdrawal Amount</div>
              
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>banks/manage-banks/add-cash-out-process" enctype="multipart/form-data">
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
                    
                   
                    
                      
                       <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Select Bank Account</label>
                            <span id="city_response">
                            	<select style="width:100%;"  id="cash_account" name="cash_account" required>
                                <option value="">Select Account </option>
                                <?php 
									for($i=0;$i<$banks_count;$i++){
								?>
									<option value="<?php echo $banks_arr[$i]['id']?>"> <?php echo $banks_arr[$i]['acc_title'] .' - '. $banks_arr[$i]['acc_number'] .' - '. $banks_arr[$i]['bank_name'] .' - '. $banks_arr[$i]['bank_branch']?></option>
                              <?php } ?>
                        		</select>
                        	</span>
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
                               <div class="col-xs-6" id="todate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="transaction_date" id="start_date" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                          </div>
                          </div>
                             
                         </div>
                      </div>
                      
                      
                      
                       <div class="form-group">
                        <label for="title">Amount</label>
                        <input type="number" name="amount" id="amount"  class="form-control" required>
                      </div>
                      
                      
                       <div class="form-group">
                        <label for="title">Description</label>
                        <textarea class="form-control" id="detail" name="detail" rows="3" ></textarea>
                      </div>
                       
                     
                      
                      
                       
                      
                   
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="cashout" id="cashout" value="Add Withdrawal" title="Click to withdrawal" />
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
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>
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
$(document).ready(function() { $("#cash_account").select2(); });
</script>
<script>
$(document).ready(function() { $("#city_holders").select2(); });
</script>
<script>
$(document).ready(function() { $("#forum_id").select2(); });
</script>


    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#edit_admin_profile_frm").validate({
            rules: {
				first_name : 'required',
				last_name : 'required',
                project_detail: "required",
				username: {
					required: true,
					minlength: 5,
					 maxlength: 20
				},
				email_address: {
					required: false,
					email: true
				},
				prof_image: {
					required: false,
					extension: "jpg|jpeg|gif|tiff|png"
				}				
				
            },
            messages: {
                project_detail: "This field is required.",
				last_name : "This field is required.",
                display_name: "This field is required.",
				prof_image : "Please select valid image for your profile (Use: jpg, jpeg, gif, tiff, png)",
				username: {
					required: "This field is required.",
					minlength: "Your Username must consist of at least 5 characters",
					maxlength: "Your Username cannot me more than 20 characters"
				},
				email_address: "Enter your valid email address",
            }
        });
    
    });
    </script>
<script type='text/javascript'>
        var rowNum = 0;
function add_layer_html(frm) {
 rowNum ++;
 var row = '<div id="rowNum'+rowNum+'"><div class="form-group"><label for="page_title">Attachments </label><input type="file" id="attachments" name="attachments[]"></div><input type="button" class="btn btn-danger" value="Remove" onclick="removeRow('+rowNum+');" style="margin-left:15px;"><div class="clearfix">&nbsp;</div><div class="clearfix">&nbsp;</div></div></div>';
 jQuery('#item').append(row);
}

function removeRow(rnum) {
 jQuery('#rowNum'+rnum).remove();
}

</script>    
    <script>
$('#popup').click(function(event) {
    event.preventDefault();
    window.open($(this).attr("href"), "popupWindow", "width=730,height=550,scrollbars=no");
});

</script>

</body>
</html>