<script type="text/javascript">
function do_delete()
{
	msg = confirm("Are you sure you want to Delete?");
	if(msg)
	{
		return true;
	}
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
        <img src="<?=base_url();?>images/webpowerup/ResponderManagement.png" alt="Responder Management"/>
        <span>Autoresponder Management</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?=base_url().index_page()?>Create_Autoresponder/index/<?=$site_id?>">
            <img src="<?=base_url();?>images/webpowerup/New.png" alt="New Autoresponder"/>
        </a>
    </div>
</div>

<div class="PageDetail">
<p>Autoresponder Details  </p>
<p>Here All Records of Autoresponder</p>
</div>

<div class="DataGrid2">
        <ul >
            <li>Name </li>
            <li class="Serial">Group </li>
            <li>When to Send </li>
            <li class="Serial">Active? </li>
            <li class="Actions">Actions</li>
        </ul>
        <?php
		
        if($autoresponds)
		{
			
			foreach($autoresponds as $row)
			{
				if($row['respond_send_immediately'] == 'Yes')
				{
                    $when_to_send =  'Immediately After User Signup';    
                }
				else
				{
                   
				   	if($row['respond_send_key'] == 'Weeks')
					{
						$respond_send_value = $row['respond_send_value']/7;
					}
					else if($row['respond_send_key'] == 'Months')
					{
						$respond_send_value = $row['respond_send_value']/30;
					}
					else if($row['respond_send_key'] == 'Years')
					{
						$respond_send_value = $row['respond_send_value']/365;
					}
					else
					{
						$respond_send_value = $row['respond_send_value'];
					}
					
					$when_to_send = $respond_send_value.' '.$row['respond_send_key'].' After '.$row['respond_send_after'];
                }
				if($row['respond_active'] == '1')
				{
                    $respond_active =  'Yes';    
                }
				else
				{
                    $respond_active =  'No';
                }
			?>
  			<ul>
				<li>
					<?=$row['respond_name'];?>
				</li>
				 <li class="Serial">
					<?=$row['group_name'];?>
				</li>
				<li><?=$when_to_send;?></li>
				<li class="Serial"><?=$respond_active;?></li>
				<li class="Actions">
					 <a href="#" class="Respond">
					 <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
					</a>
				  <a href="<?=base_url().index_page()?>Edit_Autoresponder/index/<?=$_SESSION['site_id']?>/<?=$row['respond_id'];?>" class="EditAction">
						<img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
					</a>
					 <a href="<?=base_url().index_page()?>autoresponders_management/delete_autoresponder/<?=$_SESSION['site_id']?>/<?=$row['respond_id'];?>" onclick="return do_delete();" class="DeleteAction">
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
        } ?>
</div>