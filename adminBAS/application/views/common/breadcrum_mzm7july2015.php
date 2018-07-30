<div id="topbar">

<div class="row">

<div class="col-md-6">
<?php echo $breadcrum_data?>
</div>

<div class="col-md-6">
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

</div>
 
  
</div>
