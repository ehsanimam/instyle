<?
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php");
if(@$act=="show")
{   if(@$search)
	$sql="select * from tbl_product where prod_name like '%$prod_id%'";
	else
    $sql="select * from tbl_product where prod_id='$prod_id'";
    $p_rs=mysql_query($sql);
    $p_row=mysql_fetch_array($p_rs);
		
	   if(@$cat==""){$cat=$p_row['cat_id'];}
       else{$cat=$cat;}
	   if(@$type==""){$type=$p_row['type_id'];}
       else{$type=$type;}
        
		
		if(@$subcat)
		{
			$subcat1 =$subcat;
		}
		else $subcat1 = $p_row['subcat_id'];
		
		if(@$subsubcat)
		{
			$subsubcat1 =$subsubcat;
		}
		else $subsubcat1 = $p_row['subsubcat_id'];
		
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
		
			
		if(@$tosale==''){if($p_row['on_sale'] != ""){$tosale=$p_row['on_sale'];}else{$tosale=1;}}
		
	       
}
if(@$act=="modi")
{


$color= implode(",",$_POST['cs']);
$color_name=array();
foreach($_POST['cs'] as $col){

$getpic = mysql_query("SELECT  * FROM  tblcolor  WHERE color_id='".$col."'") or die(mysql_error());
$getres=mysql_fetch_array($getpic);
array_push($color_name,$getres[color_code]);
}
    $colorname= implode(",",$color_name);
	$primary = explode(',',$_POST['primary']);
	
	
	
$get_img1 = mysql_fetch_array(mysql_query("select * from tbl_product where prod_id='".$prod_id."'"));


$color_names=explode(",",$get_img1['colornames']);
						 	foreach($color_names as $col){
							
							$getpic = mysql_query("SELECT * 
												FROM 
												 tblcolor
												WHERE
												  color_code='".$col."'") or die(mysql_error());
							$irow=mysql_fetch_array($getpic);	



if ($_FILES["front_".$get_img1['prod_no']."_".$irow['color_code']]['name']!="")
		{
		
		
		$file_product1="../images/bridal/product_front/".$get_img1["prod_no"]."_".$irow["color_code"].".jpg" ;
		 unlink($file_product1);
		
		
		    $img_front1=$_FILES["front_".$get_img1['prod_no']."_".$irow['color_code']]['name'];
			$uploadFilesTo1 = '../images/bridal/product_front';
			$fileatt1 =$_FILES["front_".$get_img1['prod_no']."_".$irow['color_code']]['tmp_name'];
			$fileatt_type1 =$_FILES["front_".$get_img1['prod_no']."_".$irow['color_code']]['type'];
			
			$img1=explode(".",$img_front1);
			
			$fileatt_name1=$get_img1['prod_no']."_".$irow['color_code'].".".$img1[1];
			$fp1 = fopen($fileatt1, 'rb');
			$data1 = fread($fp1, filesize($fileatt1));
			fclose($fp1);
			$data1 = chunk_split(base64_encode($data1));
			move_uploaded_file($fileatt1, $uploadFilesTo1.'/'.$fileatt_name1);
			
		}
		
if ($_FILES["back_".$get_img1['prod_no']."_".$irow['color_code']]['name']!="")
		{
		
		
		 $file_product2="../images/bridal/product_back/".$get_img1["prod_no"]."_".$irow["color_code"].".jpg" ;
		 unlink($file_product2);

		
		
		    $img_front2=$_FILES["back_".$get_img1['prod_no']."_".$irow['color_code']]['name'];
			$uploadFilesTo2 = '../images/bridal/product_back';
			$fileatt2 =$_FILES["back_".$get_img1['prod_no']."_".$irow['color_code']]['tmp_name'];
			$fileatt_type2 =$_FILES["back_".$get_img1['prod_no']."_".$irow['color_code']]['type'];
			
			$img2=explode(".",$img_front2);
			
			$fileatt_name2=$get_img1['prod_no']."_".$irow['color_code'].".".$img2[1];
			$fp2 = fopen($fileatt2, 'rb');
			$data2 = fread($fp2, filesize($fileatt2));
			fclose($fp2);
			$data2 = chunk_split(base64_encode($data2));
			move_uploaded_file($fileatt2, $uploadFilesTo2.'/'.$fileatt_name2);
			
		}
		
if ($_FILES["side_".$get_img1['prod_no']."_".$irow['color_code']]['name']!="")
		{
		
		 $file_product3="../images/bridal/product_side/".$get_img1["prod_no"]."_".$irow["color_code"].".jpg" ;
		 unlink($file_product3);

		
		    $img_front3=$_FILES["side_".$get_img1['prod_no']."_".$irow['color_code']]['name'];
			$uploadFilesTo3 = '../images/bridal/product_side';
			$fileatt3 =$_FILES["side_".$get_img1['prod_no']."_".$irow['color_code']]['tmp_name'];
			$fileatt_type3 =$_FILES["side_".$get_img1['prod_no']."_".$irow['color_code']]['type'];
			
			$img3=explode(".",$img_front3);
			
			$fileatt_name3=$get_img1['prod_no']."_".$irow['color_code'].".".$img3[1];
			$fp3 = fopen($fileatt3, 'rb');
			$data3 = fread($fp3, filesize($fileatt3));
			fclose($fp3);
			$data3 = chunk_split(base64_encode($data3));
			move_uploaded_file($fileatt3, $uploadFilesTo3.'/'.$fileatt_name3);
			
		}
	
	if ($_FILES["icon_".$get_img1['prod_no']."_".$irow['color_code']]['name']!="")
		{
		
		 $file_product4="../images/bridal/product_coloricon/".$get_img1["prod_no"]."_".$irow["color_code"].".jpg" ;
		 unlink($file_product4);

		
		    $img_front4=$_FILES["icon_".$get_img1['prod_no']."_".$irow['color_code']]['name'];
			$uploadFilesTo4 = '../images/bridal/product_coloricon';
			$fileatt4 =$_FILES["icon_".$get_img1['prod_no']."_".$irow['color_code']]['tmp_name'];
			$fileatt_type4 =$_FILES["icon_".$get_img1['prod_no']."_".$irow['color_code']]['type'];
			
			$img4=explode(".",$img_front4);
			
			$fileatt_name4=$get_img1['prod_no']."_".$irow['color_code'].".".$img4[1];
			$fp4 = fopen($fileatt4, 'rb');
			$data4 = fread($fp4, filesize($fileatt4));
			fclose($fp4);
			$data4 = chunk_split(base64_encode($data4));
			move_uploaded_file($fileatt4, $uploadFilesTo4.'/'.$fileatt_name4);
			
		}
		
		
		if ($_FILES["video_".$get_img1['prod_no']."_".$irow['color_code']]['name']!="")
		{
		
		 $file_product5="../images/bridal/product_video/".$get_img1["prod_no"]."_".$irow["color_code"].".flv" ;
		 unlink($file_product5);

		
		    $img_front5=$_FILES["video_".$get_img1['prod_no']."_".$irow['color_code']]['name'];
			$uploadFilesTo5 = '../images/bridal/product_video';
			$fileatt5 =$_FILES["video_".$get_img1['prod_no']."_".$irow['color_code']]['tmp_name'];
			$fileatt_type5 =$_FILES["video_".$get_img1['prod_no']."_".$irow['color_code']]['type'];
			
			$img5=explode(".",$img_front5);
			
			$fileatt_name5=$get_img1['prod_no']."_".$irow['color_code'].".".$img5[1];
			$fp5 = fopen($fileatt5, 'rb');
			$data5 = fread($fp5, filesize($fileatt5));
			fclose($fp5);
			$data5 = chunk_split(base64_encode($data5));
			move_uploaded_file($fileatt5, $uploadFilesTo5.'/'.$fileatt_name5);
			
		}
		
		
			$stock_qry="select * from tbl_stock where prod_id='".$get_img1['prod_id']."' and cs_id='".$irow['color_id']."'";
			$stock_res=mysql_query($stock_qry);
			$num_stock=mysql_num_rows($stock_res);
			$stock_rec=mysql_fetch_array($stock_res);

		if($num_stock!=0){
		
		 $import="update tbl_stock set size_0='".$_REQUEST[$irow[color_code].'_size_0']."',size_2='".$_REQUEST[$irow[color_code].'_size_2']."',size_4='".$_REQUEST[$irow[color_code].'_size_4']."',size_6='".$_REQUEST[$irow[color_code].'_size_6']."',size_8='".$_REQUEST[$irow[color_code].'_size_8']."',size_10='".$_REQUEST[$irow[color_code].'_size_10']."',size_12='".$_REQUEST[$irow[color_code].'_size_12']."',size_14='".$_REQUEST[$irow[color_code].'_size_14']."',size_16='".$_REQUEST[$irow[color_code].'_size_16']."',size_xs='".$_REQUEST[$irow[color_code].'_size_xs']."',size_s='".$_REQUEST[$irow[color_code].'_size_s']."',size_m='".$_REQUEST[$irow[color_code].'_size_m']."',size_l='".$_REQUEST[$irow[color_code].'_size_l']."',size_xl='".$_REQUEST[$irow[color_code].'_size_xl']."' where prod_id='".$get_img1['prod_id']."' and cs_id='".$irow['color_id']."'";
								   

       
	}else{
	
	$import="INSERT into tbl_stock (des_id,
									cs_id,
									prod_id,
									size_0,
									size_2,
									size_4,
									size_6,
									size_8,
									size_10,
									size_12,
									size_14,
									size_16,
									size_xs,
									size_s,
									size_m,
									size_l,
									size_xl) 
							values(
									'".$get_img1['designer']."',
									'".$irow['color_id']."',
									'".$get_img1['prod_id']."',
									'".$_REQUEST[$irow[color_code].'_size_0']."',
									'".$_REQUEST[$irow[color_code].'_size_2']."',
									'".$_REQUEST[$irow[color_code].'_size_4']."',
									'".$_REQUEST[$irow[color_code].'_size_6']."',
									'".$_REQUEST[$irow[color_code].'_size_8']."',
									'".$_REQUEST[$irow[color_code].'_size_10']."',
									'".$_REQUEST[$irow[color_code].'_size_12']."',
									'".$_REQUEST[$irow[color_code].'_size_14']."',
									'".$_REQUEST[$irow[color_code].'_size_16']."',
									'".$_REQUEST[$irow[color_code].'_size_xs']."',
									'".$_REQUEST[$irow[color_code].'_size_s']."',
									'".$_REQUEST[$irow[color_code].'_size_m']."',
									'".$_REQUEST[$irow[color_code].'_size_l']."',
									'".$_REQUEST[$irow[color_code].'_size_xl']."'
								   )";
	
	}
	
	$res_imp=mysql_query($import) or die(mysql_error());	
	
	}
	$cat=22;
    $prod_return=admin_edit_new_product($prod_id, $prod_name,$prod_no, $cat, $subcat,$subsubcat,$add_date,$catalogue_price, $less_discount,$prod_desc, $_REQUEST['designer'], $primary[0], $primary[1],$color,$colorname);
    if($prod_return==0)
    {
        			echo "
				 <script>
					location.href='edit_new_product.php?cat_id=$cat&subcat_id=$subcat'
				 </script>
				 ";
    }
	else
	{
		echo "
             <script>
                location.href='edit_new_par_bridalproduct.php?act=show&prod_id=$prod_id&mode=e&prod_return=1&err=$GLOBALS[message]'
             </script>
             ";
	}
}

