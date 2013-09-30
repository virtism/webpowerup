<script type="text/javascript">
	function do_delete()
	{
		var msg = confirm("Are you sure you want to Delete?");
		if(msg)
		{
			return true;
		}
		return false;
	}
	
$(document).ready(function(e) {  
	$(".DataGrid2 ul:odd").addClass("TableData");
	$(".DataGrid2 ul:even").addClass("TableData AlterRow");
	$(".DataGrid2 ul:first").removeClass("TableData AlterRow").addClass("TableHeader");
});

</script>


<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/CreatNewsletter.png" alt="Rooms Management"/>
        <span>Newsletter Management</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?php echo base_url().index_page() ?>Create_Newsletter">
            <img src="<?=base_url();?>images/webpowerup/createNewsletter.png" alt="Rooms Management"/>
        </a>
    </div>
    <div class="RightSideButton">
        <a href="<?php echo base_url().index_page() ?>Create_Newsletter/creat_newsletter_group">
            <img src="<?=base_url();?>images/webpowerup/createNewsletter.png" alt="Rooms Management"/>
        </a>
    </div>
</div>

<div class="PageDetail">
<p>Newsletter Details  </p>
<p>Here All Records of Newsletters</p>
</div>
   <? if($this->session->flashdata('success')){ ?>
   		<div style="color:#009900; font-weight:bold; margin-left:30px;"><?=$this->session->flashdata('success')?></div>
   <? } ?>     
 <div class="DataGrid2">
        <ul>
            <li>Subject </li>
            <li>Newsletter Body </li>
            <li>Recipients Group </li>
            <li>Newsletter Created </li>
            <li>Newsletter Send </li>
            <li class="Actions">Action</li>
        </ul>
         <?php
		 if($newsletter)
		 {
			 // $this->firephp->log($newsletter);
			 // echo "<pre>";	print_r($newsletter);	echo "</pre>";
			 
			 foreach($newsletter as $row )
			 { 
			 	//echo "<pre>";	print_r($row);	echo "</pre>"; die();
				
			 	$link = "";
				//if($row['news_date_sent'] == '' || $row['news_date_sent'] == 'NULL')
				//{
				  $link='<a href=" '. base_url().index_page().'Newsletter_Management/send_newsletter_admin/'.$row['news_id'].' " >   [Click Here To Send]</a>|';  
				//}
			 ?>   
        		<ul>
                    <li>
                        <?=$row['news_subject'];?> 
                    </li>
                    <li>
                        <?=$row['news_body'];?> 
                    </li>
                     <li>
                        <? if(isset($row['group_names'])){ echo implode(',',$row['group_names']);}?> 
                    </li>
                    <li>
                       <span class="GridCalendar"><?=$row['news_date_created'];?></span>
                    </li>
                    <li>
                        <span class="GridCalendar"><?=$row['news_date_sent'];?></span>
                    </li>
                    <li class="Actions">
                         <a href="<?=base_url().index_page()?>Edit_Newsletter/index/<?=$row['news_id']?>" class="EditAction">
                            <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
                        </a>
                         <a href="<?=base_url().index_page()?>Newsletter_Management/delete_newsletter/<?=$row['news_id']?>" onClick="return do_delete()" href= "" class="DeleteAction">
                            <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                        </a><br />
                        <?=$link;?>
                    </li>
                </ul>
			 <?php
             }
		 }
		 else
		 { ?>
			<ul class="TableData">
				<li>
				<span class="NoData">
				Sorry! No Record Found.
				</span>
				</li>
			</ul>
		 <?php 
		 } ?>
</div>

<!-------------------------Newsletter Group Listing------------------------------>

 <div class="PageDetail">
<h2>Newsletter Group Listing</h2>
</div>
<div class="DataGrid2">
        <ul>
            <li>Subject </li>
            
            
            <li>Newsletter Created </li>
            <li class="Actions">Action</li>
        </ul>
         <?php
         if($newsletter_group)
         {
             foreach($newsletter_group as $row )
             { 
                 //echo "<pre>";    print_r($row);    echo "</pre>"; die();
                
                 $link = "";
                //if($row['news_date_sent'] == '' || $row['news_date_sent'] == 'NULL')
                //{
                  $link='<a href=" '. base_url().index_page().'Newsletter_Management/send_newsletter_admin/'.$row->newsgroup_id.' " >   [Click Here To Send]</a>|';  
                //}
             ?>   
                <ul>
                    <li>
                        <?=$row->newsgroup_name;?> 
                    </li>
                    <!--<li>
                        <?=$row->news_body;?> 
                    </li>
                     <li>
                        <? if(isset($row->group_names)){ echo implode(',',$row->group_names);}?> 
                    </li>-->
                    <li>
                       <span class="GridCalendar"><?=$row->newsgroup_date;?> </span>
                    </li>
                    <!--<li>
                        <span class="GridCalendar"><? //$row['news_date_sent'];?> date</span>
                    </li>-->
                    <li class="Actions">
                         <a href="<?=base_url().index_page()?>Create_Newsletter/creat_newsletter_group/<?=$row->newsgroup_id?>" class="EditAction">
                            <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
                        </a>
                         <a href="<?=base_url().index_page()?>Newsletter_Management/delete_newsletter_group/<?=$row->newsgroup_id?>" onClick="return do_delete()" href= "" class="DeleteAction">
                            <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                        </a><br />
                        <?=$link;?>
                    </li>
                </ul>
             <?php
             }
         }
         else
         { ?>
            <ul class="TableData">
                <li>
                <span class="NoData">
                Sorry! No Record Found.
                </span>
                </li>
            </ul>
         <?php 
         } ?>
</div>