<?php
if ( ! isset($_SESSION['session_admin']) OR (isset($_SESSION['session_admin']) && $_SESSION['session_admin'] !== session_id()))
{
	header("Location: ./");
	exit;
}

