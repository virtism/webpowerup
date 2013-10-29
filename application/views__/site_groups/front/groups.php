<script type="text/javascript">
	
	$(document).ready(function(e) {
        $(".unsubscribe").click(function(e) {
			var group = $(this).attr("id");
            if( confirm("Are you sure you want to unsubscribe from "+group+" !") )
			{
				return true;
			}
			return false
        });
    });
	
</script>
<div>
<div>
	<?php echo $this->session->flashdata('upgradeGroupRsp'); 
	if($this->config->item('seo_url') == 'On')
	{
		
		$path = 'http://'.$_SERVER['SERVER_NAME'].'/';			
	}
	else
	{
		$path =  base_url().index_page();
	}
	
	
	
	?>
</div>
  <h2>Your Groups</h2>
  
  <div style="float:right">
  <a href="<?php echo $path."group_managment/new_group"; ?>"><img src="<?=base_url()?>/css/mashup/images/Join-Now-Button.png"/> </a>
  </div>
	<?php 
	if($allGroups->num_rows() > 0)
	{ ?>
        
        <table width="100%" border="0">
        <tr>
          <th width="21%" align="left" valign="middle" scope="col">Group No</th>
          <th width="27%" align="left" valign="middle" scope="col">Group Name</th>
          <th width="33%" align="left" valign="middle" scope="col">Payment Method</th>
          <th colspan="2" align="center" valign="middle" scope="col">Action</th>
        </tr>
        
        <!--
        <tr>
          <td align="left" valign="middle">1</td>
          <td align="left" valign="middle">Group A</td>
          <td align="left" valign="middle">Free</td>
          <td width="8%" align="left" valign="middle"><a href="#"> Edit </a></td>
          <td width="8%" align="left" valign="middle"><a href="#"> Delete </a></td>
        </tr>
        -->
        <?php
				 
        $i = 1;
        foreach($allGroups->result_array() as $row)
        { ?>
        <tr>
          <td align="left" valign="middle"><?php echo $i; ?></td>
          <td align="left" valign="middle"><?php echo $row['group_name']; ?></td>
          <td align="left" valign="middle"><?php echo $row['payment_method']; ?></td>
          <td width="11%" align="left" valign="middle"><a href="<?php echo $path."group_managment/edit_group/".$row['id']; ?>"> Upgrade </a></td>
          <td width="8%" align="left" valign="middle"><a class="unsubscribe" id="<?=$row['group_name'];?>" href="<?php echo $path."group_managment/unsubsribe/".$row['id']; ?>"> Unsubscribe </a></td>
        </tr>
        <?php 
        $i++;
        } ?>
        </table>
    <?php 
	} 
	else
	{
		echo "No group found.";
	}
	?>
</div>
