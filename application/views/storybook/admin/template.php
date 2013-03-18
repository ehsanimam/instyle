<?php echo doctype('xhtml1-trans'); ?>
<html>
<head>

	<meta http-equiv="Content-Language" content="en-us">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	
	<title>Admin Panel</title>
	
	<link href="<?php echo css_url('default/admin/style.css'); ?>" rel="stylesheet" type="text/css">
	
	<?php echo isset($styles_n_scripts) ? $styles_n_scripts : ''; ?>
	
</head>
<body>

	<div id="container">
		
		<div id="header">
			<?php $this->load->view($this->config->slash_item('template').'admin/header'); ?>
		</div>
		
		<div id="content_wrapper">
			Hello Word!
		</div>
		
		<div id="footer">
		
		</div>
		
	</div>

</body>
</html>

