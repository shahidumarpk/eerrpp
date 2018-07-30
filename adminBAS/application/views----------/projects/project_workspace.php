<!DOCTYPE html>
<html>
<head>

<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<title><?php echo $meta_title ?></title>
<meta name="keywords" content="<?php echo $meta_keywords ?>" />
<meta name="description" content="<?php echo $meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="<?php echo CSS?>ekko-lightbox.css" rel="stylesheet">
<?php echo $INC_header_script_top; ?>
</head>

<style type="text/css">
.chat-panel .media-content{
	
	line-height: 146px;
	}
</style>

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
	<div class="row" style="min-height:1300px;">
        <div class="col-md-12 chat-widget">
               <div class="panel chat-panel">
                <div class="panel-heading">
                  <div class="panel-title">
                  <span class="glyphicon glyphicon"></span>Project Workspace</div>
                  <div class="panel-tray pull-right">
                  </div>
                  <div class="mini-action-icons margin-right-sm pull-right"> 
                  	
                  </div>
               </div>
              
                      <div style="display:none;" id="show_message" class="alert alert-success alert-dismissable"><?php echo "File Uploaded Successfully";?></div>
               
                       <div  style="display:none;" class="alert alert-danger"><?php echo "File not Uploaded"; ?></div>
             
                <div class="panel-body">
                	<div class="media">
                    <div class="media-body">
                    <div class="media-content">
                    
                    <div class="gridlock demo">      		
                        <article class="row page">
                            <div class="mobile-full tablet-full desktop-8 desktop-push-2">
                                
                                <form action="#" class="demo_form">
                                    <div class="dropped" style="padding-top: 20px; height: 227px;"></div>
                
                                    <div class="filelists">
                                        
                                    </div>
                                </form>
                
                            </div>
                       </article>
                   </div>                 
                    </div>
                    </div>
                  </div>
                    <div class="clearfix">&nbsp;</div>
                 <?php  if($project_workspace_count >0){ ?>    
                 <div class="well">
                 <div class="panel-body alerts-panel">
                     <div class="row">
                     
					  <?php for($i=0; $i<$project_workspace_count; $i++) { ?>
                      
                       <div class="col-md-4">
                            <div class="thumbnail" style="width: 220px;height: 157px;" title="<?php echo $project_workspace_arr[$i]['attachments']; ?>">
                
							<?php 
                             $ext = pathinfo($project_workspace_arr[$i]['attachments'], PATHINFO_EXTENSION) ;
                            
                            if($ext=='jpg' or $ext=='JPG' or $ext=='png') {?>
                             <a href="<?php echo MURL?>assets/project_attachments/<?php echo $project_workspace_arr[$i]['project_id']."/".$project_workspace_arr[$i]['attachments'] ?>" style="margin-left: -36px;width:136%;" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $project_workspace_arr[$i]['title'] ?>" class="col-sm-4">
                             
                             <img src="<?php echo MURL?>assets/project_attachments/<?php echo $project_workspace_arr[$i]['project_id']."/".$project_workspace_arr[$i]['attachments'] ?>" data-src="holder.js/100%x180" data-holder-rendered="false" style="width: 113px; height: 96px;">
                             </a>
                            <?php }elseif($ext=='zip' or $ext=='rar'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_workspace_arr[$i]['project_id']."/".$project_workspace_arr[$i]['attachments'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/zip.png" style="height: 62px;" ></a>
                              
                              <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_workspace_arr[$i]['project_id']."/".$project_workspace_arr[$i]['attachments'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 62px;" ></a>
                                <?php }elseif($ext=='doc' or $ext=='docx'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_workspace_arr[$i]['project_id']."/".$project_workspace_arr[$i]['attachments'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/docx.png" style="height: 62px;" ></a>
                                <?php  }
								elseif($ext=='odt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_workspace_arr[$i]['project_id']."/".$project_workspace_arr[$i]['attachments'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/odt.png" style="height: 69px;" ></a>
                              
                            <?php }
							elseif($ext=='pptx' or $ext=='ppt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_workspace_arr[$i]['project_id']."/".$project_workspace_arr[$i]['attachments'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_workspace_arr[$i]['project_id']."/".$project_workspace_arr[$i]['attachments'];?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 62px;" ></a> 
                                
                                <?php } elseif($ext=='csv'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_workspace_arr[$i]['project_id']."/".$project_workspace_arr[$i]['attachments'] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/csv.png" style="height: 62px;" ></a> 
                                <?php  } ?>
                              
                              <div class="caption">
                                <p><?php echo $deals_result_arr[$i]['detail']; ?></p>
                                <div class="clearfix"></div>
                                 
                                 <p style="padding-top: 10px;"><?php echo date('d, M Y h:i:s a', strtotime($project_workspace_arr[$i]['created_date'])); ?></br>
                                 <?php echo ucfirst($project_workspace_arr[$i]['admin_name']);?></p>
                                 <div class="clearfix"></div>
                              </div>
                            </div>
                     <div class="clearfix"></div>
              </div>
                      <?php } ?>
          
        </div>
                 </div>
                  </div>
                  <?php } ?>
                  
           
        
     </div>
    
  </section>
  <!-- End: Content --> 
</div>
<!-- End: Main --> 
<!-- Start: Footer -->
<footer> <?php echo $INC_footer;?> </footer>
<!-- End: Footer --> 
<?php echo $INC_header_script_footer;?>

<link href="<?php  echo CSS?>jquery.fs.dropper.css" rel="stylesheet" type="text/css" media="all">
<script src="<?php  echo JS?>jquery.fs.dropper.js"></script>

		<!--[DEMO:START-RESOURCES]-->

		<style>
			.demo .filelists { margin: 20px 0; }
			.demo .filelists h5 { margin: 10px 0 0; }

			.demo .filelist { margin: 0; padding: 10px 0; }
			.demo .filelist li { background: #fff; border-bottom: 1px solid #eee; font-size: 14px; list-style: none; padding: 5px; }
			.demo .filelist li:before { display: none; }
			.demo .filelist li .file { color: #333; }
			.demo .filelist li .progress { color: #666; float: right; font-size: 10px; text-transform: uppercase; }
			.demo .filelist li .delete { color: red; cursor: pointer; float: right; font-size: 10px; text-transform: uppercase; }
			.demo .filelist li.complete .progress { color: green; }
			.demo .filelist li.error .progress { color: red; }
		</style>

		<script>
			var $filequeue,
				$filelist;

			$(document).ready(function() {
				$filequeue = $(".demo .filelist.queue");
				$filelist = $(".demo .filelist.complete");

				$(".demo .dropped").dropper({
					action: "<?php  echo SURL?>projects/manage-projects/project-workspace-process/<?php echo $project_id?>",
					maxSize: 10000048576
				}).on("start.dropper", onStart)
				  .on("complete.dropper", onComplete)
				  .on("fileStart.dropper", onFileStart)
				  .on("fileProgress.dropper", onFileProgress)
				  .on("fileComplete.dropper", onFileComplete)
				  .on("fileError.dropper", onFileError);
				

				$(window).one("pronto.load", function() {
					$(".demo .dropped").dropper("destroy").off(".dropper");
				});
				
				
				$filequeue = $(".demo .filelist.queueb");
				$filelist = $(".demo .filelist.completeb");
				
				$(".demo .droppedb").dropper({
					action: "upload.php",
					maxSize: 10000048576
				}).on("start.dropperb", onStart)
				  .on("complete.dropperb", onComplete)
				  .on("fileStart.dropperb", onFileStart)
				  .on("fileProgress.dropperb", onFileProgress)
				  .on("fileComplete.dropperb", onFileComplete)
				  .on("fileError.dropperb", onFileError);
				
				$(window).one("pronto.load", function() {
					$(".demo .droppedb").dropperb("destroy").off(".dropperb");
				});
				
			});

			function onStart(e, files) {
				console.log("Start");

				var html = '';

				for (var i = 0; i < files.length; i++) {
					html += '<li data-index="' + files[i].index + '"><span class="file">' + files[i].name + '</span><span class="progress">Queued</span></li>';
				}

				$filequeue.append(html);
			}

			function onComplete(e) {
				console.log("Complete");
				
				
				$('#show_message').show();
				location.reload();
			
				//alert('file uploaded');
				// All done!
			}

			function onFileStart(e, file) {
				console.log("File Start");

				$filequeue.find("li[data-index=" + file.index + "]")
						  .find(".progress").text("0%");
			}

			function onFileProgress(e, file, percent) {
				console.log("File Progress");

				$filequeue.find("li[data-index=" + file.index + "]")
						  .find(".progress").text(percent + "%");
			}

			function onFileComplete(e, file, response) {
				console.log("File Complete");

				if (response.trim() === "" || response.toLowerCase().indexOf("error") > -1) {
					$filequeue.find("li[data-index=" + file.index + "]").addClass("error")
							  .find(".progress").text(response.trim());
				} else {
					var $target = $filequeue.find("li[data-index=" + file.index + "]");

					$target.find(".file").text(file.name);
					$target.find(".progress").remove();
					$target.appendTo($filelist);
				}
			}

			function onFileError(e, file, error) {
				console.log("File Error");

				$filequeue.find("li[data-index=" + file.index + "]").addClass("error")
						  .find(".progress").text("Error: " + error);
			}
		</script>   
        
        <script src="<?php echo JS?>ekko-lightbox.js"></script>
     <script type="text/javascript">
            $(document).ready(function ($) {
                // delegate calls to data-toggle="lightbox"
                $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        onShown: function() {
                            if (window.console) {
                                return console.log('Checking our the events huh?');
                            }
                        },
						onNavigate: function(direction, itemIndex) {
                            if (window.console) {
                                return console.log('Navigating '+direction+'. Current item: '+itemIndex);
                            }
						}
                    });
                });

                //Programatically call
                $('#open-image').click(function (e) {
                    e.preventDefault();
                    $(this).ekkoLightbox();
                });
                

				// navigateTo
                $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        onShown: function() {

							var a = this.modal_content.find('.modal-footer a');
							if(a.length > 0) {

								a.click(function(e) {

									e.preventDefault();
									this.navigateTo(2);

								}.bind(this));

							}

                        }
                    });
                });


            });
        </script>     
        
</body>
</html>