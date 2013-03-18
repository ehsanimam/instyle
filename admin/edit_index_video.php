<?php
	session_start();
	include("../common.php");
	include("security.php");
	define("TABLE","`tbl_index_video`",true);
	$id = $_GET['id'];
	
	$sql = "SELECT * FROM ".TABLE." WHERE `video_id`=".$id;
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res);
	$old_image_path = "../images/slideshow-index/".$row['video_name'];
	
	if(isset($_POST['btnEdit'])):
		$image = $_FILES['upload_image'];
		$img_name = $image['name'];
		
		$sql = "SELECT * FROM ".TABLE." WHERE `video_name`='".$img_name."' AND `video_id` <> ".$id;
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0):
			$msg = "VIDEO ALREADY EXIST WITH THIS NAME";
		else:
			if(is_file($old_image_path)==true):
				unlink($old_image_path);
			endif;
			$path = "../images/slideshow-index/".$img_name;
			move_uploaded_file($image['tmp_name'],$path);
			chmod($path,0777);
			
			$sql = "UPDATE ".TABLE." SET `video_name`='".$img_name."' WHERE `video_id`=".$id;
			mysql_query($sql);
			$msg = "VIDEO HAS BEEN SUCCESSFULLY UPDATED";
			echo "<script>window.opener.location.reload();</script>";
		endif;
	endif;
	
	$sql = "SELECT * FROM ".TABLE." WHERE `video_id`=".$id;
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
		alert("Please provide a Our Vision Video    ");
		window.document.frm.upload_image.focus();
		return false;
	}
	/*var ext=fileVal.substr(fileVal.lastIndexOf(".")).toLowerCase();
	if(ext!=".swf") {
		alert("Video file should be .swf ");
		window.document.frm.upload_image.focus();
		window.document.frm.upload_image.select();
		return false;
	}*/
}
</script>
</head>
<body>
<table width="350" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="cccccc">
  <tr>
    <td><table width="350" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td height="20" colspan="2" align="center" bgcolor="cccccc"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Edit Index Video</font></b></td>
        </tr>
      <tr>
        <td width="41%">&nbsp;</td>
        <td width="59%">&nbsp;</td>
      </tr>
	  <form action="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>" method="post" name="frm" enctype="multipart/form-data" onSubmit="javascript:return CheckFileField();">
      <tr>
        <td align="center"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Choose Video :</font></b></td>
        <td><input name="upload_image" type="file" id="upload_image" size="15" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><b><font color="#006600" size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $row['video_name'];?></font></b>
		</td>
      </tr>
      <tr>
        <td colspan="2"><span style="font-size:10px;color:#CC0000;font-family:Verdana, Arial, Helvetica, sans-serif;"></span>		</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input name="btnEdit" type="submit" class="inputbox" id="btnEdit" value="Edit Video"></td>
      </tr>
	  </form>
      <tr>
        <td height="30" colspan="2" align="center"><b><font color="#990000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $msg;?></font></b></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>