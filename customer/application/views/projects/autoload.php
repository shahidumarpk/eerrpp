<?php  
					
  if($project_messages_count>0){
	  
	  
?>  
   
<?php 
	
	for($i=0; $i<$project_messages_count; $i++){
		
			$row_id = 'row_'.$i;
		
		 ?>

	<div class="asdf" > 
                        <div class="well">
                        	<div class="row" >
                                <div class="col-md-2" style="border-right:1px solid #ccc;">
                                    
                                    <strong class="coltext3"><?php echo  $project_messages_arr[$i]['user'];?><br>
                                    <?php if($project_messages_arr[$i]['avatar_image'] !=""){ ?>    
                                    <div class="thumbnail" style="width: 30%;margin-bottom: 0px;">
        
          <img  src="<?php echo ADMIN_SURL.'assets/user_files/'.$project_messages_arr[$i]['admin_id'].'/'.stripslashes($project_messages_arr[$i]['avatar_image'])?>">
          
                                        </div>
                                        
                                      <?php  } ?>  
                                       <?php if($project_messages_arr[$i]['user_role'] !=""){ ?>                                      
                                      (<?php echo  $project_messages_arr[$i]['user_role'];?>)
                                         
                                      <?php  } ?> 
                                         </strong>
                                        
                                         <br>
                                         <br> 
                                         
                                     <div id="jRate<?php echo $project_messages_arr[$i]['id']?>" style="height:33px;width: 100%;" title="Rating(<?php echo round($project_messages_arr[$i]['admin_rating'],2);?>)"></div>		 								
                                    <div class="text-small"> </div>
                                                                                
                                        <div class="text-small"> </div>
                                 
                                    
                                </div>
                                <div class="col-md-10">
                                
                                <div class="time_date pull-right">
                 
                                        <div class="time">
                                        <i class="fa fa-clock-o"></i>
                                        <span class="c_time"><?php echo date('d M, Y , g:i a',strtotime($project_messages_arr[$i]['created_date'])); ?></span>
                                        
                                        
                                        </div>
                                        
                                        
                                        
                                    </div>
                                
                                    <p><?php echo stripcslashes(strip_tags($project_messages_arr[$i]['message'],'<b><br><a>')) ?></p>
                                    
                                    <?php  if(count($project_message_attachment_arr[$project_messages_arr[$i]['id']]) > 0){ 
									
									for($j=0; $j<count($project_message_attachment_arr[$project_messages_arr[$i]['id']]); $j++){
									
									?>
                                    
                             <div class="col-md-2">              
                            <div class="thumbnail" style="width: 90px;height: 76px;">
                         
							<?php 
							
                             $ext = pathinfo($project_message_attachment_arr[$project_messages_arr[$i]['id']][$j], PATHINFO_EXTENSION) ;
                            
                            if($ext=='jpg' or $ext=='png') {?>
                            
                             <a href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" style="width: 116px;margin-left: -16px;" data-toggle="lightbox" data-gallery="multiimages" data-title="<?php echo $project_attachments_arr[$i]['title'] ?>" class="col-sm-4">
                             
                             
                             <img src="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" data-src="holder.js/100%x180" data-holder-rendered="false" style="width: 86px;height: 65px;">
                             </a>
                            <?php }elseif($ext=='zip' or $ext=='rar'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/zip.png" style="height: 69px;" ></a>
                                
                                <?php }elseif($ext=='doc' or $ext=='docx'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/docx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='xlsx' or $ext=='xls'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/excel.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pptx' or $ext=='ppt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pptx.png" style="height: 69px;" ></a>
                              
                            <?php }elseif($ext=='odt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/odt.png" style="height: 66px;" ></a>
                              
                            <?php }elseif($ext=='pdf'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/pdf.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='txt'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/text.png" style="height: 69px;" ></a>        
                                <?php }elseif($ext=='tif'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo MURL?>assets/img/tiff2.png" style="height: 66px;" ></a>       
                                <?php }elseif($ext=='csv'){ ?>
                              
                                <a class="anchor_style" href="<?php echo MURL?>assets/project_attachments/<?php echo $project_id."/".$project_message_attachment_arr[$project_messages_arr[$i]['id']][$j] ?>" target="_blank" download> <img src="<?php echo SURL?>assets/img/csv.png" style="height: 66px;" ></a>       
                                <?php }  ?>
                                
                                
                              
                              
                            </div>
                            </div>
                           
                         
                              
                          <?php  
						  
						   }//End for loop
						  
						  
					      }//End if ?>
                                    
                                </div>
                            </div>
                        </div>
                        
                         </div>  
     
		<?php
		
		
		 $msg_id =$project_messages_arr[$i]['id'];    
		  
	}//End for ?>
	
	 | 
     
  <?php echo $project_messages_arr[0]['id'];?>
	
<?php  }else{
	  
	  echo "not";
	  
	  }
  
  
		  
 ?> 