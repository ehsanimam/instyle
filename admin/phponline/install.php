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

$dbhe=mysql_connect($DBHost, $DBUsername, $DBPassword,true) or exit("Could not connect");
mysql_select_db($DBDatabase,$dbhe);

echo "Creating msgdb Table...\n<BR>";
$res = mysql_query("CREATE TABLE msgdb (
				ttime double(25,8) NOT NULL,
				ccode varchar(20),
				msg text,
				code1 SMALLINT(4) default 0,
				code2 SMALLINT(4) default 0,
						PRIMARY KEY  (ttime)
						) TYPE=MyISAM
		",$dbhe);
if($res==false)
	echo "Error: ".mysql_error()."\n<BR>";
else
	echo "Done.\n<BR>";


echo "Creating cs Table...\n<BR>";
$res = mysql_query("CREATE TABLE cs (
				ccode varchar(20) NOT NULL,
				assign SMALLINT(4) default 0,
				online SMALLINT(4) default 0,
				ip varchar(20),
				code1 SMALLINT(4) default 0,
				code2 SMALLINT(4) default 0,
				lastact INT(10) default 0,
				name varchar(110),
				email varchar(50),
				username varchar(20),
						PRIMARY KEY  (ccode)
						) TYPE=MyISAM
		",$dbhe);
if($res==false)
	echo "Error: ".mysql_error()."\n<BR>";
else
	echo "Done.\n<BR>";

echo "Creating bvars Table...\n<BR>";
$res = mysql_query("CREATE TABLE bvars (
				bname varchar(254) NOT NULL,
				bvalue varchar(254),
						PRIMARY KEY  (bname)
						) TYPE=MyISAM
		",$dbhe);
if($res==false)
	echo "Error: ".mysql_error()."\n<BR>";
else
	echo "Done.\n<BR>";


mysql_close($dbhe);


?>