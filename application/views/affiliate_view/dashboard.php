<?php include('main_header.php');?>  

<body>

	<!-- Themer (Remove if not needed) -->  

    <!-- Themer End -->

	<!-- Header -->
	 <?php include('header.php');?>    
    <!-- Start Main Wrapper -->
    <div id="mws-wrapper">
    
    	<!-- Necessary markup, do not remove -->
		<div id="mws-sidebar-stitch"></div>
		<div id="mws-sidebar-bg"></div>
        
        <!-- Sidebar Wrapper -->
        <?php include('leftbar.php');?>         
        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
            	<?php //include('template/menu.php');?>
                
                <!-- Panels Start -->
                
            	 <?php if($this->session->flashdata('change_passrowd')!=''){?>
                 <div class="mws-form-message success" id="errorDiv"  style=""> <?php echo $this->session->flashdata('change_passrowd'); ?> </div> 
                 <?php }?>               
            	<div class="mws-panel grid_3">
                	<div class="mws-panel-header">
                    	<span><i class="icon-book"></i> Website Summary</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <ul class="mws-summary clearfix">
                            <li>
                                <span class="key"><i class="icon-support"></i><a href="<?php echo base_url().'wpuadmin/wpuadmin_dashboard/edit_affiliate';?>"> Edit Profile</a></span>
                                <span class="val">
                                    <span class="text-nowrap">332</span>
                                </span>
                            </li>
                            <li>
                                <span class="key"><i class="icon-certificate"></i><a href="<?php echo base_url().'wpuadmin/wpuadmin_dashboard/list_of_member';?>">List Of Members</a></span>
                                <span class="val">
                                    <span class="text-nowrap">71% <i class="up icon-arrow-up"></i></span>
                                </span>
                            </li>
                            <li>
                                <span class="key"><i class="icon-shopping-cart"></i> This Week Sales</span>
                                <span class="val">
                                    <span class="text-nowrap">144 <i class="down icon-arrow-down"></i></span>
                                </span>
                            </li>
                            <li>
                                <span class="key"><i class="icon-install"></i> Cash Deposit</span>
                                <span class="val">
                                    <span class="text-nowrap">$6,421</span>
                                </span>
                            </li>
                            <li>
                                <span class="key"><i class="icon-key"></i> Last Sign In</span>
                                <span class="val">
                                    <span class="text-nowrap">September 21, 2012</span>
                                </span>
                            </li>
                            <li>
                                <span class="key"><i class="icon-windows"></i> Operating System</span>
                                <span class="val">
                                    <span class="text-nowrap">Debian Linux</span>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                
            	
                
                <!-- Panels End -->
            </div>
            <!-- Inner Container End -->
                       
            <!-- Footer -->
<?php include('footer.php');?>