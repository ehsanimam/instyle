<?php 
	include("../common.php");
	include("security.php");
	require_once("../phpscript/phpmailer/class.phpmailer.php"); // add this pages where email sending is used
	
	define('USER_TYPE','inactive_consumer');
	
	if (isset($_GET['action']) && $_GET['action'] == 'delete')
	{
		$delete = "delete from tbluser where e_mail='".$_GET['eid']."'";
		mysql_query($delete) or die('Deleting error '.mysql_error());
  
		@mysql_query("delete from tbluser_data where email='".$_GET['eid']."'");
 		@mysql_query("delete from tbluser_data_2011 where email='".$_GET['eid']."'");

		header('location:edit_user_inactive.php');
		//delete the related urls!!!!!!!!!!!!!!!!!!
	}
	
	// transfer to wholesale list as inactive
	if (isset($_GET['action']) && $_GET['action'] == 'transfer')
	{
		$sql_email = "SELECT * FROM tbluser_data WHERE email = '".$_GET['eid']."'";
		$res_email = mysql_query($sql_email) or dir ("Select error: ".mysql_error());
		$row_email = mysql_fetch_array($res_email);
		
		$e_fname = $row_email['firstname']; 
		$e_lname = $row_email['lastname'];
		$e_pword = $row_email['password'];
		$e_add1 = $row_email['address1'];
		$e_add2 = $row_email['address2'];
		$e_city = $row_email['city'];		
		$e_country = $row_email['country'];
		$e_state = $row_email['state_province'];
		$e_code = $row_email['zip_postcode'];
		$e_tel = $row_email['telephone'];
		$e_fax = $row_email['fax'];
		$e_active = $row_email['is_active'];
		
		$query = "select * from tbluser_data_wholesale where email='".$_GET['eid']."'";
		$result = mysql_query($query) or die("ERROR ".mysql_error());
		$num_result = mysql_num_rows($result);
		$rowss = mysql_fetch_array($result);
		
		if($num_result == 0)
		{
			$insert_query = "
				INSERT INTO tbluser_data_wholesale (
					email, pword, firstname, lastname, telephone, address1, address2,
					country, city, state, zipcode,create_date, access_level, is_active
				)
				VALUES (
					'".$_GET['eid']."', '".$e_pword."', '".$e_fname."', '".$e_lname."', '".$e_tel."', 
					'".$e_add1."', '".$e_add2."', '".$e_country."', '".$e_city."',
					'".$e_state."', '".$e_code."', now(), 0, 0
				)
			";
			mysql_query($insert_query) or die ("Insert tbluser_data_wholesale error: ".mysql_error());	
		}
		
		$query = "select * from tbluser_data_wholesale where email='".$_GET['eid']."'";
		$results = mysql_query($query) or die("ERROR ".mysql_error());
		$num_result = mysql_num_rows($results);
		$rowss = mysql_fetch_array($results);
		$e_id = $rowss['user_id'];

		if ($num_result > 0)
		{		
			$sql_log = "
				INSERT INTO `tbl_login_detail_wholesale` (
					`user_id`,`session_id`,`create_date`,`create_time`,`email`
				) 
				VALUES (
					'".$e_id."','".session_id()."',CURDATE(),CURTIME(),'".$e_email."'
				)
			";
			mysql_query($sql_log);		
		}
		
		header('Location: '.SITE_URL.'admin/edit_user_inactive.php?eid='.$_GET['eid'].'&action=delete ');
	}

	if (isset($_GET['action']) && $_GET['action'] == "activate")
	{
		$e_mail = $_GET['eid'];

		@mysql_query("update tbluser_data set is_active='1' where email='".$e_mail."'") or die(mysql_error());

		// start Email...........................
		$subject = "Welcome to ".SITE_NAME.", a site to order";
		
		$message = "<br />";
		$message.= "Your account has just been activated" . "<br />";
		$message.= "<br />";
		$message.= SITE_NAME." welcomes you to our website - " . SITE_DOMAIN . ".<br />";
		$message.= "<br />";
		$message.= "The following features are available:" . "<br />";
		$message.= "<br />";
		$message.= "Search Products, View Pricing, Place Orders Online." . "<br />";
		$message.= "<br />";
		$message.= "For more information or further assistance, please call us on 212.840.0846  or email ".INFO_EMAIL."..";
		
		$mail = new PHPMailer();
		
		include("../phpscript/phpmailer/phpmailer_config_2.php");
		
		$mail->From = INFO_EMAIL;    //From Address -- CHANGE --
		$mail->FromName = SITE_NAME;    //From Name -- CHANGE --
		$mail->AddAddress($e_mail);    //To Address -- CHANGE --
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
			echo "
				<script>
					window.location.href='edit_user.php?msg=1';
				</script>
			";
		}
		// End Email...............................
		
	}

	$rno = 50; // ----> number of rows per page
	
	if (isset($_REQUEST['search']) && $_REQUEST['search'] == 1)
	{
		$exp_sec_text = explode('-',$_POST['sec_text_inact']);
		$sec_email = trim($exp_sec_text[1]);
		$exp_sec_name = explode(' ',trim($exp_sec_text[0]));
		if (count($exp_sec_name) == 1)
		{
			$sec_uname = trim($exp_sec_name[0]);
			$sec_fname = trim($exp_sec_name[0]);
			$sec_lname = '';
		}
		elseif (count($exp_sec_name) == 2)
		{
			$sec_uname = trim($exp_sec_name[0]).' '.trim($exp_sec_name[1]);
			$sec_fname = trim($exp_sec_name[0]);
			$sec_lname = trim($exp_sec_name[1]);
		}
		elseif (count($exp_sec_name) > 2)
		{
			$sec_uname = trim($exp_sec_text[0]);
			$sec_fname = trim($exp_sec_name[0]).' '.trim($exp_sec_name[1]);
			$l_name = isset($exp_sec_name[3]) ?  trim($exp_sec_name[3]) : '';
			$sec_lname = trim($exp_sec_name[2]).' '.$l_name;
		}
		else
		{
			$sec_uname = '';
			$sec_fname = '';
			$sec_lname = '';
		}
		
		$select = "
			SELECT *
			FROM tbluser_data as td
				LEFT JOIN tbluser as tu ON tu.e_mail = td.email
				LEFT JOIN tblemail_subscribe as ts  ON ts.email_addr = td.email
				LEFT JOIN (select email,max(create_date) as xdate from tbl_login_detail group by email) as ld on ld.email=td.email 
			WHERE td.is_active='0' 
				AND (
					tu.uname like '%".$sec_uname."%'
					OR firstname like '%".$sec_fname."%'
					OR lastname like '%".$sec_lname."%'
					OR td.email like '%".$sec_email."%'
				)
			ORDER BY tu.create_date desc, xdate desc, uname asc
		";
	}
	else
	{
		$select = "
			SELECT *
			FROM tbluser_data as td
				LEFT JOIN tbluser as tu ON tu.e_mail = td.email
				LEFT JOIN tblemail_subscribe as ts  ON ts.email_addr = td.email
				LEFT JOIN (select email,max(create_date) as xdate from tbl_login_detail group by email) as ld on ld.email=td.email 
			WHERE td.is_active='0' 
			ORDER BY tu.create_date desc, xdate desc, uname asc
		";
	}

	$res = mysql_query($select);
	$rnum = mysql_num_rows($res);

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

	if(isset($_REQUEST['search']) && $_REQUEST['search'] == 1)
	{
		$exp_sec_text = explode('-',$_POST['sec_text_inact']);
		$sec_email = trim($exp_sec_text[1]);
		$exp_sec_name = explode(' ',trim($exp_sec_text[0]));
		if (count($exp_sec_name) == 1)
		{
			$sec_uname = trim($exp_sec_name[0]);
			$sec_fname = trim($exp_sec_name[0]);
			$sec_lname = '';
		}
		elseif (count($exp_sec_name) == 2)
		{
			$sec_uname = trim($exp_sec_name[0]).' '.trim($exp_sec_name[1]);
			$sec_fname = trim($exp_sec_name[0]);
			$sec_lname = trim($exp_sec_name[1]);
		}
		elseif (count($exp_sec_name) > 2)
		{
			$sec_uname = trim($exp_sec_text[0]);
			$sec_fname = trim($exp_sec_name[0]).' '.trim($exp_sec_name[1]);
			$l_name = isset($exp_sec_name[3]) ?  trim($exp_sec_name[3]) : '';
			$sec_lname = trim($exp_sec_name[2]).' '.$l_name;
		}
		else
		{
			$sec_uname = '';
			$sec_fname = '';
			$sec_lname = '';
		}
		
		$sql = "
			SELECT 
				td.email as te,
				date(ts.create_date) as vdate,
				tu.create_date as cdate,
				xdate,
				firstname, 
				lastname
			FROM tbluser_data as td
				LEFT JOIN tbluser as tu ON tu.e_mail = td.email
				LEFT JOIN tblemail_subscribe as ts  ON ts.email_addr = td.email
				LEFT JOIN (select email,max(create_date) as xdate from tbl_login_detail group by email) as ld on ld.email=td.email 
			WHERE td.is_active='0' 
				AND (
					tu.uname like '%".$sec_uname."%'
					OR firstname like '%".$sec_fname."%'
					OR lastname like '%".$sec_lname."%'
					OR td.email like '%".$sec_email."%'
				)
			ORDER BY tu.create_date desc, xdate desc, uname asc
			LIMIT $skip,$lmt
		";
	}
	else
	{
		$sql = "
			SELECT 
				td.email as te,
				date(ts.create_date) as vdate,
				tu.create_date as cdate,
				xdate,
				firstname, 
				lastname
			FROM tbluser_data as td
				LEFT JOIN tbluser as tu ON tu.e_mail = td.email
				LEFT JOIN tblemail_subscribe as ts  ON ts.email_addr = td.email
				LEFT JOIN (select email,max(create_date) as xdate from tbl_login_detail group by email) as ld on ld.email=td.email 
			WHERE td.is_active='0' 
			ORDER BY tu.create_date desc, xdate desc, uname asc
			LIMIT $skip,$lmt
		";
	}

	//$sql="select * from tbluser order by create_date desc,uname asc limit $skip,$lmt";
	$result = mysql_query($sql);
	
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
		if (agree)
		return true ;
		else
		return false ;
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
.style2 {font-size: x-small; font-family: Arial, Helvetica, sans-serif;}
.style3 {font-family: Arial, Helvetica, sans-serif}
-->
</style>

