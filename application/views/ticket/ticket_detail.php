<script type="text/javascript">
$(document).ready(function(e) {
    
	$(".leftComment,.rightComment").hover(
		function(){
			$(this).find(".toolbox").fadeIn("fast");
		},
		function(){
			$(this).find(".toolbox").fadeOut("fast");
		}
	);
	$(".toolbox").click(function(e) {
		
		if(!confirm("Are you sure you want to Delete?"))
		{
			return false;
		}
		
		var thisDiv = $(this);
        var comment_id = $(this).attr("id");
		// alert(comment_id);
		
		$.ajax({
			type: "POST",
			url: "<?=site_url()?>support_ticket/remove_comment/"+comment_id,
			success: function(){
				thisDiv.parent().fadeOut();
			}
		}); 
    return false;
	});
});

</script>
<style>
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
	background:#C6D3E1;
	padding:5px;
	font-weight:bold;
	margin:0 0 5px 0;
	font-size:12px;
}
.leftComment{
	background:#F2F4F9;
	float:left;
}
.rightComment{
	background:#E5EEF7;
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
<div class="commentBox" >
<h3> &gt;&gt; Reply</h3>
	
    <?php
	if($comments)
	{ 
	
	
		foreach( $comments as $row )
		{
			$class = ( $row['type'] == "admin" ) ? "leftComment" : "rightComment" ; 
		?>
		<div class="<?=$class?>">
        <div class="toolbox" id="<?=$row['id']?>">
        <img src="<?=base_url()?>images/common/delete.png" height="16px" width="16px" title="Delete this comment" />
        </div>
		<h4>By:&nbsp;<?=$row['name'];?>&nbsp;<em>( <?=$row['email'];?> )</em></h4>
        <div class="date"><strong>ON:</strong><?=convert_mysql_date_format($row['date_created']);?></div>
        <?=$row['description'];?>
		</div>
		<?php 
		}
	
	} ?>
    
    
    <form class="niceform" action="<?=site_url();?>support_ticket/post_comment/<?=$ticket['t_id']?>" method="post">
    <div class="postComment">
    	
        <div>
    	<textarea id="description" name="description"  rows="10" cols="42"></textarea>
        </div>
        
        <div class="btn">
        <input type="submit" value="Post Reply">
        </div>
        
    </div>
    </form>
</div>




</div>