<?php
	include("../common.php");
	
	if (isset($_POST['delete_from_csv']))
	{
	for ($ii = 1; $ii <= $_POST['last_i']; $ii++)
		{
			$content = $_POST['index_'.$ii.'_0'];
			
			$delete_user_data="delete from tbluser_data where email='".trim($content)."'";
			mysql_query($delete_user_data);
			
			$delete_user="delete from tbluser where e_mail='".trim($content)."'";
			mysql_query($delete_user);
		}
		
		echo "Users Successfully Deleted";
	}	
?>

<title><?php echo SITE_NAME; ?> :: Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td class="tab" align="center" valign="middle" style="padding: 10px 2px;">

	<table width=95% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
    <tr><td align=center class="error"></td></tr>
	<tr><td align="center">
	
					
		
		<!--bof form============================================================================-->
		<form name="form_edit_csv" action="remove_bounce_email_newsletter.php" method="POST">
		
			<?php
			
			// declare variable to count records
			$rowcount = 0;

			$path_to_file = "bounced_email.csv";
			
			if (file_exists($path_to_file))
			{
				// create table with header and column names
				print('<table width=100% align=center cellspacing=1 cellpadding=0>');
				print('<tr bgcolor=cccccc><td colspan="20" align="center" style="vertical-align:middle; height:30px;"><h1>Bounced Email Address</h1></td></tr>');
				print('<tr bgcolor=cccccc>
						<td style="vertical-align:middle;"><h1>Email Address</h1></td>
						</tr>');

				// open file for reading "r"
				$filecontents = file($path_to_file,FILE_IGNORE_NEW_LINES); // ----> file() returns an array of the file on a per line basis
				
				//read file line by line.
				for ($i = 0; $i < sizeof($filecontents); $i++) // ----> sizeof() is an alias of count()
				{
					if ($i == 0)
					{
						$fields = $filecontents[0];
					}
					else
					{
						$record = explode(",", $filecontents[$i]); // ----> exploding each comma separated line
					
						//read field values in variable

						$email = trim($record[0]);
						

						//skipped the first record since it has field headers only
						print('
						<tr>
							<td class="text"><input type="text" class="csvinputbox" name="index_'.$i.'_0" value="'.$email.'" style="width:200px;"/></td>
							
						</tr>
						');
					}
				}
				print('</table>');
				?>
				<br />
				<input type="hidden" name="last_i" value="<?php echo (sizeof($filecontents) - 1); ?>" />
				<input type="submit" name="delete_from_csv" value="Delete from CSV" /> 
				
				<br /><br />
				<?php
			}
			
			?>
		</form>
		<!--eof form============================================================================-->
		
	</td></tr>
	</table>
	
</td></tr>
</table>
<? include 'footer.php';