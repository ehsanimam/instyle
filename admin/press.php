<?php
	include("../common.php");
	include('../functionsadmin.php');
	include("security.php");

	define("TABLE","`tbl_press`",true);
	
	if (isset($_GET['action']) && $_GET['action'] == "Delete"):
	
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
		header("Location:press.php");
		exit();
		
	endif;
 
	$sql = "SELECT * from tbl_press";
	$r = mysql_query($sql);
	$data = mysql_fetch_array($r);
	
	if (@$action == 'add')
	{
		if(@$name!='')
		{
			
			//$cid = admin_update_press($name);
			
			//------------------------------------- upload picture
			if (isset($imgt) == true)
			{
				$strFile1 = strtolower($_FILES["imgt"]["name"]);
				$strTempFile1 = $_FILES["imgt"]["tmp_name"];	
				move_uploaded_file($strTempFile1,"press_cover/thumb/".$strFile1);	
				
				echo $strTempFile1.':'.$strFile1.'<br>';
				
				$strFile2 = strtolower($_FILES["img1"]["name"]);
				$strTempFile2 = $_FILES["img1"]["tmp_name"];	
				move_uploaded_file($strTempFile2,"press_1/".$strFile2);			
				
				echo $strTempFile2.':'.$strFile2.'<br>';	

				$strFile3 = strtolower($_FILES["img2"]["name"]);
				$strTempFile3 = $_FILES["img2"]["tmp_name"];	
				move_uploaded_file($strTempFile3,"press_2/".$strFile3);			

				echo $strTempFile3.':'.$strFile3.'<br>';   
				
				$sq="insert into tbl_press (title,cover_img,img_1,img_2) values ('$name','$strFile1','$strFile2','$strFile3')";
				
				echo $sq; 	
				mysql_query($sq) or die("Error updating press");
			}
			
			//------------------------------------------------------
			if ($cid != -1) echo"<script language=javascript>document.location.href='press.php?err=1'</script>";
		}
	}
	
	include 'top.php'; 
?>
<script>
function submit_form()
{
    document.category.method="post";
    document.category.action="press.php?action=add";
    document.category.submit();
    
}
</script>
<style type="text/css">
<!--
.style1 {color: #990000}
-->
</style>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	<!--bof form=========================================================================-->
	<form name="category" action="press.php?action=add" method="post" enctype="MULTIPART/FORM-data">
	
	<table width=90% border=1 bordercolor='cccccc' cellspacing=0 cellpadding=0>
	<tr><td>
		<table width=100% align=center cellspacing=2 cellpadding=2>
			<tr bgcolor=cccccc><td align=center colspan=2><h1>Press</h1></td></tr>
			<tr><td align=center colspan=2 class="error"><? if(@$err) echo "Press Details has been updated."; ?></td></tr>
			<tr><td colspan=2 align=center height="15"></td></tr>
			<tr>
				<td width="45%" class="text" align="center" colspan="2">Title
					<textarea id="your_textarea" name="name"></textarea>
				</td>
			</tr>
			<tr>
				<td class="text" align="center" colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td class="text" align="center" colspan="2">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td width="41%" align="right">Upload Cover Page</td>
							<td width="59%"><input type="file" name="imgt" id="imgt" class="inputbox" />
								<span class="style1">Thumb size 125px X 155px</span>
							</td>
						</tr>
						<tr>
							<td width="41%" align="right">Upload Image 1</td>
							<td width="59%"><input type="file" name="img1" id="img1" class="inputbox" />
								<span class="style1">Image zise 750px wide</span>
							</td>
						</tr>
						<tr>
							<td width="41%" align="right">Upload Image 2</td>
							<td width="59%"><input type="file" name="img2" id="img2" class="inputbox" />
						        <span class="style1">Image zise 750px wide</span>
							</td>
						</tr>                                                        
						<tr>
							<td align="right">&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr><td colspan=2 align=center><input type="submit" value="Submit" class=top></td></tr>
		</table>
	</tr></td>
	</table> 
	
	<table>
		<tr> 
			<br> 
		</tr>
		<tr>   
			<td></td>
			<td></td>
		</tr>
		<?php
		$sql3 = mysql_query("select * from tbl_press");
		if (@mysql_num_rows($sql3) > 0) 
		{
			while ($row = @mysql_fetch_array($sql3))
			{
				$bg = isset($bg) && $bg == '#dddddd' ? '#ffffff' :'#dddddd';
				echo '
				<tr bgcolor="' . $bg . '" >
					<td>
						<img src="press_cover/thumb/'.$row['cover_img'].'" />
					</td>
					<td>' .  $row['title'].'<br>'.$row['cover_img']. '</td>				  
				'; ?>
					<td align="center"><a href="javascript:LoadPopup('view_press.php?id=<?php echo $row['press_id'];?>','ViewImage','<?php echo 700 + 40;?>','<?php echo 600 + 30;?>');"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">View</font></a></td>
					<td height="20" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="javascript:LoadPopup('edit_collection_image.php?id=<?php echo $row['press_id'];?>','WinEdit','400','600');">Edit</a></font></td>
					<td height="20" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="<?php echo $_SERVER['PHP_SELF'].'?action=Delete&id='.$row['press_id'];?>" onClick="javascript:getDeleteConfirm(this); return false;">Delete</a></font></td>
				</tr>
                <?php
			}//while			   
		}//if
		?>
		<tr><td></td><td></td></tr>
	</table>
	
	</form>
	</td>
	
</tr>
</table>

<? include 'footer.php'; ?>

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