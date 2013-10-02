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
        <span>Comment Replies</span>
    </h1>
</div>
<div class="clr"></div>

<!--Normal -->
<div class="InnerMain2">


<div class="PageDetail">
<p>Comment By: <?php echo $comment['name']; ?></p>
<p>Date:	<?php echo $comment['date_created']; ?></p>
<p>Description: <?php echo $comment['message']; ?></p>
</div>


<div class="DataGrid2">
<ul>
    <li class="Serial">
    Sr.No
    </li>
    <li>Title</li>
    <li>Created by</li>
    <li>Created on</li>
    <li>Status</li>
    <li class="Actions">Action</li>
</ul>

	<?php 
	 	// echo "<pre>";	print_r($comment);	echo "</pre>";
        if($replys)
        { 
        	$i = 1;
            foreach ($replys as $reply )
            { 
			// echo "<pre>";	print_r($comment);	echo "</pre>";
			?>
        <ul>
            <li class="Serial">
            <?php echo $i; ?>
            </li>
            
            <li>
            <?php 
			  		echo substr($reply['message'],0,50);
					echo (strlen($reply['message']) > 50) ? "..." : "";
			?>
            </li>
            
            <li><?php echo $reply['name']; ?></li>
            
            <li>
            <?php 
					
					$strDate = strtotime($reply['date_created']); 
					$dateCreate = date('M. d, Y (h:i a)', $strDate);
					echo $dateCreate;
					
			?>
            </li>
            
            <li><?php echo ucfirst($reply['status']);?></li>
            <li class="Actions">
            	<a onclick="return do_delete();" href="<?=base_url().index_page();?>blog_managment/comment_delete/<?=$reply['id'];?>" class="DeleteAction">
                    <img src="images/DeleteAction.png" alt="button"/>
                </a><br />
				<?php 
			  	
				if($reply['is_banned'] == 1)
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
              
             <a href="<?=base_url().index_page();?>blog_managment/<?=$action;?>/<?=$reply['post_id'];?>/<?=$reply['user_id'];?>" title="<?=$txtBan?> this user "> 
             		<?=$txtBan?> 
                    
                    </a> 
                    &nbsp;|&nbsp;
            	    <?php 
					//echo "<pre>";	print_r($reply); 	echo "</pre>";
					if($reply['status'] == "approve")
					{
						
						$statLink = "unapprove";
						$statText = "Unapprove";
					}
					else if ($reply['status'] == "unapprove")
					{
						$statLink = "approve";
						$statText = "Approve";
					}
					?>
                    <a href="<?=base_url().index_page();?>blog_managment/reply_status/<?=$reply['comment_id'];?>/<?=$reply['id'];?>/<?=$statLink;?>">
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


        
        


