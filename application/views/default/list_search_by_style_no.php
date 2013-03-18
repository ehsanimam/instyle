<table border="0" cellspacing="0" cellpadding="0" align="center" style="width:780px;">
<tr>
	<td width="50%" style="padding:0px 0px 15px 10px; vertical-align:top;font-size:12px;color:#999;">
		<?php echo img(array('src'=>base_url().'images/arrow_small.gif','style'=>'margin:0px 2px;')).'<b>Search results for: '.$prod_no_string.'</b>'; ?>
	</td>
	<td width="50%" style="text-align:right;"><?php  //echo $this->pagination->create_links(); ?></td>
</tr>
</table>
<?php
if ($product->num_rows() > 0)
{
	/*
	| ---------------------------------------------------------------------------------
	| The counter $ii limits upto 5 thumbs per row while being float=left.
	| This allows for possible uneven product name rows under each thumb and making
	| the next row aligned horizontally circumventing the float left css property.
	*/
	$ii = 1;
	foreach ($product->result() as $thumb)
	{ ?>
		<div style="width:141px;float:left;margin:2px 0px 15px 15px;">
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr><td colspan="2" style="height:210px;">
			
					<?php
					$cat_id = $thumb->cat_id;
				
					// assign the images
					$img_url		 = base_url().'product_assets/'.$thumb->c_folder.'/'.$thumb->d_folder.'/'.$thumb->sc_folder.'/';
					$img_thumb 	     = $img_url.'product_front/'.$thumb->prod_no.'_'.$thumb->color_code.'.jpg';
					$img_thumb_back  = $img_url.'product_back/'.$thumb->prod_no.'_'.$thumb->color_code.'.jpg';
					$img_thumb_side  = $img_url.'product_side/'.$thumb->prod_no.'_'.$thumb->color_code.'.jpg';
					
					// check images and set default logo where necessary
					if ($img = @GetImageSize($img_thumb))
					{
						$thumbnail = $img_thumb;
						if ($img2 = @GetImageSize($img_thumb_back))
						{
							$back = $img_thumb_back;
						}
						else
						{
							if ($img3 = @GetImageSize($img_thumb_side))
							{
								$back = $img_thumb_side;
							}
							else
							{
								$back = $img_thumb;
							}
						}
					}
					else
					{
						$thumbnail  = base_url().'/images/instylelnylogo.jpg';
						$back  		= base_url().'/images/instylelnylogo.jpg';
					}
					
					$facets  = ! empty($thumb->styles) ? str_replace('-',', ',$thumb->styles).', ' : ''; 
					$facets .= str_replace('-',', ',$thumb->colors);
					
					$alt = $thumb->prod_name.' ( '.trim(strtolower(str_replace(',',', ',$facets))).' )';
					
					/*
					| -------------------------------------------------------------------------------------------
					| The Thumbnail
					*/
					?>
					<div class="fadehover">
					
						<?php
						//$uri_seg1	= $this->set->get_id($this->uri->segment(1)).'/';
						$uri_seg1	= $thumb->c_url_structure.'-'.$thumb->cat_id.'/';
						$uri_seg2	= $thumb->d_url_structure.'-'.$thumb->des_id.'/';
						$uri_seg3	= $thumb->sc_url_structure.'-'.$thumb->subcat_id.'/';
						
						//$segment1		= $thumb->c_url_structure.'-'.$thumb->cat_id.'/';	// cat_id
						$segment1		= $uri_seg1;															// cat_id
						$segment2		= $uri_seg2;															// either des_id or subcat_id
						$segment3		= $uri_seg3;															// either subcat_id or subsubcat_id
						$segment4		= $thumb->prod_no.'/';													// product id
						$segment5		= str_replace(' ','_',strtolower(trim($thumb->ts_color_name))).'/';		// product color
						$segment6		= str_replace('/','-',str_replace(' ','-',$thumb->prod_name)).'.html';	// product name
						
						// This is the image thumb view with links
						?>
						<a href="<?php echo site_url($segment1.$segment2.$segment3.$segment4.$segment5.$segment6); ?>">
							<img class="a" src="<?php echo base_url(); ?>res.php?w=140&h=210&constrain2=1&img=<?php echo $thumbnail; ?>" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" border="0" />
							<img class="b" src="<?php echo base_url(); ?>res.php?w=140&h=210&constrain2=1&img=<?php echo $back; ?>" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" border="0" />
						</a>
					
					</div>
					
				</td></tr>
				<tr>
					<td width="50%" style="text-align:left;">
						<span style="font-size:10px;"><?php echo $thumb->prod_no; ?><span>
					</td>
					<td width="50%" style="text-align:right;">
						<span style="font-size:10px;">
							<?php
							$price = number_format($thumb->catalogue_price,2);
							echo $this->config->item('currency').$price;
							?>
						</span>
					</td>
				</tr>
				<tr><td colspan="2"><?php echo $thumb->prod_name; ?></td></tr>
			</table>
		</div>
		<?php
		if ($ii < 5) $ii++;
		else
		{
			$ii = 1;
			echo '<div style="clear;left;">&nbsp;</div>';
		}
	}
	echo '<div style="clear;left;">&nbsp;</div>';
}
else
{
	echo 'No products return';
}
/*
| -----------------------------------------------------------------------
| Added this breadcrumb and pagination at bottom for easier naviagtion
*/
?>
<table border="0" cellspacing="0" cellpadding="0" align="center" style="width:780px;">
<tr>
	<td width="50%" style="padding:0px 0px 15px 10px; vertical-align:top;font-size:12px;color:#999;">
	</td>
	<td width="50%" style="text-align:right;"><?php //echo $this->pagination->create_links(); ?></td>
</tr>
</table>
