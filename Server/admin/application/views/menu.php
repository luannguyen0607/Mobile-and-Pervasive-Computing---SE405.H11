      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets\img\logo.png"  width="60"></a></p>
              	 
              	  	
                  <li class="mt">
                      <a class ="<?php if($this->uri->segment(2) == "user_login_process"){echo "active";}?>" href="<?php echo base_url();?>">
                          <i class="fa fa-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a class ="<?php if($this->uri->segment(1)=="user_management"){echo "active";}?>" href="<?php echo base_url("user_management");?>" >
                          <i class="fa fa-users"></i>
                          <span>User Management</span>
                      </a>
					  <ul class="sub" style="display: none;">
                          <li class ="<?php if($this->uri->segment(2)=="add_new_user"){echo "active";}?>"><a href="<?php echo base_url("user_management/add_new_user");?>" >Add User</a></li>
                      </ul>
                  </li> 
				  <li class="sub-menu">
                      <a class ="<?php if($this->uri->segment(1)=="song_management"){echo "active";}?>" href="<?php echo base_url("song_management");?>" >
                          <i class="fa fa-music" aria-hidden="true"></i>
                          <span>Songs Management</span>
                      </a>
					  <ul class="sub" style="display: none;">
                          <li class ="<?php if($this->uri->segment(2)=="add_new_song"){echo "active";}?>"><a href="<?php echo base_url("song_management/add_new_song");?>" >Add Song</a></li>
                      </ul>
                  </li>
				  <li class="sub-menu">
                      <a class ="<?php if($this->uri->segment(1) == "admin_management"){echo "active";}?>" href="<?php echo base_url("admin_management");?>">
                         <i class="fa fa-users" aria-hidden="true"></i>
                          <span>Admin management</span>
                      </a>
					  <ul class="sub" style="display: none;">
                          <li class ="<?php if($this->uri->segment(2)=="add_new_user"){echo "active";}?>"><a href="<?php echo base_url("admin_management/add_new_user");?>" >Add new</a></li>
                      </ul>
                  </li>
				  <li class="sub-menu">
                      <a class ="<?php if($this->uri->segment(1) == "setting"|| $this->uri->segment(2) == "change_password"){echo "active";}?>" href="<?php echo base_url("setting");?>">
                         <i class="fa fa-cogs" aria-hidden="true"></i>
                          <span>Setting</span>
                      </a>
					  <ul class="sub" style="display: none;">
                          <li class ="<?php if($this->uri->segment(2)=="smtp"){echo "active";}?>"><a href="<?php echo base_url("setting/smtp");?>" >SMTP Setting</a></li>
                      </ul>
					  <ul class="sub" style="display: none;">
                          <li class ="<?php if($this->uri->segment(2)=="change_password"){echo "active";}?>"><a href="<?php echo base_url("user_authentication/change_password");?>" >Change Password</a></li>
                      </ul>
                  </li>
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->