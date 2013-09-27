<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//$route['default_controller'] = "Contact_Management"; 

//$route['404_override'] = '';
//echo $_SERVER["HTTP_HOST"];

   DebugBreak();

$route['menusController/index'] = 'menusController/index/0';
$route['pagesController/index'] = 'pagesController/index/0'; 
$route['pagesController/searchPage'] = 'pagesController/searchPage/0';  
$route['administrator'] = 'administrator/login'; 
 
//if($_SERVER["HTTP_HOST"]=='23.23.227.152')
if($_SERVER["HTTP_HOST"]=='webpowerup.com')
{
	$data = explode(".",$_SERVER["REQUEST_URI"]);
	//echo "<pre>"; print_r($data);
	$domain = $data[0];
}
else
{ 
	$data = explode(".",$_SERVER["HTTP_HOST"]);
	if($data[0]=='www')
	{
		$domain = $data[1];
		if(isset($data[2]) && $data[2] =='net' && $domain == 'webpowerup')
		{
			$domain = $data[1].'.'.$data[2];
		}
		else
		{
			$domain = $data[1];
		}
	}
	else
	{
		
		$domain = $data[0];
	}
}

//echo "<pre>"; print_r($_SERVER);exit;
$host 		= "localhost"; //database location
$user 		= "root"; //database username
$pass 		=  'root'; //database password
$db_name 	= 'webpowerup'; //database name
//database connection
$link 		= mysql_connect($host, $user, $pass);
			  mysql_select_db($db_name);
$result 	= mysql_query("SELECT site_id, expire_status FROM sites where site_url = '".$domain."' OR site_domain = '".$domain."'");
$site_id 	= mysql_fetch_array($result); //print_r($site_id);  //OUTPUT OF THIS ARRAY :  Array ( [0] => 113 [site_id] => 113 )
$_SESSION['site_id'] = $site_id['site_id'];
//echo $_SERVER["HTTP_HOST"];
//print_r($site_id);


/************** Dynamic Rout code start  ************************************/
error_reporting(E_ALL);
//Defining All

$data['controller'] 	= '';
$data['page_name'] 		= '';
$siteid					= '';

//Assigning All
//echo $_SERVER["REQUEST_URI"] = /webpowerup/pages/company.html;
$url = $_SERVER["REQUEST_URI"];
$sx		= explode('/',$url);

//print_r($segments);

$data['controller'] 	= $sx[2];
if(!empty($sx[2])){
$data['page_name'] 		= str_replace('.html', '', $sx[3]);


if($data['controller'] == 'pages')
	{
		//echo "SELECT * FROM pages WHERE page_seo_url = '".$data['page_name']."' AND site_id =464";
		$page_data	= mysql_query("SELECT * FROM pages WHERE page_seo_url = '".$data['page_name']."' AND site_id =464");
		$page_array = mysql_fetch_array($page_data);	
		$route['pages/'.$sx[3]] = "site_preview/page/467/".$page_array['page_id'];
		 //$route['pages/about-us.html'] = "site_preview/page/464/3914";
	}
}
/************** Dynamic Rout code end  ************************************/

/************** futuregws code start  ************************************/

//echo $_SERVER["HTTP_HOST"]."<br>";exit; 
if($_SERVER["HTTP_HOST"] == "www.globalows.com")
{
	$route['default_controller'] = "site_preview/site/".$site_id['site_id'];
}
else if($_SERVER["HTTP_HOST"] == "www.futuresgymnastics.net")
{
	$route['default_controller'] = "site_preview/site/".$site_id['site_id'];
}
else if($_SERVER["HTTP_HOST"] == "futuresgymnastics.net")
{
	$route['default_controller'] = "site_preview/site/".$site_id['site_id'];
}
else if($_SERVER["HTTP_HOST"] == "futuresgymnastics.com")
{
	$route['default_controller'] = "site_preview/site/".$site_id['site_id'];	
}
else if($_SERVER["HTTP_HOST"] == "www.futuresgymnastics.com")
{
	$route['default_controller'] = "site_preview/site/".$site_id['site_id'];
}
else if($_SERVER["HTTP_HOST"] == "webpowerup.net" || $_SERVER["HTTP_HOST"] == "www.webpowerup.net" || $_SERVER["HTTP_HOST"] == "http://webpowerup.net")
{
	$route['default_controller'] = "site_preview/site/".$site_id['site_id'];
}
else if(isset($site_id['site_id']) && $site_id['site_id']!='')
{
	$route['default_controller'] = "site_preview/site/".$site_id['site_id'];
	//$route['default_controller'] = "welcome";
}
else
{
	$route['default_controller'] = "welcome";
	//$route['default_controller'] = "site_preview/site/".$site_id['site_id'];
}


//echo "<pre>";
//print_r($_SERVER);
//echo base_url();
//echo url_suffix();exit;
if(!empty($_SERVER["QUERY_STRING"]) && $_SERVER["QUERY_STRING"]!='/~jksports')
{
	$check_pieces = explode(".html",$_SERVER["QUERY_STRING"]);
	if(count($check_pieces) > 1)
	{
		echo "i m in";exit;
		$route['(:any)'] = 'site_preview/seo_urls/$1';  	
	}
}
//$route['site_preview/usman'] = "site_preview/page/113/930";
//echo $_SERVER["HTTP_HOST"];
//http://www.domain.com/product/32-in-sony-tv
//$route['product/(:any)/(:any)'] = "site_preview/page/$1/$2";

//$route['usman'] = "site_preview/page/113/930";

$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */