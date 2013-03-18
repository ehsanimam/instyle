<?
session_start();
include("../common.php");
include('../functionsadmin.php');
//$strFile1        =  $_FILES["prod_image"]["name"];
 //$strTempFile1    =  $_FILES["prod_image"]["tmp_name"];  
//admin_session_check();
if(@$prod_id != "")
{ 
	$sql="select * from tblzoom_img where prod_id = '$prod_id'";
	$p_rs=mysql_query($sql);
    $p_row=mysql_fetch_array($p_rs);
//echo $sql;
//exit;
}

if(@$act=="modi")
{
	if($zoom_img1!=''){ 
		unlink_zoom_img($prod_id, 1);
		$zoom_img1= admin_addnew_zoom_products_img(1); }
	else{ $zoom_img1 = ""; }

if($zoom_img2!=''){ 
		unlink_zoom_img($prod_id, 2);
		$zoom_img2= admin_addnew_zoom_products_img(2); }
	else{ $zoom_img2 = ""; }

if($zoom_img3!=''){ 
		unlink_zoom_img($prod_id, 3);
		$zoom_img3= admin_addnew_zoom_products_img(3); }
	else{ $zoom_img3 = ""; }

    $prod_return=admin_edit_zoom_product($prod_id, $zoom_img1, $zoom_img2, $zoom_img3);
    if($prod_return > 0)
    {
        			echo "
				 <script>
					location.href='add_zoom_img_product.php?prod_id=$prod_return'
				 </script>
				 ";
    }
}

include 'top.php'; 
?>
<title>In Style New York ::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function submit_form()
{
   // document.prod_frm.subcat.value=0;
    document.prod_frm.method="post";
    document.prod_frm.action="add_zoom_img_product.php?act=show&mode=e";
    document.prod_frm.submit();

}
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td class="tab" align="center" valign="middle">
	<? if(@$mode=="e" || @$mode==""){?>

          <form name="prod_frm" method="post" action="add_zoom_img_product.php?act=modi" enctype="multipart/form-data">
         	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  				<tr valign="top">
					<td class="border_color">
						<table border="0" cellpadding="5" cellspacing="1" width=100%  valign = "top">
               	  
               
				    <? if(@$p_row['zoom_img1'] != ""){          ?>
						 <tr bgcolor="#eeeeee"> 
                  <td align="right" class="text">Present Image/zoom1 : </td>
                  <td align="left"> <?
							$src_image = "product_picture/zoom1/".$p_row['zoom_img1'];			
						 ?>
						<img src="<? echo $src_image;?>" >
					  </td>
					</tr>
					 <?}	
					?>
                <tr bgcolor="#eeeeee"> 
                  <td class="text" align="right"> Zoom Image 1 : </td>
                  <td align="left"><input type="file" name="zoom_img1" id="zoom_img1" class="inputbox"> 
                  </td>
                </tr>
				    <? if(@$p_row['zoom_img2'] != ""){  ?>
						<tr bgcolor="#ffffff"> 
						  <td align="right" class="text">Present Image/zoom2 : </td>
						  <td align="left"> 
					<?
							$src_image2 = "product_picture/zoom2/".$p_row['zoom_img2'];			
						?>
							<img src="<? echo $src_image2;?>" >
						  </td>
						</tr>
						<? }	
					?>
					<tr> 
                  <td class="text" align="right"> Zoom Image 2 : </td>
                  <td align="left"><input type="file" name="zoom_img2" id="zoom_img2" class="inputbox"></td>
                </tr>
				<!-- <tr bgcolor="#eeeeee"> 
                  <td class="text" align="right"> Product Image 3 : </td>
                  <td align="left"><input type="file" name="prod_image2" id="prod_image2" class="inputbox"></td>
                </tr> -->
                <input type="hidden" name="prod_id" value="<? echo $p_row['prod_id'];?>">
                <tr bgcolor="#eeeeee"> 
                  <td colspan=2 align=center> <input type="submit" name="cmd_cat_submit" class=button value="Save"> 
                  </td>
                </tr>
              </table>
				  </td>
					</tr>
				</table>
			</form>

      <? }?>
 <!--Close for Edit Product..**************************************-->
 

	</td>
</tr>
</table>
<? include 'footer.php'; ?>