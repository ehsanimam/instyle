<?php

/*****************************************************************
phpOnline - Online customer support system
Copyright (C) 2003-2006 
Dayana Networks Ltd. <phponline@dayanahost.com>
Farhad Malekpour <fm@farhad.ca>
All rights reserved.

Official Website	http://phponline.dayanahost.com
Online Forums       http://www.dayanahost.com/forum
Powered by          http://www.dayanahost.com

Translation service provided by Google Inc.

THE USE OF THIS SOFTWARE IS COMPLETELY AT YOUR OWN RISK!

--------------------------- GNU License ---------------------------

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*****************************************************************/


include_once('config.php');

$CH1 = "";
$CH2 = "";

function CheckTable($table,$DBHost, $DBUsername, $DBPassword,$DBDatabase)
{
	$CNT_SUCCESS = false;
	$dbh=mysql_connect($DBHost, $DBUsername, $DBPassword,true);
	mysql_select_db($DBDatabase,$dbh);
	$res = mysql_query("SELECT * from $table LIMIT 0,1",$dbh);
	if($res===false)
	{
		$CNT_SUCCESS = false;
	}
	else
	{
		$CNT_SUCCESS = true;
	}
	mysql_close($dbh);
	return($CNT_SUCCESS);
}

$dbh=mysql_connect($DBHost, $DBUsername, $DBPassword,true);
if(!$dbh)
{
	$CH1 = 'Error: Can not connect to MySQL server';
	$CH2 = 'Hint: Check the database parameters in config.php';
}
else
{
	if(mysql_select_db($DBDatabase,$dbh)==false)
	{
		$CH1 = 'Error: I can connect to MySQL server but not to database '.$DBDatabase;
		$CH2 = 'Hint: Check the database parameters in config.php';
	}
	else
	{
		mysql_close($dbh);
		if(!CheckTable('bvars',$DBHost, $DBUsername, $DBPassword,$DBDatabase) || !CheckTable('cs',$DBHost, $DBUsername, $DBPassword,$DBDatabase) || !CheckTable('msgdb',$DBHost, $DBUsername, $DBPassword,$DBDatabase))
		{
			echo "pr_s1=";
			include("install.php");
			echo "&";
		}
		if(!CheckTable('bvars',$DBHost, $DBUsername, $DBPassword,$DBDatabase) || !CheckTable('cs',$DBHost, $DBUsername, $DBPassword,$DBDatabase) || !CheckTable('msgdb',$DBHost, $DBUsername, $DBPassword,$DBDatabase))
		{
			$CH1 = 'Error: I can\'t create required tables or tables corrupted';
			$CH2 = 'Hint: Try to drop all tables from database and reload this page.';
		}
	}
	
}



$RV = 2;
if($CH1=='')
	$RV = 1;



echo "pr_s=s&gm_sema=$RV&ch1=$CH1&ch2=$CH2&pr_e=e";

?>