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

include_once('noca.php');
include_once('rcq.php');

$TTime = gmdate("U");

$LastAdmLoginTime = 0;


	$LastAdmLoginTime = 0;

	$dbh=mysql_connect($DBHost, $DBUsername, $DBPassword,true) or die ('res=0');
	mysql_select_db($DBDatabase,$dbh);


	$res = mysql_query("SELECT * FROM bvars WHERE bname='adm_login_time'",$dbh);
	while($row = mysql_fetch_array($res))
	{
		$LastAdmLoginTime = $row["bvalue"];
	}
	mysql_close($dbh);

if($LastAdmLoginTime==0 || $LastAdmLoginTime<($TTime-120))
{
	$OnlineStatus = 0;
}
else
{
	$OnlineStatus = 1;
}


echo "pr_s=s&sema10=1&on_st=$OnlineStatus&pr_e=e";

?>