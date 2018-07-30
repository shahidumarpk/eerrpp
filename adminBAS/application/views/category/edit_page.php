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
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Edit Page </div>
              <ul class="nav panel-tabs">
                <li class="active"><a href="#cms_main_contents" data-toggle="tab">Main Contents</a></li>
                <li class=""><a href="#seo_contents" data-toggle="tab">SEO Contents</a></li>
              </ul>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_new_cms_page_frm" method="POST" action="<?php echo SURL?>cms/manage-pages/edit-page-process">
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
                        <label for="page_title">Page Title *</label>
                        <input id="page_title" name="page_title" type="text" class="form-control" placeholder="Page Title" value="<?php echo $page_data['page_title'] ?>" required/>
                      </div>
                      <div class="form-group">
                        <label for="page_short_desc">Short Description</label>
                        <textarea class="form-control" id="page_short_desc" name="page_short_desc" rows="3"><?php echo $page_data['page_short_desc'] ?></textarea>
                      </div>
                      
                      <div class="form-group">
                        <label for="page_long_desc">Page Description</label>
                      </div>
                      <div class="form-group">
                        <textarea class="ckeditor editor1"  id="page_long_desc" name="page_long_desc" rows="14"><?php echo $page_data['page_long_desc'] ?></textarea>
                      </div>
                    <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="standard-list1">Status</label>
                            <select class="form-control" id="status" name="status">
                            <option value="1" <?php echo ($page_data['status'] == 1) ? 'selected' : ''?> >Active</option>
                            <option value="0" <?php echo ($page_data['status'] == 0) ? 'selected' : ''?>>InActive</option>
                        </select>
                        </div>
                    </div>                      
                                          
                  </div>
                  <div id="seo_contents" class="tab-pane">
                    <div class="form-group">
                      <label for="meta_title">Meta Title</label>
                      <input id="meta_title" name="meta_title" type="text" class="form-control" value="<?php echo $page_data['meta_title'] ?>" placeholder="Meta Title"/>
                    </div>
                    <div class="form-group">
                      <label for="meta_keywords">Meta Keywords</label>
                      <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3"><?php echo $page_data['meta_keywords'] ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="meta_description">Meta Description</label>
                      <textarea class="form-control" id="meta_description" name="meta_description" rows="3"><?php echo $page_data['meta_description'] ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="seo_url_name">SEO URL Name</label>
                      <input id="seo_url_name" name="seo_url_name" type="text" class="form-control" value="<?php echo $page_data['seo_url_name'] ?>" readonly />
                      <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> Change in URL string, will loose its identity in Search Engines</span>
                    </div>
                  </div>
                    <div class="form-group" align="right" style="margin-right:17px">
                    	<input class="submit btn btn-blue" type="submit" name="upd_page_sbt" id="upd_page_sbt" value="Update Page" />
                        <input type="hidden" value="<?php echo $page_data['id'] ?>" name="page_id" readonly />
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
                page_title: "required",
                page_short_desc: "required",
                
            },
            messages: {
                page_title: "This field is required.",
                page_short_desc: "This field is required.",
            }
        });
    
    });
    </script>

</body>
</html>
