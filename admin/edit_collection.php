<?php
session_start();
	include("../common.php");
	include('../functionsadmin.php');
	include("security.php"); 
	define("TABLE","`tbl_press`",true);
	
	if($_GET['action'] == "Delete"):
		$sql = "SELECT * FROM ".TABLE." WHERE `press_id`=".$_GET['id'];
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		echo $image_name1 = $row['cover_img'];
		echo $image_name2 = $row['img_1'];
		echo $image_name3 = $row['img_2'];
		
		$image_path1 = 'press_cover/'.$image_name1;
		$image_path2 = 'press_cover/thumb/'.$image_name1;
		
		$image_path11 = 'press_1/'.$image_name2;
		$image_path22 = 'press_1/zoom/'.$image_name2;
		
		$image_path111 = 'press_2/'.$image_name3;
		$image_path222 = 'press_2/zoom/'.$image_name3;
				
			unlink($image_path1);
			unlink($image_path2);
			
			unlink($image_path11);
			unlink($image_path22);
			
			unlink($image_path111);
			unlink($image_path222);
			
	
		
		$sql = "DELETE FROM ".TABLE." WHERE `press_id`=".$_GET['id'];		
		mysql_query($sql);
		header("Location:edit_collection.php");
		exit();
	endif;
	
	$sql = "SELECT * FROM ".TABLE;
	$res = mysql_query($sql) or die(mysql_error());
	$records = mysql_num_rows($res);
	
	if(isset($_POST['btnWidth'])) {
		mysql_query("update press_img_width set width='".$_POST['width']."'");
	}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>In Style New York::Admin Section</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type=text/css>
<script language="javascript" type="text/javascript">
function LoadPopup(getFileName,getWindowName,getHeight,getWidth) {
	var _file = getFileName;
	var _window = getWindowName;
	var _toolbar = 0;
	var _menubar = 0;
	var _status = 1;
	var _resizable = 0;
	var _width = getWidth;
	var _height = getHeight;
	var _top = (screen.height - _height) / 2;
	var _left = (screen.width - _width) / 2;
	var _scrollbars = 1;
	
	var _condition = "toolbar=" + _toolbar + ",menubar=" + _menubar + ",status=" + _status + ",resizable=" + _resizable;
	_condition+=",width=" + _width + ",height=" + _height + ",left=" + _left + ",top=" + _top + ",scrollbars=" + _scrollbars + "";
	
	window.open(_file,_window,_condition);
}

function getDeleteConfirm(theURL) {
	var str="Are you sure to delete this image ?    ";
	choice=confirm(str);
	if(choice) {
		window.location.href=theURL;
	} else {
		return false;
	}
}
</script>
<style type="text/css">
<!--
.style1 {
	font-size: 11px;
	font-family: Verdana, Arial;
	color: #999999;
}
-->
</style>
</head>

<body link="#0000FF" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0" cellpadding="1" cellspacing="1">

    <tr>
      <td > <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor=gray >
          <tr>
            <td colspan="2" height=50 align="center" >
             <font size=2  face="verdana,Arial">
              <b>In Style New York Private Area Administration Section</b></font> </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff"><div align="left">
                <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="gray">
                  <tr>
                    <td width="34%" align=center bgcolor="#DCDCDC"><?php include('admin_left_menu.php');?></td>
                    <td width="66%" class=partner valign=top align=center ><table width="70%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
                          <tr>
                            <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                              <tr>
                                <td height="20" colspan="4" align="center" bgcolor="cccccc"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">List of Press Image</font></b></td>
                                </tr>
                              <tr>
                                <td width="62%" height="20" bgcolor="#DDDDDD" align="center"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Cover Image</font></b></td>
                                <td width="14%" align="center" bgcolor="#DDDDDD"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">View</font></b></td>
                                <td width="12%" height="20" align="center" bgcolor="#DDDDDD"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Edit</font></b></td>
                                <td width="12%" height="20" align="center" bgcolor="#DDDDDD"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Delete</font></b></td>
                              </tr>
							  <?php if($records == 0):?>
                              <tr>
                                <td height="100" colspan="4" align="center"><b><font color="#990000" size="2" face="Verdana, Arial, Helvetica, sans-serif">No Image Found</font></b></td>
                              </tr>
							  <?php
							  		else:
										while($row = mysql_fetch_array($res)):
											list($width, $height, $type, $attr) = getimagesize("press_1/".$row['img_1']);

							  ?>
                              <tr bgcolor='eeeeee' onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='eeeeee'">
                                <td height="20">&nbsp;<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#663333"><b><?php echo $row['cover_img'];?></b></font></td>
                                <!--<td align="center"><a href="javascript:LoadPopup('<?php echo 'press_cover/thumb/'.$row['cover_img'];?>','<?php echo $row['press_id'];?>','<?php echo $height + 40;?>','<?php echo $width + 30;?>');"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">View</font></a></td>-->
								<td align="center"><a href="javascript:LoadPopup('view_press.php?id=<?php echo $row['press_id'];?>','ViewImage','<?php echo $height + 40;?>','<?php echo $width + 30;?>');"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">View</font></a></td>								
                                <td height="20" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="javascript:LoadPopup('edit_collection_image.php?id=<?php echo $row['press_id'];?>','WinEdit','400','600');">Edit</a></font></td>
                                <td height="20" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="<?php echo $_SERVER['PHP_SELF'].'?action=Delete&id='.$row['press_id'];?>" onClick="javascript:getDeleteConfirm(this); return false;">Delete</a></font></td>
                              </tr>
							  <?php
							  			endwhile;
							  		endif;
							  ?>                            
                            </table></td>
                          </tr>
                        </table>  <br>
						<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
						 <table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=2>
						 <tr><td bgcolor="#cccccc">
						 <b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Press Image Width</font></b>
						 </td></tr>
						 <tr><td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
						 <?php
						 $img_width = mysql_fetch_array(mysql_query("select * from press_img_width")) or die(mysql_error());
						 ?>
						 <strong>Width:</strong> <input type="text" style="width:40px;" name="width" value="<?=$img_width['width']?>"> &nbsp; 
						 &nbsp;<input type="submit" name="btnWidth" value="Save">
						 </font>
						 </td></tr>
						 </table>
						 </form>
						                      
						</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table></td>
    </tr>

</table>
</body>
</html>
