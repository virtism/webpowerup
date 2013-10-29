<div class="RightColumnHeading">
    <h1 class="createroom">
        <img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt=" Create New Department"/>
        <span>Ticket Detail</span>
    </h1>
</div>

<div class="InnerMain2">

<?php
if($ticket)
{ 
?>
<div class="form">
	
    <dl>
        <dt>
        <label class="NewsletterLabel" for="email">Ticket Status</label>
        </dt>
        <dd>
        	<?=($ticket['t_closed']==0) ? "Open" : 'Closed <br><a href="'.site_url().'support_ticket/reopen_ticket/'.$ticket['t_id'].'">Click here to reopen ticket</a>' ;?>
           
        </dd>
    </dl>
    <dl>
        <dt>
        <label class="NewsletterLabel" for="email">Ticket created on</label>
        </dt>
        <dd>
        	<?=convert_mysql_date_format($ticket['t_open_date']);?>
        </dd>
    </dl>
    
    <dl>
        <dt>
        <label class="NewsletterLabel" for="email">Email  </label>
        </dt>
        <dd>
        	<?=$ticket['t_email'];?>
        </dd>
    </dl>
    
    <dl>
        <dt>
        <label class="NewsletterLabel" for="email">Subject </label>
        </dt>
        <dd>
        	<?=$ticket['t_subject'];?>
        </dd>
    </dl>
    <dl>
        <dt>
        <label class="NewsletterLabel" for="gender">Department </label>
        </dt>
        <dd>
        	<?=$ticket['d_name'];?>
        </dd>
    </dl>
    <dl>
        <dt>
        <label class="NewsletterLabel" for="comments2">Priority </label>
        </dt>
        <dd>
        	<?=$ticket['t_priority'];?>
        </dd>
    </dl>
    <dl>
        <dt>
        <label class="NewsletterLabel" for="comments2">Description </label>
        </dt>
        <dd>
        	<?=$ticket['t_body'];?>
        </dd>
    </dl>
</div>
<?php
} ?>

</div>