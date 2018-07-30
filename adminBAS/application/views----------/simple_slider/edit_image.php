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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit Slider Image </div>
              
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>simple_slider/manage-slider/edit-image-process" enctype="multipart/form-data">
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
                        <label for="page_title">Upload Slider Image *</label>
						 <input type="file" id="slider_image" name="slider_image">
                         	<a class="image-popup-no-margins" href="<?php echo SIMPLE_SLIDER_IMAGES.'/'.stripslashes($slider_image_data['slider_image'])?>">
                            	<img src="<?php echo SIMPLE_SLIDER_IMAGES.'thumb/'.stripslashes($slider_image_data['slider_image'])?>" width="200" height="170">
                            </a>
                         	
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions: jpg, jpeg, gif, tiff, png
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 6MB; Recommended Dimension: 800 * 600
                            </span>
                        
                      </div>
                      <div class="form-group">
                        <label for="page_short_desc">Caption</label>
                        <textarea class="form-control" id="slider_caption" name="slider_caption" rows="3"><?php echo stripslashes($slider_image_data['slider_caption']) ?></textarea>
                      </div>
                      <div class="row form-group">
                      <label class="col-md-11 text-left">Display Order</label>
                      <div class="col-xs-3">
                        <input type="text" name="display_order" id="display_order" value="<?php echo $slider_image_data['display_order'] ?>" class="form-control">
                      </div>
                    </div>
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" <?php echo ($slider_image_data['status'] == 1) ? 'selected' : ''?>  >Active</option>
                            <option value="0" <?php echo ($slider_image_data['status'] == 0) ? 'selected' : ''?>>InActive</option>
                        </select>
                        </div>
                    </div>                      
                  </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="upd_image_sbt" id="upd_image_sbt" value="Update Image"  title="Click to Update Slider"/>
                        <input type="hidden" name="image_id" id="image_id" value="<?php echo $slider_image_data['id'] ?>" readonly>
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
    <script type="text/javascript">
      jQuery(document).ready(function() {
    
		//Image Gallery 
		$('.image-popup-no-margins').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			closeBtnInside: false,
			fixedContentPos: true,
			mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
			image: {
				verticalFit: true
			},
			zoom: {
				enabled: true,
				duration: 300 // don't foget to change the duration also in CSS
			}
		});

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

    });
	
    </script>

</body>
</html>
