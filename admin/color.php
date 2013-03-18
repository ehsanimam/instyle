<?
include("../common.php");
$from  = $_GET['from'];
$cs = mysql_query("select * from designer_color where des_id='".$_GET['des_id']."'") or die(mysql_error());
$cs_row = mysql_fetch_array($cs);

$color_id=explode(",",$cs_row['color_id']);

				  
				  if(mysql_num_rows($cs) > 0) {
				  
				  
					  if($from == "stock")
					  {
				  	?> <select name="cs" style="font-size:11px;" onChange="getprod('product.php')"> 
						<option> - select color - </option>
					 <?php
				  	foreach($color_id as $colid) {
					
					$cs1 = mysql_query("select * from tblcolor where color_id='".$colid."'") or die(mysql_error());
                    $cs_row1 = mysql_fetch_array($cs1);
 
						?>
						<option value="<?=$cs_row1['color_id']?>" <?php echo $cs_row1['color_id']==$get_img['colors'] ? 'selected' : ''; ?>><?=$cs_row1['color_name']?> - <?=$cs_row1['color_code']?></option>
						<?
					  }
					
					?> </select> <?php
					  }
					else
					  {
								?>  <table><tr><td><select name="cs[]" style="font-size:11px;" multiple="multiple">
						<option> - select color - </option>
					 <?php
				  	foreach($color_id as $colid) {
					
					$cs1 = mysql_query("select * from tblcolor where color_id='".$colid."'") or die(mysql_error());
                    $cs_row1 = mysql_fetch_array($cs1);
 
						?>
						<option value="<?=$cs_row1['color_id']?>" <?php echo $cs_row1['color_id']==$get_img['colors'] ? 'selected' : ''; ?>><?=$cs_row1['color_name']?> - <?=$cs_row1['color_code']?></option>
						<?
					  }
					
					?> </select> </td><td class="error">Press Ctrl key to select multiple colors</td></tr></table> <?php
					  }
				  } else {
				  	echo '<option> no available color </option>';
				  }
				  ?>
