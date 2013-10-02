
<? function getDirectorySize2($path)
{
  $totalsize = 0;
  $totalcount = 0;
  $dircount = 0;
  if ($handle = @ opendir($path))
  {
	 
    while (false !== ($file = readdir($handle)))
    {
      $nextpath = $path . '/' . $file;
      if ($file != '.' && $file != '..' && !is_link ($nextpath))
      {
        if (is_dir ($nextpath))
        {
          $dircount++;
          $result = getDirectorySize2($nextpath);
          $totalsize += $result['size'];
          $totalcount += $result['count'];
          $dircount += $result['dircount'];
        }
        elseif (is_file ($nextpath))
        {
          $totalsize += filesize ($nextpath);
          $totalcount++;
        }
      }
    }
  }
  @ closedir($handle);
  $total['size'] = $totalsize;
  $total['count'] = $totalcount;
  $total['dircount'] = $dircount;
  return $total;
}

function sizeFormat2($size)
{
    if($size<1024)
    {
        return $size." bytes";
    }
    else if($size<(1024*1024))
    {
        $size=round($size/1024,1);
        return $size." KB";
    }
    else if($size<(1024*1024*1024))
    {
        $size=round($size/(1024*1024),1);
        return $size." MB";
    }
    else
    {
        $size=round($size/(1024*1024*1024),1);
        return $size." GB";
    }

} 
         if(isset($_SESSION['user_info']['user_id']))
		  {
			  $user_id = $_SESSION['user_info']['user_id'];
		  }
		  else
		  {
			  $user_id = "";
		  }
		  if(isset($_SESSION['user_info']['user_login']))
		  {
			  $user_login = $_SESSION['user_info']['user_login'];
		  }
		  else
		  {
			  $user_login = "";
		  }

$path= realpath('.')."/media/ckeditor_uploads/".$user_login."_".$user_id;
$ar=getDirectorySize2($path);
//echo sizeFormat2($ar['size']);
//exit();
$left = (5*1024*1024*1024) - $ar['size'];

?>

<style>

</style>
<div class="RightTopContents">
    <div class="BreadCrum">
        <a href="#"><img src="<?=base_url();?>images/webpowerup/BreadCrumIcon.png" alt="Breadcrum"/><span> <?php echo($this->breadcrumb->output()); ?></span></a>
        <span>/</span>
        <a href="#" class="CurrentNode">Dashoard</a>
        <?php //  echo($this->breadcrumb->output()); ?>
    </div>
    
    <div class="mainSearch">
        <form>
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
    <p>Disk Space <span id="val"><?=round($left/(5*1024*1024*1024)*100);?></span><strong>%</strong> left</p>
    
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