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
            	                 
            	
                
                <!-- Panels End -->
            </div>
            <!-- Inner Container End -->
                       
            <!-- Footer -->
<?php include('footer.php');?>