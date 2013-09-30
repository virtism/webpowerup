<div class="UserInfo" style="height: 86px;">
    <a href="#" class="UserThumb">
        <img src="<?=base_url()?>images/webpowerup/user_thumb.png" alt="userthumb"/>
    </a>
    <ul>
        <li>Welcome</li>
        <li>
            <a href="#">
			<?php 
			if(isset($_SESSION['user_info']) )
			{
				echo $name = $_SESSION['user_info']['user_fname']." ".$_SESSION['user_info']['user_lname'];		
			} ?>
            </a>
        </li>
        <li id="date_time">
        	<script type="text/javascript">window.onload = date_time('date_time');</script>            
        </li>
    </ul>
</div> <!--User info ends here-->