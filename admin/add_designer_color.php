<?
session_start();
include("../common.php");



if(@$action=='add')
{
	 if(@$des_id!='' && @$color_id!='')
	 {
		$color_id= implode(",",$_POST['color_id']);

  		$chkcolor = "select * from designer_color where des_id ='$des_id'";
		$hcolor = mysql_query($chkcolor);
		if(mysql_num_rows($hcolor) <= 0)
		{	
			$insert_query="insert into designer_color(des_id,color_id)values('$des_id','$color_id')";
			mysql_query($insert_query);
			$err="Designer Color has been added.";
			
		}else
			$err="Designer Color already exists.";
			 
  	}
  	else
  	{
   		 $err="Please complete all the entries.";
	}
}

$select="select * from designer order by designer asc";
$result=mysql_query($select);
$num=mysql_num_rows($result);


$select1="select * from tblcolor order by color_name asc";
$result1=mysql_query($select1);
$num1=mysql_num_rows($result1);

include 'top.php'; 
?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	<form name="subcategory" action="add_designer_color.php?action=add" method="post" enctype="MULTIPART/FORM-data">
<table width=85% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
	<table width=100% align=center cellspacing=2 cellpadding=2>
                <tr bgcolor=cccccc>
                  <td align=center colspan=2><h1>ADD Designer Color</h1></td>
                </tr>
                <tr>
                  <td align=center colspan=2 class=error>
                    <?=@$err;?>                  </td>
                </tr>
                <? if($num!=0){?>
                <tr>
                  <td width="55%" valign=top class="text" align="right">Select Designer : </td>
                  <td width="45%" align="left"> <select name="des_id" class=combobig>
                      <option value="">Select</option>
                      <? while($row=mysql_fetch_array($result)){?>
                      <option value="<?=@$row['des_id'];?>"><?=$row['designer'];?>
                      </option>
                      <?}?>
                    </select></td>
                </tr>
                <?}?>
               <? if($num1!=0){?>
                <tr>
                  <td width="55%" valign=top class="text" align="right">Select Color : </td>
                  <td width="45%" align="left"> <select name="color_id[]" class=combobig  multiple="multiple">
                      <option value="">Select</option>
                      <? while($row1=mysql_fetch_array($result1)){?>
                      <option value="<?=@$row1['color_id'];?>"><?=$row1['color_name'];?>
                      </option>
                      <? } ?>
                    </select></td>
                </tr>
                <?}?>
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