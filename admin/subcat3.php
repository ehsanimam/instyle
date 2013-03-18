<?
include("../common.php");
$mess2="";


$cs2 = mysql_query("select * from designer where catid='".$_GET['catid']."' and view_status='Y'") or die(mysql_error());


if(mysql_num_rows($cs2) > 0) {
					 
				   
                    $mess2='<div id="desdiv"><select name="des" style="font-size:11px;">'; 
						$mess2.='<option value=""> - select designer - </option>';
					 
				  	while($cs_row2 = mysql_fetch_array($cs2)) {
						
						$mess2.='<option value="'.$cs_row2['des_id'].'">'.$cs_row2['designer'].'</option>';
						
					  }
					
                    $mess2.='</select>';
                     
				  }else {
				  	$mess2.='<option> no available subcat </option>';
				  }
				  
$mess2.='</div>';

echo $mess2;

?>