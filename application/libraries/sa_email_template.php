<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if ($this->session->userdata('admin_sales_email') == 'dsadot@basixii.com')
		$signature = '
			Basix Black Label <br />
			230 West 38th Street <br />
			New York , NY 10018 <br />
			212.840.9811 <br />
		';
	elseif ($this->session->userdata('admin_sales_email') == 'joe@innerconcept.com')
		$signature = '
			Basix Black Label <br />
			Instyle New York <br />
			230 West 38th Street <br />
			New York , NY 10018 <br />
			212.840.0846 <br />
		';
	else $signature = '';
	
	$email_content = '
	<table width="100%">
		<tr><td>
			<br />
			
			Hi '.$recipients_name.',
			
			<br /><br />
			
			'.$comments_overall.'
			
			<br /><br />
			
			Below are the details of the attached product line sheets:
			
			<br /><br />
			
			<table border="0" cellspacing="0" cellpadding="0" width="630">
			<tbody>
				<tr>
					<td>
					
						<table width="630" border="0" cellspacing="1" cellpadding="5">
							<col width="160" />
							<col />
							<col width="90" />
							<col />
							<tr height="25">
								<td align="left" style="background-color:#767676;"><font style="font-family:Tahoma;font-size:11px;" color="white"><b>Style Number</b></font></td>
								<td align="left" style="background-color:#767676;"><font style="font-family:Tahoma;font-size:11px;" color="white"><b>Name</b></font></td>
								<td align="left" style="background-color:#767676;"><font style="font-family:Tahoma;font-size:11px;" color="white"><b>Price</b></font></td>
								<td align="left" style="background-color:#767676;"><font style="font-family:Tahoma;font-size:11px;" color="white"><b>Available Colors</b></font></td>
							</tr>
	';
	
	foreach ($this->cart->contents() as $item):
	
		$rec_price = $item['price'] == 1 ? number_format(0, 2) : number_format($item['price'], 2);
		$price = $w_prices == 'Y' ? $this->config->item('currency').' '.$rec_price : '-';
	
		$email_content .= '<tr>';
		$email_content .= '<td align="left" bgcolor="#efefef"><font style="font-family:Tahoma;font-size:10px;">'.$item['options']['prod_no'].' - '.$item['options']['product_color'].'</font></td>';
		$email_content .= '<td align="left" bgcolor="#efefef"><font style="font-family:Tahoma;font-size:10px;">'.$item['name'].'</font></td>';
		$email_content .= '<td align="left" bgcolor="#efefef"><font style="font-family:Tahoma;font-size:10px;">'.$price.'</font></td>';
		$email_content .= '<td align="left" bgcolor="#efefef"><font style="font-family:Tahoma;font-size:10px;">'.$item['options']['available_colors'].'</font></td>';
		$email_content .= '</tr>';
		
	endforeach;
	
	$email_content .= '
						</table>
					</td>
				</tr>
			</tbody>
			</table>
			<br /><br />
			
			'.$sales_agent.'<br />
			'.$signature.'
			
		</td></tr>
	</table>
	';
	
