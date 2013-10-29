 <div class="RightColumnHeading">
    <h1 class="createroom">
        <img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt=" Create New Department"/>
        <span>Create New Ticket</span>
    </h1>
</div>

<div class="InnerMain2">
<div class="form">
<form action="<?=base_url().index_page();?>support_ticket/insert_ticket" method="post" class="niceform">
<input type="hidden" name="t_owner" value="<?=$_SESSION['user_info']['user_id'];?>">
     
            <dl>
                <dt><label for="email" class="NewsletterLabel">Email <span class="star">*</span> </label></dt>
                <dd>
                	<?php echo (isset($_SESSION['user_info']['user_email'])) ? $_SESSION['user_info']['user_email'] : "" ; ?>
        			<input type="hidden" name="t_email" value="<?=(isset($_SESSION['user_info']['user_email'])) ? $_SESSION['user_info']['user_email'] : "" ;?>" >
                </dd>
            </dl>
            
             <dl>
                <dt><label for="email" class="NewsletterLabel">Subject <span class="star">*</span></label></dt>
                <dd><input type="text" name="t_subject" id="t_subject" size="55" /></dd>
            </dl>
            
            <dl>
                <dt><label for="gender" class="NewsletterLabel">Department <span class="star">*</span></label></dt>
                <dd>
                	<?php 
					if ($query->num_rows() > 0)
  					{ ?>
                        <div style=" float:left; width:100%; position:relative;">
                        <select size="1" name="t_department_id" id="t_department_id"  style="width:360px"> 
                        <?php
                        foreach($query->result() as $row)
					  	{ ?>
	                    	<option value="<?=$row->d_id;?>"><?=$row->d_name;?></option> 
						<?php
						} ?>
                        </select>
                    	</div>
                    <?php 
					} 
					else
					{ ?>
                    No department exist.
                    <?php
					} ?>          
                </dd>
            </dl>
            
            <dl>
                <dt><label for="comments2" class="NewsletterLabel">Priority <span class="star">*</span></label></dt>
                <dd>
                    <div style=" float:left; width:100%; position:relative;">
                    <select size="1" name="t_priority" id="t_priority"  style="width:360px"> 
                        <option value="Normal">Normal</option>
  						<option value="High">High</option> 
                    </select>
                    </div>
                </dd>
            </dl>
            
            <dl>
                <dt><label for="comments2" class="NewsletterLabel">Description <span class="star">*</span></label></dt>
                <dd><textarea name="t_detail" id="t_detail" rows="10" cols="42"></textarea></dd>
            </dl>
                                
            <dl>
                <dt><label for="color" class="NewsletterLabel"></label></dt>
                <dd>
                    <div class="ButtonRow">
                       
                        <a href="<?=base_url().index_page();?>support_ticket">
                        	<img src="<?=base_url();?>images/webpowerup/SupportBlue.png" alt="Insert Green"/>
                        </a>
                        
                        <input type="image" src="<?=base_url();?>images/webpowerup/TicketGreen.png" alt="Insert Green"/>
                        
                       
                     </div>
                     
                </dd>
            </dl>
	</form>
</div>
</div>