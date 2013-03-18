<?php
	include("../common.php");
	include('../functionsadmin.php');
	include("security.php");


	//collect input values
	$strAction = $_POST['hidAction'];
	$user_name = $_POST['txtemail'];
	//$password = $_POST['password'];
	$email = $_POST['txtemail'];
	$time_out = $_POST['a_level'];


	if($strAction=='add_user')
	{

	if(empty($_REQUEST['txtemail'])) {
		$err= "<li>Please enter email address</li>";	
	}

	$get_email = @mysql_query("select * from tbluser where e_mail = '".$email."'");

	if(!ereg("^([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}$", $email)) {
		$err= "<li>You have entered an invalid email address</li>";	
	} 

	if(mysql_num_rows($get_email)>0) {
		$err= "<li>Email address already taken</li>";	
	}

	if(empty($_REQUEST['txtfirstname']) || empty($_REQUEST['txtlastname'])) {
		$err= "<li>Please enter first and last name</li>";	
	}



	 if($err=="")
	  {
	  
	  
	  $get_email = @mysql_query("select * from tbluser where e_mail = '".$email."'");
	  if(mysql_num_rows($get_email)>0) {
		$err= "<li>Email address already taken</li>";	
	}else{
	  
	  $rancode = RandomNumber(6);
	  $uname_usrname = $_REQUEST['txtfirstname'].' '.$_REQUEST['txtlastname'];
	  
	  $password = "instyle2011";		
	  $insert_query="insert into tbluser(`uname`,`user_name`,`user_password`,`e_mail`,`access_level`,`region`,`sales_rep`,`disc_percent`,`create_date`, `isregistered`) values('".$uname_usrname."','".$uname_usrname."','$password','$email','".$_POST['a_level']."','".$_POST['region']."','".$_POST['sales_rep']."','".$_POST['perc']."',CURDATE(),0)";
	  mysql_query($insert_query);
	 
	 $user_id = @mysql_insert_id();
	 $sqlins = sprintf("insert into tbluser_data (user_id, firstname, lastname, company, company_web, typeof_project, resale_number, resale_expiration, telephone, cellphone, fax, address1, address2, country, city, state_province, zip_postcode, how_hear_about, receive_productupd, register_status,dresssize) values('".$user_id."', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",$_REQUEST['txtfirstname'], $_REQUEST['txtlastname'], $_REQUEST['txtCompany'], $_REQUEST['txtCompanyWeb'],$Classification, $_REQUEST['txtResaleNo'], $_REQUEST['month']."-".$_REQUEST['year'], $_REQUEST['txtphone'], $_REQUEST['txtcell'], $_REQUEST['txtfax'], $_REQUEST['txtadd1'], $_REQUEST['txtadd2'], $_REQUEST['selcountry'], $_REQUEST['txtcity'], $_REQUEST['selstate'], $_REQUEST['txtzip'], $_REQUEST['txtbest'], $y_n, "wait".$rancode, $_REQUEST['dresssize']);  
			//die($sqlins);
			mysql_query($sqlins)or die("Error:".$sqlins);

	if($_REQUEST['receive_upd']=='yes'){
		$y_n = "Yes";
	  }else{
		$y_n = "No";
	  }


	if($y_n=="Yes"){
		$sqlcheck = sprintf("select * from tblemail_subscribe where email_addr = '%s' limit 1",$_REQUEST['txtemail']);
		$res =mysql_query($sqlcheck);
		$a = mysql_fetch_array($res);
			if(!isset($a['email_addr']) && $a['email_addr']==""){
				$insert_email="insert into tblemail_subscribe (email_id, email_addr, create_date) values(0, '$_REQUEST[txtemail]', now())"; 
				//mysql_query($insert_email);
			}
	}
	 
	 // start Email...........................
		$subject = "Automated Response from instylenewyork.com";
		
		$message="";
	  $message.="Dear ".$_REQUEST['txtfirstname'].",<div><p>Welcome to Instyle Newyork.<br>Your username and password:<br>Username: ".$_REQUEST['txtemail']."<br>Password: instyle2011</p><p>Click the link below to activate your account:<a href='http://instylenewyork.com/activate.php?user_id=".$user_id."' target='_blank'>http://instylenewyork.com/activate.php?user_id=".$user_id."</a></p><div><div><p>If the link above is not active, simply copy and paste to your browser address window.</p><p>Thanks,<br>Instyle Newyork Team.<br><br>";
	  
		
		/*$headers  = "MIME-Version: 1.0\r\n";
		$headers.= "Content-type: text/html; charset=iso-8859-1\r\n";*/

		//$headers .= "To: Instyle New York<no-reply@www.instylenewyork.com>\r\n";
		//$headers.= "From: <info@instylenewyork.com>\r\n";
		//$headers.= "Bcc: info@instylenewyork.com";
		
		 $headers = 'From:info@instylenewyork.com'. "\r\n".
			"Content-Type: text/html; charset=us-ascii\r\n";
		mail($email, $subject, $message, $headers);
	 // End Email...............................

	  $user_name='';
	  $password='';
		
	  $err="User has been added." ;	

	  echo 
		"<script>
		location.href='add_user.php?err=$err';	
		</script>";		

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

    <tr>
      <td > <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor=gray >
          <tr>
            <td colspan="2" height=50 align="center" >
             <font size=2  face="verdana,Arial">
              <b>Administration Section :: Welcome page</b> </font> </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff"><div align="left">
                <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="gray">
                  <tr>
                    <td width="28%" align=center bgcolor="#cccccc" valign="top">

                    <?include 'admin_left_menu.php';?>

                    </td>
                    <td width="72%" class=partner valign=top align=center >&nbsp;&nbsp;

                    <!-----------------start--------------------//-->
                    <form name="category" action="<?php $_SERVER['PHP_SELF'];?>" method="post" onSubmit="return validForm(this)">
                    <table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>

                    <table width=100% align=center cellspacing=2 cellpadding=2>
                              <tr bgcolor=cccccc> 
                                <td align=center colspan=2><b><font size=2 color="#000000" face="verdana,Arial">ADD 
                                  User</font> </td>
                              </tr>
                              <tr> 
                               <? if(!empty($err)) {?> 
								<td align=center colspan=2><font size=1 face=verdana color=red> 
                                  <?=$err;?></font>                                </td>
								<? } ?>
                              </tr>
                            
                             <!-- <tr> 
                                <td valign=top><font size=2 color="#000000" face="verdana,Arial">&nbsp;&nbsp;User Name 
                                  :</font></td>
                                <td><input type="text" name="uname" class="textbox" value="<?=$uname;?>"></td>
                              </tr>
							  -->
                              <!--<tr> 
                                <td valign=top><font size=2 color="#000000" face="verdana,Arial">Password:</font></td>
                                <td><input type="password" name="password" class="textbox" value="<?=$password;?>"></td>
                              </tr>-->
                              <tr> 
                                <td valign=top><font size=2 color="#000000" face="verdana,Arial">&nbsp;&nbsp;E-Mail Address: <font color="#FF0000">*</font></font></td>
                                <td><input type="text" name="txtemail" class="textbox" value="<?=$e_mail;?>" size="30"></td>
                              </tr>
							  <tr> 
                                <td valign="top"><font size=2 color="#000000" face="verdana,Arial">&nbsp;&nbsp;levels:</font></td>
                                <td>
									<select name="a_level" id="a_level" onChange="javascript:dovalue();">
										<option value="">---Select---</option>
										<option value="Level 0">Level 0</option>
										<option value="Level 1">Level 1</option>
										<option value="Level 2">Level 2</option>
										<option value="Level 3">Level 3</option>
										<option value="Level 4">Level 4</option>
										<option value="Level 5">Level 5</option>
									</select>								</td>
                              </tr>
							 <tr> 
                                <td valign=top><font size=2 color="#000000" face="verdana,Arial">&nbsp;&nbsp;Discount Percent:</font></td>
                                <td><input type="text" name="perc" id="perc" class="textbox" value="0" size="3" maxlength="3" onKeyPress="javascript: _doInputNumberOnly();">&nbsp;%</td>
                              </tr>
							    <tr> 
                                <td valign=top><font size=2 color="#000000" face="verdana,Arial">&nbsp;&nbsp;Region:</font></td>
                                <td><input type="text" name="region" class="textbox" value="<?=$region;?>" size="30"></td>
                              </tr>
							  <tr>
							    <td colspan="2" align=center><hr></td>
						      </tr>
							  <tr>
							    <td colspan="2" align=center>
								<?php
								  $sqlstate="select * from tblstates order by state_name";
								  $rs=mysql_query($sqlstate);
								  
								  $sqlcountry="select * from tblcountry order by countries_name";
								  $rst=mysql_query($sqlcountry);
								?>
								
								<table border="0" cellspacing="0" cellpadding="0" width="98%" align="center">
<!--<tr>
						<td colspan="4" align="left" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Items marked with an asterisk (*) are required.</td>
					</tr>-->
				<tr> 
						<td width="37%" height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">First Name </td>
						  <td width="47%" align="left"><input name="txtfirstname" type="text" class="textbox" id="txtfirstname" size="30" /></td>
						  <td width="16%" colspan="2" rowspan="18">&nbsp;</td>
						  </tr>
						<tr> 
						<td width="37%" height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Last Name </td>
						  <td width="47%" align="left"><input name="txtlastname" type="text" class="textbox" id="txtlastname" size="30" /></td>
						  </tr>
                          <tr> 
						<td width="37%" height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Dress Size </td>
						  <td width="47%" align="left"><input name="dresssize" type="text" class="textbox" id="txtlastname" size="30" /></td>
						  </tr>
						<!--<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Company </td>
						  <td  align="left"><input name="txtCompany" type="text" class="textbox" id="txtCompany" size="30" /></td>
						  </tr>-->
						
						<tr> 
						 <td height="32" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Telephone:</td>
						 <td  align="left"><input name="txtphone" type="text" class="textbox" id="txtphone" size="30" /></td>
						 </tr>
						<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Cell :</td>
						  <td  align="left"><input name="txtcell" type="text" class="textbox" id="txtcell" size="30" /></td>
						  </tr>
						<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Fax </td>
						  <td  align="left"><input name="txtfax" type="text" class="textbox" id="txtfax" size="30" /></td>
						  </tr>
						<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Address 1 </td>
						  <td  align="left"><input name="txtadd1" type="text" class="textbox" id="txtadd1" size="30" /></td>
						  </tr>
						<tr> 
						  
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Address 2 </td>
						  <td  align="left"><input name="txtadd2" type="text" class="textbox" id="txtadd2" size="30" /></td>
						  </tr><tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Country </td>
						  <td  align="left"><select name="selcountry" id="select">
							<? while($rw = mysql_fetch_assoc($rst))
							{  if (strtoupper($rw['countries_name'])=='UNITED STATES') {?>
							<option selected value='<?=$rw['countries_name']?>'>
							<?=$rw['countries_name']?>
							</option>
							<?php }else {?>
							<option value='<?=$rw['countries_name']?>'>
							<?=$rw['countries_name']?>
							</option>
							<?  }
						  }?>
						  </select></td>
						  </tr>
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">City </td>
						  <td  align="left"><input name="txtcity" type="text" class="textbox" id="txtcity" size="30" /></td>
						  </tr>
						<tr> 
						  
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">State / Province </td>
						  <td  align="left"><select name="selstate" id="selstate">
							<? while($row = mysql_fetch_assoc($rs))
							{ ?>
							<option value='<?=$row['state_name']?>'>
							<?=$row['state_name']?>
							</option>
							<? }?>
						  </select></td>
						  </tr>
						<tr> 
						  <td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Zip/Postal Code </td>
						  <td  align="left"><input name="txtzip" type="text" class="textbox" id="txtzip" size="30" /></td>
						  </tr>
						
						<tr> 
						<td height="25" valign="middle" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">How do you hear <br/>about In Style New York?</td>
						  <td colspan="3" valign="middle"  align="left"><input name="txtbest" type="text" class="textbox" id="txtbest" size="30" /></td>
						</tr>
					
						<tr> 
						<td height="25" valign="middle" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">&nbsp;</td>
						  <td colspan="3" valign="middle"  align="left" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Would you like to receive product updates from In Style New York by Email ?</td>
						</tr>
							<tr> 
						<td height="25" valign="top" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">&nbsp;</td>
						  <td colspan="3"  align="left" valign="middle">
							<table width="100%" cellpadding="1" cellspacing="1" border="0">
								<tr>	
								<td valign="middle" width="30%"><input type="radio" name="receive_upd" value="yes" checked>&nbsp;Yes</td>
								<td valign="middle" width="70%"><input type="radio" name="receive_upd" value="no">&nbsp;No</td>
								</tr>
							</table>						</td>
						</tr>
						<tr>
							<td colspan="4"><hr></td>
						</tr>
</table>								</td>
						      </tr>
							  <tr>
							    <td align=center>&nbsp;</td>
							    <td align=center>&nbsp;</td>
						      </tr>
                              <tr> 
                                <td colspan=2 align=center>
						 <input type="hidden" name="hidAction" value="add_user"> 
					<input type="submit" name="btnUpdate" tabindex="4" value="Add" class="button">                                </td>
                              </tr>
                            </table>

                    </td></tr></table>
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
