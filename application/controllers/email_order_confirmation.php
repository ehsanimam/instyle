<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$domain = $this->config->item('site_domain');
	
	if ($sh_country <> 'United States')
	{
		$notice = '( For countries other than United State, you will be contacted by customer service for shipping fees )';
	}
	else
	{
		$notice = '( Inclusive of shipping fees )';
	}
	
	if ($this->session->userdata('user_cat') === 'wholesale')
	{
		$store_name = '
			<tr>
				<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Store Name :</b></font></td>
				<td><font style="font-family:Tahoma;font-size:10px;">'.$p_store_name.'</font></td>
			</tr>
		';
		$heading = strtoupper(ltrim($domain, 'www.')).' WHOLESALE ORDER INQUIRY';
	}
	else
	{
		$store_name = '';
		$heading = strtoupper(ltrim($domain, 'www.')).' ORDER CONFIRMATION';
	}
	
	$email_content = '
	<table width="100%" align="center">
		<tr><td bgcolor="#393939">
			<br />
			<br />
			<table border="0" cellspacing="0" cellpadding="0" width="650" align="center">
			<tbody>
				<tr>
					<td width="10" bgcolor="#efefef">
						<img src="http://'.$domain.'/images/newsletter/top_left.jpg">
					</td>
					<td bgcolor="#efefef" background="http://'.$domain.'/images/newsletter/top_bg.jpg" width="630" height="92">
						<table width="630">
						<tbody>
							<tr>
								<td width="514">
									<font color="#333333" style="font-family:Tahoma;font-size:12px;">
									<br />
									<b>'.$heading.'</b> &nbsp; &nbsp;</font> 
									<font color="#333333" style="font-family:Tahoma;font-size:10px;">[ DATE: '.date('Y-m-d',time()).' ]</font>
								</td>
								<td width="104" align="right">
									<font color="#333333" style="font-family:Tahoma;font-size:12px;">
									<br />
									<b>ORDER#:</b></font>
									<font color="#333333" style="font-family:Tahoma;font-size:10px;"> '.$order_log_id.'</font>
								</td>
							</tr>
						</tbody>
						</table>
						<br />
					</td>
					<td width="10" bgcolor="#efefef">
						<img src="http://'.$domain.'/images/newsletter/top_right.jpg">
					</td>
				</tr>
				<tr>
					<td bgcolor="#efefef">&nbsp;</td>
					<td bgcolor="#efefef">
						<font color="#333333">
						<table border="0" cellspacing="0" cellpadding="2" width="630">
						<tbody>
							<tr>
								<td colspan="2" height="35" bgcolor="#767676" background="http://'.$domain.'/images/newsletter/bar_bg.jpg">
									<font color="#ffffff" style="font-family:Tahoma;font-size:12px;">
									&nbsp;<b>SHIPPING DETAILS</b></font>
								</td>
							</tr>
							<tr>
								<td width="170">&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Name :</b></font></td>
								<td width="452"><font style="font-family:Tahoma;font-size:10px;">'.$p_first_name.' '.$p_last_name.'</font></td>
							</tr>
							'.$store_name.'
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Address :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$sh_address1.' '.$sh_address2.'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>City :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$sh_city.'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>State :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$sh_state.'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Country :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$sh_country.'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Zip :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$sh_zipcode.'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Phone :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$p_telephone.'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Email :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;"><a href="mailto:'.$p_email.'">'.$p_email.'</a></font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Courier :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$this->session->userdata('shipping_courier').'</font></td>
							</tr>
						</tbody>
						</table>
						<br />
	';
	$email_content_2 = $email_content;
	
	$email_content .= '
						<table border="0" cellspacing="0" cellpadding="2" width="630">
						<tbody>
							<tr>
								<td height="35" colSpan="2" bgcolor="#767676" background="http://'.$domain.'/images/newsletter/bar_bg.jpg">
									<font color="#ffffff" style="font-family:Tahoma;font-size:12px;">&nbsp;<b>PAYMENT DETAILS</b></font>
								</td>
							</tr>
							<tr>
								<td width="170">&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Card Type :</b></font></td>
								<td width="452"><font style="font-family:Tahoma;font-size:10px;">'.$p_card_type.'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Card Holder :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$p_first_name.' '.$p_last_name.'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Card number :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$p_card_num.'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Expiration :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$p_exp_date.'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>CSC :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$p_card_code.'</font></td>
							</tr>
						</tbody>
						</table>
						<br />
	';
	
	// removing payment details for email confirmation to user...
	/*
	$email_content_2 .= '
						<table border="0" cellspacing="0" cellpadding="2" width="630">
						<tbody>
							<tr>
								<td height="35" colSpan="2" bgcolor="#767676" background="http://'.$domain.'/images/newsletter/bar_bg.jpg">
									<font color="#ffffff" style="font-family:Tahoma;font-size:12px;">&nbsp;<b>PAYMENT DETAILS</b></font>
								</td>
							</tr>
							<tr>
								<td width="170">&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Card Type :</b></font></td>
								<td width="452"><font style="font-family:Tahoma;font-size:10px;">'.$p_card_type.'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Card Holder :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">'.$p_first_name.' '.$p_last_name.'</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Card number :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">****************</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>Expiration :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">****************</font></td>
							</tr>
							<tr>
								<td>&nbsp;<font style="font-family:Tahoma;font-size:10px;"><b>CSC :</b></font></td>
								<td><font style="font-family:Tahoma;font-size:10px;">****************</font></td>
							</tr>
						</tbody>
						</table>
						<br />
	';
	*/
	
	$final_content = '
						<table width="630" border="0" cellspacing="0" cellpadding="2">	
							<tr>
								<td align="center" background="http://'.$domain.'/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Thumb</b></font></td>
								<td align="center" background="http://'.$domain.'/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Item</b></font></td>
								<td align="center" background="http://'.$domain.'/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Style Number</b></font></td>
								<td align="center" background="http://'.$domain.'/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Size</b></font></td>
								<td align="center" background="http://'.$domain.'/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Color</b></font></td>	
								<td align="center" background="http://'.$domain.'/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Quantity</b></font></td>
								<td align="center" background="http://'.$domain.'/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Price</b></font></td>
								<td align="center" background="http://'.$domain.'/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:11px;" color="#a1a1a1"><b>Subtotal</b></font></td>
							</tr>
	';
	
	foreach ($this->cart->contents() as $items):
	
		if ($this->config->item('site_domain') == 'www.storybookknits.com')
		{
			switch ($items['options']['size'])
			{
				case '0': $size_name = 'XS'; break;
				case '2': $size_name = 'S'; break;
				case '4': $size_name = 'M'; break;
				case '6': $size_name = 'L'; break;
				case '8': $size_name = 'XL'; break;
				case '10': $size_name = '1X'; break;
				case '12': $size_name = '2X'; break;
				case '14': $size_name = '3X'; break;
				case '16': $size_name = ''; break;
			}
		}
		else $size_name = $items['options']['size'];
	
		$final_content .= '<tr>';
		$final_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;"><a href="'.$items['options']['current_url'].'"><img src="http://products.'.ltrim($domain, 'www.').'/'.$items['options']['prod_image'].'" width="60" height="90" border="0"></a></font></td>';
		$final_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$items['name'].'</font></td>';
		$final_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$items['options']['prod_no'].'</font></td>';
		$final_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$size_name.'</font></td>';
		$final_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$items['options']['color'].'</font></td>';
		$final_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$items['qty'].'</font></td>';
		$final_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">$'.$items['price'].'</font></td>';
		$final_content .= '<td align="center"><font style="font-family:Tahoma;font-size:10px;">$'.($items['qty'] * $items['price']).'</font></td>';
		$final_content .= '</tr>';
	endforeach;
	
	$final_content .= '
							<tr>
								<td colspan="7" align="right"><font style="font-family:Tahoma;font-size:12px;">Merchandise Grand-Total : </font></td>
								<td align="center"><font style="font-family:Tahoma;font-size:12px;">$'.$grand_total.'</font></td>
							</tr>
							<tr>
								<td colspan="7" align="right"><font style="font-family:Tahoma;font-size:9px;">'.$notice.' &nbsp; </font></td>
								<td align="center"></td>
							</tr>
							<tr>
								<td colspan="8" align="center"><font style="color:red;font-family:Tahoma;font-size:9px;"><br /><br />* NOTE: You will be contacted by our Customer Service Specialist to confirm the shipment and details of your order &nbsp; </font><br /></td>
							</tr>
						</table>
						<table width="630" align="center" style="border-top:1px solid black;">
							<tr>
								<td width="630" align="center">
									<font color="#333333" style="font-family:Tahoma;font-size:10px;">
										'.$this->config->item('site_name').'
										'.$this->config->item('site_address1').'
										'.$this->config->item('site_address2').'
										PHONE: 212-840-0846 ext 22 &nbsp; EMAIL <a href="mailto:'.$this->config->item('info_email').'">'.$this->config->item('info_email').'</a>
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
					<td><img src="http://'.$domain.'/images/newsletter/bottom_left.jpg"></td>
					<td><img src="http://'.$domain.'/images/newsletter/bottom_bg.jpg"></td>
					<td><img src="http://'.$domain.'/images/newsletter/bottom_right.jpg"></td>
				</tr>
			</tbody>
			</table>
			<br /><br />
		</td></tr>
	</table>
	';
	
	$email_content .= $final_content;
	$email_content_2 .= $final_content;