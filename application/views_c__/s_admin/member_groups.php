 <?php include('main_header.php');?>  
  
<style>
.blackLi
{
    
    background-color: #8F8943;
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
                    <h2>Members & Groups</h2> 
                  </div>               
                <!-- Panels Start -->
                
                <div class="mws-panel grid_8">
                    <div class="mws-panel-header">
                        <span><i class="icon-book"></i> Users</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <ul class="mws-summary clearfix">
                            <li class="blackLi">
                                <a href="javascript: void(0)">
                                    <span class="key"><i class="icon-support"></i> Create a User</span>
                                    <span class="val">
                                        <span class="text-nowrap"></span>
                                    </span>
                                </a>
                            </li>
                            <li class="blackLi">
                                <a href="javascript: void(0)"> 
                                    <span class="key"><i class="icon-support"></i> Manage Users</span>
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
                        <span><i class="icon-book"></i> Groups</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <ul class="mws-summary clearfix">
                            <li class="blackLi">
                                <a href="javascript: void(0)">
                                    <span class="key"><i class="icon-support"></i> Create a Group</span>
                                    <span class="val">
                                        <span class="text-nowrap"></span>
                                    </span>
                                </a> 
                            </li>
                            <li class="blackLi">
                                <a href="javascript: void(0)">
                                    <span class="key"><i class="icon-support"></i>Manage Groups</span>
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
                        <span><i class="icon-book"></i>Access Levels</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <ul class="mws-summary clearfix">
                            <li class="blackLi">
                                <a href="javascript: void(0)">
                                    <span class="key"><i class="icon-support"></i>Create an Access Level</span>
                                    <span class="val">
                                        <span class="text-nowrap"></span>
                                    </span>
                                </a> 
                            </li>
                            <li class="blackLi">
                                <a href="javascript: void(0)">
                                    <span class="key"><i class="icon-support"></i>Manage Access Levels</span>
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
                        <span><i class="icon-book"></i>Autoresponders</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <ul class="mws-summary clearfix">
                            <li class="blackLi">
                                <a href="javascript: void(0)">
                                    <span class="key"><i class="icon-support"></i> Create an Autoresponder</span>
                                    <span class="val">
                                        <span class="text-nowrap"></span>
                                    </span>
                                </a> 
                            </li>
                            <li class="blackLi">
                                <a href="javascript: void(0)">
                                    <span class="key"><i class="icon-support"></i> Manage Autoresponders</span>
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
