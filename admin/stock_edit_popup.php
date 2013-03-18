<?php
include("../common.php");

if($action=='edit')
{


 if($size1!='' && $size2!='' && $size3!='' && $color!='' && $stock!='')
  {

  	$update_query="update tblproduct_size set wood_type='$wood',size_id1='$size1',size_id2='$size2',size_id3='$size3', size_id4='$size4',size_id5='$size5',color_id='$color',stock='$stock' where p_id='$eid'";
	mysql_query($update_query);
	$err="Stock updated";
	print "<script>opener.location.href='edit_size_product.php?prod_id=$prd_id&err=$err';window.close();</script>";
  }
  else
  {
   $err="Please complete all the entries.";
	}
}

$select="select * from tblproduct_size where p_id='$eid'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);
$prd_id=$row[prod_id];
$woodType = $row['wood_type'];
$siz1=$row['size_id1'];
$siz2=$row['size_id2'];
$siz3=$row['size_id3'];
$siz4=$row['size_id4'];
$siz5=$row['size_id5'];

$colo=$row['color_id'];
/*$str="select * from tblsize where size_id='$row[size_id]'";
$res1=mysql_query($str);
$siz=mysql_result($res1,0,1);
						
$str="select * from tblcolor where color_id='$row[color_id]'";
$res1=mysql_query($str);
$colo=mysql_result($res1,0,1);
*/
$str="select * from tblproduct where prod_id='$row[prod_id]'";
$res1=mysql_query($str);
$prod=mysql_result($res1,0,1);
						
$str="select * from tblproduct_details where det_id='$row[part_id]'";
$res1=mysql_query($str);
$part=mysql_result($res1,0,2);

$stock=$row[stock];

if($name=='')
{
 $name=$row[size_name];
}

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
                    <form name="size" action="stock_edit_popup.php?eid=<?=$eid;?>&action=edit" method="post">
                    <table width=100% border="1" bordercolor="cccccc" cellspacing="0" cellpadding="0">
					<tr>
					<td>
                    <input type="hidden" name=eid value="<?=$eid;?>"><input type="hidden" name="prd_id" value="<?=$prd_id;?>">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><b>
                    <font size=2 color="#000000" face="verdana,Arial">Edit Stock</td></tr>
                    <tr><td align=center colspan=2><b><font size=2 face=verdana color=red><?=$err;?></td></tr>
                     <tr>
					 	<td valign=top width="50%" class="text" align="right">Product Name : </td>
                    	<td width="50%" class="text"><?=$prod;?></td></tr>
                     <tr>
                       <td valign=top class="text" align="right">Part Name : </td>
                       <td class="text"><?=$part;?></td>
                     </tr>
                     <tr>
						<td class="text" align="right">Wood Type: </td>
						<td><input name="wood" type="text" id="wood" class="inputbox" value="<?=$woodType;?>"></td>
						</tr>
					 <tr>
                       <td valign=top class="text" align="right">Size1 : </td>
                       <td class="text"><input type="text" name="size1" class="inputbox" value="<?=$siz1;?>"></td>
                     </tr>					
					 <tr>
                       <td valign=top class="text" align="right">Size2 : </td>
                       <td class="text"><input type="text" name="size2" class="inputbox" value="<?=$siz2;?>"></td>
                     </tr>
					
					 <tr>
                       <td valign=top class="text" align="right">Size3 : </td>
                       <td class="text"><input type="text" name="size3" class="inputbox" value="<?=$siz3;?>"></td>
                     </tr>
					
					  <tr>
                       <td valign=top class="text" align="right">Size4 : </td>
                       <td class="text"><input type="text" name="size4" class="inputbox" value="<?=$siz4;?>"></td>
                     </tr>
					
					  <tr>
                       <td valign=top class="text" align="right">Size5 : </td>
                       <td class="text"><input type="text" name="size5" class="inputbox" value="<?=$siz5;?>" ></td>
                     </tr>
					
                     <tr>
                       <td valign=top class="text" align="right">Color : </td>
                       <td class="text"><input type="text" name="color" class="inputbox" value="<?=$colo;?>"></td>
                     </tr>
                     <tr>
                       <td valign=top class="text" align="right">Stock : </td>
                       <td><input type="text" name="stock" class="inputbox" value="<?=$stock;?>"></td>
                     </tr>
                     <tr><td colspan=2 align=center><input type="submit" value="edit" class=button> </td></tr>
                     </table>
                    </td></tr></table>
                    </form>
                     <!-------end-------//-->
                    </td>
                  </tr>
                </table>