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



$LangFile = $HTTP_POST_VARS['lang_file'];
$TTime = gmdate("U");


$LangFile = FilterString($LangFile,'WORD');


if (preg_match("#^[a-z0-9_]+$#i",$LangFile) )
{
	$LangFile = 'lang_str_'.$LangFile.'.php';
	include_once($LangFile);
}


$CondStr = "";
foreach($LANG as $k=>$v)
{
	$CondStr .= ("lang_str_".$k."=".GetEQString(str_replace("\n","[nl]",$v))."&");
}


echo "pr_s=s&load_sema=1&".$CondStr."pr_e=e";

?>