<table border="0" cellspacing="0" cellpadding="0" align="center" style="width:780px;">
<tr>
	<td width="50%" style="padding:0px 0px 15px 10px; vertical-align:top;font-size:12px;color:#999;">
	<?php 
	/*
	| -----------------------------------------
	| Modified breadcrumb by Verjel 09/20/2011
	| -----------------------------------------
	*/
	if ($product->num_rows() > 0)
	{
		echo generate_breadcrumb($prod);
	}
	?>
	</td>
	<td width="50%" style="text-align:right;"><?php  echo $this->pagination->create_links(); ?></td>
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
					$faceted_search = explode('-',$this->uri->segment(1));
				
					// edit this line for faceted search
					if (in_array('facets',$faceted_search))
					{
						$get_color = explode('-',rtrim($this->uri->segment(3),'.html'));
					
						$val_url = base_url().'product_assets/'.$thumb->cat_folder.'/'.$thumb->folder.'/'.$thumb->subcat_folder.'/';
					
						foreach ($get_color as $gc)
						{
							$get_col   = $this->db->get_where('tblcolor',array('color_name'=>$gc));
							$get_col   = @$get_col->row();					
							$col_code  = @$get_col->color_code;
							
							$front = $val_url.'product_front/'.$thumb->prod_no.'_'.$col_code.'.jpg';
							if($img = @GetImageSize($front)) {
								$primary_img_id = $get_col->color_code;
								$color_name		= $get_col->color_name;
							} else {
								$primary_img_id = $thumb->primary_img_id;
								$color_name		= $thumb->color_name;
							}
							
						}
					}
					else
					{
						$primary_img_id = $thumb->primary_img_id;
						$color_name		= $thumb->color_name;
					}
				
					$cat_id = $thumb->cat_id;
				
					// assign the primary images
					$img_url		 = base_url().'product_assets/'.$thumb->cat_folder.'/'.$thumb->folder.'/'.$thumb->subcat_folder.'/';
					$img_thumb 	     = $img_url.'product_front/'.$thumb->prod_no.'_'.@$primary_img_id.'.jpg';
					$img_thumb_back  = $img_url.'product_back/'.$thumb->prod_no.'_'.@$primary_img_id.'.jpg';
					$img_thumb_side  = $img_url.'product_side/'.$thumb->prod_no.'_'.@$primary_img_id.'.jpg';
					
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
					
					$facets = str_replace('-',',',$thumb->colors).',';
					$facets .= ! empty($thumb->styles) ? str_replace('-',',',$thumb->styles) : '';
					
					$alt = $thumb->prod_name.' ( '.trim(strtolower(str_replace(',',', ',$facets))).' )';
					
					/*
					| -------------------------------------------------------------------------------------------
					| The Thumbnail
					*/
					?>
					<div class="fadehover">
					
						<?php
						//$uri_seg1	= $this->set->get_id($this->uri->segment(1)).'/';
						$uri_seg1	= $this->uri->segment(1).'/';
						$uri_seg2	= $thumb->des_url_structure.'-'.$thumb->des_id.'/';
						$uri_seg3	= $thumb->sc_url_structure.'-'.$thumb->subcat_id.'/';
						
						//$segment1		= $thumb->c_url_structure.'-'.$thumb->cat_id.'/';	// cat_id
						$segment1		= $uri_seg1;															// cat_id
						$segment2		= $uri_seg2;															// either des_id or subcat_id
						$segment3		= $uri_seg3;															// either subcat_id or subsubcat_id
						$segment4		= $thumb->prod_no.'/';													// product id
						$segment5		= str_replace(' ','_',strtolower(trim($color_name))).'/';				// product color
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
					<?php
					/*
					| -------------------------------------------------------------------------------------------
					| The Product No, Pricing, and Product Name
					*/
					?>
					<td width="50%" style="text-align:left;">
						<span style="font-size:10px;"><?php echo $thumb->prod_no; ?><span>
					</td>
					<td width="50%" style="text-align:right;">
						<span style="font-size:10px;">
							<?php
							if ($this->session->userdata('user_cat') == 'wholesale') $price = number_format($thumb->wholesale_price,2);
							else $price = number_format($thumb->catalogue_price,2);
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
	<?php 
	/*
	| -----------------------------------------
	| Modified breadcrumb by Verjel 09/20/2011
	| -----------------------------------------
	*/
	if ($product->num_rows() > 0)
	{
		echo generate_breadcrumb($prod);
	}		
	?>
	</td>
	<td width="50%" style="text-align:right;"><?php echo $this->pagination->create_links(); ?></td>
</tr>
</table>
