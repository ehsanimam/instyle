<?
session_start();
include("../common.php");
include("security.php");
if(@$_POST['insert']=='Submit')
{
 $date=$_POST['idate'];
 $pagename =$_POST['pagename'];
 $title =$_POST['title'];
 $desc =$_POST['desc'];
 $keyword =$_POST['keyword'];
 $sql ="insert into tblmeta(id, pagename, title, description, keyword)";
 $sql.="values(0,'$pagename','$title','$desc','$keyword')";
 $res = mysql_query($sql);
 if(mysql_affected_rows()>0)
 {
   header("location:metadata.php?err=1");
 }
}
include 'top.php'; 
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	<form name="category" action="" method="post" enctype="MULTIPART/FORM-data">
                    <table width=90% border=1 bordercolor='cccccc' cellspacing=0 cellpadding=0><tr><td>
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>Meta Data</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><? if(@$err) echo "page name has been Added."; ?></td></tr>
                   <tr><td colspan=2 align=center height="15"></td></tr>
				    <tr><td  height="15" colspan="2" align="center">PageName:&nbsp;<input type="text" name="pagename" ></td></tr>
				    <tr><td  height="15" colspan="2" align="center">Title:&nbsp;<input type="text" name="title" ></td></tr>
				    <tr>	<td width="45%" class="text" align="center" colspan="2"><textarea  cols="40" rows="10" name="desc"></textarea></td></tr>
                   	<tr>	<td width="45%" class="text" align="center" colspan="2"><textarea  cols="40" rows="10" name="keyword"></textarea></td></tr>
                   	<tr><td colspan=2 align=center><input type="submit" value="Submit" class=tab name="insert"> </td></tr>
                     </table>

                    </td></tr></table>
                    </form></td>
</tr>
</table>
<? include 'footer.php'; ?>