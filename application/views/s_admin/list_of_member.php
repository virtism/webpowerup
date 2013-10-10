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
            	                 
                <!-- Panels Start -->

                
            	<div class="mws-panel grid_9">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i>List of Members</span>
                    </div>
                     <div class="mws-panel-body no-padding">
                        <table class="mws-datatable-fn mws-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Company</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <!--<th>Price</th>
                                    <th>Image</th>-->
                                    
                                <!--<th>Status</th>-->
                                    <th>Action</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                   <?php 
                                   if($listings !=""){
                                   foreach($listings as $listing){    
                                       
                                   ?>
                                <tr>
                                    <td><?php echo $listing->user_trail_start_date;?></td>
                                    <td><?php echo $listing->company;?></td>
                                    <td><?php echo $listing->user_email;?></td>
                                    <td><?php echo $listing->user_status;?></td>
                                    
                                    <!--<td><?php echo $listing->status;?></td>-->
                                    <td>
                                    <a href="<?php echo URL.'index.php/pages/status_up/products/all_records';?>" class="btn btn-success btn-small"></a>
                                    <a href="<?php echo URL.'index.php/pages/view_record/';?>" class="btn btn-warning btn-small"> <i class="icon-search"></i>View</a>
                                    <a href="<?php echo URL.'index.php/pages/add_product/';?>" class="btn btn-primary btn-small"> <i class="icon-pencil"></i> Edit</a>
                                    <a href="<?php echo URL.'index.php/pages/delete/'."/products/all_records";?>" class="btn btn-danger btn-small"> <i class="icon-fire"></i> Delete</a>
                                    </td>
                                    </td>
                                </tr>
                                <?php }}?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Panels End -->
            </div>
            <!-- Inner Container End -->
                       
            <!-- Footer -->
 <?php include('footer.php');?>
