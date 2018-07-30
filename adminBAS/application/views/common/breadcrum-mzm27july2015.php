<div id="topbar">

<div class="row">

<div class="col-md-4">
<?php echo $breadcrum_data?>
</div>

<div class="col-md-4">
<?php

for($i=0; $i<$assign_task_count; $i++){
	
	
	 $end_date=strtotime($assign_task_arr[$i]['end_date']);
	 $today=strtotime(date('F j, Y'));
	 if($today == $end_date){
										
	//  echo '<span  style="color: red; font-weight:bold;">'.date('F j, Y', $end_date).'</span>';
	 }
						  
	 
	
}
 $assign_task_arr;  ?>
</div>
<div class="col-md-4">
	 <div class="row form-group" id="my_project" style="margin-top:14px;" data-intro="
Hello Human!
Cursing ERP for slow speed !! 
<br><br>
I am here to help :) <br>
Use me to quickly navigate to your projects.

<br><br>
I will sleep after 3rd popup.

<br><br>
Striving to make your Life Easy<br>
Production Department

" >
      </div>               
                    
</div>

</div>
 
  
</div>
