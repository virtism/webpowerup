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
        <span>Questions & Answers</span>
    </h1>
    
    <div class="RightSideButton">
        <a href="<?=base_url().index_page()?>help_center/create_new_question">
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
    <?	
	if(!empty($questions_array))
	{
		for($i=0;$i<count($questions_array);$i++)
		{ ?>
    		<ul>
        <li class="Serial">
            <?=$i+1?> 
        </li>
        <li>
            <?=string_minimizer($questions_array[$i]["question_title"]);?>
        </li>
         <li>
            <?
                if($questions_array[$i]["description"]!="")
                {
					
                    echo string_minimizer($questions_array[$i]["description"],50); 
                }
                else
                {
                    echo "N/A"; 
                }
                
            ?>
        </li>
        <li>
            <span class="GridCalendar"><?=$questions_array[$i]["create_date"]?></span>
        </li>
        <li class="Actions">
             <a href="<?=base_url().index_page()?>help_center/edit_question/<?=$questions_array[$i]["id"]?>" class="EditAction">
                <img src="<?=base_url();?>images/webpowerup/EditAction.png" alt="button"/>
            </a>
             <a onclick="return do_delete()" href="<?=base_url().index_page()?>help_center/delete_question/<?=$questions_array[$i]["id"]?>" class="DeleteAction">
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