<?php
	include("../common.php");
	//include("security.php");

	if(isset($_POST['btnsave']))
	{
		$title 	  = str_replace("'","\'",$_POST['title']);
		$subject  = str_replace("'","\'",$_POST['subject']);
		$datesend = $_POST['datesend'];
		$group_id = $_POST['group_id'];	
		$message  = $_POST['message'];
	 
		if (empty($title) || empty($subject) || empty($datesend) || empty($group_id))
		{
			header("location:edit_newsletter.php?n_id=".$_GET['n_id']."&err=Please complete all entries");
		}
		else
		{
			@mysql_query("
				UPDATE tbl_newsletter
				SET
					title = '".$title."',
					subject = '".$subject."',
					datesend = '".strtotime($datesend)."',
					group_id = '".$group_id."',
					message = '".$message."'
				WHERE
					newsletter_id = '".$_GET['n_id']."'
			") or die('Update error: '.mysql_error());
			//$n_id = mysql_insert_id();
		}
	 
		header("location:manage_newsletter.php");
	}
	include 'top.php'; 

	$get_n = mysql_fetch_array(mysql_query("SELECT * from tbl_newsletter WHERE newsletter_id='".$_GET['n_id']."'"));
	
	/*
	| ----------------------------------------------------
	| The dynamic top and bottom links (just add to message)
	*/
			$top_links = '
				<table id="wrapper" border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#333333;">
				<tr><td align="center">
				
					<table id="container" border="0" cellpadding="0" cellspacing="0" width="660" style="background:#efefef;">
						<tr>
							<td id="top_notice" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;background:#333333;padding:10px 20px;">
								If you are unable to see this message, <a href="'.str_replace('https','http',SITE_URL).'newsletter/'.$n_id.'/view" style="color:white;">Click here</a> to view.<br />
								To ensure delivery to your inbox, please add info@instylenewyork.com to your address book. 
							</td>
						</tr>
			';
			$btm_links = '
						<tr>
							<td id="bottom_notice" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;background:#333333;padding:10px 20px 20px 20px;">
								To adjust your email preferences or to unsubscribe from email advertisements from '.SITE_DOMAIN.', please <a href="'.str_replace('https','http',SITE_URL).'newsletter/'.$n_id.'/view" style="color:white;">Click here</a>.<br />
								'.SITE_NAME.', 230 West 38th Street, New York, NY 10018
							</td>
						</tr>
						
					</table> <!--#container-->
				
				</td></tr>
				</table> <!--#wrapper-->
			';
?>
<!-- firebug lite -->
<script type="text/javascript" src="firebug/firebug.js"></script>

<!-- jQuery -->



<!-- required plugins -->
<script type="text/javascript" src="../jscript/date.js"></script>
<!--[if lt IE 7]><script type="text/javascript" src="scripts/jquery.bgiframe.min.js"></script><![endif]-->

<!-- jquery.datePicker.js -->
<script type="text/javascript" src="../jscript/jquery.datePicker.js"></script>

<!-- datePicker required styles -->

<link rel="stylesheet" type="text/css" media="screen" href="../style/datePicker.css">

<!-- page specific scripts -->
<script type="text/javascript" charset="utf-8">
	$(function()
	{
		$('.date-pick').datePicker({autoFocusNextInput: true});
	});
</script>

<table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor=cccccc>
<tr><td height="333" class="tab" align="center" valign="middle">

	<!--bof form===================================================================-->
	<form name="category" action="" method="post" enctype="MULTIPART/FORM-data">
    <table border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="cccccc">
	<tr><td>
		<table border="0" cellspacing="2" cellpadding="2" width="800" align="center" >
			<tr bgcolor=cccccc><td align=center colspan=2><h1>EDIT NEWSLETTER</h1></td></tr>
			<tr><td align=center colspan=2 class="error"><? echo isset($_GET['err']) ? $_GET['err'] : ''; ?></td></tr>
			<tr>
				<td class="text" style="width:150px;">Title</td>
				<td><input class="inputbox" type="text" name="title" style="width:300px;" value="<?=$get_n['title']?>"></td>
			</tr>
			<tr>
				<td class="text">Subject</td>
				<td><input class="inputbox" type="text" name="subject" style="width:300px;" value="<?=$get_n['subject']?>"></td>
			</tr>
			<tr>
				<td class="text">Schedule date</td>
				<td class="text"><input value="<?=date('Y/m/d',$get_n['datesend'])?>" maxlength="" name="datesend" id="date1" class="date-pick" style="width:100px;background:#f0f0f0; border: 1px solid #999999; font-family: Arial; font-size: 11px; color:#666666; margin-right:5px;" /></td>
			</tr>
			<tr>
				<td class="text">User Group</td>
				<td class="text">
					<select name="group_id" class="inputbox">
						<option value="">- select group -</option>
						<?php
						$get_group = mysql_query("select * from tbl_email_group");
						if (mysql_num_rows($get_group) > 0)
						{
							while ($grow = mysql_fetch_array($get_group))
							{ ?>
								<option value="<?=$grow['group_id']?>" <?php echo $get_n['group_id'] == $grow['group_id'] ? 'selected' : ''; ?>><?=$grow['group_name']?></option>
								<?php
							}
						} ?>
					</select>
				</td>
			</tr>
			<tr><td colspan="2">
				<textarea id="textarea_pages" name="message" style="width:800px;" rows="25"><?php echo $get_n['message'];?></textarea>
			</td></tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value=" Save " class="tab" name="btnsave">
				
				</td>
				
			</tr>
		</table>
	</td></tr>
	</table>
    </form>
	<!--eof form===================================================================-->
	
</td></tr>
</table>
<? include 'footer.php'; ?>