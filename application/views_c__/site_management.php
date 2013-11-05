<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Package Management</title>
<?
//echo md5(password);exit;//echo base_url();exit;
?>
<link rel="stylesheet" href="<?=base_url();?>/css/style.css">
<link rel="stylesheet" href="<?=base_url();?>/css/sidebuilder.css">
	<script type="text/javascript" src="<?=base_url();?>/js/jquery-ui-1.8.9.custom.min.js"></script>
	
	<script>
		
		$(document).ready(function() {
		$(".item").draggable({
			revert: true   
		});
/*        $("#cart_items").draggable({
			axis: "x"
		});  */
		var count = 1;
		$("#cart_items").droppable({
			accept: ".item",
			activeClass: "drop-active",
			hoverClass: "drop-hover",
			drop: function(event, ui) {
			
			var coordsp=[];
			var coordsc=[];  
				var item        =   ui.draggable.html();
				var itemid      =   ui.draggable.attr("id"); 
				var coordsp     =   $('#cart_toolbar').position();
				
				var coordTopp   =   coordsp.top ;
				var coordLeftp  =   coordsp.left;
				//alert(itemid);
					var coordsc     =   $('#'+itemid).position();	
				
				alert(coordsc);
				var coordTopc   =   coordsc.top ;
				var coordLeftc  =   coordsc.left;
				var coordLeft   =   coordLeftc-coordLeftp;
				//var coordLeft   =   0;
				var coordTop    =   coordTopc-coordTopp;
				var html        =  '<div  class="item icart" style="  position: relative; left:'
									+coordLeft+'px; top:'
									+coordTop+'px;">';
									html = html + '<div class="divrm">';
									html = html + '<a onclick="remove(this)" class="remove '+itemid+count+'">&times;</a>';
									html = html + '<div/><input type="text" name="data_'+count+'"></div>';
				$("#cart_items").append(html);
				count += 1; 
				alert(count);
			   /* if (total_items > 4) {
					$("#cart_items").animate({width: "+=120"}, 'slow');
				}     */
			}
		});
	   /* $("#btn_next").click(function() {
			$("#cart_items").animate({left: "-=100"}, 100);
			return false;
		});
		$("#btn_prev").click(function() {
			$("#cart_items").animate({left: "+=100"}, 100);
			return false;
		});       */
	   /* $("#btn_clear").click(function() {
			$("#cart_items").fadeOut("2000", function() {
			   $(this).html("").fadeIn("fast").css({left: 0});
			});
			$("#citem").html("0");
			$("#cprice").html("$ 0");
			total_items = 0;
			total_price = 0;
			return false;
		});          */
	});
	function remove(el) {
		$(el).hide();
		$(el).parent().parent().effect("highlight", {color: "#ff0000"}, 1000);
		$(el).parent().parent().fadeOut('1000');
		setTimeout(function() {
			$(el).parent().parent().remove();
			// collapse cart items
			/*if (total_items > 3) {
				$("#cart_items").animate({width: "-=120"}, 'slow');
			}  */
		}, 1100);
		// update total item
	   /* total_items--;
		$("#citem").html(total_items);

		// update totl price
		var price = parseInt($(el).parent().parent().find(".price").html().replace("$ ", ""));
		total_price = total_price - price;
		$("#cprice").html("$ " + total_price); */
	}
	</script>
</head>

<body>
<? 
//echo "<pre>";
//print_r($modules);
//print_r($moduleArray);



//exit;
?>
<h1>Site Management</h1>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	
	<tr>
		<td colspan="2">
			Website Name : <b><?=$siteInfo[0]["site_name"]?> </b>
		</td>
		
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<!--<td colspan="2"><a href="<?=base_url()?>index.php/PageController/creatpage/<?=$siteInfo[0]["site_id"]?>">Creat Pages</a> </td>-->
		<td colspan="2"><a href="<?=base_url()?>index.php/pagesController/basic_info/<?=$siteInfo[0]["site_id"]?>">Create Pages</a>
        <br /><br />
        <input type="button" value="Back" onclick="javascript: history.go(-1);" />
        </td> 
	</tr>
	
	
	

</table>


<!--<div id="item_container">
		  <div class="item" id="i1">
			  <img src="img/static-text.png"/>
			  <label class="title">Text & Images</label>
			  <label class="price"></label>
		  </div>
		  <div class="clear"></div>
	  </div>
	   <div id="cart_container">
		  <div id="cart_title">
			  <span>Container area</span>
			  <div class="clear"></div>
		  </div>
		  <div id="cart_toolbar">
			  <div id="cart_items" class="back"></div>
		  </div>
		   <div class="clear"></div>
		  </div>
	  </div>
</div>                -->
</body>
</html>