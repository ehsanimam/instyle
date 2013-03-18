<?php
	include("../common.php");
	include("security.php");
	
	define("TABLE","`tbl_index_image`",true);
	$id = $_GET['id'];
	
	$sql = "SELECT * FROM ".TABLE." WHERE `image_id`=".$id;
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res);
	$old_image_path = "../images/slideshow-index/".$row['image_name'];
	$old_image_path_var = IMG_REPO_URL_VAR."images/slideshow-index/".$row['image_name'];
	
	if(isset($_POST['btnEdit'])):
		$image = $_FILES['upload_image'];
		$img_name = $image['name'];
		
		$sql = "SELECT * FROM ".TABLE." WHERE `image_name`='".$img_name."' AND `image_id` <> ".$id;
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0):
			$msg = "IMAGE ALREADY EXIST WITH THIS NAME";
		else:
			if(is_file($old_image_path)==true):
				@unlink($old_image_path);
				@unlink($old_image_path_var);
			endif;
			$path = "../images/slideshow-index/".$img_name;
			move_uploaded_file($image['tmp_name'],$path);
			chmod($path,0777);
			
			// copy uploaded file to image repository
			copy($path, IMG_REPO_URL_VAR."/images/slideshow-index/".$img_name);
			
			$sql = "UPDATE ".TABLE." SET `image_name`='".$img_name."' WHERE `image_id`=".$id;
			mysql_query($sql);
			$msg = "IMAGE HAS BEEN SUCCESSFULLY UPDATED";
			echo "<script>window.opener.location.reload();</script>";
		endif;
	endif;
	
	$sql = "SELECT * FROM ".TABLE." WHERE `image_id`=".$id;
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="style.css" rel="stylesheet" type=text/css>
<title>Edit Index Image</title>
<script language="javascript" type="text/javascript">
function CheckFileField() {
	var fileVal= window.document.frm.upload_image.value;
	if(fileVal=="")	{
		alert("Please provide a Our Vision Image    ");
		window.document.frm.upload_image.focus();
		return false;
	}
	var ext=fileVal.substr(fileVal.lastIndexOf(".")).toLowerCase();
	if(ext!=".gif" && ext!=".jpeg" && ext!=".tif" && ext!=".jpg") {
		alert("Image file should be .gif or .tif or .jpeg format    ");
		window.document.frm.upload_image.focus();
		window.document.frm.upload_image.select();
		return false;
	}
}
</script>
</head>
<body>
<table width="350" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="cccccc">
  <tr>
    <td><table width="350" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td height="20" colspan="2" align="center" bgcolor="cccccc"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Edit Index Image</font></b></td>
        </tr>
      <tr>
        <td width="41%">&nbsp;</td>
        <td width="59%">&nbsp;</td>
      </tr>
	  <form action="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>" method="post" name="frm" enctype="multipart/form-data" onSubmit="javascript:return CheckFileField();">
      <tr>
        <td align="center"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Choose Image :</font></b></td>
        <td><input name="upload_image" type="file" id="upload_image" size="15" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><b><font color="#006600" size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $row['image_name'];?></font></b>
		</td>
      </tr>
      <tr>
        <td colspan="2"><span style="font-size:10px;color:#CC0000;font-family:Verdana, Arial, Helvetica, sans-serif;">Image size: 753px(width) X 580px(height) </span>		</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input name="btnEdit" type="submit" class="inputbox" id="btnEdit" value="Edit Image"></td>
      </tr>
	  </form>
      <tr>
        <td height="30" colspan="2" align="center"><b><font color="#990000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo isset($msg) ? $msg : '';?></font></b></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>