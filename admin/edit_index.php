<?
include("../common.php");
include('../functionsadmin.php');
include 'top.php'; 

if($action=='edit')
{
	if($cat_image!='')
	{
		update_mainimage($cat_image);
	}
	for ($x=2;$x<6;$x++)
	{
		$nam="subcat".$x;
		$tos="toshow".$x;
		if($$nam!='' && $$tos!='')
		{
			update_index_cat_values($$nam, $$tos, $x);
		}
	}
}


$select="select * from tblindex where Id='1'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);
$imgn=$row[main_img];

?>
<script>
function submit_form()
{
    document.index.method="post";
    document.index.action="edit_index.php";
	document.index.submit();
    
}
</script>
<script>
function back_display()
{
    location.href="admin_home.php"
}
</script>
<form name="index" action="edit_index.php?&action=edit" method="post" enctype="MULTIPART/FORM-data">
<table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
	<table width=100% align=center cellspacing=2 cellpadding=2>
	  <!--DWLayoutTable-->
	<tr bgcolor=cccccc>
		<td height="29" colspan=4 align=center><h1>Edit Index page </h1></td></tr>
	<tr><td height="30"  align="center" colspan=4 class="error"><?=$err;?></td></tr>
	<tr><td height="36" colspan=4 align=center class="error"><img src="../images/<?=$imgn;?>"></td></tr>
	<tr>
			<td width="352" height="28" align="right" class="text">Upload New Main Image : </td>
			<td colspan="3" align="left"><input type="file" name="cat_image" class="button"></td>
	</tr>
	<tr>
	  <td height="30" colspan="4" align="center" valign="top"><span class="text" style="color:#FF0000">(image size should be 400(w) x 400(h) px)</span></td>
	  </tr>
	  <tr>
	  <td height="30" colspan="4" align="center"><h1>Sub-category on index page</h1></td>
	  </tr>
	  <? 
	  	for($cnt=2;$cnt<6;$cnt++)
   		{
   			$nam="subcat".$cnt;
			$tos="toshow".$cnt;
			$select="select * from tblindex where Id='$cnt'";
  			$res=mysql_query($select);
			$imgs=mysql_result($res,0,1);
			$cid=mysql_result($res,0,2);
			if($imgs=='0')
			{
				$dirt="";
				$igs="no_img.jpg";
			} 
			else
			{
				if($imgs=="tblcat")
				{
					$dirt="smallcategory/";
					$sql="select * from tblcat where cat_id='$cid'";
					$r=mysql_query($sql);
					$ro=mysql_fetch_array($r);
					$igs=$ro[img_name];
				}
				
				if($imgs=="tblmanufacturer")
				{
					$dirt="smallmanufaturer/";
					$sql="select * from tblmanufacturer where manufacturer_id='$cid'";
					$r=mysql_query($sql);
					$ro=mysql_fetch_array($r);
					$igs=$ro[small_img];
				}
				
				if($imgs=="tbltrend")
				{
					$dirt="smalltrend/";
					$sql="select * from tblcat where trend_id='$cid'";
					$r=mysql_query($sql);
					$ro=mysql_fetch_array($r);
					$igs=$ro[small_img];
				}
			}  		
	  ?>
	  <tr>
	    <td height="30" colspan="2" align="right"><img src="../images/<?=$dirt;?><?=$igs;?>">&nbsp;</td>
	    <td width="182"><select name="<?=$nam;?>" class="combobig" onchange='submit_form()'>
		<option value='0'>Select</option>
		<? if($imgs=='tblcat') {?>
		<option value='tblcat' selected="selected">Category</option>
		<? echo "selected";} else {?>
		<option value='tblcat'>Category</option>
		<? }?>
		<? if($imgs=='tblmanufacturer') {?>
		<option value='tblmanufacturer' selected>Manufacturer</option>
		<? echo "selected"; } else {?>
		<option value='tblmanufacturer'>Manufacturer</option>
		<? }?>
		<? if($imgs=='tbltrend') {?>
		<option value='tbltrend' selected>Trend</option>
		<? } else {?>
		<option value='tbltrend'>Trend</option>
		<? }?>		
		</select><script>document.index.<?=$nam;?>.value="<?=$$nam;?>"</script></td>
	    <td width="319">
			<?
				if ($$nam=='tblcat')
					{get_cat($cnt);} 
				elseif 
					($$nam=='tblmanufacturer'){get_manu($cnt);}
				elseif 
					($$nam=='tbltrend'){get_t($cnt);}
				else {get_subcat_index($cnt);}
			?><script>document.index.<?=$tos;?>.value="<?=$$tos;?>"</script><input type="hidden" name="count" value="<?=$cnt;?>">		
		</td>
	  </tr>
	  <? }?>
	<tr><td height="28" colspan=4 align=center><input type="submit" value="Update" class=button> <input type="button" name="cmd_cat_cancel"  class=button value="Cancel" onClick="back_display();"></td></tr>
	<tr>
	  <td height="7"></td>
	  <td width="3"></td>
	  <td></td>
	  <td></td>
	</tr>
	</table>
</td></tr></table>
</form>
<? include 'footer.php'; ?>