if($act=="del")
{



$get_img1 = mysql_fetch_array(mysql_query("select * from tbl_product where prod_id='".$_REQUEST['prod_id']."'"));

	
	if($get_img1['colornames']!="") {
						 
						 $color_names=explode(",",$get_img1['colornames']);
						 	foreach($color_names as $col){
							
							
	$file_mini_thumb1="../images/bridal/product_front/".$get_img1["prod_no"]."_".$col.".jpg" ;
	$file_mini_thumb2="../images/bridal/product_side/".$get_img1["prod_no"]."_".$col.".jpg" ;
	$file_mini_thumb3="../images/bridal/product_back/".$get_img1["prod_no"]."_".$col.".jpg" ;
	$file_mini_thumb4="../images/bridal/product_coloricon/".$get_img1["prod_no"]."_".$col.".jpg" ;
	$file_mini_thumb5="../images/bridal/product_video/".$get_img1["prod_no"]."_".$col.".flv" ;
	
	
	if(@file_exists($file_mini_thumb1)) {
	   unlink($file_mini_thumb1);
	   }
	   
	   if(@file_exists($file_mini_thumb2)) {
	   unlink($file_mini_thumb2);
	   }
	   
	   if(@file_exists($file_mini_thumb3)) {
	   unlink($file_mini_thumb3);
	   }
	   
	   if(@file_exists($file_mini_thumb4)) {
	   unlink($file_mini_thumb4);
	   }
	   
	   if(@file_exists($file_mini_thumb5)) {
	   unlink($file_mini_thumb5);
	   }
	
							
  }
							
	 }
	
	
	@mysql_query("delete from tbl_product where prod_id='".$prod_id."'") or die(mysql_error());
   
    ?>
	<script type="text/javascript">
			<!--
			window.location = "edit_new_product.php?cat_id=<?=$_GET['cat_id']?>"
			//-->
	</script>
	<?php }

