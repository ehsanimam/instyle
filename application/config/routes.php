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

//$route['default_controller'] 	= "maintenance"; // ----> for site maintenance use

$route['default_controller'] 	= "index";
$route['404_override'] 			= '';

/* 
| --------------------------
| WOMENS APPAREL/JEWELRY | BROWSE BY CATEGORY/DESIGNER
| --------------------------
$route['apparel-1.html']				= 'products_orig/index';
$route['apparel-1/(:any)']				= 'products_orig/index';
$route['apparel-designer-1.html']		= 'products_orig/index';
$route['apparel-designer-1/(:any)']		= 'products_orig/index';

$route['jewelry-19.html']				= 'products_orig/index';
$route['jewelry-19/(:any)']				= 'products_orig/index';
$route['jewelry-designer-19.html']		= 'products_orig/index';	
$route['jewelry-designer-19/(:any)']	= 'products_orig/index';
*/

/* 
| ---------------------------
| FACETED SEARCH WOMENS APPAREL/JEWELRY
| ---------------------------
$route['apparel-facets-1/(:any)']					= 'faceted_search/search';
$route['jewelry-facets-19/(:any)']					= 'faceted_search/search';

$route['apparel-designer-facets-1/(:any)']			= 'faceted_search/search';
$route['jewelry-designer-facets-19/(:any)']			= 'faceted_search/search';

$route['new-arrival-designer-facets/(:any)']		= 'faceted_search/search';
$route['new-arrival-facets/(:any)']					= 'faceted_search/search';
$route['clearance-designer-facets/(:any)']			= 'faceted_search/search';
$route['clearance-facets/(:any)']					= 'faceted_search/search';
*/

/* 
| ---------------------------
| NEW ARRIVAL
| ---------------------------
$route['new-arrival.html']				= 'new_arrival/index';
$route['new-arrival/(:any)']			= 'new_arrival/index';
$route['new-arrival-designer.html']		= 'new_arrival/index';
$route['new-arrival-designer/(:any)']	= 'new_arrival/index';
*/

/* 
| ---------------------------
| CLEARANCE
| ---------------------------
$route['clearance.html']				= 'clearance/index';
$route['clearance/(:any)']				= 'clearance/index';
$route['clearance-designer.html']		= 'clearance/index';
$route['clearance-designer/(:any)']		= 'clearance/index';
*/

/* 
| ---------------------------
| ROUTE PAGES
| ---------------------------
$route['page/:any']						= 'page/index';
*/

/*
| ---------------------------
| Commenting these pages to avoid confusion
| for new url structure
$route['contact.html']					= 'contact';
$route['register.html']					= 'register';
$route['press.html']					= 'press';
$route['signin.html']					= 'signin';
$route['reset-password.html']			= 'register/reset_password';
$route['sitemap.html']					= 'sitemap';	// added by rey
$route['sign_out.html']					= 'sign_out';	// added by rey
*/

/*
$route['wholesale/signin']					= 'wholesale/signin';
$route['wholesale/register']				= 'wholesale/register';
$route['wholesale/register_complete']		= 'wholesale/register_complete';
$route['wholesale/reset_password']			= 'wholesale/reset_password';
*/

$route['newsletter/(:any)']				= 'index/newsletter/$1';

$route['products/search_product']		= 'products/search_product';

/* 
| ---------------------------
| Under new url structure
| ---------------------------
*/
$route['login']					= 'login';
$route['logout']				= 'logout';
$route['login/(:any)']			= 'login/$1';
$route['cart']					= 'cart';
$route['cart/(:any)']			= 'cart/$1';
//$route['register']				= 'register';
$route['register/(:any)']		= 'register/$1';
$route['sign_out']				= 'sign_out';
$route['qty/:any']				= 'qty';
$route['search_products']		= 'search_products';
$route['facet_search']			= 'facet_search';
$route['facet_search/(:any)']	= 'facet_search/$1';
$route['wholesale']				= 'wholesale';
$route['wholesale/(:any)']		= 'wholesale/$1';

// sales admin tools
$route['sa']					= 'sa';
$route['sa/update_cart']		= 'sa/update_cart';
$route['sa/check_cart']			= 'sa/check_cart';
$route['sa/update_summary']		= 'sa/update_summary';
$route['sa/search_products']	= 'sa/search_products';
$route['sa/clear_items']		= 'sa/clear_items';
$route['sa/remembering']		= 'sa/remembering';
$route['sa/log_out']			= 'sa/log_out';
$route['sa/(:any)']				= 'sa';

// admin panel
$route['admin_ci']					= 'admin_ci';
$route['admin_ci/(:any)']			= 'admin_ci/$1';

/* This takes care of all the other links apart from above and some of the old routes */
$route[':any']				= 'main';


/* End of file routes.php */
/* Location: ./application/config/routes.php */