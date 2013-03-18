<?
session_start();
include("../common.php");
include("security.php");

if(@$action=='delete')
{
 $delete="delete from tblsize where size_id='$eid'";
 mysql_query($delete);

 header('location:edit_size.php');
 //delete the related urls!!!!!!!!!!!!!!!!!!
}


$select="select * from tblsize";
$result=mysql_query($select);

include 'top.php'; 
?>
<script>
function confirm_delete()
{
var agree=confirm("Are you sure you wish to delete the record?");
if (agree)
return true ;
else
return false ;
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	
	<form name="faq" action="edit_size.php" method="post">
					<?php if(isset($_GET['msg'])) { ?>
					<span style="color:#CC0000;" class="text"><strong>CSV has been updated</strong></span><br /><br />
					<?php } ?>
                    <table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <table width=100% align=center cellspacing=2 cellpadding=2 >
                    <tr bgcolor=cccccc>
                    <td align=center colspan=2><h1>Update CSV </h1></td></tr>

                    <?php
					$get_tcs = mysql_query("SELECT
											  d.designer, d.des_id
											FROM
											  tbl_color_size tcs
											  JOIN designer d ON d.des_id = tcs.des_id
											GROUP BY
											  tcs.des_id");
					if(mysql_num_rows($get_tcs)>0) {
						while($d_row = mysql_fetch_array($get_tcs)) {
					?>
                    <tr>
                    	<td width="40%" class="text" align="right"><?=$d_row['designer'];?> : </td>
						<td width="60%" align="left">
							
										<span class="text">[</span><a href="#" class="pagelinks" onclick="javascript:window.open('sizecolor_edit_popup.php?des_id=<?=@$d_row['des_id'];?>','','height=150 width=400')">Update CSV</a><span class="text">]</span>
								
							
							</td>
						</tr>
                     <?
					 	}
					 }
					 ?>
                   </table>
                    </td></tr></table>
                    </form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>