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
<link href="<?php echo base_url(); ?>assets/css/style_<?php echo $this->config->item('template'); ?>.css" rel="stylesheet" type="text/css"/>

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
	// place google analytics code here
	echo ENVIRONMENT === 'production' ? $this->config->item('google_analtyics') : '';
	
/*
<script>
	// onload event for flowplayer visibility on thumbs list only after all images has loaded
	window.onload = function() {
		document.getElementById("view_mode_link_text_top").style.visibility="visible";
		document.getElementById("view_mode_link_text_btm").style.visibility="visible";
		for (i = 1; i <= 100; i++) {
			document.getElementById("runway_mode_player_" + i).style.visibility="visible";
		}
	}
</script>
*/
?>

<?php
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
	<?php $this->load->view($this->config->slash_item('template').'top_nav'); ?>
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
			<td><?php $this->load->view($this->config->slash_item('template').$file); ?></td>
		</tr>
	  
		<?php
		/*
		| -------------------------------------------------------------------------------
		| Footer to footnote section
		*/
		?>
		<tr><td>
		
			<div id="botwhitebg" align="center">
			<div style="border-top:#999999 1px solid;padding-top:10px;">
			<table cellspacing="0" cellpadding="0" width="100%" border="0">
				<tr>
					<td align="left" valign="top">
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr>
						<?php
						/*
						| --------------------------------------------------------------------------------------
						| Footer Links by categories
						*/
						if ($this->config->item('site_domain') === 'www.storybookknits.com_')
						{
							$cat_id = $this->set->get_id_of('cat', 'sweaters');
							$cat_res = $this->set->get_subcategory($cat_id);
						}
						else $cat_res = $this->set->get_category();
						
						if ($cat_res->num_rows() > 0)
						{
							foreach ($cat_res->result() as $cat_rec)
							{
								if ($this->session->userdata('user_cat') != 'wholesale' OR $cat_rec->cat_name != 'Accessories')
								{ ?>
									<td style="vertical-align:top;">
									
									<div class="normal_txt1"><?php echo $this->config->item('site_domain') === 'www.storybookknits.com_' ? strtoupper($cat_rec->subcat_name) : strtoupper($cat_rec->cat_name); ?></div>
									
										<?php
										if ($this->config->item('site_domain') === 'www.storybookknits.com_')
										{
											$cat_qry1 = $this->query_category->get_subsubcat_new($cat_rec->sc_url_structure);
										}
										else $cat_qry1 = $this->query_category->get_subcat_new($cat_rec->url_structure);
										
										if($cat_qry1->num_rows() > 0)
										{
											foreach($cat_qry1->result() as $cat_rec1)
											{
												$url  	 = '';
												$url 	.= $cat_rec1->c_url_structure.'/';
												$url 	.= $cat_rec1->sc_url_structure;
												
												if ($this->config->item('site_domain') === 'www.storybookknits.com_')
												{
													$url .= '/'.$cat_rec1->ssc_url_structure;
													echo anchor(str_replace('https','http',site_url($url)),$cat_rec1->subsubcat_name,array('class'=>'normal_txt3')).'<br>';
												}
												else
												{
													echo anchor(str_replace('https','http',site_url($url)),$cat_rec1->subcat_name,array('class'=>'normal_txt3')).'<br>';
												}
											} 
										}
										?>
									</td>
									<?php
								}
							} 
						}
						else
						{
							echo '<td>No category return</td>';
						}
						?>
						</tr>
						</table>
					</td>
					<td align="right" valign="top">
						<table border=0 cellpadding=0 cellspacing=0>
							<tr><td align=right style="vertical-align:top;">
							
								<?php
								if ($this->session->userdata('user_cat') == 'wholesale')
								{ ?>
									<?php $link_class = uri_string() == 'wholesale_ordering' ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('wholesale_ordering')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">ORDERING</a><span class="lseparator">|</span>
									
									<?php $link_class = uri_string() == 'wholesale_return_policy' ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('wholesale_return_policy')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">RETURNS</a><span class="lseparator">|</span>
									
									<?php $link_class = uri_string() == 'wholesale_shipping' ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('wholesale_shipping')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">SHIPPING</a><span class="lseparator">|</span>
									
									<?php $link_class = uri_string() == 'wholesale_privacy_notice' ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('wholesale_privacy_notice')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">PRIVACY</a><span class="lseparator">|</span>
									
									<?php $link_class = uri_string() == 'wholesale_order_status' ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('wholesale_order_status')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">ORDER STATUS</a><span class="lseparator">|</span>
									
									<?php $link_class = uri_string() == 'wholesale_faq' ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('wholesale_faq')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">FAQ</a><span class="lseparator">|</span>
									<?php
								}
								else
								{ ?>
									<?php $link_class = uri_string() == 'ordering' ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('ordering')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">ORDERING</a><span class="lseparator">|</span>
									
									<?php $link_class = uri_string() == 'return_policy' ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('return_policy')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">RETURNS</a><span class="lseparator">|</span>
									
									<?php $link_class = uri_string() == 'shipping' ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('shipping')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">SHIPPING</a><span class="lseparator">|</span>
									
									<?php $link_class = uri_string() == 'privacy_notice' ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('privacy_notice')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">PRIVACY</a><span class="lseparator">|</span>
									
									<?php $link_class = uri_string() == 'order_status' ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('order_status')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">ORDER STATUS</a><span class="lseparator">|</span>
									
									<?php $link_class = uri_string() == 'faq' ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('faq')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">FAQ</a><span class="lseparator">|</span>
									<?php
								}
								?>
								
								<?php $link_class = uri_string() == 'sitemap' ? 'color:#AA0000;' : ''; ?>
								<a href="<?php echo str_replace('https','http',site_url('sitemap')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">SITEMAP</a><span class="lseparator">|</span>
								<?php $link_class = uri_string() == 'contact' ? 'color:#AA0000;' : ''; ?>
								<a href="<?php echo str_replace('https','http',site_url('contact')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">CONTACT</a>
								<br /><br />
							</td></tr>
							<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;"><?php echo strtoupper($this->config->item('site_name')); ?>, INC</td></tr>
							<!--
							<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;">TEL: 212-840-0846</td></tr>
							-->
							<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;">EMAIL: <?php echo safe_mailto($this->config->item('info_email'), strtoupper($this->config->item('info_email'))); ?></td></tr>
							<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;">COPYRIGHT <?php echo strtoupper($this->config->item('site_domain')); ?></td></tr>
						</table>
						<br />

						<a href="http://www.storybookknits.com/" target="_blank"><img src="<?php echo base_url(); ?>images/blog.png" alt="Blog" title="Blog"border="0" /></a> 
					  
						<a href="http://www.youtube.com/storybookknits" target="_blank"><img src="<?php echo base_url(); ?>images/y.png" title="Follow us on Youtube" alt="Follow us on Youtube" border="0" /></a> 
					  
						<a href="http://www.facebook.com/storybookknits" target="_blank"><img src="<?php echo base_url(); ?>images/ico_facebook.jpg" alt="Facebook Connect"  title="Facebook Connect"border="0" /></a> 
						
						<a href="https://twitter.com/storybookknits" target="_blank"><img src="<?php echo base_url(); ?>images/ico_twitter.jpg" border="0" alt="Follow us on Twitter" title="Follow us on Twitter" /></a>
						
						<a href="#"><img src="<?php echo base_url(); ?>images/ico_rss.jpg" border="0" alt="Rss Feeds" title="Rss Feeds" /></a> 
						
						<div style="clear:both;"></div>      
					</td>
				</tr>
				</table>
			</div>
			</div>
		</td></tr>
		<tr><td class="normal_txt" style="font-weight:normal; text-decoration:none;">
			<div id="botwhitebg" align="center">
			<div id="wrapbottom" style="text-align:justify;margin-bottom:35px;">
				<?php
				/*
				| ---------------------------------------------------------------------------
				| Footer text will be pulled up from category, subcategory, and designer.
				| If footer text is empty, default footer text will be show up.
				| Default footer text can be change in the custom_config file
				| -- Modified by Verjel --  07/14/2011
				*/
				if (isset($footer_text) && ! empty($footer_text))
				{
					if ($footer_text == $site_title)
					{
						echo $uri_designer.$uri_facets.$footer_text;
					}
					else
					{
						echo $footer_text;
					}
				}
				else
				{
					echo $this->config->item('footer_text');
				}
				?>
			</div>
			</div>
		</td></tr>
	</table>
</td></tr>
<tr></td>
</td></tr>
</table>
	<?php
	/*
	| ---------------------------------------------------------------------------
	| Using this portion for debugging purposes
	|
	if (ENVIRONMENT === 'production')
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
