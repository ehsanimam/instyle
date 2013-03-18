<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login - Admin Panel - <?php echo $this->config->item('site_name'); ?></title>
<link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon"/>
<style>

.text-input {
				display: block;
				margin: 0 0 1em 0;
				width: 305px;
				border: 5px;
				-moz-border-radius: 1px;
				-webkit-border-radius: 1px;
				padding: 5px;
				-moz-border-radius: 1px;
				-webkit-border-radius: 1px;
				border-radius: 1px;
				font-family: arial;
				font-size:14px;
}

.login_child {
				width: 320px;
				background: #000;
				border: 1px solid white;
				margin: 200px auto 0;
				padding: 1em;
				-webkit-border-radius: 4px;
				-moz-border-radius: 4px;
				border-radius: 4px;
				color: #999;
				font-family:arial;
				text-align: center;
}

.submitlogin {
				border: none;
				width: 150px;
				margin-right: 1em;
				padding: 5px;
				text-decoration: none;
				font-size: 16px;
				background: #999;
				color: white;
				-moz-border-radius: 4px;
				-webkit-border-radius: 4px;
				border-radius: 4px;
}

</style>

<!--[if IE]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
	
	<div class="content-wrap">
		<div class="login-wrap">
       		<div class="login_child">
               	<div class="imglogo">
                   	<h4>Login to <?php echo $this->config->item('site_name'); ?> Admin Panel</h4>
				</div>
				
				<!--bof form=========================================-->
           		<?php echo form_open('admin_ci/login'); ?>
					<input type="hidden" name="page_being_accessed" value="<?php echo $this->session->flashdata('page_being_accessed'); ?>" />
                   	<input value="" name="username" class="text-input" type="text" placeholder="Username">
                   	<input name="password" class="text-input" type="password" placeholder="Password">
                   	<input name="" class="submitlogin" type="submit" value="Login">
               	</form>
				<!--eof form=========================================-->
				
               	<div class="imglogo">
                   	<h4><?php echo $this->session->flashdata('logErr') ? $this->session->flashdata('logErr'): ''; echo validation_errors(); ?></h4>
				</div>
			</div>
        </div>
    </div>
	<?php
	/*
	| ---------------------------------------------------------------------------
	| Using this portion for debugging purposes
	|
	*/
	if (ENVIRONMENT === 'development__')
	{
		echo '<div style="position:relative;margin:0 auto;width:980px;">';
		if ($this->session->userdata('user_cat') == 'user') echo '\'user_cat\' is USER for CONSUMER - User ID: '.$this->session->userdata('user_id').'<br />';
		if ($this->session->userdata('user_cat') == 'wholesale') echo '\'user_cat\' is WHOLESALE - User ID: '.$this->session->userdata('user_id').'<br />';
		echo $this->session->userdata('user_loggedin') ? 'Is logged in - Yes'  : 'Is logged in - No'.br();
		echo $this->session->userdata('admin_logged_in') ? 'Is admin logged in - Yes'  : 'Is admin logged in - No';
		echo br(3);
		echo '</div>';
	}
	?>
    
</body>
</html>