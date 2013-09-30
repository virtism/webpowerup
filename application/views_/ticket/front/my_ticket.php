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
 
 <div class="ticket_type">
 	<ul>
    	<li><a href="<?=site_url();?>ticket/my_ticket/assigned" title="Ticket assigned to your department">Create a ticket</a></li>
        <li><a href="<?=site_url();?>ticket/my_ticket/created" title="Ticket created by you">Existing tickets</a></li>
    </ul>
 </div>
</div>
