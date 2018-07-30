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



<link rel='stylesheet' href='<?php echo SURL ?>assets/calender/lib/cupertino/jquery-ui.min.css' />
<link href='<?php echo SURL ?>assets/calender/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo SURL ?>assets/calender/fullcalendar.print.css' rel='stylesheet' media='print' />

<script src='<?php echo SURL ?>assets/calender/lib/moment.min.js'></script>
<script src='<?php echo SURL ?>assets/calender/lib/jquery.min.js'></script>
<script src='<?php echo SURL ?>assets/calender/fullcalendar.min.js'></script>
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
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-visible">
                <div class="panel-heading">
                
                 <div class="row">
                        <div class="col-md-10">
                           <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span>Calendar</div>
                        </div>
                        <div class="col-md-2" align="right">
                       
                        </div>
                    </div>      
                    
                  
                </div>
                <div class="panel-body padding-bottom-none">

	            <div id='calendar'></div>
                        
                  
                  
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
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 


<script>

	$(document).ready(function() {

		$('#calendar').fullCalendar({
			theme: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultDate: '<?php echo date('Y-m-d')?>',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
			
			<?php for($i=0; $i<$calendar_count; $i++){  ?>	
				{
					title: 'START: <?php echo $calendar_arr[$i]['event_title']; ?>',
					start: '<?php echo $calendar_arr[$i]['event_start_date']; ?>',
					end: '<?php echo $calendar_arr[$i]['event_start_date']; ?>',
					url: '<?php echo $calendar_arr[$i]['event_url']; ?>' ,
				},
				{
					title: 'END: <?php echo $calendar_arr[$i]['event_title']; ?>',
					start: '<?php echo $calendar_arr[$i]['event_end_date']; ?>',
					end: '<?php echo $calendar_arr[$i]['event_end_date']; ?>',
					url: '<?php echo $calendar_arr[$i]['event_url']; ?>' ,
				},
			<?php } ?>	
				
			
			]
		});
		
	});

</script>
<style>

	

	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}

</style>
</body>
</html>
