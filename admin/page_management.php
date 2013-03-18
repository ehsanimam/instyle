<?php
	include("../common.php");
	
	/*
	| ---------------------------------------------------------------------------
	| This file enables editing of content of the following pages:
	| Oredring, Return Policy, Shipping, Privacy Notice, Order Status, FAQ
	|
	| This file is self serving the form choices and should initially check for
	| varialbes set at the uri.
	|
	*/
	// The title of THIS page and other defaults
	define('PAGE_TITLE', 'Page Management');
	$db = 'pages';
	
	/*
	*---------------------------------------------------------------------
	* Process the uri strings if any
	*
	*/
	// Get uri string
	if ($_REQUEST['page'] && $_REQUEST['page'] != '')
	{
		$page = $_REQUEST['page'];
	}
	
	if (isset($_REQUEST['action']) && $_REQUEST['action'] != '')
	{
		$action = $_REQUEST['action'];
	}
	
	if (isset($_REQUEST['bb']) && $_REQUEST['bb'] != '' && $_REQUEST['bb'] == '1')
	{
		$query = "SELECT * FROM ".$db." WHERE title_code = '".$page."'";
		$result = mysql_query($query);
		
		if (mysql_num_rows($result) > 0)
		{
			$row = mysql_fetch_array($result);
		}
		// check if it is index page 
		if($_REQUEST['page'] == 'index_page')
		{
			$notice = 'Text file is updated!&nbsp; View <a href="http://www.instylenewyork.com">page</a>';
		}
		else
		{
			$notice = 'Text file is updated!&nbsp; View <a href="http://www.instylenewyork.com/p'.$row['page_id'].'/'.$page.'.html">page</a>';
		}
	}
	
	/*
	*---------------------------------------------------------------------
	* DATABASE functions per action reference
	*
	*/
	// Update to database
	if (isset($action) && $action == 'update')
	{
		$query = "UPDATE ".$db." SET text = '".str_replace("'","\'",$_POST['new_text'])."' WHERE title_code = '".$page."'";
		$result = mysql_query($query) or die (mysql_error());
		header("Location: page_management.php?page=".$page."&bb=1");
	}
	
	include 'top.php';
	
	/*
	| ---------------------------------------------------------------------------
	| Start html code
	|
	*/
?>
	
	<title><?php echo PAGE_TITLE; ?> :: Admin Section</title>
	<link href="style.css" rel="stylesheet" type="text/css">
		
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr><td height="300" class="tab" align="center" valign="middle">

		<table style="outline:1px solid #787878;margin: 10px 0 10px;width: 80%;">
			
			<?php
			// Check if page is in the database
			$query = "SELECT * FROM ".$db." WHERE title_code = '".$page."'";
			$result = mysql_query($query);
			
			if (mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result);
	
				/*
				| ------------------------------------------------------------------------------
				| View mode
				| ------------------------------------------------------------------------------
				*/ ?>
				<tr bgcolor=cccccc valign="middle" height="35"><td align=center><h1>
				<?php 	
				if(stristr($page,'wholesale')) 
					echo 'WHOLESALE '; 
				else if(stristr($page,'index')) 
					echo 'INDEX '; 
				else 
					echo 'RETAIL '; 
								
				echo PAGE_TITLE; ?> :: Edit</h1></td>
				</tr>
				
				<tr height="25"><td></td></tr>
				
				<tr><td align="center">
				
					<h1 style="width: 80%;text-align: left;"><strong>&nbsp; &nbsp; Page:&nbsp; &nbsp; <?php echo $row['title']; ?></strong></h1>
					
				</tr></td>
				<tr height="20"><td></td></tr>
						<tr><td align="center" class="text">
							<?php
							if (isset($notice))
							{
								/*-html output-*/
								echo '<table style="outline:1px solid #F69679;margin: 5px 0 5px;width: 60%;font-size:bold;color:red;text-align: center;"><tr><td>';
									echo '<p>'.$notice.'</p>';
								echo '</td></tr></table><br />';
							} ?>
						</td></tr>
				<tr><td align="center">
				
					<form action="page_management.php?page=<?php echo $page; ?>&action=update" method="POST">
						<textarea id="textarea_pages" name="new_text"><?php echo $row['text']; ?></textarea>
						<br />

				</tr></td>
				<tr><td width="50%" align="right" style="padding: 0 11%;">
				
						<input type="submit" name="submit" value="Update" />
						<br /><br />
					</form>
				</tr></td>
				<tr><td>
				
				</tr></td>
				<tr><td>
				
					<p class="text">
						<em>&nbsp; NOTE:
						<br />&nbsp; If you need to include an image from the server, you should include the full url/path to the image.
						<br />&nbsp; If you're uploading image, 'Upload' it first before clicking 'Submit' to insert to the document.</em>
					<p>
					
				<tr><td>
				<tr><td>
				
					<table style="min-width: 600px;"><tr><td></td></tr></table>
					
				</tr></td>
				<?php
			}
			else
			{
				/*
				| ------------------------------------------------------------------------------
				| Error in view mode (string on uri is not authorized)
				| ------------------------------------------------------------------------------
				*/
				echo '<tr><td class="text">';
				echo '<p><img src="../images/red_camp.gif" alt="error" style="vertical-align:middle;" /> &nbsp; The page you are lookig for is not found!</p>';
				echo '</td></tr>';
			} ?>
		</table>
	</td></tr>
	</table>

<?php	
	include 'footer.php';

/* End of file - page_management.php */
/* Location: ./admin/page_management.php */