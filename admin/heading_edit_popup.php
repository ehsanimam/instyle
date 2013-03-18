<?
include("../common.php");

if(@$action=='edit')
{

 if(@$heading_name!='')
  {
  $type_name=explode("_",$heading_name);

  $update_query="update tbl_type_headings set headings='".addslashes($type_name[0])."',title='".addslashes($title)."',description='".addslashes($description)."',keyword='".addslashes($keyword)."',alttags='".addslashes($alttags)."',heading_id='".$type_name[1]."' where id='$eid'";

  mysql_query($update_query);


 print "<script>opener.location.href='edit_typeheading.php';window.close();</script>";
  }
  else
  {
   $err="Please complete all the entries.";
}
}

$select="select * from tbl_type_headings where id='$eid'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);


if(@$heading_name=='')
{
 $heading_name=$row['headings']."_".$row['heading_id'];
}

?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="1" cellspacing="1">

    <tr>
      <td >
                    <!-----start-----------//-->
                    <form name="color" action="<?php echo $_SERVER['PHP_SELF'];?>?eid=<?=$eid;?>&action=edit" method="post">
                    <table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <input type="hidden" name=eid value="<?=@$eid;?>">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><b>
                    <font size=2 color="#000000" face="verdana,Arial">Edit Category</td></tr>

                    <tr><td align=center colspan=2><b><font size=2 face=verdana color=red><?=@$err;?></td></tr>

                     <tr>
                  <td valign=top class="text" align="right"><font size=2 color="#000000" face="verdana,Arial">Category Name:</font></td>
                  <td align="left">
				  	<select name="heading_name" id="heading_name" class="inputbox">
						<option value="">---Select---</option>
						<?php
							$sql_heading = "select * from tblcat";
							$res_heading = mysql_query($sql_heading);
							while($row_heading = mysql_fetch_array($res_heading)) {
							
							$new_headingname=$row_heading['cat_name']."_".$row_heading['cat_id'];
						 ?>
						 <option value="<?=$row_heading['cat_name']."_".$row_heading['cat_id']?>" <?php if($heading_name==$new_headingname){ echo 'selected="selected"'; } ?> ><?php echo $row_heading['cat_name'];?></option>
						 <?php } ?>
					</select>
				  </td>
                </tr> 
                     
<tr>
		<td valign=top class="text" align="right">Title:</td>
		<td><input type="text" name="title" class="inputboxbig" value="<?=stripslashes($row['title']);?>"></td>
	</tr>
    <tr>
		<td valign=top class="text" align="right">Description:</td>
		<td><textarea name="description" class="textareabig"><?=stripslashes($row['description']);?></textarea></td>
	</tr>
    <tr>
		<td valign=top class="text" align="right">Keywords:</td>
		<td><textarea name="keyword" class="textareabig"><?=stripslashes($row['keyword']);?></textarea></td>
	</tr>
    <tr>
		<td valign=top class="text" align="right">Alt Tags:</td>
		<td><input type="text" name="alttags" class="inputboxbig" value="<?=stripslashes($row['alttags']);?>"></td>
	</tr>

                    <tr><td colspan=2 align=center><input type="submit" value="edit" class=button> </td></tr>
                     </table>

                    </td></tr></table>
                    </form>
                     <!-------end-------//-->
                    </td>
                  </tr>
                </table>