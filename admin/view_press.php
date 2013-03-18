<?php
	include("../common.php");
	define("IMG_PATH_1","press_cover/thumb/",true);
	define("IMG_PATH_2","press_1/",true);
	define("IMG_PATH_3","press_2/",true);
	
	$sql ="Select * from `tbl_press` where press_id='".$_GET['id']."'";
	$res =mysql_query($sql);
	$res2 =mysql_query($sql);
	$rows = mysql_fetch_array($res);
	$img_zoom_1 = IMG_PATH_2.$rows['img_1'];
	$img_zoom_2 = IMG_PATH_3.$rows['img_2'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<body>
	<table cellpadding="0" cellspacing="0" width="100%" border="0">
		<?php if(empty($rows['cover_img'])==false){ ?>
		<tr>
			<td><img src="<?php echo IMG_PATH_1.$rows['cover_img'];?>" border="0" /></td>
		</tr>
		<?php } ?>
		<tr>
			<td height="20"></td>
		</tr>
		<?php
			if(empty($rows['img_1'])==false){	
		?>
			<tr>
				<td valign="top"><img src="<?php echo $img_zoom_1; ?>" border="0"></td>
			</tr>
		<?php } ?>	
		<tr>
			<td height="20"></td>
		</tr>
		<?php 
			if(empty($rows['img_2'])==false){	
		?>
		<tr>
			<td valign="top"><img src="<?php echo $img_zoom_2; ?>" border="0"></td>
		</tr>
		<tr>
			<td height="10">&nbsp;</td>
		</tr>	
		<?php } ?>
	</table>
</body>
</html>
