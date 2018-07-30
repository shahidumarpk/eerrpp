<aside id="sidebar">
  <div id="sidebar-search">
    <div class="sidebar-toggle"> <span class="glyphicon glyphicon-resize-horizontal"></span> </div>
  </div>
  <div id="sidebar-menu">
    <ul class="nav sidebar-nav">
	 	<li> <a href="<?php echo SURL?>dashboard/dashboard"><span class="glyphicons glyphicons-dashboard"></span><span class="sidebar-title">Dashboard</span></a> </li>
        
        <?php 
		
		$unread_messages_count=$this->session->userdata('unread_msg_count');
		
		
			$c = 0;

			foreach($nav_panel_arr as $main_menu_index => $main_menu){
				
				if(in_array($main_menu['menu_id'],$this->session->userdata('permissions_arr'))){
					
					if($main_menu['status']  == 1){
				
					echo ($c == 0) ? '<li class="active">' : '<li>';

		?>
    		             <a class="accordion-toggle menu-close" href="<?php echo ($main_menu['url_link'] == '#') ? '#main_menu_'.$main_menu_index  : SURL.$main_menu['url_link']?>"><span class="glyphicons <?php echo $main_menu['menu_icon_class']?>"></span><span class="sidebar-title"><?php echo $main_menu['menu_title']?></span><span class="caret"></span></a>
        <?php		
						if(count($main_menu['sub_menu']) > 0){
					
							echo '<ul id="main_menu_'.$main_menu_index.'" class="nav sub-nav">';
							for($j=0;$j<count($main_menu['sub_menu']);$j++){
								
								if(in_array($main_menu['sub_menu'][$j]['id'],$this->session->userdata('permissions_arr'))){
		?>
                                    
                                    <?php if($main_menu['sub_menu'][$j]['id']==124  && $this->session->userdata('daily_report')==1){  ?>
                                    <li><a href="<?php echo SURL.$main_menu['sub_menu'][$j]['url_link'] ?>" title="<?php echo $main_menu['sub_menu'][$j]['menu_title']?>"><span class="glyphicons <?php echo $main_menu['sub_menu'][$j]['icon_class_name']?>"></span><?php echo $main_menu['sub_menu'][$j]['menu_title']?></a></li>
                                    
                                    <?php } ?>
                                    
                                    
                                 <?php if($main_menu['sub_menu'][$j]['id']!=124){  ?>   
                                    <li><a href="<?php echo SURL.$main_menu['sub_menu'][$j]['url_link'] ?>" title="<?php echo $main_menu['sub_menu'][$j]['menu_title']?>"><span class="glyphicons <?php echo $main_menu['sub_menu'][$j]['icon_class_name']?>"></span><?php echo $main_menu['sub_menu'][$j]['menu_title']?>
									<?php 
									
									if($unread_messages_count !=0){
									if($main_menu['sub_menu'][$j]['id']==71){echo " (".$unread_messages_count." Unread)";} } ?></a></li>
        <?php						
								 }
								}//end if(in_array($main_menu['sub_menu'][$j]['id'],$this->session->userdata('permissions_arr')))
								
							}//end for
					
							echo '</ul>';
						}//end if(count($sub_menu['sub_menu']) > 0)
						
						echo '</li>';
						$c++;
					}//end if($main_menu['status']  == 1)
				
				}//end if(in_array($main_menu_index,$this->session->userdata('permissions_arr')))
				
			}//end foreach
			
		?>
        
        
    </ul>

  </div>
</aside>
