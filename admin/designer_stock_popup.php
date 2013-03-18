<?
session_start();
include("../common.php");


if(isset($_POST['submit']))

   {
	
$import="update tbl_stock set size_0='".$_REQUEST['size_0']."',size_2='".$_REQUEST['size_2']."',size_4='".$_REQUEST['size_4']."',size_6='".$_REQUEST['size_6']."',size_8='".$_REQUEST['size_8']."',size_10='".$_REQUEST['size_10']."',size_12='".$_REQUEST['size_12']."',size_14='".$_REQUEST['size_14']."',size_16='".$_REQUEST['size_16']."',size_xs='".$_REQUEST['size_xs']."',size_s='".$_REQUEST['size_s']."',size_m='".$_REQUEST['size_m']."',size_l='".$_REQUEST['size_l']."',size_xl='".$_REQUEST['size_xl']."' where st_id='".$_REQUEST['eid']."'";
								   

       $res_imp=mysql_query($import) or die(mysql_error());
	if($res_imp!=''){  
	 print "<script>opener.location.href='edit_color_size.php?msg=1';window.close();</script>"; 	  
    }
}


$select1="SELECT s.*, d.designer,c.color_name,p.prod_name FROM tbl_stock s LEFT JOIN designer d ON d.des_id = s.des_id LEFT JOIN tblcolor c ON c.color_id = s.cs_id LEFT JOIN tbl_product p ON p.prod_id = s.prod_id where st_id='".$_GET['eid']."'";
$result1=mysql_query($select1);
$row3=mysql_fetch_array($result1);

?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
					<form name="size" action="designer_stock_popup.php" method="post" enctype='multipart/form-data'>
					<? if(isset($msg)) { ?> <span style="color:#CC0000;" class="text"><strong><?=$msg?></strong></span> <? }?>
                    <table width=80% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
					<tr><td>
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc><td align=center colspan=16><h1>EDIT STOCK</h1></td></tr>
                    <tr><td align=center colspan=16 class="error"><?=@$err;?></td></tr>
                        <td class="text" align="right" colspan="2">Designer:</td>
						<td align="left" colspan=14> 
							<input type="text" name="<?=$row3['des_id']?>" class="inputbox" value="<? echo @$row3['designer'];?>">
						</td>
					</tr>
					
				<tr>
					<td class="text" align="right" colspan="2">Color : </td>
                  <td align="left" class="text" colspan="14">
                  <div id="colordiv"><input type="text" name="<?=$row3['cs_id']?>" class="inputbox" value="<? echo @$row3['color_name'];?>"></div>
				  </td>
                </tr>
				<tr><td align=center colspan=16 class="error"><?=@$err;?></td></tr>
                        <td class="text" align="right" colspan="2">Product:</td>
						  <td align="left" class="text" colspan="14">
                  <div id="proddiv"><input type="text" name="<?=$row3['prod_id']?>" class="inputbox" value="<? echo @$row3['prod_name'];?>"></div>
				  </td>
					</tr>
					<tr>
					<td colspan="2">&nbsp;</td>
					<td align="left" class="text"><div id="stockdiv">
                    
     <?php 
$cs2 = mysql_query("select * from designer_size where des_id='".$row3['des_id']."'") or die(mysql_error());
$cs_row2 = mysql_fetch_array($cs2);
$size_id=explode(",",$cs_row2['size_id']);

	 
	 ?>               
      <table width="576" border="0" cellspacing="5" cellpadding="0" class="text"><tr>              
    <?php                
      foreach($size_id as $sizeid) {
		
			$cs1 = mysql_query("select * from tblsize where size_id='".$sizeid."'") or die(mysql_error());
			$cs_row1 = mysql_fetch_array($cs1);              
              ?>      
             <td width="7%" ><strong>&nbsp;&nbsp;&nbsp;<?=$cs_row1["size_name"]?></strong> </td>  
             <?php     
        }
		?>
		</tr><tr>          
         <?php           
         foreach($size_id as $sizeid) {
		
			$cs4 = mysql_query("select * from tblsize where size_id='".$sizeid."'") or die(mysql_error());
			$cs_row4 = mysql_fetch_array($cs4);
?>
				<td><input type='text' name=<?="size_".strtolower($cs_row4["size_name"])?> size='2' value="<? echo $row3["size_".strtolower($cs_row4["size_name"])];?>"></td>
                <?php
		  }
		  ?>
          </tr></table>        
                    </div></td>
					</tr>
					<input type="hidden" name="eid" value="<?=$_GET['eid']?>">
                       <tr><td colspan="2">&nbsp;</td><td colspan=14 align=center><input type="submit" name="submit" value="Upload &amp; Save" class=button style="width:120px;"> </td></tr>
                     </table>
                    </td></tr></table>
                    </form>
	
	
	</td>
</tr>
</table>
