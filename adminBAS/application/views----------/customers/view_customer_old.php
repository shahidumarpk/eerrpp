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
        <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> View Customer </div>
               <ul class="nav panel-tabs">
                <li class="active"><a href="#user_prof_contents" data-toggle="tab">Customer Profile</a></li>
                <li class=""><a href="#upload_user_docs" data-toggle="tab">Uploaded Documents</a></li>
              </ul>
            </div>
            <div class="panel-body alerts-panel">
                <div class="tab-content border-none padding-none">
                  <div id="user_prof_contents" class="tab-pane active">
                 
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
                        <label for="first_name">First Name:&nbsp;</label>
                        <?php echo stripslashes($customer_user_data['first_name']) ?>
                      </div>
                      <div class="form-group">
                        <label for="last_name">Last Name:&nbsp;</label>
                        <?php echo stripslashes($customer_user_data['last_name']) ?>
                      </div>
                     <div class="form-group">
                        <label for="username">Username :&nbsp;</label>
                        <?php echo stripslashes($customer_user_data['username']) ?>
	                 </div>
                     
                     <div class="form-group">
                        <label for="email_address">Email Address :&nbsp;</label>
                        <?php echo stripslashes($customer_user_data['email_address']) ?>
	                 </div>
                      <div class="row form-group">
                     <div class="col-md-5">
                     		<div class="form-group">
                     		 <label for="upload">Upload Profile Image</label>
                     		</div>
                     </div>
                    <?php 
							if($customer_user_data['profile_image'] !=''){
					?>
                        <div class="col-md-5">
                            <img src="<?php echo CUSTOMER_FOLDER.'/'.$customer_user_data['id'].'/'.stripslashes($customer_user_data['profile_image'])?>">
                        </div>
                        <?php }//end if?>
                      </div>
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Account Type :&nbsp;</label>
                          <?php echo stripslashes($customer_user_data['account_type']) ?>
                          
                         </div>
                    </div>
                    <div id="personaldata" <?php echo ($customer_user_data['account_type'] == 'Personal') ? '' : 'style="display:none;"'?>>
                    	 <div class="form-group">
                        <label for="email_address">Technical Person Name :&nbsp;</label>
                        <?php echo $customer_user_data['tech_name'] ?>
                      </div>  
                         
                         <div class="form-group">
                        <label for="email_address">Technical Person Phone :&nbsp;</label>
                        <?php echo $customer_user_data['tech_phone'] ?>
                      </div>
                    </div>
                    
                    <div id="businessdata" <?php echo ($customer_user_data['account_type'] == 'Business') ? '' : 'style="display:none;"'?>>
                    	 <div class="form-group">
                        <label for="Company Name">Company Name :&nbsp;</label>
                        <?php echo $customer_user_data['comp_name'] ?>
                      </div>  
                         
                         <div class="form-group">
                        <label for="Company Phone">Company Phone :&nbsp;</label>
                        <?php echo $customer_user_data['comp_phone'] ?>
                      </div>
                      
                       <div class="form-group">
                        <label for="Company Website">Company Website:&nbsp;</label>
                        <?php echo $customer_user_data['comp_website'] ?>
                      </div>  
                         
                         <div class="form-group">
                        <label for="email_address">Company Address:&nbsp;</label>
                       <?php echo $customer_user_data['comp_add'] ?>
                      </div>
                         
                      <div class="form-group">
                        <label for="email_address">Technical Person Name :&nbsp;</label>
                        <?php echo $customer_user_data['tech_name'] ?>
                      </div>  
                         
                      <div class="form-group">
                        <label for="email_address">Technical Person Phone :&nbsp;</label>
                        <?php echo $customer_user_data['tech_phone'] ?>
                      </div>
                   
                    </div> 
                      
                   <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Status:&nbsp;</label>
                          <?php echo ($customer_user_data['status'] == 1) ? 'Active' : 'InActive' ;?>
                        </div>
                   </div>
                    </div> 
                  <div id="upload_user_docs" class="tab-pane">
                   <div class="row">
        <div class="col-md-12">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Uploaded Document list</div>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Document</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                 <?php 
				for($i=0;$i<$customer_user_docs_count;$i++){
					$counter = $i+1 ; 
				 ?>
                    <tr>
                      <td><?php echo $counter ; ?></td>
                      <td><?php echo stripslashes($customer_user_docs_data[$i]['title']) ; ?></td>
                      <td><?php 
							if($customer_user_docs_data[$i]['upload_doc'] !=''){
						?>
                           <img src="<?php echo CUSTOMER_FOLDER.'/'.$customer_user_data['id'].'/'.stripslashes($customer_user_docs_data[$i]['upload_doc'])?>" width="180" height="135">
                    	<?php }//end if?></td>
                      <td><?php echo  stripslashes($customer_user_docs_data[$i]['descrp']) ; ?></td>
                    </tr>
                <?php } ?>    
                </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
                </div>
                  
                </div>
                
              
            </div>            
          </div>
        </div>
      </div>
      <div class="row" style="min-height:250px;">&nbsp;</div>
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
				first_name : 'required',
				last_name : 'required',
              username: {
					required: true,
					minlength: 5,
					maxlength: 20
				},
				password: {
					required: false,
					minlength: 6
				},
				confirm_password: {
					required: false,
					equalTo: "#password"
				},
				email_address: {
					required: false,
					email: true
				},
				prof_image: {
					required: false,
					extension: "jpg|jpeg|gif|tiff|png"
				}				
				
            },
            messages: {
                first_name: "This field is required.",
				last_name : "This field is required.",
				display_name: "This field is required.",
				prof_image : "Please select valid image for your profile (Use: jpg, jpeg, gif, tiff, png)",
				username: {
					required: "This field is required.",
					minlength: "Username must consist of at least 5 characters",
					maxlength: "Username cannot me more than 20 characters"
				},
				password: {
					minlength: "Password must be at least 6 characters long"
				},
				confirm_password: {
					equalTo: "New Password must match with confirm password"
				},				
				email_address: "Enter your valid email address",
			}
        });
    
    });
 
 	//Get Radio Values
	function change_account(radiovalue){
		
	if(radiovalue == 'Personal'){
		document.getElementById('personaldata').style.display = '';
		document.getElementById('businessdata').style.display = 'none';
		
	}else if(radiovalue == 'Business'){
	
		document.getElementById('personaldata').style.display = 'none';
		document.getElementById('businessdata').style.display = '';
	
	}
	
	
}
	
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
