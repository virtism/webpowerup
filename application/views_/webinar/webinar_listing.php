<h2>Webinar Rooms</h2>
<style>
.table-data td{ text-align:center;  }

</style>
<?php
if ( $view_all_webinar_records) 
{ 
?>
<table class="table-data" cellpadding="0" cellspacing="0" width="100%">
<tr><th>Webinar Title</th><th>Webinar Date</th><th>Join Webinar</th></tr>
<? /*echo "<pre>"; print_r($view_all_room_records); exit;*/ 
for($i = 0; $i <count($view_all_webinar_records); $i++){?>
	<tr>
		<td><?=$view_all_webinar_records[$i]['title']?></td>
		<td><?=$view_all_webinar_records[$i]['start_date']?></td>		
		<td ><a  target="_blank" href='<?=base_url()?>broadcast/GWSWhiteboard.html#webinarID=<?=$view_all_webinar_records[$i]['webinar_rid']?>&attendee_id=<?=(2*$_SESSION['login_info']['customer_id'])?>'>Attend Webinar</a></td>
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