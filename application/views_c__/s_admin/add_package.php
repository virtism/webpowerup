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
            
            <div class="mws-stat-container clearfix">
                <h2>New Package </h2>
                </div> 
                <!-- Statistics Button Container -->
<? 
if(isset($action) && $action == "edit" )
{
    $action = "editPackage";
    $btnCaption = "Update";
    
}
else
{
    $action = "creatNewPackage" ;
    $btnCaption = "Save";
}

?>                
                
                
                <div class="mws-panel grid_8">
                    <div class="mws-panel-header">
                        <span><i class="icon-ok"></i>You Can Add Package Here</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <form id="mws-validate" class="mws-form" enctype="multipart/form-data" method="post" action="<?=base_url().index_page()?>administrator/packages/package_management/">
                        <input type="hidden" name="action" value="<?=$action?>">
                        <? if(isset($action) && $action == "editPackage" ) {?>
                        <input type="hidden" name="package_id" value="<?=$packageArray[0]["package_id"]?>">
                        <? }?> 
                            <div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>
                            <div class="mws-form-inline">
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Package Name</label>
                                    <div class="mws-form-item">
                                     <input type="text" name="package_name" class="required large" value="<? if(isset($packageArray[0]["package_name"])) echo $packageArray[0]["package_name"];?>">
                                        
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Description</label>
                                    <div class="mws-form-item">
                                         <input type="text" name="package_description" class="required large" value="<? if(isset($packageArray[0]["package_description"])) echo $packageArray[0]["package_description"]?>"> 
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Status </label>
                                    <div class="mws-form-item">
                                        <select name="package_status">
                                            <option value="Active"> Active </option>
                                            <option value="Inactive"> Inactive </option>
                                            <option value="Deleted"> Deleted </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Package Price</label>
                                    <div class="mws-form-item">
                                         <input type="text" name="package_price" class="required large" value="<? if(isset($packageArray[0]["package_fixed_price"])) echo $packageArray[0]["package_fixed_price"]?>">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Package Modules  </label>
                                    <div class="mws-form-item">
                                        <?
                                            for($i = 0; $i<count($modules); $i++ )
                                            {
                                                
                                                $checked = "";
                                                if(isset($moduleArray[$i]["module_id"]))
                                                {
                                                    if($moduleArray[$i]["module_id"] == $modules[$i]["module_id"])
                                                    {
                                                        $checked = 'checked= "checked"';
                                                    }    
                                                }
                                                
                                        ?>
                                            <input type="checkbox" name="module_id[]" value="<?=$modules[$i]["module_id"]?>" <?=$checked?>> <?=$modules[$i]["module_name"]?>
                                        <? }?>
                                    </div>
                                </div>
                            </div>
                            <div class="mws-button-row">
                                <input type="submit" name="submit" class="btn btn-danger" value="<?=$btnCaption?>">
                                
                            </div>
                        </form>
                    </div>        
                </div>
                
                <!-- Panels End -->

            
            <!-- Inner Container End -->
             </div>          
            <!-- Footer -->
           <?php include('footer.php');?>