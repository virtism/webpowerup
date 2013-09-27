<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Active template
|--------------------------------------------------------------------------
|
| The $template['active_template'] setting lets you choose which template 
| group to make active.  By default there is only one group (the 
| "default" group).
|
*/
$template['active_template'] = 'default';

/*
|--------------------------------------------------------------------------
| Explaination of template group variables
|--------------------------------------------------------------------------
|
| ['template'] The filename of your master template file in the Views folder.
|   Typically this file will contain a full XHTML skeleton that outputs your
|   full template or region per region. Include the file extension if other
|   than ".php"
| ['regions'] Places within the template where your content may land. 
|   You may also include default markup, wrappers and attributes here 
|   (though not recommended). Region keys must be translatable into variables 
|   (no spaces or dashes, etc)
| ['parser'] The parser class/library to use for the parse_view() method
|   NOTE: See http://codeigniter.com/forums/viewthread/60050/P0/ for a good
|   Smarty Parser that works perfectly with Template
| ['parse_template'] FALSE (default) to treat master template as a View. TRUE
|   to user parser (see above) on the master template
|
| Region information can be extended by setting the following variables:
| ['content'] Must be an array! Use to set default region content
| ['name'] A string to identify the region beyond what it is defined by its key.
| ['wrapper'] An HTML element to wrap the region contents in. (We 
|   recommend doing this in your template file.)
| ['attributes'] Multidimensional array defining HTML attributes of the 
|   wrapper. (We recommend doing this in your template file.)
|
| Example:
| $template['default']['regions'] = array(
|    'header' => array(
|       'content' => array('<h1>Welcome</h1>','<p>Hello World</p>'),
|       'name' => 'Page Header',
|       'wrapper' => '<div>',
|       'attributes' => array('id' => 'header', 'class' => 'clearfix')
|    )
| );
|
*/

/*
|--------------------------------------------------------------------------
| Default Template Configuration (adjust this or create your own)
|--------------------------------------------------------------------------
*/

$template['default']['template'] = 'template';
$template['default']['regions'] = array(
   'header',
   'content',
   'footer'
); 
$template['default']['parser'] = 'parser';
$template['default']['parser_method'] = 'parse';
$template['default']['parse_template'] = FALSE;

//------ BlueGray template   -------//
$template['bluegray']['template'] = '../templates/bluegray/template';
$template['bluegray']['regions'] = array(
   'header',
   'leftbar',
   'content',
   'rightbar',
   'footer'
); 
$template['bluegray']['parser'] = 'parser';
$template['bluegray']['parser_method'] = 'parse';
$template['bluegray']['parse_template'] = FALSE;

//------  hobbit template    -------//
$template['hobbit']['template'] = '../templates/hobbit/template';
$template['hobbit']['regions'] = array(
   'header',
   'content',
   'footer'
); 
$template['hobbit']['parser'] = 'parser';
$template['hobbit']['parser_method'] = 'parse';
$template['hobbit']['parse_template'] = FALSE;

//------ logistix template  -------//
$template['logistix']['template'] = '../templates/logistix/template';
$template['logistix']['regions'] = array(
   'header',
   'content',
   'footer'
); 
$template['logistix']['parser'] = 'parser';
$template['logistix']['parser_method'] = 'parse';
$template['logistix']['parse_template'] = FALSE;

//------ winglobal template  -------//
$template['winglobal']['template'] = '../templates/winglobal/template';
$template['winglobal']['regions'] = array(
   'title',
   'description',
   'keywords',
   'menu',
   'header',
   'logo',
   'content',
   'sidebar',
   'footer',
   'footer2',
   'toolbox'
); 
$template['winglobal']['parser'] = 'parser';
$template['winglobal']['parser_method'] = 'parse';
$template['winglobal']['parse_template'] = FALSE;

 //------ my template  -------//
$template['mytemplate']['template'] = '../templates/mytemplate/mytemplate';
$template['mytemplate']['regions'] = array(
   'title',
   'menu',
   'logo',
   'content',
   'sidebar',
   'footer',
   'footer2'
); 
$template['winglobal']['parser'] = 'parser';
$template['winglobal']['parser_method'] = 'parse';
$template['winglobal']['parse_template'] = FALSE;
   
//------ Vantage template  -------//
$template['vantage']['template'] = '../templates/vantage/template';
$template['vantage']['regions'] = array(
   'title',
   'description',
   'keywords',
   'menu',
   'other_top_navigation',
   'logo',
   'content',
   'header',
   'leftbar',
   'rightbar',
   'footer',
   'toolbox',
   'top_slider'
); 
$template['vantage']['parser'] = 'parser';
$template['vantage']['parser_method'] = 'parse';
$template['vantage']['parse_template'] = FALSE;
 
//------ GWS template  -------//
$template['gws']['template'] = '../templates/gws/template';
$template['gws']['regions'] = array(
   'title',
   'description',
   'keywords',
   'menu',
   'logo',
   'content',
   'sidebar',
   'footer',
   'footer2'
); 
$template['gws']['parser'] = 'parser';
$template['gws']['parser_method'] = 'parse';
$template['gws']['parse_template'] = FALSE;

