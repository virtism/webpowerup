<script language="javascript" type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>
<style>
.NoData {
    color: #FF0000;
    float: left;
    min-height: 30px;
    padding-top: 10px;
    width: 100%;
	font-weight:bold;
}
</style>

<div class="RightColumnHeading">
	
    <h1>
        <span>Edit Post</span>
    </h1>
    
</div>
<div class="clr"></div>

<div class="InnerMain2">
<?php
if($post)
{ 
?>
    <div>
        <?php echo $this->session->flashdata('rspPostEdit'); ?>
    </div>
    
    <form class="niceform" method="post" action="<?=base_url().index_page();?>blog_managment/edit_post">
    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>" />
    <input type="hidden" name="blog_id" value="<?php echo $post['blog_id']; ?>" />

	<dl>
           <dt>
                 <label class="NewsletterLabel">Title<span class="star">*</span></label>
           </dt>
           
           <dd>
                <input type="text"  name="title" id="title" value="<?php echo $post['title']; ?>" maxlength="30" size="55"  />              
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label class="NewsletterLabel">Description</label>
           </dt>
           
           <dd>
                <textarea name="description" id="description" class="ckeditor" ><?php echo $post['description']; ?></textarea>           
           </dd>
    </dl>
    <dl>
       <dt>&nbsp;
             
       </dt>
       <dd>
            <input type="button" onclick="window.location = '<?=base_url().index_page()?>blog_managment/blog/<?=$post['blog_id'];?>'" value="Back">
       &nbsp;
       		<input type="submit" value="Save">
       </dd>
	</dl>
    </form>

<?php
} 
else
{
	echo "<p align=\"center\" class=\"NoData\">No data found</p>"; 
} 
?>

</div>