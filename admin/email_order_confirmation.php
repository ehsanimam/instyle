<?php 
	
	if ($trans_rec['ship_country'] <> 'United States')
	{
		$notice = '( For countries other than United State, you will be contacted by customer service for shipping fees )';
	}
	else
	{
		$notice = '( Inclusive of shipping fees )';
	}
	
	if ($trans_rec['store_name'])
	{
		$store_name = '
			<tr>
				<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Store Name :</b></font></td>
				<td><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec['store_name'].'</font></td>
			</tr>
		';
	}
	else
	{
		$store_name = '';
	}
	
	if($trans_rec['store_name'] != '' OR $trans_rec['store_name'] != NULL)
	$user_type = 'wholesale';
	else
	$user_type = 'consumer';
	
	if ($user_type === 'wholesale')
	{
		$heading = 'INSTYLENEWYORK.COM WHOLESALE ORDER INQUIRY';
	}
	else $heading = 'INSTYLENEWYORK.COM ORDER CONFIRMATION';
	
	$date =  str_replace('-', '',str_replace(',',' ',$trans_rec['date_ordered']));
	$date = strtotime($date);
	$date = date('Y-m-d',$date);
	
	if($trans_rec['courier'] != '0' AND $trans_rec['courier'] != '' )
	$courier = $trans_rec['courier'];
	else
	$courier = '';
	
	$email_content = '
	<table width="100%" align="center">
		<tr><td bgcolor="#393939">
			<br />
			<br />
			<table border="0" cellspacing="0" cellpadding="0" width="650" align="center">
			<tbody>
				<tr>
					<td width="10" bgcolor="#efefef">
						<img src="http://www.instylenewyork.com/images/newsletter/top_left.jpg">
					</td>
					<td bgcolor="#efefef" background="http://www.instylenewyork.com/images/newsletter/top_bg.jpg" width="630" height="92">
						<table width="630">
						<tbody>
							<tr>
								<td width="514">
									<font color="#333333" style="font-family:Tahoma;font-size:12px;">
									<br />
									<b>'.$heading.'</b> &nbsp; &nbsp;</font> 
									<font color="#333333" style="font-family:Tahoma;font-size:10px;">[ DATE: '.$date.' ]</font>
								</td>
								<td width="104" align="right">
									<font color="#333333" style="font-family:Tahoma;font-size:12px;">
									<br />
									<b>ORDER#:</b></font>
									<font color="#333333" style="font-family:Tahoma;font-size:10px;"> '.$_GET['order_id'].'</font>
								</td>
							</tr>
						</tbody>
						</table>
						<br />
					</td>
					<td width="10" bgcolor="#efefef">
						<img src="http://www.instylenewyork.com/images/newsletter/top_right.jpg">
					</td>
				</tr>
				<tr>
					<td bgcolor="#efefef">&nbsp;</td>
					<td bgcolor="#efefef">
						<font color="#333333">
						<table border="0" cellspacing="0" cellpadding="2" width="630">
						<tbody>
							<tr>
								<td colspan="2" height="35" bgcolor="#767676" background="http://instylenewyork.com/images/newsletter/bar_bg.jpg">
									<font color="#ffffff" style="font-family:Tahoma;font-size:12px;">
									&nbsp;<b>SHIPPING DETAILS</b></font>
								</td>
							</tr>
							<tr>
								<td width="170">&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Name :</b></font></td>
								<td width="452"><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec['firstname'].' '.$trans_rec['lastname'].'</font></td>
							</tr>
							'.$store_name.'
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Address :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec['ship_address1'].' '.$trans_rec['ship_address2'].'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>City :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec['ship_city'].'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>State :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec['ship_state'].'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Country :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec['ship_country'].'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Zip :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec['ship_zipcode'].'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Phone :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec['telephone'].'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Email :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;"><a href="mailto:'.$trans_rec['email'].'">'.$trans_rec['email'].'</a></font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Courier :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$courier.'</font></td>
							</tr>
						</tbody>
						</table>
						<br />
						<table border="0" cellspacing="0" cellpadding="2" width="630">
						<tbody>
							<tr>
								<td height="35" colSpan="2" bgcolor="#767676" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg">
									<font color="#ffffff" style="font-family:Tahoma;font-size:12px;">&nbsp;<b>PAYMENT DETAILS</b></font>
								</td>
							</tr>
							<tr>
								<td width="170">&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Card Type :</b></font></td>
								<td width="452"><font style="font-family:Tahoma;font-size:10px;"></font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Card Holder :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec['firstname'].' '.$trans_rec['lastname'].'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Card number :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;"></font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Expiration :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;"></font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>CSC :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;"></font></td>
							</tr>
						</tbody>
						</table>
						<br />
						<table width="630" border="0" cellspacing="0" cellpadding="2">	
							<tr>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Thumb</b></font></td>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Item</b></font></td>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Style Number</b></font></td>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Size</b></font></td>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Color</b></font></td>	
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Quantity</b></font></td>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Price</b></font></td>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Subtotal</b></font></td>
							</tr>
	';
	$trans_r3 = mysql_query($trans_q) or die('No transaction returned! (2) '.mysql_error());
	while ($trans_rec3 = mysql_fetch_array($trans_r3))
	{
		/*
		| -----------------------------------------------------------------------------------
		| Things needed to be able to get the image linked to the respective item.
		| color_code, prod_id, designer_folder, subcat_folder
		*/
		$queryNew2 = @mysql_query("
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
				tp.prod_no = '".$trans_rec3['prod_no']."'
				AND ts.color_name = '".$trans_rec3['color']."'
				");
			$folder2 = @mysql_fetch_array($queryNew2);
							
			$link_to_prod_detail2 = $folder2['cat_url_structure'].'-'.$folder2['cat_id'].'/'.$folder2['d_url_structure'].'-'.$folder2['designer'].'/'.$folder2['subcat_url_structure'].'-'.$folder2['subcat_id'].'/'.$trans_rec3['prod_no'].'/'.strtolower($trans_rec3['color']).'/'.$folder2['prod_name'];
			$amount += ($trans_rec3['qty'] * $trans_rec3['unit_price']);
		/*
		| -----------------------------------------------------------------------------------
		*/
		$email_content .= '<tr>';
		$email_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;"><a href="'.SITE_URL.$link_to_prod_detail2.'"><img src="http://instylenewyork.com/'.$trans_rec3['image'].'" width="60" height="90" border="0"></a></font></td>';
		$email_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec3['prod_name'].'</font></td>';
		$email_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec3['prod_no'].'</font></td>';
		$email_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec3['size'].'</font></td>';
		$email_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec3['size'].'</font></td>';
		$email_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$trans_rec3['qty'].'</font></td>';
		$email_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">$'.number_format($trans_rec3['unit_price'], 2, '.', ',').'</font></td>';
		$email_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">$'.($trans_rec3['qty'] * $trans_rec3['unit_price']).'</font></td>';
		$email_content .= '</tr>';
	}
	if(isset($_GET['designer']))
	{
		$total = $amount;
	}
	else
	{
		$total = $trans_rec['amount'];
	}
	
	$email_content .= '
							<tr>
								<td colspan="7" align="right"><font style="font-family:Tahoma;font-size:12px;">Merchandise Grand-Total : </font></td>
								<td align="center"><font style="font-family:Tahoma;font-size:12px;">$'.$total.'</font></td>
							</tr>
							<tr>
								<td colspan="7" align="right"><font style="font-family:Tahoma;font-size:9px;">'.$notice.' &nbsp; </font></td>
								<td align="center"></td>
							</tr>
							<tr>
								<td colspan="8" align="center"><font style="color:red;font-family:Tahoma;font-size:9px;"><br /><br />* NOTE: You will be contacted by our Customer Service Specialist to complete the payment details of your order &nbsp; </font><br /></td>
							</tr>
						</table>
						<table width="630" align="center" style="border-top:1px solid black;">
							<tr>
								<td width="630" align="center">
									<font color="#333333" style="font-family:Tahoma;font-size:10px;">
										'.SITE_NAME.'
										230 West 38th Street
										New York, NY 10018
										PHONE: 212-840-0846 ext 22 &nbsp; EMAIL <a href="mailto:'.INFO_EMAIL.'">'.INFO_EMAIL.'</a>
									</font>
								</td>
							</tr>
							<tr>
								<td width="630" align="center">
									<font color="#333333" style="font-family:Tahoma;font-size:10px;">
										Purchaser agrees to abide by the instylenewyork.com return policy.
									</font>
								</td>
							</tr>
						</table>
						</font>
					</td>
					<td bgcolor="#efefef">&nbsp;</td>
				</tr>
				<tr>
					<td><img src="http://www.instylenewyork.com/images/newsletter/bottom_left.jpg"></td>
					<td><img src="http://www.instylenewyork.com/images/newsletter/bottom_bg.jpg"></td>
					<td><img src="http://www.instylenewyork.com/images/newsletter/bottom_right.jpg"></td>
				</tr>
			</tbody>
			</table>
			<br /><br />
		</td></tr>
	</table>
	';
	
	
	?>