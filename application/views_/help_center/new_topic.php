
<div class="RightColumnHeading">
    <h1>
        <img src="<?=base_url();?>images/webpowerup/HelpCenter.png" alt="Question Answers"/>
        <span>New Topic</span>
    </h1> 
</div>
<div class="PageDetail">
<p>You can create topics here for the Help Center </p>
<p>Topic Title / Category Name</p>
</div>

<div class="form">
<form action="<?=base_url().index_page()?>help_center/do_creat_topic" method="post" name="new_topic" id="new_topic" class="niceform"  enctype="multipart/form-data">
 
        <dl>
               <dt>
                    <label for="email" class="NewsletterLabel">Topic Title / Category Name</label>
               </dt>
               <dd>
                    <input type="text" name="topic_title" value="<?=(isset($topic_array[0]["topic_title"])) ? $topic_array[0]["topic_title"] : ""?>" size="55" >
               </dd>
        </dl>
        <dl>
               <dt>
               <label for="email" class="NewsletterLabel"> Category Icon </label>     
               </dt>
               <dd>
               <?
                    if(isset($topic_array[0]["image_name"] ))
                    {
                        ?>
                            <a href="<?=base_url()?>/media/help_center/icons/<?=$topic_array[0]["image_name"]?>" target="_blank"><?=$topic_array[0]["image_name"]?></a>
                            <br>		
                            If you want to change the icon upload a new icon.
                        <?	
                    }
                ?>
                <input type="file" name="topic_icon" size="35" >
               </dd>
        </dl>
        <dl>
               <dt>
               <label for="email" class="NewsletterLabel"> Description </label>
                     
               </dt>
               <dd>
               <textarea rows="10" cols="42" name="description"><?=(isset($topic_array[0]["description"])) ? $topic_array[0]["description"] : ""?></textarea>
                    
               </dd>
        </dl>
        
        <dl>
            <dt><label for="color" class="NewsletterLabel"></label></dt>
            <dd>
                <div class="ButtonRow">
            <a href="<?=base_url().index_page();?>help_center/topics_home" class="BackButton">
                <img src="<?=base_url();?>images/webpowerup/BackBlue.png" alt="BackBlue"/>
            </a>
             <input type="image" src="<?=base_url();?>images/webpowerup/SaveGreen.png">
            
         </div>
            </dd>
        </dl>
        
</form>
</div>