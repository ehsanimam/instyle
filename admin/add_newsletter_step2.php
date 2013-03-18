<?php
	include("../common.php");
	include("security.php");
	
	if (isset($_POST['add_step2']))
	{
		$image 	  	 = $_FILES['image'];
		$item_title  = $_POST['item_title'];
		$item_desc 	 = $_POST['item_desc'];
		$item_url	 = $_POST['item_url'];
		$prod_url	 = $_POST['prod_url'];
		$prod_url_clr = $_POST['prod_url_clr'];
		$n_id		 = $_POST['newsletter_id'];	
		
		$html 	= '';

		// LUXURY SHOPPING
		$luxury	= '
							<table id="luxry_shopping_images" border="0" cellpadding="0" cellspacing="0">
		';
		$i = 0;
		foreach ($image['name'] as $img)
		{
			@$images .= $img.',';
			
			$path = "../images/newsletters/".$img;
			move_uploaded_file($image['tmp_name'][$i],$path);
			chmod($path,0777);
			
			$c1 = fmod($i, 2); // ---> identifies 1st or 2nd column and new row
			if ($c1 == 0)
			{
				$tr_b = '<tr valign="top">';
				$tr_e = '	<td width="20"></td>';
			}
			else
			{
				$tr_b = '';
				$tr_e = '</tr>';
			}
			
			$luxury .= '
								'.$tr_b.'
									<td width="300" style="padding-bottom:10px;">
										<div class="luxury_images" style="font-family:arial;font-size:12px;color:gray;width:300px;">
											<a href="'.$item_url[$i].'" target="_blank">
												<img src="'.str_replace('https','http',SITE_URL).'images/newsletters/'.$img.'" border="0" width="300" height="160" />
											</a>
											<br />
											<a href="'.$item_url[$i].'" style="color:red;font-style:underline;" target="_blank"><b>'.htmlspecialchars($item_title[$i],ENT_QUOTES).'</b></a>
											<br />
											<span>'.htmlspecialchars($item_desc[$i],ENT_QUOTES).'</span>
										</div>
									</td>
								'.$tr_e.'
			';
			
			$i++;
		}
		
		if ($c1 == 0) $luxury .= '			<td></td></tr>'; // ---> in case last image is in 1st column
		
		$luxury .= '</table>';
		
		$luxury_html = $luxury;
		
		// NEW ARRIVAL
		$prods	= '
							<table id="new_arrival_product_images" border="0" cellpadding="0" cellspacin="0">
		';
		$y 		= 0;
		foreach ($prod_url as $purl)
		{
			$seg = explode('/',$purl);
			$prod_no    = $seg[4];
			$color_name = $seg[5];

			$sql = "SELECT
					  p.prod_id, p.prod_name, p.prod_no, tc.color_id, tc.color_name, tc.color_code, p.prod_date, p.prod_desc, p.on_sale,
					  p.catalogue_price, p.less_discount, p.primary_img, p.primary_img_id, p.new_arrival, p.clearance, p.colors, p.styles, 
					  c.cat_name, c.cat_id, c.title AS c_title, c.description AS c_description, c.folder AS c_folder, 
					  c.keyword AS c_keyword, c.alttags AS c_alttags, c.url_structure AS c_url_structure,
					  sc.subcat_name, sc.folder AS sc_folder, sc.subcat_id, sc.title AS sc_title, sc.description AS sc_description, 
					  sc.keyword AS sc_keyword, sc.alttags AS sc_alttags, sc.url_structure AS sc_url_structure,
					  d.designer, d.folder AS d_folder, d.des_id,
					  tc.color_name, ssc.name AS subsubcat_name
					FROM
					  tbl_product p
					  JOIN tblcat c ON c.cat_id = p.cat_id
					  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
					  LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
					  JOIN designer d ON d.des_id = p.designer
					  JOIN tbl_stock ts ON ts.prod_no = p.prod_no
					  JOIN tblcolor tc ON tc.color_name = ts.color_name
					WHERE
					  p.prod_no ='".$prod_no."'
					AND
					  tc.color_name = '".$color_name."'";
			$row = mysql_fetch_array(mysql_query($sql));
			
			$thumb_name = $row['prod_no'].'_'.$row['color_code'].'.jpg';
			$thumb 		= str_replace('https','http',SITE_URL).'product_assets/'.$row['c_folder'].'/'.$row['d_folder'].'/'.$row['sc_folder'].'/product_front/'.$thumb_name;
			
			$r2 = fmod($y, 4); // ---> indicates which column;
			if ($r2 == 0)
			{
				$tr_b = '<tr valign="top">';
				$tr_e = '	<td width="20"></td>';
			}
			else if ($r2 == 3)
			{
				$tr_b = '';
				$tr_e = '</tr>';
			}
			else
			{
				$tr_b = '';
				$tr_e = '	<td width="20"></td>';
			}
			
			$prods .= '
								'.$tr_b.'
									<td width="140" style="padding-bottom:10px;">
										<div class="product_images" style="font-family:arial;font-size:10px;color:gray;width:140px;">
											<a href="'.$purl.'" target="_blank">
												<img src="'.str_replace('https','http',SITE_URL).'res.php?w=140&h=210&constrain2=1&img='.$thumb.'" border="0" width="140" height="210" />
											</a>
											<br />
											<table border="0" cellpadding="0" cellspacin="0">
												<tr>
													<td align="left" style="font-family:Arial;font-size:10px;color:gray;">'.$row['prod_no'].'</td>
													<td align="right" style="font-family:Arial;font-size:10px;color:gray;">$ '.$row['catalogue_price'].'</td>
												<tr>
												<tr><td colspan="2" style="font-family:Arial;font-size:10px;color:gray;width:140px;">'.$row['prod_name'].'</td></tr>
											</table>
										</div>
									</td>
								'.$tr_e.'
			';
			
			$y++;
		}
		
		if ($r2 == 0) $prods .= '			<td colspan="5"></td></tr>';
		if ($r2 == 1) $prods .= '			<td colspan="3"></td></tr>';
		if ($r2 == 2) $prods .= '			<td></td></tr>';
		
		$prods .= '</table>';
		
		$arrival_html = $prods;
		
		// CLEARANCE
		$clears = '
							<table id="clearance_product_images" border="0" cellpadding="0" cellspacin="0">
		';
		$z 		= 0;
		foreach ($prod_url_clr as $purlc)
		{
			$seg2 = explode('/',$purlc);
			$prod_no2    = $seg2[4];
			$color_name2 = $seg2[5];
			
			$sql2 = "SELECT
					  p.prod_id, p.prod_name, p.prod_no, tc.color_id, tc.color_name, tc.color_code, p.prod_date, p.prod_desc, p.on_sale,
					  p.catalogue_price, p.less_discount, p.primary_img, p.primary_img_id, p.new_arrival, p.clearance, p.colors, p.styles, 
					  c.cat_name, c.cat_id, c.title AS c_title, c.description AS c_description, c.folder AS c_folder, 
					  c.keyword AS c_keyword, c.alttags AS c_alttags, c.url_structure AS c_url_structure,
					  sc.subcat_name, sc.folder AS sc_folder, sc.subcat_id, sc.title AS sc_title, sc.description AS sc_description, 
					  sc.keyword AS sc_keyword, sc.alttags AS sc_alttags, sc.url_structure AS sc_url_structure,
					  d.designer, d.folder AS d_folder, d.des_id,
					  tc.color_name, ssc.name AS subsubcat_name
					FROM
					  tbl_product p
					  JOIN tblcat c ON c.cat_id = p.cat_id
					  JOIN tblsubcat sc ON sc.subcat_id = p.subcat_id
					  LEFT JOIN tblsubsubcat ssc ON ssc.id = p.subsubcat_id
					  JOIN designer d ON d.des_id = p.designer
					  JOIN tbl_stock ts ON ts.prod_no = p.prod_no
					  JOIN tblcolor tc ON tc.color_name = ts.color_name
					WHERE
					  p.prod_no ='".$prod_no2."'
					AND
					  tc.color_name = '".$color_name2."'";
			$row2 = mysql_fetch_array(mysql_query($sql2));
			
			$thumb_name2 = $row2['prod_no'].'_'.$row2['color_code'].'.jpg';
			$thumb2 	= str_replace('https','http',SITE_URL).'product_assets/'.$row2['c_folder'].'/'.$row2['d_folder'].'/'.$row2['sc_folder'].'/product_front/'.$thumb_name2;
			
			$r3 = fmod($z, 4); // ---> indicates which column;
			if ($r3 == 0)
			{
				$tr_b = '<tr valign="top">';
				$tr_e = '	<td width="20"></td>';
			}
			else if ($r3 == 3)
			{
				$tr_b = '';
				$tr_e = '</tr>';
			}
			else
			{
				$tr_b = '';
				$tr_e = '	<td width="20"></td>';
			}
			
			$clears .= '
								'.$tr_b.'
									<td width="140" style="padding-bottom:10px;">
										<div class="product_images" style="font-family:arial;font-size:10px;color:gray;width:140px;">
											<a href="'.$purlc.'" target="_blank">
												<img src="'.str_replace('https','http',SITE_URL).'res.php?w=140&h=210&constrain2=1&img='.$thumb2.'" border="0" width="140" height="210" />
											</a>
											<br />
											<table border="0" cellpadding="0" cellspacin="0">
												<tr>
													<td align="left" style="font-family:Arial;font-size:10px;color:gray;">'.$row2['prod_no'].'</td>
													<td align="right" style="font-family:Arial;font-size:10px;color:gray;">$ '.$row2['catalogue_price'].'</td>
												<tr>
												<tr><td colspan="2" style="font-family:Arial;font-size:10px;color:gray;width:140px;">'.$row2['prod_name'].'</td></tr>
											</table>
										</div>
									</td>
								'.$tr_e.'
			';
			
			$z++;
		}
		
		if ($r3 == 0) $prods .= '			<td colspan="5"></td></tr>';
		if ($r3 == 1) $prods .= '			<td colspan="3"></td></tr>';
		if ($r3 == 2) $prods .= '			<td></td></tr>';
		
		$clears .= '</table>';
		
		$clearance_html = $clears;
		
		/*
		| ---------------------------------------------------------------------
		| Portion of the top links removed for dynamic link used on view and opt out mode
		| See index/newsletter.php and/or manage_newsletter send email process
		*/
		$html .= '
					
					<tr>
						<td id="header" colspan="9" style="font-familyl:Arial;font-size:9px;color:white;text-align:center;background:black;padding:5px 20px;">
							<table id="logo_and_menu" border="0" cellpadding="0" cellspacing="0" width="620">
								<tr>
									<td width="292">
										<a href="www.instylenewyork.com"><img src="'.str_replace('https','http',SITE_URL).'images/instyle_logo.jpg" border="0" width="292" height="47" /></a>
									</td>
									<td width="338" align="right">
										<table border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td align="right" style="font-family:Arial;font-size:10px;"><a href="'.str_replace('https','http',SITE_URL).'apparel.html" style="color:white;" target="_blank"><b>WOMENS APPAREL</b></a></td>
												<td align="right" style="font-family:Arial;font-size:10px;padding:0 3px 0 30px;"><a href="'.str_replace('https','http',SITE_URL).'clearance.html" style="color:white;" target="_blank"><b>CLEARANCE</b></a></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td id="top_banner" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;padding:10px 0 0 0;">
							<img src="'.str_replace('https','http',SITE_URL).'images/newsletters/apps_banner.jpg" border="0" width="620" height="90" />
						</td>
					</tr>
					
					<tr>
						<td colspan="9" class="separator" style="background:#efefef;padding:10px 20px 0 20px;">
							<table border="0" cellpadding="0" cellspacing="0" width="620">
								<tr><td style="font-family:arial;font-size:14px;font-weight:bold;color:white;background:#383838;padding:5px 10px;">
									SHOP THE FINEST IN SPECIAL OCCASSION WEAR
								</td></tr>
							</table>
						</td>
					</tr>

					<tr>
						<td colspan="9" class="thumbs_categories" style="background:#efefef;padding:10px 20px 0 20px;">
							'.$luxury_html.'
						</td>
					</tr>

					<tr>
						<td colspan="9" class="separator" style="background:#efefef;padding:10px 20px 0 20px;">
							<table border="0" cellpadding="0" cellspacing="0" width="620">
								<tr><td style="font-family:arial;font-size:14px;font-weight:bold;color:white;background:#383838;padding:5px 10px;">
									LATEST ARRIVALS
								</td></tr>
							</table>
						</td>
					</tr>

					<tr>
						<td colspan="9" class="thumbs_categories" style="background:#efefef;padding:10px 20px 0 20px;">
							'.$arrival_html.'
						</td>
					</tr>

					<tr>
						<td colspan="9" class="separator" style="background:#efefef;padding:10px 20px 0 20px;">
							<table border="0" cellpadding="0" cellspacing="0" width="620">
								<tr><td style="font-family:arial;font-size:14px;font-weight:bold;color:white;background:#383838;padding:5px 10px;">
									SPECIAL CLEARANCE - DRESSES FROM $120 - $295
								</td></tr>
							</table>
						</td>
					</tr>

					<tr>
						<td colspan="9" class="thumbs_categories" style="background:#efefef;padding:10px 20px 20px 20px;">
							'.$clearance_html.'
						</td>
					</tr>

		';	
		/*
		| ---------------------------------------------------------------------
		| Portion of the bottom links removed for dynamic link used on view and opt out mode
		| See index/newsletter.php and/or manage_newsletter send email process
		*/

		// Used for after saving new created newsletter... a continue button after fisrt viewing
		$cont = '
			<br />
			<CENTER>
				<input type="button" name="btn" value=" Continue.. " onclick="window.location=\''.SITE_URL.'admin/manage_newsletter.php\'">
			</CENTER>
			<br />
		';
		
		if ( ! empty($html))
		{
			@mysql_query("update tbl_newsletter set message='".$html."', imgs='".@$images."' WHERE newsletter_id = '".$n_id."'");
			$n_id = mysql_insert_id();
		}
	}
	
	include 'top.php'; 
