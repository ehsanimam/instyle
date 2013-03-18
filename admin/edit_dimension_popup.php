<?php
include("../common.php");

if($action=='edit')
{


 if($price_!='')
  {

  	echo $update_query="update tbl_dimensions set price='$price_',size='$sizes_' where d_id='$eid'";
	mysql_query($update_query);
	$err="Price updated";
	echo "<script>opener.location.href='edit_dimension_price.php?prod_id=$prd_id&err=$err';window.close();</script>";	
  }
  else
  {
   $err="Please complete all the entries.";
  }
}

$select="select * from tbl_dimensions where d_id='$eid'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);
$prd_id=$row[prod_id];
$size=$row['size'];
$price=$row['price'];

?>

<title>7thavenuedirect::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<head>
<script language="javascript">
	function _doreturn(){
		document.prod_frm.submit();
	}
	
	function _number(){
	var key = window.event.keyCode;
	if(key >=48 && key <= 57)
	{
	 	return true;
	}else{
		return false;
	}	
}
</script>
</head>

<table width="100%" border="0" cellpadding="1" cellspacing="1">
    <tr>
      <td >
                    <!-----start-----------//-->
                    <form name="size" action="edit_dimension_popup.php?eid=<?=$eid;?>&action=edit" method="post">
                    <table width=100% border="1" bordercolor="cccccc" cellspacing="0" cellpadding="0">
					<tr>
					<td>
                    <input type="hidden" name=eid value="<?=$eid;?>"><input type="hidden" name="prd_id" value="<?=$prd_id;?>">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><b>
                    <font size=2 color="#000000" face="verdana,Arial">Edit</td></tr>
                    <tr><td align=center colspan=2><b><font size=2 face=verdana color=red><?=$err;?></td></tr>
                     <tr>
                       <td width="50%" align="right" valign=top class="text">Size : </td>
                       <td width="50%" class="text"><input type="text" class="inputbox" name="sizes_" id="sizes_" value="<?=$size;?>" /></td>
                     </tr>
                     <tr>
                       <td valign=top class="text" align="right">Price : </td>
                       <td><input type="text" name="price_" class="inputbox" value="<?=$price;?>"></td>
                     </tr>
                     <tr><td colspan=2 align=center><input type="submit" value="edit" class="button" onkeypress="_number();" > </td></tr>
                     </table>
                    </td></tr></table>
                    </form>
                     <!-------end-------//-->
                    </td>
                  </tr>
                </table>