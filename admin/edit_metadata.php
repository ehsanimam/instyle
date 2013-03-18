<?
include("../common.php");
include("security.php");
if(@$action=='edit')
{

 if(@$pagename!='' && @$title!='' && @$description!='' && @$keyword!= '')
  {

  $update_query="update tblmeta
                 set pagename='".addslashes($pagename)."',
				 title='".addslashes($title)."',
				 description='".addslashes($description)."',
				 keyword='".addslashes($keyword)."',
				 dfooter='".addslashes($dfooter)."',				 
				 alttags='".addslashes($alttags)."',
				 url_structure='".addslashes($url_structure)."' 
                 where id='".$id."'";

  mysql_query($update_query);


 print "<script>window.location.href='mdata_details.php';</script>";
  }
  else
  {
   $err="Please complete all the entries.";
}
}

$select="select * from tblmeta where id='$id'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);


if(@$name=='')
{
	$pagename=stripslashes($row['pagename']);
    $title=stripslashes($row['title']);
   $description=stripslashes($row['description']);
   $keyword=stripslashes($row['keyword']);
   $alttags=stripslashes($row['alttags']);
   $url_structure=stripslashes($row['url_structure']);
   $dfooter=stripslashes($row['dfooter']);   
}

?>

<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<?
include 'top.php'; 
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
<form name="color" action="edit_metadata.php?id=<?=$id;?>&action=edit" method="post">
                    <table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
 <input type="hidden" name="id" value="<?=@$id;?>">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>Edit Meta Data</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><?=@$err;?></td></tr>

                    <tr>
						<td width="45%" class="text" align="right">Page Name : </td>
                    	<td width="55%" align="left"><input type="text" name="pagename" class="inputbox" value="<? echo @$pagename;?>"></td>
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
                 <tr> 
                  <td  align="right" valign=top class="text">Url Structure : </td>
                  <td  align="left"><input type="text" name="url_structure"  class="inputboxbig" value="<?=@$url_structure;?>"></td>
                </tr>
                
                
<tr> 
                  <td  align="right" valign=top class="text">Footer: </td>
                  <td  align="left"><textarea  name="dfooter"  class="textareabig"><?=@$dfooter;?></textarea></td>
                </tr>                
                
                
					<tr><td colspan=2 align=center><input type="submit" value="Submit" class=tab name="insert"> </td></tr>
                     </table>

                    </td></tr></table>
                    </form></td>
</tr>
</table>

                <? include 'footer.php'; ?>