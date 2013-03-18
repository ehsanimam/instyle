<?php
	include("../common.php");
	include("security.php");
	include 'top.php';
	
	if (isset($_GET['del']))
	{
		$q_del = "DELETE FROM tbl_newsletter WHERE newsletter_id = '".$_GET['del']."'";
		$r_del = mysql_query($q_del) or die('Delete error: '.mysql_error());
		
		echo '
			<script>
				window.location.href="manage_newsletter.php";
			</script>
		';
	}
	
	if (isset($_POST['send_newsletter']))
	{
		$newsletter_id = $_POST['newsletter_id'];
		$group_id = $_POST['group_id'];
		
		// query newsletter
		$q_news = "SELECT * FROM tbl_newsletter WHERE newsletter_id = '".$newsletter_id."'";
		$r_news = mysql_query($q_news) or die('Select newsletter error: '.mysql_error());
		$news_row = mysql_fetch_array($r_news);
		
		// query group list email
		$q_group = "SELECT * FROM tbl_email_group WHERE group_id = '".$group_id."'";
		$r_group = mysql_query($q_group) or die('Select email group error: '.mysql_error());
		$group_row = mysql_fetch_array($r_group);
		
		if ($group_row['emails'] == 'All' OR $group_row['emails'] == 'Wholesale' OR $group_row['emails'] == 'Consumer')
		{
			if ($group_row['emails'] == 'All')
			{
				$q_emails = "SELECT email FROM tbluser_data UNION SELECT email from tbluser_data_wholesale";
			}
			else if ($group_row['emails'] == 'Wholesale')
			{
				$q_emails = "SELECT email FROM tbluser_data_wholesale";
			}
			else if ($group_row['emails'] == 'Consumer')
			{
				$q_emails = "SELECT email FROM tbluser_data";
			}
			
			$r_emails = mysql_query($q_emails) or die('Slect union error: '.mysql_error());
			$emails = mysql_fetch_array($r_emails);
			//$emails = array('rsbgm@innerconcept.com'); // ---> do not send to plenty yet
		}
		else
		{
			// explode comma sepaerate email addresses
			$emails = explode(',',$group_row['emails']);
		}
		
		while ($email = current($emails))
		{
			// trim possible whitespaces and hashing email for optout link
			$email = trim($email);
			$opt_out_email = md5(DEV1_EMAIL.'-'.$email);
			
			// append message with optout link
			$msg_content = '
			<table id="wrapper" border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#333333;">
			<tr><td align="center">
			
				<table id="container" border="0" cellpadding="0" cellspacing="0" width="660" style="background:#efefef;">
					<tr>
						<td id="top_notice" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;background:#333333;padding:10px 20px;">
							If you are unable to see this message, <a href="'.str_replace('https','http',SITE_URL).'newsletter/'.$newsletter_id.'/'.$opt_out_email.'" style="color:white;">Click here</a> to view.<br />
							To ensure delivery to your inbox, please add info@instylenewyork.com to your address book. 
						</td>
					</tr>
			';
			$msg_content .= $news_row['message'];
			$msg_content .= '
					<tr>
						<td id="bottom_notice" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;background:#333333;padding:10px 20px 20px 20px;">
							To adjust your email preferences or to unsubscribe from email advertisements from '.SITE_DOMAIN.', please <a href="'.SITE_URL.'register/opt_out/'.$opt_out_email.'" style="color:white;">Click here</a>.<br />
							'.SITE_NAME.', 230 West 38th Street, New York, NY 10018
						</td>
					</tr>
					
				</table> <!--#container-->
			
			</td></tr>
			</table> <!--#wrapper-->
			';
			
			if ($_SERVER['SERVER_NAME'] === 'localhost')
			{
				require("../phpscript/phpmailer/class.phpmailer.php"); // add this pages where email sending is used
				
				$mail = new PHPMailer();
				
				include("../phpscript/phpmailer/phpmailer_config.php");

				$mail->From = INFO_EMAIL;    //From Address -- CHANGE --
				$mail->FromName = SITE_NAME;    //From Name -- CHANGE --
				$mail->AddAddress($email);    //To Address -- CHANGE --
				$mail->AddReplyTo(INFO_EMAIL, SITE_NAME); //Reply-To Address -- CHANGE --

				$mail->WordWrap = 80;    // set word wrap to 50 characters
				$mail->IsHTML(true);    // set email format to HTML

				$mail->Subject = $news_row['subject'];
				$mail->Body    = $msg_content;

				if(!$mail->Send())
				{
				   echo "Message could not be sent. <p>";
				   echo "Mailer Error: " . $mail->ErrorInfo;
				   exit;
				}

				echo "Message has been sent";
			}
			else
			{
				require("../phpscript/phpmailer/class.phpmailer.php"); // add this pages where email sending is used
				
				$mail = new PHPMailer();
				
				include("../phpscript/phpmailer/phpmailer_config.php");

				$mail->From = INFO_EMAIL;    //From Address -- CHANGE --
				$mail->FromName = SITE_NAME;    //From Name -- CHANGE --
				$mail->AddAddress($email);    //To Address -- CHANGE --
				$mail->AddReplyTo(INFO_EMAIL, SITE_NAME); //Reply-To Address -- CHANGE --

				$mail->WordWrap = 80;    // set word wrap to 50 characters
				$mail->IsHTML(true);    // set email format to HTML

				$mail->Subject = $news_row['subject'];
				$mail->Body    = $msg_content;

				if(!$mail->Send())
				{
				   echo "Message could not be sent. <p>";
				   echo "Mailer Error: " . $mail->ErrorInfo;
				   exit;
				}

				echo "Message has been sent";
			}
			
			next($emails);
		}
		
		echo '
			<script>
				window.location.href="manage_newsletter.php?msg=1";
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
function goto_manage_mail_group() {
	window.location.href="manage_newsletter_group.php";
}
function r_u_sure() {
	var r = confirm("Are you sure you want to delete the newsletter?");
	if (r == true) {
		return true;
	} else {
		return false;
	}
}
</script>

<table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor=cccccc>
<tr><td height="333" class="tab" align="center" valign="middle">

	<?php
	if (isset($_GET['send_nl']))
	{
		// The Query
		$q_nl = "
			SELECT 
				tn.*, tn.group_id as group_id,
				teg.*
			FROM 
				tbl_newsletter tn
			LEFT JOIN 
				tbl_email_group teg
				ON teg.group_id = tn.group_id
			WHERE 
				tn.newsletter_id = '".$_GET['send_nl']."'
		";
		$r_nl = mysql_query($q_nl) or die('Select error: '.mysql_error());
		$nl_row = mysql_fetch_array($r_nl);
		?>
		
		<br />
		<!--bof form============================================================================-->
		<form action="manage_newsletter.php" method="post" enctype="MULTIPART/FORM-data">
		<input type="hidden" name="newsletter_id" value="<?php echo $_GET['send_nl']; ?>" />
		<table border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="cccccc">
		<tr><td>
		
			<center>
			<h1>SEND NEWSLETTER</h1>
			<span class="text" style="display:block;"><?php echo isset($err) ? $err : ''; ?></span>
			</center>
			
			<br />
			<table border="0" cellspacing="2" cellpadding="2" width="700" align="center" >
				<col width="9%" />
				<col width="20%" style="background:#e1e1e1;" />
				<col width="55%" style="background:#e1e1e1;" />
				<col width="16%" />
				<tr height="30">
					<td class="text"></td>
					<td class="text" style="text-align:right;padding-right:20px;">Newsletter Title :</td>
					<td class="text"><?php echo $nl_row['title']; ?></td>
				</tr>
				<tr height="30">
					<td class="text"></td>
					<td class="text" style="text-align:right;padding-right:20px;">Subject :</td>
					<td class="text"><?php echo $nl_row['subject']; ?></td>
				</tr>
				<tr height="30">
					<td class="text"></td>
					<td class="text" style="text-align:right;padding-right:20px;">Send to :</td>
					<td class="text">
						<select name="group_id">
							<option>- select group -</option>
							<?php
							// query the group list
							$q_gl = "SELECT * FROM tbl_email_group";
							$r_gl = mysql_query($q_gl) or die('Select error: '.mysql_error());
		
							while ($gl_row = mysql_fetch_array($r_gl))
							{
								$selected = ($gl_row['group_id'] == $nl_row['group_id']) ? 'selected="selected"' : '';
								?>
								<option value="<?php echo $gl_row['group_id']; ?>" <?php echo $selected; ?>><?php echo $gl_row['group_name']; ?></option>
								<?php
							}
							?>
						</select>
					</td>
					<td class="text" rowspan="3">
						<input type="submit" name="send_newsletter" value="Send" />
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
	
	if (isset($_GET['msg']))
	{
		if ($_GET['msg'] == 1)
		{
			echo '<br /><span class="text" style="font-weight:bold;color:red;display:block;">Newsletter has been sent to mailing list.</span>';
		}
	}
	?>

	<br />
	<!--bof form============================================================================-->
	<form name="category" action="" method="post" enctype="MULTIPART/FORM-data">
    <table border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="cccccc">
	<tr><td>
	
		<center><h1>MANAGE NEWSLETTERS</h1></center><br>
		
		<table border="0" cellspacing="2" cellpadding="2" width="700" align="center" >
			<tr>
			<td class="text" width="30" style="background:#999"><b>ID</b></td>
			<td class="text" style="background:#999"><b>Title</b></td>
			<td class="text" style="background:#999"><b>Subject</b></td>
			<td class="text" style="background:#999"><b>Send To Group</b></td>
			<td class="text" style="background:#999"><b>Send Date</b></td>
			<td class="text" style="background:#999"><b>Status</b></td>
			<td class="text" width="60" style="background:#999"><b>Action</b></td></tr>
			<?php
			// The Query
			$q = mysql_query("
				SELECT 
					tn.*, tn.group_id as group_id,
					teg.*
				FROM tbl_newsletter tn
				LEFT JOIN tbl_email_group teg
					ON teg.group_id = tn.group_id
				ORDER BY 
					tn.status DESC, 
					tn.datesend DESC
			") or die('Query error: '.mysql_error());
			
			if (mysql_num_rows($q))
			{
				while ($r = mysql_fetch_array($q))
				{
					$exp_now = explode('/',@date('m/d/Y',time()));
					$time_now = @mktime(0,0,0,$exp_now[0],$exp_now[1],$exp_now[2]);
					if ($r['datesend'] != '' && $r['datesend'] != NULL)
					$time_db = $r['datesend'];
					else $time_db = '';
					$pending = $time_db < $time_now ? 'Not sent' : 'Pending';
					?>
					<tr>
					<td class="text" style="border-bottom:1px solid #efefef;"><?=$r['newsletter_id']?></td>
					<td class="text" style="border-bottom:1px solid #efefef;"><?=$r['title']?></td>
					<td class="text" style="border-bottom:1px solid #efefef;"><?=$r['subject']?></td>
					<td class="text" style="border-bottom:1px solid #efefef;"><?=$r['group_name']?></td>
					<td class="text" style="border-bottom:1px solid #efefef;"><?php echo date('Y/m/d',$r['datesend']); ?></td>
					<td class="text" style="border-bottom:1px solid #efefef;"><?php echo $r['status'] == 1 ? 'Sent' : $pending; ?></td>
					<td class="text" style="border-bottom:1px solid #efefef;">
						<a href="javascript:void(0);" onClick="MM_openBrWindow('<?php echo SITE_URL; ?>newsletter/<?=$r['newsletter_id']?>/view','','width=800,height=700,scrollbars=yes')">View</a><br />
						<a href="edit_newsletter.php?n_id=<?=$r['newsletter_id']?>">Edit</a><br />
						<a href="manage_newsletter.php?del=<?php echo $r['newsletter_id']; ?>" onclick="return r_u_sure()">Delete</a><br />
						<a href="manage_newsletter.php?send_nl=<?php echo $r['newsletter_id']; ?>">Send Now</a>
					</td>
					</tr>
					<?php
				}
			} ?>
		</table>
	
	</td></tr>
	</table>
    </form>
	<!--eof form============================================================================-->
	
	<br />
	<input type="button" name="btn_add_newsletter" value="CREATE NEWSLETTER" style="margin:0 auto;" onclick="goto_add_newsletter()" />
	&nbsp;
	<input type="button" name="btn_add_newsletter" value="CREATE MAILING GROUP" style="margin:0 auto;" onclick="goto_manage_mail_group()" />
	<br /><br />
	
</td></tr>
</table>

<? include 'footer.php'; ?>