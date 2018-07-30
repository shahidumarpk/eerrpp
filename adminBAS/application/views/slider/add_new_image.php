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
       <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Slider Image </div>
       
        <ul class="nav panel-tabs">
                <li class="active"><a href="#cms_main_contents" data-toggle="tab">Slider Image</a></li>
                <li class=""><a href="#seo_contents" data-toggle="tab">Add Layer</a></li>
                <li class=""><a href="#button_contents" data-toggle="tab">Add Button</a></li>
        </ul>
              
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_slider_image_frm" method="POST" action="<?php echo SURL?>slider/manage-slider/add-new-image-process" enctype="multipart/form-data">
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
                        <label for="slider_image">Upload Slider Image *</label>
						 <input type="file" id="slider_image" name="slider_image">
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions: jpg, jpeg, gif, tiff, png
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 6MB; Recommended Dimension: 800 * 600
                            </span>
                        
                      </div>
                      <div class="form-group">
                        <label for="background_image">Upload Background Image *</label>
						 <input type="file" id="slider_background" name="slider_background">
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions: jpg, jpeg, gif, tiff, png
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 6MB; Recommended Dimension: 800 * 600
                            </span>
                        
                      </div>
                      
                      <div class="row form-group">
                      <label class="col-md-11 text-left">Display Order</label>
                      <div class="col-xs-3">
                        <input type="text" name="display_order" id="display_order" value="0" class="form-control">
                      </div>
                    </div>
                    
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" selected >Active</option>
                            <option value="0">InActive</option>
                            
                        </select>
                        </div>
                    </div>     
                    
                </div>
                
                
                <div id="seo_contents" class="tab-pane">
                
                 <div class="form-group">
                        <label for="slider_text">Enter Text</label>
                        <textarea class="form-control" id="slider_text" name="slider_text[]" rows="2"></textarea>
                      </div>
                      
                     <div class="row form-group">
                     <div class="col-md-5">
                          <label for="class_name">Class Name</label>
                            <select class="form-control" id="class_name" name="class_name[]">
                            <option value="regular" selected >regular</option>
                            <option value="list-left">list-left</option>
                             <option value="small">small</option>
                             <option value="list-right">list-right</option>
                        </select>
                        </div>
                    </div>     
                      
                      
                      <div class="row form-group">
                      <label class="col-md-11 text-left">X-Direction</label>
                      <div class="col-xs-3">
                        <input type="text" name="x_direction[]" id="x_direction" value="" class="form-control">
                      </div>
                    </div>
                    <div class="row form-group">
                      <label class="col-md-11 text-left">Y-Direction</label>
                      <div class="col-xs-3">
                        <input type="text" name="y_direction[]" id="y_direction" value="" class="form-control">
                      </div>
                    </div>
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="status">Status</label>
                            <select class="form-control" id="status" name="status[]">
                            <option value="1" selected >Active</option>
                            <option value="0">InActive</option>
                            
                        </select>
                        </div>
                    </div>
                    
                    
                    <div id="item"></div> 
                    <div><button type="button" class="btn btn-blue" onClick="add_layer_html(this.form);">Add More Layers </button></div>
                    
                </div>
                
                
                <div id="button_contents" class="tab-pane">
                <div class="form-group">
                        <label for="page_title">Upload Button </label>
						 <input type="file" id="btn_image" name="btn_image">
                         <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                - Allowed Extensions: jpg, jpeg, gif, tiff, png
                            </span>
                            <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
                                Max Upload Size: 6MB; Recommended Dimension: 800 * 600
                            </span>
                            
                      </div> 
                      <div class="row form-group">
                      <label class="col-md-11 text-left">Button Link</label>
                      <div class="col-xs-3">
                        <input type="text" name="btn_link" id="btn_link" value="" class="form-control">
                      </div>
                      </div>
                      
               
                      <div class="row form-group">
                      <label class="col-md-11 text-left">X-Direction</label>
                      <div class="col-xs-3">
                        <input type="text" name="x_direction_btn" id="x_direction_btn" value="" class="form-control">
                      </div>
                    </div>
                    <div class="row form-group">
                      <label class="col-md-11 text-left">Y-Direction</label>
                      <div class="col-xs-3">
                        <input type="text" name="y_direction_btn" id="y_direction_btn" value="" class="form-control">
                      </div>
                    </div>
                    <div class="row form-group">
                     <div class="col-md-5">
                          <label for="btn_class_name">Class Name</label>
                            <select class="form-control" id="btn_class_name" name="btn_class_name">
                            <option value="regular" selected >regular</option>
                            <option value="list-left">list-left</option>
                             <option value="small">small</option>
                             <option value="list-right">list-right</option>
                        </select>
                        </div>
                    </div> 
                    
                    
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="status">Status</label>
                            <select class="form-control" id="btn_status" name="btn_status">
                            <option value="1" selected >Active</option>
                            <option value="0">InActive</option>
                            
                        </select>
                        </div>
                    </div>    
               
                </div>
				
                <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="add_image_sbt" id="add_image_sbt" value="Add New Slider" title="Click to Add Slider" />
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
		
		$("#slider_background").rules(
		 	"add", {
			
			 extension: "jpg|jpeg|gif|tiff|png",
         	messages: {
				extension : "Please select valid image for epaper pages(Use: jpg, jpeg, gif, tiff, png)",
         }
      	});
		
		$("#display_order").rules(
		 	"add", {
			 required:true,
			
      	});
		
		$("#btn_image").rules(
		 	"add", {
			 required:true,
			 extension: "jpg|jpeg|gif|tiff|png",
         	messages: {
				extension : "Please select valid image for epaper pages(Use: jpg, jpeg, gif, tiff, png)",
         }
      	});
		
		$("#btn_link").rules(
		 	"add", {
			 required:true,
			 
      	});
		
		$("#x_direction_btn").rules(
		 	"add", {
			 required:true,
			
      	});
		
		$("#y_direction_btn").rules(
		 	"add", {
			 required:true,
			
      	});
		
    
    });
    </script>
 <script type='text/javascript'>
        var rowNum = 0;
function add_layer_html(frm) {
 rowNum ++;
 var row = '<div id="rowNum'+rowNum+'"><div class="form-group"><label for="slider_text">Enter Text</label><textarea class="form-control" id="slider_text" name="slider_text[]" rows="2"></textarea></div><div class="row form-group"><div class="col-md-5"><label for="class_name">Class Name</label><select class="form-control" id="class_name" name="class_name[]"><option value="regular" selected >regular</option><option value="list-left">list-left</option><option value="small">small</option><option value="list-right">list-right</option></select></div></div><div class="row form-group"><label class="col-md-11 text-left">X-Direction</label><div class="col-xs-3"><input type="text" name="x_direction[]" id="x_direction" value="" class="form-control"></div></div><div class="row form-group"><label class="col-md-11 text-left">Y-Direction</label><div class="col-xs-3"><input type="text" name="y_direction[]" id="y_direction" value="" class="form-control"></div></div><div class="row form-group"><div class="col-md-5"><label for="status">Status</label><select class="form-control" id="status" name="status[]"><option value="1" selected >Active</option><option value="0">InActive</option></select></div></div><input type="button" class="btn btn-danger" value="Remove" onclick="removeRow('+rowNum+');" style="margin-left:15px;"><div class="clearfix">&nbsp;</div><div class="clearfix">&nbsp;</div></div></div>';
 jQuery('#item').append(row);
}

function removeRow(rnum) {
 jQuery('#rowNum'+rnum).remove();
 jQuery('#rowNum'+rnum).remove();
}

</script>   
 
</body>
</html>
