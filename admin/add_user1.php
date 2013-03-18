<?php
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php");

	function Now()
	{
		$tm = getdate(time(0));
		return sprintf("%d-%02d-%02d %02d:%02d:%02d", $tm['year'], $tm['mon'], $tm['mday'], $tm['hours'], $tm['minutes'], $tm['seconds']);
	}

 $msg="";
  $sqlstate="select * from tblstates order by state_name";
  $rs=mysql_query($sqlstate);
  
  $sqlcountry="select * from tblcountry order by countries_name";
  $rst=mysql_query($sqlcountry);
  
  if($_REQUEST['clf']!='others'){
  	$Classification = $_REQUEST['clf'];
  }else{
  	$Classification = $_REQUEST['others'];
  }
  
  if($_REQUEST['receive_upd']=='yes'){
  	$y_n = "Yes";
  }else{
  	$y_n = "No";
  }
  
  if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']!=null)
  {
		$rancode = RandomNumber(6);
		$sqlins = sprintf("insert into tbluser_data (user_id, firstname, lastname, company, company_web, typeof_project, resale_number, resale_expiration, telephone, cellphone, fax, address1, address2, country, city, state_province, zip_postcode, email, how_hear_about, receive_productupd, register_status) values(0, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' )",$_REQUEST['txtfirstname'], $_REQUEST['txtlastname'], $_REQUEST['txtCompany'], $_REQUEST['txtCompanyWeb'],$Classification, $_REQUEST['txtResaleNo'], $_REQUEST['month']."-".$_REQUEST['year'], $_REQUEST['txtphone'], $_REQUEST['txtcell'], $_REQUEST['txtfax'], $_REQUEST['txtadd1'], $_REQUEST['txtadd2'], $_REQUEST['selcountry'], $_REQUEST['txtcity'], $_REQUEST['selstate'], $_REQUEST['txtzip'], $_REQUEST['txtemail'], $_REQUEST['txtbest'], $y_n, "wait".$rancode);  
		mysql_query($sqlins)or die("Error:".$sqlins);
  
  
			$sqlsel = sprintf("select * from tbluser_data where register_status='wait%s'",$rancode);
			 $rs= MyQuery($sqlsel);
			 if($rs['user_id']!=""){
				 $user_pass =RandomNumber(8);
				$sqlgen = sprintf("insert into tbluser (user_id, uname, user_name, user_password, e_mail, access_level, region, sales_rep, disc_percent, create_date) values(%d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', %s, '%s' )",$rs['user_id'], $rs['firstname'], $rs['firstname'], $user_pass, $rs['email'], "0", "", "", "0", Now());
				mysql_query($sqlgen)or die("Error:".$sqlgen);

				  $strbody="";
				  $strbody.="
				  <table width='60%' border='0' align='center' cellpadding='0' cellspacing='0'>          
						 <tr bgcolor='#336699'>
						  <td colspan=2><font color='#ffffff'><stong>Welcome to Instyle New York</strong></font></td>
					 </tr>  
					<tr>
						  <td width='33%' height='25' >User Name :</td>
						  <td width='67%'>{$rs['firstname']}</td>
						</tr>
						  <tr>
						  <td width='33%' height='25' >Password :</td>
						  <td width='67%'>{$user_pass}</td>
						</tr>
					  </table>";
						
				$to=sprintf("%s",$rs['email']);
				$subject = "Inform Username & Password";
				$body= $strbody;
				
				/*$headers  = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
				$headers .= "From:info@instylenewyork.com\r\n";*/
				
				//$headers .= 'Cc: database@innerconcept.com' . "\r\n";
				//$headers .= 'Bcc: database@innerconcept.com' . "\r\n";
				//$headers .= 'Bcc: bubun_ich@yahoo.co.in' . "\r\n";
				
				 $headers = 'From:info@instylenewyork.com'. "\r\n".
        "Content-Type: text/html; charset=us-ascii\r\n";
		
				if (mail($to, $subject, $body, $headers))
				{
					  $msg="User has been added." ;	
						
				}
					$sqlupd = sprintf("update tbluser_data set register_status='%s' where user_id=%d", Now(),$rs['user_id']);  
					mysql_query($sqlupd)or die("Error:".$sqlupd);
			 }
  echo 
	"<script>
	location.href='add_user1.php?err=$msg';	
	</script>";		
  }
