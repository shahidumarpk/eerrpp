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
   <div id="my_project"></div>
      
    <div class="container">
    
    <div class="row">
		<div align="center" ><!--<a href="https://play.google.com/store/apps/details?id=bir.home.adminerp" target="_blank"><img src="<?php echo IMG?>we-are-coming.png"></a>-->
		</div>
	</div>
    
    <?php if($ALLOW_dashboard_charts==1){ ?>
    
    
    
    <div class="row">
				<div class="col-md-6">
                	<div class="panel" >
                <div class="panel-heading">
                  <div class="panel-title"  > <span class="glyphicon glyphicon-stats"></span> Awarded Projects </div>
                </div>
                <div class="panel-body">
                 <div id="awarded_projects_chart" style="min-width: 300px; height: 250px; margin: 0 auto"></div>
                </div>
              </div>
                </div>   
                <div class="col-md-6">
                	<div class="panel">
                <div class="panel-heading">
                  <div class="panel-title"> <span class="glyphicon glyphicon-stats"></span> Income </div>
                </div>
                <div class="panel-body">
                   <div id="income_chart" style="min-width: 300px; height: 250px; margin: 0 auto"></div>
                </div>
              </div>
                </div>   
                
          </div>
                
                
                  <div class="row">
                  
                  
                <div class="col-md-12">
                	<div class="panel">
                <div class="panel-heading">
                  <div class="panel-title"> <span class="glyphicon glyphicon-stats"></span> Closing Projects </div>
                </div>
                <div class="panel-body">
                   <div id="closing_chart" style="min-width: 300px; height: 250px; margin: 0 auto"></div>
                </div>
              </div>
                </div>
                
                
                        
            </div>
    
      
           
        
     
    
     
    <?php } ?>
    
    
    <?php if($ALLOW_dashboard_statistics==1){ ?>
    
     <div class="row">
        <div class="col-md-12" style="min-height:180px;" >
          <div id="console-btns">
          
           <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-group fa-3x" style="color:#fa603d;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php echo $customers_count; ?></b></div>
												<div class="title"><b>Clients</b></div>
												
										   </div>
										</div>
									 </div>
              </div>
              
              
          
               <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-file-text fa-3x" style="  color: #36a9e1;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php echo $projects_count; ?></b></div>
												<div class="title"><b>Projects</b></div>
												
										   </div>
										</div>
									 </div>
              </div>
              
              
               <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-file-o fa-3x" style=" color: #e84c8a;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php echo $open_projects_count; ?></b> </div>
												<div class="title"><b>Open Projects</b></div>
												
										   </div>
										</div>
									 </div>
              </div>
              
              
                <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa  fa-check-square  fa-3x" style="color:#090;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php echo $close_projects_count; ?></b> </div>
												<div class="title"><b>Closed Projects</b></div>
												
										   </div>
										</div>
									 </div>
              </div>
              
              
                <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa  fa-times  fa-3x" style="color:#F00;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php echo $cancel_projects_count; ?></b> </div>
												<div class="title"><b>Cancel Projects</b></div>
												
										   </div>
										</div>
									 </div>
              </div>
              
              
              <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa  fa-eye-slash  fa-3x" style="color:#fabb3d;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php echo $hold_projects_count; ?></b> </div>
												<div class="title"><b>Hold Projects</b></div>
												
										   </div>
										</div>
									 </div>
              </div>
              
           
            </div>
          </div>
       </div> 
           
        <div class="row">
        <div class="col-md-12" style="min-height:160px;">
          <div id="console-btns">   
              
                <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-bar-chart-o fa-3x" style=" color:#ff5454;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b style="font-size: 18px;"><?php echo number_format($total_income,2,".",","); ?></b> </div>
												<div class="title"><b>Income</b></div>
												
										   </div>
										</div>
									 </div>
              </div>
              
              
              
              <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-bar-chart-o fa-3x" style=" color:#ff5454;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b style="font-size: 18px;"><?php echo number_format($total_expense,2,".",","); ?></b> </div>
												<div class="title"><b>Expense</b></div>
												
										   </div>
										</div>
									 </div>
              </div>
             
             
              <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-bar-chart-o fa-3x" style=" color:#ff5454;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b style="font-size: 18px;"><?php echo number_format($expected_income,2,".",","); ?></b> </div>
												<div class="title"><b>Expected Income</b></div>
												
										   </div>
										</div>
									 </div>
              </div>
              
            
              
              
              
          
          </div>
        </div>
     </div>
     
    
     
    <?php } ?>
    
    
    
       <?php if($ALLOW_my_dashboard_statistics==1){ ?>
    
     <div class="row">
        <div class="col-md-12" >
          <div id="console-btns">
          
          
               <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-file-text fa-3x" style="color: #fa603d;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php if($my_projects !=""){echo $my_projects; }else{echo "0";} ?></b></div>
												<div class="title"><b>My Projects</b></div>
												
										   </div>
										</div>
									 </div>
              </div>
              
              
               <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-file-o  fa-3x" style="color: #e84c8a;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php if($my_open_projects !=""){echo $my_open_projects;}else{echo "0";} ?></b> </div>
												<div class="title">Open Projects</div>
												
										   </div>
										</div>
									 </div>
              </div>
              
              
                <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa  fa-eye-slash  fa-3x" style="color:#fabb3d;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php if($my_hold_projects !=""){echo $my_hold_projects;}else{echo "0";} ?></b> </div>
												<div class="title">Hold Projects</div>
												
										   </div>
										</div>
									 </div>
              </div>
              
              
                <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-check-square fa-3x" style="color: #090;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php if($my_closed_projects !=""){echo $my_closed_projects;}else{echo "0";} ?></b> </div>
												<div class="title">Closed Projects</div>
												
										   </div>
										</div>
									 </div>
              </div>
              
              
              
               <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa  fa-times  fa-3x" style="color:#F00;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php if($my_cancel_projects !=""){echo $my_cancel_projects;}else{echo "0";} ?></b> </div>
												<div class="title">Cancel Projects</div>
												
										   </div>
										</div>
									 </div>
              </div>
              
                </div>
			</div>
		</div>
              
              
           
       <div class="row">
        <div class="col-md-12" style="min-height:150px;">
          <div id="console-btns"> 
              
                <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-th-large fa-3x" style="color: #36a9e1;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php if($my_tasks !=""){echo $my_tasks;}else{echo "0";} ?></b> </div>
												<div class="title">Total Tasks</div>
												
										   </div>
										</div>
									 </div>
              </div>
              
              
              
              <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa  fa-th-list fa-3x" style="color: #ff5454;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php if($my_open_tasks !=""){echo $my_open_tasks;}else{echo "0";} ?></b> </div>
												<div class="title">Open Tasks</div>
												
										   </div>
										</div>
									 </div>
              </div>
              
               <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa  fa-eye-slash  fa-3x" style="color:#fabb3d;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php if($my_hold_tasks !=""){echo $my_hold_tasks;}else{echo "0";} ?></b> </div>
												<div class="title">Hold Tasks</div>
												
										   </div>
										</div>
									 </div>
              </div>
             
             
              <div class="col-sm-6 col-md-3">
              	<div class="dashbox panel panel-default" style="height: 81px;">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-arrow-up fa-3x" style="color:#090;"></i>
										   </div>
										   <div class="panel-right">
												<div class="number"><b><?php if($my_closed_tasks){echo $my_closed_tasks;}else{echo "0";} ?></b> </div>
												<div class="title">Closed Tasks</div>
												
										   </div>
										</div>
									 </div>
              </div>
              
            
              
              
              
          
          </div>
        </div>
     </div>
     
    
     
    <?php } ?>
    
    
      <div class="row">
        <div class="col-md-12" >
          <div id="console-btns">
        
           <?php 
			$c = 0;

			foreach($nav_panel_arr as $main_menu_index => $main_menu){
				
				if(in_array($main_menu['menu_id'],$this->session->userdata('permissions_arr'))){
					
					if($main_menu['status']  == 1){
				
					

		?>
            
              <div class="col-sm-6 col-md-3">
                <a href="<?php echo ($main_menu['url_link'] == '#') ? '#main_menu_'.$main_menu_index  : SURL.$main_menu['url_link']?>" >
                <div class="console-btn">
                  <div class="console-icon divider-right"> <span class="glyphicons <?php echo $main_menu['menu_icon_class']?>"></span> </div>
                  <div class="console-text">
                    <div class="console-title"><?php echo $main_menu['menu_title']?></div>
                    <div class="console-subtitle">View More <i class="fa fa-caret-right"></i> </div>
                  </div>
                </div>
                   </a>
              </div>
           
              
     <?php   
					}//end if($main_menu['status']  == 1)
				
				}//end if(in_array($main_menu_index,$this->session->userdata('permissions_arr')))
				
			}//end foreach
			
		?>      
           
             
            
           
              <div class="col-sm-6 col-md-3">
                <a href="javascript:void(0);" onClick="fetch_tickets();"><div class="console-btn">
                  <div class="console-icon divider-right"> <span class="glyphicons glyphicons-download"></span> </div>
                  <div class="console-text">
                    <div class="console-title">Fetch Tickets</div>
                    <div class="console-subtitle">&nbsp;</div>
                  </div>
                </div></a>
              </div>
         
            
            <?php
			
		//	if($project_messages_count >0){ ?>
            
            <?php // for($i=0; $i<$project_messages_count; $i++)
		//	 {
		    ?>
			
            
			<!--<p><strong>Project Name: <?php echo $project_messages_arr[$i]['project_title'];  ?></strong>  : <a href="<?php echo base_url()?>projects/manage-projects/project-detail/<?php echo $project_messages_arr[$i]['project_id'] ?>" >(<?php echo $project_messages_arr[$i]['num_messages'];?>) New Messages</a></p>-->
            
            
            
          <?php //} }  ?>
          
          
            <div class="row">
              <div class="col-sm-12" id="ticket_response">
                
              </div>
            </div>
           
          </div>
        </div>
      </div>
      
     
      <div class="row" style="min-height:350px;">&nbsp;</div>
    </div>
  </section>
  <!-- End: Content --> 
  
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer style="margin-top: 270px;"> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="min-width:760px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Guess What! ERP has an Andriod App Now !!</h4>
      </div>
      <div class="modal-body"  id="myModal1" >
      
      <img src="<?php echo SURL . '/assets/img/ayat.jpg'?>">
      <br><br>
      
        <p>Visit Google Play Store to Download your copy :)</p>
       
        
       <a href="https://play.google.com/store/apps/details?id=bir.home.adminerp"> <img src="<?php echo SURL . '/assets/img/erp_admin_google.png'?>"></a>


        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<?php echo $INC_header_script_footer;?>



