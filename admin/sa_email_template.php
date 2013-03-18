<?php

	$signature = '
		Basix Black Label <br />
		Instyle New York <br />
		230 West 38th Street <br />
		New York , NY 10018 <br />
		212.840.0846 <br />
	';
	
	if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] === 'localhost')
	{
		$mock_msg = '
			<span style="color:red;">[ 	
				This is the mock sales package sending. This is just a test sending. Please ignore.
			]</span>
		';
	}
	else $mock_msg = '';
	
	$email_content = '
	<table width="100%">
		<tr><td>
			<br />
			
			'.$mock_msg.'
			
			<br />
			
			Dear '.$row['firstname'].' '.$row['lastname'].',
			
			<br /><br />
			
			We are attaching several brand new designs for your review.<br />
			Please respond with items of interest for your stores.
			
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
							<col width="70" />
							<col />
							<tr height="25">
								<td align="left" style="background-color:#767676;"><font style="font-family:Tahoma;font-size:11px;" color="white"><b>Style Number</b></font></td>
								<td align="left" style="background-color:#767676;"><font style="font-family:Tahoma;font-size:11px;" color="white"><b>Name</b></font></td>
								<td align="left" style="background-color:#767676;"><font style="font-family:Tahoma;font-size:11px;" color="white"><b>Price</b></font></td>
								<td align="left" style="background-color:#767676;"><font style="font-family:Tahoma;font-size:11px;" color="white"><b>Available Colors</b></font></td>
							</tr>
	';
	
	// get all new items
	$sel = "
		SELECT *
		FROM 
			new_items_count 
		WHERE 
			status = '2' 
			AND des_id = '5'
	";
	$qry = mysql_query($sel) or die('Select from new_items_count Error!<br />'.mysql_error().'<br />'.$sel);
	
	$i = 0;
	$attachment = array();
	
	if (mysql_num_rows($qry) > 0)
	{
		// for each new item status = 2
		while ($row = mysql_fetch_array($qry))
		{
			// break color code from prod_sku
			$exp = explode("_", $row['prod_sku']);
			$color_code = $exp[1];
			
			// get product details and different colors from tbl_product and tbl_stock
			$sel_details = "
				SELECT 
					p.wholesale_price, p.prod_name, p.colors,
					ts.color_name,
					tc.color_code,
					c.folder AS c_folder,
					d.folder AS d_folder,
					sc.folder AS sc_folder
				FROM 
					tbl_product p
					LEFT JOIN designer d ON d.des_id = p.designer
					LEFT JOIN tblcat c ON c.cat_id = p.cat_id
					LEFT JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
					LEFT JOIN tbl_stock ts ON ts.prod_no = p.prod_no
					LEFT JOIN tblcolor tc ON tc.color_name = ts.color_name
				WHERE 
					p.prod_no = '".$row['prod_no']."'
					AND tc.color_code = '".$color_code."'
			";
			$qry_details = mysql_query($sel_details) or die('Select product details Error!<br />'.mysql_error().'<br />'.$sel_details);
			
			if (mysql_num_rows($qry_details) > 0)
			{
				// in case more than one color
				while ($row_details = mysql_fetch_array($qry_details))
				{
					$price = $row_details['wholesale_price'] == 1 ? number_format(0, 2) : number_format($row_details['wholesale_price'], 2);
				
					$email_content .= '<tr>';
					$email_content .= '<td align="left" bgcolor="#efefef"><font style="font-family:Tahoma;font-size:10px;">'.$row['prod_no'].' - '.strtoupper($row_details['color_name']).'</font></td>';
					$email_content .= '<td align="left" bgcolor="#efefef"><font style="font-family:Tahoma;font-size:10px;">'.$row_details['prod_name'].'</font></td>';
					$email_content .= '<td align="left" bgcolor="#efefef"><font style="font-family:Tahoma;font-size:10px;">'.$price.'</font></td>';
					$email_content .= '<td align="left" bgcolor="#efefef"><font style="font-family:Tahoma;font-size:10px;">'.strtoupper($row_details['colors']).'</font></td>';
					$email_content .= '</tr>';
					
					$attachment[$i] = '../product_assets/'.$row_details['c_folder'].'/'.$row_details['d_folder'].'/'.$row_details['sc_folder'].'/'.'product_linesheet/'.$row['prod_no'].'_'.strtoupper($row_details['color_code']).'.jpg';
					$i++;
				}
			}
		}
	}
	
	// free up mysql memory
	mysql_free_result($qry);
	
	$email_content .= '
						</table>
					</td>
				</tr>
			</tbody>
			</table>
			<br /><br />
			
			'.$signature.'
			
		</td></tr>
	</table>
	';
	
