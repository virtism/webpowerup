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
        <span>Login Section</span>
    </h1>
</div>
<div class="clr"></div>


<div class="mainContentDiv">

<form name="user" method="post" action="<?=base_url().index_page()?>UsersController/login/<?=$this->uri->segment(3)?>" class="niceform">
       
        

        <? if(isset($request_from) && !empty($request_from)) {?>

        <input type="hidden" name="request_from" value="<?=$request_from?>" />

        <?
        }?>

        <input type="hidden" name="action" value="doLogin" />

       

        <div style="clear:left;">
            <label for="user_login">Username</label>
             <div>
            <input id="user_login" type="text" size="55" name="user_login" value="<?=$user_login?>" >
             </div>
        </div>
       

        <div style="clear:left;">
            <label for="user_password">Password</label>
            <div>
                <input id="user_password" type="password" size="55" name="user_password" >
            </div>
           
        </div>
         <div style="clear:left;">
            <?php
                if($error_message!='')
                {
                    echo '<code>'.$error_message.'</code>';    
                }
                ?>
            </div>
		<br />
        <div style="clear:left;">

            <div>

                <input type="submit" value="Login" />

            </div>
            <div>
            	<a href="<?=base_url().index_page()?>UsersController/forgotpassword">Forgot Password?</a>
            </div>

        </div>

        

</form>
</div>
