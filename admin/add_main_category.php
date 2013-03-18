<?
session_start();
include("../common.php");
include("security.php");
if($action=='add')
{
	if($name!='')
 	{
  		$insert_query="insert into tblmaincat (main_cat_name) values ('$name')";
  		mysql_query($insert_query);
  		$err="Main Category has been added.";
  		$name='';
		//header('location:add_category.php?err='.$err);
  	}
  	else
  	{
   		$err="Please entries name of Main category.";
	}
}
include 'top.php'; 
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	
	<form name="category" action="add_main_category.php?action=add" method="post">
<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
	<table width=100% align=center cellspacing=2 cellpadding=2>
		<tr bgcolor=cccccc><td align=center colspan=2><h1>ADD Main Category</h1></td></tr>
		<tr><td align=center colspan=2 class="error"><?=$err;?></td></tr>
		<tr>
			<td class="text" align="right">Main Category Name : </td>
			<td align="left"><input type="text" name="name" class="textbox" value="<?=$name;?>"></td>
		</tr>
		<tr><td colspan=2 align=center><input type="submit" value="Add" class=button> </td></tr>
	</table>
</td></tr></table>
</form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>