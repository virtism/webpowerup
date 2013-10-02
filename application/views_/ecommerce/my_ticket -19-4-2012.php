<div>

     <?php if ($query->num_rows() > 0)
	 
	 {
	 
	 ?> 
<table width="100%" border="0" bgcolor="#F9F9F9">
  <tr bgcolor="#DEDDDD">
    
    <td><strong>Ticket No </strong></td>
    
    <td><strong>Subject</strong></td>
    <td><strong>Department</strong></td>
    
  </tr>
  

     <?php foreach($query->result() as $row): ?>
     <?//  print_r($row);?>
       <tr>
       
       <td><?=$row->t_no?></td>
       <td><a href="ticket_detail/<?=$row->t_id?>" ><?=$row->t_subject?></a></td>
       <td><?=$row->d_name?></td>

       </tr> 
     <?php endforeach;?>  
      

  
</table>
<?php 
	 } 
	 
	
else
{
	echo "No tickets Found";
}
 ?>
</div>

