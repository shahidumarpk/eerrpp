  	<div class="pull-left">
        <a class="navbar-brand" href="index.php">
            <div class="navbar-logo">
                <img src="<?php echo IMG?>logo.png" class="img-responsive" alt="logo"/>
            </div>
        </a>
    </div>
  <div class="pull-right header-btns">
 
    <div class="btn-group user-menu">
      <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown"> <span class="glyphicons glyphicons-user"></span> <b>Welcome</b> <?php echo $this->session->userdata('customer_name');?> </button>
      <button type="button" class="btn btn-sm dropdown-toggle padding-none" data-toggle="dropdown"> <img src="<?php echo ($this->session->userdata('customer_profile_image') == '') ? IMG."avatars/default_user.png" : CUSTOMER_FOLDER.'/'.$this->session->userdata('customer_id')."/t1-".$this->session->userdata('customer_profile_image')?>" alt="user avatar" width="28" height="28" /> </button>
      <ul class="dropdown-menu checkbox-persist" role="menu">
        <li class="menu-arrow">
          <div class="menu-arrow-up"></div>
        </li>
        <li class="dropdown-header">Your Account <span class="pull-right glyphicons glyphicons-user"></span></li>
        <li>
          <ul class="dropdown-items">
            <li>
              <div class="item-icon"><i class="fa fa-cog"></i> </div>
              <a class="item-message" href="<?php echo base_url() ?>customers/manage_customers/edit_customer">Edit Profile</a> </li>
        
           
            <li class="padding-none">
              <div class="dropdown-lockout">&nbsp;</div>
              <div class="dropdown-signout"><i class="fa fa-sign-out"></i> <a href="<?php echo SURL?>login/logout">Sign Out</a></div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
