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
                <h2>Packages </h2>
                </div>                
                <!-- Panels Start -->

                 <a href="<?=base_url().index_page()?>administrator/packages/addnew" style="margin-bottom: 10px; margin-left: 10px;" class="btn btn-success"> <i class=""></i>Add New</a>
                <div class="mws-panel grid_8">
                    <div class="mws-panel-header">
                        <span><i class="icon-table"></i>All Packages</span>
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
                                    <th>Package Name</th>
                                    <th>Package Description</th>
                                    <th>Package Price</th>
                                    <th>Package Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                   <?php 
                                   if($packages !=""){
                                       $i = 1;
                                   foreach($packages as $package){    
                                       
                                   ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $package->package_name;?></td>
                                    <td><?php echo $package->package_description;?></td> 
                                    <td><?php echo $package->package_fixed_price;?></td> 
                                    <td><?php echo $package->package_status;?></td>
                                    <td>
                                        <a href="<?=base_url().index_page()?>administrator/packages/editPackage/<?=$package->package_id;?>" class="btn btn-primary btn-small"> <i class="icon-pencil"></i> Edit</a>
                                        <a href="<?=base_url().index_page()?>administrator/packages/deletePackage/<?=$package->package_id;?>" class="btn btn-danger btn-small" onClick="confirm('Do You Really Want To Delete');"> <i class="icon-fire"></i> Delete</a>
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
