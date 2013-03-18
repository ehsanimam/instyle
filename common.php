<?php
	session_start();
	// prevent accessing page without login
	if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') === false){
		if(!$_SESSION['session_admin']){
			header("location:index.php");
		}
	}
 
	if ( ! ini_get('register_globals'))
	{
		$superglobals = array($_SERVER, $_ENV, $_FILES, $_COOKIE, $_POST, $_GET);
		if (isset($_SESSION))
		{
			array_unshift($superglobals, $_SESSION);
		}
		foreach ($superglobals as $superglobal)
		{
			extract($superglobal, EXTR_SKIP);
		}
	}

	if (isset($act) && $act == "logout")
	{ 
		session_destroy();	
		header("Location: ../");
	}

	/*
	| ------------------------------------------------------------------------------
	| This is where you may define your local database connection and site url
	| for development environment purposes.
	*/
	if ($_SERVER['SERVER_NAME'] === 'localhost')
	{
		error_reporting(E_ALL); // ----> for development use only
		
		/* ---------------------------------------
		 | Local development database switch can only be done manually for now
		 | Comment all other active groups for developement environment
		 | ---------------------------------------
		*/
		//$active_group = 'local_instyle';
		$active_group = 'local_storybook';
		
		switch ($active_group)
		{
			case 'local_instyle':
				$dbhost="localhost";
				$username="root";
				$password="root";
				$db="verjel_instyle";
				
				define('SITE_NAME','Instyle New York');
				define('SITE_SHORT_NAME','instyle');
				define('SITE_DOMAIN','www.instylenewyork.com');
				define('INFO_EMAIL','info@instylenewyork.com');
				
				$host = $_SERVER['HTTP_HOST'];
				define('IMG_REPO_URL', "http://$host/www/joetaveras/products/");
				define('IMG_REPO_URL_VAR', "../../products/");
			break;
			
			case 'local_storybook':
				$dbhost="localhost";
				$username="root";
				$password="root";
				$db="db_storybook";
				
				define('SITE_NAME','Story Book Knits');
				define('SITE_SHORT_NAME','storybook');
				define('SITE_DOMAIN','www.storybookknits.com');
				define('INFO_EMAIL','info@storybookknits.com');
				
				$host = $_SERVER['HTTP_HOST'];
				define('IMG_REPO_URL', "http://$host/www/joetaveras/products/");
				define('IMG_REPO_URL_VAR', "../../products/");
			break;
		}

		$host = $_SERVER['HTTP_HOST'];
		define('SITE_URL', "http://$host/www/joetaveras/milan/");
	}
	elseif ($_SERVER['SERVER_NAME'] === 'www.instylemilan.com')
	{
		//error_reporting(E_ALL); // ----> for development use only
		
		$dbhost="localhost";
		$username="joe_milan";
		$password="m1l@n";
		$db="joe_milan";

		// ---> remote db
		// connect config to remote db
		$host_remote="216.70.104.66";
		$username_remote="joe_taveras";
		$password_remote="!@R00+@dm!N";
		$db_remote="joe_moscow";

		define('SITE_URL','http://www.instylemilan.com/');
		define('IMG_REPO_URL', 'http://products.instylemilan.com/');
		
		define('SITE_NAME','Instyle New York');
		define('SITE_DOMAIN','www.instylenewyork.com');
		define('INFO_EMAIL','info@instylenewyork.com');
	}
	elseif ($_SERVER['SERVER_NAME'] === 'www.instylenewyork.com')
	{
		//error_reporting(E_ALL); // ----> for development use only
		
		$dbhost="localhost";
		$username="verjel";
		$password="icmstudio";
		$db="verjel_instyle";

		// ---> remote db
		// connect config to remote db
		$host_remote="64.207.150.168";
		$username_remote="joereyrusty_icm";
		$password_remote="!@R00+@dm!N";
		$db_remote="icmbasix_main";

		define('SITE_URL','https://www.instylenewyork.com/');
		define('IMG_REPO_URL', 'http://products.instylenewyork.com/');
		
		define('SITE_NAME','Instyle New York');
		define('SITE_DOMAIN','www.instylenewyork.com');
		define('INFO_EMAIL','info@instylenewyork.com');
	}
	elseif ($_SERVER['SERVER_NAME'] === 'www.storybookknits.com')
	{
		//error_reporting(E_ALL); // ----> for development use only
		
		$dbhost="localhost";
		$username="joe_db_storybook";
		$password="1cmstud10s";
		$db="db_storybook";

		// ---> remote db
		// connect config to remote db
		$host_remote="localhost";
		$username_remote="joereyrusty_icm";
		$password_remote="!@R00+@dm!N";
		$db_remote="icm_cozy";

		define('SITE_URL','http://www.storybookknits.com/');
		define('IMG_REPO_URL', 'http://products.storybookknits.com/');
		define('IMG_REPO_URL_VAR', '/var/www/vhosts/storybookknits.com/products/');
		
		define('SITE_NAME','Story Book Knits');
		define('SITE_SHORT_NAME','storybook');
		define('SITE_DOMAIN','www.storybookknits.com');
		define('INFO_EMAIL','info@storybookknits.com');
	}
	
	/*
	| ------------------------------------------------------------------------------
	| Connet to db
	*/
	$link = mysql_connect($dbhost,$username,$password);
	mysql_select_db($db,$link);

	/*
	| ------------------------------------------------------------------------------
	| Global constants
	*/
	// smtp.com mailer info
	define('SMTP_HOST','instylenewyork.smtp.com');
	define('SMTP_UNAME','joe@innerconcept.com');
	define('SMTP_PWORD','inner@8775784000');
	
	define('DEV1_EMAIL','rsbgm@innerconcept.com');
	define('DEV2_EMAIL','rusty@innerconcept.com');
	
	define('SINGLE_DESIGNER_SITE',FALSE); // ---> set TRUE for manufacturer sites
	
	define('DESIGNER',''); // ---> set designer name for url purposes when single_designer_site
	
	