</head>

<body>

<?php
	echo '
<script type="text/javascript">
	// This is search field on user list
	$().ready(function() {
	    $("#sec_text_inact").autocomplete("get_user_list.php?u='.USER_TYPE.'", {
	        width: 300,
	        matchContains: true,
			max: 20,
	        selectFirst: false
	    });
	});
</script>
	';
?>

<table width="100%" border="0" cellpadding="1" cellspacing="1">
<tr><td>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor=gray >
		<tr>
            <td bgcolor="#ffffff">
			<div align="left">
			
                <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="gray">
					<tr>
						<td class="partner" valign="top" align="center">&nbsp;&nbsp;
						
							<table cellpadding="0" cellspacing="0" width="80%" border="0">
								<!--bof form=====================================================================-->
								<form name="frm" action="<?php echo $_SERVER['PHP_SELF'];?>?search=1" method="post">
								<tr>
									<td align="right" class="text" style="padding-right:100px;">
										Search for inactive users:&nbsp;
										<input type="text" name="sec_text_inact" id="sec_text_inact" value="<?php echo isset($_REQUEST['sec_text_inact']) ? $_REQUEST['sec_text_inact'] : '';?>" size="50">&nbsp;&nbsp;
										<input type="submit" value=" Search ">
									</td>
								</tr>
								</form>
								<!--eof form=====================================================================-->
								<tr>
									<td>
										<span class="text"> Page :</span>
										<?php
										/*
										| ---------------------------
										| Paginatoim
										*/
										if (($cpage - 4) >= 1) // ---> First & Previous page
										{ ?>
											<span class="text">[</span><a href="edit_user_inactive.php<?php echo isset($_REQUEST['search']) ? '?search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text_inact']) ? '&sec_text_inact='.$_REQUEST['sec_text_inact'] : ''; ?>" class="pagelinks" title="First">&lt;&lt;</a><span class="text">]</span>
											<span class="text">[</span><a href="edit_user_inactive.php?cpage=<?php echo ($cpage - 1); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text_inact']) ? '&sec_text_inact='.$_REQUEST['sec_text_inact'] : ''; ?>" class="pagelinks" title="Previous">&lt;</a><span class="text">]</span>
											<?php
											echo '...';
										}
										if (($cpage - 1000) >= 1) // ---> Skip pages
										{ ?>
											<span class="text">[</span><a href="edit_user_inactive.php?cpage=<?php echo ($cpage - 1000); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text_inact']) ? '&sec_text_inact='.$_REQUEST['sec_text_inact'] : ''; ?>" class="pagelinks" title="Page <?php echo ($cpage - 1000); ?>"><?php echo ($cpage - 1000); ?></a><span class="text">]</span>
											.
											<?php
										}
										if (($cpage - 100) >= 1) // ---> Skip pages
										{ ?>
											<span class="text">[</span><a href="edit_user_inactive.php?cpage=<?php echo ($cpage - 100); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text_inact']) ? '&sec_text_inact='.$_REQUEST['sec_text_inact'] : ''; ?>" class="pagelinks" title="Page <?php echo ($cpage - 100); ?>"><?php echo ($cpage - 100); ?></a><span class="text">]</span>
											.
											<?php
										}
										if (($cpage - 10) >= 1) // ---> Skip pages
										{ ?>
											<span class="text">[</span><a href="edit_user_inactive.php?cpage=<?php echo ($cpage - 10); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text_inact']) ? '&sec_text_inact='.$_REQUEST['sec_text_inact'] : ''; ?>" class="pagelinks" title="Page <?php echo ($cpage - 10); ?>"><?php echo ($cpage - 10); ?></a><span class="text">]</span>
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
												<span class="text">[</span><a href="edit_user_inactive.php?cpage=<?php echo $i; echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text_inact']) ? '&sec_text_inact='.$_REQUEST['sec_text_inact'] : ''; ?>" class="pagelinks" title="Page <?php echo $i; ?>"><?php echo $i; ?></a><span class="text">]</span>
												<?php
											}
										}
										if (($cpage + 10) <= $tpage) // ---> Skip pages
										{ ?>
											.
											<span class="text">[</span><a href="edit_user_inactive.php?cpage=<?php echo ($cpage + 10); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text_inact']) ? '&sec_text_inact='.$_REQUEST['sec_text_inact'] : ''; ?>" class="pagelinks" title="Page <?php echo ($cpage + 10); ?>"><?php echo ($cpage + 10); ?></a><span class="text">]</span>
											<?php
										}
										if (($cpage + 100) <= $tpage) // ---> Skip pages
										{ ?>
											.
											<span class="text">[</span><a href="edit_user_inactive.php?cpage=<?php echo ($cpage + 100); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text_inact']) ? '&sec_text_inact='.$_REQUEST['sec_text_inact'] : ''; ?>" class="pagelinks" title="Page <?php echo ($cpage + 100); ?>"><?php echo ($cpage + 100); ?></a><span class="text">]</span>
											<?php
										}
										if (($cpage + 1000) <= $tpage) // ---> Skip pages
										{ ?>
											.
											<span class="text">[</span><a href="edit_user_inactive.php?cpage=<?php echo ($cpage + 1000); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text_inact']) ? '&sec_text_inact='.$_REQUEST['sec_text_inact'] : ''; ?>" class="pagelinks" title="Page <?php echo ($cpage + 1000); ?>"><?php echo ($cpage + 1000); ?></a><span class="text">]</span>
											<?php
										}
										if (($cpage + 4) <= $tpage) // ---> Next & Last page
										{
											echo '...'; ?>
											<span class="text">[</span><a href="edit_user_inactive.php?cpage=<?php echo ($cpage + 1); echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text_inact']) ? '&sec_text_inact='.$_REQUEST['sec_text_inact'] : ''; ?>" class="pagelinks" title="Next">&gt;</a><span class="text">]</span>
											<span class="text">[</span><a href="edit_user_inactive.php?cpage=<?php echo $tpage; echo isset($_REQUEST['search']) ? '&search='.$_REQUEST['search'] : ''; echo isset($_REQUEST['sec_text_inact']) ? '&sec_text_inact='.$_REQUEST['sec_text_inact'] : ''; ?>" class="pagelinks" title="Last">&gt;&gt;</a><span class="text">]</span>
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
												<span class="text"><br /><br />Search results for: <?php echo $_REQUEST['sec_text_inact']; ?></span>
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
							<form name="frm_edit_user_inactive" action="edit_user_inactive.php" method="post">
							<table width="100%" border="1" bordercolor="cccccc" cellspacing="0" cellpadding="0">
							<tr><td>

								<table width=100% align=center cellspacing=2 cellpadding=2>
									<tr bgcolor=cccccc>
										<td align=center colspan="3"><b><font size=2 color="#000000" face="verdana,Arial">INACTIVE Consumer User Maintenance &nbsp; &nbsp; Filter by: <a href="edit_user.php" class="pagelinks">Active</a> | <a href="edit_user_inactive.php" class="pagelinks">Inactive</a> </font></b>
										</td>
									</tr>

									<?php
									$ctr = isset($cpage) ? ($cpage - 1) * 50 : 0;
									while ($row = mysql_fetch_array($result))
									{
										$ctr = $ctr+1;
										$name = $row['firstname'].' '.$row['lastname'];
										?>
										<tr align=center>
											<td align="left"><span class="style2"><?php echo $ctr.'. '; echo $name; ?></span></td>
											<td align="left"><span class="style2"><?php echo isset($row['te']) ? strtolower($row['te']) : ''; ?></span></td>
											
											<td align="left"> &nbsp;&nbsp;
												<span class="pagelinks" style="color:#CC0000">Inactive</span> <a href="edit_user_inactive.php?eid=<?=$row['te'];?>&action=activate" class="pagelinks" title="Click to activate this user">Activate?</a>&nbsp;&nbsp; 
												<a href="" onClick="javascript:window.open('user_edit_popup.php?eid=<?=$row['te'];?>','','scrollbars=yes, height=700, width=600')" class="pagelinks">[edit]</a>&nbsp;&nbsp;
												<a href="edit_user_inactive.php?eid=<?=$row['te'];?>&action=delete" onClick="return confirm_delete()" class="pagelinks">[delete]</a>&nbsp;&nbsp;
												<!--
												<a href="edit_user_inactive.php?eid=<?=$row['te'];?>&action=email" class="pagelinks">[send email]</a>&nbsp;&nbsp;
												-->
												<a href="edit_user_inactive.php?eid=<?=$row[e_mail];?>&action=transfer" onClick="return confirm_transfer()" class="pagelinks">[transfer to wholesale list]</a>				
											</td>
										</tr>
										<?php
									} ?>


                   </table>					
                    </td></tr>					
					</table>
                    <p>&nbsp;</p>
                    </form>
                     <!-------end-------//-->
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table></td>
    </tr>
</table>
</body>
</html>
