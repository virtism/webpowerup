<script type="text/javascript">

$(document).ready(function(e) {  
	$(".DataGrid2 ul:odd").addClass("TableData");
	$(".DataGrid2 ul:even").addClass("TableData AlterRow");
	$(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
});
function do_delete()
{
	msg = confirm("Are you sure you want to Delete?");
	if(msg)
	{
		return true;
	}
	return false;
}

</script>

<div class="RightColumnHeading">
    <h1>
        <span>Comments</span>
    </h1>
</div>
<div class="clr"></div>

<!--Normal -->
<div class="InnerMain2">
<?php 
// this sshows the responce
/*?><div>
	<?php echo $this->session->flashdata('rspComment'); ?>
</div><?php 
*/?>

    <div class="DataGrid2">
    <ul>
        <li class="Serial">Sr No.</li>
        <li>Message</li>
        <li>Created by</li>
        <li>Created on</li>
        <li>Status</li>
        <li class="Actions">Action</li>
    </ul>
    
     	<?php 
	 	// echo "<pre>";	print_r($comment);	echo "</pre>";
        if($comments)
        { 
        	$i = 1;
            foreach ($comments as $comment )
            { 
			// echo "<pre>";	print_r($comment);	echo "</pre>";
			?>
    
            <ul>
                <li class="Serial">
                	<?php echo $i; ?>
                </li>
                <li>
                <?php 
			  		echo substr($comment['message'],0,50);
					echo (strlen($comment['message']) > 50) ? "..." : "" ;	
			    ?>
                </li>
                <li><?php echo $comment['name']; ?></li>
                <li>
                <?php 
					
					$strDate = strtotime($comment['date_created']); 
					$dateCreate = date('M. d, Y (h:i a)', $strDate);
					echo $dateCreate;
					
					?>
                </li>
                <li><?php echo ucfirst($comment['status']);?></li>
                <li class="Actions">
                <a class="Respond" href="<?=base_url().index_page();?>blog_managment/comment_detail/<?=$comment['id'];?>"> 
                	<img src="images/DeleteAction.png" alt="button"/>
                </a>
                <a class="EditAction" href="<?=base_url().index_page();?>blog_managment/comment_edit/<?=$comment['id'];?>">
                	<img src="images/EditAction.png" alt="button"/>
                </a>
                <a class="DeleteAction" onclick="return do_delete();" href="<?=base_url().index_page();?>blog_managment/comment_delete/<?=$post?>/<?=$comment['id'];?>">
                	<img src="images/DeleteAction.png" alt="button"/>
                </a>
              	   
              	
                
                <?php 
			  	
				if($comment['is_banned'] == 1)
				{
					$txtBan = "Acitve";
					$action = "unban_user";
				}
				else
				{
					$txtBan = "Banned";
					$action = "ban_user";
				}
			  
			  	?>
              
                <a href="<?=base_url().index_page();?>blog_managment/<?=$action;?>/<?=$post?>/<?=$comment['user_id'];?>" title="<?=$txtBan?> this user "> 
             		<?=$txtBan?> 
                    
                    </a> 
                    &nbsp;|&nbsp;
            	    <?php 
					
					if($comment['status'] == "approve")
					{
						
						$statLink = "unapprove";
						$statText = "Unapprove";
					}
					else if ($comment['status'] == "unapprove")
					{
						$statLink = "approve";
						$statText = "Approve";
					}
					
				?> 
              	<a href="<?=base_url().index_page();?>blog_managment/comment_status/<?=$post?>/<?=$comment['id'];?>/<?=$statLink;?>">
                	<?=$statText?>
				</a> 
              	
                </li>
            </ul>
    		<?php 
			$i++;
            } 
        }
		else
		{ ?>
			<ul class="TableData">
                <li>
                <span class="NoData">
                Sorry! No Record Found.
                </span>
                </li>
            </ul>
		<?php 
		} ?>
    </div>

</div>