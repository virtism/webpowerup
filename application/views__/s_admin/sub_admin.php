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
                <h2>Sub Admins </h2>
                </div>                
                <!-- Panels Start -->

                
                <div class="mws-panel grid_8">
                    <div class="mws-panel-header">
                        <span><i class="icon-table"></i>All Sub Admin</span>
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
                                    <th>SubAdmin Id</th>
                                    <th>SubAdmin Name</th>
                                    <th>SubAdmin E-mail</th>
                                    <th>SubAdmin Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                   <?php 
                                   if($sub_admins !=""){
                                       $i = 1;
                                   foreach($sub_admins as $sub_admin){    
                                       
                                   ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $sub_admin->user_id;?></td>
                                    <td><?php echo $sub_admin->user_fname.' '.$sub_admin->user_lname;?></td> 
                                    <td><?php echo $sub_admin->user_email;?></td> 
                                    <td><?php echo $sub_admin->user_status;?></td>
                                    <td>
                                        <a href="<?php echo URL.'index.php/pages/view_cat/';?>" class="btn btn-warning btn-small"> <i class="icon-search"></i>View</a>
                                        <a href="<?=base_url().index_page();?>UsersController/myaccount/<?=$sub_admin->user_id;?>" class="btn btn-primary btn-small"> <i class="icon-pencil"></i> Edit</a>
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
