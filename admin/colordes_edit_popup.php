<?
include("../common.php");
include('../functionsadmin.php');
include("security.php");

 if($_GET['action']=='edit')
{

	 
		$color_id= implode(",",$_POST['color_id']);

  			
			$insert_query="update designer_color set color_id='".$color_id."' where des_id='".$_REQUEST['des_id']."'";
			$res=mysql_query($insert_query);
			
			if($res!=''){
			print "<script>opener.location.href='edit_designer_color.php?msg=1';window.close();</script>";
			}
			
			//$err="Designer Color has been edited.";
			
  
}
$select="select * from designer_color where des_id='$eid'";
$result=mysql_query($select);
$num = mysql_num_rows($result);
$row=mysql_fetch_array($result);

$sql="select * from designer where des_id='$eid'";
$qry = mysql_query($sql);
$row2=mysql_fetch_array($qry);
							
$sql1="select * from tblcolor";
$qry1 = mysql_query($sql1);
$num1 = mysql_num_rows($qry1);


?>
<title>7thavenuedirect::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<form name="subcategory" action="colordes_edit_popup.php?action=edit" method="post" enctype="MULTIPART/FORM-data">
<table width=85% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
	<table width=100% align=center cellspacing=2 cellpadding=2>
                <tr bgcolor=cccccc>
                  <td align=center colspan=2><h1>Edit Designer Color</h1></td>
                </tr>
                <tr>
                  <td align=center colspan=2 class=error>
                    <?=@$err;?>                  </td>
                </tr>
                <? if($num!=0){
								
					?>

                <tr>
                  <td width="55%" valign=top class="text" align="right"> Designer : </td>
                  <td width="45%" align="left"> <input type="text" name="<?=$row2['des_id']?>" class="inputbox" value="<? echo @$row2['designer'];?>"></td>
                </tr>
                <? }?>
               <? if($num1!=0){
					$color_ids=explode(",",$row['color_id']);
					?>
                <tr>
                  <td width="55%" valign=top class="text" align="right">Color : </td>
                  <td width="45%" align="left"> <select name="color_id[]" class=combobig  multiple="multiple">
                      <option value="">Select</option>
                      <? while($row1=mysql_fetch_array($qry1)){?>
                      <option value="<?=@$row1['color_id'];?>" <?php echo in_array($row1['color_id'],$color_ids) ? 'selected' : ''; ?>><?=$row1['color_name'];?>
                      </option>
                      <?}?>
                    </select></td>
                </tr>
                <?}?>
				<tr>
                  <td>&nbsp;</td><td align="left"><input type="hidden" name="des_id" value="<?=$eid?>"> <input type="submit" value="Edit" class=button> 
                  </td>
                </tr>
              </table>
</td></tr></table>
</form>