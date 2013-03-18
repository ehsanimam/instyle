<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
	if (defined(ENVIRONMENT) && (ENVIRONMENT == 'development' OR ENVIRONMENT == 'testing'))
		$pre = '_ ';
	else $pre = '';
	
 	if (isset($site_title) && !empty($site_title))
	{
		$uri_facets = isset($url_facets) ? ucwords(str_replace('-',', ',$url_facets)).' - ' : '';
		$uri_designer = isset($product->designer) ? $product->designer.' - ' : '';
		$dyn_site_title = $pre.$uri_designer.$uri_facets.$site_title;
	}
	else
	{
		$uri_facets = isset($url_facets) ? ucwords(str_replace('-',', ',$url_facets)).' - ' : '';
		$dyn_site_title = $pre.$uri_facets.$this->config->item('site_title');
	}

	if (isset($site_description) && !empty($site_description))
	{
		$uri_facets = isset($url_facets) ? ucwords(str_replace('-',', ',$url_facets)).' - ' : '';
		$dyn_site_description = $uri_facets.$site_description;
	}
	else
	{
		$uri_facets = isset($url_facets) ? ucwords(str_replace('-',', ',$url_facets)).' - ' : '';
		$dyn_site_description = $uri_facets.$this->config->item('site_description');
	}

	if (isset($site_keywords) && !empty($site_keywords))
	{
		$uri_facets = isset($url_facets) ? ucwords(str_replace('-',' ',$url_facets)).' - ' : '';
		$dyn_site_keywords = $uri_facets.$site_keywords;
	}
	else
	{
		$uri_facets = isset($url_facets) ? ucwords(str_replace('-',' ',$url_facets)).' - ' : '';
		$dyn_site_keywords = $uri_facets.$this->config->item('site_keywords');
	}
?>

<title><?php echo $dyn_site_title; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="<?php echo $dyn_site_description; ?>" />
<meta name="alexaVerifyID" content="1VXMA55vx8QtgD8Nkjvj0R8XMB4" />
<meta name="keywords" content="<?php echo $dyn_site_keywords; ?>" />
<meta name="author" content="Instyle" />
<meta name="subject" content="<?php echo $this->config->item('site_subject'); ?>" />
<meta name="coverage" content="worldwide" />
<meta name="Content-Language" content="english" />
<meta name="resource-type" content="document" />
<meta name="robots" content="all,index,follow" />
<meta name="classification" content="<?php echo $this->config->item('site_name'); ?>" />
<meta name="rating" content="general" />
<meta name="revisit-after" content="10 days" />
<link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" /> 
<link href="<?php echo base_url(); ?>style/main.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>style/style_b.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/style_default.css" rel="stylesheet" type="text/css"/>

<?php echo @$jscript; ?>

<style>
	body { vertical-align:top; }
	td { vertical-align:top; }
	.left { line-height:20px; font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif; }
	.left a { color:#999999; text-decoration:none; }
	.left a:hover { color:#CC0000; text-decoration:none; }
	
	div.pagination {
		padding: 3px 0px 3px 3px;
		margin: 2px 0px 3px 17px;
		display: inline;
	}

	div.pagination a {
		padding: 2px 5px 2px 5px;
		margin: 2px 2px 2px 2px;
		border: 1px solid #996600;
		text-decoration: none; /* no underline */
		color:#666666;
	}
	div.pagination a:hover, div.pagination a:active {
		border: 1px solid #CC3300;

		color: #000;
	}
	div.pagination span.current {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #888888;
		font-weight: bold;
		background-color: #CC3300;
		color: #FFF;
		}
	div.pagination span.disabled {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #EEE;

		color: #DDD;
	}
	div.pagination a.viewall {
		font-family:Arial, Helvetica, sans-serif;
		font-size:11px; font-weight:normal;
		text-align:justify;
		text-decoration:none;
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #EEE;
		color: #DDD;
	}

	.faceted_search { font-size:9px; line-height:10px; font-family:"tahoma"}

	#dvloader {
		position: fixed;
		z-index: 99;
		top: 0px;
		left: 0px;
		background-color: black;
		width: 100%;
		height: 100%;
		filter: Alpha(Opacity=40);
		opacity: 0.4;
		-moz-opacity: 0.4;
		text-align: center;
		padding-top: 350px;
	}
	
	#dvloader2 {
		position: fixed;
		z-index: 99;
		top: 0px;
		left: 0px;
		background-color: transparent;
		width: 100%;
		height: 100%;
		text-align: center;
		padding-top: 350px;
	}
	
	.dialog_runway_video {
		position: fixed;
	}
</style>

<?php
if (ENVIRONMENT !== 'development')
{ ?>
<script type="text/javascript">
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
<?php
}

	echo isset($function_reset_checkboxes) ? $function_reset_checkboxes : '';
?>

</head>

<body <?php echo isset($reset_checkbox) ? $reset_checkbox : ''; ?>>

<?php echo isset($div_loader) ? $div_loader : ''; ?>

<table border="0" cellspacing="0" cellpadding="0" width="100%">

<?php
/*
| -------------------------------------------------------------------------------
| Top nav
*/
?>
<tr><td id="headblackbg" style="height:40px;">
	<?php $this->load->view($this->config->slash_item('template').'sales/top_nav'); ?>
</td></tr>

<?php
/*
| -------------------------------------------------------------------------------
| Content Section (this row contains content and footer and footnote
*/
?>
<tr><td>

	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">
	
		<?php
		/*
		| -------------------------------------------------------------------------------
		| Content section
		*/
		?>
		<tr>
			<td><?php $this->load->view($this->config->slash_item('template').'sales/'.$file); ?></td>
		</tr>
	  
	</table>
</td></tr>
<tr><td>
</td></tr>
</table>
	<?php
	/*
	| ---------------------------------------------------------------------------
	| Using this portion for debugging purposes
	|
	*/
	if (ENVIRONMENT === 'development' || ENVIRONMENT === 'testing__')
	{
		echo '<div style="position:relative;margin:0 auto;width:980px;">';
		if ($this->session->userdata('user_cat') == 'user') echo '\'user_cat\' is USER for CONSUMER - User ID: '.$this->session->userdata('user_id').'<br />';
		if ($this->session->userdata('user_cat') == 'wholesale') echo '\'user_cat\' is WHOLESALE - User ID: '.$this->session->userdata('user_id').'<br />';
		echo $this->session->userdata('user_loggedin') ? 'Is logged in - Yes'  : 'Is logged in - No'.br();
		echo $this->session->userdata('admin_is_logged_in') ? 'Is admin logged in - Yes - "'.$this->session->userdata('admin_username')  : 'Is admin logged in - No';
		echo br(3);
		print_r($this->session->all_userdata());
		echo br(3).'Default Theme';
		echo '</div>';
	}
	?>
</body>
</html>
