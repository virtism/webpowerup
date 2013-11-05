 <?php include('main_header.php');?>  
  
<style>
.blackLi
{
    background-color: #312020;
}
.key
{
    width: 300px  !important;
    
}
</style>
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
            	<div class="mws-stat-container clearfix">
                    <h2>Design & Configuration</h2> 
                </div>                
                <!-- Panels Start -->
                
                <div class="mws-panel grid_8">
                    <div class="mws-panel-header">
                        <span><i class="icon-book"></i> Design & Appearance</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <ul class="mws-summary clearfix">
                                <li class="blackLi">
                                    <a href="javascript: void(0)">
                                        <span class="key"><i class="icon-support"></i> Design Your Site</span>
                                        <span class="val">
                                            <span class="text-nowrap"></span>
                                        </span>
                                    </a>
                                </li>
                            
                            
                            <li class="blackLi">
                                <a href="javascript: void(0)"> 
                                    <span class="key"><i class="icon-support"></i> Upload Or Change My Logo</span>
                                    <span class="val">
                                        <span class="text-nowrap"></span>
                                    </span>
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class="mws-panel grid_8">
                    <div class="mws-panel-header">
                        <span><i class="icon-book"></i> Site Settings</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <ul class="mws-summary clearfix">
                            <li class="blackLi">
                                <a href="javascript: void(0)">
                                    <span class="key"><i class="icon-support"></i> Edit Site Settings</span>
                                    <span class="val">
                                        <span class="text-nowrap"></span>
                                    </span>
                                </a> 
                            </li>
                            <li class="blackLi">
                                <a href="javascript: void(0)">
                                    <span class="key"><i class="icon-support"></i> Edit Paypal Settings</span>
                                    <span class="val">
                                        <span class="text-nowrap"></span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>                                
                <!-- Panels End -->
            </div>
            </div>
            <!-- Inner Container End -->
                       
            <!-- Footer -->
 <?php include('footer.php');?>
