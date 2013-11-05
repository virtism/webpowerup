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

<style>

.info 
{
width:auto;
padding:15px 15px 15px 15px;
margin:15px 15px 15px 15px;	
color: #00529B;
background-color: #BDE5F8;
}
.success 
{
	width:auto;
padding:15px 15px 15px 15px;
margin:15px 15px 15px 15px;	
color: #4F8A10;
background-color: #DFF2BF;
}
.warning 
{
	width:auto;
padding:15px 15px 15px 15px;
margin:15px 15px 15px 15px;	
color: #9F6000;
background-color: #FEEFB3;
}
.error 
{
	width:auto;
padding:15px 15px 15px 15px;
margin:15px 15px 15px 15px;	
color: #D8000C;
background-color: #FFBABA;
}


</style>





<div style="text-align:right; width:100%;">
<?php 
	
	$linkText = "";
	if($blog['blog_status'] == "Published") 
	{
		$linkText = '<img src="'.base_url().'images/webpowerup/Unpublish.png" alt="Unpublish"/>';
		$action = "Unpublish";
	}
	else if($blog['blog_status'] == "Not-Published") 
	{
		$linkText = '<img src="'.base_url().'images/webpowerup/Publish.png" alt="Unpublish"/>';
		$action = "Publish";
	}
?>

</div>

<div class="RightColumnHeading">
	
    <div class="RightSideButton">
    
        <a href="<?=base_url().index_page();?>blog_managment/change_status/<?=$blog['id'];?>/<?=$action?>" >
            <?=$linkText;?>
        </a>
       
    </div>
    
    <h1>
        <span>Blog Management</span>
    </h1>
    
</div>
<div class="clr"></div>

<!--Normal-->
<div class="InnerMain2">

	<div class="<?= $this->session->flashdata('rspClass'); ?>">
		<?php echo $this->session->flashdata('rspBlog'); ?>
	</div>
    
    <form class="niceform" method="post" action="<?=base_url().index_page();?>blog_managment/edit_blog/">
	<input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>" >
    <dl>
           <dt>
                	<label class="NewsletterLabel">Blog Title <span class="star">*</span></label>
           </dt>
           <dd>
                <input size="55" type="text" name="title" id="title" value="<?=$blog['title'];?>" >
           </dd>
    </dl>
    
    <dl>
           <dt>
                	<label class="NewsletterLabel">Blog Description</label>
           </dt>
           <dd>
               		<textarea rows="10" cols="43" name="description" id="description"><?=$blog['description'];?></textarea>
           </dd>
    </dl>
    <dl>
       <dt>&nbsp;
             
       </dt>
       <dd>
            <input type="submit" name="submit" value="Save">
       </dd>
	</dl>
	</form>
</div>



<div class="RightColumnHeading">
	
    <div class="RightSideButton">
    
        <a href="<?=base_url().index_page();?>blog_managment/create_post/<?=$blog['id'];?>">
          	<img src="<?=base_url();?>images/webpowerup/New.png" alt="New"/>
        </a>    
    </div>
    
    <h1>
        <span>Blog Posts</span>
    </h1>
    
</div>
<div class="clr"></div>


<div class="DataGrid2">
<ul>
    <li class="Serial">
     Sr.No
    </li>
    <li>Title</li>
    <li>Created on</li>
    <li>Status</li>
    <li class="Actions">Action</li>
</ul>

<?php 
        if(count($posts) > 0)
        { 
        	$i = 1;
            foreach ($posts as $post )
            { ?>
        <ul>
            <li class="Serial">
              <?php echo $i; ?>
            </li>
            <li>
			<?php 
				echo substr($post['title'],0,50);
				echo (strlen($post['title']) > 50) ? "..." : "" ;	
			?>
            </li>
            <li>
            <?php 	
				$strDate = strtotime($post['date_created']); 
				$dateCreate = date('M. d, Y (h:i a)', $strDate);
				echo $dateCreate;
			?>
            </li>
            <li><?=$post['status'];?></li>
            <li class="Actions">
           		<a href="<?=base_url().index_page();?>blog_managment/post_detail/<?=$post['id'];?>" class="Respond">
                    <img src="images/DeleteAction.png" alt="button"/>
                </a>
            	
                <a href="<?=base_url().index_page();?>blog_managment/post_edit/<?=$post['id'];?>" class="EditAction">
                    <img src="images/EditAction.png" alt="button"/>
                </a>
                <a onclick="return do_delete();" href="<?=base_url().index_page();?>blog_managment/post_delete/<?=$blog['id'];?>/<?=$post['id'];?>" class="DeleteAction">
                    <img src="images/DeleteAction.png" alt="button"/>
                </a>
                <a href="<?=base_url().index_page();?>blog_managment/post_comment/<?=$post['id'];?>">See Comment</a>
            </li>
        </ul>
         <?php 
			$i++;
            } 
        } ?>

</div>

