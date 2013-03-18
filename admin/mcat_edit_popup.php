<?
include("../common.php");
include('../functionsadmin.php');
include("security.php");

$strFile1        =  $_FILES["cat_image"]["name"];
$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];
$eid=$_GET["eid"];
if(@$action=='edit')
{

 if($name!='')
  {
	if(isset($_POST["subcat"]))
	$sarr=implode("|",$_POST["subcat"]);
	else
	$custom=$_POST["custom"];
	
  	if(isset($sarr) && $sarr!="")
	$update_query="update tblmajcat set cat_name='$name',def_subcat_id='$sarr',priority='$priority' where cat_id='$eid'";
	else
	$update_query="update tblmajcat set cat_name='$name',custom_redirect='$custom',priority='$priority' where cat_id='$eid'";
  	mysql_query($update_query);
//	die($cat_image.$_POST["cat_image"].$_FILES["cat_image"]["name"]);
	if ($cat_image!='')
	{
		admin_newmcatimg($strFile1, $eid);
		/*$strFile1        =  $_FILES["pdF"]["name"];
		$strTempFile1    =  $_FILES["pdF"]["tmp_name"];  
		move_uploaded_file($strTempFile1,"pdf/".strtolower($strFile1));*/
	}
	
	//******************************************** Price PDF
	   $strFile1_pdf_p  =  strtolower($_FILES["pdF_price"]["name"]);
	   $strTempFile1_pdf_p=  $_FILES["pdF_price"]["tmp_name"];  
   
		if (!empty($strTempFile1_pdf_p))
		{
				//Delete the image file from server
				//@unlink("pdf_price/".$strFile1_pdf_p);
				move_uploaded_file($strTempFile1_pdf_p,"pdf_price/".$strFile1_pdf_p);
				
				$sql_pdf_p="update tblmajcat set pdf_p='$strFile1_pdf_p' where cat_id ='$eid'";
 
				mysql_query($sql_pdf_p) or die("Error updating tblcat");
		}
	//********************************************************
	//******************************************* Color PDF
		$strFile1_pdf_c  =  strtolower($_FILES["pdF_color"]["name"]);
	    $strTempFile1_pdf_c=  $_FILES["pdF_color"]["tmp_name"];  
   
		if (!empty($strTempFile1_pdf_c))
		{
				//Delete the image file from server
				//@unlink("pdf_color/".$strFile1_pdf_c);
				move_uploaded_file($strTempFile1_pdf_c,"pdf_color/".$strFile1_pdf_c);
				
				$sql_pdf_c="update tblmajcat set pdf_c='$strFile1_pdf_c' where cat_id ='$eid'";
 
				mysql_query($sql_pdf_c) or die("Error updating tblcat");
		}
		
	//*****************************************************	
		
	print "<script>opener.location.href='edit_majcategory.php';window.close();</script>";
  }
  else
  {
   $err="Please complete all the entries.";
}
}

$select="select * from tblmajcat where cat_id='$eid'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);


if(@$name=='')
{
 $name=$row['cat_name'];
 $imgn=$row['cat_img'];
 $imgs=$row['img_name'];
 if($row['def_subcat_id']!="" && $row['def_subcat_id']!="NULL")
 $def_subcat_id=explode("|",$row['def_subcat_id']);
 else
 $custom=$row['custom_redirect'];
 $priority=$row['priority'];
}

$select="select * from tblmright where which_page='$eid' order by img_date desc";
$res=mysql_query($select);
$rw=mysql_fetch_array($res);

?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<form name="category" action="mcat_edit_popup.php?eid=<?=$eid;?>&action=edit" method="post" enctype="MULTIPART/FORM-data">
<table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
<input type="hidden" name=eid value="<?=$eid;?>">
	<table width=100% align=center cellspacing=2 cellpadding=2>
          <!--DWLayoutTable-->
          <tr bgcolor=cccccc> 
            <td align=center colspan=2><h1>Edit Category</h1></td>
          </tr>
          <tr>
            <td align=center colspan=2 class="error">
              <?=@$err;?>
            </td>
          </tr>
          <tr> 
            <td width="460" valign=top class="text" align="right">Category Name 
              : </td>
            <td width="413"><input type="text" name="name" class="inputbox" value="<?=$name;?>"></td>
          </tr>
          <tr> 
            <td width="460" valign=top class="text" align="right">SubCategory Name 
              : </td>
            <td width="413">
			<? $str="select * from tblsubcat";
				$str_exec=mysql_query($str)or die(mysql_error());
			?>
			<select name="subcat[]" multiple="multiple" size="10">
			<? while($rst=mysql_fetch_assoc($str_exec))
			{   ?>
				<option value="<?=$rst['subcat_id']?>" <? if(isset($def_subcat_id) && is_array($def_subcat_id)){if(@in_array($rst['subcat_id'],$def_subcat_id)){ ?> selected <? }}?>><?=$rst['subcat_name']?></option>
			<? }
			?>
			
			</select></td>
          </tr>
<tr>
			<td class="text" align="right">Custom Redirect : </td>
			<td align="left"><input type="text" name="custom" id="custom" class="inputbox" value="<?=$custom?>"></td>
           </tr>
          <tr>
            <td align=center colspan=2 class="error"><img src="../images/category/<?=$imgn;?>"></td>
          </tr>
          <tr>
			<td class="text" align="right">Upload PDF(Price List) : </td>
			<td align="left"><input type="file" name="pdF_price" id="pdF_price" class="inputbox"></td>
           </tr>
		     <tr>
			<td class="text" align="right">Upload PDF(Color List) : </td>
			<td align="left"><input type="file" name="pdF_color" id="pdF_color" class="inputbox"></td>
           </tr>
		  <tr> 
            <td class="text" align="right">Upload Big New Image : </td>
            <td align="left"><input type="file" name="cat_image" class="inputbox"></td>
          </tr>
          <tr> 
            <td height="30" colspan="2" align="center" valign="top"><span class="text" style="color:#FF0000">(image 
              size should be 7500(w) x568(h) px)</span></td>
          </tr>
				<tr>
                      <td valign=top align=right class="text" >Priority (affects the order in which category is displayed 1-127)</td>
                     	<td width="55%" align="left"><input type="text" name="priority" class="inputbox" value="<? echo @$priority;?>"></td>
					</tr>
          <? 
	  	for($cnt=0;$cnt<4;$cnt++)
   		{
   			$imgn=@mysql_result($res,$cnt,1);
			$rid=@mysql_result($res,$cnt,0);
			$sub_id=@mysql_result($res,$cnt,3);
			$rowid="rowid".$cnt;   		
	  ?>
          <? }?>
          <tr>
            <td colspan=2 align=center><input type="submit" value="Update" class=button> 
            </td>
          </tr>
        </table>
</td></tr></table>
</form>