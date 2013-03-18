<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
|				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|	['swap_pre'] A instyle table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By instyle there is only one group (the 'instyle' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
|
| Not setting the $active_group variable to be able to use multiple connection_aborted
| loading database at the contruct of the classes
|
*/

	/* ---------------------------------------
	 | To developers, the development environment has been set for and in between 2
	 | pioneering developers. To maintain one code across coders, please adjust your local
	 | environment accordingly.
	 | ---------------------------------------
	*/

	/* ---------------------------------------
	 | Local development database switch can only be done manually for now
	 | Comment all other active groups for developement environment
	 | ---------------------------------------
	*/

switch (ENVIRONMENT)
{
	case 'development':
		//$active_group = 'local_instyle';
		$active_group = 'local_storybook';
	break;
	
	case 'testing';
		$active_group = 'milan';
	break;
	
	default:
		if ($_SERVER['SERVER_NAME'] === 'www.instylenewyork.com') $active_group = 'instyle';
		if ($_SERVER['SERVER_NAME'] === 'www.storybookknits.com') $active_group = 'storybook';
}

$active_record = TRUE;

$db['milan']['hostname'] = 'localhost';
$db['milan']['username'] = 'joe_milan';
$db['milan']['password'] = 'm1l@n';
$db['milan']['database'] = 'joe_milan';
$db['milan']['dbdriver'] = 'mysql';
$db['milan']['dbprefix'] = '';
$db['milan']['pconnect'] = TRUE;
$db['milan']['db_debug'] = TRUE;
$db['milan']['cache_on'] = FALSE;
$db['milan']['cachedir'] = '';
$db['milan']['char_set'] = 'utf8';
$db['milan']['dbcollat'] = 'utf8_general_ci';
$db['milan']['swap_pre'] = '';
$db['milan']['autoinit'] = TRUE;
$db['milan']['stricton'] = FALSE;

$db['instyle']['hostname'] = 'localhost';
$db['instyle']['username'] = 'verjel';
$db['instyle']['password'] = 'icmstudio';
$db['instyle']['database'] = 'verjel_instyle';
$db['instyle']['dbdriver'] = 'mysql';
$db['instyle']['dbprefix'] = '';
$db['instyle']['pconnect'] = TRUE;
$db['instyle']['db_debug'] = TRUE;
$db['instyle']['cache_on'] = FALSE;
$db['instyle']['cachedir'] = '';
$db['instyle']['char_set'] = 'utf8';
$db['instyle']['dbcollat'] = 'utf8_general_ci';
$db['instyle']['swap_pre'] = '';
$db['instyle']['autoinit'] = TRUE;
$db['instyle']['stricton'] = FALSE;

$db['local_instyle']['hostname'] = 'localhost';
$db['local_instyle']['username'] = 'root';
$db['local_instyle']['password'] = 'root';
$db['local_instyle']['database'] = 'verjel_instyle';
$db['local_instyle']['dbdriver'] = 'mysql';
$db['local_instyle']['dbprefix'] = '';
$db['local_instyle']['pconnect'] = TRUE;
$db['local_instyle']['db_debug'] = TRUE;
$db['local_instyle']['cache_on'] = FALSE;
$db['local_instyle']['cachedir'] = '';
$db['local_instyle']['char_set'] = 'utf8';
$db['local_instyle']['dbcollat'] = 'utf8_general_ci';
$db['local_instyle']['swap_pre'] = '';
$db['local_instyle']['autoinit'] = TRUE;
$db['local_instyle']['stricton'] = FALSE;

$db['local_storybook']['hostname'] = 'localhost';
$db['local_storybook']['username'] = 'root';
$db['local_storybook']['password'] = 'root';
$db['local_storybook']['database'] = 'db_storybook';
$db['local_storybook']['dbdriver'] = 'mysql';
$db['local_storybook']['dbprefix'] = '';
$db['local_storybook']['pconnect'] = TRUE;
$db['local_storybook']['db_debug'] = TRUE;
$db['local_storybook']['cache_on'] = FALSE;
$db['local_storybook']['cachedir'] = '';
$db['local_storybook']['char_set'] = 'utf8';
$db['local_storybook']['dbcollat'] = 'utf8_general_ci';
$db['local_storybook']['swap_pre'] = '';
$db['local_storybook']['autoinit'] = TRUE;
$db['local_storybook']['stricton'] = FALSE;

$db['storybook']['hostname'] = 'localhost';
$db['storybook']['username'] = 'joe_db_storybook';
$db['storybook']['password'] = '1cmstud10s';
$db['storybook']['database'] = 'db_storybook';
$db['storybook']['dbdriver'] = 'mysql';
$db['storybook']['dbprefix'] = '';
$db['storybook']['pconnect'] = TRUE;
$db['storybook']['db_debug'] = TRUE;
$db['storybook']['cache_on'] = FALSE;
$db['storybook']['cachedir'] = '';
$db['storybook']['char_set'] = 'utf8';
$db['storybook']['dbcollat'] = 'utf8_general_ci';
$db['storybook']['swap_pre'] = '';
$db['storybook']['autoinit'] = TRUE;
$db['storybook']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */