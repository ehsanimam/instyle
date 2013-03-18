<?php
	include("../common.php");
	include("security.php");
	
	if(isset($_POST['add_step1']))
	{
		$title 	  = str_replace("'","\'",$_POST['title']);
		$subject  = str_replace("'","\'",$_POST['subject']);
		$datesend = $_POST['datesend'];
		$group_id = $_POST['group_id'];
		
		if (empty($title) || empty($subject) || empty($datesend) || empty($group_id))
		{
			header("location:add_newsletter_step1.php?err=Please complete all entries");
		}
		else
		{
			@mysql_query("insert into tbl_newsletter (title,subject,datesend,group_id) values ('".$title."','".$subject."','".strtotime($datesend)."','".$group_id."')") or die('Insert error: '.mysql_error());
			$n_id = mysql_insert_id();
		}
	 
		if (mysql_affected_rows() > 0)
		{
		   header("location:add_newsletter_step2.php?n_id=".$n_id);
		}
	}
	
	include 'top.php'; 
?>
<!-- firebug lite -->
<script type="text/javascript" src="firebug/firebug.js"></script>

<!-- jQuery -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>

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

	<!--bof form============================================================================-->
	<form name="category" action="" method="post" enctype="MULTIPART/FORM-data">
    <table border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="cccccc">
	<tr><td>
	
		<table border="0" cellspacing="2" cellpadding="2" width="500" align="center" >
			<tr bgcolor=cccccc><td align=center colspan=2><h1>ADD NEWSLETTER - STEP 1 : BASIC INFORMATION</h1></td></tr>
			<tr><td align=center colspan=2 class="error"><? echo isset($_GET['err']) ? $_GET['err'] : ''; // first edit ?></td></tr>
			<tr>
				<td class="text" style="width:150px;">Title</td>
				<td><input class="inputbox" type="text" name="title" style="width:300px;"></td>
			</tr>
			<tr>
				<td class="text">Subject</td>
				<td><input class="inputbox" type="text" name="subject" style="width:300px;"></td>
			</tr>
			<tr>
				<td class="text">Schedule date</td>
				<td class="text"><input maxlength="0" name="datesend" id="date1" class="date-pick" style="width:100px;background:#f0f0f0; border: 1px solid #999999; font-family: Arial; font-size: 11px; color:#666666; margin-right:5px;" /></td>
			</tr>
			<tr>
				<td class="text">User Group</td>
				<td class="text">
					<select name="group_id" class="inputbox">
						<option value="">- select group -</option>
						<?php
							$get_group = mysql_query("select * from tbl_email_group");
							if(mysql_num_rows($get_group)>0) {
								while($grow = mysql_fetch_array($get_group )) {
									?>
									<option value="<?=$grow['group_id']?>"><?=$grow['group_name']?></option>
									<?php
								}
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value=" Save " class=tab name="add_step1">
				
				</td>
				
			</tr>
		</table>
		
	</td></tr>
	</table>
    </form>
	<!--eof form============================================================================-->
	
</td></tr>
</table>
<? include 'footer.php'; ?>