<div class="RightColumnHeading">
    <h1>
        <span>Comments Edit</span>
    </h1>
</div>
<div class="clr"></div>

<!--Normal -->
<div class="InnerMain2">
<?php 
/*?><div>
<?php echo $this->session->flashdata('rspPostEdit'); ?>
</div><?php 
*/?>


<form class="niceform" method="post" action="<?=base_url().index_page();?>blog_managment/edit_comment">
<input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>" />
<input type="hidden" name="post_id" value="<?php echo $comment['post_id']; ?>" />


<div class="PageDetail">
<p>Comment By: <?php echo $comment['name']; ?></p>
<p>Date:	<?php echo $comment['date_created']; ?></p>
</div>


	<dl>
       <dt>
             <label  class="NewsletterLabel">Description</label>
       </dt>
       <dd>
            <textarea rows="10" cols="42" name="message" id="message" ><?php echo $comment['message']; ?></textarea>
       </dd>
	</dl>
    
    <dl>
       <dt>
             &nbsp;
       </dt>
       <dd>
            <input type="button" onclick="window.location = '<?=base_url().index_page()?>blog_managment/post_comment/<?=$comment['post_id'];?>'" value="Back">
       &nbsp;
       <input type="submit" value="Save">
       </dd>
	</dl>
    

</div>