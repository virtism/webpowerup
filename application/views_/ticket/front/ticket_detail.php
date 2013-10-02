<style>
.ticketTbl{
	width:90%;
	margin:0 0 10px 0;
}
.ticketTbl tr td{
	padding:5px;
}
.postText{
	width:350px;
	height:120px;
	border:#B1B0B1 solid 1px;
	margin:0 0 10px 0;
	padding:10px;
}

.commentBox{
	width:700px;
	padding:10px 10px 10px 10px;
	margin:15px 0 0 35px;
	float:left;
}
.commentBox .postComment{
	margin:10px;
	width:675px;
	height:225px;
	float:left;
}
.commentBox .postComment textarea{
	/*width:660px;
	border:solid 1px #666666;
	height:150px;*/
}
.commentBox .postComment .btn{
	
}
h3{
	margin:10px;
}
.leftComment,.rightComment{
	width:70%;
	margin:5px;
	padding:10px;
	position:relative;
}
.leftComment h4,.rightComment h4{
	background:#F0EEEF;
	padding:5px;
	font-weight:bold;
	margin:0 0 5px 0;
	font-size:12px;
}
.leftComment{
	background:#E0E0E0;
	float:left;
}
.rightComment{
	background:#E0E0E0;
	float:right;
}
.leftComment .toolbox,.rightComment .toolbox{
	position:absolute;
	top:5px;
	right:5px;
	height:16px;
	width:auto;
	display:none;
	cursor:pointer;
}
.date{
	font-size:10px;
	margin:0 0 5px 0;
}
</style>

<h2>Ticket Detail</h2>
<div>
<?php
if ($ticket->num_rows() == 1 )
{
?> 
    <table width="100%" border="0" bgcolor="#F9F9F9" class="ticketTbl">
    
        <tr bgcolor="#DEDDDD">
        	<td colspan="2" align="left" ><strong></strong></td>
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
        
        
        <?php 
		} ?> 
    </table>
<div>
    <form name="ticket_comment" method="post" action="<?php echo site_url(); ?>ticket/ticket_detail/<?php echo $ticket_id; ?>">
        
    <?php if ( $this->session->flashdata('postResponse') ) {  echo $this->session->flashdata('postResponse'); } ?> 
    
    <table width="100%" border="0">
    <tr>
    <td>
        <textarea class="postText" name="comment_detail"></textarea>    </td>
    </tr>
    <tr>
    <td align="left">
      <input type="submit" name="comment_post" id="comment_post" value="Post" />
    </td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    </tr>
    
    <!-- comment here 	-->
    
    
    </table>
    </form>
    
    <?php
	if($comments)
	{ 
		//echo "<pre>";	print_r($comments);
		foreach( $comments as $row )
		{
			$class = ( $row['type'] == "admin" || $row['user_id'] != $_SESSION['login_info']['customer_id'] ) ? "leftComment" : "rightComment" ; 
		?>
		<div class="<?=$class?>">
        <h4>By:&nbsp;<?=$row['name'];?>&nbsp;<em>( <?=$row['email'];?> )</em></h4>
        <div class="date"><strong>ON:</strong><?=convert_mysql_date_format($row['date_created']);?></div>
        <?=$row['description'];?>
		</div>
		<?php 
		}
	
	} ?>
    
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
