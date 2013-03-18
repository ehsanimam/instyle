<?
include("../common.php");
if($_GET['option']=='typecat'){
$mess2="";


$cs2 = mysql_query("select * from tblsubcat where cat_id='".$_GET['catid']."' and view_status='Y'") or die(mysql_error());


if(mysql_num_rows($cs2) > 0) {
					 
				   
                    $mess2='<div id="subcatdiv"><select name="type_name" style="font-size:11px;">'; 
						$mess2.='<option value=""> - select subcat - </option>';
					 
				  	while($cs_row2 = mysql_fetch_array($cs2)) {
						
						$mess2.='<option value="'.$cs_row2[subcat_id].'">'.$cs_row2[subcat_name].'</option>';
						
					  }
					
                    $mess2.='</select>';
                     
				  }else {
				  	$mess2.='<option> no available subcat </option>';
				  }
				  
$mess2.='</div>';

echo $mess2;
}
if($_GET['option']=='typesubcat'){
$mess2="";


$cs2 = mysql_query("select * from tblsubsubcat where subcat_id='".$_GET['subcatid']."' and view_status='Y'") or die(mysql_error());


if(mysql_num_rows($cs2) > 0) {
					 
				   
                    $mess2='<div id="subcatdiv"><select name="type_name" style="font-size:11px;">'; 
						$mess2.='<option value=""> - select sub subcat - </option>';
					 
				  	while($cs_row2 = mysql_fetch_array($cs2)) {
						
						$mess2.='<option value="'.$cs_row2[id].'">'.$cs_row2[name].'</option>';
						
					  }
					
                    $mess2.='</select>';
                     
				  }else {
				  	$mess2.='<option> no available sub subcat </option>';
				  }
				  
$mess2.='</div>';

echo $mess2;
}
?>