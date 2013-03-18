<?
session_start();
include("../common.php");
include("security.php");
 $sql="select * from tblhome";
  $res = mysql_query($sql);
  $row = mysql_fetch_array($res);
if(@$_POST['submit']=='submit')
{
$title1=$_POST['title1'];
$title2=$_POST['title2'];
$title3=$_POST['title3'];
$desc1=$_POST['desc1'];
$desc2=$_POST['desc2'];
$desc3=$_POST['desc3'];



//if(@$image1!='')
//{
if ($_FILES['image1']['name']!= ""){
	$imgcount=copy ($_FILES['image1']['tmp_name'], "../home/".$_FILES['image1']['name']) 
    or die ("Could not upload the image");	
	//unlink("files/".$_POST['messageid']."_".$_REQUEST['hidimg1']); 
	$image1=$_FILES['image1']['name'];
	}
else{
	$image1=$_POST['himage1'];
}
//----------------
if ($_FILES['image2']['name']!= ""){
	$imgcount=copy ($_FILES['image2']['tmp_name'], "../home/".$_FILES['image2']['name']) 
    or die ("Could not upload the image");	
	//unlink("files/".$_POST['messageid']."_".$_REQUEST['hidimg1']); 
	$image2=$_FILES['image2']['name'];
	}
else{
	$image2=$_POST['himage2'];
}
//----------------	
//----------------
if ($_FILES['image3']['name']!= ""){
	$imgcount=copy ($_FILES['image3']['tmp_name'], "../home/".$_FILES['image3']['name']) 
    or die ("Could not upload the image");	
	$image3=$_FILES['image3']['name'];
	}
else{
	$image3=$_POST['himage3'];
}
//----------------	
//$image1=$_FILES['image1']['name'];
//$timage1=$_FILES['image1']['tmp_name'];
/*if(is_uploaded_file($image1))
{
 move_uploaded_file($timage1,"../home/".$image1)or die("could not be uploaded");
}
}
else
{
$image1=$_POST['himage1'];
}
if(@$image2!='')
{
$image2=$_FILES['image2']['name'];
$timage2=$_FILES['image2']['tmp_name'];
if(is_uploaded_file($image2))
{
 move_uploaded_file($timage2,"../home/".$image2)or die("could not be uploaded");
}
}
else
{
$image2=$_POST['himage2'];
}
if(@$image3!='')
{
$image3=$_FILES['image3']['name'];
$timage3=$_FILES['image3']['tmp_name'];
if(is_uploaded_file($image3))
{
 move_uploaded_file($timage3,"../home/".$image3)or die("could not be uploaded");
}
}
else{
$image3=$_POST['himage3'];
}*/
$sql ="update tblhome set title1='$title1',title2='$title2',title3='$title3',";
$sql.="desc1='$desc1',desc2='$desc2',desc3='$desc3',";
$sql.="image1='$image1',image2='$image2',image3='$image3' where id=1";
$res= mysql_query($sql);
if(mysql_affected_rows()>0)
{
  header("location:index_manage.php?err=1");
 }
}
include 'top.php'; 
?>
<title>In Style New York::Admin Section</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">

	
	<form name="form1" action="" method="post" enctype="multipart/form-data">
                   
				   <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
<tr>
	  <td width="99%" align="left" valign="middle"  class="tab"><table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td align="center"><?php if(@$err){ echo "<font color=red>offer details has been updated</font>"; }?></td>
          </tr>
		  <tr>
            <td bgcolor=cccccc><span class="head">offer1</span></td>
          </tr>
		  <tr>
            <td><table width="80%" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td width="25%" align="right"><span class="text">Icon Alt:&nbsp;</span>&nbsp;</td>
                  <td align="left"><input name="title1" type="text" class="inputbox" size="30" value="<?=@$row['title1']?>"></td>
                </tr>
                <tr>
                  <td align="right"><span class="text">Icon Alt Tag:&nbsp;</span>&nbsp;</td>
                  <td align="left"><textarea name="desc1" cols="30" rows="5" class="textarea"><?=@$row['desc1']?></textarea>&nbsp;<img src="../home/<?=@$row['image1']?>" height="63" width="63"></td>
                </tr>
                <tr>
                  <td align="right"><span class="text">Link to Sub Category:&nbsp;</span>&nbsp;</td>
                  <td align="left"><input name="title1" type="text" class="inputbox" size="30" value="" style="background:white;border:1px solid black;"></td>
                </tr>
                <tr>
                  <td align="right"><span class="text">Products:&nbsp;</span>&nbsp;</td>
                  <td align="left"><input name="image1" type="file" class="inputbox" value="">&nbsp;
                    <font color="#FF0033">image size:167(w)x78(h)</font></td>
                </tr>
                 </table></td>
          </tr>
          <tr>
            <td bgcolor=cccccc><span class="head">offer2</span></td>
          </tr>
		   <tr>
            <td><table width="80%" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td width="25%" align="right"><span class="text">Title:</span>&nbsp;&nbsp;</td>
                  <td align="left"><input name="title2" type="text" class="inputbox" id="title2" size="30" value="<?=@$row['title2']?>"></td>
                </tr>
                <tr>
                  <td align="right"><span class="text">Description:</span>&nbsp;&nbsp;</td>
                  <td align="left"><textarea name="desc2" cols="30" rows="5" class="textarea" id="desc2"><?=@$row['desc2']?></textarea>&nbsp;<img src="../home/<?=@$row['image2']?>" height="63" width="63"></td>
                </tr>
                <tr>
                  <td align="right"><span class="text">Products:</span>&nbsp;&nbsp;</td>
                  <td align="left"><input name="image2" type="file" class="inputbox" value="" >&nbsp;<font color="#FF0033">image size:167(w)x78(h)</font></td>
                </tr>
                 </table></td>
          </tr>
          <tr>
            <td bgcolor=cccccc><span class="head">offer3</span></td>
          </tr>
		   <tr>
            <td><table width="80%" border="0" cellpadding="2" cellspacing="2">
                <tr>
                  <td width="25%" align="right"><span class="text">Title:</span>&nbsp;&nbsp;</td>
                  <td align="left"><input name="title3" type="text" class="inputbox" id="title3" size="30" value="<?=@$row['title3']?>"></td>
                </tr>
                <tr>
                  <td align="right"><span class="text">Description:</span>&nbsp;&nbsp;</td>
                  <td align="left"><textarea name="desc3" cols="30" rows="5" class="textarea" id="desc3"><?=@$row['desc3']?></textarea>&nbsp;<img src="../home/<?=@$row['image3']?>" height="63" width="63"></td>
                </tr>
                <tr>
                  <td align="right"><span class="text">Products:&nbsp;</span>&nbsp;</td>
                  <td align="left"><input name="image3" type="file" class="inputbox" value="" >&nbsp; <font color="#FF0033">image size:167(w)x78(h)</font></td>
                </tr>
				<tr><td colspan="2" height="20">&nbsp;</td></tr>
				<tr><td colspan="2" align="center"><input name="submit" type="submit" class="button" value="submit"></td></tr>
                 </table></td>
          </tr>
        </table>
<td width="1%">
</tr>
</table>
<input type="hidden" name="himage1" value="<?=@$row['image1']?>">
<input type="hidden" name="himage2" value="<?=@$row['image2']?>">
<input type="hidden" name="himage3" value="<?=@$row['image3']?>">
</form>
<? include 'footer.php'; ?>