<?php
	include("../common.php");
	include('../functionsadmin.php');
	include("security.php");

	if (isset($_GET['action']) && $_GET['action'] == 'add')
	{
		//collect input values
		$uname				= $_POST['uname'];
		$email				= $_POST['email'];
		$pword				= $_POST['pword'];
		$store_name			= $_POST['store_name'];
		$firstname			= $_POST['firstname'];
		$lastname			= $_POST['lastname'];
		$fed_tax_id			= $_POST['fed_tax_id'];
		$address1			= $_POST['address1'];
		$address2			= $_POST['address2'];
		$city				= $_POST['city'];
		$country			= $_POST['country'];
		$state				= $_POST['state'];
		$zipcode			= $_POST['zipcode'];
		$telephone			= $_POST['telephone'];
		$fax				= $_POST['fax'];
		$is_active			= $_POST['is_active'];
		$access_level		= $_POST['access_level'];
		
		if (!$email || !$pword || !$store_name || !$firstname || !$lastname || !$address1 || !$city || !$country || !$state || !$zipcode || !$telephone)
		{
			$err = "<li>Please fill up all (*) mandatory fields</li>";
		}
		
		$get_email = @mysql_query("SELECT * FROM tbluser_data_wholesale WHERE email = '".$email."'") or die ("Select error: ".mysql_error());

		// ---------- (@2012-01-04-rey)
		// Changed ereg() function to preg_match as it is already deprecated.
		if ( ! preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i', $email))
		{
			$err = "<li>You have entered an invalid email address</li>";
		}
		
		if ($uname != $email)
		{
			$err = "<li>Place your email address as your user name too.</li>";
		}

		if ( ! $err)
		{
			$get_email = @mysql_query("SELECT * FROM tbluser_data_wholesale WHERE email = '".$email."'") or die ("Select error: ".mysql_error());
			
			if (mysql_num_rows($get_email) > 0)
			{
				$err = "<li>Email address already taken</li>";
			}
			else
			{
				// ---------- (@2012-01-04-rey)
				// Added addcslashes for field 'store_name' for potential apostrophe in text string input
				// This is only for admin as admin is not yet CI. But, will practice the same at CI as well.
				$insert_query = "
					INSERT INTO tbluser_data_wholesale (
						email, pword, store_name, firstname, lastname, fed_tax_id, address1, address2,
						city, country, state, zipcode, telephone, fax, create_date, access_level, is_active
					) 
					VALUES (
						'".$email."', '".$pword."', '".addcslashes($store_name,'\'')."', '".$firstname."', '".$lastname."',
						'".$fed_tax_id."', '".$address1."', '".$address2."', '".$city."', '".$country."',
						'".$state."', '".$zipcode."', '".$telephone."', '".$fax."', '".date('Y-m-d', time())."',
						'".$access_level."', '".$is_active."'
					)
				";
				mysql_query($insert_query) or die ("Insert error: ".mysql_error());
	 
			// start Email...........................
				$subject = "Welcome to ".SITE_NAME." Wholesale Order System for (BASIX, ISSUE, CENTREVILLE)";
				
				$message = "\n";
				$message.= SITE_NAME." welcomes you to our wholesale website. Use the information below to login." . "\n";
				$message.= "\n";
				$message.= SITE_URL."wholesale/signin.html" . "\n";
				$message.= "\n";
				$message.="Username: ".$email . "\n";
				$message.="Password: ".$pword . "\n";
				$message.= "\n";
				$message.= "The following features are available:" . "\n";
				$message.= "\n";
				$message.= "Search Products, View Wholesale Pricing, Place Orders Online." . "\n";
				$message.= "\n";
				$message.= "For more information or further assistance, please call us on 212.840.0846  or email ".INFO_EMAIL.".";
				
				//$headers  = "MIME-Version: 1.0" . "\n";
				//$headers .= "Content-type: text/html; charset=iso-8859-1" . "\n";

				//$headers .= "To: Instyle New York<no-reply@www.instylenewyork.com>\r\n";
				$headers = "From: ".SITE_NAME." TEAM <".INFO_EMAIL.">" . "\r\n";
				//$headers .= "rsbgm@yahoo.com\r\n"; // ----> for development purposes only
				$headers .= "Bcc: ".DEV1_EMAIL . "\r\n"; // ---> for debussing purposes
		
				//mail($email, $subject, $message, $headers); // ----> no email sending in adding users
			// End Email...............................

				$err = "User has been added." ;
				
				echo "
					<script>
						location.href='add_user_wholesale.php?err=$err';
					</script>
				";
			}
		}
	}
