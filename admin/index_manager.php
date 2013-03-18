<?
include("../common.php");
include 'top.php'; 

if(@$_REQUEST['submit']=='Submit' && $_REQUEST['desc1'] != '' && $_REQUEST['link'] != '' && $_REQUEST['title'] != '')
	{	
		$title = trim($_REQUEST['title']);
		$desc = trim($_REQUEST['desc1']);
		$link = trim($_REQUEST['link']);
		
		$insert_query="insert into tblhome(title1,desc1,link,seq)values('".$title."','".$desc."','".$link."', 0)";
			mysql_query($insert_query);
				$err="Offer has been added";
	
	}

?>
<title><?php echo SITE_NAME; ?>::Admin Section</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">

	
<form name="form1" action="" method="POST" enctype="multipart/form-data">

	<table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
		<tr>
			<td width="99%" align="center" valign="middle"  class="tab" height="250">
				<table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
					<tr>
						<td>
							<table width=100% align=center cellspacing=2 cellpadding=2>
								<tr bgcolor=cccccc>
									<td align=center colspan=2><h1>ADD OFFERS</h1></td>
								</tr>
								<tr>
									<td align=center colspan=2 class="error"><? if(@$err) echo $err; ?></td>
								</tr>
								<tr>
									<td width="45%" class="text" align="right">Title : </td>
									<td width="55%" align="left"><input name="title" type="text" class="inputbox" size="39" value=""></td>
								</tr>
								<tr> 
									<td  align="right" valign=top class="text">Description : </td>
									<td  align="left"><textarea name="desc1" cols="30" rows="5" class="inputboxbig" style="padding:0px;"></textarea></td>
								</tr>
								<tr> 
									<td  align="right" valign=top class="text">Link : </td>
									<td  align="left"><input name="link" type="text" class="inputbox" size="39" value=""></td>
								</tr>                                              
								<tr>
									<td colspan=2 align=center><input type="submit" value="Submit" class=tab name="submit"> </td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
</table>

</form>
<? include 'footer.php'; ?>