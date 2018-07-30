<!-- Core Javascript - via CDN -->
<script src="<?php echo AJAX ?>libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo AJAX ?>libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="<?php echo CSS ?>/bootstrap/3.1.0/js/bootstrap.min.js"></script> 

<!-- Theme Javascript -->
<script type="text/javascript" src="<?php echo JS ?>uniform.min.js"></script>
<script type="text/javascript" src="<?php echo JS ?>main.js"></script>
<!--<script type="text/javascript" src="assets/js/plugins.js"></script>-->
<script type="text/javascript" src="<?php echo JS ?>custom.js"></script>

<!-- Init Theme Core 	 -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		// Init Theme Core 	  
		Core.init();
});
</script>

<?php 
if($PLUGIN_floatchart == 1){
?>
    <!-- FLOAT CHART Addon -->
    <script type="text/javascript" src="<?php echo JS ?>charts.js"></script> 
    <script type="text/javascript" src="<?php echo AJAX ?>libs/flot/0.8.1/jquery.flot.min.js"></script>
    <script type="text/javascript" src="<?php echo AJAX ?>libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/jqueryflot/jquery.flot.resize.min.js"></script>
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/jqueryflot/jquery.flot.pie.min.js"></script> 
    <!-- Flot Charts Addon -->
<script type="text/javascript">
  jQuery(document).ready(function() {
	  
	// Init Theme Core 	  
	//Core.init();
	  
    // This page contains more Initilization Javascript than normal.
	// As a result it has its own js page. See charts.js for more info
	Charts.init();
  
  });
</script>
<?php 
}//end if($PLUGIN_floatchart == 1)

if($PLUGIN_gcal == 1){
?>
    <!--GCAL Plugins -->
    <script type="text/javascript" src="<?php echo AJAX ?>libs/fullcalendar/1.6.4/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/calendar/gcal.js"></script>

<?php	
}//end if($PLUGIN_gcal == 1)

if($PLUGIN_datepicker == 1){
?>
    <!--START: DATE Picker Files -->
   <!-- <script type="text/javascript" src="< ?php echo VENDOR ?>plugins/datepicker/bootstrap-datepicker.js"></script> 
    <script type="text/javascript">
        jQuery(document).ready(function() {
            // Date Picker 
            $('.datepicker').datepicker();
    });
    </script>-->
<script src="<?php echo VENDOR ; ?>plugins/datepicker/js/moment.js"></script>   
<script src="<?php echo VENDOR ; ?>plugins/datepicker/js/bootstrap-datetimepicker.js"></script>   
<script type="text/javascript" src="http://eonasdan.github.io/bootstrap-datetimepicker/scripts/locales/bootstrap-datetimepicker.ru.js"></script>

<script language="javascript">
function create_date(divname){
 jQuery('#'+divname).datetimepicker({
   pickTime: false
   });
}
</script>
    
    <!--END: DATE Picker Files -->

<?php	
}//end if($PLUGIN_datepicker == 1)

if($PLUGIN_datagrid == 1){
	
?>

    <!--START: DATA GRID Files-->
    <script type="text/javascript" src="<?php echo AJAX ?>jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo AJAX ?>jquery.dataTables/1.9.4/jquery.dataTables.delay.min.js"></script>
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/datatables/js/datatables.js"></script><!-- Datatable Bootstrap Addon -->

<?php
}//end if($PLUGIN_datagrid == 1)

if($PLUGIN_form_validation == 1){
?>
	<script type="text/javascript" src="<?php echo VENDOR ?>plugins/validate/jquery.validate.js"></script>
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/validate/additional-methods.js"></script>

<?php	
}//end if($PLUGIN_form_validation == 1)

if($PLUGIN_gallery == 1){
?>
	<script type="text/javascript" src="<?php echo VENDOR ?>plugins/mfpopup/dist/jquery.magnific-popup.min.js"></script> 
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/mixitup/jquery.mixitup.min.js"></script> 
    <script type="text/javascript">
     jQuery(document).ready(function() {
    
        
        // Shared mixitup variables
        var liveEffects = ['fade'];
        var clickEv = 'click';
        
        // Init mixitup 
        $('#Grid').mixitup({
            sortOnLoad: ['data-cat', 'asc'],
            buttonEvent: clickEv,
            onMixStart: function(config){
                // update effects array
                config.effects = liveEffects;
                config.transitionSpeed = 800;
                return config;
            }
        });
    
    
        
        // Add each image item to a gallery popup
        $('#Grid').magnificPopup({
          delegate: 'a', 
          type: 'image',
          disableOn: function() {
              if ($('#Grid li').hasClass('dragging')) {
                 return false;
              }
              return true;
          },
          gallery: {
            enabled: true
          }
        });
                
        
    });
    </script>

<?php 
}//end if($PLUGIN_gallery == 1)
?>

<?php
if($PLUGIN_fancybox == 1){
?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo VENDOR ?>fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="<?php echo VENDOR ?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
   
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("a#example1").fancybox();
		});
	</script>
    
<?php	
}//end if($PLUGIN_ckeditor == 1)
?>
