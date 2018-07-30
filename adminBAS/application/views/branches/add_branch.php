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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Branch </div>
              
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>branches/manage-branches/add-branch-process" enctype="multipart/form-data">
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
                    
                    
                    
                     <div class="form-group">
                        <label for="title">Branch Name</label>
                        <input type="text" name="branch_name" id="branch_name"  class="form-control" required>
                      </div>
                      
                       <div class="form-group">
                        <label for="title">Short Name</label>
                        <input type="text" name="short_name" id="short_name"  class="form-control" required>
                      </div>
                      
                      <div class="form-group">
                        <label for="title">Land Line Number</label>
                        <input type="text" name="land_line_number" id="land_line_number"  class="form-control" >
                      </div>
                      
                      <div class="form-group">
                        <label for="title">Mobile Number</label>
                        <input type="text" name="mobile_number" id="mobile_number"  class="form-control" >
                      </div>
                      
                      <div class="form-group">
                        <label for="title">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" ></textarea>
                      </div>
                      
                      <div class="form-group">
                        <label for="title">Contact Person Name</label>
                        <input type="text" name="contact_person_name" id="contact_person_name"  class="form-control" >
                      </div>
                      
                      <div class="form-group">
                        <label for="title">Contact Person Number</label>
                        <input type="text" name="contact_person_number" id="short_name"  class="form-control" >
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
                    	<input class="submit btn btn-blue" type="submit" name="add_branch" id="add_branch" value="Add Branch" title="Click to Add Branch" />
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
    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
		$("#add_new_slider_image_frm").validate({

            rules: {
				display_order: {
					required: false,
					digits: true
				},
            },

            messages: {
				display_order : "Use digit to set a display order"
            }

		});

		$("#slider_image").rules(
		 	"add", {
			 
			 extension: "jpg|jpeg|gif|tiff|png",
         	messages: {
				extension : "Please select valid image for epaper pages(Use: jpg, jpeg, gif, tiff, png)",
         }
      	});
		
    
    });
    </script>

</body>
</html>
