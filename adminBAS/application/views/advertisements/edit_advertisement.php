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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span>Edit Advertisement </div>
              
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>advertisements/manage-advertisements/edit_advertisement_process" enctype="multipart/form-data">
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
                        <label for="title">Advertisement Title</label>
                        <input type="text" name="title" id="title"  class="form-control" value="<?php echo $advertisement_data['title']; ?>">
                      </div>
                      
                      <img src="<?php echo MURL."assets/advertisements/".$advertisement_data['image']; ?>"  width="150" height="130">
                      
                      <div class="form-group">
                        <label for="page_title">Upload Image *</label>
						 <input type="file" id="image" name="image">
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions: jpg, jpeg, gif, tiff, png
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 6MB; Recommended Dimension: 275 * 400
                            </span>
                        
                      </div>
                    </div>
                    
                     <div class="form-group">
                        <label for="link">Advertisement Link</label>
                        <input type="text" name="link" id="link" value="<?php echo $advertisement_data['link']; ?>"  class="form-control">
                   </div>
                    
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" <?php if($advertisement_data['status']==1){ ?>  selected<?php } ?>>Active</option>
                            <option value="0" <?php if($advertisement_data['status']==0){ ?>  selected<?php } ?>>InActive</option>
                        </select>
                        </div>
                    </div>                      
                  </div>
                  
                  <input type="hidden" name="add_id" value="<?php echo $advertisement_data['id']; ?>" >
                     <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="edit_advertisement" id="edit_advertisement" value="Edit Advertisement" />
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
