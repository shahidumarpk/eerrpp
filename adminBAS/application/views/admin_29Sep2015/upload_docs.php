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
<header class="navbar navbar-fixed-top"><?php echo $INC_top_header; ?> </header>
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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Upload User Docs </div>
            </div>
            <div class="panel-body alerts-panel">
             
                <div class="tab-content border-none padding-none">
                  <div id="user_prof_contents" class="tab-pane active">
                   <form class="cmxform" id="add_new_user_frm" method="POST" action="<?php echo SURL?>admin/manage-user/upload-docs-process" enctype="multipart/form-data">
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
                        <label for="first_name">Title*</label>
                        <input id="title" name="title[]" type="text" class="form-control" placeholder="Enter Document Name" value="" required/>
                      </div>
                   <div class="form-group">
                       <label for="upload">Upload Doc </label>
                      <input type="file" id="upload_doc0" name="upload_doc[]">
                        <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
	                        - Allowed Extensions: jpg,jpeg,gif,tiff,png,doc,docx,xls,xlsx,pdf <br>
                        </span>
                        <span class="help-block margin-top-sm"><i class="fa fa-bell"></i> 
							- Max Upload Size: 2MB
                        </span>
                   </div>
                   <div class="form-group">
                        <label for="page_short_desc">Short Description</label>
                       <textarea class="form-control" id="short_desc" name="short_desc[]" rows="3"><?php echo $session_post_data['page_short_desc'] ?></textarea>
                   </div>
                   <div id="itemRows"></div> 
                    <div><button type="button" class="btn btn-blue" onClick="addRow(this.form);">Upload More </button></div>
                    
                    <div class="clearfix">&nbsp;</div>
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="upd_user_docs_sbt" id="upd_user_docs_sbt" value="Update User" />
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $admin_user_data['id'] ?>" readonly />
                    </div>
                     </form>
                </div>
                
             
            </div>            
          </div>
        </div>
      </div>
      <div class="row" style="min-height:250px;">&nbsp;</div>
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
        $("#add_new_user_frm").validate({
            rules: {
				title : 'required',
				upload_doc: {
					required: false,
					extension: "jpg|jpeg|gif|tiff|png|doc|docx|xls|xlsx|pdf"
				}				
			},
            messages: {
                title: "This field is required.",
				upload_doc : "Please select valid image for your profile (Use: jpg,jpeg,gif,tiff,png,doc,docx,xls,xlsx,pdf)",
			}
        });
    });
</script>
<script type='text/javascript'>
        var rowNum = 0;
function addRow(frm) {
	rowNum ++;
	var row = '<div id="rowNum'+rowNum+'"><div class="form-group"><label for="first_name">Title*</label><input id="title" name="title[]" type="text" class="form-control" placeholder="Enter Document Name" value="" required/></div><div class="form-group"><label for="upload">Upload Doc </label><input type="file" id="upload_doc" name="upload_doc[]"><span class="help-block margin-top-sm"><i class="fa fa-bell"></i>- Allowed Extensions: jpg,jpeg,gif,tiff,png,doc,docx,xls,xlsx,pdf <br></span><span class="help-block margin-top-sm"><i class="fa fa-bell"></i>- Max Upload Size: 2MB</span></div><div class="form-group"><label for="page_short_desc">Short Description</label><textarea class="form-control" id="short_desc" name="short_desc[]" rows="3"><?php echo $session_post_data['page_short_desc'] ?></textarea></div><input type="button" class="btn btn-danger" value="Remove" onclick="removeRow('+rowNum+');" style="margin-left:15px;"><div class="clearfix">&nbsp;</div><div class="clearfix">&nbsp;</div></div></div>';
	jQuery('#itemRows').append(row);
}

function removeRow(rnum) {
	jQuery('#rowNum'+rnum).remove();
}

</script>
</body>
</html>
