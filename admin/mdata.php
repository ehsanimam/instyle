<?
include("../common.php");
include("security.php");
if(@$_POST['insert']=='Submit')
{
 $date=$_POST['idate'];
 $pagename =$_POST['pagename'];
 $title =$_POST['title'];
 $desc =$_POST['desc'];
 $keyword =$_POST['keyword'];
 $sql ="insert into tblmeta(pagename, title, description, keyword,alttags,url_structure,dfooter)";
 $sql.="values('".addslashes($pagename)."','".addslashes($title)."','".addslashes($desc)."','".addslashes($keyword)."','".addslashes($alttags)."','".addslashes($url_structure)."','".addslashes($dfooter)."')";
 $res = mysql_query($sql);
 if(mysql_affected_rows()>0)
 {
   header("location:mdata.php?err=1");
 }
}
include 'top.php'; 
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	<form name="category" action="" method="post" enctype="MULTIPART/FORM-data">
                    <table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>

                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>Meta Data</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><? if(@$err) echo "page name has been Added."; ?></td></tr>

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
                  <td  align="left"><textarea  name="desc"  class="textareabig"><?=@$description;?></textarea></td>
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
                  <td  align="right" valign=top class="text">Footer : </td>
                  <td  align="left"><textarea  name="dfooter"  class="textareabig"><?=@$dfooter;?></textarea></td>
                </tr>                
                
                
                
					<tr><td colspan=2 align=center><input type="submit" value="Submit" class=tab name="insert"> </td></tr>
                     </table>

                    </td></tr></table>
                    </form></td>
</tr>
</table>

<? include 'footer.php'; ?>