<?php

if ($_SERVER['SERVER_NAME'] === 'localhost')
{
	$DBHost = 'localhost';
	$DBUsername = 'root';
	$DBPassword = 'root';
	$DBDatabase = 'db_instyle';
}
else
{
	$DBHost = 'localhost';
	$DBUsername = 'verjel';
	$DBPassword = 'icmstudio';
	$DBDatabase = 'verjel_instyle';
}

?>