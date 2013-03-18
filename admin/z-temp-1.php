<?php
	include("httpdocs/common.php");

	mysql_query("UPDATE tbluser_data SET is_active = '1'") or die(mysql_error());
	
	echo 'Done';