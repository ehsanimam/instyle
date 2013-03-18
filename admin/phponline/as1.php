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

$Usr = $HTTP_POST_VARS['usr1'];
$TTime = gmdate("U");
$Alarm = $HTTP_POST_VARS['alarm'];
$WUsr = "";

$FDELIM = "|_:-:|";
$LDELIM = "|::_:-|";

$WList = "";

$fst = GetPStatus();
if($fst==1)
{
	SetPStatus("0");
	$dbh=mysql_connect($DBHost, $DBUsername, $DBPassword,true) or die ('res=0');
	mysql_select_db($DBDatabase,$dbh);
	mysql_query("INSERT INTO bvars VALUES('adm_login_time','$TTime')",$dbh);
	mysql_query("UPDATE bvars SET bvalue='$TTime' WHERE bname='adm_login_time'",$dbh);
	mysql_close($dbh);

	$dbh=mysql_connect($DBHost, $DBUsername, $DBPassword,true) or die ('res=0');
	mysql_select_db($DBDatabase,$dbh);
	$HREF = $AS2PHP;
	$Alarm=0;
	$res = mysql_query("SELECT * FROM cs WHERE online=1 AND assign<>2 AND ($TTime-lastact<60)",$dbh);
	while($row = mysql_fetch_array($res))
	{
		$IP = $row["ip"];
		$TW = $row["ccode"];
		$UN = $row["username"];
		$Name = $row["name"];
		
		$WList .= ($TW.$FDELIM);
		$WList .= ($IP.$FDELIM);
		
		if($UN!='')
		{
			$WList .= ($UN.$FDELIM);
		}
		if($Name!='')
		{
			$WList .= ($Name.$FDELIM);
		}


		if($row["assign"] == 1)
		{
			$WList .= ("1".$FDELIM);
		}
		else
		{
			if($row["assign"] == 2) // discard
			{
				$WList .= ("2".$FDELIM);
			}
			else
			{
				if($row["assign"] == 3) // on hold
				{
					$WList .= ("3".$FDELIM);
				}
				else
				{
					$WList .= ("0".$FDELIM);
					$Alarm = 1;
				}
			}
		}
		

		if($CONF['conf_UseLanguageTranslator']==1)
		{
			$WList .= (ucfirst($TransLangs[$row['code1']][1]).$FDELIM);
		}
		else
		{
			$WList .= ("".$FDELIM);
		}

		$WList .= ("0".$FDELIM);
		$WList .= ("0".$LDELIM);
	}
	mysql_free_result($res);


	mysql_close($dbh);




	echo "pr_s=s&alarm=$Alarm&dl=0&wlistvar=$WList&sema1=0&sema2=2&pr_e=e";
}
else
{
	echo "pr_s=s&sema1=0&pr_e=e";
}


?>