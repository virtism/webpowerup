
<div class="RightColumnHeading">
	
    <h1>
        <span>Post Detail</span>
    </h1>
    
</div>
<div class="clr"></div>

<div class="InnerMain2">
<form class="niceform">
<dl>
       <dt>
       		<label  class="NewsletterLabel">Post Title</label>
              
       </dt>
       <dd>
            <?php echo $post['title']; ?>
       </dd>
</dl>

<dl>
       <dt>
           <label  class="NewsletterLabel">Description</label>
       </dt>
       <dd>
            <?php echo $post['description']; ?>
       </dd>
</dl>

<dl>
       <dt>
            &nbsp;
       </dt>
       <dd>
            <input type="button" onclick="history.go(-1);" value="Back">
       </dd>
</dl>
</form>
</div>


