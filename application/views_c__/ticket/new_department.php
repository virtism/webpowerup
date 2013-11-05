<div class="RightColumnHeading">
    <h1 class="createroom">
        <img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt=" Create New Department"/>
        <span>Create New Department</span>
    </h1>
</div>

<div class="InnerMain2">
<div class="form">
 <form action="<?=base_url().index_page();?>support_ticket/insert_department" method="post" class="niceform">
 <input type="hidden" name="d_owner" value="<?=$_SESSION['user_info']['user_id']?>">
        <fieldset>
            <dl>
                <dt><label for="email" class="NewsletterLabel">Name </label></dt>
                <dd>
                <input type="text" name="d_name" id="d_name" size="55" />
                <span style="margin:0 0 0 10px; width:150px; float:left;"><?php echo form_error('d_name'); ?></span>
                </dd>
               
            </dl>
            
            <dl>
                <dt><label for="email" class="NewsletterLabel">Notification Email</label></dt>
                <dd>
                <label class="check_label">Comma-Seperated list of emails to notify when new ticket <br />is assigned to this department.</label>
                <div style="clear:left;"><input type="text" name="d_email_notification" id="d_email_notification" size="55" /></div>
                </dd>
            </dl>
            
            <dl>
                <dt><label for="gender" class="NewsletterLabel">Groups</label></dt>
                <dd>
                	<?php 
					
					if ( $q->num_rows() > 0)
					{ ?>  
                    <div style=" float:left; width:100%; position:relative;">
                    <select size="1" name="d_group_id" id="d_group_id"  style="width:360px"> 
                        <?php 
							foreach ($q->result() as $row)
							{ ?>
								<option value="<?=$row->id?>" ><?=$row->group_name?></option>    
							<?php
                            }
						?>
                    </select>
                    </div>
                    <?php
					} 
					else
					{ ?>
					<a href="<?=base_url()?>sitegroups/new_site_group/">No Group Exists Click To Create Group!</a>
					<?php
                    } ?>
                   
                </dd>
            </dl>
            
                                
            <dl>
                <dt><label for="color" class="NewsletterLabel"></label></dt>
                <dd>
                    <div class="ButtonRow">
                         <a href="<?=base_url().index_page();?>support_ticket">
                        	<img src="<?=base_url();?>images/webpowerup/SupportBlue.png" alt="Insert Green"/>
                         </a>
                        
                         <input type="image" src="<?=base_url();?>images/webpowerup/InsertGreen.png" alt="Insert Green"/>

                     </div>
                     
                </dd>
            </dl>

             
            
        </fieldset>
        
 </form>
 </div>
 </div>