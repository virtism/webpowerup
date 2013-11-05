<?=doctype()?>
<html>
<head>
<title></title>
<link href="<?=base_url();?>css/menu_style.css" media="all" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript">
function append(type)
{
    var content = document.getElementById("content");
    var heading = document.getElementById("heading");
    var paragraph = document.getElementById("paragraph");
        
    if(type == "h" && heading.value!="")
    {
        content.innerHTML += '<div onclick="deleteThis(this)"><h1>'+heading.value+'</h1></div>';
        //content.innerHTML += '<div onclick="editThis(this, '+"'h'"+')"><h1>'+heading.value+'</h1></div>'; 
               
        heading.value = "";   
    }
    
    if(type == "p" && paragraph.value!="")
    {        
        
        content.innerHTML += '<div onclick="deleteThis(this)"><p>'+paragraph.value+'</p></div>';
        //content.innerHTML += '<div onclick="editThis(this, '+"'p'"+')"><p>'+paragraph.value+'</p></div>';  
         
        paragraph.value = "";    
    } 
    
    if(type == "br")
    {
        content.innerHTML += '<br />';    
    }
    if(type == "hr")
    {
        content.innerHTML += '<div onclick="deleteThis(this)"><hr /></div>';    
    }   
}
/*function editThis(element, type)
{
    //alert(element.firstChild); 
    var content = document.getElementById("content");
    var heading = document.getElementById("heading");
    var paragraph = document.getElementById("paragraph");
    
    if(type == 'h')
    {
        alert(element.firstChild.innerHTML);    
    }
    
    if(type == 'p')
    {
        alert(element.firstChild.innerHTML);        
    }
               
}*/
function deleteThis(element)
{
    var content = document.getElementById("content");
    answer = confirm("Are you sure?");
    
    if(answer)
    {        
        content.removeChild(element);
        element = null;        
    }   
    else
    {
        return;       
    }
}
</script>
</head>
<body>

<div id="menu">
    <ul>
        <li><a href="#">Elements</a>
            <ul>
                <li><a href="javascript:void(0)">Heading</a></li>
                    <input type="text" id="heading" name="heading" />
                    <a href="javascript:void(0)"  onclick="append('h')">Save</a>
                <li><a href="javascript:void(0)">Paragraph</a></li>
                    <textarea id="paragraph" name="paragraph" cols="20" rows="5"></textarea>
                    <a href="javascript:void(0)"  onclick="append('p')">Save</a>
                <!--<li><a href="javascript:void(0)" onclick="append('br')">Line Break</a></li>--> 
                <li><a href="javascript:void(0)" onclick="append('hr')">Horizontal Rule</a></li>  
            </ul>
        </li>
        <li><a href="#">Menus</a></li>     
        <li><a href="#">Designs</a></li>  
        <li><a href="#">Pages</a></li>  
        <li><a href="#">Settings</a></li>  
    </ul>
</div>

<div id="content">
&nbsp;
</div>
</body>
</html>