//------ GWS_Admin template  -------//
$template['gws_admin']['template'] = '../templates/gws_admin/template';
$template['gws_admin']['regions'] = array(
   'title',
   'description',
   'header',
   'keywords',
   'logo',
   'sidebar',
   'content'
); 
$template['gws_admin']['parser'] = 'parser';
$template['gws_admin']['parser_method'] = 'parse';
$template['gws_admin']['parse_template'] = FALSE;


//------ Ship Time template  -------//
$template['shiptime']['template'] = '../templates/shiptime/template';
$template['shiptime']['regions'] = array(
         'title',
         'description',
         'keywords',
         'favicon',
         'menu',
         'logo',
         'header',
         'sidebar',  
         'content',
         'footer'
); 
$template['shiptime']['parser'] = 'parser';
$template['shiptime']['parser_method'] = 'parse';
$template['shiptime']['parse_template'] = FALSE;

//------ Gymnastic template  -------//
$template['gymnastic']['template'] = '../templates/gymnastic/template';
$template['gymnastic']['regions'] = array(
         'title',
         'description',
         'keywords',
         'favicon',
         'menu',
         'logo',
         'header',
         'top_slider',
         'sidebar',  
         'content',
         'footer'
); 
$template['gymnastic']['parser'] = 'parser';
$template['gymnastic']['parser_method'] = 'parse';
$template['gymnastic']['parse_template'] = FALSE;

//---------Mash-Up Template---------------------//
$template['mashup']['template'] = '../templates/mashup/template';
$template['mashup']['regions'] = array(
		 'title',
		 'description',
		 'keywords',
		 'header',
		 'logo',
		 'menu',
		 'top_slider',
		 'slider',
		 //'sidebar',  
		 'content',
		 'footer',
		 'leftbar'
); 
$template['mashup']['parser'] = 'parser';
$template['mashup']['parser_method'] = 'parse';
$template['mashup']['parse_template'] = FALSE;

//---------Community Template---------------------//
$template['comunity']['template'] = '../templates/comunity/template';
$template['comunity']['regions'] = array(
		 'title',
		 'description',
		 'keywords',
		 'header',
		 'logo',
		 'menu',
		 'top_slider',
		 'slider',
		 'sidebar',  
		 'content',
		 'footer',
		 'leftbar'
		
); 
$template['comunity']['parser'] = 'parser';
$template['comunity']['parser_method'] = 'parse';
$template['comunity']['parse_template'] = FALSE;

//---------Florist Template---------------------//
$template['florist']['template'] = '../templates/florist/template';
$template['florist']['regions'] = array(
		 'title',
		 'description',
		 'keywords',
		 'header',
		 'logo',
		 'menu',
		 'top_slider',
		 'slider',
		 //'sidebar',  
		 'content',
		 'footer',
		 'leftbar'
); 
$template['florist']['parser'] = 'parser';
$template['florist']['parser_method'] = 'parse';
$template['florist']['parse_template'] = FALSE;
//---------Castleton Template---------------------//
$template['castleton']['template'] = '../templates/castleton/template';
$template['castleton']['regions'] = array(
		 'title',
		 'description',
		 'keywords',
		 'header',
		 'logo',
		 'menu',
		 'top_slider',
		 'slider',
		 'sidebar',  
		 'content',
		 'footer',
		 'leftbar'
); 
$template['castleton']['parser'] = 'parser';
$template['castleton']['parser_method'] = 'parse';
$template['castleton']['parse_template'] = FALSE;
//---------Car_Club Template---------------------//
$template['carclub']['template'] = '../templates/carclub/template';
$template['carclub']['regions'] = array(
		 'title',
		 'description',
		 'keywords',
		 'header',
		 'logo',
		 'menu',
		 'top_slider',
		 'slider',
		 'sidebar',  
		 'content',
		 'footer',
		 'leftbar'
); 
$template['carclub']['parser'] = 'parser';
$template['carclub']['parser_method'] = 'parse';
$template['carclub']['parse_template'] = FALSE;

//---------Blue Master Template---------------------//
$template['bluemaster']['template'] = '../templates/bluemaster/template';
$template['bluemaster']['regions'] = array(
         'title',
         'description',
         'keywords',
         'header',
         'logo',
         'menu',
         'top_slider',
         'slider',
         'sidebar',
		 'rightbar',  
         'content',
         'footer',
         'leftbar'
); 
$template['bluemaster']['parser'] = 'parser';
$template['bluemaster']['parser_method'] = 'parse';
$template['bluemaster']['parse_template'] = FALSE;

//---------Hosting Template---------------------//

$template['hosting']['template'] = '../templates/hosting/template';
$template['hosting']['regions'] = array(
		 'title',
		 'description',
		 'keywords',
		 'header',
		 'logo',
		 'menu',
		 'top_slider',
		 'slider',
		 'sidebar',
		 'rightbar',  
		 'content',
		 'footer',
		 'leftbar'
); 
$template['hosting']['parser'] = 'parser';
$template['hosting']['parser_method'] = 'parse';
$template['hosting']['parse_template'] = FALSE;


/* End of file template.php */
/* Location: ./system/application/config/template.php */