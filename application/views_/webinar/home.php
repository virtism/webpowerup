<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
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
        <img src="<?=base_url();?>images/webpowerup/WebinarManagement.png" alt="Webinar Management"/>
        <span>Webinar Management</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?=base_url().index_page();?>webinar_controller/new_webinar/<?=$site_id;?>">
            <img src="<?=base_url();?>images/webpowerup/CreateWebinar.png" alt="Rooms Management"/>
        </a>
    </div>
</div>

<div class="DataGrid2">
				<ul >
                    <li class="Serial">Sr.No</li>
                    <li>Webinar Title </li>
                    <li>Access Level </li>
                    <li>Email To </li>
                    <li>Webinar Link</li>
                    <li class="Actions">Actions</li>
                </ul>
                    
                    
			<?
            
            $admin_ids = '';
            if(isset($_SESSION['user_info']['user_id']))
            {
                $admin_ids = $_SESSION['user_info']['user_id'];
            }
            if(count($all_webinars) > 0)
            {
                
                for($i=0;$i<count($all_webinars);$i++)
                {
				?>
                <ul>
                    <li class="Serial">
                       <?=$i+1?>
                    </li>
                    <li>
                        <?=$all_webinars[$i]["title"]?>
                    </li>
                     <li>
                        <?=$all_webinars[$i]["webinar_access"]?>
                    </li>
                    <li>
                       <?=($all_webinars[$i]["email_to"])? $all_webinars[$i]["email_to"] : "N/A"?>
                    </li>
                    <li>
                        <a target="_blank" href="<?=base_url().index_page();?>broadcast/GWSWhiteboard.html#webinarID=<?=$all_webinars[$i]["webinar_rid"]?>&attendee_id=<?=(2*$admin_ids)?>"  class="Meeting">Join Webinar</a>
                    </li>
                    <li class="Actions">
                         <a href="<?=base_url().index_page()?>webinar_controller/do_edit_webinar/<?=$all_webinars[$i]["id"]?>" class="EditAction">
                        	<img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
                        </a>
                         <a href="<?=base_url().index_page()?>webinar_controller/do_delete_webinar/<?=$all_webinars[$i]["id"]?>" onclick="return do_delete();" class="DeleteAction">
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