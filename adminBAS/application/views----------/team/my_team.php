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
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                
                <div class="row">
                        <div class="col-md-10">
                            <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> My Team</div>
                        </div>
                        <div class="col-md-2" align="right">
                       
                        </div>
                   </div> 
                 
                </div>
                
           
                <div class="panel-body padding-bottom-none">
               
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
					
					if($my_team_count > 0){
                ?>
                
                  <table class="table table-striped table-bordered table-hover" id="manage_all_teams">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th class="hidden-xs">Team Title</th>
                        <th class="hidden-xs">Team Head Name</th>
                        <th class="hidden-xs hidden-sm">Branch Name</th>
                        <th class="hidden-xs hidden-sm" >Members</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
					 
					 $user_id=$this->session->userdata('admin_id');
					 for($i=0;$i<$my_team_count;$i++){
					
					?>
                            <tr>
                                <td><span class="xedit"><?php echo ($i+1);?></span></td>
                                <td class="hidden-xs"><?php echo  stripcslashes(strip_tags($my_team_arr[$i]['team_title']));?> </td>
                                <td class="hidden-xs"><strong>
								<?php echo stripcslashes($my_team_arr[$i]['head_name']);?>
                                </strong>
                                </td>
                                <td class="hidden-xs hidden-sm"><?php echo stripcslashes($my_team_arr[$i]['branch_name']) ;?></td>
                                <td class="hidden-xs">
								<?php 
								
								for($j=0; $j<count($my_team_arr[$i]['team']); $j++){
									
								if($my_team_arr[$i]['team_id'][$j]== $user_id){  ?>
                                
								 <span class="label btn-success"><?php echo stripcslashes($my_team_arr[$i]['team'][$j]); ?></span><br>	
									
					        	<?php }else{		
									
								echo "<strong>".stripcslashes($my_team_arr[$i]['team'][$j])."</strong><br>";
								
								}
								}
								
								?>
                                
                               
                                
                                </td>
					
                            </tr>
                    <?php			
						}//end for
					?>
                    </tbody>
                  </table>
                  
                  <?php 
					}else{
				?>
                <div class="alert alert-danger alert-dismissable">
                	<strong>No Team(s) Found</strong> </div>                	
                <?php		
					}//end if
				  ?>
                </div>
                
                 
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row" style="min-height:250px;">&nbsp;</div>
    </div>
  </section>
  <!-- End: Content --> 
  
</div>

<div id="output">Message send</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>

<script type="application/javascript">
	$('#manage_all_teams').dataTable({
		"aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1,-4 ] }],
		"aaSorting": [],
		"oLanguage": { "oPaginate": {"sPrevious": "", "sNext": ""} },
		"iDisplayLength": 25,
		"bPaginate": true, 
		"bLengthChange": true,
		"bFilter": true,
		"aLengthMenu": [[25, 50, 75,100], [25, 50, 75,100]],
		"sDom": 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip',
		"oTableTools": {
			"sSwfPath": "<?php echo VENDOR ?>plugins/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
		}
		
	});	
</script>


<link href="<?php echo CSS ;?>select2.css" rel="stylesheet"/>
<script src="<?php echo JS ; ?>select2.js"></script>
<script>
$(document).ready(function() { $("#search_status").select2(); });
</script>
<script>
$(document).ready(function() { $("#branch_id").select2(); });
</script>

<script>
$(document).ready(function() { $("#role_id").select2(); });
</script>
</body>
</html>
