<?php
	include("../common.php");
	include("security.php");
	
	if(@$action=='add')
	{
		if(@$name!='')
		{
			$chkcolor = "select * from tblcolor where color_name ='$name' OR color_code ='".$_POST['code']."'";
			$hcolor = mysql_query($chkcolor);
			
			if(mysql_num_rows($hcolor) <= 0)
			{
				$color_na=explode(" ",$name);
			
				if($color_na[1]=="")
				{
					$col_na=substr($color_na[0], 0, 4);
					$col3=$col_na;
				}
				else
				{
					$col_na1=substr($color_na[0], 0, 2); 
					$col_na2=substr($color_na[1], 0, 2);
					$col3=$col_na1.$col_na2; 
				} 
			
				$col_name3=strtoupper($col3); 
				$col_code=$col_name3."1";

				$insert_query="insert into tblcolor(color_name,color_code)values('".$name."','".$_POST['code']."')";
				mysql_query($insert_query);
				$err="Color has been added.";
				$name='';
				$code='';
			}
			else
			{
				$err="Color name/code already exists.";
			}
		}
		else
		{
			$err="Please enter color name.";
		}
	}

	include 'top.php'; 
?>
<title><?php echo SITE_NAME;?> :: Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td height="333" class="tab" align="center" valign="middle">
	
	<!--bof form============================================================================-->
	<form name="size" action="add_color.php?action=add" method="post">
	<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
	<tr><td>
		<table width=100% align=center cellspacing=2 cellpadding=2>
			<tr bgcolor=cccccc><td align=center colspan=2><h1>ADD Color</h1></td></tr>
			<tr><td align=center colspan=2 class="error"><?=@$err;?></td></tr>
			<tr>
				<td class="text" align="right">Color Name : </td>
				<td align="left"><input type="text" name="name" class="inputbox" value="<?=@$name;?>"></td>
			</tr>
			<tr>
				<td class="text" align="right">Color Code : </td>
				<td align="left"><input type="text" name="code" class="inputbox" value="<?=@$code;?>"></td>
			</tr>
			<tr><td colspan=2 align=center><input type="submit" value="Add" class=button> </td></tr>
		</table>
	</td></tr>
	</table>
	</form>
	<!--eof form============================================================================-->
	
</td></tr>
</table>
<?php include 'footer.php';