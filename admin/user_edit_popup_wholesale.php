<?php
	include("../common.php");
	include('../functionsadmin.php');
	//include('security.php');

	if (isset($_GET['action']) && $_GET['action'] == 'edit')
	{
		if ($_POST['is_active'] == '1')
		{
			$active_date = "active_date = '".date('Y-m-d', time())."',";
		}
		else $active_date = '';

		$update_user_data = "
			UPDATE tbluser_data_wholesale 
			SET 
				email			= '".$_POST['email']."',
				pword			= '".$_POST['pword']."',
				store_name		= '".addcslashes($_POST['store_name'],'\'')."',
				firstname		= '".$_POST['firstname']."',
				lastname		= '".$_POST['lastname']."',
				fed_tax_id		= '".$_POST['fed_tax_id']."',
				address1		= '".$_POST['address1']."',
				address2		= '".$_POST['address2']."',
				city			= '".$_POST['city']."',
				country			= '".$_POST['country']."',
				state			= '".$_POST['state']."',
				zipcode			= '".$_POST['zipcode']."',
				telephone		= '".$_POST['telephone']."',
				fax				= '".$_POST['fax']."',
				access_level	= '".$_POST['access_level']."',
				".$active_date."
				is_active		= '".$_POST['is_active']."' 
			WHERE email = '".$_GET['eid']."'
		";
		mysql_query($update_user_data) or die ('Updating error: '.mysql_error());
		
		if ($_POST['is_active'] == '1')
		{
			if (isset($_POST['control']) && $_POST['control'] == 'admin')
			{
				print "
					<script>
						window.location.href='edit_user_wholesale.php?eid=".$_POST['email']."&action=activate';
					</script>
				";
			}
			else
			{
				print "
					<script>
						opener.location.href='edit_user_wholesale.php';
						window.close();
					</script>
				";
			}
		}
		else
		{
			if (isset($_POST['control']) && $_POST['control'] == 'admin')
			{
				print "
					<script>
						window.location.href='edit_user_wholesale_inactive.php';
					</script>
				";
			}
			else
			{
				print "
					<script>
						opener.location.href='edit_user_wholesale_inactive.php';
						window.close();
					</script>
				";
			}
		}
	}  

	$select = "SELECT * FROM tbluser_data_wholesale WHERE email = '$eid'";
	$result = mysql_query($select);
	$row = mysql_fetch_array($result);

	if (isset($err) && $err == '')
	{
		$user_name = $row['user_name'];
		$password = $row['user_password'];
		$xmail = $row['e_mail'];
		echo '>>>>'.$xmail.":".$user_name;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Fashion :: Admin</title>
<link href='style.css' rel='stylesheet' type='text/css'>
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
	if (lebel == 'Level 0')
	{
		window.document.getElementById('perc').value=0;
	}
	else
	{
		window.document.getElementById('perc').value="";
	}
}
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function validForm(passForm) 
  {	
  
  	     if(passForm.email.value=="")
	{
	  alert("Please enter Email");
	  document.category.email.focus();
	  return false;
	}
	if(passForm.email.value!= '')
	{
		var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
		if(!passForm.email.value.match(emailExp) ) 
		{
		  alert("Please enter valid email");
			  document.category.email.focus();
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

	<!-----start-----------//-->
	<!--bof form======================================================================-->
	<form name="category" action="user_edit_popup_wholesale.php?eid=<?=$row['email'];?>&action=edit" method="post" onSubmit="javascript:return _check();"s>
	<table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
		<tr>
			<td>
				<input type="hidden" name=eid value="<?=$eid;?>">
				<input type="hidden" name="control" value="<?php echo isset($_GET['control']) ? $_GET['control'] : '';?>">
				
				<?php
				$sqlstate = "select * from tblstates order by state_name";
				$rs = mysql_query($sqlstate);
			  
				$sqlcountry = "select * from tblcountry order by countries_name";
				$rst = mysql_query($sqlcountry);
				?>
				
				<table width="100%" align=center cellspacing=2 cellpadding=2>
					<tr bgcolor=cccccc> 
						<td align=center colspan=2><b> <font size=2 color="#000000" face="verdana,Arial">Edit Wholeslae User</font></td>
					</tr>
					<tr> 
						<? if(!empty($err)){ ?>
						<td align=center colspan=2><font size=1 face=verdana color=red> 
						<?=$err;?>
						</font></td>
						<? } ?>
					</tr>
					<tr>
						<td valign=top style="text-align:right;"><font size=2 color="#000000" face="verdana,Arial">User Name :</font></td>
						<td><input type="text" name="uname" class="textbox" value="<?=$row['email'];?>" size="30" /></td>
					</tr>
					<tr> 
						<td valign=top style="text-align:right;"><font size=2 color="#000000" face="verdana,Arial">Password :</font></td>
						<td><input type="text" name="pword" class="textbox" value="<?=$row['pword'];?>" size="30" /></td>
					</tr>
					<tr>
						<td valign=top style="text-align:right;"><font size=2 color="#000000" face="verdana,Arial"><font color="#FF0000">*</font>&nbsp;E-Mail Address :</font></td>
						<td><input type="text" name="email" class="textbox" value="<?=$row['email'];?>" size="30"></td>
					</tr>
					<?php $array = array("Level 0","Level 1","Level 2","Level 3","Level 4","Level 5");?>
					<tr> 
						<td width="130" valign="top" style="text-align:right;"><font size=2 color="#000000" face="verdana,Arial">Level :</font></td>
						<td>
							<select name="access_level" id="a_level" onChange="javascript:dovalue();">
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
						<td width="150" height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">First Name :</td>
						<td align="left"><input name="firstname" type="text" class="textbox" id="txtfirstname" size="30" value="<?=$row['firstname']?>" /></td>
					</tr>
					<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">Last Name :</td>
						<td align="left"><input name="lastname" type="text" class="textbox" id="txtlastname" size="30" value="<?=$row['lastname']?>" /></td>
					</tr>
					<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">Store Name :</td>
						<td align="left"><input name="store_name" type="text" class="textbox" id="txtadd2" size="30"  value="<?=$row['store_name']?>"/></td>
					</tr>
					<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">Address 1 :</td>
						<td align="left"><input name="address1" type="text" class="textbox" id="txtadd1" size="30" value="<?=$row['address1']?>" /></td>
					</tr>
					<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">Address 2 :</td>
						<td align="left"><input name="address2" type="text" class="textbox" id="txtadd2" size="30"  value="<?=$row['address2']?>"/></td>
					</tr>
					<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">Federal Tax ID :</td>
						<td align="left"><input name="fed_tax_id" type="text" class="textbox" id="txtadd2" size="30"  value="<?=$row['fed_tax_id']?>"/></td>
					</tr>
					<tr>
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">City :</td>
						<td align="left"><input name="city" type="text" class="textbox" id="txtcity" size="30" value="<?=$row['city']?>" /></td>
					</tr>
					<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">Country :</td>
						<td align="left">
							<select name="country" id="select">
								<?php
								$rst1 = mysql_query("select * from tblcountry") or die(mysql_error());
								while ($rw = mysql_fetch_array($rst1))
								{ ?>
									<option value='<?=$rw['countries_name']?>'  <?php echo $rw['countries_name']==$row['country'] ? 'selected' : ''; ?>><?=$rw['countries_name']?></option>
									<?php
								} ?>
							</select>
						</td>
					</tr>
					<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">State :</td>
						<td align="left">
							<select name="state" id="selstate">
								<?php
								while ($rw2 = mysql_fetch_assoc($rs))
								{ ?>
									<option value='<?=$rw2['state_name']?>'  <?php echo $rw2['state_name']==$row['state'] ? 'selected' : ''; ?>><?=$rw2['state_name']?></option>
									<?php
								} ?>
							</select>
						</td>
					</tr>
					<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">Zip :</td>
						<td align="left"><input name="zipcode" type="text" class="textbox" id="txtzip" size="30" value="<?=$row['zipcode']?>" /></td>
					</tr>
					<tr> 
						<td height="32" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">Telephone :</td>
						<td align="left"><input name="telephone" type="text" class="textbox" id="txtphone" size="30" value="<?=$row['telephone']?>" /></td>
					</tr>
					<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">Fax :</td>
						<td align="left"><input name="fax" type="text" class="textbox" id="txtfax" size="30" value="<?=$row['fax']?>" /></td>
					</tr>
					<tr> 
						<td height="25" class="search_head" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:right;">Is Active :</td>
						<td align="left">
							<select name="is_active" id="is_active">
								<option value='1' <?php echo $row['is_active'] == '1' ? 'selected' : ''; ?>>Active</option>
								<option value='0' <?php echo $row['is_active'] == '0' ? 'selected' : ''; ?>>Inactive</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2"><hr></td>
					</tr>
					<tr> 
						<td colspan="2" align="center"><input type="submit" value="Update" class="button"></td>
					</tr>
				</table>
				
			</td>
		</tr>
	</table>
	</form>
	<!--eof form======================================================================-->
	<!-------end-------//-->
	
</td></tr>
</table>

</body>
</html>