?>
<script type="text/javascript" charset="utf-8">
	$(function() {
        var scntDiv = $('#p_scents');
		var proDiv = $('#p_prods');
		var proDiv2 = $('#c_prods');
		
        var i = $('#p_scents p').size() + 2;
		var j = $('#p_prods p').size() + 2;
		var k = $('#c_prods p').size() + 2;

        $('#addScnt').live('click', function() {                
                $('<p>' +
					'Upload Image '+i+':&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
					'<input class="inputbox" type="file" name="image[]" style="margin:2px 0px;"> <span style="color:#ff0000;font-size:9px;">Image size: W=296px H=157px</span><br>' +
					'Item Title '+i+':&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
					'<input class="inputbox" type="text" name="item_title[]" style="width:300px;margin:2px 0px;"><br>' +
					'Item Description '+i+':&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
					'<input class="inputbox" type="text" name="item_desc[]" style="width:300px;margin:2px 0px;"><br>' +
					'Item URL 1:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
					'<input class="inputbox" type="text" name="item_url[]" style="width:300px;margin:2px 0px;"><br>' +
				'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="remScnt">Remove</a><p>').appendTo(scntDiv);
				i++;
                return false;
        });

        $('#remScnt').live('click', function() {
                if( i > 1 ) {
                        $(this).parents('p').remove();
                        i--;
                }
                return false;
        });
		
		
		$('#addProd').live('click', function() {                
                $('<p>' +
					'Product URL '+j+':&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
					'<input class="inputbox" type="text" name="prod_url[]" style="width:300px;margin:2px 0px;"> <a href="#" id="remProd">Remove</a><br>' +
				'<p>').appendTo(proDiv);
				j++;
                return false;
        });

        $('#remProd').live('click', function() {
                if( j > 1 ) {
                        $(this).parents('p').remove();
                        j--;
                }
                return false;
        });
		
		$('#addProd2').live('click', function() {                
                $('<p>' +
					'Product URL '+k+':&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
					'<input class="inputbox" type="text" name="prod_url_clr[]" style="width:300px;margin:2px 0px;"> <a href="#" id="remProd2">Remove</a><br>' +
				'<p>').appendTo(proDiv2);
				k++;
                return false;
        });

        $('#remProd2').live('click', function() {
                if( k > 1 ) {
                        $(this).parents('p').remove();
                        k--;
                }
                return false;
        });
		
});

