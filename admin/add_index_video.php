<?php
	session_start();
	include("../common.php");
	include("security.php");
	define("TABLE","`tbl_index_video`",true);
	
	if(isset($_POST['btnAdd'])):
		$image = $_FILES['upload_image'];
		$img_name = $image['name'];
		
		$sql = "SELECT * FROM ".TABLE." WHERE `video_name`='".$img_name."'";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0):
			$msg = "VIDEO ALREADY EXIST WITH THIS NAME";
		else:
			$path = "../images/slideshow-index/".$img_name;
			
			move_uploaded_file($image['tmp_name'],$path);
			chmod($path,0777);
			
			$sql = "INSERT INTO ".TABLE."(`video_name`) VALUES('".$img_name."')";
			mysql_query($sql);
			$msg = "VIDEO HAS BEEN SUCCESSFULLY ADDED";
			echo "<script>window.opener.location.reload();</script>";
		endif;
	endif;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="style.css" rel="stylesheet" type=text/css>
<title>Add Index Video</title>
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
		alert("Video file should be .swf");
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
        <td height="20" colspan="2" align="center" bgcolor="cccccc"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Add Index Video</font></b></td>
        </tr>
      <tr>
        <td width="41%">&nbsp;</td>
        <td width="59%">&nbsp;</td>
      </tr>
	  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="frm" enctype="multipart/form-data" onSubmit="javascript:return CheckFileField();">
      <tr>
        <td align="center"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Choose Video :</font></b></td>
        <td><input name="upload_image" type="file" id="upload_image" size="15" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center" style="font-size:10px;color:#CC0000;font-family:Verdana, Arial, Helvetica, sans-serif;"></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input name="btnAdd" type="submit" class="inputbox" id="btnAdd" value="Add Video"></td>
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