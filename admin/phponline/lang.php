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

eval(base64_decode("bGlzdCgkSVNOLCRJU05QQikgPSBHZXRMaWNlbnNlKCk7"));

echo "ps_s=s&txt_sema=1&maxwaittime=".$CONF['conf_MaxWaitTime']."&usetrans=".$CONF['conf_UseLanguageTranslator']."&license=$ISN&licensepb=$ISNPB&phponlinever=".$CONF['conf_phpOnlineVer']."&msg1=".$CONF['conf_Msg1']."&msg2=".$CONF['conf_Msg2']."&msg3=".$CONF['conf_Msg3']."&msg4=".$CONF['conf_Msg4']."&msg5=".$CONF['conf_Msg5']."&msg6=".$CONF['conf_Msg6']."&msg7=".$CONF['conf_Msg7']."&msg8=".$CONF['conf_Msg8']."&msg9=".$CONF['conf_Msg9']."&msg10=".$CONF['conf_Msg10']."&ps_e=e";

?>