</script>

<table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor=cccccc>
<tr><td height="333" class="tab" align="center" valign="middle">
	<br />
	
	<!--bof form============================================================================-->
	<form name="category" action="" method="post" enctype="MULTIPART/FORM-data">
	<input type="hidden" name="newsletter_id" value="<?php echo $_GET['n_id']; ?>">
    <table border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="cccccc">
	<tr><td>
	
		<?php if(isset($_POST['add_step2']))
		{
			echo $cont;
			echo '
				<table id="wrapper" border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#333333;">
				<tr><td align="center">
				
					<table id="container" border="0" cellpadding="0" cellspacing="0" width="660" style="background:#efefef;">
						<tr>
							<td id="top_notice" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;background:#333333;padding:10px 20px;">
								If you are unable to see this message, <a href="'.str_replace('https','http',SITE_URL).'newsletter/'.$n_id.'/view" style="color:white;">Click here</a> to view.<br />
								To ensure delivery to your inbox, please add info@instylenewyork.com to your address book. 
							</td>
						</tr>
			';
			echo $html;
			echo '
						<tr>
							<td id="bottom_notice" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;background:#333333;padding:10px 20px 20px 20px;">
								To adjust your email preferences or to unsubscribe from email advertisements from '.SITE_DOMAIN.', please <a href="'.str_replace('https','http',SITE_URL).'newsletter/'.$n_id.'/view" style="color:white;">Click here</a>.<br />
								'.SITE_NAME.', 230 West 38th Street, New York, NY 10018
							</td>
						</tr>
						
					</table> <!--#container-->
				
				</td></tr>
				</table> <!--#wrapper-->
			';
			echo $cont;
		}
		else
		{ ?>
	
		<table border="0" cellspacing="2" cellpadding="2" width="600" align="center" >
			<tr bgcolor=cccccc><td align=center colspan=2><h1>ADD NEWSLETTER - STEP 2 : PRODUCT ENTRIES</h1></td></tr>
			<tr><td align=center colspan=2 class="error"><? echo isset($_GET['err']) ? $_GET['err'] : ''; ?></td></tr>
			<tr>
				<td class="text" colspan="2" style="background:#efefef;padding:3px 0px;"><b>LUXURY SHOPPING BELOW RETAIL PRICING</b></td>
			</tr>
			
			<tr>
				<td class="text" colspan="2">
					<div id="p_scents">
						Upload Image 1:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input class="inputbox" type="file" name="image[]" style="margin:2px 0px;"> <span style="color:#ff0000;font-size:9px;">Image size: W=296px H=157px</span><br>
						Item Title 1:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input class="inputbox" type="text" name="item_title[]" style="width:300px;margin:2px 0px;"><br>
						Item Description 1:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input class="inputbox" type="text" name="item_desc[]" style="width:300px;margin:2px 0px;"><br>
						Item URL 1: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input class="inputbox" type="text" name="item_url[]" style="width:300px;margin:2px 0px;">
					</div>
					<br />
					<a href="#" id="addScnt">[+] Add Another</a>
				</td>
			</tr>
			
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td class="text" colspan="2" style="background:#efefef;padding:3px 0px;"><b>LATEST ARRIVAL</b></td>
			</tr>
			<tr>
				<td class="text" colspan="2">
					<div id="p_prods">
						Product URL 1:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input class="inputbox" type="text" name="prod_url[]" style="width:300px;margin:2px 0px;">
					</div>
					<br />
					<a href="#" id="addProd">[+] Add Another</a>
				</td>
			</tr>
			
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td class="text" colspan="2" style="background:#efefef;padding:3px 0px;"><b>SPECIAL CLEARANCE</b></td>
			</tr>
			<tr>
				<td class="text" colspan="2">
					<div id="c_prods">
						Product URL 1:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input class="inputbox" type="text" name="prod_url_clr[]" style="width:300px;margin:2px 0px;">
					</div>
					<br />
					<a href="#" id="addProd2">[+] Add Another</a>
				</td>
			</tr>
			
			<tr>
				<td width="125">&nbsp;</td>
				<td><br><input type="submit" value=" Save " class=tab name="add_step2"></td>
			</tr>
		</table>
		
		<?php } ?>
		
	</td></tr>
	</table>
    </form>	
	<!--eof form============================================================================-->
	
	<br />
	</td>
</tr>
</table>
<? include 'footer.php'; ?>