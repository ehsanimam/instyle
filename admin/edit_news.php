<?
include("../common.php");
include("security.php");
if(@$action=='edit')
{

 if(@$ndate!='' && @$ntext!='')
  {

  $update_query="update tblnews
                 set n_date='$ndate',
				 n_text='$ntext'
                 where n_id='$id'";

  mysql_query($update_query);


 print "<script>window.location.href='news_details.php';</script>";
  }
  else
  {
   $err="Please complete all the entries.";
}
}

$select="select * from tblnews where n_id='$id'";
$result=mysql_query($select);
$row=mysql_fetch_array($result);


if(@$name=='')
{
 $ndate=$row['n_date'];
  $ntext=$row['n_text'];
}

?>

<title>7thavenuedirect::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<?
include 'top.php'; 
?>
<table width="100%" border="0" cellpadding="1" cellspacing="1">

    <tr>
      <td >
                    <!-----start-----------//-->
                    <form name="color" action="edit_news.php?id=<?=$id;?>&action=edit" method="post">
                    <table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <input type="hidden" name=id value="<?=@$id;?>">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><b>
                    <font size=2 color="#000000" face="verdana,Arial">Edit News</td></tr>

                    <tr><td align=center colspan=2><b><font size=2 face=verdana color=red><?=@$err;?></td></tr>


                     <tr>
					 <td  height="15" colspan="2" align="center">Date:&nbsp;<input type="text" class="inputbox" name="ndate" value="<?=@$ndate;?>">&nbsp;eg:<font color="#FF0000">yyyy-mm-dd</font></td>
					</tr>
<tr>
					<td width="45%" class="text" align="center" colspan="2"><textarea  cols="40" rows="10" name="ntext"><?=@$ntext;?></textarea></td>




                    <tr><td colspan=2 align=center><input type="submit" value="edit" class=inputbox> </td></tr>
                     </table>

                    </td></tr></table>
                    </form>
                     <!-------end-------//-->
                    </td>
                  </tr>
                </table>
				<?
include 'footer.php'; 
?>