<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title?></title>

<link href="<?=base_url();?>css/webpowerup/style.css" rel="stylesheet" type="text/css" media="all" />



<style>
#slider, #slider2 {width:130px; }
</style>
<script src="<?=base_url();?>js/jquery.js"></script>
<script src="<?=base_url();?>js/date_time.js"></script>
<!--[if lte IE 6]><script type="text/javascript" src="<?=base_url();?>js/pngfix/supersleight-min.js"></script><![endif]-->


<!--	fancybox  files	-->
<script type="text/javascript" src="<?=base_url()?>js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

</head>

<body>

<!--Header Started-->
<div id="Header">
    <div class="CenterAlign">
        <?=$header?>
    </div>
</div>
<!--Header Ends Here-->

<!--Main Body Started-->
<div id="MainBody">
    <div class="CenterAlign">
        <div class="HundredPercent">
        
            
            <?php
			if( $leftColumn != 0 )
			{ ?>
            <!--LeftColumn Started-->
            <div class="LeftColumn" id="left_column">
            
            	<!--User info Started-->
				<?=$UserInfo?>
                <!--User info ends here-->
                
                <!--User info Started -->
                <?=$SwitchMenu?>
                <!--SwitchMenu ends here-->
               
            </div>
            <!--LeftColumn ends here-->
            <?php 
			} ?>
            <!--RightColumn Started-->
            <div class="RightColumn" id="right_column" <?php if($leftColumn == 0 ) { ?> style="width:100% !important;" <?php } ?> >
            	<!--contentTop Started-->
				<?=$contentTop?>
                <!--contentTop ends here-->
                
                <!--content Started-->
                <?=$content?>
                <!--content ends here-->
                
            </div>
            <!--RightColumn ends here-->
        
        
        </div>
    </div>
</div>
<!--Main ends here-->

<!--Footer Started-->
<div id="Footer">
<div class="CenterAlign">
	<?=$footer?>
  </div>
</div>

<script src="<?=base_url();?>js/jquery.js"></script>
<script src="<?=base_url();?>js/niceforms.js"></script>
<script src="<?=base_url();?>js/ddaccordion.js"></script>
<script src="<?=base_url();?>js/equal.js"></script>
<script src="<?=base_url();?>js/dropmenu.js"></script> 
<script src="<?=base_url();?>js/ga.js"></script>
<script src="<?=base_url();?>js/jquery-ui.js"></script>
<script src="<?=base_url();?>js/flotr2.min.js"></script>
<script src="<?=base_url();?>js/graph.js"></script>
<script src="<?=base_url();?>js/toastmessage.js"></script>


<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["unselected", "selected"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<span class='statusicon' />", "<span class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})

var Obj = jQuery.noConflict();
Obj(document).ready(function() {
	
	

    if(Obj('.submenuheader').hasClass("unselected")) {
               Obj('.unselected').parent().removeClass('open');
    }
    else {
	
        Obj('.selected').parent().addClass('open');
    }
	
	Obj(".submenuheader").click(function(){
        if(Obj('.submenuheader').hasClass("unselected")) {
               Obj('.unselected').parent().removeClass('open');
    }
    else {
	
        Obj('.selected').parent().addClass('open');
    }
  });
  
	Obj("#slider").slider({
	  value:0,
	  min: 0,
	  max: 100,
	  slide: function(event, ui) {
		Obj("#val").text(ui.value);
	  }
	});
	
	Obj("#slider2").slider({
	  value:0,
	  min: 0,
	  max: 100,
	  slide: function(event, ui) {
		Obj("#val2").text(ui.value);
	  }
	});
	
	
  	Obj("#nav-one").dropmenu();
  
	Obj.toastmessage('showToast', {
		type     : 'success',
		text: 'Page loaded successfully',
		position : 'bottom-right',
		inEffectDuration: 	1500,
		stayTime: 			1000
	});

});


</script>

<script>

<!--	REMOVING THIS CODE FANCYBOX WILL WORK -->
<!--	SPACE AVALIBLE JQ DONT WORK			  -->

/*jQuery(document).ready(function(jQuery){
	$("#quick_task").thumbnailScroller({ 
		scrollerType:"hoverAccelerate", 
		scrollerOrientation:"horizontal", 
		scrollEasing:"easeOutCubic",  //http://jqueryui.com/demos/effect/easing.html
		scrollEasingAmount:800, 
		acceleration:4, 
		scrollSpeed:800, 
		noScrollCenterSpace:10, 
		autoScrolling:0, 
		autoScrollingSpeed:2000, 
		autoScrollingEasing:"easeInOutCubic",  //http://jqueryui.com/demos/effect/easing.html
		autoScrollingDelay:500 
	});
});*/
</script>


<!--Footer Ends Here-->



</body>
</html>