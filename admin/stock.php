<?
include("../common.php");

		$csql = "select * from tbl_product where prod_id='".$_REQUEST['prod_id']."'"; 
		$cs3 = mysql_query($csql);
		$cs_row3 = mysql_fetch_array($cs3);

		$color_names=explode(",",$cs_row3['colornames']);		
				if(mysql_num_rows($cs3) > 0) {
			foreach($color_names as $col){
						
							$get_color = mysql_query("SELECT * 
												FROM 
												 tblcolor
												WHERE
												  color_code='".$col."'") or die(mysql_error());
							$csrow=mysql_fetch_array($get_color);	
				?>
                <table>
	            <tr>
                <td width="256" align="right" class=""> <?php 
				
				$stock_qry="select * from tbl_stock where prod_id='".$_REQUEST['prod_id']."' and cs_id='".$csrow['color_id']."'";
				$stock_res=mysql_query($stock_qry);
				$num_stock=mysql_num_rows($stock_res);
				$stock_rec=mysql_fetch_array($stock_res);

				if($stock_rec['st_id']!=''){
					$stock =$stock_rec['st_id'];
				}
				else
				{
					$stock =0;
				}
				?>
                <input type="hidden" name="stock[]" value="<?=$stock;?>" /><br /><select name="color[]" style="font-size:11px;" onChange="getCs('checkcolor.php?color_id='+this.value)">
						<option> - select color - </option>
					 <?php
					$cs1 = mysql_query("select * from tblcolor order by color_name asc") or die(mysql_error());
                    while($cs_row1 = mysql_fetch_array($cs1)){
						?>
						<option value="<?=$cs_row1['color_id']?>" <?php if($csrow['color_id']==$cs_row1['color_id']) { echo 'selected="selected"'; }?>><?=$cs_row1['color_name']?> - <?=$cs_row1['color_code']?></option>
						<?
					}
					?> </select> </td> 
                  <td width="256" align="center" class="text"> 
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
		
			$cs4 = mysql_query("select * from tblsize") or die(mysql_error());
			while($cs_row4 = mysql_fetch_array($cs4)){
				
			
			?>

				<td><input type='text' name='<?=$col?>_size_<?=strtolower($cs_row4["size_name"])?>' size='2' value="<?=$stock_rec['size_'.strtolower($cs_row4["size_name"])]?>"></td>
               
                <?php
				
				
		  }
		  ?>
         </tr></table>
				
				  </td>
                 <!--<td width="256" align="left" class=""><?php if($num_stock!=0){?><span class="text">[</span><a href="add_color_size.php?eid=<?=$stock_rec['st_id'];?>&action=delete" class="pagelinks" onclick="return confirm_delete()">delete</a><span class="text">]</span><?php } ?></td>--> 
                </tr>
                <?php } 
                
                }else { ?>
	<tr> 
                  <td width="256" align="left" class="error" colspan="2">No Available Size</td></tr></table>
    <?php
    } ?>
 	
