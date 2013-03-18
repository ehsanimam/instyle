<?php  if ( ! defined('BASEPATH')) exit('ERROR 404: Page not found');

$config['dev1_email']		= 'rsbgm@innerconcept.com';
$config['dev2_email']		= 'rusty@innerconcept.com';
$config['currency']			= '$';
$config['currency_char']	= 'USD';

$config['items_per_page']	= 100;

// used for form spam bots security and others
$config['a_secret_1']		= $config['dev1_email'];
$config['a_secret_2']		= $config['dev2_email'];

$config['assets_url']		= 'assets';

/*
|--------------------------------------------------------------------------
| Template Views
|--------------------------------------------------------------------------
|
| Switch templates automatically depending on domain name
|
*/
switch ($_SERVER['SERVER_NAME'])
{
	// ---> set this manually for development purposes
	// put it before the domain you are editing
	case ("localhost"):
	case ("www.storybookknits.com"):
		$config['template']			= 'storybook';
		$config['site_name']		= 'Story Book Knits';
		$config['site_domain']		= 'www.storybookknits.com';
		$config['site_address1']	= '230 West 38th Street';
		$config['site_address2']	= 'New York, NY 10018';

		$config['site_title']		= 'Story Book Knits';
		$config['site_keywords']	= 'Cocktail Dresses, Party Dresses, Homecoming Dresses, Glitz Dresses, Beaded Dresses, Sequined Dresses, Costume Jewelry , Swimwear, Issue Dresses, Basix Dresses, Furs, and more at instylenewyork.com';
		$config['site_description']	= 'A vast collection of womens fashion ranging from Dresses , Evening Gowns, Special Occassion suits , costume jewelry and more.';
		$config['footer_text']		= '';

		$config['site_subject']		= 'Story Book Knits';
		$config['info_email']		= 'info@storybookknits.com';
		$config['store_email']		= 'order@storybookknits.com';
		$config['inquiry_email']	= 'info@storybookknits.com';
		
		$config['google_analtyics']	= "
			<script type=\"text/javascript\">

			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-36020496-1']);
			  _gaq.push(['_trackPageview']);

			  (function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();

			</script>
		";
		
		if ($_SERVER['SERVER_NAME'] === 'localhost') $config['PROD_IMG_URL'] = 'http://localhost/www/joetaveras/products/';
		else $config['PROD_IMG_URL'] = 'http://products.storybookknits.com/';
	break;
	
	case ("www.instylenewyork.com"):
	default:
		$config['template']			= 'default';
		$config['site_name']		= 'Instyle New York';
		$config['site_domain']		= 'www.instylenewyork.com';
		$config['site_address1']	= '230 West 38th Street';
		$config['site_address2']	= 'New York, NY 10018';

		$config['site_title']		= 'Cocktail dress - Evening dress - Homecoming dress - Special occasion dresses and more at Instylenewyork.com ';
		$config['site_keywords']	= 'Cocktail Dresses, Party Dresses, Homecoming Dresses, Glitz Dresses, Beaded Dresses, Sequined Dresses, Costume Jewelry , Swimwear, Issue Dresses, Basix Dresses, Furs, and more at instylenewyork.com';
		$config['site_description']	= 'A vast collection of womens fashion ranging from Dresses , Evening Gowns, Special Occassion suits , costume jewelry and more.';
		$config['footer_text']		= '';

		$config['google_analtyics']	= "
			<script type=\"text/javascript\">
				var isOpen = 0;

				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', 'UA-18902231-1']);
				_gaq.push(['_trackPageview']);

				(function() {
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();

			</script>
		";
		
		$config['site_subject']		= 'Instyle New York';
		$config['info_email']		= 'info@instylenewyork.com';
		$config['store_email']		= 'order@instylenewyork.com';
		$config['inquiry_email']	= 'info@instylenewyork.com';
		
		if ($_SERVER['SERVER_NAME'] === 'localhost') $config['PROD_IMG_URL'] = 'http://localhost/www/joetaveras/products/';
		$config['PROD_IMG_URL']		= 'http://products.instylenewyork.com/';
}

/*
|--------------------------------------------------------------------------
| Site Access
|--------------------------------------------------------------------------
|
| Production Site access level using login. Typically this is used for beta sites
| to prevent being index and possibly duplicate production sites which may
| penalize our google account.
|
| 'DEFAULT'			Defaults to site direct access
| 'ADMIN_ONLY'		With login on live site
|
*/
$config['site_access']		= 'DEFAULT';


/*
| --------------------------
| old items
| just in case it is neede again.
| just remove _OLD
*/
$config['footer_text_OLD']	= 'In Style New York is an online dress and womens fashion store that provides manufacturer direct fashion of the highest quality to an international sophisticated woman. Located in the heart of the New York Fashion District, instylenewyork.com, maintains a special relationship with all its designers and strives to provide you with the best selections and customer service in the following areas. In Style New York carries all possible kinds of Evening Dresses, Prom Dresses, Cocktail Dresses, Mother of the Bride Dresses, Home Coming Dresses, Ball Gowns, Little Black Dresses, Glitz Dresses, Furs, Sexy Dresses, Quinceanera Dresses, Print Dresses, Pageant dresses, Party Dresses, Strapless Dresses, high fashion dresses, one of a kind dresses, Church Suits, Tops, Jeans, Jacket, Sweaters Accessories in Gemstone, costume jewelry , sterling silver and more including pre collections and couture. We currently carry dresses from the following designers: Basix Black Label, Basix Dresses, Issue New York, Issue Dresses, WR9000, Natanel, Centre Ville, Junnie Leigh, Milano Suits, Sioni Suits, Tally Taylor, and more. ';
