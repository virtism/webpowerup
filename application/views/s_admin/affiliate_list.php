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
                <h2>Affiliate</h2>
                </div>                
                <!-- Panels Start -->

                
                <div class="mws-panel grid_8">
                    <div class="mws-panel-header">
                        <span><i class="icon-table"></i>All Affiliate</span>
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
                                   if($affiliates !=""){
                                       $i = 1;
                                   foreach($affiliates as $affiliate){    
                                       
                                   ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $affiliate->user_fname.' '.$affiliate->user_lname;?></td> 
                                    <td><?php echo $affiliate->user_email;?></td> 
                                    <td><?php echo $affiliate->user_status;?></td>
                                    <td>
                                        <a href="<?=base_url().index_page();?>administrator/user_affiliate/get_affiliate_member/<?=$affiliate->user_id;?>" class="btn btn-warning btn-small"> <i class="icon-search"></i>View Member</a>
                                        <a href="<?=base_url().index_page();?>UsersController/myaccount/<?=$affiliate->user_id;?>" class="btn btn-primary btn-small"> <i class="icon-pencil"></i> Edit</a>
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
