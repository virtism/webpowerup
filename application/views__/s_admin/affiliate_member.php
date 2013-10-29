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
                <div class="mws-stat-container clearfix">
                <h2>Affiliate Member</h2>
                </div>                
                <!-- Panels Start -->

                
                <div class="mws-panel grid_8">
                    <div class="mws-panel-header">
                        <span><i class="icon-table"></i>All Member</span>
                    </div>
                    <div class="mws-panel-toolbar">
                        <div class="btn-toolbar">
                        </div>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-datatable-fn mws-table">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Emial/Username</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                   <?php 
                                   if($affiliate_members !=""){
                                       $i = 1;
                                   foreach($affiliate_members as $affiliate_member){    
                                       
                                   ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $affiliate_member->user_fname.' '.$affiliate_member->user_lname;?></td> 
                                    <td><?php echo $affiliate_member->user_email;?></td> 
                                    <td><?php echo $affiliate_member->user_status;?></td>
                                    <td>
                                        <a href="<?=base_url().index_page();?>administrator/packages/get_affiliate_member/" class="btn btn-warning btn-small"> <i class="icon-search"></i>View</a>
                                        <a href="<?=base_url().index_page();?>UsersController/myaccount/" class="btn btn-primary btn-small"> <i class="icon-pencil"></i> Edit</a>
                                        <a href="<?php echo URL.'index.php/pages/delete/'."/category/all_categories";?>" class="btn btn-danger btn-small" onClick="confirm('Do You Really Want To Delete');"> <i class="icon-fire"></i> Delete</a>
                                    </td>
                                    
                                </tr>
                                <?php $i++;
                                   }}?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Panels End -->
            </div>
            <!-- Inner Container End -->
                       
            <!-- Footer -->
 <?php include('footer.php');?>
