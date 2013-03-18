<?
include("../common.php");
$mess2="";


$cs2 = mysql_query("select * from tblsubcat where cat_id='".$_GET['catid']."' and view_status='Y'") or die(mysql_error());


if(mysql_num_rows($cs2) > 0) {
					 
				   
                    $mess2='<div id="subcatdiv"><select name="subcat" style="font-size:11px;">'; 
						$mess2.='<option value=""> - select subcat - </option>';
					 
				  	while($cs_row2 = mysql_fetch_array($cs2)) {
						
						$mess2.='<option value="'.$cs_row2['subcat_id'].'">'.$cs_row2['subcat_name'].'</option>';
						
					  }
					
                    $mess2.='</select>';
                     
				  }else {
				  	$mess2.='<option> no available subcat </option>';
				  }
				  
$mess2.='</div>';

echo $mess2;

?>