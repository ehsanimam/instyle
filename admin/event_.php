<?
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php");
$sql ="SELECT * FROM tblaboutus where a_type like '%event%' and a_id='3'";
		$r = mysql_query($sql);
		 $data = mysql_fetch_array($r);
	if(@$action=='add')
{
	if(@$name!='')
	{
	    
		$cid = admin_update_event($name);
		if($cid != -1)
			echo"<script language=javascript>location.href='event.php?err=1'</script>";
			}
	}
include 'top.php'; 
?>
<script>
function submit_form()
{
    document.category.method="post";
    document.category.action="event.php?action=add";
    document.category.submit();
    
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	<form name="category" action="event.php?action=add" method="post" enctype="MULTIPART/FORM-data">
                    <table width=90% border=1 bordercolor='cccccc' cellspacing=0 cellpadding=0><tr><td>
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>Events</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><? if(@$err) echo "Event Details has been updated."; ?></td></tr>
                   <tr><td colspan=2 align=center height="15"></td></tr>
				   <tr>
                  <!--<td  height="15" align="center" colspan="2" width="45%">Date:&nbsp;<input type="text" name="idate" size="20"></td></tr>
				   
                <tr> 
                  <td height="15" align="center" colspan="2" width="45%">Title:&nbsp;&nbsp;<input type="text" name="title" size="20"></td></tr>
				  <tr><td colspan=2  align="left" height="15" width="45%">Body:&nbsp;</td></tr>-->
				    <tr>
					<td width="45%" colspan="2" class="text" ><textarea  id="your_textarea" name="name"><?=@$data['a_desc'];?></textarea>
					<script language="JavaScript">
  generate_wysiwyg('your_textarea');
</script> </td></tr>
                   	<tr><td colspan=2 align=center><input type="submit" value="Submit" class=tab> 
					</td></tr>
                     </table>

                    </td></tr></table>
                    </form></td>
</tr>
</table>
<? include 'footer.php'; ?>