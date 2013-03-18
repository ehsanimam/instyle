<?php
	include("../common.php");
?>
<body bgcolor="#393939">
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
								<td width="104"><img src="http://www.instylenewyork.com/images/newsletter/logo.gif"></td>
								<td width="514">
									<font color="#333333" style="font-family:Tahoma;font-size:12px;">
									<br />
									<b>INSTYLENEWYORK.COM ORDER CONFIRMATION</b> &nbsp; &nbsp; &nbsp;</font> 
									<font color="#333333" style="font-family:Tahoma;font-size:10px;">[ DATE: '.date('Y-m-d',time()).' ]</font>
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
								<td width="452"><font style="font-family:Tahoma;font-size:10px;">'.$p_first_name.' '.$p_last_name.'</font></td>
							</tr>
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
								<td><font style="font-family:Tahoma;font-size:10px;">'.$p_phone.'</font></td>
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
						<table border="0" cellspacing="0" cellpadding="2" width="630">
						<tbody>
							<tr>
								<td height="35" colSpan="2" bgcolor="#767676" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg">
									<font color="#ffffff" style="font-family:Tahoma;font-size:12px;">&nbsp;<b>CREDIT CARD DETAILS</b></font>
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
						<table width="630" border="0" cellspacing="0" cellpadding="2">	
							<tr>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:12px;" color="#ffffff"><b>Thumb</b></font></td>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:12px;" color="#ffffff"><b>Item</b></font></td>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:12px;" color="#ffffff"><b>Style Number</b></font></td>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:12px;" color="#ffffff"><b>Size</b></font></td>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:12px;" color="#ffffff"><b>Color</b></font></td>	
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:12px;" color="#ffffff"><b>Quantity</b></font></td>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:12px;" color="#ffffff"><b>Price</b></font></td>
								<td align="center" background="http://www.instylenewyork.com/images/newsletter/bar_bg.jpg"><font style="font-family:Tahoma;font-size:12px;" color="#ffffff"><b>Subtotal</b></font></td>
							</tr>
							<tr>
								<td align="center">
									<font style="font-family:Tahoma;font-size:10px;"><a href="'.$items['options']['current_url'].'"><img src="'.$items['options']['prod_image'].'" width="60" height="90" border="0"></a></font>
								</td>
								<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$items['name'].'</font></td>
								<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$items['options']['prod_no'].'</font></td>
								<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$items['options']['size'].'</font></td>
								<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$items['options']['color'].'</font></td>
								<td align="center"><font style="font-family:Tahoma;font-size:10px;">'.$items['qty'].'</font></td>
								<td align="center"><font style="font-family:Tahoma;font-size:10px;">$'.$items['price'].'</font></td>
								<td align="center"><font style="font-family:Tahoma;font-size:10px;">$'.($items['qty'] * $items['price']).'</font></td>
							</tr>
							<tr>
								<td colspan="7" align="right"><font style="font-family:Tahoma;font-size:12px;">Merchandise Grand-Total : </font></td>
								<td><font style="font-family:Tahoma;font-size:12px;">$'.$this->cart->total()+$this->session->userdata('shipping_fee').'</font></td>
							</tr>
						</table>
						<br /><br /><br />
						<table width="630" align="center">
							<tr>
								<td width="630">
									<font color="#333333" style="font-family:Tahoma;font-size:10px;">
										'.$this->config->item('site_name').'
										'.$this->config->item('site_address1').'
										'.$this->config->item('site_address2').'
										PHONE: 212-840-0846 ext 22
									</font>
								</td>
							</tr>
						</table>
						</font>
						<br /><br />
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
 </body>