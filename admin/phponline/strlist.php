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

$FDELIM = "|_:-:|";
$LDELIM = "|::_:-|";

$WList = "";

if ($handle = opendir(getcwd())) 
{
	while (false !== ($file = readdir($handle))) 
	{
		if(substr($file,0,strlen('lang_str_'))=='lang_str_' && substr(strrev($file),0,strlen('php.'))=='php.')
		{
			$FC = file($file);
			if(strpos(strtolower($FC[2]),"phponline language strings")!==false)
			{
				$LangFile = substr($file,strlen('lang_str_'));
				$LangFile = strrev(substr(strrev($LangFile),strlen('php.')));
				$FCName = trim($FC[3]);
				$WList .= ($FCName.$FDELIM);
				$WList .= ($LangFile.$LDELIM);
			}
		}
	}
	closedir($handle);
}

echo "pr_s=s&wlist=$WList&strlist_sema=1&pr_e=e";


?>