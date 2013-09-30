<script type="text/javascript">

	function sizeBox(id){
	//alert(document.getElementById('thebox').rows);
	//alert(document.getElementById('thebox').value.length / 16);
		if((document.getElementById(id).value.length % 86) == 0)
		{
			//alert("in");
			document.getElementById(id).rows +=1;
		}
		
	}
	
	function save_to_db(element_id)
	{
		//alert(element_id.style);
		var element = document.getElementById(element_id);
		//alert(element.style.borderStyle);
		element.style.borderStyle = 'none';
		var data = $('#'+element_id).val();
	  //  var page_id = $('#page_id').val();
		//alert(data);
		
		var coordsp     =   $('#'+element_id).position();
		
		var coordTopp   =   coordsp.top ;
		var coordLeftp  =   coordsp.left;
				
			//    alert(coordTopp);
				//alert(coordLeftp);
				
				
		var dataString = 'element_id=' + element_id +'&data=' + data + '&pos_top=' + coordTopp + '&pos_left=' + coordLeftp +'&page_id=<?=$page_id?>' ;
		//alert(dataString);
		var path='<?=base_url()?>'+'index.php/pagesController/ajax_content_add/';
		$.ajax({
				type: "POST",
				url: path,
				//data: '',
				data: dataString,
		success: function(data) {
			
				//alert(data)
				//$('#response_test', data).each( function () {
				//status = $(this).text();
		//});
		// alert(status)
			if(status==1){
			//    document.getElementById('registartion_frm').action = path+"#signIn";
			}
		},
		error:function(){
			alert("somecvcnvnc error");
			}
		});
	}
   
   ///--------------------------------------------------------------------------///
   
	 // for image save 
   function save_to_db_img(element_id)
	{
		//alert('i am here ...');
		var data = $('#'+element_id).val();
		var src = $('#'+element_id).attr('src');

		//alert(src+'this is the source ');
	   // exit();
		
		var coordsp     =   $('#'+element_id).position();
		
		var coordTopp   =   coordsp.top ;
		var coordLeftp  =   coordsp.left;
				
			//    alert(coordTopp);
				//alert(coordLeftp);
				
				
		var dataString = 'element_id=' + element_id +'&src=' + src + '&pos_top=' + coordTopp + '&pos_left=' + coordLeftp +'&page_id=<?=$page_id?>' ;
		//alert(dataString);
		var path='<?=base_url()?>'+'index.php/pagesController/ajax_content_image_save/';
		$.ajax({
				type: "POST",
				url: path,
				//data: '',
				data: dataString,
		success: function(data) {
			
				//alert(data)
				//$('#response_test', data).each( function () {
				//status = $(this).text();
		//});
		// alert(status)
			if(status==1){
			//    document.getElementById('registartion_frm').action = path+"#signIn";
			}
		},
		error:function(){
			alert("Image saving Error ");
			}
		});
	} 
	
	
	function show_hide_control(show_id,hide_id)
	{
		//alert(show_id);
		//alert(hide_id);
		$('#'+show_id).show(); 
		$('#'+hide_id).hide();
		//alert(show_id);
		//var ParentDiv = document.getElementById(show_id).childNodes;
		//var ChildDivs = ParentDiv[0].childNodes;
		//alert(ChildDivs[2]);
		//editor = CKEDITOR.replace( ChildDivs[2], {resize_enabled : 'false', width: '725', height: '100'} );
		//alert(editor);
		
		var counter_id = hide_id.split("_");
		// alert(counter_id[1]);
		$('#textarea_'+counter_id[1]).focus();
			
	}
	
	function show_hide(show_id,hide_id)
	{
		//alert(show_id);
		//alert(hide_id);
		$('#'+show_id).show(); 
		$('#'+hide_id).hide();
		alert(show_id);
		var ParentDiv = document.getElementById(show_id).childNodes;
		var ChildDivs = ParentDiv[0].childNodes;
		//alert(ChildDivs[2]);
		//alert(ChildDivs[2].id);
	//	editor = CKEDITOR.replace( ChildDivs[2], {resize_enabled : 'false', width: '725', height: '100'} );
		//alert(editor);
		
		var counter_id = hide_id.split("_");
		// alert(counter_id[1]);
		$('#textarea_'+counter_id[1]).focus();
			
	}
	function apply_style(element,event)
	{
		 var style = "border:1px dashed black; background-color:#E9E9E9; "  ;
		 //alert(event);
	} 
	

	function box_load(id)
	{
		//alert(id);
		var count2 = id.split("_");
		//alert(count[1]);
		$("#popup_id").val('temp_image_'+count2[1]);                        
		
		$("#"+id).fancybox({
								'width'                : '70%',
								'height'            : '95%',
								'autoScale'            : false,
								'transitionIn'        : 'none',
								'transitionOut'        : 'none',  
								'type'                : 'ajax'
							});
		
	} 
	
	function right_menu_open(id)
	{
		alert("called");
		//alert(id);
		
	   $("#menu_box_2").fancybox({
			
								'width'                : '70%',
								'height'            : '95%',
								'autoScale'            : false,
								'transitionIn'        : 'none',
								'transitionOut'        : 'none',  
								'type'                : 'ajax'
							});
			
		
		
	}
	
	function right_menu_open2()
	{
		alert("called custom 2");
		//debugger;
		//alert(id);
		$("#custom_open").fancybox({
								'width'                : '70%',
								'height'            : '95%',
								'autoScale'            : false,
								'transitionIn'        : 'none',
								'transitionOut'        : 'none',  
								'type'                : 'ajax'
							});
		
	
		
		
	}
	
	
	
	//start code written by numaan  
	function getFocusedElement() {
	  return document.activeElement;
	};
	
	function load_ckeditor(element_id)
	{
		//alert(element_id);
		//alert(count);
		element = document.getElementById(element_id);
		//alert(element);
		
		editor = CKEDITOR.replace( element, { customConfig : '<?=base_url()?>/ckeditor/config.js' }  );
		

	}
	
	function custom_image(element_id)
	{
		//alert(element_id);
		var dialogObj;
		element = document.getElementById(element_id);
		var editor = CKEDITOR.replace( element, { customConfig : '<?=base_url()?>ckeditor/config.js' }  );
		 
		// CKEDITOR.instances.temp_image_1.execCommand('image');

		
		
	}
	
	
	function open_smiley()
	{
		for(var i in CKEDITOR.instances)
		{
			//alert(CKEDITOR.instances[i].id);
			 //var element = CKEDITOR.dom.element.getById(CKEDITOR.instances[i].id);
			 //element.hide();
			 
			 CKEDITOR.instances.temp_image_1.execCommand('image');

			//alert(CKEDITOR.instances[i].getData());
		}
	}
	
	
	function borderCheck(element)
	{
		object = getFocusedElement();
		if (!(object==element)) {
			///alert('element has focus');
			element.style.borderStyle = 'none';    
		}
	}
	
	$(document).ready(function() {
		 
		
							
		$(".item").draggable({
			revert: true   
		});
		
		$("#cart_items").droppable({
			accept: ".item",
			//activeClass: "drop-active",
			//hoverClass: "drop-hover",
			drop: function(event, ui) {
			
			var coordsp=[];
			var coordsc=[];  
				var item        =   ui.draggable.html();
				var itemid      =   ui.draggable.attr("id"); 
				//alert(itemid);
				var coordsp     =   $('#cart_toolbar').position();
				
				var coordTopp   =   coordsp.top ;
				var coordLeftp  =   coordsp.left;
				//alert(itemid);
				var coordsc     =   $('#'+itemid).position();    
				
				//alert(coordsc.top);
				//alert(coordsc.left);
				var coordTopc   =   coordsc.top ;
				var coordLeftc  =   coordsc.left;
				var coordLeft   =   coordLeftc-coordLeftp;
				//var coordLeft   =   0;
				var coordTop    =   coordTopc-coordTopp;
				
				//numControls++;
				var numControls = document.getElementById('numControls');
				controls_count += 1; 
				numControls.value = controls_count; 
				count += 1;
				
				var hrml_sort_pre =  '<div class="column" id="column1">';
				
				if(itemid == "para")
				{
					var html        =  '<div class="dragbox" id="item'+count+'"><img src="<?=base_url()?>/css/move_arrow.gif" alt="no-image" class="drag-image"><h2 id="'+count+'" value="para_1" onclick="do_collapse(this);" onmouseup="do_fill_data(this.id);" onmouseover="fetch_editor_data(this.id);" >&nbsp;</h2><div style="float:right;margin-top:-20px;margin-right:4px"><a  onclick="remove_item(\'item'+count+'\')" id="remove'+itemid+count+'" class="remove'+itemid+count+' x-button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></div><div class="dragbox-content" ><div id="item_cart_'+count+'"  style="  position: relative; left: 0px; top:-2px;width:100%">';
										html = html + '<textarea cols="86" class="editor_ta" rows="1" id="para_'+count+'" name="content[]" ></textarea><input type="hidden" name="control_type[]" value="para" /><input type="hidden" name="ckeditor_mode" id="ckeditor_mode_'+count+'" value="para_'+count+'" /><input type="hidden" name="image-para[]" value="" /></div></div></div>';
										
				}
				if(itemid == "image")
				{
					var html        =  '<div class="dragbox" id="item'+count+'"><img src="<?=base_url()?>/css/move_arrow.gif" alt="no-image" class="drag-image"><h2 id="'+count+'" value="para_1" onclick="do_collapse(this);" onmouseup="do_fill_data(this.id);" onmouseover="fetch_editor_data(this.id);" >&nbsp;</h2><div style="float:right;margin-top:-20px;margin-right:4px"><a  onclick="remove_item(\'item'+count+'\')" id="remove'+itemid+count+'" class="remove'+itemid+count+' x-button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></div><div class="dragbox-content" ><div id="item_cart_'+count+'"  style="  position: relative; left: 0px; top:-2px;width:100%;">';									
										html = html + '<a id="image_'+count+'" href="<?=base_url()?>index.php/media/index/'+count+'" ><span class="menu'+count+'" id="menu_id_'+count+'"><img src="<?=base_url()?>images/na.jpg" id="temp_image_'+count+'" name="para_'+count+'" onclick="box_load(\'image_'+count+'\')" title = " " alt = ""  /></span></a><input type="hidden" name="control_type[]" value="image" /><input type="hidden" id="input_temp_image_'+count+'" name="content[]" value="" /> <input type="hidden" name="image-para[]" value="" /><div class="contextMenu" id="myMenu'+count+'" style="display:none;"><ul><li id="properties"><a id="custom_open" href="<?=base_url()?>index.php/media/load_properties/'+count+'"> </a> <img src="<?=base_url()?>images/properties.png"/> Image Properties</li></ul></div></div></div></div>';
										
									
											
				}	
				if(itemid == "image_content")
				{
										
					var html        =  '<div class="dragbox" id="item'+count+'"><img src="<?=base_url()?>/css/move_arrow.gif" alt="no-image" class="drag-image"><h2 id="'+count+'" value="para_1" onclick="do_collapse(this);" onmouseup="do_fill_data(this.id);" onmouseover="fetch_editor_data(this.id);" >&nbsp;</h2><div style="float:right;margin-top:-20px;margin-right:4px"><a  onclick="remove_item(\'item'+count+'\')" id="remove'+itemid+count+'" class="remove'+itemid+count+' x-button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></div><div class="dragbox-content" ><div id="item_cart_'+count+'"  style="  position: relative; left: 0px; top:-2px;width:100%;">';
										html = html + '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td align="left"  valign="top"><a id="image_'+count+'" href="<?=base_url()?>index.php/media/index/'+count+'" ><span class="menu'+count+'" id="menu_id_'+count+'"><img src="<?=base_url()?>images/na.jpg" id="temp_image_'+count+'" name="para_'+count+'" onclick="box_load(\'image_'+count+'\')" title = " " alt = ""  /></span></a></td><td align="center" style="padding-right:10px"><textarea cols="86" class="editor_ta" rows="1" id="para_'+count+'" name="content[]" ></textarea><input type="hidden" name="control_type[]" value="image-para" /><input type="hidden" id="input_temp_image_'+count+'" name="image-para[]" value="" /></td></tr></table>';
										html = html + ' <div class="contextMenu" id="myMenu'+count+'" style="display:none;"><ul><li id="properties"><a id="custom_open" href="<?=base_url()?>index.php/media/load_properties/'+count+'"> </a> <img src="<?=base_url()?>images/properties.png"/> Image Properties</li></ul></div></div></div></div>';
											
				}
				if(itemid == "content_image")
				{
										
					var html        =  '<div class="dragbox" id="item'+count+'"><img src="<?=base_url()?>/css/move_arrow.gif" alt="no-image" class="drag-image"><h2 id="'+count+'" value="para_1" onclick="do_collapse(this);" onmouseup="do_fill_data(this.id);" onmouseover="fetch_editor_data(this.id);" >&nbsp;</h2><div style="float:right;margin-top:-20px;margin-right:4px"><a  onclick="remove_item(\'item'+count+'\')" id="remove'+itemid+count+'" class="remove'+itemid+count+' x-button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></div><div class="dragbox-content" ><div id="item_cart_'+count+'"  style="  position: relative; left: 0px; top:-2px;width:100%;">';
										html = html + '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td align="left"  valign="top" style="padding-right:10px"><textarea cols="86" class="editor_ta" rows="1" id="para_'+count+'" name="content[]" ></textarea><input type="hidden" name="control_type[]" value="para-image" /><input type="hidden" id="input_temp_image_'+count+'" name="image-para[]" value="" /></td><td align="center"><a id="image_'+count+'" href="<?=base_url()?>index.php/media/index/'+count+'" ><img src="<?=base_url()?>images/na.jpg" id="temp_image_'+count+'" name="para_'+count+'" onclick="box_load(\'image_'+count+'\')" title = " " alt = ""  /></a></td></tr></table>';
										html = html + ' </div></div></div>';
											
				}
				
				if(itemid == "test" )
				{
					var html        =  '<div id="item_cart_'+count+'"  style="  position: relative; left: 0px; top:-2px;width:80%;">';
										html = html + '<div><input type="hidden" id="input_para_'+count+'" name="content[]" value="" />';
										html = html + '<a onclick="remove_item('+"'"+'item_cart_'+count+"'"+');" id="remove'+itemid+count+'" class="remove '+itemid+count+'" name="image_'+count+'">&times;</a>';
										html = html + '<div/><a id="image_'+count+'" href="<?=base_url()?>index.php/media/index/'+count+'" ><img src="<?=base_url()?>images/na.jpg" id="para_'+count+'" name="para_'+count+'" onclick="box_load(\'image_'+count+'\')" title = " " alt = ""  /></a><input type="hidden" name="control_type[]" value="image" /> </div>';
				}
			
				//hidden Feilds for Image properties need to be available for all plugins
				html = html + '<input type="hidden" name="image_url[]" id="image_url'+count+'"><input type="hidden" name="image_alt[]" id="image_alt'+count+'"><input type="hidden" name="image_target[]" id="image_target'+count+'"><input type="hidden" name="image_width[]" id="image_width'+count+'">';
				html = html + '<input type="hidden" name="image_hspace[]" id="image_hspace'+count+'"><input type="hidden" name="image_vspace[]" id="image_vspace'+count+'"><input type="hidden" name="image_border[]" id="image_border'+count+'"><input type="hidden" name="image_height[]" id="image_height'+count+'"><input type="hidden" name="image_alignment[]" id="image_alignment'+count+'">';
				
			
				var hrml_sort_post =  '</div >';
				
				if(count==1)
				{
					html = hrml_sort_pre + html + hrml_sort_post; 
					$("#cart_items").append(html);
				}
				else
				{
					$("#column1").append(html);
				}
				apply_sortable();
				
		
				if(itemid == "para")
				{
					load_ckeditor('para_'+count);		
				}   
				if(itemid == "image_content")
				{
					load_ckeditor('para_'+count);		
				}     
				if(itemid == "content_image")
				{
					load_ckeditor('para_'+count);		
				}
				if(itemid == "image")
				{
					//apply_context_menu(count);
				}   
				  
				  do_collapse();
				 // test_function();   
			}
			
		});
	});

	
	
	
	function apply_context_menu(counter)
	{
		//alert(counter);
		
		$("#custom_open").fancybox({
								'width'                : '70%',
								'height'            : '95%',
								'autoScale'            : false,
								'transitionIn'        : 'none',
								'transitionOut'        : 'none',  
								'type'                : 'ajax'
							});
							
		$('span.menu'+counter).contextMenu('myMenu'+counter+'', {

			bindings: {

			  'properties': function(t) {
				// right_menu_open('menu_box_2');
			$('#img_property').val(counter);	
			  $("#custom_open").click();
			   //rig
			//	self_load();  
										  

			  },

			  'email': function(t) {

				alert('Trigger was '+t.id+'\nAction was Email');

			  },

			  'save': function(t) {

				alert('Trigger was '+t.id+'\nAction was Save');

			  },

			  'delete': function(t) {

				alert('Trigger was '+t.id+'\nAction was Delete');

			  }

			}

		  });
	}
	
	function remove_item(e1)
	{   
		controls_count--;  
		var numControls = document.getElementById('numControls');
		numControls.value = controls_count;
		//alert(numControls.value);
		
		//alert(controls_count);
		element = document.getElementById(e1);
		$(element).fadeOut('1000');
		return;  
	}
	/* backup on 19/09/2011 */
	/*
	function remove(el) {    
		numControls--;
		document.getElementById('numControls').value--; 
		$(el).hide();
		
		$(el).parent().parent().effect("highlight", {color: "#ffffff"}, 1000);
		$(el).parent().parent().fadeOut('1000');
		setTimeout(function() {
			
		$(el).parent().parent().remove();
			
		}, 1100);
	}
	*/
	
	function remove_from_db(name) {
 
		var dataString = 'element_id=' + name +'&page_id=<?=$page_id?>' ;
		//alert(dataString);
		var path='<?=base_url()?>'+'index.php/pagesController/ajax_content_delete/';
		$.ajax({
				type: "POST",
				url: path,
				//data: '',
				data: dataString,
		success: function(data) {
			
				//alert(data)
				//$('#response_test', data).each( function () {
				//status = $(this).text();
		//});
		// alert(status)
			if(status==1){
			//    document.getElementById('registartion_frm').action = path+"#signIn";
			}
		},
		error:function(){
			alert("somecvcnvnc error");
			}
		});
	}
	
	//*------------------------------------------ Content Dragining Dropping-------------
	function fetch_editor_data(element_id)
	{
//		alert("usman");
	//	alert(element_id);
		
		
		for(var i in CKEDITOR.instances)
		{
			//alert(CKEDITOR.instances[i].name);
			if(CKEDITOR.instances[i].name == "para_"+element_id)
			{
				//alert("sania mirza");
				//alert(CKEDITOR.instances[i].getData());
				$("#temp_editor_data").val(CKEDITOR.instances[i].getData());
				//alert($("#temp_editor_data").val());
				break;		
			}
			
			//alert(CKEDITOR.instances[i].getData());
		}	
		//alert("Saleem");
	}
	
	function do_fill_data(element_id)
	{
		//alert(element_id);
		//alert($("#temp_editor_data").val());
		for(var i in CKEDITOR.instances)
		{
			if(CKEDITOR.instances[i].name == "para_"+element_id)
			{
				CKEDITOR.instances[i].setData($("#temp_editor_data").val());	
				return true;
			}
			
		}	
	}
	
	function apply_sortable(){
		
			
	
	$('.column').sortable({
		
		
		connectWith: '.column',
		handle: 'h2',
		cursor: 'move',
		placeholder: 'placeholder',
		forcePlaceholderSize: true,
		opacity: 0.4,
		stop: function(event, ui){
			$(ui.item).find('h2').click();
			var sortorder='';
			$('.column').each(function(){
				var itemorder=$(this).sortable('toArray');
				var columnId=$(this).attr('id');
				sortorder+=columnId+'='+itemorder.toString()+'&';
			});
			//alert('SortOrder: '+sortorder);
			/*Pass sortorder variable to server using ajax to save state*/
		}
	})
//	.disableSelection();
	}
	
	function do_collapse(element)
	{  
		
		if(element)
		{
			//To keep editor data loaded in collapse function
			var full_element_id = 'para_'+element.id;
			do_fill_data(full_element_id);
			//alert('saleem');
			//end
			$(element).hover(function(){
				
			$(element).addClass('collapse');
		}, function(){
		//	$(this).find('h2').removeClass('collapse');
			$(element).removeClass('collapse');
		})
		$(element).siblings('.dragbox-content').toggle();	
		}
		
		if(element)
		{

			var myinstances = [];

			//this is the foreach loop
			for(var i in CKEDITOR.instances)
			{
				

				/* this  returns each instance as object try it with alert(CKEDITOR.instances[i]) */
				//CKEDITOR.instances[i];
				
				if('para_'+element.id == CKEDITOR.instances[i].name )
				{
					var inst = CKEDITOR.instances[i] ;
					
					//inst.reset(false);	
					CKEDITOR.instances[i].updateElement();
					//alert(CKEDITOR.instances[i].getData());
					if(CKEDITOR.instances[i].getData())
					{
						CKEDITOR.instances[i].setData(CKEDITOR.instances[i].getData());	
					}
					 //console.log(CKEDITOR.instances[i]._.events);
					 //CKEDITOR.instances[i].insertHtml( ' <p>teri</p>' );      
					 //alert($('#cke_contents_para_1').html());              
					// CKEDITOR.instances[i].insertHtml( '<p>This is a new paragraph.</p>' );
					 
					 //[CKEDITOR.instances[i].name] = ;
					break;
					
				}  
				
				//alert(CKEDITOR.instances[i].id);   
				/* this returns the names of the textareas/id of the instances. */
				//CKEDITOR.instances[i].name;

				/* returns the initial value of the textarea */
				//CKEDITOR.instances[i].value; 

				/* this updates the value of the textarea from the CK instances.. */
				//CKEDITOR.instances[i].updateElement();

				/* this retrieve the data of each instances and store it into an associative array with
				the names of the textareas as keys... */
				//myinstances[CKEDITOR.instances[i].name] = CKEDITOR.instances[i].getData();

			}

			
		  // var instance = CKEDITOR.instances[i].id;;
		  // instance.setMode('source');

		}
		
		
		
	/*$('.dragbox')
	.each(function(){
		$(this).hover(function(){
			$(this).find('h2').addClass('collapse');
		}, function(){
			$(this).find('h2').removeClass('collapse');
		})
		.find('h2').hover(function(){
			$(this).find('.configure').css('visibility', 'visible');
		}, function(){
			$(this).find('.configure').css('visibility', 'hidden');
		})                                           
		.click(function(){
			$(this).siblings('.dragbox-content').toggle();
		}) 
		.end()
		.find('.configure').css('visibility', 'hidden');   
	});	*/
	}
	
	function test_function(){
		$('#para_1').ckeditor();
		var editor = $('#para_1').ckeditorGet();

		// this gets a list of all events that you can listen for
		console.log(CKEDITOR.instances[i]._.events);

		// here's how you listen for an event
		editor.on("someEvent", function(e) {
		  console.log(e); 
});

		
	}

	
	
	
	
	//---------------------------------END------------------------------------------------
//------------------------------- Custom Functionality to Page Edit-----------------------

 function showEditor(id)
					{
						CKEDITOR.replace(id);
						//$("#para"+id)
						para = document.getElementById("div_para"+id);
						$(para).toggle();
						//save_button = document.getElementById("save"+id);
						edit_button = document.getElementById("edit"+id);
						//alert(edit_button);
						edit_button.style.visibility = "hidden";
						if(edit_button.style.visibility=="visible")
						{
							edit_button.style.visibility="hidden";
							edit_button.style.position="absolute";        
						} 
						
						return;
					}
					function deleteContent(content_area, id)
					{
						numControls = document.getElementById('numControls');
						numControls--;
						bool = confirm('Are you sure to delete this Content?');
						if(bool == true)
						{
							var contentarea = document.getElementById(content_area); 
							//alert(contentarea);return;
							$(contentarea).fadeOut('1000');
							setTimeout('."contentarea.innerHTML=null".', 1000);
							$.ajax({
							url: '<?=base_url()?>index.php/pagesController/deleteContentInfo/'+id,
							success: function(data)
									{
									}
							});    
						}
						else
						{
							return;
						}
					}


//	
	
</script>