<?php
	session_start();
	include("../common.php");
	include 'top.php';
	
	/*
	| ---------------------------------------------------------------------------
	| This file simply activates the 'LIVE CHAT' link at home page
	|
	*/
	// The title of THIS page and other defaults
	define('PAGE_TITLE', 'Activate Live Chat');
	
	/*
	*---------------------------------------------------------------------
	* Process the uri strings if any
	*
	*/
	// Get uri string
	if ($_REQUEST['action'] && $_REQUEST['action'] != '')
	{
		$action = $_REQUEST['action'];
	}
	
	$filename = '../chat_link.txt';
	if (file_exists($filename))
	{
		if ($action == '')
		{
			$handle_file = fopen($filename,'rb');
			$content = fread($handle_file,10);
			fclose($handle_file);
			$chat_link_status = $content;
		}
		else if ($action == 'Activate')
		{
			$handle_file = fopen($filename,'wb');
			fwrite($handle_file,'activated');
			$handle_file = fopen($filename,'rb');
			$content = fread($handle_file,10);
			fclose($handle_file);
			$chat_link_status = $content;
		}
		else if ($action == 'Disable')
		{
			$handle_file = fopen($filename,'wb');
			fwrite($handle_file,'disabled');
			$handle_file = fopen($filename,'rb');
			$content = fread($handle_file,10);
			fclose($handle_file);
			$chat_link_status = $content;
		}
	}
	else
	{
		$chat_link_status = ' - ';
	}
	
	/*
	| ---------------------------------------------------------------------------
	| Start html code
	|
	*/ ?>
	
	<title><?php echo PAGE_TITLE; ?> :: Admin Section</title>
	<link href="style.css" rel="stylesheet" type="text/css">
		
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr><td height="300" class="tab" align="center" valign="middle">

		<table style="outline:1px solid #787878;margin: 10px 0 10px;width: 80%;">
			
			<tr bgcolor=cccccc valign="middle" height="35"><td align=center><h1><?php echo PAGE_TITLE.'&nbsp; :: &nbsp;'.ucfirst($chat_link_status); ?></h1></td></tr>
			
			<tr height="25"><td></td></tr>
			
			<tr><td align="center">
			
				<table width="60%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
					<tr><td style="">
			
					<h1 style="float: left;"><strong>&nbsp; Live Chat link at home page:&nbsp; &nbsp; <?php if ($chat_link_status == 'activated') echo '<em>now '.ucfirst($chat_link_status).'</em>'; else echo ucfirst($chat_link_status); ?></strong></h1>

					<form action="activate_live_chat.php" method="POST" style="float: right;">
						<input type="submit" name="action" value="<?php if ($chat_link_status == 'activated') echo 'Disable'; else echo 'Activate'; ?>" style="width: 100px;" />
					</form>
					
					</tr></td>
				
				</table>
				
			<tr><td>
		
			</tr></td>
			<tr><td>
		
				<table style="min-width: 600px;height: 25px;"><tr><td></td></tr></table>
				
			</tr></td>
		</table>
	</td></tr>
	</table>

<?php	
	include 'footer.php';

/* End of file - page_management.php */
/* Location: ./admin/page_management.php */