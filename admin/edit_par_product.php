<?
session_start();
include("../common.php");
include('../functionsadmin.php');
//$strFile1        =  $_FILES["prod_image"]["name"];
 //$strTempFile1    =  $_FILES["prod_image"]["tmp_name"];  
//admin_session_check();
if(@$act=="show")
{   if(@$search)
	$sql="select * from tblproduct where prod_name like '%$prod_id%'";
	else
    $sql="select * from tblproduct where prod_id='$prod_id'";
    $p_rs=mysql_query($sql);
    $p_row=mysql_fetch_array($p_rs);

		
	   if(@$cat==""){$cat=$p_row['cat_id'];}
       else{$cat=$cat;}
	   if(@$type==""){$type=$p_row['type_id'];}
       else{$type=$type;}
        
        //if($subcat==''){if($p_row[subcat_id]!=""){$subcat=$p_row[subcat_id];}else{$subcat=$subcat;}}
		
//		echo $subcat1 = $p_row[subcat_id];
		
		if(@$subcat)
		{
			$subcat1 =$subcat;
		}
		else $subcat1 = $p_row['subcat_id'];
		/*if(@$type)
		{
			$type1 =$type;
		}
		else $type1 = $p_row['type_id'];*/
		
		if(@$manuf=='')
		{
			if($p_row['manufacturer_id']!='0'){$manuf=$p_row['manufacturer_id'];}
		}
        		
		if(@$subcat_manu=='')
		{
			if($p_row['manu_sub_id']!=""){$subcat_manu=$p_row['manu_sub_id'];}
        	else{$subcat_manu=0;}
		}
		
		if(@$trend == '')
		{
			if($p_row['trend_id']!=""){$trend=$p_row['trend_id'];}
		}
		
		if(@$subcat_trend=='')
		{
			if($p_row['trend_sub_id']!=""){$subcat_trend=$p_row['trend_sub_id'];}
		    else{$subcat_trend=0;}
		}
		
		if(@$tosale==''){$tosale=$p_row['on_sale'];}
		
		for($n=1;$n<4;$n++)
		{
			$xy="asso".$n;
			$t="suggest".$n;
			if(@$$xy==''){$$xy=$p_row[$t];}
		}	
        
		//$cat=$p_row[cat];
}
if(@$act=="modi")
{

    $prod_return=admin_edit_product($prod_name, $prod_no, $cat, $subcat, $manuf, $subcat_manu, $add_date, $trend, $subcat_trend, $asso1, $asso2, $asso3, $tosale, $prod_desc, $prod_id, $type);
    if($prod_return==0)
    {
        		if ($prod_image0!='')
				{ 
					uplink_product_iamges($prod_id, 0);
					admin_add_products_img($prod_id, 0);
				}
				if ($prod_image1!='')
				{ 
					uplink_product_iamges($prod_id, 1);
					admin_add_products_img($prod_id, 1);
				}
				if ($prod_image2!='')
				{
					uplink_product_iamges($prod_id, 2);
					admin_add_products_img($prod_id, 2);
				}
				if ($prod_image3!='')
				{
					uplink_product_iamges($prod_id, 3);
					admin_add_products_img($prod_id, 3);
				}
				if ($sketch_img!='')
				{
					uplink_product_iamges_sketch($prod_id);
					admin_add_products_img($prod_id);
				}
				
				/*$strFile1        =  $_FILES["prod_image0"]["name"];
				$strTempFile1    =  $_FILES["sketch_img"]["tmp_name"];  
				move_uploaded_file($strTempFile1,"product_picture/sketch/".strtolower($strFile1));*/
		
					echo "
				 <script>
					location.href='display_product.php?cat_id=$cat_id'
				 </script>
				 ";
    }
	else
	{
		echo "
             <script>
                location.href='edit_par_product.php?act=show&prod_id=$prod_id&mode=e&prod_return=1&err=$GLOBALS[message]'
             </script>
             ";
	}
}

if($act=="del")
{
    uplink_product_iamges($prod_id, 0);
	uplink_product_iamges($prod_id, 1);
	uplink_product_iamges($prod_id, 2);
	uplink_product_iamges($prod_id, 3);
	
	$del_sql="delete from tblproduct where prod_id='$prod_id'";;
    mysql_query($del_sql);
	$del_sql="delete from tblproduct_details where prod_id='$prod_id'";;
    mysql_query($del_sql);
	$del_sql="delete from tblproduct_size where prod_id='$prod_id'";;
    mysql_query($del_sql);
    
	//unlink the related image
       
    
	 echo "
             <script>
                location.href='display_product.php'
             </script>
             ";
}



