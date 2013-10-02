<style>
.mainContentDiv{
	width:500px;
	clear:both;
	margin:0 auto;
	margin-top:25px;
	color:#4E4E4E;
}
.mainContentDiv label{
	height:30px;
	line-height:30px;
}
.clr{
	clear:both;
}
</style>
<div class="RightColumnHeading">
    <h1>
        <span>FORGOT PASSWORD SECTION</span>
    </h1>
</div>
<div class="clr"></div>


<div class="mainContentDiv">

<form name="user" method="post" action="<?=base_url().index_page()?>UsersController/Password_Recovery" class="niceform">
       
        

        <div style="clear:left;">
            <label for="user_login">Submit Your Email</label>
             <div>
            <input id="user_email" type="text" size="55" name="user_email"  >
             </div>
        </div>
       

        
        <div style="clear:left;">
			<br />
            <div>

                <input type="submit" value="Get Password" />
                <? if(isset($msg)){ echo $msg; } ?>
            </div>
        
        </div>

        

</form>
</div>