<?php
	include("../common.php");
	include("security.php");
	
	define("TABLE","`tbl_index_image`",true);
	
	if(empty($_GET['action'])==false && $_GET['action'] == "Delete"):
		$sql = "SELECT * FROM ".TABLE." WHERE `image_id`=".$_GET['id'];
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		$image_name = $row['image_name'];
		
		$image_path = '../images/slideshow-index/'.$image_name;
		$image_path_repo = IMG_REPO_URL_VAR.'images/slideshow-index/'.$image_name;
		if(is_file($image_path)==true):
			if(is_writable($image_path)==true):
				@unlink($image_path);
				@unlink($image_path_repo);
			endif;
		endif;
		
		$sql = "DELETE FROM ".TABLE." WHERE `image_id`=".$_GET['id'];		
		mysql_query($sql);
	endif;
	
	$sql = "SELECT * FROM ".TABLE;
	$res = mysql_query($sql) or die(mysql_error());
	$records = mysql_num_rows($res);
	
	
	if(isset($_POST['btnSeq'])) {
		$get_seq = @mysql_query("select image_id from tbl_index_image") or die(mysql_error());
		while($row = @mysql_fetch_array($get_seq)) {
			@mysql_query("update tbl_index_image set seq='".$_POST[$row['image_id']]."' where image_id='".$row['image_id']."'");
		}
		$msg = '<center><span style="color:#ff0000;"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sequence has been updated</font></span></center>';
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo SITE_NAME; ?> :: Admin</title>
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
              <b><?php echo SITE_NAME; ?> Administration Section</b></font> </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff"><div align="left">
                <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="gray">
                  <tr>
                    <td width="34%" align=center bgcolor="#DCDCDC" style="vertical-align:top;"><?php include('admin_left_menu.php');?></td>
                    <td width="66%" class=partner valign=top align=center ><table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><a href="javascript:LoadPopup('add_index_image.php','WinAdd','300','500');"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Add Image</font></a></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>
						<?php echo isset($msg) ? $msg : ''; ?>
						<table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
                          <tr>
                            <td>
							<form method="post" name="frmseq" action="<?=$_SERVER['PHP_SELF']?>">							
							<table width="100%" border="0" cellspacing="1" cellpadding="5">
                              <tr>
                                <td height="20" colspan="7" align="center" bgcolor="cccccc"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">List of Index Image</font></b></td>
                                </tr>
                              <tr>
							  <td height="10" bgcolor="#DDDDDD" align="center">&nbsp;<b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sequence</font></b></td>
                              <td height="40" bgcolor="#DDDDDD" align="center">&nbsp;<b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Image</font></b></td>
                                <td width="42%" height="20" bgcolor="#DDDDDD" align="center">&nbsp;<b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Image Name</font></b></td>
                                <td width="14%" align="center" bgcolor="#DDDDDD"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">View</font></b></td>
								<td width="14%" align="center" bgcolor="#DDDDDD"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Link</font></b></td>
                                <td width="12%" height="20" align="center" bgcolor="#DDDDDD"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Edit</font></b></td>
                                <td width="12%" height="20" align="center" bgcolor="#DDDDDD"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Delete</font></b></td>
                              </tr>
							  
							  <?php if($records == 0):?>
                              <tr>
                                <td height="100" colspan="4" align="center"><b><font color="#990000" size="2" face="Verdana, Arial, Helvetica, sans-serif">No Image Found</font></b></td>
                              </tr>
							  <?php
							  		else:
									$res = @mysql_query("select * from tbl_index_image");
										while($row = mysql_fetch_array($res)):
											list($width, $height, $type, $attr) = getimagesize("../images/slideshow-index/".$row['image_name']);

							  ?>
                              <tr bgcolor='eeeeee' onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='eeeeee'">
                                <td height="20">&nbsp;<input type="text" name="<?=$row['image_id']?>" value="<?=$row['seq']?>" style="width:30px;"></td>
                                <?php 		
								$src_image = IMG_REPO_URL."images/slideshow-index/".$row['image_name'];
								 		?>
								
								<td height="70" align="center"><img src="<?php echo $src_image;?>"  width="169" height="129s" border="0"></td>
								<td height="20">&nbsp;<font class="text"><b><?php echo $row['image_name'];?></b></font></td>
                                <td align="center"><font class="text"><a href="javascript:LoadPopup('<?php echo '../images/slideshow-index/'.$row['image_name'];?>','<?php echo $row['image_id'];?>','<?php echo $height + 40;?>','<?php echo $width + 30;?>');">View</a></font></td>
                                 <td height="20" align="center"><font class="text"><a href="javascript:LoadPopup('edit_index_link.php?id=<?php echo $row['image_id'];?>','WinEdit','300','400');">Link</a></font></td>
								<td height="20" align="center"><font class="text"><a href="javascript:LoadPopup('edit_index_image.php?id=<?php echo $row['image_id'];?>','WinEdit','300','400');">Edit</a></font></td>
                                <td height="20" align="center"><font" class="text"><a href="<?php echo $_SERVER['PHP_SELF'].'?action=Delete&id='.$row['image_id'];?>" onClick="javascript:getDeleteConfirm(this); return false;">Delete</a></font></td>
                              </tr>
							  <?php
							  			endwhile;
							  		endif;
							  ?>                            
                            </table>							
							</td>
                          </tr>
                        </table> 
						<input type="submit" name="btnSeq" value="Update Sequence" style="margin-top:5px;"> 
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
