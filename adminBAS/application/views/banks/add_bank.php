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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Bank </div>
              
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>banks/manage-banks/add-bank-process" enctype="multipart/form-data">
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
                          <label for="standard-list1">Branch Name</label>
                           <select id="branch" name="branch_id" style="width:100%;" required>
                           <option value="">Select Branch Name</option>
                                <?php
								if($branches_count>0){ 
								for($c=0; $c < $branches_count ; $c++){ ?>
										<option value="<?php echo $branches_arr[$c]['id'] ?>"><?php echo $branches_arr[$c]['branch_name'];?></option>
								<?php }} ?>
                          </select>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label for="title">Account Title</label>
                        <input type="text" name="acc_title" id="acc_title"  class="form-control" required>
                      </div>
                      
                      
                       <div class="form-group">
                        <label for="title">Account Number</label>
                        <input type="text" name="acc_number" id="acc_number"  class="form-control" required>
                      </div>
                      
                      
                      
                      <div class="form-group">
                        <label for="title">Bank Name</label>
                        <input type="text" name="bank_name" id="bank_name"  class="form-control" required>
                      </div>
                      
                      <div class="form-group">
                        <label for="title">Bank Branch</label>
                        <input type="text" name="bank_branch" id="bank_branch"  class="form-control" required>
                      </div>
                      
                      <div class="form-group">
                        <label for="title">Bank Phone # 1</label>
                        <input type="text" name="phone_1" id="phone_1"  class="form-control" >
                      </div>
                      
                      <div class="form-group">
                        <label for="title">Bank Phone # 2</label>
                        <input type="text" name="phone_2" id="phone_2"  class="form-control" >
                      </div>
                      
                      <div class="form-group">
                        <label for="title">Manager Phone #</label>
                        <input type="text" name="manager_phone" id="manager_phone"  class="form-control" required>
                      </div>
                      
                      <div class="form-group">
                        <label for="title">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" ></textarea>
                      </div>
                      
                     
                     <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">City</label>
                            <span id="city_response">
                            	<select style="width:100%;"  id="city" name="city" required>
                                <option>Select City </option>
                                <?php 
									for($i=0;$i<$cities_count;$i++){
								?>
									<option value="<?php echo $cities_arr[$i]['name']?>"> <?php echo $cities_arr[$i]['name']?></option>
                              <?php } ?>
                        		</select>
                        	</span>
                        </div>
                    </div>
                     
                     
                      
                      
                      
                      
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" selected >Active</option>
                            <option value="0">InActive</option>
                        </select>
                        </div>
                    </div>                      
                  </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="add_branch" id="add_branch" value="Add Bank" title="Click to Add Bank" />
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
$(document).ready(function() { $("#vendor").select2(); });
</script>
<script>
$(document).ready(function() { $("#city").select2(); });
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
$(document).ready(function() { $("#branch").select2(); });
</script>
</body>
</html>
