<?php
session_start();
include("../common.php");

if(@$action=='add')
{
	 if(@$designer_type!='')
	 {
  		$chkcolor = "select * from designer_type where designer_type='$designer_type'";
		$hcolor = mysql_query($chkcolor);
		if(mysql_num_rows($hcolor) <= 0)
		{	
			$insert_query="insert into designer_type(designer_type, catid)values('$designer_type','".$_POST['catid']."')";
			mysql_query($insert_query);
			$err="Designer type has been added.";
			$name='';
		}else
			$err="Type already exists.";
			//header('location:add_color.php?err='.$err);
			
  	}
  	else
  	{
   		$err="Please enter designer type.";
	}
}


include 'top.php'; 
?>
<title>Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">	
		<form name="size" action="<?php echo $_SERVER['PHP_SELF'];?>?action=add" method="post">
		<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
		<table width=100% align=center cellspacing=2 cellpadding=2>
		<tr bgcolor=cccccc><td align=center colspan=2><h1>ADD Designer Type</h1></td></tr>
		<tr><td align=center colspan=2 class="error"><?=@$err;?></td></tr>

		<tr>
			<td class="text" align="right">Designer Type : </td>
			<td align="left"><input type="text" name="designer_type" class="inputbox" value="<?=@$designer_name;?>"></td>
		</tr>
		<tr>
			<td class="text" align="right">Category : </td>
			<td align="left">
			<select name="catid">
				<option> - select category - </option>
				<?php
				$heading = mysql_query("select * from tblcat");
				if(mysql_num_rows($heading) > 0) {
					while($row = mysql_fetch_array($heading)) {
						?> <option value="<?=$row['cat_id']?>"><?=$row['cat_name']?></option> <?php
					}
				}
				?>
			</select>
			</td>
		</tr>
			<tr><td colspan=2 align=center><input type="submit" value="Add" class=button> </td></tr>
		 </table>

		</td></tr></table>
		</form>
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>