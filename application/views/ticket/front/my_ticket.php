<style>
.ticket_type ul{
	list-style:circle;
	padding:0 0 0 15px;
	margin:10px 0 0 15px;

}
.ticket_type ul li{	
	margin:0 0 10px 0px;

}
</style>
<div>
 <h2>Your Tickets</h2>
  <?
 
 if($this->config->item('seo_url') == 'On')
	{
		
		$path = 'http://'.$_SERVER['SERVER_NAME'].'/';			
	}
	else
	{
		$path =  base_url().index_page();
	}
 
 ?>
 <div class="ticket_type">
 	<ul>
    	<li><a href="<?=$path?>ticket/my_ticket/assigned" title="Ticket assigned to your department">Existing tickets</a></li>
        <li><a href="<?=$path?>manage_ticket/index.html" title="Ticket created by you">Create a ticket</a></li>
    </ul>
 </div>
</div>
