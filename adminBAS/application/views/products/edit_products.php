<?php 
$session_post_data = $this->session->userdata('add-new-cat-data');
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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit Product </div>
              <ul class="nav panel-tabs">
              
                <li class="active"><a href="#basic_content" data-toggle="tab">Basic</a></li>
                <li class=""><a href="#attribute_content" data-toggle="tab">Attributes</a></li>
                <li class=""><a href="#seo_content" data-toggle="tab">SEO</a></li>
                <li class=""><a href="#gallery_content" data-toggle="tab">Gallery</a></li>
                
              </ul>
            </div>
            
            
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_category_frm" method="POST" enctype="multipart/form-data" action="<?php echo SURL?>products/manage-products/edit-products-process">
                <div class="tab-content border-none padding-none" >
                
                  <div id="basic_content" class="tab-pane active">
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
                        <label for="product_name">Product Name *</label>
                        <input id="product_name" name="product_name" type="text" class="form-control" placeholder="Procuct Name" value="<?php echo stripcslashes(strip_tags($product_arr['product_name'])) ?>" />
                      </div>
                      
                      
                      <div class="row form-group">
                        <div class="col-md-5">
                       
                          <label for="product_category">Category</label>
                               
                            <?php
							    
								
								foreach($categories_list_arr as $item=>$key)
					          	{  
								        $cat=explode(',',$product_arr['product_category']);
										
										
										$sub_category.="<option value='$key[pid]-0' ";
										   
										if(in_array($key[pid].'-0',$cat)==$key[pid].'-0'){ $sub_category.="selected"; }
										
										$sub_category.=" >".$key['category_name']."</option>";
										
									if($key['sub_category']!=""){
										
										foreach($key['sub_category'] as $sub_cate=>$data)
					          	        { 
										      
											
										    $sub_category.="<option value='$data[cid]' ";
										
										    if(in_array($data[cid],$cat)==$data[cid]){ $sub_category.="selected"; }
										
										    $sub_category.=" >&nbsp;&nbsp;&nbsp;&nbsp;".$data['category_name']."</option>";
										}
									}
								
						        }
		                           ?>
								
                        <select class="form-control" id="product_category" name="product_category[]" style="font-size:12px" multiple>
                            	<?php echo  $sub_category ?>
                               
                              
                        </select>
                         </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="product_discription">Description</label>
                      <textarea class="form-control" id="product_discription" name="product_discription" rows="6"><?php echo stripcslashes(strip_tags($product_arr['product_discription'])) ?></textarea>
                    </div>
                   
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="product_status" name="product_status">
                            <option value="1" <?php if($product_arr['product_status']==1){ ?> selected <?php  }  ?> >Active</option>
                            <option value="0" <?php if($product_arr['product_status']==0){ ?> selected <?php  }  ?>>InActive</option>
                        </select>
                        </div>
                    </div> 
                    
                     <div class="form-group">
                      <label for="product_tags">Product Tags</label>
                      <textarea class="form-control" id="product_tags" name="product_tags" rows="2"><?php echo stripcslashes(strip_tags($product_arr['product_tags'])) ?></textarea>
                    </div>                     
               </div><!--End Basic Content-->
                  
                  
                  <div id="attribute_content" class="tab-pane"><!--Start Attribute Content-->
                    <div class="form-group">
                      <label for="product_original_price">Product Original Price</label>
                      <input id="product_original_price" name="product_original_price" type="text" class="form-control" value="<?php echo $product_arr['product_original_price'] ?>" placeholder="Product original price"/>
                    </div>
                    
                    <div class="form-group">
                      <label for="discount_percentage">Discount Percentage</label>
                     <input id="discount_percentage" name="discount_percentage" type="text" class="form-control" value="<?php echo $product_arr['discount_percentage'] ?>" placeholder="Discount Percentage"/>
                    </div>
                    <div class="form-group">
                      <label for="weight">Weight</label>
                      <input id="weight" name="weight" type="text" class="form-control" value="<?php echo $product_arr['weight'] ?>" placeholder="Weight"/>
                    </div>
                    
                    <div class="form-group">
                    <label for="dimensions">Dimensions</label>
                     <input id="dimensions" name="dimensions" type="text" class="form-control" value="<?php echo $product_arr['dimensions'] ?>" placeholder="L * W * H"/>
                    </div>
                    

                    <div class="form-group">
                      <label for="quantity_in_hand">Quantity In Hand</label>
                       <input id="quantity_in_hand" name="quantity_in_hand" type="text" class="form-control" value="<?php echo $product_arr['quantity_in_hand'] ?>" placeholder="Quantity n Hand"/>
                    </div>
                    
                    <div class="form-group">
                      <label for="model">Model</label>
                       <input id="model" name="model" type="text" class="form-control" value="<?php echo $product_arr['model'] ?>" placeholder="Model"/>
                    </div>
                    
                     <div class="form-group">
                      <label for="color">Color</label>
                       <input id="color" name="color" type="text" class="form-control" value="<?php echo $product_arr['color'] ?>" placeholder="Color"/>
                    </div>
                    
                    <div class="form-group">
                      <label for="package">Package</label>
                       <input id="package" name="package" type="text" class="form-control" value="<?php echo $product_arr['package'] ?>" placeholder="Package"/>
                    </div>
                    
               </div><!--End Attribute Content-->
               
               
                  <div id="seo_content" class="tab-pane"><!--Start Seo Content-->
                    
                    <div class="form-group">
                      <label for="meta_keywords">Meta Keywords</label>
                      <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3"><?php echo stripcslashes(strip_tags($product_arr['meta_keywords'])) ?></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label for="meta_discription">Meta Description</label>
                      <textarea class="form-control" id="meta_discription" name="meta_discription" rows="3"><?php echo stripcslashes(strip_tags($product_arr['meta_discription'])) ?></textarea>
                    </div>
                    
                     <div class="form-group">
                      <label for="meta_title">Meta Title</label>
                      <textarea class="form-control" id="meta_title" name="meta_title" rows="3"><?php echo stripcslashes(strip_tags($product_arr['meta_title'])) ?></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label for="seo_url">SEO URL </label>
                      <input id="seo_url" name="seo_url" type="text" class="form-control"  value="<?php echo $product_arr['seo_url'] ?>" />
                      <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> Change in URL string, will loose its identity in Search Engines</span>
                    </div>
               </div><!--End Seo Content-->
               
                
            </form>     
                  
                <div id="gallery_content" class="tab-pane"><!--Start gallery Content-->
                
                      
                <table class="table table-striped table-bordered table-hover" id="manage_cms_pages">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Images</th>
                        <th class="text-center hidden-xs">Options</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
							for($i=0;$i<$product_images_count;$i++){
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1) ?></span></td>
                                
                                <td class="hidden-xs"><span class="xedit"><img src="<?php echo MURL?>/assets/products/files/<?php echo $product_images_arr[$i]['name']; ?>" width="80"  height="70"></span></td>
                                
                                <td class="hidden-xs text-center">
                                	<a href="<?php echo base_url()?>products/manage-products/delete-products_images/<?php echo $product_images_arr[$i]['id'] ?>/<?php echo $product_arr['product_code'] ?>" onClick="return confirm('Are you sure you want to delete?')" type="button" class="btn btn-danger btn-gradient" title="Delete Image">Delete <span class="glyphicons glyphicons-remove"></span> </a>
                                

                               </td>
                            </tr>
                    <?php			
						}//end for
					?>
                    </tbody>
                  </table>
                    
                  <form id="fileupload" action="#" method="POST" enctype="multipart/form-data">
              <noscript>
              <input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/">
              <input type="hidden" name="product_idddd" id="product_iddd" value="4564645">
              
              </noscript>
              <div class="panel-menu">
                <div class="fileupload-buttonbar"> <span class="btn btn-info btn-gradient fileinput-button margin-right-sm"> <i class="glyphicon glyphicon-plus"></i> <span>Add files...</span>
                  <input type="file" name="files[]" multiple>
                  </span>
                  <button type="submit" class="btn btn-default btn-gradient start margin-right-sm"> <i class="glyphicons glyphicons-upload"></i> <span>Start upload</span> </button>
                  <button type="reset" class="btn btn-default btn-gradient cancel margin-right-sm"> <i class="glyphicon glyphicon-ban-circle"></i> <span>Cancel upload</span> </button>
                  <button type="button" class="btn btn-default btn-gradient delete margin-right-sm"> <i class="glyphicon glyphicon-trash"></i> <span>Delete</span> </button>
                  <span class="margin-left-sm">
                  <input type="checkbox" class="checkbox toggle inline-object">
                  </span> <span class="fileupload-process"></span>
                  <div class="col-lg-5 hidden fileupload-progress fade">
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                    <div class="progress-extended">&nbsp;</div>
                  </div>
                </div>
              </div>
              <div class="panel-body">
                <table role="presentation" class="table table-striped">
                  <tbody class="files">
                  </tbody>
                </table>
              </div>
            </form>
        
                    
               </div><!--End Gallery Content-->   
                  
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                    <input type="hidden" name="product_id" value="<?php echo $product_arr['product_code'] ?>" >
                    	<input class="submit btn btn-blue" type="submit" name="edit_products_sbt" id="edit_products_sbt" value="Edit Product" title="Click to Update product" />
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
<?php echo $INC_header_script_footer;
$product_id  = $product_arr['product_code'];

?>
    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#add_new_category_frm").validate({
            rules: {
                category_name: "required",
                parent_id: "required",
				display_order: {
					required: false,
					digits: true

				},
                
            },
			
            messages: {
                category_name: "Enter Category Name.",
                parent_id: "Select Parent Category.",
				display_order : "Use digit to set a display order"
            }
        });
    
    });
    </script>
    
    <script language="javascript">
	/*
 * jQuery File Upload Plugin JS Example 8.9.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint nomen: true, regexp: true */
/*global $, window, blueimp */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: '<?php echo  MURL ;?>assets/products/'
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
		'product_id',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );
	
	$('#fileupload').fileupload({
		formData: {product_id: '<?php echo $product_id ; ?>'}
	});
	
    if (window.location.hostname === 'blueimp.github.io') {
        // Demo settings:
        $('#fileupload').fileupload('option', {
            url: '//jquery-file-upload.appspot.com/',
			// Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            maxFileSize: 1000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '//jquery-file-upload.appspot.com/',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                            new Date())
                    .appendTo('#fileupload');
            });
        }
    } else {
        // Load existing files:
       /* $('#fileupload').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });*/
    }

});
    </script>

</body>
</html>
