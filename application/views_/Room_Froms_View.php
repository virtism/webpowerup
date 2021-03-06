<script src="<?php echo base_url();?>asset/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
function deleteRoom()
{
  var msg = confirm("Are you sure you want to Delete?");
  if(msg)
	 return true;
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
    <h1 class="createroom">
        <img src="<?=base_url();?>images/webpowerup/RoomsManagement.png" alt="Rooms Management"/>
        <span>Rooms Management</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?php echo base_url().index_page()?>room_management/create_room/">
            <img src="<?=base_url();?>images/webpowerup/CreateNewRoom.png" alt="Rooms Management"/>
        </a>
    </div>
</div>

<div class="PageDetail">
<p>Rooms Details </p>
<p>Here All Records of Rooms Created</p>
</div>

<div class="DataGrid2">
        <ul >
            <li>Name </li>
            <li>Topic </li>
            <li>Date </li>
            <li class="Actions">Action</li>
        </ul>
        <?php
        if($rooms) 
		{
			foreach($rooms as $row)
			{
				
			?>
        	<ul >
            <li>
                <a href="#"><?=$row['name']?></a>
            </li>
            <li>
                <?=$row['topic']?>
            </li>
             <li>
               	<?=$row['reg_date_start']?>
            </li>
            <li class="Actions">
                <a target="_blank" href="<?=base_url();?>broadcast/GWSWhiteboard.html#roomID=<?=$row['room_rid']?>&attendee_id=<?php echo ($row['presenter_id'] * 2) ; ?>" class="RefreshAction">
                    <img src="<?=base_url();?>images/webpowerup/RefreshAction.png" alt="button"/>
                </a>
                 <a href="<?=base_url().index_page();?>room_management/edit_room/<?=$row['id']?>" class="EditAction">
                    <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
                </a>
                 <a onclick="return deleteRoom();" href="<?=base_url().index_page();?>room_management/delete_room/<?=$row['id']?>" class="DeleteAction">
                    <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                </a>
				 <br>
                <?php /*?><a  href="<?=base_url().index_page();?>room_management/send_invitation/<?=$row['id']?>">Send Invitation Mail</a><?php */?>
				 <a style="color: white; font-size: 10px; text-shadow: 0px 0px #424B59; background-color: #424B59; border: 1px #424B59 solid;" href="<?=base_url().index_page();?>room_management/send_invitation/<?=$row['id']?>"> Send Invitation Mail </a> <br><br>
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