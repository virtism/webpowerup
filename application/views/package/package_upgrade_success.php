<style>
#rspMain{
	/*position:relative;*/
	clear:both;
	
}
#rsp{
	/*position:absolute;
	top:0;*/
	width:100%;
	height:45px;
	line-height:45px;
	font-size:14px;
	padding:10px 10px 10px 10px;
}

.info 
{
color: #00529B;
background-color: #BDE5F8;
}
.success 
{
color: #4F8A10;
background-color: #DFF2BF;
}
.warning 
{
color: #9F6000;
background-color: #FEEFB3;
}
.error 
{
color: #D8000C;
background-color: #FFBABA;
}

</style>

<h1> Upgrade Complete </h1>

<p>
    <div id="rspMain">
        <div id="rsp" class="<?=$class?>"><?=$msg?></div>
        <!--<div id="closeRsp"></div>-->
    </div>
    
    
   <br />
     Click <a href="<?=base_url().index_page()?>UsersController/login/sitelogin" ><strong>here</strong></a> to Continue 
   
 
</p>


