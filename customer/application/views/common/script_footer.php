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

<!--<script type="text/javascript">
jQuery(document).ready(function() {
	setInterval("hideMsgs();",10000); 
});
function hideMsgs() {
	//jQuery('#autoloadMsg').hide();
	$('#refresh').load(location.href + ' #autoloadMsg');
	$('#autoloadMsg').fadeOut('xfast');
	
}

</script>-->

<!--<script>
    $(document).ready(
            function() {
                setInterval(function() {
                  //  var randomnumber = Math.floor(Math.random() * 100);
                    $('#autoloadMsg').load(location.href + ' #autoloadMsg');
					
                }, 5000);
            });
</script>-->

     
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="<?php echo JS?>visualcaptcha.js"></script>



<script type="text/javascript" src="<?php echo AJAX ?>libs/highchart/highcharts.js"></script>
 
<script type="text/javascript" src="<?php echo AJAX ?>libs/highchart/exporting.js"></script>
 

<?php 
if($PLUGIN_floatchart == 1){
	
	
	
	
?>
    <!-- FLOAT CHART Addon -->
    <script type="text/javascript" src="<?php echo AJAX ?>libs/flot/0.8.1/jquery.flot.min.js"></script>
    <script type="text/javascript" src="<?php echo AJAX ?>libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="<?php echo VENDOR ?>plugins/jqueryflot/jquery.flot.resize.min.js"></script><!-- Flot Charts Addon -->




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
    
    <?php 
//mzm
if($PLUGIN_autolinker == 1){

?>
<script type="text/javascript" src="<?php echo AJAX ?>libs/autolinker/autolinker.min.js"></script>
 
<?php } ?>


<script src="<?php echo VENDOR ; ?>plugins/datepicker/js/moment.js"></script>   
<script src="<?php echo VENDOR ; ?>plugins/datepicker/js/bootstrap-datetimepicker.js"></script>   
<!--<script type="text/javascript" src="http://eonasdan.github.io/bootstrap-datetimepicker/scripts/locales/bootstrap-datetimepicker.ru.js"></script>-->

<script language="javascript">
function create_date(divname){
 jQuery('#'+divname).datetimepicker({
   pickTime: false
   });
}

function create_date_time(divname){
		 jQuery('#'+divname).datetimepicker({
		   pickTime: true
		   });
   
 }
   
   
 function create_date_monthsonly(divname){
	
				jQuery('#'+divname).datetimepicker( {
				format: "MM/YYYY",
				viewMode: "months", 
				minViewMode: "months",
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
			$('.open-popup-link').magnificPopup({
		  type:'inline',
		  midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
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


<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-success btn-gradient start" disabled>
                    <i class="glyphicons glyphicons-upload"></i> 
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-danger btn-gradient cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i> 
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script> 
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" class="item-link" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i> 
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle hidden">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i> 
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}



	$('#opener').on('click', function() {		
		var panel = $('#slide-panel');
		if (panel.hasClass("visible")) {
			panel.removeClass('visible').animate({'margin-left':'-300px'});
		} else {
			panel.addClass('visible').animate({'margin-left':'0px'});
		}	
		return false;	
	});
	
	
	



</script> 


<!-- Optionally loading ALL upload plugins - For demonstration purposes only --> 
<script src="<?php echo VENDOR ?>plugins/jqueryupload/plugins/blueimp/js/tmpl.min.js"></script> 
<script src="<?php echo VENDOR ?>plugins/jqueryupload/plugins/blueimp/js/load-image.min.js"></script> 
<script src="<?php echo VENDOR ?>plugins/jqueryupload/plugins/blueimp/js/canvas-to-blob.min.js"></script> 
<script src="<?php echo VENDOR ?>plugins/jqueryupload/plugins/blueimp/js/jquery.blueimp-gallery.min.js"></script> 
<script src="<?php echo VENDOR ?>plugins/jqueryupload/js/jquery.iframe-transport.js"></script> 
<script src="<?php echo VENDOR ?>plugins/jqueryupload/js/jquery.fileupload.js"></script> 
<script src="<?php echo VENDOR ?>plugins/jqueryupload/js/jquery.fileupload-process.js"></script> 
<script src="<?php echo VENDOR ?>plugins/jqueryupload/js/jquery.fileupload-image.js"></script> 
<script src="<?php echo VENDOR ?>plugins/jqueryupload/js/jquery.fileupload-audio.js"></script> 
<script src="<?php echo VENDOR ?>plugins/jqueryupload/js/jquery.fileupload-video.js"></script> 
<script src="<?php echo VENDOR ?>plugins/jqueryupload/js/jquery.fileupload-validate.js"></script> 
<script src="<?php echo VENDOR ?>plugins/jqueryupload/js/jquery.fileupload-ui.js"></script>

  <!--select 2 mzm -->
<script src="<?php echo JS ; ?>select2.js"></script>

<script type="text/javascript">
	
	//mzm method to load my projects on ajax call
function get_my_projects(){  
	//display spinnner
	$('#my_project').html('Loading Projects ...')
  $.ajax({
    url: '<?php echo SURL?>dashboard/dashboard/my_projects',
    type: 'GET',
    async: true,
    
    success: function (data) {
	//hide spinnner
	$('#my_project').html(data)
	$("#project_id").select2();
		//console.log('get_my_projects_call')
		//console.log(data)
		
       
    }
  });
  
}

//visit my project link from my project dropdown
function visit_project(project_id){
//	console.log(project_id)
	
window.location = "<?php echo SURL?>projects/manage-projects/project-detail/"+project_id;
}



$(document).ready(function() {
	
	get_my_projects();
 });	

</script>