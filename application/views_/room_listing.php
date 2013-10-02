<h2>Meeting Rooms</h2>
<style>
	.table-data td{ text-align:center;  }
</style>
<?php
//echo "<pre>";echo count($view_all_room_records);print_r($view_all_room_records);exit;
if (isset($view_all_room_records) && !empty($view_all_room_records)>0) 
{ 

//echo "<pre>"; print_r($view_all_room_records);exit;
?>
    <table class="table-data" cellpadding="0" cellspacing="0" width="100%">
    <tr><th>Meeting Title</th><th>Meeting Date</th><th>Join Meeting</th></tr>
    <? /*echo "<pre>"; print_r($view_all_room_records); exit;*/ 
    for($i = 0; $i <count($view_all_room_records); $i++)
    {
        ?>
        <tr>
            <td><?=$view_all_room_records[$i]['name']?></td>
            <td><?=$view_all_room_records[$i]['reg_date_start']?></td>
            
            <td colspan="2"><a  target="_blank" href='<?=base_url()?>broadcast/GWSWhiteboard.html#roomID=<?=$view_all_room_records[$i]['room_rid']?>&attendee_id=<?=(2*$_SESSION['login_info']['customer_id'])?>'>Join Meeting Room</a></td>
        </tr>
    
    <?
    }
    
    
    ?>
    </table>
<?php
}
else
{
	echo "<div> No record was found! </div>";
}
?>


</body>
</html>