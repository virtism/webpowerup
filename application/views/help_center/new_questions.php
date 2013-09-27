
<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/HelpCenter.png" alt="Question Answers"/>
        <span>Questions & Answers</span>
    </h1>
</div>

<div class="form">
 <form action="<?=base_url().index_page()?>help_center/do_creat_question" method="post" name="new_question" id="new_question" class="niceform">
 <input type="hidden" name="action" value="<?=$action?>">
 <input type="hidden" name="question_id" value="<?=(isset($question_array[0]["id"])) ? $question_array[0]["id"] : ""?>">
    <fieldset>
            <dl>
                <dt><label for="email" class="NewsletterLabel"></label></dt>
                <dd><label class="check_label"> You can create Questions/Answers here for the Help Center  </label></dd>
            </dl>
            <dl>
                <dt><label for="email" class="NewsletterLabel">Question Title :</label></dt>
                <dd><input type="text" name="question_title" value="<?=(isset($question_array[0]["question_title"])) ? $question_array[0]["question_title"] : ""?>" size="55" /></dd>
            </dl>
           
            <dl>
                <dt><label for="category" class="NewsletterLabel">Category :</label></dt>
                <dd>
                	
                    
                    <!--	IF TOPIC EXISTS	-->
                    <?php
					if(!empty($all_topics_array))
					{
					?>
                    <div  style=" position:relative; margin-top:10px; float:left">
                      <select size="4" name="topic_id[]" multiple="multiple" id="topic_id"  style="width:360px;"> 
                              <?	
								for($i=0;$i<count($all_topics_array);$i++)
								{
									$slected = '';
									
									if(isset($question_array[0]["topics"]) && count($question_array[0]["topics"] > 0))
									{
										for($j=0;$j<count($question_array[0]["topics"]);$j++)
										{
											
											if(array_search($all_topics_array[$i]["id"],$question_array[0]["topics"][$j]) )
											{
												$slected = 'selected="selected"';
											}
											
										}
									}
									?>
										<option value="<?=$all_topics_array[$i]["id"]?>" <?=$slected?> ><?=$all_topics_array[$i]["topic_title"]?></option>
									<?
								}
							?>   
                      </select>
                    </div>
                    <?php
					}
					?>
                    <!--IF NO TOPIC--> 	
                    <div style="width:100%; float:left; margin-bottom:5px;">
                    <label class="check_label"> You can Enter this Question as A FAQ or <a style="text-decoration:underline;" href="<?=base_url().index_page()?>help_center/create_new_topic">Creat Topic</a></label>
                    <label class="check_label">Is Help Center Most Frequently Asked Question </label>
                    </div>
                    <input type="checkbox" name="is_faq" value="1"  checked="checked" />
                    <label class="check_label">Most FAQ </label>
                    
              </dd>
            </dl>
            
         <dl>
           <dt><label for="comments2" class="NewsletterLabel">Description:</label></dt>
                <dd><textarea name="description" id="description" rows="10" cols="42"><?=(isset($question_array[0]["description"])) ? $question_array[0]["description"] : ""?></textarea></dd>
            </dl>
            
           
            
            <dl>
                <dt><label for="color" class="NewsletterLabel"></label></dt>
                <dd>
                    <div class="ButtonRow">
                <a href="<?=base_url().index_page();?>help_center/questions_home" class="BackButton">
                    <img src="<?=base_url();?>images/webpowerup/BackBlue.png" alt="BackBlue"/>
                </a>
                 <input type="image" src="<?=base_url();?>images/webpowerup/SaveGreen.png">
                
             </div>
                </dd>
            </dl>

             
            
        </fieldset>
        
 </form>
 </div>