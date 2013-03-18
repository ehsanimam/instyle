<?php
	include("../common.php");
	include("security.php");
	require_once("../phpscript/phpmailer/class.phpmailer.php"); // add this pages where email sending is used
	
	define('USER_TYPE','inactive_wholesale');
	
	// check for msg notification
	if (isset($_GET['msg']))
	{
		if ($_GET['msg'] == 1)
		{
			$sql_msg1 = "SELECT * FROM tbluser_data_wholesale WHERE email = '".$_GET['eid']."'";
			$res_msg1 = mysql_query($sql_msg1) or dir ("Select error: ".mysql_error());
			$row_msg1 = mysql_fetch_array($res_msg1);
			$name = $row_msg1['firstname'].' '.$row_msg1['lastname'];
			
			$notice = 'User Detail email successfully sent to '.$name;
		}
		else $notice = '';
	}
	else $notice = '';
	
	// delete the user
	if (isset($_GET['action']) && $_GET['action'] == 'delete')
	{
		$delete = "DELETE FROM tbluser_data_wholesale where email = '".$_GET['eid']."'";
		mysql_query($delete);
  
		header('location:edit_user_wholesale_inactive.php');
	}
	
	//transfer to consumer list -rusty
	if (isset($_GET['action']) && $_GET['action'] == 'transfer')
	{
		$sql_email = "SELECT * FROM tbluser_data_wholesale WHERE email = '".$_GET['eid']."'";
		$res_email = mysql_query($sql_email) or dir ("Select error: ".mysql_error());
		$row_email = mysql_fetch_array($res_email);
		
		$e_fname = $row_email['firstname']; 
		$e_lname = $row_email['lastname'];
		$e_email = $row_email['email'];
		$e_pword = $row_email['pword'];
		$e_add1 = $row_email['address1'];
		$e_add2 = $row_email['address2'];
		$e_city = $row_email['city'];		
		$e_country = $row_email['country'];
		$e_state = $row_email['state'];
		$e_code = $row_email['zipcode'];
		$e_tel = $row_email['telephone'];
		$e_fax = $row_email['fax'];
		$e_date = $row_email['create_date'];
		$e_access = $row_email['access_level'];
		$e_active = $row_email['is_active'];
		
		$query = "select * from tbluser_data where email='".$_GET['eid']."'";
		$result = mysql_query($query) or die("ERROR ".mysql_error());
		$num_result = mysql_num_rows($result);
		$rowss = mysql_fetch_array($result);
		
		if($num_result == 0)
		{
			$insert_query = "
				INSERT INTO tbluser_data (
					email, password, firstname, lastname, dresssize, telephone, address1, address2,
					country, city, state_province, zip_postcode, receive_productupd, is_active
				)
				VALUES (
					'".$e_email."', '".$e_pword."', '".$e_fname."', '".$e_lname."','0', '".$e_tel."', 
				    '".$e_add1."', '".$e_add2."', '".$e_country."', '".$e_city."',
					'".$e_state."', '".$e_code."', 1, '".(int)$e_active."'
				)
			";
			mysql_query($insert_query) or die ("Insert tbluser_data error: ".mysql_error());
	 
			$user_uname = $e_fname.' '.$e_lname;
			$insert_query = "
				INSERT INTO tbluser (
					e_mail, user_name, user_password, uname, access_level, create_date, isregistered, received_produpdate
				) 
				VALUES (
					'".$e_email."', '".$e_email."', '".$e_pword."', '".$user_uname."', '".$e_access."', 
					'".date('Y-m-d', time())."', 1, 1
				)
			";
			mysql_query($insert_query) or die ("Insert tbluser error: ".mysql_error());	
		}
		else
		{
			// Update tbluser
			$sq = "update tbluser set isregistered = '1' where e_mail = '".$_GET['eid']."'";
			@mysql_query($sq) or die(mysql_error());		  
		}
		
		$query = "select * from tbluser where e_mail='".$_GET['eid']."' and isregistered=1";
		$result = mysql_query($query) or die("ERROR ".mysql_error());
		$num_result = mysql_num_rows($result);
		$rowsss = mysql_fetch_array($result);
		$e_id = $rowsss['user_id'];

		if ($num_result > 0)
		{			
			$sql_log = "
				INSERT INTO `tbl_login_detail` (
					`user_id`,`session_id`,`create_date`,`create_time`,`email`
				) 
				VALUES (
					'".$e_id."','".session_id()."',CURDATE(),CURTIME(),'".$e_email."'
				)
			";
			mysql_query($sql_log);	
		}
		
		header('Location: '.SITE_URL.'admin/edit_user_wholesale_inactive.php?eid='.$_GET['eid'].'&action=delete ');
	}

	// auto sending of login details by email when wholesale user status is changed to active
	if (isset($_GET['action']) && $_GET['action'] == "activate")
	{
		@mysql_query("
			UPDATE tbluser_data_wholesale 
			SET 
				is_active = 1, 
				active_date = '".date('Y-m-d', time())."'
			WHERE email = '".$_GET['eid']."'
		") or die(mysql_error());

		$sql_email = "select * from `tbluser_data_wholesale` where `email` = '".$_GET['eid']."'";
		$res_email = mysql_query($sql_email);
		$row_email = mysql_fetch_array($res_email);
		if ($row_email['firstname'] === $row_email['lastname']
			OR $row_email['lastname'] == '') $y_name = $row_email['firstname'];
		else $y_name = $row_email['firstname'].' '.$row_email['lastname'];
		$y_email = $row_email['email'];
		$y_pword = $row_email['pword'];
		
	// start Email...........................
		$subject = "Welcome to ".SITE_NAME." Wholesale Order System";
		
		$message = "<br />";
		$message.= SITE_NAME." welcomes you to our wholesale website. Use the information below to login." . "<br />";
		$message.= "<br />";
		$message.= SITE_URL."wholesale/signin.html" . "<br />";
		$message.= "<br />";
		$message.="Username: ".$y_email . "<br />";
		$message.="Password: ".$y_pword . "<br />";
		$message.= "<br />";
		$message.= "The following features are available:" . "<br />";
		$message.= "<br />";
		$message.= "Search Products, View Wholesale Pricing, Place Orders Online." . "<br />";
		$message.= "<br />";
		$message.= "For more information or further assistance, please call us on 212.840.0846  or email ".INFO_EMAIL."...";
		
		$mail = new PHPMailer();
		
		include("../phpscript/phpmailer/phpmailer_config_2.php");
		
		$mail->From = INFO_EMAIL;    //From Address -- CHANGE --
		$mail->FromName = SITE_NAME;    //From Name -- CHANGE --
		$mail->AddAddress($y_email, $y_name);    //To Address -- CHANGE --
		//$mail->AddAddress(DEV1_EMAIL);    //To Address -- CHANGE --
		$mail->AddReplyTo(INFO_EMAIL, SITE_NAME); //Reply-To Address -- CHANGE --

		$mail->WordWrap = 80;    // set word wrap to 50 characters
		$mail->IsHTML(true);    // set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $message;

		if ( ! $mail->Send())
		{
			echo "There was an error sending your email. <p>";
			echo "Mailer Error: " . $mail->ErrorInfo;
			//exit;
		}
		else
		{
			header('location:edit_user_wholesale.php?eid='.$_GET['eid'].'&msg=2');
		}
	 // End Email...............................
	}

	$rno = 300; // ----> number of rows per page
	
	if (isset($_REQUEST['search']) && $_REQUEST['search'] == 1)
	{
		$exp_sec_text = explode('-',$_POST['sec_text']);
		$sec_email = trim($exp_sec_text[1]);
		$exp_sec_name = explode(' ',trim($exp_sec_text[0]));
		if (count($exp_sec_name) == 1)
		{
			$sec_fname = trim($exp_sec_name[0]);
			$sec_lname = '';
		}
		elseif (count($exp_sec_name) == 2)
		{
			$sec_fname = trim($exp_sec_name[0]);
			$sec_lname = trim($exp_sec_name[1]);
		}
		elseif (count($exp_sec_name) > 2)
		{
			$sec_fname = trim($exp_sec_name[0]).' '.trim($exp_sec_name[1]);
			$l_name = isset($exp_sec_name[3]) ?  trim($exp_sec_name[3]) : '';
			$sec_lname = trim($exp_sec_name[2]).' '.$l_name;
		}
		else
		{
			$sec_fname = '';
			$sec_lname = '';
		}
		
		$select = "
			SELECT td.*, xdate
			FROM tbluser_data_wholesale td
			LEFT JOIN (select email,max(create_date) as xdate from tbl_login_detail_wholesale group by email) as ld on ld.email = td.email
			WHERE (
				firstname like '%".$sec_fname."%'
				OR lastname like '%".$sec_lname."%'
				OR td.email like '%".$sec_email."%'
			)
				AND is_active = '0'
			ORDER BY create_date DESC, firstname ASC
		";
	}
	else
	{
		$select = "
			SELECT td.*, xdate 
			FROM tbluser_data_wholesale td
			LEFT JOIN (select email,max(create_date) as xdate from tbl_login_detail_wholesale group by email) as ld on ld.email = td.email
			WHERE is_active = '0' 
			ORDER BY create_date DESC, firstname ASC";
	}

	$res = mysql_query($select);
	if ($res) $rnum = mysql_num_rows($res);
	else $rnum = 0;

		$mod=$rnum%$rno;
        if($mod>0)
        {
          $tpage=($rnum-$mod)/$rno +1; 
        }
        else
        {
          $tpage=($rnum-$mod)/$rno;
        }
        if(@$cpage=="")
        {
          $cpage=1;       /*variable for page no.....*/
        }

        $skip=($cpage-1)*$rno;
        if(($skip+$rno)>$rnum)
        {
          $lmt=$rnum-$skip;
        }
        else
        {
          $lmt=$rno;
        }
        $start=$skip +1;
        $end=$skip + $lmt;

	if (isset($_REQUEST['search']) && $_REQUEST['search'] == 1)
	{
		$exp_sec_text = explode('-',$_POST['sec_text']);
		$sec_email = trim($exp_sec_text[1]);
		$exp_sec_name = explode(' ',trim($exp_sec_text[0]));
		if (count($exp_sec_name) == 1)
		{
			$sec_fname = trim($exp_sec_name[0]);
			$sec_lname = '';
		}
		elseif (count($exp_sec_name) == 2)
		{
			$sec_fname = trim($exp_sec_name[0]);
			$sec_lname = trim($exp_sec_name[1]);
		}
		elseif (count($exp_sec_name) > 2)
		{
			$sec_fname = trim($exp_sec_name[0]).' '.trim($exp_sec_name[1]);
			$l_name = isset($exp_sec_name[3]) ?  trim($exp_sec_name[3]) : '';
			$sec_lname = trim($exp_sec_name[2]).' '.$l_name;
		}
		else
		{
			$sec_fname = '';
			$sec_lname = '';
		}
		
		$sql = "
			SELECT td.*, xdate 
			FROM tbluser_data_wholesale td
			LEFT JOIN (select email,max(create_date) as xdate from tbl_login_detail_wholesale group by email) as ld on ld.email = td.email
			WHERE (
				firstname like '%".$sec_fname."%'
				OR lastname like '%".$sec_lname."%'
				OR td.email like '%".$sec_email."%'
			)
				AND is_active = '0'
			ORDER BY create_date DESC, firstname ASC
			LIMIT $skip,$lmt
		";
	}
	else
	{
		$sql = "
			SELECT td.*, xdate
			FROM tbluser_data_wholesale td
			LEFT JOIN (select email,max(create_date) as xdate from tbl_login_detail_wholesale group by email) as ld on ld.email = td.email
			WHERE is_active = '0'
			ORDER BY create_date DESC, firstname ASC
			LIMIT $skip,$lmt
		";
	}

	$result=mysql_query($sql);
	
	include 'top.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<!--<meta http-equiv="refresh" content="20" > -->
	<title>Fashion::Admin</title>
	<script>
	function confirm_delete()
	{
		var agree=confirm("Are you sure you wish to delete the record?");
		if (agree) return true;
		else return false;
	}
	function confirm_transfer()
	{
		var agree=confirm("Are you sure you wish to Transfer this record?");
		if (agree) return true;
		else return false;
	}
	</script>
	<link href="style.css" rel="stylesheet" type=text/css>
	<style type="text/css">
	<!--
	.style2 {font-size: x-small}
	.style3 {font-family: Arial, Helvetica, sans-serif}
	-->
	</style>
	
<?php
	echo '
<script type="text/javascript">
	// This is search field on user list
	$().ready(function() {
	    $("#sec_text").autocomplete("get_user_list.php?u='.USER_TYPE.'", {
	        width: 300,
	        matchContains: true,
			max: 20,
	        selectFirst: false
	    });
	});
</script>
	';
?>

</head>

<body>

<table width="100%" border="0" cellpadding="1" cellspacing="1">
<tr><td>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor=gray >
		<tr>
            <td bgcolor="#ffffff"><div align="left">
			
                <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="gray">
					<tr>
						<td width="72%" class=partner valign=top align=center >&nbsp;&nbsp;
						
							<table cellpadding="0" cellspacing="0" width="600" border="0">
							
								<tr>
									<td align="center" class="text" style="padding:20px 0;color:red;font-size:bold;">
										<?php if (isset($notice) && $notice != '') echo $notice; ?>
									</td>
								</tr>
								
								<!--bof form=====================================================================-->
								<form name="frm" action="<?php echo $_SERVER['PHP_SELF'];?>?search=1" method="post">
								<tr>
									<td align="right" class="text" style="padding-right:60px;">
										Search for inactive users:&nbsp;
										<input type="text" name="sec_text" id="sec_text" value="<?php echo isset($_REQUEST['sec_text']) ? $_REQUEST['sec_text'] : '';?>" size="50">&nbsp;&nbsp;
										<input type="submit" value=" Search "></td>
								</tr>
								</form>
								<!--eof form=====================================================================-->
								<tr>
									<td>
										<span class="text"><br />Page :</span>
										<?php
										/*
										| ---------------------------
										| Paginatoim
										*/
										if (($cpage - 4) >= 1) // ---> First & Previous page
										{ ?>
											<span class="text">[</span><a href="edit_user_wholesale_inactive.php<?php echo isset($_REQUEST['search']) ? '?search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text']) ? '&sec_text='.$_REQUEST['sec_text'] : ''; ?>" class="pagelinks" title="First">&lt;&lt;</a><span class="text">]</span>
											<span class="text">[</span><a href="edit_user_wholesale_inactive.php?cpage=<?php echo ($cpage - 1); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text']) ? '&sec_text='.$_REQUEST['sec_text'] : ''; ?>" class="pagelinks" title="Previous">&lt;</a><span class="text">]</span>
											<?php
											echo '...';
										}
										if (($cpage - 1000) >= 1) // ---> Skip pages
										{ ?>
											<span class="text">[</span><a href="edit_user_wholesale_inactive.php?cpage=<?php echo ($cpage - 1000); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text']) ? '&sec_text='.$_REQUEST['sec_text'] : ''; ?>" class="pagelinks" title="Page <?php echo ($cpage - 1000); ?>"><?php echo ($cpage - 1000); ?></a><span class="text">]</span>
											.
											<?php
										}
										if (($cpage - 100) >= 1) // ---> Skip pages
										{ ?>
											<span class="text">[</span><a href="edit_user_wholesale_inactive.php?cpage=<?php echo ($cpage - 100); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text']) ? '&sec_text='.$_REQUEST['sec_text'] : ''; ?>" class="pagelinks" title="Page <?php echo ($cpage - 100); ?>"><?php echo ($cpage - 100); ?></a><span class="text">]</span>
											.
											<?php
										}
										if (($cpage - 10) >= 1) // ---> Skip pages
										{ ?>
											<span class="text">[</span><a href="edit_user_wholesale_inactive.php?cpage=<?php echo ($cpage - 10); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text']) ? '&sec_text='.$_REQUEST['sec_text'] : ''; ?>" class="pagelinks" title="Page <?php echo ($cpage - 10); ?>"><?php echo ($cpage - 10); ?></a><span class="text">]</span>
											.
											<?php
										}
										for ($i = $cpage - 3; $i <= ($cpage + 3); $i++) // ---> Current and neighboring pages
										{
											if ($i == $cpage) // ---> current page as plain text
											{ ?>
												<span class="text" style="color:#aa0000;">[<u><?php echo $i;?></u>]</span>
												<?php
											}
											elseif ($i >= 1 && $i <= $tpage) // ---> other pages as link
											{ ?>
												<span class="text">[</span><a href="edit_user_wholesale_inactive.php?cpage=<?php echo $i; echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text']) ? '&sec_text='.$_REQUEST['sec_text'] : ''; ?>" class="pagelinks" title="Page <?php echo $i; ?>"><?php echo $i; ?></a><span class="text">]</span>
												<?php
											}
										}
										if (($cpage + 10) <= $tpage) // ---> Skip pages
										{ ?>
											.
											<span class="text">[</span><a href="edit_user_wholesale_inactive.php?cpage=<?php echo ($cpage + 10); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text']) ? '&sec_text='.$_REQUEST['sec_text'] : ''; ?>" class="pagelinks" title="Page <?php echo ($cpage + 10); ?>"><?php echo ($cpage + 10); ?></a><span class="text">]</span>
											<?php
										}
										if (($cpage + 100) <= $tpage) // ---> Skip pages
										{ ?>
											.
											<span class="text">[</span><a href="edit_user_wholesale_inactive.php?cpage=<?php echo ($cpage + 100); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text']) ? '&sec_text='.$_REQUEST['sec_text'] : ''; ?>" class="pagelinks" title="Page <?php echo ($cpage + 100); ?>"><?php echo ($cpage + 100); ?></a><span class="text">]</span>
											<?php
										}
										if (($cpage + 1000) <= $tpage) // ---> Skip pages
										{ ?>
											.
											<span class="text">[</span><a href="edit_user_wholesale_inactive.php?cpage=<?php echo ($cpage + 1000); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text']) ? '&sec_text='.$_REQUEST['sec_text'] : ''; ?>" class="pagelinks" title="Page <?php echo ($cpage + 1000); ?>"><?php echo ($cpage + 1000); ?></a><span class="text">]</span>
											<?php
										}
										if (($cpage + 4) <= $tpage) // ---> Next & Last page
										{
											echo '...'; ?>
											<span class="text">[</span><a href="edit_user_wholesale_inactive.php?cpage=<?php echo ($cpage + 1); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text']) ? '&sec_text='.$_REQUEST['sec_text'] : ''; ?>" class="pagelinks" title="Next">&gt;</a><span class="text">]</span>
											<span class="text">[</span><a href="edit_user_wholesale_inactive.php?cpage=<?php echo $tpage; echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text']) ? '&sec_text='.$_REQUEST['sec_text'] : ''; ?>" class="pagelinks" title="Last">&gt;&gt;</a><span class="text">]</span>
											<?php
										}
										
										// ---> Search and count text
										if (isset($_REQUEST['search']) && $_REQUEST['search'] == 1)
										{
											if ($rnum == 0)
											{ ?>
												<span class="text"><br /><br />No results found.</span>
												<?php
											}
											else
											{ ?>
												<span class="text"><br /><br />Search results for: <?php echo $_REQUEST['sec_text']; ?></span>
												<?php
											}
										}
										else
										{ ?>
											<span class="text"><br /><br />Default showing <?php echo $rno; ?> per page of <?php echo $rnum; ?> records (Total pages: <?php echo $tpage; ?>)</span>
											<?php
										} ?>
									</td>
								</tr>
								<tr>
									<td height="15"></td>
								</tr>
							</table>
							
							<!-----start-----------//-->
							<!--bof form=====================================================================-->
							<form name="faq" action="edit_user_wholesale_inactive.php" method="post">
							<table width="100%" border="1" bordercolor="cccccc" cellspacing="0" cellpadding="0">
							<tr><td>

								<table width="100%" align="center" cellspacing="2" cellpadding="2">
									<col />
									<col />
									<col />
									<col width="75" />
									<col width="75" />
									<col width="75" />
									<tr bgcolor=cccccc>
										<td align=center colspan="3"><b><font size="2" color="#000000" face="verdana,Arial">Wholesale User Maintenance &nbsp; &nbsp; Filter by: <a href="edit_user_wholesale.php" class="pagelinks">Active</a> | <a href="edit_user_wholesale_inactive.php" class="pagelinks">Inactive</a> </font></b></td>
										<td align="left"><font size="1" color="#000000" face="verdana,Arial">DATE JOINED</font></td>
										<td align="left"><font size="1" color="#000000" face="verdana,Arial">DATE LAST ACTIVATED</font></td>
										<td align="left"><font size="1" color="#000000" face="verdana,Arial">DATE LAST LOGIN</font></td>
									</tr>

									<?php
									$ctr = (($cpage-1)*50);
									if ($result)
									{
										while ($row = mysql_fetch_array($result))
										{
											$ctr = $ctr+1;
											?>
											
											<tr align=center>
												<td align="left"><span class="style2"><span class="style3"><?php echo $ctr.'. '.$row['store_name']?></span></span></td>
												<td align="left"><span class="style2"><span class="style3"><?php echo strtolower($row['email']);?></span></span></td>
												<td align="left"> &nbsp;&nbsp;
													<span class="pagelinks" style="color:#CC0000">Inactive</span>
													<a href="edit_user_wholesale_inactive.php?eid=<?=$row['email'];?>&action=activate" class="pagelinks" title="Click to activate this user">Activate?</a>&nbsp;&nbsp; 
													<a href="javascript:void(0);" onClick="javascript:window.open('user_edit_popup_wholesale.php?eid=<?=$row['email'];?>','','scrollbars=yes, width=550, height=650')" class="pagelinks">[edit]</a>&nbsp;&nbsp;
													<a href="edit_user_wholesale_inactive.php?eid=<?=$row['email'];?>&action=delete" onClick="return confirm_delete()" class="pagelinks">[delete]</a>&nbsp;&nbsp;
													<!--
													<a href="edit_user_wholesale_inactive.php?eid=<?=$row['email'];?>&action=email" class="pagelinks">[send email]</a>&nbsp;&nbsp;
													-->
                                                    <a href="edit_user_wholesale_inactive.php?eid=<?=$row['email'];?>&action=transfer" onClick="return confirm_transfer()" class="pagelinks">[transfer to consumer]</a>
												</td>
												
												<td align="left">
													<span class="style2"><span class="style3"><?=$row['create_date']?></span></span>
												</td>
												<td align="left">
													<span class="style2"><span class="style3"><?=$row['active_date']=='0000-00-00' ? '' : $row['active_date'];?></span></span>
												</td>
												<td align="left">
													<span class="style2"><span class="style3" style="color:red;"><?=$row['xdate']?></span></span>
												</td>
											</tr>
											<?php
										}
									} ?>

								</table>
							</td></tr>					
							</table>
							<p>&nbsp;</p>
							</form>
							<!--eof form=====================================================================-->
							<!-------end-------//-->
						</td>
					</tr>
                </table>
				
            </td>
		</tr>
	</table>

</td></tr>
</table>

</body>
</html>
