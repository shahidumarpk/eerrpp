<?php 
$session_post_data = $this->session->userdata('add-faq-data');
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
        <div class="col-md-12">
          <div class="panel" style="min-height:1300px">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Menu Items </div>
              
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_cms_page_frm" method="POST" action="<?php echo SURL?>admin/manage-menu/add-menu-process">
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
                        <input id="Title" name="menu_title" type="text" class="form-control" placeholder="MENU TITLE " value="<?php echo $session_post_data['menu_title'] ?>" required/>
                      </div>
                      <div class="form-group">
                        <label for="page_long_desc">Parent ID</label></br>
                          <select style="width:20%;" id="P_id" name="parent_id" onChange="$get_categories(this.value)" required >
								<option value="0">Select Parent</option>
                            	<?php 
									for($i=0;$i<$items_result_count;$i++){
								?>
                            			<option value="<?php echo $items_result_arr[$i]['id']?>"><?php echo $items_result_arr[$i]['menu_title']?></option>    
                                <?php		
									}//end for
								?>
                            
                        </select>
                      
                      
                      </div>
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="standard-list1">Show in Nav</label>
                            <select class="form-control" id="Nav" name="show_in_nav">
                            <option value="1" selected >Active</option>
                            <option value="0">InActive</option>
                        </select>
                        </div>
                    </div>         
                    
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="standard-list1">Set as Default</label>
                            <select class="form-control" id="default" name="set_as_default">
                            <option value="1" selected >Active</option>
                            <option value="0">InActive</option>
                        </select>
                        </div>
                    </div>          
                                 
               <div class="form-group">
                        <label for="Icon">ICON Class Name </label>
                        <input id="Icon" name="icon_class_name" type="text" class="form-control" placeholder="Icon class Name" value="<?php echo $session_post_data['icon_class_name'] ?>" />
                      </div>
                      <div class="form-group">
                        <label for="Link">URL Link </label>
                        <input id="Link" name="url_link" type="text" class="form-control" placeholder="URL LINK " value="<?php echo $session_post_data['url_link'] ?>" />
                      </div>
                      <div class="form-group">
                        <label for="order">Display Order</label>
                        <input id="order" name="display_order" type="text" class="form-control" placeholder="Display Order " value="<?php echo $session_post_data['display_order'] ?>" />
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
                    	<input class="submit btn btn-blue" type="submit" name="add_menu_sbt" id="add_page_sbt" value="Add Page" title="Click to Add page" />
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
        $("#add_new_cms_page_frm").validate({
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
