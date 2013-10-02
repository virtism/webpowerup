<script type="text/javascript">
function do_delete()
{
  var msg = confirm("Are you sure you want to Delete?");
  if(msg)
	 return true;
  else
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
        <img src="<?=base_url();?>images/webpowerup/HelpCenter.png" alt="Help Center"/>
        <span>Help Center</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?=base_url().index_page()?>help_center/create_new_topic">
            <img src="<?=base_url();?>images/webpowerup/CreateTopics.png" alt="Create Topics"/>
        </a>
        <a href="<?=base_url().index_page()?>help_center/questions_home">
            <img src="<?=base_url();?>images/webpowerup/QuestionAnswer.png" alt="Question Answers"/>
        </a>
    </div>
</div>
        
        
<div class="DataGrid2">
    <ul>
        <li class="Serial">Sr.No </li>
        <li>Topic / Category </li>
        <li>Description </li>
        <li>Create Date </li>
        <li class="Actions">Actions</li>
    </ul>
    
    <?php	
	if(!empty($topics_array))
	{
		for($i=0;$i<count($topics_array);$i++)
		{   
	?>   
                      
        <ul>
            <li class="Serial">
                <?=$i+1?> 
            </li>
            <li>
                <?=string_minimizer($topics_array[$i]["topic_title"]);?>
            </li>
             <li>
                <?
					if($topics_array[$i]["description"]!="")
					{
						echo string_minimizer($topics_array[$i]["description"]);
					}
					else
					{
						echo "N/A"; 
					}
					
				?>
            </li>
            <li>
                <span class="GridCalendar"><?=$topics_array[$i]["create_date"]?></span>
            </li>
            <li class="Actions">
                 <a href="<?=base_url().index_page()?>help_center/edit_topic/<?=$topics_array[$i]["id"]?>" class="EditAction">
                    <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
                </a>
                 <a onclick="return do_delete()" href="<?=base_url().index_page()?>help_center/delete_topic/<?=$topics_array[$i]["id"]?>" class="DeleteAction">
                    <img src="<?=base_url();?>images/webpowerup/DeleteAction.png" alt="button"/>
                </a>
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