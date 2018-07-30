<div class="messages-menu" title="New inbox messages"><button type="button" class="btn btn-sm dropdown-animate" data-toggle="dropdown"><span class="glyphicon glyphicon-comment" style=""></span> <span style="color:#3FA9F5;"><b><?php if($messages_count !=0){echo $messages_count; }?></b></span></button>
      <ul class="dropdown-menu checkbox-persist" role="menu">
        <li class="menu-arrow">
          <div class="menu-arrow-up"></div>
        </li>
        <li class="dropdown-header">Recent Messages <span class="pull-right glyphicons glyphicons-comment"></span></li>
        <li>
          <ul class="dropdown-items">
          <?php if(count($messages_arr)>0){
			  
			  for($i=0; $i<count($messages_arr); $i++){
			   ?>
            <li>
              <a href="<?php echo SURL?>messages/manage-messages/message-inbox-detail/<?php echo $messages_arr[$i]['message_id'];?>"><div class="item-message"><b><?php echo $messages_arr[$i]['user_name']; ?></b> - <small class="text-muted"><?php echo $messages_arr[$i]['time_ago']; ?></small><br>
                <?php echo stripslashes($messages_arr[$i]['subject']); ?></div></a>
            </li>
         <?php }}else{echo "&nbsp; No new messages found";} ?>   
          </ul>
        </li>
        <li class="dropdown-footer"><a href="<?php echo SURL?>messages/manage-messages/inbox/0">View All Messages <i class="fa fa-caret-right"></i> </a></li>
      </ul>
    </div>
   
   
   
    
    <div class="alerts-menu" title="New inbox notifications">
      <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-bell"></span><b><span style="color:#3FA9F5;"><?php if($inbox_notifications_count !=0){echo $inbox_notifications_count;} ?></span></b> </button>
      <ul class="dropdown-menu checkbox-persist" role="menu">
        <li class="menu-arrow">
          <div class="menu-arrow-up"></div>
        </li>
        <li class="dropdown-header">Recent Notifications <span class="pull-right glyphicons glyphicons-bell"></span></li>
        <li>
          <ul class="dropdown-items">
          
           <?php if($inbox_notifications_count>0){
			  
			  for($i=0; $i<count($inbox_notifications_arr); $i++){
			   ?>
            <li>
              <a href="<?php echo SURL?>messages/manage-messages/message-inbox-detail/<?php echo $inbox_notifications_arr[$i]['message_id'];?>"><div class="item-message"><b><?php echo $inbox_notifications_arr[$i]['user_name']; ?></b> - <small class="text-muted"><?php echo $inbox_notifications_arr[$i]['time_ago']; ?></small><br>
                <?php echo stripslashes($inbox_notifications_arr[$i]['subject']); ?></div></a>
            </li>
         <?php }}else{echo "&nbsp; No new notifications found";} ?>   
            
          </ul>
        </li>
        <li class="dropdown-footer"><a href="<?php echo SURL?>messages/manage-messages/inbox/1">View All Notifications <i class="fa fa-caret-right"></i> </a></li>
      </ul>
    </div>
    
    <div class="alerts-menu" title="New assign task">
      <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-tag"></span><span style="color:#3FA9F5;"> <b><?php if($assign_task_notifiations_count !=0){ echo $assign_task_notifiations_count;}?></b></span> </button>
      <ul class="dropdown-menu dropdown-checklist checkbox-persist animated-short" role="menu">
        <li class="menu-arrow">
          <div class="menu-arrow-up"></div>
        </li>
        <li class="dropdown-header">Recent Tasks <span class="pull-right glyphicons glyphicons-tag"></span></li>
        <li>
          <ul class="dropdown-items">
          <?php if($assign_task_notifiations_count>0){
			  
			  for($i=0; $i<$assign_task_notifiations_count; $i++){
			   ?>
            <li><strong>
            <a href="<?php echo SURL?>projects/manage-projects/assign-task-detail/<?php echo $assign_task_notifiations_arr[$i]['id'];?>">  <div class="item-message text-slash"><?php echo stripslashes($assign_task_notifiations_arr[$i]['title']);?></div></a>
              <div class="item-label"><span class="label label-success pull-right">New</span></div>
              
            </strong></li>
          <?php }}else{echo "&nbsp; No new tasks found";} ?> 
          </ul>
        </li>
        <li class="dropdown-footer"><a href="<?php echo SURL?>projects/manage-projects/manage-task">View All Tasks <i class="fa fa-caret-right"></i> </a></li>
      </ul>
    </div>

    <div class="btn-group user-menu">
      <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-user"></span> <b>Welcome</b> <?php echo $this->session->userdata('display_name');?> </button>
      <button type="button" class="btn btn-sm dropdown-toggle padding-none" data-toggle="dropdown"> <img src="<?php echo ($this->session->userdata('profile_image') == '') ? IMG."avatars/default_user.png" : USER_FOLDER.'/'.$this->session->userdata('admin_id')."/t1-".$this->session->userdata('profile_image')?>" alt="user avatar" width="28" height="28" /> </button>
      <ul class="dropdown-menu checkbox-persist" role="menu">
        <li class="menu-arrow">
          <div class="menu-arrow-up"></div>
        </li>
        <li class="dropdown-header">Your Account <span class="pull-right glyphicons glyphicons-user"></span></li>
        <li>
          <ul class="dropdown-items">
            <li>
              <div class="item-icon"><i class="fa fa-cog"></i> </div>
              <a class="item-message" href="<?php echo base_url() ?>admin/manage-user/edit-profile">Edit Profile</a> </li>
        
            <li class="border-bottom-none">
              <div class="item-icon"><i class="fa fa-lock"></i> </div>
              <a class="item-message" href="<?php echo base_url()?>admin/manage-user/edit-password">Change Password</a> </li>
            <li class="padding-none">
              <div class="dropdown-lockout">&nbsp;</div>
              <div class="dropdown-signout"><i class="fa fa-sign-out"></i> <a href="<?php echo SURL?>login/logout">Sign Out</a></div>
            </li>
          </ul>
        </li>
      </ul>
    </div>