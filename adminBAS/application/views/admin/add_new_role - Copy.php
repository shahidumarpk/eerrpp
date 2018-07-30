<?php 
$session_post_data = $this->session->userdata('add-new-role-data');
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
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Role</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="add_new_role_frm" method="POST" action="<?php echo SURL?>admin/manage-roles/add-new-role-process">
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
                      <label for="role_title">Role Title*</label>
                      <input id="role_title" name="role_title" type="text" class="form-control" placeholder="Enter Role Title" value="<?php echo $session_post_data['role_title'] ?>" required/>
                    </div>
                    <div class="form-group">
                      <label for="confirm_password">Assign Permissions*</label>
                    </div>
                    <div class="form-group">
                      <?php
							$c = 0;
							foreach($permission_arr as $main_menu_index => $main_menu){
								
								$check_box_id_str .= '#menu_'.$c.', ';
						?>
                      <div class="section">
                        <div class="form-group"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <label for="menu_<?php echo $c?>">
                          	<input type="checkbox" class="checkbox" id="menu_<?php echo $c?>" name="permission_arr[]" <?php echo ($main_menu['set_as_default'] == 1) ? 'checked' : ''?> value="<?php echo $main_menu_index?>"  />
                          	<?php echo $main_menu['menu_title']?> </label>
                          <?php 
										if(count($main_menu['sub_menu']) > 0){
											
											for($j=0;$j<count($main_menu['sub_menu']);$j++){
							?>
                                                  <div class="subsection"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label for="sub_menu_<?php echo $main_menu['sub_menu'][$j]['id']?>" style="font-weight:500">
                                                      <input type="checkbox" class="checkbox" id="sub_menu_<?php echo $main_menu['sub_menu'][$j]['id']?>" <?php echo ($main_menu['sub_menu'][$j]['set_as_default'] == 1) ? 'checked' : ''?> name="permission_arr[]" value="<?php echo $main_menu['sub_menu'][$j]['id']?>" />
                                                      <?php echo $main_menu['sub_menu'][$j]['menu_title']?> </label>
                                                  </div>
                          <?php			
											}//end for

										}//end if(count($main_menu['sub_menu']) > 0)
						?>
                        </div>
                      </div>
                      <?php		
								$c++;
							}//end foreach
                        ?>
                    </div>
                  </div>
                  <div class="row form-group">
                    <div class="col-md-5">
                      <label for="standard-list1">Status</label>
                      <select class="form-control" id="status" name="status">
                        <option value="1">Active</option>
                        <option value="0">InActive</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group" align="right" style="margin-right:17px">
                    <input class="submit btn btn-blue" type="submit" name="add_admin_role_sbt" id="add_admin_role_sbt" value="Add new Role" />
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" style="min-height:250px;">&nbsp;</div>
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
        $("#add_new_role_frm").validate({
            rules: {
				role_title: {
					required: true,
				},
            },
            messages: {
				role_title: {
					required: "Role Title cannot be empty.",
				}
            }
        });
    
		// Multiselect Checkboxes in Group
		$('<?php echo trim($check_box_id_str,', ')?>').click(function(){
		
			var p = $(this).parents('.section');
		 
			p.find('div.subsection input:checkbox').prop('checked', this.checked);
			if(!this.checked){
				
				// remove the checkbox classes on sub sections
				p.find('.subsection').find('label').removeClass('c_on');
				p.find('.subsection').find('span').removeClass('checked');
				// remove the class from the thing we have clicked
				$(this).removeClass('c_on');
				
			} else {
				p.find('.subsection').find(':checkbox').prop('checked', true)
				p.find('.subsection').find('span').addClass('checked');
				p.find('.subsection').find('label').addClass('c_on');
				$(this).addClass('c_on');
			}
		});
    
	});


</script>
</body>
</html>
