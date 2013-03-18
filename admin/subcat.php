<?
include("../common.php");
$des_id  = $_GET['des_id'];
$mess2="";

$cs1 = mysql_query("select * from designer where des_id='".$_GET['des_id']."'") or die(mysql_error());
$cs_row1 = mysql_fetch_array($cs1);


$cs2 = mysql_query("select * from tblsubcat where cat_id='".$cs_row1['catid']."' and view_status='Y'") or die(mysql_error());


if(mysql_num_rows($cs2) > 0) {
					 
				   
                    $mess2='<div id="subcatdiv"><select name="subcat" style="font-size:11px;" onChange=getprod("product.php?subcat_id="+this.value+"&des_id="+'.$_GET['des_id'].');getCs2("allitems.php?subcat_id="+this.value+"&option=subcat");>'; 
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

?>