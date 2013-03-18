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


$ADMID = FilterString($HTTP_POST_VARS['admid'],'WORD');


$FDELIM = "|_:-:|";
$LDELIM = "|::_:-|";

$WList = "";


$WList .= ('empty'.$FDELIM);
$WList .= (''.$FDELIM);
$WList .= ("0".$FDELIM);
$WList .= ("".$FDELIM);
$WList .= ("".$FDELIM);
$WList .= ("".$FDELIM);
$WList .= ("".$LDELIM);




$dbh=mysql_connect($DBHost, $DBUsername, $DBPassword,true) or die ('res=0');
mysql_select_db($DBDatabase,$dbh);

$res = mysql_query("SELECT * FROM bvars ORDER BY bvalue ",$dbh);
while($row = mysql_fetch_array($res))
{
	$FSSA = explode("_",$row['bname']);
	if($FSSA[0]!='fss' || count($FSSA)<3)
		continue;
	if($FSSA[1]=='g' || ($FSSA[1]=='p' && $FSSA[2]==$ADMID ))
	{
		$WList .= ($row['bname'].$FDELIM);
		$WList .= ($row['bvalue'].$FDELIM);
		if($FSSA[2]==$ADMID)
			$WList .= ("1".$FDELIM);
		else
			$WList .= ("0".$FDELIM);

		$FSS_PG = '';
		if($FSSA[1]=='g')
		{
			if($FSSA[2]==$ADMID)
			{
				$WList .= ("g".$FDELIM);
				$FSS_PG = 'g';
			}
			else
			{
				$WList .= ("G".$FDELIM);
				$FSS_PG = 'G';
			}
		}
		else
		{
			$WList .= ("p".$FDELIM);
			$FSS_PG = 'p';
		}

		$WList .= ("[".$FSS_PG."] ".$row['bvalue'].$FDELIM);
		$WList .= ("".$FDELIM);
		$WList .= ("".$LDELIM);
	}
}
mysql_free_result($res);


mysql_close($dbh);






$WList = GetEQString($WList);


echo "pr_s=s&wlistvar=$WList&fss_sema=1&pr_e=e";


?>