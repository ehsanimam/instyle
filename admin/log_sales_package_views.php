<h2><?php echo MAIN_BODY_TITLE.' &nbsp; &nbsp; '; ?></h1>

<div id="content_wrapper">

	<div id="content2" class="content">
	
		<!--bof form============================================================================-->
		<form name="prod_list_disp_frm" method="post" action="list_products.php?sel=<?php echo $sel; ?><?php echo isset($_GET['p']) ? '&p='.$_GET['p'] : ''; ?>">

			<input type="hidden" name="des_id" value="<?php echo $des_id; ?>" />
			<input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>" />
			<input type="hidden" name="subcat_id" value="<?php echo $subcat_id; ?>" />
			
			<br /><br />
			
			<div class="common" style="float:left;"><?php echo $log_count; ?> logs total</div>
			<div class="common" style="float:right;">Number of entries per page: <?php echo $log_count < $limit ? 'All' : $log_count; ?></a></div>
			<div class="common" style="text-align:center;">
				<?php echo $page != 1 ? $pagination : ''; ?>
			</div>
			<div style="clear:both;"></div>
			
			<table width="100%" border="0" cellspacing="2" cellpadding="0" style="margin: 10px 0;">
				<col width="50" />
				<col width="200" />
				<col width="200" />
				<col />
				<col width="100" />
				<tr bgcolor="#CCCCCC" height="30">
					<?php
					// -----------------------------------------
					// ---> Headings
					?>
					<td align="center"></td>
					<td align="center"><h1>Sent To</h1></td>
					<td align="center"><h1>From</h1></td>
					<td align="center"><h1>Items</h1></td>
					<td align="center"><h1>Date Sent</h1></td>
				</tr>
				
				<?php
				$counter = 0;
				while ($log_row = mysql_fetch_array($qry1))
				{
					$counter++; ?>
				<tr bgcolor="#eeeeee" onMouseOver="this.bgColor='#cccccc'" onMouseOut="this.bgColor='#eeeeee'" class="text">
				
					<!--1 Item Counter-->
					<td align="left" class="reg_cell"><?php echo $counter; ?></td>
				
					<!--2 Sent To-->
					<td align="left" class="reg_cell">
						<?php echo ucwords($log_row['name']).' &laquo'.$log_row['sent_to'].'&raquo'; ?>
					</td>
				
					<!--3 From-->
					<td align="left" class="reg_cell">
						<?php echo ucfirst($log_row['admin_sales_user']).' '.ucfirst($log_row['admin_sales_lname']).' &laquo'.$log_row['from'].'&raquo'; ?>
					</td>
				
					<!--4 Items-->
					<td align="left" class="reg_cell"><?php echo $log_row['items']; ?></td>
				
					<!--5 Date Sent-->
					<td align="center" class="reg_cell"><?php echo $log_row['date_sent']; ?></td>
					
				</tr>
					<?php
				}
				
				// free up mysql memory
				mysql_free_result($qry1);
				?>
				
			</table>
			
			<div class="common" style="float:left;"><?php echo $log_count; ?> logs total</div>
			<div class="common" style="float:right;">Number of entries per page: <?php echo $log_count < $limit ? 'All' : $log_count; ?></a></div>
			<div class="common" style="text-align:center;">
				<?php echo $page != 1 ? $pagination : ''; ?>
			</div>
			<div style="clear:both;"></div>
			
		</form>
		<!--eof form============================================================================-->
		
	</div>
	
</div> <!-- #content_wrapper -->

