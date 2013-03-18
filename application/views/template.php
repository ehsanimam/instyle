<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
 	if (isset($site_title) && !empty($site_title))
	{
		$dyn_site_title = $site_title;
	}
	else
	{
		$dyn_site_title = $this->config->item('site_title');
	}

	if (isset($site_description) && !empty($site_description))
	{
		$dyn_site_description = $site_description;
	}
	else
	{
		$dyn_site_description = $this->config->item('site_description');
	}

	if (isset($site_keywords) && !empty($site_keywords))
	{
		$dyn_site_keywords = $site_keywords;
	}
	else
	{
		$dyn_site_keywords = $this->config->item('site_keywords');
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
	margin: 3px 0px 3px 3px;
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
div.pagination a.viewall{
font-family:Arial, Helvetica, sans-serif;
 font-size:11px; font-weight:normal;
   text-align:justify;
    text-decoration:none;
padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #EEE;
	color: #DDD;}

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
	
</style>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18902231-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<?php echo isset($function_reset_checkboxes) ? $function_reset_checkboxes : ''; ?>

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
	<?php $this->load->view('top_nav'); ?>
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
			<td><?php $this->load->view($file); ?></td>
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
						$cat_res = $this->set->get_category();
						if($cat_res->num_rows() > 0)
						{
							foreach($cat_res->result() as $cat_rec)
							{
								if ($this->session->userdata('user_cat') != 'wholesale' OR $cat_rec->cat_name != 'Accessories')
								{ ?>
									<td style="vertical-align:top;">
									<div class="normal_txt1"><?php echo strtoupper($cat_rec->cat_name); ?></div>
										<?php 
										$cat_qry1 = $this->set->get_subcategory($cat_rec->cat_id);
										if($cat_qry1->num_rows() > 0)
										{
											foreach($cat_qry1->result() as $cat_rec1)
											{
												$url  	 = '';
												$url 	.= $cat_rec1->c_url_structure.'-'.$cat_rec1->cat_id.'/';
												$url 	.= $cat_rec1->sc_url_structure.'-'.$cat_rec1->subcat_id;
												echo anchor(str_replace('https','http',site_url($url.'.html')),$cat_rec1->subcat_name,array('class'=>'normal_txt3')).'<br>';
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
									<?php $link_class = ($this->uri->segment(2) == 'wholesale_ordering.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('p7/wholesale_ordering.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">ORDERING</a><span class="lseparator">|</span>
									
									<?php $link_class = ($this->uri->segment(2) == 'wholesale_return_policy.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('p8/wholesale_return_policy.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">RETURNS</a><span class="lseparator">|</span>
									
									<?php $link_class = ($this->uri->segment(2) == 'wholesale_shipping.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('p9/wholesale_shipping.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">SHIPPING</a><span class="lseparator">|</span>
									
									<?php $link_class = ($this->uri->segment(2) == 'wholesale_privacy_notice.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('p10/wholesale_privacy_notice.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">PRIVACY</a><span class="lseparator">|</span>
									
									<?php $link_class = ($this->uri->segment(2) == 'wholesale_order_status.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('p11/wholesale_order_status.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">ORDER STATUS</a><span class="lseparator">|</span>
									
									<?php $link_class = ($this->uri->segment(2) == 'wholesale_faq.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('p12/wholesale_faq.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">FAQ</a><span class="lseparator">|</span>
									<?php
								}
								else
								{ ?>
									<?php $link_class = ($this->uri->segment(2) == 'ordering.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('p1/ordering.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">ORDERING</a><span class="lseparator">|</span>
									
									<?php $link_class = ($this->uri->segment(2) == 'return_policy.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('p2/return_policy.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">RETURNS</a><span class="lseparator">|</span>
									
									<?php $link_class = ($this->uri->segment(2) == 'shipping.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('p3/shipping.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">SHIPPING</a><span class="lseparator">|</span>
									
									<?php $link_class = ($this->uri->segment(2) == 'privacy_notice.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('p4/privacy_notice.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">PRIVACY</a><span class="lseparator">|</span>
									
									<?php $link_class = ($this->uri->segment(2) == 'order_status.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('p5/order_status.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">ORDER STATUS</a><span class="lseparator">|</span>
									
									<?php $link_class = ($this->uri->segment(2) == 'faq.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('p6/faq.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">FAQ</a><span class="lseparator">|</span>
									<?php
								}
								?>
								
								<?php $link_class = ($this->uri->segment(1) == 'press.html') ? 'color:#AA0000;' : ''; ?>
								<a href="<?php echo str_replace('https','http',site_url('press.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">PRESS</a><span class="lseparator">|</span>
								<?php $link_class = ($this->uri->segment(1) == 'sitemap.html') ? 'color:#AA0000;' : ''; ?>
								<a href="<?php echo str_replace('https','http',site_url('sitemap.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">SITEMAP</a><span class="lseparator">|</span>
								
								<?php
								if ($this->session->userdata('user_cat') != 'wholesale')
								{
									$link_class = ($this->uri->uri_string() == 'wholesale/signin.html') ? 'color:#AA0000;' : ''; ?>
									<a href="<?php echo str_replace('https','http',site_url('wholesale/signin.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">RETAILER LOGIN</a><span class="lseparator">|</span>
									<?php
								}
								?>
								
								<?php $link_class = ($this->uri->segment(1) == 'contact.html') ? 'color:#AA0000;' : ''; ?>
								<a href="<?php echo str_replace('https','http',site_url('contact.html')); ?>" style="font-family:Arial; font-size: 10px; font-weight:normal; text-decoration:none;<?php echo $link_class; ?>">CONTACT</a>
								<br /><br />
							</td></tr>
							<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;"><?php echo strtoupper($this->config->item('site_name')); ?>, INC</td></tr>
							<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;">TEL: 212-840-0846</td></tr>
							<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;">EMAIL: <a href="mailto:info@instylenewyork.com">INFO@INSTYLENEWYORK.COM</a></td></tr>
							<tr><td align="right" style="font-family:Arial; font-size: 10px; font-weight:normal;">COPYRIGHT INSTYLENEWYORK.COM</td></tr>
						</table>
						<br />
						<a href="http://www.instylenewyork.com/" target="_blank"><img src="<?php echo base_url(); ?>images/blog.png" alt="Blog" title="Blog"border="0" /></a> 
					  
						<a href="http://www.youtube.com/instylenewyork" target="_blank"><img src="<?php echo base_url(); ?>images/y.png" title="Follow us on Youtube" alt="Follow us on Youtube" border="0" /></a> 
					  
						<a href="http://www.facebook.com/pages/Instylenewyork/111176205617161" target="_blank"><img src="<?php echo base_url(); ?>images/ico_facebook.jpg" alt="Facebook Connect"  title="Facebook Connect"border="0" /></a> 
						
						<a href="https://twitter.com/instylenewyork" target="_blank"><img src="<?php echo base_url(); ?>images/ico_twitter.jpg" border="0" alt="Follow us on Twitter" title="Follow us on Twitter" /></a> 
						
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
				| Footer text will pulled up from  category, subcategory, and designer.
				| If footer text is empty, default footer text will be show up.
				| Default footer text can be change in the custom_config file
				| -- Modified by Verjel --  07/14/2011
				*/
				if (isset($footer_text) && !empty($footer_text))
				{
					echo $footer_text;
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
	echo '<div style="position:relative;margin:0 auto;width:980px;">';
	if ($this->session->userdata('user_cat') == 'user') echo '\'user_cat\' is USER for CONSUMER - User ID: '.$this->session->userdata('user_id').'<br />';
	if ($this->session->userdata('user_cat') == 'wholesale') echo '\'user_cat\' is WHOLESALE - User ID: '.$this->session->userdata('user_id').'<br />';
	echo $this->session->userdata('user_loggedin') ? 'Is logged in - Yes'  : 'Is logged in - No';
	echo br();
	print_r($this->session->all_userdata());
	echo br(3);
	echo '</div>';
	
	echo base_url();
	echo br().$this->uri->segment(1);
	*/
	?>
</body>
</html>