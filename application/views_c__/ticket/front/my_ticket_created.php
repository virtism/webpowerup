<div>
 <h2>Opened Ticket</h2>
     <?php if ( ($opened_ticket) && $opened_ticket->num_rows() > 0)
	 
	 {
	 
	 ?> 
    
<table width="100%" border="0" bgcolor="#F9F9F9">
  <tr bgcolor="#DEDDDD">
    
    <td><strong>Ticket No </strong></td>
    
    <td><strong>Subject</strong></td>
    <td><strong>Department</strong></td>
    
  </tr>
  
     <?php foreach($opened_ticket->result() as $row): ?>
     <?//  print_r($row);?>
       <tr>
       
       <td><?=$row->t_no?></td>
       <td><a href="<?=site_url();?>ticket/ticket_detail/<?=$row->t_id?>" ><?=$row->t_subject?></a></td>
       <td><?=$row->d_name?></td>
       </tr> 
     <?php endforeach;?>  
      
  
</table>
<?php 
	 } 
	 
	
else
{
	echo "No opened ticket Found";
}
 ?>
 
 <h2>Closed Ticket</h2>
 <?php if ( ($closed_ticket) && $closed_ticket->num_rows() > 0)
	 
	 {
	 
	 ?> 
     
<table width="100%" border="0" bgcolor="#F9F9F9">
  <tr bgcolor="#DEDDDD">
    
    <td><strong>Ticket No </strong></td>
    
    <td><strong>Subject</strong></td>
    <td><strong>Department</strong></td>
    
  </tr>
  
     <?php foreach($closed_ticket->result() as $row): ?>
     <?//  print_r($row);?>
       <tr>
       
       <td><?=$row->t_no?></td>
       <td><a href="<?=site_url();?>ticket/ticket_detail/<?=$row->t_id?>" ><?=$row->t_subject?></a></td>
       <td><?=$row->d_name?></td>
       </tr> 
     <?php endforeach;?>  
      
  
</table>
<?php 
	 } 
	 
	
else
{
	echo "No closed ticket Found";
}
 ?>
</div>
