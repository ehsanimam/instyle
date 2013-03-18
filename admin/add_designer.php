<?php
include("../common.php");
include('../functionsadmin.php');
include("security.php");

if (@$action == 'add')
{
	if (@$designer_name != '')
	{
  		$chkcolor = "select * from designer where designer = '$designer_name'";
		$hcolor = mysql_query($chkcolor);
		
		if (mysql_num_rows($hcolor) <= 0)
		{	
			$strFile1        =  $_FILES["i_image"]["name"];
			$strTempFile1    =  $_FILES["i_image"]["tmp_name"];
		
			if ( ! empty($strFile1) && file_exists($strTempFile1))
			{
				$randomno = RandomNumber(5);
				$strFileName1 = $randomno.strtolower($strFile1);
				
				//Upload the File1.
				copy($strTempFile1,"../images/designer_icon/".$strFileName1);
				gd2resize("../images/designer_icon/".$strFileName1,169,129,"../images/designer_icon/thumb/","");
				gd2resize("../images/designer_icon/".$strFileName1,579,446,"../images/designer_icon/zoom/","");
			}
			else
			{
				$strFileName1 = '';
			}
			
			$seq_sql = "select max(ordering) from designer where catid='".$_POST['catid']."'";
			$seq_res = mysql_query($seq_sql);
			$seq_row = mysql_fetch_array($seq_res);
			$seq_num = mysql_num_rows($seq_res);
			
			if ($seq_row[0] > 0 && $seq_num == 1):
				$seqes = $seq_row[0] + 1; 
			else:	
				$seqes = 1;
			endif;
			
			$destype_id = isset($_POST['destype_id']) & $_POST['destype_id'] == '- select type -' ? 0 : $_POST['destype_id'];
			
			$insert_query = "
				INSERT INTO designer (
					designer, 
					catid, 
					destype_id, 
					icon_img, 
					ordering,
					folder
				) VALUES (
					'$designer_name', 
					'".$_POST['catid']."', 
					'".$destype_id."', 
					'$strFileName1', 
					'$seqes',
					'$folder'
				)
			";
			mysql_query($insert_query) or die('Inserting error: '.mysql_error());
			
			$cfold_sql = "SELECT folder AS c_folder FROM tblcat WHERE cat_id = '".$_POST['catid']."'";
			$cfold_res = mysql_query($cfold_sql);
			$cfold_row = mysql_fetch_array($cfold_res);
			
			// add subfolder where necessary
			if ( ! file_exists('../product_assets/'.$cfold_row['c_folder'].'/'.$folder))
			{
				$old = umask(0);
				if ( ! mkdir('../product_assets/'.$cfold_row['c_folder'].'/'.$folder, 0777, TRUE)) die('Unable to create "../product_assets/'.$cfold_row['c_folder'].'/'.$folder.'" folder.');
				umask($old);
			}
	
			$err = "Designer has been added.";
			$name = '';
		}
		else
		{
			$err = "Designer already exists.";
			//header('location:add_color.php?err='.$err);
		}
  	}
  	else
  	{
   		$err = "Please enter designer name.";
	}
}


include 'top.php'; 
?>
<title><?php echo SITE_NAME; ?> :: Admin Section</title>
<script>
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
	}
	
	
	
	function getDesigner(strURL) {		
		
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('designerdiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
				
	}
</script>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">	
		<form name="size" action="<?php echo $_SERVER['PHP_SELF'];?>?action=add" method="post"  enctype="MULTIPART/FORM-data">
		<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
		<table width=100% align=center cellspacing=2 cellpadding=2>
		<tr bgcolor=cccccc><td align=center colspan=2><h1>ADD Designer</h1></td></tr>
		<tr><td align=center colspan=2 class="error"><?=@$err;?></td></tr>

		<tr>
			<td class="text" align="right">Designer Name : </td>
			<td align="left"><input type="text" name="designer_name" class="inputbox" value="<?=@$designer_name;?>"></td>
		</tr>
		<tr>
			<td class="text" align="right">Category : </td>
			<td align="left">
			<select name="catid"  onChange="getDesigner('find_designer_type.php?destype_id='+this.value)">
				<option> - select category - </option>
				<?php
				$heading = mysql_query("select * from tblcat");
				if(mysql_num_rows($heading) > 0) {
					while($row = mysql_fetch_array($heading)) {
						?> <option value="<?=$row['cat_id']?>"><?=$row['cat_name']?></option> <?php
					}
				}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="text" align="right">Type : </td>
			<td align="left">
				<div id="designerdiv">
					<select name="destype_id">
						<option value=""> - select type - </option>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<td class="text" align="right">Folder : </td>
			<td align="left"><input type="text" name="folder" class="inputbox" value="<?=@$folder;?>"></td>
		</tr>
		<tr>
			<td valign=top class="text" align="right">Icon Image : </td>
			<td align="left"><input type="file" name="i_image" id="i_image" class="inputbox" /><br />
				<span style="color:#FF0000;" class="text">images size should be<br /> 169(w)px X 129(h)px</span>
			</td>
		</tr>
		<tr><td colspan=2 align=center><input type="submit" value="Add" class=button> </td></tr>
		 </table>

		</td></tr></table>
		</form>
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>