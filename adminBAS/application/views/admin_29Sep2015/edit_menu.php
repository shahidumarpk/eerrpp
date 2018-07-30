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
        <div class="col-md-12">
          <div class="panel" style="min-height:1300px">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit Menu Items</div>
            
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_new_cms_page_frm" method="POST" action="<?php echo SURL?>admin/manage-menu/edit-menu-process">
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
                        <label for="Question">Menu Title *</label>
                        <input id="Title" name="menu_title" type="text" class="form-control" placeholder="MENU TITLE " value="<?php echo $menu_data_arr['menu_title'] ?>" required/>
                      </div>        
                           <div class="row form-group">
                     <div class="col-md-5">
                          <label for="standard-list1">Select Parent id</label>
                            <select class="form-control" id="P_id" name="parent_id">
                            <?php
$items=$menu_data_arr['parent_id']; 
foreach($items_data1 as $row) {	
		
	$selected = ($row["id"] == $items) ? 'selected="selected"':'';


 
	echo "<option value='".$row["id"]."' $selected >".$row["menu_title"]."</option>";
	

		} ?>   </select>                    </div>
                  
                    </div>                      
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="standard-list1">Show in Nav</label>
                            <select class="form-control" id="Nav" name="show_in_nav">
                            <option value="1" <?php echo ($menu_data_arr['show_in_nav'] == 1) ? 'selected' : ''?> >Active</option>
                            <option value="0" <?php echo ($menu_data_arr['show_in_nav'] == 0) ? 'selected' : ''?>>InActive</option>
                        </select>
                        </div>
                        </div>            
                           <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="standard-list1">Set as Default</label>
                            <select class="form-control" id="default" name="set_as_default">
                            <option value="1" <?php echo ($menu_data_arr['set_as_default'] == 1) ? 'selected' : ''?> >Active</option>
                            <option value="0" <?php echo ($menu_data_arr['set_as_default'] == 0) ? 'selected' : ''?>>InActive</option>
                        </select>
                        </div>
                        </div>            
                  
                                    
                      <div class="form-group">
                        <label for="Icon">ICON Class Name </label>
                        <input id="Icon" name="icon_class_name" type="text" class="form-control" placeholder="Icon class Name" value="<?php echo $menu_data_arr['icon_class_name'] ?>" />
                      </div>
                      <div class="form-group">
                        <label for="Link">URL Link </label>
                        <input id="Link" name="url_link" type="text" class="form-control" placeholder="URL LINK " value="<?php echo $menu_data_arr['url_link'] ?>" />
                      </div>
                      <div class="form-group">
                        <label for="order">Display Order</label>
                        <input id="order" name="display_order" type="text" class="form-control" placeholder="Display Order " value="<?php echo $menu_data_arr['display_order'] ?>" />
                      </div>
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" <?php echo ($menu_data_arr['status'] == 1) ? 'selected' : ''?> >Active</option>
                            <option value="0" <?php echo ($menu_data_arr['status'] == 0) ? 'selected' : ''?>>InActive</option>
                        </select>
                        </div>
                        </div>            
                  </div>
                  <div id="seo_contents" class="tab-pane">
                    <div class="form-group">
                      <label for="meta_title">Meta Title</label>
                      <input id="meta_title" name="meta_title" type="text" class="form-control" value="<?php echo stripcslashes(strip_tags($page_data['meta_title'])) ?>" placeholder="Meta Title"/>
                    </div>
                    <div class="form-group">
                      <label for="meta_keywords">Meta Keywords</label>
                      <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3"><?php echo stripcslashes(strip_tags($page_data['meta_keywords'])) ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="meta_description">Meta Description</label>
                      <textarea class="form-control" id="meta_description" name="meta_description" rows="3"><?php echo stripcslashes(strip_tags($page_data['meta_description'])) ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="seo_url_name">SEO URL Name</label>
                      <input id="seo_url_name" name="seo_url_name" type="text" class="form-control" value="<?php echo $page_data['seo_url_name'] ?>" readonly />
                      <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> Change in URL string, will loose its identity in Search Engines</span>
                    </div>
                  </div>
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="upd_faq_sbt" id="upd_page_sbt" value="Update Page"  title="Click to Update page"/>
                        <input type="hidden" value="<?php echo $menu_data_arr['id'] ?>" name="page_id" readonly />
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
        $("#edit_new_cms_page_frm").validate({
            rules: {
                faq_question: "required",
                faq_answer: "required",
                
            },
            messages: {
                faq_question: "This field is required.",
                faq_answer: "This field is required.",
            }
        });
    
    });
    </script>

</body>
</html>
