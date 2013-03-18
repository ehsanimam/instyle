<?php
	include("../common.php");
	include('../functionsadmin.php');
	include("security.php");

	if (@$action == 'add')
	{
		if ($sub_name != '' && $cat != '')
		{
			// Insert subcat to tblsubsubcat
			$getid = admin_ins_subsubcat($cat,$subcat,$sub_name,$title,$description,$keyword,$alttags,$url_structure);
	  
			if	($getid != -1)
			{
				/*
				$strFile1_p        =  $_FILES["pdF_price"]["name"];
				$strTempFile1_p    =  $_FILES["pdF_price"]["tmp_name"];  
				
				if ($strFile1_p != '')
				{
					move_uploaded_file($strTempFile1_p,"pdf_price/".strtolower($strFile1_p));
				}
			
				$strFile1_c        =  $_FILES["pdF_color"]["name"];
				$strTempFile1_c    =  $_FILES["pdF_color"]["tmp_name"];  
				if ($strFile1_c != '')
				{
					move_uploaded_file($strTempFile1_c,"pdf_color/".strtolower($strFile1_c));
				}
				*/
		 
				// add subsubcat to subcat table
				$sel_des_2 = "SELECT * FROM tblsubcat WHERE subcat_id = '".$_POST['subcat']."'";
				$qry_des_2 = mysql_query($sel_des_2) or die('Select error: '.mysql_error());
				$ary_des_2 = mysql_fetch_array($qry_des_2);
				
				$subsubcats = $ary_des_2['subsubcats'].$getid.',';
				
				$upd_des_3 = "
					UPDATE tblsubcat
					SET subsubcats = '".$subsubcats."'
					WHERE subcat_id = '".$_POST['subcat']."'
				";
				$qry_des_3 = mysql_query($upd_des_3) or die('Update error: '.mysql_error());
				
				// queries for folder structuring
				$get_subsubcat = mysql_query("
					SELECT
						c.folder AS c_folder, 
						sc.folder AS sc_folder, 
						ssc.folder AS ssc_folder,
						d.folder AS d_folder
					FROM
						tblsubcat sc
						JOIN tblsubsubcat ssc ON ssc.subcat_id = sc.subcat_id
						JOIN designer d ON d.catid = sc.cat_id
						JOIN tblcat c ON c.cat_id = sc.cat_id
					WHERE sc.subcat_id = '".$_POST['subcat']."'
						AND d.des_id = '".$_POST['des']."'
				");
				$subsubcatq 	= mysql_fetch_array($get_subsubcat);
				
				$path 		= "../product_assets/".$subsubcatq['c_folder']."/".$subsubcatq['d_folder']."/".$subsubcatq['sc_folder'];
				$subsubfolder  = $path.'/'.trim($url_structure);
				// at products image repo
				$path_var 		= IMG_REPO_URL_VAR."product_assets/".$subsubcatq['c_folder']."/".$subsubcatq['d_folder']."/".$subsubcatq['sc_folder'];
				$subsubfolder_var  = $path_var.'/'.trim($url_structure);
				
				//add subfolder under subcat where necessary
				if ( ! file_exists($subsubfolder))
				{
					$old = umask(0);
					if ( ! mkdir($subsubfolder, 0777, TRUE)) die('Unable to create "'.$subsubfolder.'" folder.');
					umask($old);
				}
				if ( ! file_exists($subsubfolder_var)) // --> at the products image repo
				{
					$old = umask(0);
					if ( ! mkdir($subsubfolder_var, 0777, TRUE)) die('Unable to create "'.$subsubfolder_var.'" folder.');
					umask($old);
				}
				
				//add product view folders where necessary
				if ( ! file_exists($subsubfolder.'/product_back'))
				{
					$old = umask(0);
					if ( ! mkdir($subsubfolder.'/product_back', 0777, TRUE)) die('<br />Unable to create "'.$subsubfolder.'/product_back".');
					umask($old);
				}
				if ( ! file_exists($subsubfolder_var.'/product_back')) // --> at the products image repo
				{
					$old = umask(0);
					if ( ! mkdir($subsubfolder_var.'/product_back', 0777, TRUE)) die('<br />Unable to create "'.$subsubfolder_var.'/product_back".');
					umask($old);
				}
				if ( ! file_exists($subsubfolder.'/product_coloricon'))
				{
					$old = umask(0);
					if ( ! mkdir($subsubfolder.'/product_coloricon', 0777, TRUE)) die('Unable to create "'.$subsubfolder.'/product_coloricon".');
					umask($old);
				}
				if ( ! file_exists($subsubfolder_var.'/product_coloricon')) // --> at the products image repo
				{
					$old = umask(0);
					if ( ! mkdir($subsubfolder_var.'/product_coloricon', 0777, TRUE)) die('Unable to create "'.$subsubfolder_var.'/product_coloricon".');
					umask($old);
				}
				if ( ! file_exists($subsubfolder.'/product_front'))
				{
					$old = umask(0);
					if ( ! mkdir($subsubfolder.'/product_front', 0777, TRUE)) die('Unable to create "'.$subsubfolder.'/product_front".');
					umask($old);
				}
				if ( ! file_exists($subsubfolder_var.'/product_front')) // --> at the products image repo
				{
					$old = umask(0);
					if ( ! mkdir($subsubfolder_var.'/product_front', 0777, TRUE)) die('Unable to create "'.$subsubfolder_var.'/product_front".');
					umask($old);
				}
				if ( ! file_exists($subsubfolder.'/product_side'))
				{
					$old = umask(0);
					if ( ! mkdir($subsubfolder.'/product_side', 0777, TRUE)) die('Unable to create "'.$subsubfolder.'/product_side".');
					umask($old);
				}
				if ( ! file_exists($subsubfolder_var.'/product_side')) // --> at the products image repo
				{
					$old = umask(0);
					if ( ! mkdir($subsubfolder_var.'/product_side', 0777, TRUE)) die('Unable to create "'.$subsubfolder_var.'/product_side".');
					umask($old);
				}
				if ( ! file_exists($subsubfolder.'/product_video'))
				{
					$old = umask(0);
					if ( ! mkdir($subsubfolder.'/product_video', 0777, TRUE)) die('Unable to create "'.$subsubfolder.'/product_video".');
					umask($old);
				}
				if ( ! file_exists($subsubfolder_var.'/product_video')) // --> at the products image repo
				{
					$old = umask(0);
					if ( ! mkdir($subsubfolder_var.'/product_video', 0777, TRUE)) die('Unable to create "'.$subsubfolder_var.'/product_video".');
					umask($old);
				}
				
				$err = "Sub SubCategory has been added.";
				$sub_name = '';
				$cat = '';
			}
			else
			{
				$err = "Sub SubCategory already exists.";
				//header('location:add_subcategory.php?err='.$err);
			}
		}
		else
		{
			$err = "Please complete all the entries.";
		}
	}
	
$select="select * from tblcat order by cat_name asc";
$result=mysql_query($select);
$num=mysql_num_rows($result);


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
	
	function getQty(strURL) {
	
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('subcatdiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
	
	}
	
	function getQty2(strURL) {
	
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('desdiv').innerHTML=req.responseText;						
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
	
	<form name="subcategory" action="add_subsubcategory.php?action=add" method="post" enctype="MULTIPART/FORM-data">
<table width=85% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
	<table width=100% align=center cellspacing=2 cellpadding=2>
                <tr bgcolor=cccccc>
                  <td align=center colspan=2><h1>ADD Sub Sub Category</h1></td>
                </tr>
                <tr>
                  <td align=center colspan=2 class=error>
                    <?=@$err;?>                  </td>
                </tr>
                <? if($num>0){?>
                <tr>
					<td width="45%" valign=top class="text" align="right">Select Category : </td>
					<td width="55%" align="left">
						<select name="cat" class=combobig onChange="getQty('subcat1.php?catid='+this.value); getQty2('subcat3.php?catid='+this.value)">
							<option value="">Select</option>
							<?php
							while ($row = mysql_fetch_array($result))
							{ ?>
								<option value="<?=@$row[cat_id];?>"><?=$row['cat_name'];?></option>
								<? 
							}
							?>
						</select>
						<script language="JavaScript">
							document.subcategory.cat.value="<?=$cat;?>"
						</script>
					</td>
                </tr>
                <? } ?>
				<tr>
					<td class="text" align="right">Designer:</td>
					<td align="left" class="text">
						<div id="desdiv">Select Designer</div>
					</td>
				</tr>
                <tr>
					<td class="text" align="right">SubCategory:</td>
					<td align="left" class="text">
						<div id="subcatdiv">Select SubCategory</div>
					</td>
				</tr>
                <tr> 
                  <td valign=top class="text" align="right"> Sub SubCategory : </td>
                  <td align="left"><input type="text" name="sub_name"  class="inputbox" value="<?=@$sub_name;?>"></td>
                </tr>
                <tr>
                  <td valign=top class="text" align="right">Icon Image : </td>
                  <td align="left"><input type="file" name="i_image" id="i_image" class="inputbox" /></td>
                </tr>
                 <tr>
                      <td valign=top>&nbsp;</td>
                      <td height="28" align="left" valign="top"><span class="text" style="color:#FF0000">images size should be 169(w)px X 129(h)px</span></td>
                    </tr>
                <tr> 
                <tr> 
                  <td  align="right" valign=top class="text">Title : </td>
                  <td  align="left"><input type="text" name="title"  class="inputboxbig" value="<?=@$title;?>"></td>
                </tr>
                 <tr> 
                  <td  align="right" valign=top class="text">Description : </td>
                  <td  align="left"><textarea  name="description"  class="textareabig"><?=@$description;?></textarea></td>
                </tr>
                 <tr> 
                  <td  align="right" valign=top class="text">Keywords : </td>
                  <td  align="left"><textarea  name="keyword"  class="textareabig"><?=@$keyword;?></textarea></td>
                </tr>
                 <tr> 
                  <td  align="right" valign=top class="text">Alt Tags : </td>
                  <td  align="left"><input type="text" name="alttags"  class="inputboxbig" value="<?=@$alttags;?>"></td>
                </tr>
                 <tr> 
                  <td  align="right" valign=top class="text">Url Structure : </td>
                  <td  align="left"><input type="text" name="url_structure"  class="inputboxbig" value="<?=@$url_structure;?>"></td>
                </tr>
					
				<tr>
                  <td>&nbsp;</td><td align="left"> <input type="submit" value="Add" class=button> 
                  </td>
                </tr>
              </table>
</td></tr></table>
</form>
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>