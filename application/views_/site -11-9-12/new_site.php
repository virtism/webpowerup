
<div class="RightColumnHeading">
    <h1>
        <span>Create a Website - Step 1</span>
    </h1>
</div>
<div class="form">
<form class="niceform" action="<?=base_url().index_page()?>SiteController/creatnewsite_step2" accept-charset="utf-8" method="post" id="user" name="site_setup_stp2">
<input type="hidden" value="site_setup_stp2" name="action" />

<dl>
       <dt>
             <label  class="NewsletterLabel">Website Title <span class="star">*</span></label>
       </dt>
       <dd>
            <input id="site_title" name="site_title" type="text" maxlength="40" size="40" />

            <?php echo form_error('site_title', '<label class="error">', '</label>'); ?>
       </dd>
</dl>

<dl>
       <dt>
             <label  class="NewsletterLabel">Website Subdomain <span class="star">*</span></label>
       </dt>
       <dd>
            <input id="site_domain" name="site_domain" type="text" maxlength="40" size="40" />.<? $url = explode('www.',$_SERVER["HTTP_HOST"]); echo $url[count($url)-1]; ?>
                <?php echo "<br>".form_error('site_domain', '<label class="error">', '</label>'); ?>
       </dd>
</dl>

<dl>
       <dt>
             <label  class="NewsletterLabel">Website Domain <span class="star">*</span></label>
       </dt>
       <dd>
            <input id="site_domain"  name="domain" type="text" maxlength="40" size="40" />
       </dd>
</dl>

<dl>
       <dt>
             
       </dt>
       <dd>
           

                <input type="button" value="BACK" onclick="javascript: history.go(-1);" /> &nbsp; <input type="submit" value="NEXT" />

            
       </dd>
</dl>

</form>
</div>