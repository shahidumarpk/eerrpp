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
  <?php  echo $INC_left_nav_panel; ?> 
  <!-- End: Sidebar --> 
  <!-- Start: Content -->
  <section id="content"> <?php echo $INC_breadcrum?>
    <div class="container">
      <div class="row">
        <div class="col-md-12" >
      <!--  <img width="800px" src="<?php  echo IMG . 'notification-banner.jpg'?>">
        -->  
        </div>
      </div>
      
     
      <div class="row" style="min-height:600px;">
      
      
      	<div class="col-sm-6">
        
            <div>
            	<div class="row">
					<div class="col-xs-4">
						<!-- Centered text -->
						<div class="stat-panel text-center">
							
						</div> <!-- /.stat-panel -->
					</div>
					<div class="col-xs-4">
						<div class="stat-panel text-center">
							
							
						</div> <!-- /.stat-panel -->
					</div>
					<div class="col-xs-4">
						<div class="stat-panel text-center">
							
							
						</div> <!-- /.stat-panel -->
					</div>
				</div>
            </div>	
        
        </div>
        
        	<div class="row">
		
                <div class="col-md-12 col-sm-12 message-widget">
                	<div class="row">
                    
            			 <div class="col-sm-12 col-md-4">
                                            <div class="dashbox panel panel-default" style="min-height:81px !important;">
                                                    <div class="panel-body" style="margin-bottom:1px">
                                                       <div class="panel-left blue">
                                                            <i class="fa  fa-folder-open fa-3x" ></i>
                                                       </div>
                                                       <div class="panel-right">
                                                            <div class="number"><b><?php echo $open_projects_count; ?></b></div>
                                                            <div class="title"><b>Open Projects</b></div>
                                                            
                                                       </div>
                                                    </div>
                                                 </div>
              								</div>
                         <div class="col-sm-12 col-md-4">
                            					<div class="dashbox panel panel-default" style="min-height:81px !important;">
                                                    <div class="panel-body" style="margin-bottom:1px">
                                                       <div class="panel-left blue">
                                                            <i class="fa fa-times-circle-o fa-3x" ></i>
                                                       </div>
                                                       <div class="panel-right">
                                                            <div class="number"><b><?php echo $close_projects_count; ?></b></div>
                                                            <div class="title"><b>Closed Projects</b></div>
                                                            
                                                       </div>
                                                    </div>
                                                 </div>
                          					</div>                
                         <div class="col-sm-12 col-md-4">
                            					<div class="dashbox panel panel-default" style="min-height:81px !important;">
                                                    <div class="panel-body" style="margin-bottom:1px">
                                                       <div class="panel-left blue">
                                                            <i class="fa fa-file-text-o fa-3x" ></i>
                                                       </div>
                                                       <div class="panel-right">
                                                            <div class="number"><b><?php echo $projects_count; ?></b></div>
                                                            <div class="title"><b>Total Projects</b></div>
                                                            
                                                       </div>
                                                    </div>
                                                 </div>
                          					</div>
                                            
                      
                	</div>
                    
                    
                  
                    <div class="row">
                          <div class="col-md-12">
                           <div class="panel">
                            <div class="panel-heading">
                              <div class="panel-title"> <span class="glyphicon glyphicon-stats"></span> Daily Task Report</div>
                            </div>
                            <div class="panel-body">
                               <div id="daily_chart" style="min-width: 300px; height: 250px; margin: 0 auto"></div>
                            </div>
                          </div>
                         </div>
            
                   </div>
                   
                   
               
                  <div class="panel">
                      <div class="panel-heading">
                              <div class="panel-title"> <span class="fa fa-tasks"></span> In Progress Projects</div>
                            </div>
                            <div class="panel-body">
                              <div class="table-sorted">
                        		<table class="table table-striped">
                                	<tr>
                                    	<th>Project Name</th>
                                        <th>Message(s)</th>
                                        <th>Action</th>
                                    </tr>
                           		 <?php
        
									if($projects_count >0){ ?>
									
									<?php  for($i=0; $i<$projects_count; $i++)
									 {
									?>
									<tr>
                                    	<td><?php echo $projects_arr[$i]['project_title'];  ?></td>
                                        <td><?php if($projects_arr[$i]['num_messages'] !=""){ echo $projects_arr[$i]['num_messages'];?> New Message(s) <?php  }else{echo "No New Message";} ?></td>
                                        <td>
                                        <div class="btn-group">
                                          <button type="button" class="btn btn-default btn-gradient dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-cogwheel"></span> Action </button>
                                          <ul class="dropdown-menu checkbox-persist pull-right text-left" role="menu">
                                            <li><a href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $projects_arr[$i]['id'] ?>" ><i class="fa fa fa-eye"></i> Details </a></li>
                                            <li><a href="<?php echo base_url()?>projects/manage-projects/manage-project-task/<?php echo $projects_arr[$i]['id'] ?>" ><i class="fa fa-info-circle"></i> Tasks </a></li>
                                          </ul>
                                        </div>
                                        </td>
									</tr>
									
                           <?php } }  ?>
                           </table>
                           </div>
                            </div>
                        </div>
                 
                  </div>
                  
                </div>
              <!--  <div class="col-md-3 message-widget">
                    <div class="rightMarquee" >
                    <h2 >Notifications</h2>
                       <div id="strap">
                        <a href="https://play.google.com/store/apps/details?id=birclient_erp.bir.com.bir_client_erp" title="Click here to download app" target="_blank"> <img src="<?php echo SURL ?>assets/img/Button.png"  style="margin-left: 36px;"  class="thumbnail" /></a>
                        
                        <a href="https://itunes.apple.com/us/app/bir-erp-client/id1019502530?ls=1&mt=8" title="Click here to download app" target="_blank"> <img src="<?php echo SURL ?>assets/img/app-store.png"  style="margin-left: 36px;"  class="thumbnail" /></a>
                         
                        </div>
                        
                        <div id="strap">
                        <h3><a href="<?php echo SURL?>app" target="_blank">Learn More</a></h3>
                        </div>
                    </div>
                </div>-->
            </div>
      </div>
      
      
    </div>
  </section>
  <!-- End: Content --> 
 
  
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer style="margin-top: 270px;"> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>

