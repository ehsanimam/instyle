<?php
	session_start();
	include("../common.php");
	include('../functionsadmin.php');
	include("security.php"); 
	define("TABLE","`tbl_contract`",true);
	
	if($_GET['action'] == "Delete"):
		$sql = "SELECT * FROM ".TABLE." WHERE `id`=".$_GET['id'];
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		$image_name = $row['img'];
		
		$image_path1 = 'contract/'.$image_name;
		$image_path2 = 'contract/thumb/'.$image_name;
		$image_path3 = 'contract/zoom/'.$image_name;
		
			unlink($image_path1);
			unlink($image_path2);
			unlink($image_path3);
	
		
		$sql = "DELETE FROM ".TABLE." WHERE `id`=".$_GET['id'];		
		mysql_query($sql);
		header("Location:edit_contract.php");
		exit();
	endif;
	
	$sql = "SELECT * FROM ".TABLE;
	$res = mysql_query($sql) or die(mysql_error());
	$records = mysql_num_rows($res);
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
	var _scrollbars = 0;
	
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
                                <td height="20" colspan="5" align="center" bgcolor="cccccc"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">List of contract Image</font></b></td>
                                </tr>
                              <tr>
                                <td width="52%" height="20" bgcolor="#DDDDDD">&nbsp;<b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Image Name</font></b></td>
								<td width="12%" height="20" bgcolor="#DDDDDD">&nbsp;<b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Type</font></b></td>
                                <td width="12%" align="center" bgcolor="#DDDDDD"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">View</font></b></td>
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
											list($width, $height, $type, $attr) = getimagesize("contract/zoom/".$row['img']);

							  ?>
                              <tr bgcolor='eeeeee' onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='eeeeee'">
                                <td height="20">&nbsp;<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#663333"><b><?php echo $row['img'];?></b></font></td>
                                <td height="20">&nbsp;<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#663333"><b><?php echo $row['type'];?></b></font></td>
								<td align="center"><a href="javascript:LoadPopup('<?php echo 'contract/zoom/'.$row['img'];?>','<?php echo $row['id'];?>','<?php echo $height + 40;?>','<?php echo $width + 30;?>');"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">View</font></a></td>
                                <td height="20" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="javascript:LoadPopup('edit_contract_image.php?id=<?php echo $row['id'];?>','WinEdit','400','600');">Edit</a></font></td>
                                <td height="20" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="<?php echo $_SERVER['PHP_SELF'].'?action=Delete&id='.$row['id'];?>" onClick="javascript:getDeleteConfirm(this); return false;">Delete</a></font></td>
                              </tr>
							  <?php
							  			endwhile;
							  		endif;
							  ?>                            
                            </table></td>
                          </tr>
                        </table>                        
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
