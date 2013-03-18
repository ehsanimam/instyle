<?php
	include("../common.php");
	include 'top.php'; 
	
	/*
	| ---------------------------------------------------------------------------
	| This file displays the order log.
	|
	| This file also displays the detail of the order log after choosing
	| a specific transaction.
	*/
	
	// Self serving form for delivery status update
	if (isset($_POST['submit_status']))
	{
		$order_id = $_POST['order_id'];
		
		if (isset($_POST['del_status']) && $_POST['del_status'] != '')
		{
			$q = "UPDATE tbl_order_log SET status = '1' WHERE order_log_id = '".$order_id."'";
			$r = mysql_query($q) or die('Update error: '.mysql_error());
		}
		else
		{
			$q = "UPDATE tbl_order_log SET status = '0' WHERE order_log_id = '".$order_id."'";
			$r = mysql_query($q) or die('Update error: '.mysql_error());
		}
		
		echo '
			<script>
				window.location.href="order_log.php";
			</script>
		';
	}
	
	// Self serving form for update on post delivery remarks
	if (isset($_POST['update_remarks']))
	{
		$order_id = $_POST['order_id'];
		$del_status_2 = isset($_POST['del_status_2']) ? $_POST['del_status_2'] : 0;
		$return_reason = isset($_POST['return_reason']) ? $_POST['return_reason'] : 0;
		$comments = $_POST['comments'];
		
		$u = "
			UPDATE tbl_order_log
			SET
				status = '".$del_status_2."',
				remarks = '".$return_reason."',
				comments = '".$comments."'
			WHERE order_log_id = '".$order_id."'
		";
		$r = mysql_query($u) or die('Update error: '.mysql_error());
		
		echo '
			<script>
				window.location.href="order_log.php?order_id='.$order_id.'";
			</script>
		';
	}
	
	// Self serving form to delete record
	if (isset($_GET['del']))
	{
		$order_id = $_GET['del'];
		
		$q1 = "DELETE FROM tbl_order_log WHERE order_log_id = '".$order_id."'";
		$r1 = mysql_query($q1) or die('Delte error: '.mysql_error());
		
		$q2 = "DELETE FROM tbl_order_log_details WHERE order_log_id = '".$order_id."'";
		$r2 = mysql_query($q2) or die('Delte error: '.mysql_error());
		
		echo '
			<script>
				window.location.href="order_log.php";
			</script>
		';
	}
	
	/*
	| -----------------------------------------------------------------------
	| Oder details view
	*/
	if (isset($_GET['order_id']) && $_GET['order_id'] != '')
	{
		/*
		| -----------------------------------------------------------------------
		| Let's do all database query necessary for displaying specific transactions
		*/
		$trans_q = "
			SELECT 
				tlog.*, tlog.order_log_id AS order_id,
				tdet.*
			FROM 
				tbl_order_log tlog
			LEFT JOIN
				tbl_order_log_details tdet ON tdet.order_log_id = tlog.order_log_id
			WHERE tlog.order_log_id = '".$_GET['order_id']."'
		";
		$trans_r = mysql_query($trans_q) or die('No transaction returned! '.mysql_error());
		$trans_rec = mysql_fetch_array($trans_r);
		
		$order_date = date('Y-m-d',strtotime(str_replace(',','',substr($trans_rec['date_ordered'],0,-8))));
		$user_id = $trans_rec['user_id'];
		
		/*
		| -----------------------------------------------------------------------
		| Display the specific transaction with all the shipping details and the
		| list of order(s).
		*/
		?>
		
		<title>Order Log Detail View::Admin Section</title>
		<link href="style.css" rel="stylesheet" type="text/css" />
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
		<tr><td height="300" class="tab" align="center" valign="middle">

			<table style="outline:1px solid #787878;margin: 10px 0 10px;">
			
				<tr bgcolor=cccccc valign="middle" height="35"><td colspan="6" style="position:relative;">
					<div style="position:relative;width:100%;text-align:center;padding-bottom:5px;">
						<input type="button" value="<< Back" onclick="window.location.href='order_log.php'" style="position:absolute;left:5px;top:-5px;" />
						<h1>Transaction Record</h1>
					</div>
				</td></tr>
				
				<tr>
					<td colspan="6" align="center">
						<h1><strong><?php echo $trans_rec['store_name'] != '' ? 'Store - '.$trans_rec['store_name'] : 'Consumer'; ?></strong></h1>
					</td>
				</tr>
				
				<tr>
					<td colspan="3" width="40%" style="padding-bottom:8px;">
						<h1><strong>ORDER RECORD NO. - <?php echo $_GET['order_id']; ?><br />
						(DATE OF ORDER: <?php echo $order_date; ?>)</strong></h1>
					</td>
					<td colspan="3" style="padding-bottom:8px;">
						<?php $status = $trans_rec['status'] == 1 ? 'Delivered' : 'Not yet delivered' ; ?>
						<span class="text" style="float:right;text-align:right;"><h1>STATUS: </h1> <?php echo $status; ?></span>
					</td>
				</tr>
				
				<tr valign="top">
					<td colspan="3" style="width:250px;">
						<table width="100%" border="0" cellpadding="0" cellspacing="0"  bgcolor="">
							<!--DWLayoutTable-->
							<tr bgcolor="#cccccc" height="35">
								<td height="35"  valign="middle" class="head">&nbsp; Shipping Details</td>
							</tr>
							<tr>
								<td height="7"  valign="top"><img src="images/spacer.gif" alt=" " width="1" height="7"></td>
							</tr>
							<tr>
								<td height="20" align="left" valign="middle" class="text"><b>First name&nbsp;:</b>&nbsp;<?=$trans_rec['firstname']?></td>
							</tr>
							<tr>
								<td height="20" align="left" valign="middle" class="text"><b>Last name&nbsp;:</b>&nbsp;<?=$trans_rec['lastname']?></td>
							</tr>
							<?php if ($trans_rec['store_name'] != '' OR $trans_rec['store_name'] != NULL) { ?>
							<tr>
								<td height="20" align="left" valign="middle" class="text"><b>Store Name : </b>&nbsp;<?=$trans_rec['store_name']?></td>
							</tr>
							<?php } ?>
							<tr>
								<td height="20" align="left" valign="middle" class="text"><b>Address : </b>&nbsp;<?=$trans_rec['ship_address1']?>&nbsp;<?=$trans_rec['ship_address2']?> </td>
							</tr>
							<tr>
								<td height="20" align="left" valign="middle" class="text"><b>City : </b>&nbsp;<?=$trans_rec['ship_city']?></td>
							</tr>
							<tr>
								<td height="20" align="left" valign="middle" class="text"><b>State : </b>&nbsp;<?=$trans_rec['ship_state']?></td>
							</tr>
							<tr>
								<td height="20" align="left" valign="middle" class="text"><b>Country : </b>&nbsp;<?=$trans_rec['ship_country']?></td>
							</tr>
							<tr>
								<td height="20" align="left" valign="middle" class="text"><b>Zip : </b>&nbsp;<?=$trans_rec['ship_zipcode']?></td>
							</tr>
							<tr>
								<td height="20" align="left" valign="middle" class="text"><b>Phone : </b>&nbsp;<?=$trans_rec['telephone']?></td>
							</tr>
							<?php if (isset($trans_rec['cellphone']) && $trans_rec['cellphone'] != '') { ?>
							<tr>
								<td height="20" align="left" valign="middle" class="text"><b>Cell : </b>&nbsp;<?=$trans_rec['cellphone']?></td>
							</tr>
							<?php } ?>
							<tr>
								<td height="20" align="left" valign="middle" class="text"><b>Email : </b>&nbsp;<?=$trans_rec['email']?></td>
							</tr> 
							<tr>
								<td height="7" colspan="2" valign="top"><img src="images/spacer.gif" alt=" " width="1" height="7"></td>
							</tr>
						</table>
					</td>
					<td colspan="3" align="left">
						<?php
						// check delivery status
						if ($trans_rec['status'] == 1)
						{
							$status2 = 'Delivered';
							$checked2 = 'checked="checked"';
						}
						else
						{
							$status2 = 'Check to update delivery status...' ;
							$checked2 = '';
						}
						// check post delivery remarks
						if ($trans_rec['remarks'] != '' && $trans_rec['remarks'] != NULL) $remarks = $trans_rec['remarks'];
						?>
						<table width="100%" border="0" cellpadding="0" cellspacing="0"  bgcolor="">
							<!--DWLayoutTable-->
							<tr bgcolor="#cccccc" height="35">
								<td height="35"  valign="middle" class="head">&nbsp; Remarks <span style="font-weight:normal;">(Post-delivery)</span></td>
							</tr>
							<tr><td class="text" align="center">
								<div style="text-align:left;display:table-cell;padding:10px 0 10px 0;">
									<!--bof form==========================================================================-->
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
									<input type="hidden" name="order_id" value="<?php echo $_GET['order_id']; ?>" />
									<input type="hidden" name="update_remarks" value="1" />
									<input type="checkbox" name="del_status_2" value="1" <?php echo $checked2; ?>/>&nbsp; <?php echo $status2; ?><br />
									<input type="radio" name="return_reason" value="1" <?php echo $remarks == 1 ? 'checked="checked"' : ''; ?> />&nbsp;
										Return for exchange<br />
									<input type="radio" name="return_reason" value="2" <?php echo $remarks == 2 ? 'checked="checked"' : ''; ?> />&nbsp;
										Return for store credit<br />
									<input type="radio" name="return_reason" value="3" <?php echo $remarks == 3 ? 'checked="checked"' : ''; ?> />&nbsp;
										Return for refund<br />
									<input type="radio" name="return_reason" value="4" <?php echo $remarks == 4 ? 'checked="checked"' : ''; ?> />&nbsp;
										Return for other reasons (see comments)<br />
									Commetns:<br />
									<textarea name="comments" rows="3" cols="33"><?php echo $trans_rec['comments'] ? $trans_rec['comments'] : ''; ?></textarea><br />
								</div>
									<input type="submit" name="submit" value="Update Remarks" />
									</form>
									<!--eof form==========================================================================-->
							</td></tr>
						</table>
					</td>
				</tr>
				
				<tr><td colspan="6">
				
					<table width="100%" cellpadding="0" cellspacing="2">
					
						<tr bgcolor=cccccc valign="middle" height="35"><td colspan="8"><h1>&nbsp; Shopping Bag Contents</h1></td></tr>
						
						<tr bgcolor="#cccccc" height="35">
							<td width="170" align="center" valign="middle" class="head">Designer</td>
							<td width="76" align="center" valign="middle" class="head">Thumb</td>
							<td width="170" align="center" valign="middle" class="head">Item Name</td>
							<td width="70" align="center" valign="middle" class="head">Style Number</td>
							<td width="50" align="center" valign="middle" class="head">Size</td>
							<td width="75" align="center" valign="middle" class="head">Color</td>
							<td width="40" align="center" valign="middle" class="head">Qty</td>
							<td width="80" align="center" valign="middle" class="head">Price</td>
						</tr>
					
					<?php
					// Set $net_price
					$net_price = '';
					
					// Get order log - all items
					$trans_r2 = mysql_query($trans_q) or die('No transaction returned! (2) '.mysql_error());

					while ($trans_rec2 = mysql_fetch_array($trans_r2))
					{
						/*
						| -----------------------------------------------------------------------------------
						| Things needed to be able to get the image linked to the respective item.
						| color_code, prod_id, designer_folder, subcat_folder
						*/
						$queryNew = @mysql_query("
							SELECT
								tp.cat_id, tp.designer, tp.subcat_id, tp.prod_name,
								cat.url_structure AS cat_url_structure, 
								d.url_structure as d_url_structure, 
								subcat.url_structure AS subcat_url_structure, 
								tcs.color_name, tcs.color_code
							FROM
								tbl_product tp
								LEFT JOIN tblcat cat ON cat.cat_id = tp.cat_id
								LEFT JOIN designer d ON d.des_id = tp.designer
								LEFT JOIN tblsubcat subcat ON subcat.subcat_id = tp.subcat_id
								LEFT JOIN tbl_stock ts ON ts.prod_no = tp.prod_no
								LEFT JOIN tblcolor tcs ON tcs.color_name = ts.color_name
							WHERE
								tp.prod_no = '".$trans_rec2['prod_no']."'
								AND ts.color_name = '".$trans_rec2['color']."'
						");
						$folder = @mysql_fetch_array($queryNew);
						
						$link_to_prod_detail = $folder['cat_url_structure'].'-'.$folder['cat_id'].'/'.$folder['d_url_structure'].'-'.$folder['designer'].'/'.$folder['subcat_url_structure'].'-'.$folder['subcat_id'].'/'.$trans_rec2['prod_no'].'/'.strtolower($trans_rec2['color']).'/'.$folder['prod_name'];
						/*
						| -----------------------------------------------------------------------------------
						*/
						
						//== this is where the thumbnail image is placed and the rest of the records ?>
						<tr bgcolor="efefef" onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='efefef'">
							<td class="text" align="center"><?=$trans_rec2['designer']?></td>
							<td align="center" style="padding:5px 0 5px;">
								<a href="<?php echo SITE_URL.$link_to_prod_detail; ?>">
									<img src="<?php echo SITE_URL; ?>res.php?w=60&constrain2=1&img=<?php echo $trans_rec2['image']; ?>" />
								</a>
							</td>
							<td class="text" align="center"><?=$trans_rec2['prod_name']?></td>
							<td class="text" align="center"><?=$trans_rec2['prod_no']?></td>
							<td class="text" align="center"><?=$trans_rec2['size']?></td>
							<td class="text" align="center"><?=$trans_rec2['color']?></td>
							<td class="text" align="center"><?=$trans_rec2['qty']?></td>
							<td class="text" align="center">$<?=number_format($trans_rec2['unit_price'], 2, '.', ',')?></td>
						</tr>
						<?php
						$net_price += (number_format($trans_rec2['unit_price'], 2, '.', ',') * number_format($trans_rec2['qty']));
					} ?>
					</table>
					
				</td></tr>
				<tr bgcolor=cccccc valign="middle" height="10"><td align=center colspan="8"></td></tr>
				<tr><td colspan="6" class="text" style="padding-bottom:10px;">
				
					<h1>SUMMARY:<br /><?php echo '<b>Total Amount:</b> $'.$net_price; ?></h1>
					
					<?php
					$shipping_fee = trim($trans_rec['ship_country']) == 'United States' ? $trans_rec['shipping_fee'] : 'T.B.A';
					?>
					<strong>Shipping Fee:</strong> <?php echo $shipping_fee; ?>
					<br />
					<strong>Courier:</strong> <?php echo $trans_rec['courier']; ?>
					
				</td></tr>
				<tr bgcolor=cccccc valign="middle" height="8"><td align=center colspan="8"></td></tr>
			</table>
		</td></tr>
		</table>
		<?php
	}
	/*
	| -----------------------------------------------------------------------
	| Oder list view
	*/
	else
	{
		$query = "
			SELECT 
				tlog.order_log_id AS order_id, date_ordered, amount, status, remarks, comments,
				store_name, transaction_code, SUM(qty), SUM(unit_price)
			FROM 
				tbl_order_log tlog
			LEFT JOIN
				tbl_order_log_details tdet ON tdet.order_log_id = tlog.order_log_id
			GROUP by tlog.order_log_id
		";
		$result = mysql_query($query) or die('No records returned! '.mysql_error());
		?>
		
		<title>Order Log View::Admin Section</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		
		<script>
			function warnme() {
				var r = confirm('Are you sure you want to delete the record?'+"\n"+'This process cannot be undone.');
				if (r == true) return true;
				else return false;
			}
		</script>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
		<tr><td height="333" class="tab" align="center" valign="middle">

			<table cellpadding="0" cellspacing="2" style="outline:1px solid #787878">
			
				<tr bgcolor="cccccc" valign="middle" height="35"><td align="center" colspan="10"><h1>Order Log</h1></td></tr>
				
				<tr bgcolor="#cccccc" height="35">
					<td width="50" align="center" valign="middle" class="head">Item No</td>
					<td width="80" align="center" valign="middle" class="head">Order ID</td>
					<td width="165" align="center" valign="middle" class="head">
						Transaction Number
						<br />
						<span style="font-weight:normal;">(click for order details)</span>
					</td>
					<td width="165" align="center" valign="middle" class="head">Order Date</td>
					<td width="50" align="center" valign="middle" class="head">Total Order Qty</td>
					<td width="60" align="center" valign="middle" class="head">Total Amount</td>
					<td width="70" align="center" valign="middle" class="head">Status <span style="font-weight:normal;">(Check if delivered)</span></td>
					<td width="50" align="center" valign="middle" class="head">User Type</td>
					<td width="120" align="center" valign="middle" class="head">Remarks</td>
					<td width="50" align="center" valign="middle" class="head">Del</td>
				</tr>
			<?php
			$i = 1;
			while ($rows = mysql_fetch_array($result))
			{
				if ($rows['remarks'] != '' && $rows['remarks'] != NULL) $remarks = 'Returned';
				else $remarks = '';
				?>
				<tr class="text" height="20" bgcolor="efefef" onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='efefef'">
					<td align="center"><?php echo $i; ?></td>
					<td align="center"><?php echo $rows['order_id']; ?></td>
					<td align="center"><?php echo '<a href="order_log.php?order_id='.$rows['order_id'].'">'.$rows['transaction_code']; ?></a></td>
					<td align="center"><?php echo $rows['date_ordered']; ?></td>
					<td align="center"><?php echo $rows['SUM(qty)']; ?></td>
					<td align="center"><?php echo $rows['amount']; ?></td>
					<td align="center">
						<?php
						$frm_name = "status-".$i;
						$checked = $rows['status'] == 1 ? 'checked="checked"' : '';
						?>
						<!--bof form==========================================================================-->
						<form name="<?php echo $frm_name; ?>" action="" method="POST">
						<input type="hidden" name="order_id" value="<?php echo $rows['order_id']; ?>" />
						<input type="checkbox" name="del_status" value="1" <?php echo $checked; ?> onclick="submit()" />
						<input type="hidden" name="submit_status" value="Submit" />
						</form>
						<!--eof form==========================================================================-->
					</td>
					<td align="center"><?php echo $rows['store_name'] != '' ? 'Store' : 'Consumer'; ?></td>
					<td align="center"><?php echo $remarks; ?></td>
					<td align="center">
						[<a href="order_log.php?del=<?php echo $rows['order_id']; ?>" class="del_link" onclick="return warnme();">X</a>]
					</td>
				</tr>
				<?php
				$i++;
			} ?>
				<tr bgcolor="cccccc" valign="middle" height="10"><td align="center" colspan="10"></td></tr>
			</table>
			
		</td></tr>
		</table>
		<?php
	}
	
	include 'footer.php';

