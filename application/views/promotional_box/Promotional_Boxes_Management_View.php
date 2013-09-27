
<script type="text/javascript">
	function do_delete()
	{
		var msg = confirm("Are you sure you want to Delete?");
		if(msg)
		{
			return true;
		}
		else
		return false;
	}
	$(document).ready(function(e) {  
		$(".DataGrid2 ul:odd").addClass("TableData");
		$(".DataGrid2 ul:even").addClass("TableData AlterRow");
		$(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
    });
</script>
<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt="Rooms Management"/>
        <span>Promotional Boxes Management</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?=base_url().index_page();?>Create_Promotional_Boxe">
            <img src="<?=base_url();?>images/webpowerup/CreateBoxes.png" alt="Create Boxes"/>
        </a>
    </div>
</div>
<div class="clr"></div>


<div class="PageDetail">
<p>Promotional Boxes Details  </p>
<p>Here All Records of Promotional Boxes</p>
</div>
<div class="InnerMain2">
<div class="DataGrid2">
				
            <ul >
                <li>Title </li>
                <li class="managefield">Show Title </li>
                <li class="managefield">Product</li>
                <li class="managefield">Position </li>
                <li class="managefield">Order </li>
                <li class="managefield">Publish </li>
                <li class="managefield">Display Pages </li>
                <li>Who can view </li>
                <li class="Actions">Action</li>
            </ul>
            
            <?php  

            if($view_all_records)
            {
                foreach($view_all_records as $row)
                {
            ?>
                <ul >
                    
                    <li><?=$row['box_title'];?></li>
                    <li class="managefield"><?=$row['box_show_title'];?></li>
                    <li class="managefield"><?=$row['box_product'];?> </li>
                    <li class="managefield"><?=$row['box_position'];?></li>
                    <li class="managefield"><?=$row['box_order'];?></li>
                    <li class="managefield"><?=$row['box_publish'];?></li>
                    <li class="managefield"><? if(isset($row['page_title'])){ echo $row['page_title'];  }else{ echo "ALL"; }?></li>
                    <li><?=$row['box_permissions'];?></li>
                    <li class="Actions">
                         <a href="<?=base_url().index_page();?>Edit_Promotional_Boxe/index/<?=$row['box_id']?>" class="EditAction">
                            <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
                        </a>
                         <a href="<?=base_url().index_page();?>Promotional_Boxes_Management/delete_promotional_boxe/<?=$row['box_id']?>" class="DeleteAction" onclick="return do_delete();">
                            <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                        </a>
                    </li>
                </ul>
            <?php	
                }
            }
            else 
           { ?>
                <ul class="TableData">
                <li>
                <span class="NoData">
                Sorry! No Record Found.
                </span>
                </li>
                </ul>
			<?php 
            }
            ?>
                
</div>

	<!--	PAGINATION	 -->
    <?php /*?><div class="pageDiv">
    <?php echo $paging;?>
    <br />
    Display # 
    <select id="numRecords" name="numRecords" onChange="document.frmPages.submit();">            
    <option value="5" <?php if($pageLimit==5){?>selected="selected"<?php }?>>5</option>
    <option value="10" <?php if($pageLimit==10){?>selected="selected"<?php }?>>10</option>
    <option value="20" <?php if($pageLimit==20){?>selected="selected"<?php }?>>20</option>    
    </select>
    Results <?php echo $from+1;?> - <?php echo $from+$numRecords;?> of <?=$totalRecords;?>
    </div><?php */?>
    <!--	PAGINATION	 -->

</div>


   
	


