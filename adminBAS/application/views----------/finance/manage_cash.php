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
            
             <div class="row">
                        <div class="col-md-10">
                            <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Manage Cash</div>
                        </div>
                        <div class="col-md-2" align="right">
                        <?php 
                                        if($ALLOW_pages_add== 1){ 
					    ?>
                          <a href="<?php echo SURL?>finance/manage-financial-statistics/add-forum"><span class="glyphicons glyphicons-circle_plus"></span> Add New</a>                        <?php  }  ?>
                        </div>
                    </div>      
                    
             
            </div>
            <div class="panel-body">
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

              
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Forum Name</th>
                      <th>Forum Profile URL</th>
                      <th>Amount (PKR)</th>
                      <th>Option</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                  	<?php
				
						if($forum_count > 0){
							for($i=0;$i<$forum_count;$i++){
							
					?>
                            <tr>
                                <td><?php echo ($i+1);?></td>
                                <td><?php echo $forum_arr[$i]['forum_name'];?></td>
                                <td><?php echo $forum_arr[$i]['forum_profile_url'];?></td>
                                <td><?php echo $forum_arr[$i]['amount'];?></td>
                                <td><?php 
                                    if($ALLOW_user_edit == 1){ 
								?>
                                        <a href="<?php echo base_url()?>finance/manage-financial-statistics/edit-cash/<?php echo $forum_arr[$i]['id'] ?>" type="button" class="btn btn-info btn-gradient" title="Edit Cash"> <span class="glyphicons glyphicons-edit"></span></a>                                
                                <?php	
									}//end if
									
									if($ALLOW_user_delete == 1){ 
								?>
                                	<a href="<?php echo base_url()?>finance/manage-financial-statistics/delete-forum/<?php echo $forum_arr[$i]['id'] ?>" onClick="return confirm('Are you sure you want to delete?')" type="button" class="btn btn-danger btn-gradient" title="Delete Cash"> <span class="glyphicons glyphicons-remove"></span> </a>
                                <?php	
									}//end if

                                 ?></td>
                                
                            </tr>
                    <?php		
							
						}//enf for
						
						}
						else{
					?>	
                        <tr>
	                        <td colspan="8">
                                <div class="alert alert-danger alert-dismissable">
                                No Record(s) Found </div>
                            </td>
                        </tr>
                    <?php		
						}//end if
					?>
                    
                  </tbody>
                </table>
                
                <div align="right">
                	<?php //echo "Showing $start - $end of $total total results"; ?>
                	<?php echo $page_links?>
                </div>

               
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
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

</body>
</html>
