<?
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php");

$xcat = $_POST['cat'];
$xsubcat = $_POST['subcat'];
//echo "these:".$xcat.":".$xsubcat; 


if(@$act=="show")
{   
  //  if(@$search)
	//$sql="select * from tbl_product where prod_name like '%$prod_id%'";
	//else
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

$get_img1 = mysql_fetch_array(mysql_query("select * from tbl_product where prod_id='".$prod_id."'"));

							
							$getpic = mysql_query("SELECT * 
												FROM 
												 tblcolor
												WHERE
												  color_id='".$_REQUEST['cs_id']."'") or die(mysql_error());
							$irow=mysql_fetch_array($getpic);	
							
if ($_FILES["front_".$get_img1['prod_no']] !="" && !empty($_REQUEST['cs_id']))
		{
		
		$file_product1=$_POST['folder']."product_front/".$get_img1["prod_no"]."_".$irow["color_code"].".jpg" ;
		 //unlink($file_product1);
		
		
		    $img_front1=$_FILES["front_".$get_img1['prod_no']]['name'];
			$uploadFilesTo1 = $_POST['folder'].'product_front';
			$fileatt1 =$_FILES["front_".$get_img1['prod_no']]['tmp_name'];
			$fileatt_type1 =$_FILES["front_".$get_img1['prod_no']]['type'];
			
			$img1=explode(".",$img_front1);
			
			$fileatt_name1=$get_img1['prod_no']."_".$irow['color_code'].".".$img1[1];
			
			$fp1 = @fopen($fileatt1, 'rb');
			$data1 = @fread($fp1, filesize($fileatt1));
			@fclose($fp1);
			$data1 = @chunk_split(base64_encode($data1));
			@move_uploaded_file($fileatt1, $uploadFilesTo1.'/'.$fileatt_name1);
			
		}
		
if ($_FILES["back_".$get_img1['prod_no']] !="" && !empty($_REQUEST['cs_id']))
		{
		
		
		 $file_product2=$_POST['folder']."product_back/".$get_img1["prod_no"]."_".$irow["color_code"].".jpg" ;
		 //unlink($file_product2);
		
		
		
		    $img_front2=$_FILES["back_".$get_img1['prod_no']]['name'];
			$uploadFilesTo2 = $_POST['folder'].'product_back';
			$fileatt2 =$_FILES["back_".$get_img1['prod_no']]['tmp_name'];
			$fileatt_type2 =$_FILES["back_".$get_img1['prod_no']]['type'];
			
			$img2=explode(".",$img_front2);
			
			$fileatt_name2=$get_img1['prod_no']."_".$irow['color_code'].".".$img2[1];
			$fp2 = @fopen($fileatt2, 'rb');
			$data2 = @fread($fp2, filesize($fileatt2));
			@fclose($fp2);
			$data2 = @chunk_split(base64_encode($data2));
			@move_uploaded_file($fileatt2, $uploadFilesTo2.'/'.$fileatt_name2);
			
		}
		
if ($_FILES["side_".$get_img1['prod_no']] !="" && !empty($_REQUEST['cs_id']))
		{
		
		 
		 $file_product2=$_POST['folder']."product_side/".$get_img1["prod_no"]."_".$irow["color_code"].".jpg" ;
		 //unlink($file_product3);
		    $img_front3=$_FILES["side_".$get_img1['prod_no']]['name'];
			$uploadFilesTo3 = $_POST['folder'].'product_side';
			$fileatt3 =$_FILES["side_".$get_img1['prod_no']]['tmp_name'];
			$fileatt_type3 =$_FILES["side_".$get_img1['prod_no']]['type'];
			
			$img3=explode(".",$img_front3);
			
			$fileatt_name3=$get_img1['prod_no']."_".$irow['color_code'].".".$img3[1];
			$fp3 = fopen($fileatt3, 'rb');
			$data3 = fread($fp3, filesize($fileatt3));
			fclose($fp3);
			$data3 = chunk_split(base64_encode($data3));
			move_uploaded_file($fileatt3, $uploadFilesTo3.'/'.$fileatt_name3);
			
		}
	

if ($_FILES["icon_".$get_img1['prod_no']] !="" && !empty($_REQUEST['cs_id']))
		{
		
		 $file_product4=$_POST['folder']."product_coloricon/".$get_img1["prod_no"]."_".$irow["color_code"].".jpg" ;
		 //unlink($file_product4);

		
		    $img_front4=$_FILES["icon_".$get_img1['prod_no']]['name'];
			$uploadFilesTo4 = $_POST['folder'].'product_coloricon';
			$fileatt4 =$_FILES["icon_".$get_img1['prod_no']]['tmp_name'];
			$fileatt_type4 =$_FILES["icon_".$get_img1['prod_no']]['type'];
			
			$img4=explode(".",$img_front4);
			
			$fileatt_name4=$get_img1['prod_no']."_".$irow['color_code'].".".$img4[1];
			$fp4 = fopen($fileatt4, 'rb');
			$data4 = fread($fp4, filesize($fileatt4));
			fclose($fp4);
			$data4 = chunk_split(base64_encode($data4));
			move_uploaded_file($fileatt4, $uploadFilesTo4.'/'.$fileatt_name4);
			
		}
		
		
if ($_FILES["video_".$get_img1['prod_no']] !="" && !empty($_REQUEST['cs_id']))
		{
		
		 $file_product5=$_POST['folder']."product_video/".$get_img1["prod_no"]."_".$irow["color_code"].".flv" ;
		 //unlink($file_product5);

		
		    $img_front5=$_FILES["video_".$get_img1['prod_no']]['name'];
			$uploadFilesTo5 = $_POST['folder'].'product_video';
			$fileatt5 =$_FILES["video_".$get_img1['prod_no']]['tmp_name'];
			$fileatt_type5 =$_FILES["video_".$get_img1['prod_no']]['type'];
			
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

	if(!empty($_POST['cs_id'])){		
	
	$import="INSERT into tbl_stock (cs_id,
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
									size_fs) 
							values(
									'".$_REQUEST['cs_id']."',
									'".$_REQUEST['prod_id']."',
									'".$_REQUEST['size_0']."',
									'".$_REQUEST['size_2']."',
									'".$_REQUEST['size_4']."',
									'".$_REQUEST['size_6']."',
									'".$_REQUEST['size_8']."',
									'".$_REQUEST['size_10']."',
									'".$_REQUEST['size_12']."',
									'".$_REQUEST['size_14']."',
									'".$_REQUEST['size_16']."',
									'".$_REQUEST['size_fs']."'									
								   )";
		$res_imp=mysql_query($import) or die(mysql_error());	
		}

	if (empty($_REQUEST['cat']) || empty($_REQUEST['subcat']) || empty($_REQUEST['designer']))
		  {
		    $global_message = 'Error:Category , sub-category or designer has no entry';
			echo $global_message.'<BR> Hit BACK on browser';
		  }
		  else
		  {
    $prod_return=admin_edit_new_product($prod_id, $prod_name,$prod_no, $_REQUEST['cat'], $_REQUEST['subcat'], $subsubcat,$add_date,$catalogue_price, $less_discount,$prod_desc, $_REQUEST['designer'], $primary[0], $_REQUEST['primary_img_id'],$color,$colorname);
	$global_message = 'Product has been updated';
    echo "<script>
                location.href='edit_new_par_product.php?act=show&prod_id=$prod_id&mode=e&prod_return=1&err=".$global_message."'
          </script>";
		  }
}

if($act=="del_stock") {
	$getp = mysql_query("SELECT
							tp.prod_no, tp.prod_id,
							d.folder as designer_folder, subcat.folder AS subcat_folder, tcs.color_name,tcs.color_code,tp.prod_no,
							case cat.cat_id
							  when '1'
								then 'WMANSAPREL'
							  when '19'
								then 'JWLRYACCSRIES'
							  when '22'
								then 'BRIDAL'
							  when '23'
								then 'WMANSAPREL'
							  else 'WMANSAPREL'
							end as cat_folder
							FROM
							  tbl_product tp
							  LEFT JOIN designer d ON d.des_id=tp.designer
							  LEFT JOIN tblcat cat ON cat.cat_id = tp.cat_id
							  LEFT JOIN tblsubcat subcat ON subcat.subcat_id = tp.subcat_id
							  LEFT JOIN tbl_stock ts ON ts.prod_id = tp.prod_id
							  LEFT JOIN tblcolor tcs ON tcs.color_id = ts.cs_id
							WHERE
							  tp.prod_id ='".$_GET['prod_id']."'
							AND ts.st_id ='".$_GET['st_id']."'") or die(mysql_error());
	if(@mysql_num_rows($getp)) {
         $prow = @mysql_fetch_array($getp);
		 
		 	$x1 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_front/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			$x2 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_side/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			$x3 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_back/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			$x4 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_coloricon/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			$x5 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_video/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			
		 @unlink($x1);
		 @unlink($x2);
		 @unlink($x3);
		 @unlink($x4);
		 @unlink($x5);
		 
		 @mysql_query("DELETE FROM tbl_stock WHERE st_id='".$_GET['st_id']."'") or die(mysql_error());
		 
		 echo "<script>
                location.href='edit_new_par_product.php?act=show&prod_id=".$_GET['prod_id']."&mode=e&prod_return=1&err=stock has been deleted'
          </script>";
	}					  
							  
}


if($act=="del")
{

$get_img1 = mysql_fetch_array(mysql_query("select * from tbl_product where prod_id='".$_REQUEST['prod_id']."'"));

	$cat_id = $_REQUEST['cat_id'];
	$subcat_id = $_REQUEST['subcat_id'];
	$prod_id = $_REQUEST['prod_id'];
	
	$getp = mysql_query("SELECT
							tp.prod_no, tp.prod_id,
							d.folder as designer_folder, subcat.folder AS subcat_folder, tcs.color_name,tcs.color_code,tp.prod_no,
							case cat.cat_id
							  when '1'
								then 'WMANSAPREL'
							  when '19'
								then 'JWLRYACCSRIES'
							  when '22'
								then 'BRIDAL'
							  when '23'
								then 'WMANSAPREL'
							  else 'WMANSAPREL'
							end as cat_folder
							FROM
							  tbl_product tp
							  LEFT JOIN designer d ON d.des_id=tp.designer
							  LEFT JOIN tblcat cat ON cat.cat_id = tp.cat_id
							  LEFT JOIN tblsubcat subcat ON subcat.subcat_id = tp.subcat_id
							  LEFT JOIN tbl_stock ts ON ts.prod_id = tp.prod_id
							  LEFT JOIN tblcolor tcs ON tcs.color_id = ts.cs_id
							WHERE
							  tp.prod_id ='".$prod_id."'
							") or die(mysql_error());
	
	if(@mysql_num_rows($getp)>0) {
		while($prow = @mysql_fetch_array($getp)) {
			
			$x1 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_front/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			$x2 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_side/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			$x3 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_back/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			$x4 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_coloricon/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
			$x5 = '../product_assets/'.$prow['cat_folder'].'/'.$prow['designer_folder'].'/'.$prow['subcat_folder'].'/product_video/'.$prow['prod_no'].'_'.$prow['color_code'].'.jpg';
				
			 @unlink($x1);
			 @unlink($x2);
			 @unlink($x3);
			 @unlink($x4);
			 @unlink($x5);
		}
	}
	
	@mysql_query("delete from tbl_product where prod_id='".$prod_id."'") or die(mysql_error());
   
    ?>
	<script type="text/javascript">
			<!--
			window.location = "edit_new_product.php?cat_id=<?=$cat_id?>&subcat_id=<?=$subcat_id?>"
			//-->
	</script>
	<?php 
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
    document.prod_frm.action="edit_new_par_product.php?act=show&mode=e";
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
    
<script type="text/javascript">
function showsubcat(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getsubcat.php?q="+str,true);
xmlhttp.send();
}
</script>    
    
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td class="tab" align="center" valign="middle">
	<? if(@$mode=="e"){?>

          <form name="prod_frm" method="post" action="edit_new_par_product.php?act=modi" enctype="multipart/form-data">
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
                  <td align="right" class="text">Category Name : </td>
                  <td align="left"> 
                    <select name="cat" onchange="showsubcat(this.value)">
                    <?php
					
					$_SESSION['subcat']=$p_row['subcat_id'];;
					$sq = "select * from tblcat";
					$get_category = @mysql_query($sq);
					if(mysql_num_rows($get_category) > 0) {
						while($row = mysql_fetch_array($get_category)) {
							?> 
							<option value="<?=$row['cat_id']?>" <?php echo $row['cat_id']==$p_row['cat_id'] ? 'selected' : ''; ?>><?=$row['cat_name']?></option>
							<?
						}
					}
					?>
				   </select>	<?php  echo $p_row['cat_id'];   ?> 
                  </td>
                </tr>
                <tr  bgcolor="#eeeeee"> 
                  <td align="right" class="text">SubCategory name : </td>
                  <td align="left"> <div id="txtHint">
                    <select name="subcat">
                    <?php
					$sq = "select * from tblsubcat where cat_id='".$p_row['cat_id']."'";
					$get_subcategory = @mysql_query($sq);
					if(mysql_num_rows($get_subcategory) > 0) {
						while($rowx1 = mysql_fetch_array($get_subcategory)) {
							?> 
							<option value="<?=$rowx1['subcat_id']?>" <?php echo $rowx1['subcat_id']==$p_row['subcat_id'] ? 'selected' : ''; ?>><?=$rowx1['subcat_name']?></option>
							<?
						}
					}
					?>
				   </select> </div>	<?php  echo $p_row['subcat_id'];   ?>           </td>
                </tr>
                <tr  bgcolor="#eeeeee"> 
                  <td align="right" class="text"> Sub SubCategory name : </td>
                  <td align="left"> 
                    <? get_subsubcategories($subcat1);?>
                    <script>document.prod_frm.subsubcat.value="<?=$subsubcat1;?>"</script>                  </td>
                </tr>
				<!--
				<tr  bgcolor="#eeeeee"> 
                  <td align="right" class="text">Type Category name : </td>
                  <td align="left"> 
                    <? get_typecategories_edit();?>
                    <script>document.prod_frm.type.value="<?=$type;?>"</script> 
                  </td>
                </tr>
				-->
				<tr  bgcolor="#eeeeee"> 
                  <td class="text" align="right">Designer : </td>
                  <td align="left"> 
				  <select name="designer">
				  	<option value=""></option>
                    <?php
					$get_designer = @mysql_query("select * from designer where des_id='".$p_row['designer']."'");
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
							$getpic = mysql_query("SELECT
													tp.prod_no, tp.prod_id,
													d.folder as designer_folder, subcat.folder AS subcat_folder, tcs.color_name,tcs.color_code,tp.prod_no,
														ts.size_0, ts.size_2, ts.size_4, ts.size_6, ts.size_8, ts.size_10, ts.size_12, ts.size_14, ts.size_16,ts.size_fs, ts.st_id,
														case cat.cat_id
														  when '1'
															then 'WMANSAPREL'
														  when '19'
															then 'JWLRYACCSRIES'
														  when '22'
															then 'BRIDAL'
														  when '23'
															then 'WMANSAPREL'
														  else 'CLRNCE'
														end as cat_folder
														FROM
														  tbl_product tp
														  LEFT JOIN designer d ON d.des_id=tp.designer
														  LEFT JOIN tblcat cat ON cat.cat_id = tp.cat_id
														  LEFT JOIN tblsubcat subcat ON subcat.subcat_id = tp.subcat_id
														  LEFT JOIN tbl_stock ts ON ts.prod_id = tp.prod_id
														  LEFT JOIN tblcolor tcs ON tcs.color_id = ts.cs_id
														WHERE
														  tp.prod_id ='".$_REQUEST['prod_id']."'") or die(mysql_error());							
							
							$base_site_url	 = 'http://instylenewyork.com/';						
							
							 ?>
                       <tr><td class="text">
                           <table border="0" cellspacing="0" cellpadding="3" width="400">                           
                           <?php
                           if(@mysql_num_rows($getpic)) {
                             while($irow = @mysql_fetch_array($getpic)) {
                                $img_url		 = $base_site_url.'product_assets/'.$irow['cat_folder'].'/'.$irow['designer_folder'].'/'.$irow['subcat_folder'].'/';
                                $upload_folder	 = 'product_assets/'.$irow['cat_folder'].'/'.$irow['designer_folder'].'/'.$irow['subcat_folder'].'/';
								
                                $img_thumb 	     = $img_url.'product_front/'.$irow['prod_no'].'_'.$irow['color_code'].'.jpg';
                                $img_thumb_back  = $img_url.'product_back/'.$irow['prod_no'].'_'.$irow['color_code'].'.jpg';
                                $img_thumb_side  = $img_url.'product_side/'.$irow['prod_no'].'_'.$irow['color_code'].'.jpg';
                                $video			 = $img_url.'product_video/'.$irow['prod_no'].'_'.$irow['color_code'].'.flv';
								
								$imgchecked = $irow['color_code'] == $p_row['primary_img_id'] ? 'checked' : '';
								//echo '>>'.$img_thumb; 
                                ?>
                                <tr style="background:#ddd;">
                                <td colspan="4">
                                	<table border="0" cellspacing="0" cellpadding="0"><tr><td width="200">
                                    <strong><?=strtoupper($irow['color_name'])?></strong> [<a href="edit_new_par_product.php?act=del_stock&prod_id=<?=$prod_id?>&st_id=<?=$irow['st_id']?>" onclick="return confirm('Are you sure you want to delete this color and its stock?')">delete</a>]&nbsp;[<a href="edit_stock.php?<?=$_SERVER['QUERY_STRING']?>&st_id=<?=$irow['st_id']?>">edit&nbsp;stock</a>]</td>
                                    <td>
                                 	&nbsp; <input type="radio" name="primary_img_id" value="<?=$irow['color_code']?>" <?=$imgchecked?> /> Primary Image
                                    </td></tr></table>
                                 </td>
                                </tr>
                                <tr style="background:#ddd;">
                                <td width="70">                                
                                <?php
								if($img = @GetImageSize($img_thumb)) {
									?> Front<br /> <img src="<?=$base_site_url?>res.php?w=60&constrain2=1&img=<?php echo $img_thumb;?>" width=63> <?php
								}
								?>
                                </td>
                                <td width="70">                                
                                <?php
								if($img = @GetImageSize($img_thumb_back)) {
									?> Back<br /><img src="<?=$base_site_url?>res.php?w=60&constrain2=1&img=<?php echo $img_thumb_back;?>" width=63> <?php
								}
								?>
                                </td>
                                <td width="70">                                
                                <?php
								if($img = @GetImageSize($img_thumb_side)) {
									?> Side<br /><img src="<?=$base_site_url?>res.php?w=60&constrain2=1&img=<?php echo $img_thumb_side;?>" width=63> <?php
								}
								?>
                                </td>
                                <td width="70">                                
                                <?php
								if($img = @GetImageSize($video)) {
									?> Video<br /><img src="<?=$base_site_url?>res.php?w=60&constrain2=1&img=<?=$base_site_url?>'images/instylelnylogo.jpg'" width=63> <?php
								}
								?>
                                </td>
                                </tr>
                                <tr style="background:#ddd;"><td colspan="4" style="font-size:10px;">
                                <table width="100%" border="1" cellspacing="0" cellpadding="2" style="border-collapse:collapse;border:1px solid #999;">
                                  <tr style="background:#ddd;">
                                    <td>Size 0</td>
                                    <td>Size 2</td>
                                    <td>Size 4</td>
                                    <td>Size 6</td>
                                    <td>Size 8</td>
                                    <td>Size 10</td>
                                    <td>Size 12 </td>
                                    <td>Size 14</td>
                                    <td>Size 16</td>
                                    <td>Size FS</td>
                                  </tr>
                                  <tr>
                                    <td style="font-weight:bold;"><?=$irow['size_0']?></td>
                                    <td style="font-weight:bold;"><?=$irow['size_2']?></td>
                                    <td style="font-weight:bold;"><?=$irow['size_4']?></td>
                                    <td style="font-weight:bold;"><?=$irow['size_6']?></td>
                                    <td style="font-weight:bold;"><?=$irow['size_8']?></td>
                                    <td style="font-weight:bold;"><?=$irow['size_10']?></td>
                                    <td style="font-weight:bold;"><?=$irow['size_12']?></td>
                                    <td style="font-weight:bold;"><?=$irow['size_14']?></td>
                                    <td style="font-weight:bold;"><?=$irow['size_16']?></td>
									<td style="font-weight:bold;"><?=$irow['size_fs']?></td>                                    
                                  </tr>
                                </table>
                                </td></tr>
                                <tr><td colspan="4">&nbsp;</td>
                                <?php
                             }
                           }
                           ?>       
                           
                           </table>                
                       </td></tr>
                       <tr><td class="text">
                       <b>Browse Product Images</b> [ Leave this if no need to add more product images/colors ]<br />
                       <table border="0" cellspacing="0" style="background:#ccc;border:1px solid #999999;">
                            <tr><td class="text" align="right">Select color : </td>
                            <td>
                            <?php
							$get_color = @mysql_query("select * from `tblcolor` order by color_name");
							if(@mysql_num_rows($get_color)>0) {
								?> <select name="cs_id" style="font-size:11px;"> <option value=""> - select color - </option> <?php
								while($crow = @mysql_fetch_array($get_color)) {
									?>
                                    <option value="<?=$crow['color_id']?>" ><?=$crow['color_name']?> - <?=$crow['color_code']?></option>
                                    <?
								}
								?> </select> <?php
							}
							?>
                            <input type="hidden" name="folder" value="../<?=$upload_folder?>" />                            
                            </td></tr>
                            <tr> 
                              <td width="100" align="right" class="text">Front Image : </td>
                              <td align="left" class="error"><input type="file" name="front_<?=$p_row['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                            </tr>
                            <tr> 
                              <td align="right" class="text">Back Image : </td>
                              <td align="left" class="error"><input type="file" name="back_<?=$p_row['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                            </tr>
                             <tr> 
                              <td align="right" class="text">Side Image : </td>
                              <td align="left" class="error"><input type="file" name="side_<?=$p_row['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 1600 px x 2400 px</td>
                            </tr>
                            <tr> 
                              <td align="right" class="text">Color Icon Image : </td>
                              <td align="left" class="error"><input type="file" name="icon_<?=$p_row['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;image must be 40 px x 40 px</td>
                            </tr>
                             <tr> 
                              <td align="right" class="text">Runway Video : </td>
                              <td align="left" class="error"><input type="file" name="video_<?=$p_row['prod_no']?>" class="inputbox">&nbsp;&nbsp;&nbsp;&nbsp;video must be minimum 327 px x 589 px</td>
                            </tr>
                            <tr>
                            <td class="text" align="right">Stock : </td>
                            <td>
                            <table width="100%" border="1" cellspacing="0" cellpadding="2" style="border-collapse:collapse;border:1px solid #999;">
                                  <tr>
                                    <td>Size 0</td>
                                    <td>Size 2</td>
                                    <td>Size 4</td>
                                    <td>Size 6</td>
                                    <td>Size 8</td>
                                    <td>Size 10</td>
                                    <td>Size 12 </td>
                                    <td>Size 14</td>
                                    <td>Size 16</td>
                                    <td>Size FS</td>
                                  </tr>
                                  
                                 
                                  
                                  
                                  
                                  <tr>
                                    <td><input type="text" name="size_0" style="width:20px;" maxlength="2" /></td>
                                    <td><input type="text" name="size_2" style="width:20px;" maxlength="2" /></td>
                                    <td><input type="text" name="size_4" style="width:20px;" maxlength="2" /></td>
                                    <td><input type="text" name="size_6" style="width:20px;" maxlength="2" /></td>
                                    <td><input type="text" name="size_8" style="width:20px;" maxlength="2" /></td>
                                    <td><input type="text" name="size_10" style="width:20px;" maxlength="2" /></td>
                                    <td><input type="text" name="size_12" style="width:20px;" maxlength="2" /></td>
                                    <td><input type="text" name="size_14" style="width:20px;" maxlength="2" /></td>
                                    <td><input type="text" name="size_16" style="width:20px;" maxlength="2" /></td>
                                    <td><input type="text" name="size_fs" style="width:20px;" maxlength="2" /></td>
                                    
                                  </tr>
								 <tr>
                                    <td>Size 0</td>
                                    <td>Size ¼</td>
                                    <td>Size ½</td>
                                    <td>Size ¾</td>
                                    <td>Size 1</td>
                                    <td>Size 1¼</td>
                                    <td>Size 1½ </td>
                                    <td>Size 1¾</td>
                                    <td>Size 2</td>
                                    <td>Size 2¼</td>
                                    <td>Size 2½ </td>
                                    <td>Size 2¾</td>
                                  </tr>                                  
                                  
                                  
                                  
                                </table>

                            </td></tr>
                       </table>
                       </td></tr>
				</table>			 
                
                </td>
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
                        For Ex : <?=$p_row['prod_no']?>_&lt;color_code&gt;.jpg
                        <?php }else{ ?>
                        For Ex : <?=$p_row['prod_no']?>_&lt;color_code&gt;.jpg
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

          <form name="prod_del_frm" method="post" action="edit_new_par_product.php?act=del&cat_id=<?=$_GET['cat_id']?>&subcat_id=<?=$_GET['subcat_id']?>" enctype="MULTIPART/FORM-data">
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