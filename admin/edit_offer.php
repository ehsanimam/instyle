<?php
include("../common.php");
include 'top.php'; 

if($_GET['action'] == 'edit')
	{	
		$desc = trim($_POST['desc1']);
		$link = trim($_POST['link']);
		$title = trim($_POST['title']);
		
		$sql_up = "update tblhome set title1 = '".$title."' ,desc1='".$desc."' , link = '".$link."' where id='".$_GET['id']."'";
		$offer_up = mysql_query($sql_up);
			$err="Offer has been Updated.";
			
			echo '
			<script>
				window.location.href="edit_offer.php?n_id='.$_GET['id'].'&action=updated";
			</script>';
	}
else
	{
		$q = mysql_query("SELECT * FROM tblhome where id = ".$_GET['n_id']."") or die('Query error: '.mysql_error());
		$r = mysql_fetch_array($q);
	}			


?>
<title><?php echo SITE_NAME; ?>::Admin Section</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">

	
<form name="form1" action="edit_offer.php?id=<?php echo $_GET['n_id']; ?>&action=edit" method="POST" enctype="multipart/form-data">
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
									<td align=center colspan=2 class="error"><? if($_GET['action'] == 'updated') echo 'Offer has been Updated'; ?></td>
								</tr>
								<tr>
									<td width="45%" class="text" align="right">Title : </td>
									<td width="55%" align="left"><input name="title" type="text" class="inputbox" size="39" value="<?php  echo $r['title1']; ?>"></td>
								</tr>
								<tr> 
									<td  align="right" valign=top class="text">Description : </td>
									<td  align="left"><textarea name="desc1" cols="30" rows="5" class="inputboxbig" style="padding:0px;"><?php  echo $r['desc1']; ?></textarea></td>
								</tr>
								<tr> 
									<td  align="right" valign=top class="text">Link : </td>
									<td  align="left"><input name="link" type="text" class="inputbox" size="39" value="<?php  echo $r['link']; ?>"></td>
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
<td width="1%">
</tr>
</table>

</form>
<? include 'footer.php'; ?>