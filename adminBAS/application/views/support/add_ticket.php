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
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span> Add New Ticket</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>support/manage_tickets/add_ticket_process" enctype="multipart/form-data">
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
                    
                    
                    
                    <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Type :</label>
                           <input id="account_type" name="account_type" type="radio" value="customer" onClick="change_account(this.value)" /> Customer &nbsp;&nbsp;<input id="account_type" name="account_type" type="radio" value="guest"  onClick="change_account(this.value)" /> Guest 							
                        </div>
                    </div>
                    
                    
                    <div id="customerdata" style="display:none;">
                    	   
                   <div class="row form-group">
                        <div class="col-md-5">
                          <label for="standard-list1">Customer Name</label>
                            <select class="form-control" id="customer_id" name="customer_id">
                           <?php 
								for($c=0; $c < $customers_list_count ; $c++){ ?>
										<option value="<?php echo $customers_list_arr[$c]['id'] ?>"><?php echo $customers_list_arr[$c]['first_name'].' '.$customers_list_arr[$c]['last_name'] ; ?></option>
								<?php } ?>
                        </select>
                        </div>
                    </div>      
                         
                    </div>
                    
                    <div id="guestdata" style="display:none;">
                    	 <div class="form-group">
                        <label for="guest_email">Email</label>
                        <input id="guest_email" name="guest_email" type="text" class="form-control" placeholder="Type Email" value="<?php echo $session_post_data['comp_name'] ?>"/>
                         </div>  
                    
                    </div>
                      
                      
                            
                      <div class="form-group">
                        <label for="subject">Subject*</label>
                        <input id="subject" name="subject" type="text" class="form-control" placeholder="Type Subject Name" value="" required/>
                      </div>
                      
                      <div class="form-group">
                        <label for="details">Details*</label>
                       <textarea class="form-control" id="details" name="details" rows="5" required></textarea>
                      
                      <div class="row form-group">
                    
                        <div class="col-md-5">
                          <label for="proirity">Priority</label>
                            <select class="form-control" id="proirity" name="proirity">
                            <option value="0" selected >Low</option>
                            <option value="1" >Normal</option>
                            <option value="2">High</option>
                        </select>
                        </div>
                    </div>
                <div class="form-group">
                                <div class="col-xs-4" id="todate">
                                <label for="radiotags">Commited Date</label>
                                <div class="input-group"><input type="text" readonly="readonly" style="cursor:pointer;" name="todate" id="todate" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            	</div>
                     </div>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
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
                        <input class="submit btn btn-blue" type="submit" name="add_ticket_sbt" id="add_ticket_sbt" value="Add Ticket" />
                    </div>
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
    
	//Get Radio Values
	function change_account(radiovalue){
		
	if(radiovalue == 'customer'){
		document.getElementById('customerdata').style.display = '';
		document.getElementById('guestdata').style.display = 'none';
		
	}else if(radiovalue == 'guest'){
	
		document.getElementById('customerdata').style.display = 'none';
		document.getElementById('guestdata').style.display = '';
	
	}
	
	
}

 </script>
    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#edit_admin_profile_frm").validate({
            rules: {
				subject : 'required',
				last_name : 'required',
                project_detail: "required",
				username: {
					required: true,
					minlength: 5,
					 maxlength: 20
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
                subject: "This field is required.",
				last_name : "This field is required.",
                display_name: "This field is required.",
				prof_image : "Please select valid image for your profile (Use: jpg, jpeg, gif, tiff, png)",
				username: {
					required: "This field is required.",
					minlength: "Your Username must consist of at least 5 characters",
					maxlength: "Your Username cannot me more than 20 characters"
				},
				email_address: "Enter your valid email address",
            }
        });
    
    });
    </script>

</body>
</html>
