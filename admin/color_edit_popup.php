<?php
	include("../common.php");

	if(@$action=='edit')
	{
		if ((@$name!='') or (@$col_code!=''))
		{
			$update_query="update tblcolor
					 set color_name='$name',color_code='$col_code' 
					 where color_id='$eid'";
			mysql_query($update_query);
			echo 'Color Updated...';
			print "<script>opener.location.href='edit_color.php';window.close();</script>";
		}
		else  
		{
			$err="Color already exists.";
		}

		print "<script>opener.location.href='edit_color.php';window.close();</script>";
	}

	$select="select * from tblcolor where color_id='$eid'";
	$result=mysql_query($select);
	$row=mysql_fetch_array($result);

	if(@$name=='')
	{
		$name=$row['color_name'];
	}

	if(@$col_code=='')
	{
		$col_code=$row['color_code'];
	}
?>
<title><?php echo SITE_NAME; ?> :: Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="1" cellspacing="1">
<tr><td>
	<!--bof form============================================================================-->
	<form name="color" action="color_edit_popup.php?eid=<?=$eid;?>&action=edit" method="post">
	<table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
	<tr><td>
		<input type="hidden" name=eid value="<?=@$eid;?>">
		<table width=100% align=center cellspacing=2 cellpadding=2>
			<tr bgcolor=cccccc><td align=center colspan=2><b><font size=2 color="#000000" face="verdana,Arial">Edit Color</td></tr>
			<tr><td align=center colspan=2><b><font size=2 face=verdana color=red><?=@$err;?></td></tr>
			<tr>
				<td valign=top><font size=2 color="#000000" face="verdana,Arial">Color Name:</td>
				<td><input type="text" name="name" class="inputbox" value="<?=@$name;?>"></td>
			</tr>
			<tr>
				<td valign=top><font size=2 color="#000000" face="verdana,Arial">Color Code:</td>
				<td><input type="text" name="col_code" class="inputbox" value="<?=@$col_code;?>"></td>
			</tr>
			<tr><td colspan=2 align=center><input type="submit" value="edit" class=button> </td></tr>
		</table>
	</td></tr>
	</table>
	</form>
	<!--eof form============================================================================-->
</td></tr>
</table>