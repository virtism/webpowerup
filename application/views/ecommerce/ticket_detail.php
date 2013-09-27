<div>

<?php

if ($ticket->num_rows() == 1 )
{
?> 
    <table width="100%" border="0" bgcolor="#F9F9F9">
    
        <tr bgcolor="#DEDDDD">
        	<td colspan="2" align="left" ><strong>Ticket</strong></td>
        </tr>
        <?php 
		foreach($ticket->result() as $row)
		{ ?>
	 
      
        <tr>
            <td width="20%"><strong>Ticket Subject:</strong> </td>
          <td width="80%"><?php echo $row->t_subject; ?></td>
      </tr>
        
        <tr>
            <td><strong>Ticket Assigned for:</strong> </td>
            <td><?php echo $row->d_name; ?></td>
        </tr>
        <tr>
          <td><strong>Ticket Number:</strong></td>
          <td><?php echo $row->t_no; ?></td>
        </tr>
        <tr>
          <td><strong>Ticket Priority:</strong></td>
          <td><?php echo $row->t_priority; ?></td>
        </tr>
        <tr>
          <td><strong>Detail:</strong> </td>
          <td><?php echo $row->t_body; ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
        <?php 
		} ?> 
    </table>
<div>
    <form name="ticket_comment" method="post" action="<?php echo base_url().index_page(); ?>ticket/ticket_detail/<?php echo $ticket_id; ?>">
        
    <?php if ( $this->session->flashdata('postResponse') ) {  echo $this->session->flashdata('postResponse'); } ?> 
    
    <table width="100%" border="0">
    <tr>
    <td>
        <textarea name="comment_detail"></textarea>    </td>
    </tr>
    <tr>
    <td align="left">
      <input type="submit" name="comment_post" id="comment_post" value="Post" />
      <input type="button" name="comment_cancle" id="comment_cancle" value="Cancle" /></td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    </tr>
    
    <!-- comment here 	-->
    <?php 
		foreach($ticketComment->result() as $comment)
		{ ?>
        <tr>
            <td>
			<?php 
				echo $comment->description; 
				echo "<br>".$comment->customer_fname." ".$comment->customer_lname;
			?>            </td>
        </tr>
    <?php } ?> 
    </table>
    </form>
    
</div>
<?php
} 
else
{
	echo "No ticket Found";
}
?>

<br />


</div>

