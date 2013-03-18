<?php
	if (ENVIRONMENT === 'development')
	{
		// ----> for local development environment purposes only
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'mail.instylenewyork.com';
		$config['smtp_port'] = 587; // 465 or 587 for gmail...
		$config['smtp_user'] = 'local@instylenewyork.com';
		$config['smtp_pass'] = 'reyrusty';
		$config['mailtype'] = 'html';
	}
	else
	{
		// ----> for live production use
		$config['protocol'] = 'mail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
	}
	
/* End of file email.php */
/* Location: ./application/config/email.php */