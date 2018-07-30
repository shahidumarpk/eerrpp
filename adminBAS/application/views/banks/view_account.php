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
        <div class="col-md-12" style="min-height:1300px;">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> View Detail </div>
              
            </div>
            <div class="panel-body alerts-panel">
              <div class="row">
                    
                    <div class="col-xs-12">
                    <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td><strong>Title:</strong></td>
                              <td><?php echo $banks_arr['acc_title']; ?></td>
                            </tr>
                           
                            <tr>
                              <td><strong>Account Number:</strong></td>
                              <td><?php echo $banks_arr['acc_number']; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Bank Name:</strong></td>
                              <td><?php echo $banks_arr['bank_name']; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Branch Name:</strong></td>
                              <td> <?php echo $banks_arr['bank_branch']; ?></td>
                            </tr>
                             <tr>
                              <td><strong>Phone # 1:</strong></td>
                              <td><?php echo $banks_arr['phone_1']; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Phone # 2:</strong></td>
                              <td> <?php echo $banks_arr['phone_2']; ?></td>
                            </tr>
                             <tr>
                              <td><strong>Manager Phone:</strong></td>
                              <td> <?php echo $banks_arr['manager_phone']; ?></td>
                            </tr>
                             <tr>
                              <td><strong>Address:</strong></td>
                              <td><?php echo $banks_arr['address']; ?></td>
                            </tr>
                            <tr>
                              <td><strong>City:</strong></td>
                              <td> <?php echo $banks_arr['city']; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Created Date:</strong></td>
                              <td> <?php echo  date('d, M Y h:i:s a', strtotime($banks_arr['created_date'])); ?></td>
                            </tr>
                            
                             <tr>
                              <td><strong>Status:</strong></td>
                              <td><?php if($banks_arr['status']==1){ ?> Active <?php } ?><?php if($banks_arr['status']==0){ ?> De-Active <?php } ?></td>
                            </tr>
                          </tbody>
                        </table>
                        
                        
                   <div class="form-group" align="right" style="margin-right:17px">
                    	
                    	<a class="submit btn btn-blue" href="<?php echo base_url().'banks/manage-banks'; ?>">Go Back</a>
                    </div>
                    
                    </div>
                  </div>
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
    

</body>
</html>
