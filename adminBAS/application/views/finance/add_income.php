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
        <div class="col-md-12"  style="min-height:1300px;">
          <div class="panel">
            <div class="panel-heading">
              <div class="panel-title"> <span class="glyphicon glyphicon-book"></span>Add Income</div>
            </div>
            <div class="panel-body alerts-panel">
              <form class="cmxform" id="edit_admin_profile_frm" method="POST" action="<?php echo SURL?>finance/manage-financial_statistics/add_income_process" enctype="multipart/form-data">
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
                          <label for="standard-list1">Branch Name</label>
                           <select id="branch" name="branch_id" style="width:100%;" required>
                           <option value="">Select Branch Name</option>
                                <?php
								if($branches_count>0){ 
								for($c=0; $c < $branches_count ; $c++){ ?>
										<option value="<?php echo $branches_arr[$c]['id'] ?>"><?php echo $branches_arr[$c]['branch_name'];?></option>
								<?php }} ?>
                          </select>
                        </div>
                    </div>  
                    
                      <div class="row form-group">
                              <label class="col-md-1">Date</label>
                              <div class="col-xs-4" id="todate">
                                   <div class="input-group"><input type="text" readonly style="cursor:pointer;" name="date" id="start_date" class="form-control" required /><span class="input-group-addon"><span id="targetto" onclick="create_date('todate')" class="glyphicon glyphicon-calendar" style="cursor:pointer;"></span></span>
	                        </div>
                            </div>
                             
                            </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="amount">USD</label>
                        <input id="usd" name="income_usd" type="text" class="form-control"  value="" required style="width: 455px;"/>
                      </div>
                      
                      
                      <div class="form-group">
                        <label for="amount">PKR</label>
                        <input id="amount" name="income_pkr" type="text" class="form-control"  value="" required style="width: 455px;" readonly/>
                      </div>
                      
                      
                       
                      <div class="form-group">
                        <label for="value">Description</label>
                        <textarea class="form-control" id="discription" name="discription" rows="8"  style="width: 455px;"></textarea>
                      </div>
                                                        
                 </div>
                  
                    <div class="form-group" align="right" style="margin-right:17px">
                        <input class="submit btn btn-blue" type="submit" name="add_income_sbt" id="add_income_sbt" value="Add Income" />
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

<link href="<?php echo CSS ;?>select2.css" rel="stylesheet"/>
<script src="<?php echo JS ; ?>select2.js"></script>
<script>
$(document).ready(function() { $("#branch").select2(); });
</script>

    <script type="text/javascript">
      jQuery(document).ready(function() {
    
      // validate signup form on keyup and submit
        $("#edit_admin_profile_frm").validate({
            rules: {
				first_name : 'required',
				last_name : 'required',
                display_name: "required",
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
                first_name: "This field is required.",
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
	
	
	$('#usd').on('keyup',function() {
		
	    	var usd = this.value; 
			
			var checkurl = '<?php echo base_url()?>finance/manage-financial-statistics/convert-usd/'+usd;
			$.post(checkurl,usd,function(response,status,xhr) {
				
			//var convert_amount= response;
			
			$('#amount').val(response);
			
			})

		})
		
    </script>

</body>
</html>
