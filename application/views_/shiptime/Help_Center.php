<style>

#cc{
	width: 860px;
	float:left;
}

#ccleft{
	
}

#virticalline{
	margin-left: 40px;
}

#ccright{
	margin-left: 15px;
    width: 320px;
}

</style>

<div id="cc">
    <div id="ccleft">
        <div id="helpcenterhead">
        Help Center
        </div>
        <div id="cantfindandline">
        <div id="cantfind">
        If you can't find an answer here <a href="Help Center.html">Contact Support.</a>
        </div>
        <div id="linehorismaller">
        </div>
        </div>
        <div id="mostfrequenthead">
        <?=$topic_name?>
        </div>
        <div id="linedividerhelpcenter">
        </div>
        <div id="allquestions">
<!--                    <ul>
                <li><a href="Help Center.html">1. How do I re-print a shipping label?</a></li>
                <li><a href="Help Center.html">2. I forget my middle name, could you remind me?</a></li>
                <li><a href="Help Center.html">3. Has anyone figured out what the meaning of life is yet?</a></li>
                <li><a href="Help Center.html">4. I've been working on ShipTime for way too long, can I have a nap?</a></li>
                <li><a href="Help Center.html">5. Every time I turn on my mac, there's this chime sound. Why?</a></li>
                <li><a href="Help Center.html">6. I tried sending a package using ShipTime but I forgot why I was sending the package.</a></li>
                <li><a href="Help Center.html">7. I quit smoking recently, do I get a rebate credit reward?</a></li>
                <li><a href="Help Center.html">8. I told a friend about ShipTime via Compuserve. Where's my coupon?</a></li>
                <li><a href="Help Center.html">9. I don't have anything to ship but I still want to be a member.</a></li>
                <li><a href="Help Center.html">10. I can't believe I didn't find ShipTime sooner. Why didn't I?</a></li>
            </ul>  -->
            
<?php
/*
echo '<pre>';
print_r($faqs);
exit();   
*/
		if(!empty($faqs))
		{
			for ($i=0; $i<count($faqs); $i++)
			{
				if(!empty($faqs[$i])){
				?> 
				<h3 id="bobcontent<?=$i?>-title" class="handcursor"><?=$i+1?>. <?=$faqs[$i]['question_title']?> </h3>
				<div id="bobcontent<?=$i?>" class="switchgroup1"> <?=$faqs[$i]['description']?> </div>
				<?php
				}
 			}
			
		}
		else
		{
		 echo    '<h3 id="bobcontent2-title" class="handcursor"> NO Records Founds !</h3>
				  <div id="bobcontent2" class="switchgroup1"> NO Records Founds ! </div>
				  ';
		} 
?>
<!--<h3 id="bobcontent2-title" class="handcursor">2. I forget my middle name, could you remind me?</h3>
<div id="bobcontent2" class="switchgroup1">
Java is completely different from JavaScript.
The former is a compiled language while the later is a scripting language.
</div>
<h3 id="bobcontent11-title" class="handcursor">11. Has anyone figured out what the meaning of life is yet?</h3>
<div id="bobcontent11" class="switchgroup1">
DHTML is the embodiment of a combination of technologies- JavaScript, CSS, and HTML.
Through them a new level of interactivity is possible for the end user experience.
</div> -->
<script type="text/javascript">
var bobexample=new switchcontent("switchgroup1", "div") //Limit scanning of switch contents to just "div" elements
bobexample.setStatus('<img src="<?=base_url()?>images/png/comment_edit.png" /> ' , '<img src="<?=base_url()?>images/png/comment.png" /> ')
bobexample.setColor('darkred', '#1c32a0')
bobexample.setPersist(true)
bobexample.collapsePrevious(true) //Only one content open at any given time
bobexample.init()
</script>
                        
        </div>
    </div>
    <div id="virticalline">
    </div>            
    <div id="ccright">
        <div id="whatdouneed">
        What Do You Need Help With?
        </div>
        <div id="formnbuttonwtdouwant">
        <div id="formhelpcenter">
                <form name="whatuneed" action="">
                    <input type="text" value="" id="whatyouneed" />
                 </form>
        </div>
        <div id="helpcenterfieldbtn">
        <input type="image" class="login" src="<?=base_url(); ?>css/shiptime/images/helpcenterfieldarrow.png">
        </div>
        </div>
        <div id="sometextunderfield">
            <p>Search above, or select from one of the below help topics.</p>
        </div>
        <div id="linedividerccright">
        </div>
        <div id="headingccrighttopic">
        Topics
        </div>
<?php
    /*
    echo '<pre>';
    print_r($topics);
    exit();   
    */
if(!empty($topics)){
for ($i=0; $i<count($topics); $i++){
?>                        
        <div id="imageandtextccright">
            <div id="imageccrightsmall">
            <!--<img src="<?=base_url(); ?>css/shiptime/images/smallericonslock.png" /> -->
            <img src="<?=base_url(); ?>media/help_center/icons/<?=$topics[$i]['image_name']?>" /> 
            </div>
            <div id="textsmallimageccright">
                <a href="<?=base_url().index_page()?>Help_Center_Home/index/<?=$topics[$i]['id']?>"><?=$topics[$i]['topic_title']?></a>
            </div>
        </div>
<?php }
} ?>                
    </div>
</div><!-- cc -->