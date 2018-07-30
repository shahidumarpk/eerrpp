<aside id="sidebar">
  <div id="sidebar-search">
    <div class="sidebar-toggle"> <span class="glyphicon glyphicon-resize-horizontal"></span> </div>
  </div>
  <div id="sidebar-menu">
    <ul class="nav sidebar-nav">
	 	<li> <a href="<?php echo SURL?>dashboard/dashboard"><span class="glyphicons glyphicons-dashboard"></span><span class="sidebar-title">Dashboard</span></a> </li>
        
       
					
					<li class="active"><li>

    		             <a class="accordion-toggle menu-close" href=""><span class="glyphicons glyphicons-group"></span><span class="sidebar-title">Customer Support</span><span class="caret"></span></a>
      		
						
							<ul id="main_menu_" class="nav sub-nav">
							
									<li><a href="<?php echo SURL?>support/manage-tickets" title=""><span class="glyphicons "></span>Manage Tickets</a></li>
                                    <li><a href="<?php echo SURL?>support/manage_tickets/add_ticket" title=""><span class="glyphicons "></span>Add Tickets</a></li>
       		
						   </ul>
						
				    </li>
                  
                  
                  <li class="active"><li>

    		             <a class="accordion-toggle menu-close" href=""><span class="glyphicons glyphicons-font"></span><span class="sidebar-title">Invoices</span><span class="caret"></span></a>
      		
						
							<ul id="main_menu_" class="nav sub-nav">
							
									<li><a href="<?php echo SURL?>invoices/manage_invoices/" title=""><span class="glyphicons "></span>Manage Invoices</a></li>
						   </ul>
						
				  </li>
                  
                  
                   <li class="active"><li>

    		             <a class="accordion-toggle menu-close" href=""><span class="glyphicons glyphicons-font"></span><span class="sidebar-title">Projects</span><span class="caret"></span></a>
      		
						
							<ul id="main_menu_" class="nav sub-nav">
							
									<li><a href="<?php echo SURL?>projects/manage-projects" title=""><span class="glyphicons "></span>Manage Projects</a></li>
						   </ul>
						
				  </li>
                  
                  <?php if($this->session->userdata('check_employee')==0){  ?>
                  
					<li class="active"><li>

    		             <a class="accordion-toggle menu-close" href=""><span class="glyphicons glyphicons-group"></span><span class="sidebar-title">Sub Users</span><span class="caret"></span></a>
                         
							<ul id="main_menu_" class="nav sub-nav">
							
									<li><a href="<?php echo SURL?>employee/manage-employee" title=""><span class="glyphicons "></span>Manage Sub Users</a></li>
                                    <li><a href="<?php echo SURL?>employee/manage-employee/add-employee" title=""><span class="glyphicons "></span>Add Sub User</a></li>
       		
						   </ul>
				    </li>
                <?php  } ?>  
                  
                   <li class="active"><li>

    		             <a class="accordion-toggle menu-close" href=""><span class="glyphicons glyphicons-settings"></span><span class="sidebar-title">Site Preferences</span><span class="caret"></span></a>
      		
						
							<ul id="main_menu_" class="nav sub-nav">
							
									<li><a href="<?php echo SURL?>customers/manage_customers/edit_customer" title=""><span class="glyphicons "></span>Edit Profile</a></li>
                                    
						   </ul>
						
				  </li>
					
			
    </ul>

  </div>
</aside>
