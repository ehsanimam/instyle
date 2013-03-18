<?php
	include("../common.php");
	include("security.php"); 
	$_SESSION['letter'] = '';
?> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo strtoupper(SITE_NAME); ?> - NEWS LETTER LIST</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="sample.css" />
</head>
<body>
	<h1>
		<?php echo strtoupper(SITE_NAME); ?> - NEWS LETTER LIST
	</h1>
	
<table>
<tr>
	<td  valign="top">

		<!--bof form===========================================================================-->
		<form action="" method="post" enctype="multipart/form-data">
		<?php
		if (isset($_POST['xemail']) && ( ! empty($_POST['femail'])))
		{
			$nl_id = $_POST['chkActive'];
			$to = $_POST['femail'];
			
			$q2 = "SELECT * FROM newsletter WHERE id = '".$nl_id."'";
			$r2 = mysql_query($q2) or die ('Select error: '.mysql_error());
			$s2 = mysql_fetch_array($r2);
			
			$subject = $s2['subject'];
			$from = $s2['efrom'];
			$message = $s2['Content'];
			$message = str_replace("&lt;", "<", $message);
			$message = str_replace("&gt;", ">", $message);
			$headers = "From: ".$from."" . "\r\n";
			$headers .= "Content-type: text/html\r\n";
			//echo '>>#-->'.$to.':'.$message.':'.$subject; die();
			
			mail($to, $subject, $message, $headers);
		}
		
		if (isset($_POST['delete']))
		{
			$nl_id = $_POST['chkActive'];
			$q_del = "DELETE FROM newsletter WHERE id = '".$nl_id."'";
			$q_res = mysql_query($q_del) or die ("Delete error: ".mysql_error());
			
			$q_sel = "SELECT MAX(id) FROM newsletter";
			$sel_res = mysql_query($q_sel) or die ("Select error ".mysql_error());
			$r1 = mysql_fetch_array($sel_res);
			
			$q_upd = "UPDATE newsletter SET send = '1' WHERE id = '".$r1['MAX(id)']."'";
			$upd_res = mysql_query($q_upd) or die ("Update error ".mysql_error());
		}

		if (isset($_POST['reset']))
		{
			if (isset($_POST['chkActive']))
			{
				$chkActive = $_POST['chkActive'];
				$strExtr = "";
				$qcolls = "update newsletter set send='0'";
				mysql_query($qcolls);
				$VardlerID = $chkActive;
				//echo '>>'.$VardlerID;
				$qcolls = "update newsletter set send='1' where id=$VardlerID";
				mysql_query($qcolls);
				$helper = "SELECT id,title,subject,efrom,content from newsletter where id='$VardlerID' and send='1'" ;
				$aobj = mysql_query($helper);
				$a = mysql_fetch_array($aobj);
				$msg = $a['content'];
				$id = $a['id'];
				$subject = $a['subject'];
				$from = $a['efrom'];
				$title = $a['title'];
				$_SESSION['content'] = $msg;
				$_SESSION['id'] = $msg;
				//echo 'msg is:'.$msg;
			}
		}
	  
		if (isset($_POST['xedit']))
		{
			if (isset($_POST['chkActive']))
			{
				$chkActive = $_POST['chkActive'];
				$count = count($chkActive);
				$strExtr = "";
				$qcolls = "update newsletter set send='0'";
				mysql_query($qcolls);
				
				for ($i = 0; $i < $count; $i++)
				{
					$VardlerID = $chkActive[$i];
					$qcolls = "Select id,title,subject,efrom,send,content from newsletter where id='$VardlerID'";
					
					if ($result = mysql_query($qcolls));
					{
						$num = mysql_numrows($result);
						$i = 0;
						$content = mysql_result($result,$i,"content");
					}
				}
			}
		}

		echo '<p>NEWSLETTERS</p>';
		echo '
			<table style="border: 1px solid #D4E099">
				<tr>

					<td bgcolor="#9999DD" align="center" width="25"> <strong>TITLE</strong></td>
					<td bgcolor="#9999DD" align="center" width="25"><strong>SUBJECT</strong></td>
					<td bgcolor="#9999DD" align="center" width="25"><strong>FROM</strong></td>
					<td bgcolor="#9999DD" align="center" width="20"><strong>-</strong></td>

				</tr>
		';

		$qcolls = "SELECT id,title,subject,efrom,send,content FROM newsletter";
		// echo '-1-';
		if ($result = mysql_query($qcolls));
		{
			$num = mysql_numrows($result);
			
			if ($num > 0)
			{
				$i = 0;
				while ($i < $num)
				{
					$nl_id = mysql_result($result,$i,"id");
					$title = mysql_result($result,$i,"title");
					$subject = mysql_result($result,$i,"subject");
					$from = mysql_result($result,$i,"efrom");
					$id = mysql_result($result,$i,"id");
					$send = mysql_result($result,$i,"send");
					$content = mysql_result($result,$i,"content");
					
					echo '<tr><td>' . $id.':'. $title. '</td><td>' .$subject.'</td> <td>' . $from .'</td>';
					if ($send == 1)
					{
						echo '<td><input type="radio" value="' . $id .'" name="chkActive" checked  ></td>';
						$_SESSION['subj'] = $subject;
						$_SESSION['from'] = $from;
						$_SESSION['cont'] = $content;
						$msg = $content;
						$nid = $nl_id;
					}
					else
					{
						echo '<td><input type="radio" value="' . $id .'" name="chkActive" ></td>';
					}
					
					echo '</tr>';				
					$i++;
				}		
			}  //if cnt>0
		}// if there is	
	  
		echo '</table>'
		?>

		<input name="reset" type="submit" id="reset"  value="Use Selected Newsletter" />
		&nbsp;
		<input name="delete" type="submit" id="delete"  value="Delete Newsletter" />
	   
		<p><b>To test selected newsletter, send newsletter to (email):</b><br />
		<input type="text" name="femail"  size="26" /></p>
		<input name="xemail" type="submit" id="xemail" value="Send Email" />
		</form>
		<!--eof form===========================================================================-->
		
		<a href="ckeditor/_samples/nleditor.php?xmode=0">CREATE NEW NEWSLETTER</a>
		<a href="ckeditor/_samples/nleditor.php?xmode=1&nid=<?php echo $nid; ?>">EDIT NEWSLETTER</a>
		<br /><br />
		<a href="admin_home.php">back to main admin menu</a>
		
	</td>
	<td style="padding-left:50px;">
		<?php
		if (isset($msg) && $msg) echo 'Current NewsLetter is:'.$msg;
		else echo 'No Newsletter is selected.';
		?>
	</td>
</tr>
</table>

</body>
</html>
