<script language="javascript" type="text/javascript" src="<?=base_url()?>ckeditor/ckeditor.js"></script>   

<div class="RightColumnHeading">
	
    <h1>
        <span>Create New Post</span>
    </h1>
    
</div>
<div class="clr"></div>

<div class="InnerMain2">
	<form class="niceform"  method="post" action="<?=base_url().index_page();?>blog_managment/add_post">
	<input type="hidden" name="blog_id" value="<?=$blog_id;?>"  />
    
    <dl>
           <dt>
                 <label class="NewsletterLabel">Page Title<span class="star">*</span></label>
           </dt>
           
           <dd>
                <input type="text"  name="title" id="title"  size="55"  />              
           </dd>
    </dl>
    
    <dl>
           <dt>
                 <label class="NewsletterLabel">Description</label>
           </dt>
           
           <dd>
                <textarea name="description" id="description" class="ckeditor" ></textarea>           
           </dd>
    </dl>
    <dl>
       <dt>&nbsp;
             
       </dt>
       <dd>
            <input type="button" onclick="history.go(-1);" value="Back"> &nbsp; <input type="submit" value="Continue">
       </dd>
	</dl>
    </form>
</div>