?>
<html>
<head>
<title>Fashion::Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type=text/css>
<script language="javascript" type="text/javascript" src="js/function.js"></script>
<script language="javascript">
function _check(){
	if(isEmpty('category','uname','Name')==false){
		return false;
	}
	if(isEmail('category','email','Email')==false){
		return false;
	}
	
	var lebel = window.document.getElementById('a_level').value;
	if(lebel != 'Level 0'){
		if(IsNumeric('category','perc','Discount Percent')==false){
			return false;
		}
	}
}
function dovalue(){
	var lebel = window.document.getElementById('a_level').value;
	if(lebel == 'Level 0'){
		window.document.getElementById('perc').value=0;
	}else{
		window.document.getElementById('perc').value="";
	}
}

</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function validForm(passForm) 
  {	
  
  	     if(passForm.txtemail.value=="")
	{
	  alert("Please enter Email");
	  document.category.txtemail.focus();
	  return false;
	}
	if(passForm.txtemail.value!= '')
	{
		var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
		if(!passForm.txtemail.value.match(emailExp) ) 
		{
		  alert("Please enter valid email");
			  document.category.txtemail.focus();
			  return false;
		}
	}
		/*if (passForm.txtfirstname.value == "") 
		 {
				alert("Please enter First Name")          
				document.category.txtfirstname.focus()
				return false
          }
		  
	  if (passForm.txtlastname.value == "") 
		 {
				alert("Please enter Last Name")          
				document.category.txtlastname.focus()
				return false
          }
	
		if (passForm.txtadd1.value == "") 
		 {
				alert("Please enter Address")          
				document.category.txtadd1.focus()
				return false
          }		
      if (passForm.txtadd2.value == "") 
		 {
				alert("Please enter Address")          
				document.category.txtadd2.focus()
				return false
          }		
      if (passForm.selcountry.value == "") 
		 {
				alert("Please select Country")          
				document.category.selcountry.focus()
				return false
          }	
		
		if (passForm.txtcity.value == "") 
		 {
				alert("Please enter City")          
				document.category.txtcity.focus()
				return false
          }		
	
		if (passForm.selstate.value == "") 
		 {
				alert("Please select State")          
				document.category.selstate.focus()
				return false
          }		
	
		if (passForm.txtzip.value == "") 
		 {
				alert("Please enter Zip/Postal code")          
				document.category.txtzip.focus()
				return false
          }*/
		 
		  
		return true;
	 }  
//-->
</script>
</head>

<body>

