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

$route['default_controller'] 	= "index";
$route['404_override'] 			= '';

/* 
| --------------------------
| BROWSE BY CATEGORY
| --------------------------
*/
$route['apparel-c1.html']				= 'products/index';
$route['apparel-c1.html/(:any)']		= 'products/index';

$route['jewelry-c19.html']				= 'products/index';
$route['jewelry-c19.html/(:any)']		= 'products/index';

$route['clearance-c23.html']			= 'products/index';
$route['clearance-c23.html/(:any)']		= 'products/index';

$route['bridal-c22.html']				= 'products/index';
$route['bridal-c22.html/(:any)']		= 'products/index';

$route['apparel-c1']					= 'products/index';
$route['apparel-c1/(:any)']				= 'products/index';

$route['jewelry-c19']					= 'products/index';
$route['jewelry-c19/(:any)']			= 'products/index';

$route['clearance-c23']					= 'products/index';
$route['clearance-c23/(:any)']			= 'products/index';

$route['bridal-c22']					= 'products/index';
$route['bridal-c22/(:any)']				= 'products/index';


/* 
| ---------------------------
| BROWSE BY DESIGNERS
| ---------------------------
*/
$route['apparel-d1.html']				= 'products/designer';
$route['apparel-d1.html/(:any)']		= 'products/designer';

$route['jewelry-d19.html']				= 'products/designer';
$route['jewelry-d19.html/(:any)']		= 'products/designer';

$route['clearance-d23.html']			= 'products/designer';
$route['clearance-d23.html/(:any)']		= 'products/designer';

$route['bridal-d22.html']				= 'products/designer';
$route['bridal-d22.html/(:any)']		= 'products/designer';

$route['apparel-d1']					= 'products/designer';
$route['apparel-d1/(:any)']				= 'products/designer';

$route['jewelry-d19']					= 'products/designer';
$route['jewelry-d19/(:any)']			= 'products/designer';

$route['clearance-d23']					= 'products/designer';
$route['clearance-d23/(:any)']			= 'products/designer';

$route['bridal-d22']					= 'products/designer';
$route['bridal-d22/(:any)']				= 'products/designer';

/* 
| ---------------------------
| ROUTE PAGES
| ---------------------------
*/
$route['p(:any)']						= 'index/page/$i';
$route['contact.html']					= 'contact';
$route['register.html']					= 'register';
$route['press.html']					= 'press';
$route['signin.html']					= 'signin';
$route['reset-password.html']			= 'register/reset_password';


/* End of file routes.php */
/* Location: ./application/config/routes.php */