<script language="javascript">


function daily_chart(data){
	//console.log('closing_chart')
	//data1 = data
    $('#daily_chart').highcharts({

        title: {
            text: 'Daily Tasks'
        },

        xAxis: {
           
		   // tickInterval: 7 * 24 * 3600 * 1000, // one week
			
			type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                month: '%e. %b',
                year: '%b'
            },
			
			title: {
                text: 'Dates'
            }
			
			
			
        },

        yAxis: {
            type: 'line',
            

				title: {
					text: 'Number of Tasks'
				}
		 },

        tooltip: {
		  // headerFormat: '<b>{series.name}</b><br />',
            headerFormat: '<b>Details</b><br />',
           // pointFormat: 'Date = {point.x}, Price = {point.y}'
			 pointFormat: 'Date : {point.x:%e %b} , <br> Task(s) :  {point.task_name}'
			
			  
        },

        series:  [{
			  name: 'Daily Tasks Last 5 Days - Next 5 Days',
               data:  data ,
            pointStart: 1
        }], 
    });

}



$(document).ready(function() {
	
 
  //console.log(1);
  //funtion to get closing projects for last 5 days and 5 days in future
$.ajax({
    url: '<?php echo SURL?>dashboard/dashboard/daily_tasks',
    type: 'GET',
    async: true,
    
    success: function (data) {
		
		console.log('daily_chart')
		console.log(data)
		
        daily_chart(data);
    }
  });
  
 
 


  
 }); //end of document on ready



</script>
  

</body>
</html>
