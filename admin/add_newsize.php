<?
session_start();
include("../common.php");
include("security.php");
if(@$action=='add')
{
	 if(@$name!='')
	 {
  		$chkcolor = "select * from size  where size_name ='$name'";
		$hcolor = mysql_query($chkcolor);
		if(mysql_num_rows($hcolor) <= 0)
		{	
			$insert_query="insert into tblsize(size_name)values('$name')";
			mysql_query($insert_query);
			$err="Size has been added.";
			$name='';
		}else
			$err="Size already exists.";
			
  	}
  	else
  	{
   		$err="Please enter Size name.";
	}
}


include 'top.php'; 
?>
<title>Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	<form name="size" action="add_newsize.php?action=add" method="post">
                    <table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>ADD SIZE</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><?=@$err;?></td></tr>

                    <tr>
						<td class="text" align="right">Size Name : </td>
	                    <td align="left"><input type="text" name="name" class="inputbox" value="<?=@$name;?>"></td>
					</tr>
    	                <tr><td colspan=2 align=center><input type="submit" value="Add" class=button> </td></tr>
                     </table>

                    </td></tr></table>
                    </form>
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>