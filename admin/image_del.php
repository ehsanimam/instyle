<?
session_start();
include("../common.php");
include('../functionsadmin.php');
	
	//$ret = unlink_prod_images($_GET["img_id"], $_GET["cnt"]);
	
	if($_GET["img_folder"]=='product_video'){
     
	$file_mini_thumb="../images/".$_GET["img_folder"]."/".$_GET["prod_no"]."_".$_GET["color_code"].".flv" ;
	  }else{
	$file_mini_thumb="../images/".$_GET["img_folder"]."/".$_GET["prod_no"]."_".$_GET["color_code"].".jpg" ;
	  }
	  if(@file_exists($file_mini_thumb)) {
	   unlink($file_mini_thumb);
	   }
	  
	   
	   $getid="select prod_id from tbl_product where prod_no='".$_GET["prod_no"]."'";
	   $res_get=mysql_query($getid);
	   $rec_get=mysql_fetch_array($res_get);
	   
	   header("location:edit_new_par_product.php?act=show&prod_id=".$rec_get["prod_id"]."&mode=e&msg=1");


	/*if($ret > 0){	
		alert("Delete image Successful","edit_new_par_product.php?act=show&prod_id=".$_GET["prod_id"]."&mode=e","");		
	}
	else
	{
		alert("Cannot delete image","edit_new_par_product.php?act=show&prod_id=".$_GET["prod_id"]."&mode=e","");		
	}*/
?>
