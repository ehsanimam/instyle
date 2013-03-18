<?php
include("../common.php");
include('../functionsadmin.php');
include("security.php");

 if($_GET['action']=='edit')
{
	$size_id= implode(",",$_POST['size_id']);
 $insert_query="update designer_size set size_id='$size_id' where desize_id='$eid'";
	mysql_query($insert_query);
print "<script>opener.location.href='edit_designer_size.php';window.close();</script>";
}
$select="select * from designer_size where desize_id='$eid'";
$result=mysql_query($select);
$num = mysql_num_rows($result);
$row=mysql_fetch_array($result);

$sql="select * from designer";
$qry = mysql_query($sql);
							
$sql1="select * from tblsize";
$qry1 = mysql_query($sql1);
$num1 = mysql_num_rows($qry1);

if(@$name=='')
{
 $name=$row['subcat_name'];
 $imgn=$row['img_name'];
}

?>
<title>7thavenuedirect::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<form name="subcategory" action="sizedes_edit_popup.php?action=edit" method="post" enctype="MULTIPART/FORM-data">
<input type="hidden" name=eid value="<?=$eid;?>">
<table width=85% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
	<table width=100% align=center cellspacing=2 cellpadding=2>
                <tr bgcolor=cccccc>
                  <td align=center colspan=2><h1>Edit Designer Size</h1></td>
                </tr>
                <tr>
                  <td align=center colspan=2 class=error>
                    <?=@$err;?>                  </td>
                </tr>
                <? if($num!=0){
								
					?>

                <tr>
                  <td width="55%" valign=top class="text" align="right">Select Designer : </td>
                  <td width="45%" align="left"> <select name="des_id" class=combobig disabled>
                      <option value="">Select</option>
                      <? while($row2=mysql_fetch_array($qry)){?>
                      <option value="<?=@$row2['des_id'];?>" <? if($row2[des_id] == $row['des_id']) echo "selected";?>><?=$row2['designer'];?>
                      </option>
                      <?}?>
                    </select></td>
                </tr>
                <?}?>
               <? if($num1!=0){
					$size_ids=explode(",",$row['size_id']);
					?>
                <tr>
                  <td width="55%" valign=top class="text" align="right">Select Size : </td>
                  <td width="45%" align="left"> <select name="size_id[]" class=combobig  multiple="multiple">
                      <option value="">Select</option>
                      <? while($row1=mysql_fetch_array($qry1)){?>
                      <option value="<?=@$row1['size_id'];?>" <?php echo in_array($row1['size_id'],$size_ids) ? 'selected' : ''; ?>><?=$row1['size_name'];?>
                      </option>
                      <?}?>
                    </select></td>
                </tr>
                <?}?>
				<tr>
                  <td>&nbsp;</td><td align="left"> <input type="submit" value="Edit" class=button> 
                  </td>
                </tr>
              </table>
</td></tr></table>
</form>