<table width="100%" border="0" cellpadding="1" cellspacing="1">
<tr><td>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor=gray >
		<tr>
            <td colspan="2" height=50 align="center">
				<font size=2  face="verdana,Arial"><b>Administration Section</b></font>
			</td>
		</tr>
		<tr>
            <td bgcolor="#ffffff"><div align="left">
			
                <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="gray">
					<tr>
						<td width="28%" align=center bgcolor="#cccccc" valign="top">

							<?php include 'admin_left_menu.php'; ?>
	
						</td>
						<td width="72%" class=partner valign=top align=center >&nbsp;&nbsp;

							<!-----------------start--------------------//-->
							<!--bof form=================================================================================-->
							<form name="category" action="<?php $_SERVER['PHP_SELF'];?>?action=add" method="post" onSubmit="return validForm(this)">
							<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
							<tr><td>
	
								<table width=100% align=center cellspacing=2 cellpadding=2>
									<tr bgcolor=cccccc> 
										<td align=center colspan=2><b><font size=2 color="#000000" face="verdana,Arial">ADD Wholesale User</font></td>
									</tr>
									<tr> 
										<?php
										if ( ! empty($err))
										{ ?> 
											<td align=center style="font-size:11pt; font-family:Arial, Helvetica, sans-serif;"colspan=2><font color=red><?=$err;?></font></td>
											<?php
										} ?>
									</tr>
									
									
									<tr>
										<td valign="middle" style="text-align:right; font-size:11pt; font-family:Arial, Helvetica, sans-serif;"><br /><font><span style="color:red;">*</span> Username :</font></td>
										<td><br /><input type="text" name="uname" class="textbox" value="" size="30" /> &nbsp; <span style="font-size:11pt;font-style:italic;color:red;">Email address too.</span></td>
									</tr>
									<tr> 
										<?php
										// ---------- (@2012-01-04-rey)
										// Removed default passwording and changing input to text so Joe can see the password
										?>
										<td valign="middle" style="text-align:right; font-size:11pt; font-family:Arial, Helvetica, sans-serif;"><font><span style="color:red;">*</span> Password :</font></td>
										<td><input type="text" name="pword" class="textbox" value="" size="30" /></td>
									</tr>
									<tr>
										<td valign="middle" style="text-align:right; font-size:11pt; font-family:Arial, Helvetica, sans-serif;"><font><font color="#FF0000">*</font>&nbsp;E-Mail Address :</font></td>
										<td><input type="text" name="email" class="textbox" value="" size="30"></td>
									</tr>
									<?php $array = array("Level 0","Level 1","Level 2","Level 3","Level 4","Level 5");?>
									<tr> 
										<td width="200" valign="middle" style="text-align:right;font-size:11pt; font-family:Arial, Helvetica, sans-serif;""><font>Level :</font></td>
										<td>
											<select name="access_level" id="a_level" onChange="javascript:dovalue();" class="sel">
											<?php
											for ($i = 0; $i <= 5; $i++)
											{
												if ($i == $row['access_level']) $selected = 'selected="selected"';
												else $selected = '';
												?>
												<option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo 'Level '.$i;?></option>
												<?php
											} ?>
											</select>
										</td>
									</tr>
									<tr>
										<td width="150" height="25" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;"><span style="color:red;">*</span> First Name :</td>
										<td align="left"><input name="firstname" type="text" class="textbox" id="txtfirstname" size="30" value="" /></td>
									</tr>
									<tr> 
										<td height="25" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;"><span style="color:red;">*</span> Last Name :</td>
										<td align="left"><input name="lastname" type="text" class="textbox" id="txtlastname" size="30" value="" /></td>
									</tr>
									<tr> 
										<td height="25" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;"><span style="color:red;">*</span> Store Name :</td>
										<td align="left"><input name="store_name" type="text" class="textbox" id="txtadd2" size="30"  value=""/></td>
									</tr>
									<tr> 
										<td height="25" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;"><span style="color:red;">*</span> Address 1 :</td>
										<td align="left"><input name="address1" type="text" class="textbox" id="txtadd1" size="30" value="" /></td>
									</tr>
									<tr> 
										<td height="25" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;">Address 2 :</td>
										<td align="left"><input name="address2" type="text" class="textbox" id="txtadd2" size="30"  value=""/></td>
									</tr>
									<tr> 
										<td height="25" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;">Federal Tax ID :</td>
										<td align="left"><input name="fed_tax_id" type="text" class="textbox" id="txtadd2" size="30"  value=""/></td>
									</tr>
									<tr>
										<td height="25" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;"><span style="color:red;">*</span> City :</td>
										<td align="left"><input name="city" type="text" class="textbox" id="txtcity" size="30" value="" /></td>
									</tr>
									<tr> 
										<td height="25" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;"><span style="color:red;">*</span> Country :</td>
										<td align="left">
											<select name="country" id="select" class="sel">
												<option value=''> - Select Country - </option>
												<?php
												$rst1 = mysql_query("select * from tblcountry") or die(mysql_error());
												while ($rw = mysql_fetch_array($rst1))
												{ ?>
													<option value='<?=$rw['countries_name']?>'><?=$rw['countries_name']?></option>
													<?php
												} ?>
											</select>
										</td>
									</tr>
									<tr> 
										<td height="25" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;"><span style="color:red;">*</span> State :</td>
										<td align="left">
											<select name="state" id="selstate" class="sel">
												<option value=''> - Select State - </option>
												<?php
												$rs = mysql_query("select * from tblstates") or die(mysql_error());
												while ($rw2 = mysql_fetch_assoc($rs))
												{ ?>
													<option value='<?=$rw2['state_name']?>' ><?=$rw2['state_name']?></option>
													<?php
												} ?>
											</select>
										</td>
									</tr>
									<tr> 
										<td height="25" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;"><span style="color:red;">*</span> Zip :</td>
										<td align="left"><input name="zipcode" type="text" class="textbox" id="txtzip" size="30" value="" /></td>
									</tr>
									<tr> 
										<td height="32" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;"><span style="color:red;">*</span> Telephone :</td>
										<td align="left"><input name="telephone" type="text" class="textbox" id="txtphone" size="30" value="" /></td>
									</tr>
									<tr> 
										<td height="25" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;">Fax :</td>
										<td align="left"><input name="fax" type="text" class="textbox" id="txtfax" size="30" value="" /></td>
									</tr>
									<tr> 
										<td height="25" class="search_head" style="font-size:11pt; font-family:Arial, Helvetica, sans-serif; text-align:right;">Is Active :</td>
										<td align="left">
											<select name="is_active" id="is_active" class="sel">
												<option value='1'>Active</option>
												<option value='0'>Inactive</option>
											</select>
										</td>
									</tr>
									
									<tr><td colspan="2"><br /></td></tr>
									<tr> 
										<td colspan=2 align=center>
											<input type="hidden" name="hidAction" value="add_user"> 
											<input type="submit" name="btnUpdate" tabindex="4" value="Add" class="button">
										</td>
									</tr>
									<tr><td colspan="2"><br /></td></tr>
								</table>
	
							</td></tr>
							</table>
							</form>
							<!--eof form=================================================================================-->
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
