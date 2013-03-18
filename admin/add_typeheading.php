<?php
session_start();
include("../common.php");

if(@$action=='add')
{
	 if(@$heading_name!='')
	 {
	 
	    $type_name=explode("_",$heading_name);
  		$chkcolor = "select * from tbl_type_headings where headings='$type_name[0]'";
		$hcolor = mysql_query($chkcolor);
		if(mysql_num_rows($hcolor) <= 0)
		{	
		
		$type_name=explode("_",$heading_name);
			$insert_query="insert into tbl_type_headings(headings,title,description,keyword,alttags,heading_id)values('".addslashes($type_name[0])."','".addslashes($title)."','".addslashes($description)."','".addslashes($keyword)."','".addslashes($alttags)."','".$type_name[1]."')";
			mysql_query($insert_query);
			$err="Category has been added.";
			$name='';
			header('location:edit_typeheading.php?msg=1');
		}else
			$err="Category already exists.";
			//header('location:add_color.php?err='.$err);
			
  	}
  	else
  	{
   		$err="Please enter categoty name.";
	}
}


include 'top.php'; 
?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">	
		<form name="size" action="<?php echo $_SERVER['PHP_SELF'];?>?action=add" method="post">
		<table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
		<table width=100% align=center cellspacing=2 cellpadding=2>
		<tr bgcolor=cccccc><td align=center colspan=2><h1>ADD Type Category</h1></td></tr>
		<tr><td align=center colspan=2 class="error"><?=@$err;?></td></tr>
        <tr>
                  <td valign=top class="text" align="right">Select Category Name: </td>
                  <td align="left">
				  	<select name="heading_name" id="heading_name" class="inputbox">
						<option value="">---Select---</option>
						<?php
							$sql_heading = "select * from tblcat";
							$res_heading = mysql_query($sql_heading);
							while($row_heading = mysql_fetch_array($res_heading)) {
							$new_headingname=$row_heading['cat_name']."_".$row_heading['cat_id'];
						 ?>
						 <option value="<?=$row_heading['cat_name']."_".$row_heading['cat_id']?>" <?php if($_REQUEST['heading_name']==$new_headingname){ echo 'selected="selected"'; } ?>><?php echo $row_heading['cat_name'];?></option>
						 <?php } ?>
					</select>
				  </td>
                </tr>
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
			<tr><td colspan=2 align=center><input type="submit" value="Add" class=button> </td></tr>
		 </table>

		</td></tr></table>
		</form>
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>