include 'top.php'; 
?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function submit_form()
{
   // document.prod_frm.subcat.value=0;
    document.prod_frm.method="post";
    document.prod_frm.action="edit_par_product.php?act=show&mode=e";
    document.prod_frm.submit();

}
</script>
<script>
function back_display()
{
    location.href="edit_product.php?cat_id=<?=$cat;?>"
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td class="tab" align="center" valign="middle">
	<? if(@$mode=="e"){?>

          <form name="prod_frm" method="post" action="edit_par_product.php?act=modi" enctype="multipart/form-data">
         	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  				<tr valign="top">
					<td class="border_color">
						<table border="0" cellpadding="5" cellspacing="1" width=100%  valign = "top">
                <!--DWLayoutTable-->
                <input type="hidden" name="prod_id" value="<? echo @$prod_id?>">
                <input type="hidden" name="hidOldFile1" value="<?PHP print $p_row['prod_image'] ; ?>">
                <? if(@$prod_return==1){?>
                <tr bgcolor="#eeeeee"> 
                  <td class="error" colspan=2><? echo @$err;?>&nbsp;</td>
                </tr>
                <? }?>
                <tr bgcolor="#eeeeee"> 
                  <td width="256" align="right" class="text">Product name : </td>
                  <td width="614" align="left"><input type="text" name="prod_name" class="inputbox" value="<? echo $p_row['prod_name'];?>"></td>
                </tr>
				<tr bgcolor="#eeeeee"> 
                  <td width="256" align="right" class="text">STYLE NUMBER : </td>
                  <td width="614" align="left"><input type="text" name="prod_no" class="inputbox" value="<? echo $p_row['prod_no'];?>"></td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td align="right" class="text">Category name : </td>
                  <td align="left"> 
                    <? @get_categories();?>
                    <script>document.prod_frm.cat.value="<?=$cat;?>"</script> 
                  </td>
                </tr>
                <tr  bgcolor="#eeeeee"> 
                  <td align="right" class="text">SubCategory name : </td>
                  <td align="left"> 
                    <? get_subcategories($cat);?>
                    <script>document.prod_frm.subcat.value="<?=$subcat1;?>"</script> 
                  </td>
                </tr>
				<tr  bgcolor="#eeeeee"> 
                  <td align="right" class="text">Type Category name : </td>
                  <td align="left"> 
                    <? get_typecategories_edit();?>
                    <script>document.prod_frm.type.value="<?=$type;?>"</script> 
                  </td>
                </tr>
                <tr  bgcolor="#eeeeee"> 
                  <td align="right" class="text">Product Date : </td>
                  <td align="left"><input type="text" name="add_date" class="inputbox" value="<? echo $p_row['prod_date'];?>"> <span class="text"> 
                    (yyyy-mm-dd) e.g <? echo date('Y-m-d');?></td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td align="right" class="text">Present Image/s : </td>
                  <td align="left"> 
				    <? if(@$p_row['prod_image0']==""){                  
                   
						 	$src_image = "product_picture/sketch/".$p_row['sketch_img'];
						 }else{						 
							$src_image = "product_picture/mini_thumb/".$p_row['prod_image0'];			
						 }	
					?>
                    <img src="<? echo $src_image;?>" >
                  </td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td class="text" align="right"> Product Image : </td>
                  <td align="left"><input type="file" name="prod_image0" class="inputbox"> 
                  </td>
                </tr>
				<tr> 
                  <td class="text" align="right">Sketch Image : </td>
                  <td align="left"><input type="file" name="sketch_img" id="sketch_img" class="inputbox"></td>
                </tr>
                <?
					  for($x=1;$x<4;$x++)
					  {
					  	$xy1="asso".$x;
					  ?>
                <? }?>
                <tr bgcolor="#eeeeee"> 
                  <td height="22" colspan="2" align="center" valign="middle"><a href="edit_det_product.php" class="pagelinks">Edit 
                    Details to Product</a><img src="spacer.gif" alt=" " width="50" height="1"><a href="edit_size_product.php?prod_id=<?=$prod_id;?>" class="pagelinks">Edit 
                    Stock to Product</a></td>
                </tr>
                <input type="hidden" name="prod_id" value="<? echo $p_row['prod_id'];?>">
                <tr bgcolor="#eeeeee"> 
                  <td colspan=2 align=center> <input type="submit" name="cmd_cat_submit" class=button value="Update"> 
                    <input type="button" name="cmd_cat_cancel"  class=button value="Cancel" onClick="back_display();"> 
                  </td>
                </tr>
              </table>
				  </td>
					</tr>
				</table>
			</form>

      <? }?>
 <!--Close for Edit Product..**************************************-->
 
 <!--This part for Delete Product..**************************************-->
     <? if($mode=="d"){?>

          <form name="prod_del_frm" method="post" action="edit_par_product.php?act=del" enctype="MULTIPART/FORM-data">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr valign="top" class="bodytext">
					<td class="text">
						<table border="0" cellpadding="5" cellspacing="1" width=100%>
                <tr bgcolor="#eeeeee"> 
                  <td width="30%" align="right">Category name : </td>
                  <td width="70%" align="left"> 
                    <? get_catname($cat);?>
                  </td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td width="30%" align="right">SubCategory name : </td>
                  <td width="70%" align="left">
                    <? get_typename($subcat1);?>
                  </td>
                </tr>
				<tr bgcolor="#eeeeee"> 
                  <td width="30%" align="right">Type Category name : </td>
                  <td width="70%" align="left">
                    <? get_typename($type);?>
                  </td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td align="right">Product name : </td>
                  <td align="left"><? echo $p_row['prod_name'];?></td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td align="right">Precent Image : </td>
                  <td align="left"> 
                    <? if($p_row['prod_image0']==""){
						 	$src_image = "product_picture/sketch/".$p_row['sketch_img'];
						 }else{						 
							$src_image = "product_picture/mini_thumb/".$p_row['prod_image0'];			
						 }					
					?>                    
                     <img src="<?php echo $src_image;?>" >                     
                  </td>
                </tr>
                <input type="hidden" name="prod_id" value="<? echo $p_row['prod_id'];?>">
                <input type="hidden" name="image_name" value="<? echo $p_row['prod_image'];?>">
                <tr bgcolor="#eeeeee"> 
                  <td colspan=2 align=center> <span style="color:#FF0000; font-weight:bold">Do 
                    you want to delete?<br>
                    &nbsp;<br>
                    </span> <input type="submit" name="cmd_prod_del" class=button value="Yes"> 
                    <input type="button" name="cmd_prod_cancel" class=button value="No" onClick="back_display();"> 
                  </td>
                </tr>
              </table>
					</td>
				</tr>
			</table>
          </form>

      <? }?>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>