<script type="text/javascript">

$(document).ready(function() {
	
	//introJs().start();
	
	
	});

</script>


<script language="javascript">
function fetch_tickets(){
 document.getElementById('ticket_response').innerHTML = "<img class='loading' src='<?php echo IMG ; ?>ajax-loader.gif' alt='loading...' /><br>Please wait .....";

 var request_url = "<?php echo MURL ; ?>cron_email_reader.php";
 jQuery.post(
  request_url, {flag : true}, function(responseText){
	 
  	if(responseText == '0'){
		responseText = '<div class="alert alert-info">No Ticket(s) found</div>';
  		jQuery("#ticket_response").html(responseText);  
  	}else{
  		responseText = '<div class="alert alert-success alert-dismissable">'+responseText+' Ticket(s) fetched successfully</div>';
  		jQuery("#ticket_response").html(responseText);
  	}
  }, "html"
 );
}//end check_nic_exist


//mzm
//charts funtion

 

  
  //mzm : Function to populate awarded projects data. The funtion will be triggered by its respective ajax call
 function awarded_projects_chart(data){
	
	//data1 = data
    $('#awarded_projects_chart').highcharts({

        title: {
            text: 'Awarded Projects'
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
            //minorTickInterval: 0.1,

				title: {
					text: 'Amount in $'
				}
		 },

        tooltip: {
		  // headerFormat: '<b>{series.name}</b><br />',
            headerFormat: '<b>Details</b><br />',
           // pointFormat: 'Date = {point.x}, Price = {point.y}'
			 pointFormat: 'Date : {point.x:%e %b} , Amount : ${point.y} <br> Project(s) :  {point.project_name}'
			  
        },

        series:  [{
			  name: 'Awarded Projects in Last 10 Days',
               data:  data ,
            pointStart: 1
        }], 
    });

}




  //mzm : Function to populate income chart. The funtion will be triggered by its respective ajax call
 function income_chart(data){
	//console.log('income_chart')
	//data1 = data
    $('#income_chart').highcharts({

        title: {
            text: 'Income'
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
					text: 'Amount in $'
				}
		 },

        tooltip: {
		  // headerFormat: '<b>{series.name}</b><br />',
            headerFormat: '<b>Details</b><br />',
           // pointFormat: 'Date = {point.x}, Price = {point.y}'
			 pointFormat: 'Date : {point.x:%e %b} , Amount : ${point.y}'
			  
        },

        series:  [{
			  name: 'Income in Last 10 Days',
               data:  data ,
            pointStart: 1
        }], 
    });

}





  //mzm : Function to populate closing chart. The funtion will be triggered by its respective ajax call
 function closing_chart(data){
	//console.log('closing_chart')
	//data1 = data
    $('#closing_chart').highcharts({

        title: {
            text: 'Closing Projects'
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
					text: 'Number of Projects'
				}
		 },

        tooltip: {
		  // headerFormat: '<b>{series.name}</b><br />',
            headerFormat: '<b>Details</b><br />',
           // pointFormat: 'Date = {point.x}, Price = {point.y}'
			 pointFormat: 'Date : {point.x:%e %b} , Amount : ${point.amount} <br> Project(s) :  {point.project_name}'
			
			  
        },

        series:  [{
			  name: 'Closing Projects Last 5 Days - Next 5 Days',
               data:  data ,
            pointStart: 1
        }], 
    });

}





 
 <?php if($ALLOW_dashboard_charts==1){ ?>


$(document).ready(function() {
	
//funtion to get awarded project chart data
$.ajax({
    url: '<?php echo SURL?>dashboard/dashboard/awarded_projects_chart',
    type: 'GET',
    async: true,
    
    success: function (data) {
		console.log('awarded_projects_chart')
		console.log(data);
        awarded_projects_chart(data);
    }
  });

 
 
 //funtion to get income chart data
$.ajax({
    url: '<?php echo SURL?>dashboard/dashboard/income_chart',
    type: 'GET',
    async: true,
    
    success: function (data) {
		console.log('income_chart')
		console.log(data)
        income_chart(data);
    }
  });
  
     
  //console.log(1);
  //funtion to get closing projects for last 5 days and 5 days in future
$.ajax({
    url: '<?php echo SURL?>dashboard/dashboard/closing_projects',
    type: 'GET',
    async: true,
    
    success: function (data) {
		
		console.log('closing_chart')
		console.log(data)
		
        closing_chart(data);
    }
  });
  
 
 


  
 }); //end of document on ready




  
<?php } ?>


$(document).ready(function() {
	


	//$('#myModal1').fireworks();
		//$("#myModal").modal()

	
  });


</script>


<script type="text/javascript" src="<?php echo JS ?>jquery.fireworks.js"></script>

</body>
</html>
