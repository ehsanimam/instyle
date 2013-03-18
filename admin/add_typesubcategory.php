<?
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php");

//$strFile2        =  $_FILES["prod_image"]["name"];
//$strTempFile2    =  $_FILES["prod_image"]["tmp_name"];

if(@$action=='add')
{
 if($type_name!='')
  {
	  $getid=admin_ins_typesubcat($type_name,$heading,$title,$description,$keyword,$alttags);
	  if($getid != -1)
	  {
		 $err="Type Sub Category has been added.";
		 $type_name='';
		 $cat='';
		 header('location:edit_typesubcategory.php?msg=1');
	  }else
	     $err="Type Sub Category already exists.";
	  		 //header('location:add_subcategory.php?err='.$err);			
 }
 else
 {
	   $err="Please complete all the entries.";
  }
}

include 'top.php'; 
?>
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
</script>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	<form name="typecategory" action="add_typesubcategory.php?action=add" method="post" enctype="MULTIPART/FORM-data">
<table width=85% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
	<table width=100% align=center cellspacing=2 cellpadding=2>
                <tr bgcolor=cccccc>
                  <td align=center colspan=2><h1>ADD Type Sub Sub Category</h1></td>
                </tr>
                <tr>
                  <td align=center colspan=2 class=error>
                    <?=@$err;?>                  </td>
                </tr>
                 <tr>
                  <td valign=top class="text" align="right">Select Sub Category: </td>
                  <td align="left">
				  	<select name="heading" id="heading" class="inputbox" onChange="getQty('subcat2.php?option=typesubcat&subcatid='+this.value)">
						<option value="">---Select---</option>
						<?php
							$sql_heading = "select * from tblsubcat";
							$res_heading = mysql_query($sql_heading);
							while($row_heading = mysql_fetch_array($res_heading)) {
						 ?>
						 <option value="<?php echo $row_heading['subcat_id']?>"><?php echo $row_heading['subcat_name'];?></option>
						 <?php } ?>
					</select>
				  </td>
                </tr>
                <tr> 
                  <td width="48%" align="right" valign=top class="text">Type Sub Sub Category : </td>
                  <td width="52%" align="left"><div id="subcatdiv">Select Sub SubCategory</div></td>
                </tr>
                 <tr> 
                  <td width="48%" align="right" valign=top class="text">Title : </td>
                  <td width="52%" align="left"><input type="text" name="title"  class="inputboxbig" value="<?=@$title;?>"></td>
                </tr>
                 <tr> 
                  <td width="48%" align="right" valign=top class="text">Description : </td>
                  <td width="52%" align="left"><textarea  name="description"  class="textareabig"><?=@$description;?></textarea></td>
                </tr>
                 <tr> 
                  <td width="48%" align="right" valign=top class="text">Keywords : </td>
                  <td width="52%" align="left"><textarea  name="keyword"  class="textareabig"><?=@$keyword;?></textarea></td>
                </tr>
                 <tr> 
                  <td width="48%" align="right" valign=top class="text">Alt Tags : </td>
                  <td width="52%" align="left"><input type="text" name="alttags"  class="inputboxbig" value="<?=@$alttags;?>"></td>
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