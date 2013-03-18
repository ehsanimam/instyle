<?php
	include("../common.php");
	//include("security.php");
	include 'top.php';

	if (isset($_POST['submit_new_group']) && $_POST['submit_new_group'])
	{
		$group_name = $_POST['group_name'];
		$group_desc = $_POST['group_desc'];
		$emails = $_POST['emails'];
		
		if ( empty($group_name) || empty($group_desc) || empty($emails))
		{
			echo '
				<script>
					window.location.href="manage_newsletter_group.php?action=add&err=1";
				</script>
			';
		}
		else
		{
			$q_ins = "INSERT INTO tbl_email_group (group_name,group_desc,emails) VALUES ('".$group_name."','".$group_desc."','".$emails."')";
			$r_ins = mysql_query($q_ins) or die('Insert error: '.mysql_error());

			echo '
				<script>
					window.location.href="manage_newsletter_group.php";
				</script>
			';
		}
	}
	
	if (isset($_GET['del']))
	{
		$q_del = "DELETE FROM tbl_email_group WHERE group_id = '".$_GET['del']."'";
		$r_del = mysql_query($q_del) or die('Delete error: '.mysql_error());
		
		echo '
			<script>
				window.location.href="manage_newsletter_group.php";
			</script>
		';
	}
?>
<script language="javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
	window.open(theURL,winName,features);
}
function goto_add_newsletter() {
	window.location.href="add_newsletter_step1.php";
}
function goto_edit_newsletter() {
	window.location.href="manage_newsletter.php";
}
function goto_manage_mail_group(param) {
	window.location.href="manage_newsletter_group.php?action="+param;
}
</script>

<table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor=cccccc>
<tr><td height="333" class="tab" align="center" valign="middle">

	<?php
	if (isset($_GET['action']) && $_GET['action'] == 'add')
	{
		$err = isset($_GET['err']) && $_GET['err'] == 1 ? '<span style="color:red;font-style:italic;">Please don\'t leave any form blank.</span>' : '';
		?>
		<br />
		<!--bof form============================================================================-->
		<form name="category" action="" method="post" enctype="MULTIPART/FORM-data">
		<table border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="cccccc">
		<tr><td>
		
			<center>
			<h1>ADD NEW GROUP</h1>
			<span class="text" style="display:block;"><?php echo isset($err) ? $err : ''; ?></span>
			</center>
			
			<br />
			<table border="0" cellspacing="2" cellpadding="2" width="700" align="center" >
				<col width="10%" />
				<col width="20%" style="background:#e1e1e1;" />
				<col width="55%" style="background:#e1e1e1;" />
				<col width="15%" />
				<tr>
					<td class="text"></td>
					<td class="text" style="text-align:right;padding-right:20px;">
						<label for="group_name">Group Name :</label>
					</td>
					<td class="text">
						<input type="text" name="group_name" size="40" style="border:1px solid #d1d1d1;width:373px;height:20px;" />
					</td>
				</tr>
				<tr>
					<td class="text"></td>
					<td class="text" style="text-align:right;padding-right:20px;">
						<label for="group_desc">Description :</label>
					</td>
					<td class="text">
						<input type="text" name="group_desc" size="40" style="border:1px solid #d1d1d1;width:373px;height:20px;" />
					</td>
				</tr>
				<tr>
					<td class="text"></td>
					<td class="text" style="text-align:right;padding-right:20px;">
						<label for="emails">Subscribers :</label><br />
						<span style="color:#717171;font-style:italic;">(comma separated email addresses)</span><br /><br />
						<span style="color:#990000;font-style:italic;">(set to 'All' for all subscribed users)</span><br /><br />
						<span style="color:#990000;font-style:italic;">(set to 'Wholesale' for all subscribed wholesale users only)</span><br /><br />
						<span style="color:#990000;font-style:italic;">(set to 'Consumer' for all subscribed non-wholesale users only)</span><br /><br />
					</td>
					<td class="text">
						<textarea name="emails" cols="40" row="5" style="border:1px solid #d1d1d1;width:373px;height:280px;"></textarea>
					</td>
					<td class="text" rowspan="3">
						<input type="submit" name="submit_new_group" value="Submit" />
					</td>
				</tr>
			</table>
			<br />
		
		</td></tr>
		</table>
		</form>
		<!--eof form============================================================================-->
		<?php
	}
	?>

	<br />
	<!--bof form============================================================================-->
	<form name="category" action="" method="post" enctype="MULTIPART/FORM-data">
    <table border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="cccccc">
	<tr><td>
	
		<center><h1>MANAGE NEWSLETTERS MAILING GROUP LIST</h1></center><br>
		
		<table border="0" cellspacing="2" cellpadding="2" width="700" align="center" >
			<col width="100" />
			<col />
			<col />
			<col width="60" />
			<tr height="30">
				<td class="text" style="background:#999"><b>Group Name</b></td>
				<td class="text" style="background:#999"><b>Description</b></td>
				<td class="text" style="background:#999"><b>Subscribers</b></td>
				<td class="text" style="background:#999"><b>Action</b></td>
			</tr>
			<?php
				$q = mysql_query("SELECT * FROM tbl_email_group");
				if(mysql_num_rows($q)) {
					while($r = mysql_fetch_array($q))
					{ ?>
						<tr>
							<td class="text" style="border-bottom:1px solid #efefef;"><?=$r['group_name']?></td>
							<td class="text" style="border-bottom:1px solid #efefef;"><?=$r['group_desc']?></td>
							<td class="text" style="border-bottom:1px solid #efefef;"><?=$r['emails']?></td>
							<td class="text" style="border-bottom:1px solid #efefef;">
								<a href="manage_newsletter_group.php?del=<?php echo $r['group_id']; ?>">Delete</a>
							</td>
						</tr>
						<?php
					}
				}
			?>
		</table>
	
	</td></tr>
	</table>
    </form>
	<!--eof form============================================================================-->
	
	<br />
	<input type="button" name="btn_add_newsletter" value="CREATE NEWSLETTER" style="margin:0 auto;" onclick="goto_add_newsletter()" />
	&nbsp;
	<input type="button" name="btn_add_newsletter" value="EDIT NEWSLETTER" style="margin:0 auto;" onclick="goto_edit_newsletter()" />
	&nbsp;
	<?php
	if ( ! isset($_GET['action']) OR $_GET['action'] != 'add')
	{ ?>
		<input type="button" name="btn_add_newsletter" value="ADD A GROUP" style="margin:0 auto;" onclick="goto_manage_mail_group('add')" />
		<?php
	} ?>
	<br /><br />
	
</td></tr>
</table>

<? include 'footer.php'; ?>