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
  
  <link rel="stylesheet" href="css/test.css" type="text/css" media="screen" title="Test Stylesheet" charset="utf-8" />
    <script src="js/protoculous-effects-shrinkvars.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/textboxlist.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/test.js" type="text/javascript" charset="utf-8"></script>
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
        <div class="col-md-12" style="min-height:1270px;">
          <div class="panel" style="min-height:600px;">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Project Assign</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>projects/manage-projects/project-assign-process" enctype="multipart/form-data">
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
                      
        <select name="name[]" id="name" data-placeholder="Choose a name..." class="chosen-select" multiple style="width:350px;" tabindex="4">
            <option value=""></option>
            
           <?php  for($i=0; $i<$customers_count; $i++) {?>
                                
                                <option value="<?php echo $customers_arr[$i]['id'] ?>">
                                <?php echo $customers_arr[$i]['first_name']." ".$customers_arr[$i]['last_name']; ?>
                                </option>
          <?php } ?>
          
        
          </select>
                   
         
                  
                  <input type="hidden" name="project_id" value="<?php echo $project_id; ?>"  >
                  
                    <div class="form-group" align="right" style="margin-right:100px">
                        <input class="submit btn btn-blue"  type="submit" name="assign_project" id="assign_project" value="Assign Project" />
                    </div>
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
  
  
    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#edit_admin_profile_frm").validate({
            rules: {
				first_name : 'required',
				last_name : 'required',
                display_name: "required",
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
                first_name: "This field is required.",
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
    
<link href="<?php echo CSS ;?>select2.css" rel="stylesheet"/>
<script src="<?php echo JS ; ?>select2.js"></script>
<script>
$(document).ready(function() { $("#employee_id").select2(); });
</script>

</body>
</html>