include 'top.php'; 
?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function submit_form()
{
   // document.prod_frm.subcat.value=0;
    document.prod_frm.method="post";
    document.prod_frm.action="edit_new_par_bridalproduct.php?act=show&mode=e";
    document.prod_frm.submit();

}
function confirmLink(theLink,msg)
{
    // Confirmation is not required in the configuration file
    var is_confirmed = confirm(msg);
    return is_confirmed;
} 

</script>
<script>
function back_display()
{
    location.href="edit_new_product.php?cat_id=<?=$cat;?>&subcat_id=<?=$subcat1?>"
}
</script>

    <link type="text/css" href="js/datePicker.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataPicker.js"></script>
	<script type="text/javascript" src="js/date.js"></script>
    

	<script type="text/javascript">
	$(function()
{
	$('.date-pick').datePicker()
	$('#add_date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				//$('#add_date').dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
	
});
	</script>
    
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td class="tab" align="center" valign="middle">
	<? if(@$mode=="e"){?>

          <form name="prod_frm" method="post" action="edit_new_par_bridalproduct.php?act=modi" enctype="multipart/form-data">
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
                <?php if($_GET['msg']==1){?>
                <tr>
                  <td align=center colspan=2 class="error">Delete image Successful.</td>
                </tr>
                <?php } ?>
                <?php if($_GET['msg']==3){?>
                <tr>
                  <td align=center colspan=2 class="error">Images & Stock Added Successfully.</td>
                </tr>
                <?php } ?>
	              <tr bgcolor="#eeeeee"> 
                  <td width="403" align="right" class="text">Product name : </td>
                  <td width="946" align="left"><input type="text" name="prod_name" class="inputbox" value="<? echo $p_row['prod_name'];?>"></td>
                </tr>
				<tr bgcolor="#eeeeee"> 
                  <td width="403" align="right" class="text">Style Number : </td>
                  <td width="946" align="left"><input type="text" name="prod_no" class="inputbox" value="<? echo $p_row['prod_no'];?>" readonly="readonly"></td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td align="right" class="text">Category name : </td>
                  <td align="left"><input type="text" class="inputbox" value="Bridal" readonly> </td>
                </tr>
                <tr  bgcolor="#eeeeee"> 
                  <td align="right" class="text">SubCategory name : </td>
                  <td align="left"> 
                  <? @get_subcategories1();?>
                    <script>document.prod_frm.subcat.value="<?=$subcat1;?>"</script>                      </td>
                </tr>
                <tr  bgcolor="#eeeeee"> 
                  <td align="right" class="text"> Sub SubCategory name : </td>
                  <td align="left"> 
                    <? get_subsubcategories($subcat1);?>
                    <script>document.prod_frm.subsubcat.value="<?=$subsubcat1;?>"</script>                  </td>
                </tr>
				<tr  bgcolor="#eeeeee"> 
                  <td class="text" align="right">Designer : </td>
                  <td> 
				  <select name="designer">
				  	<option value=""> - select designer - </option>
                    <?php
					$get_designer = @mysql_query("select * from designer where catid='".$cat."'");
					if(mysql_num_rows($get_designer) > 0) {
						while($row = mysql_fetch_array($get_designer)) {
							?>
							<option value="<?=$row['des_id']?>" <?php echo $row['des_id']==$p_row['designer'] ? 'selected' : ''; ?>><?=$row['designer']?></option>
							<?
						}
					}
					?>
				   </select>				  </td>
                </tr>
                <tr  bgcolor="#eeeeee"> 
                  <td align="right" class="text">Product Date : </td>
                  <td align="left"><input name="add_date" id="add_date" class="date-pick" value="<? echo date('m/d/Y',strtotime($p_row['prod_date']));?>"/>&nbsp;<span class="text">(format:mm/dd/yyyy)</span></td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td align="right" class="text">Present images color/sizes: </td>
                  <td align="left"> 
				  	<table border="0" width="100%" cellspacing="0">
				    <? 
						 if($p_row['colornames']!="") {
						 
						 $color_names=explode(",",$p_row['colornames']);
						 	foreach($color_names as $col){
							
							$getpic = mysql_query("SELECT * 
												FROM 
												 tblcolor
												WHERE
												  color_code='".$col."'") or die(mysql_error());
							$irow=mysql_fetch_array($getpic);	
											  
							 ?>
							 <tr>
							 <td style="background:#ddd;">
							 <table border="0">
                             <tr>
							<td class="head1" colspan="4"><strong><?=$irow['color_name']?></strong></td>
							</tr>
                             <tr>
							 <td align="center" class="text" style="vertical-align:top;">
							 <? 
							 
							 $image_front="../images/bridal/product_front/".$p_row['prod_no']."_".$irow['color_code'].".jpg";
							 if (file_exists($image_front)) {
							
							
							 $p_qry=mysql_query("select * from tbl_product where prod_id='".$_REQUEST['prod_id']."'");
							 $r_res=mysql_fetch_array($p_qry);
							 
							
							 if($r_res['primary_img']==NULL || $r_res['primary_img']==''){
							
							$p_qry=mysql_query("update tbl_product set  primary_img='".product_front."',primary_img_id='".$irow['color_code']."' where prod_id='".$_REQUEST['prod_id']."'");
							 }
							 
							}
							
							
							 $p_qry1=mysql_query("select * from tbl_product where prod_id='".$_REQUEST['prod_id']."'");
							 $r_res1=mysql_fetch_array($p_qry1);

							 
							
							$primary_img_url="../images/bridal/".$r_res1['primary_img']."/".$r_res1['prod_no']."_".$r_res1['primary_img_id'].".jpg";
							
							 if (file_exists($image_front)) {
							 ?>	
							 Front <br />						 
							 <a href="bridalimage_del.php?prod_no=<?=$p_row['prod_no']?>&color_code=<?=$irow[color_code];?>&img_folder=product_front" onClick="return confirmLink(this,'<? print "Do you want to delete this image?";?>')" title="Click to delete image"><img src="resizeimage.php?w=60&h=90&constrain2=1&img=<?=$image_front?>" style="margin:1px; border:1px solid #333;" /> </a><br />	
							 <?php echo $primary_img_url==$image_front ? 'Primary' : ''; ?>					 	
							 <input type="radio" name="primary" value="product_front,<?=$irow['color_code']?>" <?php echo $primary_img_url==$image_front ? 'checked' : ''; ?> />							
							 <? } ?> 
							 </td>							 
							 
							 <td align="center" class="text" style="vertical-align:top;">
							 <? $image_side="../images/bridal/product_side/".$p_row['prod_no']."_".$irow['color_code'].".jpg";
							 if (file_exists($image_side)) { ?>	
							 Side <br />						 		
							<a href="bridalimage_del.php?prod_no=<?=$p_row['prod_no']?>&color_code=<?=$irow[color_code];?>&img_folder=product_side" onClick="return confirmLink(this,'<? print "Do you want to delete this image?";?>')" title="Click to delete image"> <img src="resizeimage.php?w=60&h=90&constrain2=1&img=<?=$image_side?>" style="margin:1px;border:1px solid #333;" /> </a><br />
							<?php echo $primary_img_url==$image_side ? 'Primary' : ''; ?>	
							 <input type="radio" name="primary" value="product_side,<?=$irow['color_code']?>" <?php echo $primary_img_url==$image_side ? 'checked' : ''; ?> />							 
							<? } ?>
							</td>
							
							
							<td align="center" class="text" style="vertical-align:top;">
							<? $image_back="../images/bridal/product_back/".$p_row['prod_no']."_".$irow['color_code'].".jpg";							
												
							 if (file_exists($image_back)) { ?>
							Back <br />
							<a href="bridalimage_del.php?prod_no=<?=$p_row['prod_no']?>&color_code=<?=$irow[color_code];?>&img_folder=product_back" onClick="return confirmLink(this,'<? print "Do you want to delete this image?";?>')" title="Click to delete image"> <img src="resizeimage.php?w=60&h=90&constrain2=1&img=<?=$image_back?>" style="margin:1px;border:1px solid #333;" /> </a><br />
							<?php echo $primary_img_url==$image_back ? 'Primary' : ''; ?>	
							 <input type="radio" name="primary" value="product_back,<?=$irow['color_code']?>" <?php echo $primary_img_url==$image_back ? 'checked' : ''; ?> />							
							<? } ?>
							</td>
                            <td align="center" class="text" style="vertical-align:top;">
							<? $run_video="../images/bridal/product_video/".$p_row['prod_no']."_".$irow['color_code'].".flv";							
												
							 if (file_exists($run_video)) { ?>
							Video <br />
							<a href="bridalimage_del.php?prod_no=<?=$p_row['prod_no']?>&color_code=<?=$irow[color_code];?>&img_folder=product_video" onClick="return confirmLink(this,'<? print "Do you want to delete this video?";?>')" title="Click to delete video"> <img src="resizeimage.php?w=60&h=90&constrain2=1&img=../images/instylelnylogo.jpg" style="margin:1px;border:1px solid #333;" /> </a>
													
							<? } ?>
							</td>
							</tr>							
							</table>
							
							</td>
							<tr>
							<td class="text" style="background:#CCCCCC" colspan="4">
                            <?php 
	    $icon_url="../images/bridal/product_coloricon/".$p_row['prod_no']."_".$irow['color_code'].".jpg";
							if (file_exists($icon_url)) {
		$icon_url="../images/bridal/product_coloricon/".$p_row['prod_no']."_".$irow['color_code'].".jpg";
		}else{
		$icon_url="../images/bridal/product_coloricon/".$p_row['prod_no']."_".$irow['color_code'].".gif";
		}
							
							?>
							<strong>Color:</strong> <?=$irow['color_name']?> <img src="resizeimage.php?w=22&h=22&constrain2=1&img=<?=$icon_url?>" style="border:1px solid #efe; vertical-align:middle;" /> <!--[ <a href="#" onclick="javascript:window.open('edit_product_img_popup2.php?act=show&prod_id=<?= @$prod_id?>&mode=e&color_code=<?=$irow['color_code']?>&des_id=<?=$p_row['designer']?>','','height=500 width=520 scrollbars')">Edit Images & Stock</a> ]<br />-->
							</td>
							</tr>
                            <tr>
							<td class="text" style="background:#CCCCCC" colspan="4"><table border="0" cellpadding="1" cellspacing="1" width=100%  valign = "top">
                <? if(@$prod_return==1){?>
                <tr bgcolor="#eeeeee"> 
                  <td class="error" colspan=2><? echo @$err;?>&nbsp;</td>
                </tr>
                <? }?>
                <tr style="background: none repeat scroll 0% 0% rgb(204, 204, 204);"> 
                  <td align="left" class="" colspan="2"><strong><?=$csrow['color_name']?></strong></td>
                </tr>
	            <tr bgcolor="#eeeeee"> 
                  <td width="266" align="right" class="text">Front Image : </td>
                  <td width="671" align="left" class="error"><input type="file" name="front_<?=$p_row['prod_no']?>_<?=$irow['color_code']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                </tr>
				<tr bgcolor="#eeeeee"> 
                  <td width="266" align="right" class="text">Back Image : </td>
                  <td width="671" align="left" class="error"><input type="file" name="back_<?=$p_row['prod_no']?>_<?=$irow['color_code']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td width="266" align="right" class="text">Side Image : </td>
                  <td width="671" align="left" class="error"><input type="file" name="side_<?=$p_row['prod_no']?>_<?=$irow['color_code']?>" class="inputbox" >&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                </tr>
                <tr bgcolor="#eeeeee"> 
                  <td width="266" align="right" class="text">Color Icon Image : </td>
                  <td width="671" align="left" class="error"><input type="file" name="icon_<?=$p_row['prod_no']?>_<?=$irow['color_code']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 40 px x 40 px</td>
                </tr>
                 <tr bgcolor="#eeeeee"> 
                  <td width="266" align="right" class="text">Runway Video : </td>
                  <td width="671" align="left" class="error"><input type="file" name="video_<?=$p_row['prod_no']?>_<?=$irow['color_code']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;video must be minimum 327 px x 589 px</td>
                </tr>
                <tr bgcolor="#eeeeee">
                <td width="266" align="right" class="text">Stock : </td> 
                  <td width="671" align="left" class="text" > 
				 <table width="576" border="0" cellspacing="5" cellpadding="0" class="text"><tr>
                 <?php
		
			$cs1 = mysql_query("select * from tblsize") or die(mysql_error());
			while($cs_row1 = mysql_fetch_array($cs1)){
			?>

				<td width="7%" ><strong>&nbsp;&nbsp;&nbsp;<?=$cs_row1["size_name"]?></strong> </td>
                <?php
		  }
          ?>
		</tr><tr>
		<?php
		
			$stock_qry="select * from tbl_stock where prod_id='".$p_row['prod_id']."' and cs_id='".$irow['color_id']."'";
			$stock_res=mysql_query($stock_qry);
			$stock_rec=mysql_fetch_array($stock_res);

		
			$cs4 = mysql_query("select * from tblsize") or die(mysql_error());
			while($cs_row4 = mysql_fetch_array($cs4)){
			?>

				<td><input type='text' name='<?=$irow['color_code']?>_size_<?=strtolower($cs_row4["size_name"])?>' size='2' value="<?=$stock_rec['size_'.strtolower($cs_row4["size_name"])]?>"></td>
                <?php
		  }
		  ?>
         </tr></table>
				  
				  </td>
                </tr>
				</table></td>
							</tr>
                            
                            
							<tr><td style="font-size:5px;">&nbsp;</td></tr>
							 <?
							}
						 } else {
						 	echo '<tr><td class="text">Please select colors</td></tr>';
						 }
						 
						 
					?> 
				</table>    <!--[<a href="#" class="common" onclick="javascript:window.open('edit_product_img_popup.php?act=show&prod_id=<?= @$prod_id?>&mode=e&des_id=<?=$p_row['designer']?>','','height=500 width=520 scrollbars')"><strong>upload new colors</strong></a>]-->		</td>
                </tr>
                <tr  bgcolor="#eeeeee"> 
                  <td class="text" align="right">Color : </td>
                  <td> 
				  <div id="colordiv">
                   <table><tr><td>
                  <?php
				  $color_ids=explode(",",$p_row['colors']);
				 
				  	?> <select name="cs[]" style="font-size:11px;" multiple="multiple">
						<option> - select color - </option>
					 <?php
					$cs1 = mysql_query("select * from tblcolor order by color_name asc") or die(mysql_error());
                    while($cs_row1 = mysql_fetch_array($cs1)){
						?>
						<option value="<?=$cs_row1['color_id']?>" <?php echo in_array($cs_row1['color_id'],$color_ids) ? 'selected' : ''; ?>><?=$cs_row1['color_name']?> - <?=$cs_row1['color_code']?></option>
						<?
					}
					?> </select> 
                 </td><td class="error">Press Ctrl key to select multiple colors</td></tr></table>
</div>				  </td>
                </tr>
				<tr bgcolor="#eeeeee"> 
                  <td align="right" class="text">Our sale price : </td>
                  <td align="left"><input type="text" name="catalogue_price" class="inputbox" value="<? echo @$p_row['catalogue_price'];?>"></td>
                </tr>
				<tr bgcolor="#eeeeee"> 
                  <td align="right" class="text">Retail	 price  : </td>
                  <td align="left"><input type="text" name="less_discount" class="inputbox" value="<? echo @$p_row['less_discount'];?>"></td>
                </tr>
				
				<!--<tr bgcolor="#eeeeee"> 
                  <td class="text" align="right">Shipping Cost : </td>
                  <td align="left"><input type="text" name="shipping_cost" class="inputbox" value="<? echo @$p_row['shipping_cost'];?>"></td>
                </tr>-->
				<tr bgcolor="#eeeeee">
					<td class="text" align="right">Description : </td>
						<td align="left">
							<textarea name="prod_desc" rows="5" cols="40"><? echo @$p_row['prod_desc'];?></textarea>						</td>
				</tr>
                <tr bgcolor="#eeeeee">
						<td  colspan="2" class="error" align="center">
                        NOTE :Please Upload Image with name &lt;style number&gt;_&lt;color code&gt;.jpg <br />
                        <?php if($p_row['primary_img_id']!=''){?>
                        For Ex : <?=$p_row['prod_no']?>_<?=$p_row['primary_img_id']?>.jpg
                        <?php }else{ ?>
                        For Ex : <?=$p_row['prod_no']?>_<?=$r_res1['primary_img_id']?>.jpg
                        <?php } ?>
										</td>
				</tr>
                <input type="hidden" name="prod_id" value="<? echo $p_row['prod_id'];?>">
                <tr bgcolor="#eeeeee"> 
                  <td colspan=2 align=center> <input type="submit" name="cmd_cat_submit" class=button value="Update"> 
                    <input type="button" name="cmd_cat_cancel"  class=button value="Cancel" onClick="back_display();">                  </td>
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

          <form name="prod_del_frm" method="post" action="edit_new_par_bridalproduct.php?act=del&cat_id=<?=$_GET['cat_id']?>" enctype="MULTIPART/FORM-data">
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
                  <td align="right">Product name : </td>
                  <td align="left"><? echo $p_row['prod_name'];?></td>
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