<div class="RightTopContents">
    <div class="BreadCrum">
        <a href="#"><img src="<?=base_url();?>images/webpowerup/BreadCrumIcon.png" alt="Breadcrum"/><span> <?php echo($this->breadcrumb->output()); ?></span></a>
        <span>/</span>
        <a href="#" class="CurrentNode">Dashoard</a>
        <?php //  echo($this->breadcrumb->output()); ?>
    </div>
    
    <div class="mainSearch">
        <form >
            <input class="none" name="mainSearch" type="text" id="mainSearch" onfocus="if(this.value=='type keyword'){this.value=''}" onblur="if(this.value==''){this.value='type keyword'}" value="type keyword" />
            <input class="none" name="bSearch" type="submit" value="Search" />
      </form>
    </div>

</div>
        
<div class="RightColumnTop">

    <div class="GreenSearch">
    <input type="text" class="none"  name="greensearch" value="" />
    <a href="#">
    <img src="<?=base_url();?>images/webpowerup/GreenSearchButton.png" alt="search Button"/>
    </a>
    </div>
    
    <div class="DiskSpace">
    <div class="r_slider_holder">
    <div class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" id="slider">
        <a style="left: 0%;" class="ui-slider-handle ui-state-default ui-corner-all" href="#"></a>
    </div>
    </div>
    <p>Disk Space <span id="val">0</span><strong>%</strong> left</p>
    
    </div>
    
    <div class="AverageBandwidth">
    <div class="r_slider_holder">
    <div class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" id="slider2">
        <a style="left: 0%;" class="ui-slider-handle ui-state-default ui-corner-all" href="#"></a>
    </div>
    </div>
    <p><span>Average</span> Bandwidth <span id="val2">0</span><span>%</span></p>
    </div>

</div>