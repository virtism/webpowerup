<style type="text/css">
div#actionMenu li {
    display: inline;
    list-style-type: none;
    padding-right: 20px;
    
}
div#actionMenu {
    padding-top: 20px;       
}
.pageDiv{
	padding:10px 0 0 0;
	margin:0 auto;
	text-align:center;
	clear:both;
}
</style>
<script language="javascript" type="text/javascript">
	function isChecked(){
    for(i=1;i<=<?=$numRecords?>;i++){
        if(document.getElementById('chkMenu'+i).checked==true){
            return true;            
        }
    }
    return false;
}
function publishMenu(){    
    if(isChecked() == true){
        form = document.getElementById('frmMenus');
        form.action = "<?=base_url().index_page()?>menusController/publishMenu/<?=$site_id?>"+"/00";
        form.submit();
    }
    else{
        window.alert("No menu(s) selected. Please select menu(s) first to continue.");
        return;
    }    
}
function unpublishMenu(){    
    if(isChecked() == true){
        form = document.getElementById('frmMenus');
        form.action = "<?=base_url().index_page()?>menusController/unpublishMenu/<?=$site_id?>"+"/00";
        form.submit();
    }
    else{
        window.alert("No menu(s) selected. Please select menu(s) first to continue.");
        return;
    }    
}
function deleteMenu(){    
    if(isChecked() == true){
       var msg = confirm("Are you sure you want to Delete?");
		if(msg)
	    {
	    	form = document.getElementById('frmMenus');
        	form.action = "<?=base_url().index_page()?>menusController/trashMenu/<?=$site_id?>"+"/00";
        	form.submit();
		}
		return false;	
    }
    else{
        window.alert("No menu(s) selected. Please select menu(s) first to continue.");
        return;
    }    
}
function selectAllMenu(){
    state = document.getElementById('chkMenuAll').checked;    
    for(i=1;i<=<?=$numRecords?>;i++){        
        document.getElementById('chkMenu'+i).checked=true;        
    }       
}
</script>

<div class="RightColumnHeading">
    <h1>
    	<img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt="Manage By Menu"/>
        <span>Manage My Menu</span>
    </h1>
    <div class="RightSideButton">
        <a href="javascript: void(0)" onClick="return deleteMenu()">
            <img src="<?=base_url()?>images/webpowerup/Trash.png" alt="Trash"/>
        </a>
        <a href="javascript: void(0)" onClick="unpublishMenu()">
            <img src="<?=base_url()?>images/webpowerup/Unpublish.png" alt="Unpublish"/>
        </a>
        <a href="javascript: void(0)" onClick="publishMenu()">
            <img src="<?=base_url()?>images/webpowerup/Publish.png" alt="Publish"/>
        </a>
        <a href="<?=base_url().index_page()?>menusController/createMenu/<?=$site_id?>">
            <img src="<?=base_url()?>images/webpowerup/New.png" alt="New"/>
        </a>
    </div>
</div>
<div class="clr"></div>



<div class="InnerMain2">
 <form id="frmMenus" name="frmMenus" method="post" action="<?=base_url().index_page()?>menusController/index/<?=$site_id?>/0" style="background:none !important;border: medium none !important;">

    
    <?php     
    if($records->num_rows()>0)
	{ ?>
   
    
    <div class="DataGrid2">

    <ul style="width:758px;" class="TableHeader">
        <li class="Serial">
            <input type="checkbox" value="0" name="chkMenuAll" id="chkMenuAll" onClick="selectAllMenu()" />  
        </li>
        <li>Menu Name</li>
        <li>Position</li>
        <li>Published</li>
        <li style="width:118px;">Display Order</li>
    </ul>
    
    <?php 
    $intCount = 0;
    $numRecords = $records->num_rows();
	//echo '<pre>';print_r($records->result_array());exit;
    foreach($records->result_array() as $row)
	{
		$intCount++;
			
		if($intCount%2==0)
		{
			$class =  "TableData AlterRow";
		}
		else
		{
			
			$class =  "TableData";
		}
		?>
        
        
        <ul  class="<?=$class?>" >
            <li class="Serial">
            <?php
            	$strDisabled = '';
            if($this->Menus_Model->is_main_menu($site_id, $row['menu_id']))
            {
                $strDisabled = 'disabled="disabled"';        
            }
            ?>
            <input type="checkbox" value="<?php echo $row['menu_id'];?>" name="chkMenu[]" id="chkMenu<?php echo $intCount;?>" <?=$strDisabled?> /> 
            </li>
            <li>
            	<u><a href="<?=base_url().index_page()?>menusController/showMenuInfo/<?=$site_id?>/<?php echo $row['menu_id'];?>"><?php echo $row['menu_name'];?></a></u>
            </li>
            <li><?php echo $row['menu_position'];?></li>
            <li><?php echo $row['menu_published'];?></li>
            <li class="Actions">
            		
					<?php
                    $strSort = '';
                    if($intCount>1)
                    {
                        $strSort = '<a class="UpAction" href="'.base_url().index_page().'menusController/moveUp/'.$site_id.'/'.$from.'/'.$row['menu_order'].'"><img src="'.base_url().'images/webpowerup/UpAction.png" alt="button" /></a>';    
                    }
					else if($intCount != $numRecords)
                    {						
						$strSort = '<a class="UpAction" href="'.base_url().index_page().'menusController/moveUp/'.$site_id.'/'.$from.'/'.$row['menu_order'].'"><img src="'.base_url().'images/webpowerup/UpAction.png" alt="button" /></a>'; 
												
					}	
                    else
                    {
                        $strSort = '&nbsp;';
                    }
                    echo $strSort;
                    ?>
            
            	
                 <a href="javascript: void(0)" class="Order1Action" style="padding:4px 0 0 0; height:15px !important;">
                    <?=$row['menu_order'];?>
				 </a>
                 
                
                 	<?php
					
                    $strSort = '';
                    if($intCount<=$numRecords && $from == 0)
                    {
                        $strSort = '<a class="DownAction" href="'.base_url().index_page().'menusController/moveDown/'.$site_id.'/'.$from.'/'.$row['menu_order'].'"><img src="'.base_url().'images/webpowerup/DownAction.png" alt="button" /></a>'; 
                    }
					else if($intCount != $numRecords)
                    {						
						$strSort = '<a class="DownAction" href="'.base_url().index_page().'menusController/moveDown/'.$site_id.'/'.$from.'/'.$row['menu_order'].'"><img src="'.base_url().'images/webpowerup/DownAction.png" alt="button" /></a>';
												
					}					
                    else
                    {
                        $strSort = '&nbsp;';
                    }
					//echo $intCount.'---'.$numRecords;
                    echo $strSort;
                    ?>
                 
            </li>
        </ul>
    
     <?php 
	} ?>
    

    </div>
    <div class="pageDiv">
    <?php echo $paging;?>
    <br />
    Display # 
     <select id="frmMenus" name="frmMenus" onChange="document.frmMenus.submit();">                      
    <?php /*?><option value="5" <?php if($pageLimit==5){?>selected="selected"<?php }?>>5</option><?php */?>
    <option value="10" <?php if($pageLimit==10){?>selected="selected"<?php }?>>10</option>
    <option value="20" <?php if($pageLimit==20){?>selected="selected"<?php }?>>20</option>   
    </select>
    Results <?php echo $from+1;?> - <?php echo $from+$numRecords;?> of <?=$totalRecords;?>
    </div>       
    
    <?php 
    } ?>   
</form>
</div>