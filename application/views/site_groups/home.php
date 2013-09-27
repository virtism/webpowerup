<script type="text/javascript">

$(document).ready(function(e) {  
	$(".DataGrid2 ul:odd").addClass("TableData");
	$(".DataGrid2 ul:even").addClass("TableData AlterRow");
	$(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
});

</script>
<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/5.png" alt="Group"/>
        <span>Group</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?=base_url().index_page()?>sitegroups/new_site_group">
            <img src="<?=base_url();?>images/webpowerup/CreateGroup.png" alt="Create Group"/>
        </a>
    </div>
</div>


<div class="DataGrid2">
				
        <ul>
            <li class="Serial">Sr.No </li>
            <li>Group Name</li>
            <li>Group Code </li>
            <li>Members </li>
            <li>Status</li>
            <li class="Actions">Actions</li>
        </ul>
            
		<?
            if(count($groups_array) >0)
            {
                //print_r($groups_customer_count);
                $i=0;
                for($i=0;$i<count($groups_array);$i++)
                {
                        if($groups_array[$i]["is_disabled"] == "No")

                        {

                            $action_text = "Disabled";

                            $current_status = "Enable";

                        }
                        else
                        {
                            $action_text = "Enable";

                            $current_status = "Disabled";
                        }
                        
                ?>     
                <ul >
                    
                    <li class="Serial">
                        <?=$i+1;?>
                    </li>
                    
                    <li>
                        <?=$groups_array[$i]["group_name"];?>
                    </li>
                    
                     <li>
                        <?=$groups_array[$i]["group_code"];?>
                    </li>
                    
                    <li>
                       <?=$groups_array[$i]["member_count"];?>
                    </li>
                    
                    <li>
                       <?=$current_status;?>
                    </li>
                    <li class="Actions">
                         <a href="<?=site_url()?>sitegroups/edit_group/<?=$groups_array[$i]["id"]?>" class="EditAction">
                            <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
                        </a>
                         <a href="<?=site_url()?>sitegroups/delete_group/<?=$groups_array[$i]["id"]?>" class="DeleteAction">
                            <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                        </a>
                        <br />
                        <?php /*?><a href="<?=site_url()?>sitegroups/edit_group/<?=$groups_array[$i]["id"]?>">Edit</a>|<?php */?> <a href="<?=base_url().index_page()?>sitegroups/status_group/<?=$groups_array[$i]["id"]?>">
                  <?=$action_text?>
                  </a>
                 
                   <br /><a href="<?=site_url()?>sitegroups/submits/<?=$groups_array[$i]["id"]?>">Submissions</a>
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
			} ?>
</div>