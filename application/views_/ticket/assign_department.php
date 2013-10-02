<div class="RightColumnHeading">
    <h1 class="createroom">
        <img src="<?=base_url();?>images/webpowerup/CreateResponder.png" alt=" Create New Department"/>
        <span>Assign Group to Department</span>
    </h1>
</div>

<div class="InnerMain2">
<div class="form">
 <form action="<?=base_url().index_page();?>support_ticket/assign_department" method="post" class="niceform">
 <input type="hidden" name="d_id" value="<?=$dep->d_id?>">
        <fieldset>
            <dl>
                <dt><label for="email" class="NewsletterLabel">Name </label></dt>
                <dd>
                <?php echo $dep->d_name; ?>
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
							{
								$selected = ( $dep->d_group_id == $row->id ) ? " selected=\"selected\" " : "" ;  
								
							?>
								<option value="<?=$row->id?>" <?=$selected?> ><?=$row->group_name?></option>    
							<?php
                            }
						?>
                    </select>
                    </div>
                    <?php
					} 
					else
					{ ?>
					No group found. Create group first	
					<?php
                    } ?>
                    
                   
                </dd>
            </dl>
            
                                
            <dl>
                <dt><label for="color" class="NewsletterLabel"></label></dt>
                <dd>
                    <div class="ButtonRow">
                         
                        
                         <input type="submit" value="Save" src="<?=base_url();?>images/webpowerup/InsertGreen.png" alt="Insert Green"/>

                     </div>
                     
                </dd>
            </dl>

             
            
        </fieldset>
        
 </form>
 </div>
 </div>
