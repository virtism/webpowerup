

<div class="RightColumnHeading">
    <h1>
        <span>Create Your New Blog</span>
    </h1>
</div>
<div class="clr"></div>

<!--Normal -->
<div class="InnerMain2">


<div>
	<?php echo $this->session->flashdata('rspBlogAdd'); ?>
</div>


<form class="niceform" method="post" action="<?=base_url().index_page();?>blog_managment/add_blog">


<dl>
       <dt>
             <label  class="NewsletterLabel">Blog Title <span class="star">*</span></label>
       </dt>
       <dd>
          <input type="text" name="title" id="title"  size="53"  /> 
       </dd>
</dl>

<dl>
       <dt>
             <label  class="NewsletterLabel">Description</label>
       </dt>
       <dd>
          <textarea name="description" id="description"  rows="10" cols="42"></textarea>
       </dd>
</dl>
<dl>
       <dt>&nbsp;
             
       </dt>
       <dd>
            <input type="submit" value="Continue">
       </dd>
</dl>



</form>
</div>