?>

<html>
<head>
<title>Fashion::Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type=text/css>
<script language="javascript" type="text/javascript" src="js/function.js"></script>
<script language="javascript">

	function _do(){
		var c = document.getElementById('clf').value;
		if(c == 'others'){
			document.getElementById('oth').style.display='';
			document.getElementById('others').focus();
			document.getElementById('others').select();
		}else{
			document.getElementById('oth').style.display = 'none';
		}
		
	}

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
                    <form name="category" action="<?php $_SERVER['PHP_SELF'];?>" method="post" onSubmit="javascript:return _check();" >
                    <table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>

                    <table width=100% align=center cellspacing=2 cellpadding=2>
                              <tr bgcolor=cccccc> 
                                <td align=center colspan=4><b><font size=2 color="#000000" face="verdana,Arial">ADD 
                                  User</font> </td>
                              </tr>
                              <tr> 
                               <? if(!empty($err)) {?> 
								<td align=center colspan=2><font size=1 face=verdana color=red> 
                                  <?=$err;?></font>                                </td>
								<? } ?>
                              </tr>
                            <tr> 
						<td width="20%" height="25" class="search_head">First Name <font color="#FF0000">*</font></td>
						  <td width="37%" align="left"><input name="txtfirstname" type="text" class="inputbox" id="txtfirstname" size="30" /></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr> 
						<td width="20%" height="25" class="search_head">Last Name <font color="#FF0000">*</font></td>
						  <td width="37%" align="left"><input name="txtlastname" type="text" class="inputbox" id="txtlastname" size="30" /></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr> 
						<td height="25" class="search_head">Company <font color="#FF0000">*</font></td>
						  <td  align="left"><input name="txtCompany" type="text" class="inputbox" id="txtCompany" size="30" /></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr> 
						<td height="25" class="search_head">Company Website</td>
						  <td  align="left"><input name="txtCompanyWeb" type="text" class="inputbox" id="txtCompanyWeb" size="30" /></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
							<tr> 
						<td height="30" class="search_head" valign="middle">Type of Project:</td>
						  <td class="search_head" valign="middle"  align="left">
						  <select name="clf" id="clf" onChange="javascript:_do();">
						  	<option value="">---Please choose one---</option>
							<option value="Designer">Designer</option>
							<option value="Architect">Architect</option>
							<option value="Retailer">Retailer</option>
							<option value="Consumer">Consumer</option>
							<option value="others">Other (please specify)</option>
						  </select>						  </td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr id="oth" style="display:none;">
									<td width="16%" height="25" class="search_head" valign="middle">&nbsp;</td>
									<td width="44%" class="search_head" valign="top"><input type="text" name="others" id="others" class="inputbox" value="please specify"></td>
									<td width="10%">&nbsp;</td>
									<td width="30%">&nbsp;</td>
								</tr>
						<tr> 
						<td height="25" class="search_head">Resale Number</td>
						  <td  align="left"><input name="txtResaleNo" type="text" class="inputbox" id="txtResaleNo" size="30" /></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr> 
						<td height="25" class="search_head">Resale Expiration</td>
						  <td  align="left"><select name="month" id="month">
							<option value="">Month</option>  
							<option value="jan">January</option>  
							<option value="feb">Febuary</option>  
							<option value="mar">March</option>  
							<option value="apr">April</option>  
							<option value="may">May</option>  
							<option value="jun">June</option>  
							<option value="jul">July</option>  
							<option value="aug">August</option>  
							<option value="sep">September</option>  
							<option value="oct">October</option>  
							<option value="nov">November</option>  
							<option value="dec">December</option>  
						</select>
						<select name="year" id="year">
							<option value="">Year</option>  
							<option value="2010">2010</option>  
							<option value="2011">2011</option>  
							<option value="2012">2012</option>  
							<option value="2013">2013</option>  
							<option value="2014">2014</option>  
							<option value="2015">2015</option>  
							<option value="2016">2016</option>  
							<option value="2017">2017</option>  
							<option value="2018">2018</option>  
							<option value="2019">2019</option>  
							<option value="2020">2020</option>  
							<option value="2021">2021</option>  
							<option value="2022">2022</option>  
							<option value="2023">2023</option>  
							<option value="2024">2024</option>  
							<option value="2025">2025</option>  
							<option value="2026">2026</option>  
							<option value="2027">2027</option>  
							<option value="2028">2028</option>  
							<option value="2029">2029</option>  
							<option value="2030">2030</option>  
						</select>
						</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr> 
						 <td height="32" class="search_head">Telephone:</td>
						 <td  align="left"><input name="txtphone" type="text" class="inputbox" id="txtphone" size="30" /></td>
						 <td class="search_head" align="left">Cell :<font color="#FF0000">*</font></td>
						 <td  align="left"><input name="txtcell" type="text" class="inputbox" id="txtcell" size="30" /></td>
						</tr>
						<tr> 
						<td height="25" class="search_head">Fax </td>
						  <td  align="left"><input name="txtfax" type="text" class="inputbox" id="txtfax" size="30" /></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr> 
						<td height="25" class="search_head">Address 1 <font color="#FF0000">*</font></td>
						  <td  align="left"><input name="txtadd1" type="text" class="inputbox" id="txtadd1" size="30" /></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr> 
						  
						<td height="25" class="search_head">Address 2 <font color="#FF0000">*</font></td>
						  <td  align="left"><input name="txtadd2" type="text" class="inputbox" id="txtadd2" size="30" /></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr> 
						  <tr> 
						<td height="25" class="search_head">Country <font color="#FF0000">*</font></td>
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
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<td height="25" class="search_head">City <font color="#FF0000">*</font></td>
						  <td  align="left"><input name="txtcity" type="text" class="inputbox" id="txtcity" size="30" /></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr> 
						  
						<td height="25" class="search_head">State / Province <font color="#FF0000">*</font></td>
						  <td  align="left"><select name="selstate" id="selstate">
							<? while($row = mysql_fetch_assoc($rs))
							{ ?>
							<option value='<?=$row['state_name']?>'>
							<?=$row['state_name']?>
							</option>
							<? }?>
						  </select></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr> 
						  <td height="25" class="search_head">Zip/Postal Code <font color="#FF0000">*</font></td>
						  <td  align="left"><input name="txtzip" type="text" class="inputbox" id="txtzip" size="30" /></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr> 
						  <td height="25" class="search_head">Email <font color="#FF0000">*</font></td>
						  <td  align="left"><input name="txtemail" type="text" class="inputbox" id="txtemail" size="30" /></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr> 
						<td height="25" valign="middle" class="search_head">How do you hear <br/>about In Style New York?</td>
						  <td colspan="3" valign="middle"  align="left"><input name="txtbest" type="text" class="inputbox" id="txtbest" size="30" /></td>
						</tr>
					
						<tr> 
						<td height="25" valign="middle" class="search_head">&nbsp;</td>
						  <td colspan="3" valign="middle"  align="left" class="search_head">Would you like to receive product updates from In Style New York by Email ?</td>
						</tr>
							<tr> 
						<td height="25" valign="top" class="search_head">&nbsp;</td>
						  <td valign="middle"  align="left">
							<table width="100%" cellpadding="1" cellspacing="1" border="0">
								<tr>	
								<td valign="middle" width="30%"><input type="radio" name="receive_upd" value="yes">&nbsp;Yes</td>
								<td valign="middle" width="70%"><input type="radio" name="receive_upd" value="no">&nbsp;No</td>
								</tr>
							</table>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;</td>
						</tr>
						<tr> 
						  <td height="25" >&nbsp;</td>
						  <td align="left"><input name="Submit" type="submit" class="submit" value=" Save " /></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
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
