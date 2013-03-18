<?php
if ($product->num_rows() > 0)
{
	$i = 1;
	foreach ($product->result() as $thumb)
	{
		if ($i == 1) echo '<div style="width:140px;float:left;margin:2px 0px 20px 2px;">';
		else echo '<div style="width:140px;float:left;margin:2px 0px 20px 26px;">';
		?>
		
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr><td colspan="2" style="height:210px;">
		
			<?php
			$cat_id = $thumb->cat_id;
			
			$img_url		 = base_url().'product_assets/'.$thumb->cat_folder.'/'.$thumb->folder.'/'.$thumb->subcat_folder.'/';
			$img_thumb 	     = $img_url.'product_front/'.$thumb->prod_no.'_'.$thumb->primary_img_id.'.jpg';
			$img_thumb_back  = $img_url.'product_back/'.$thumb->prod_no.'_'.$thumb->primary_img_id.'.jpg';
			$img_thumb_side  = $img_url.'product_side/'.$thumb->prod_no.'_'.$thumb->primary_img_id.'.jpg';
			
			//die($img_thumb_back);
			if($img = @GetImageSize($img_thumb)) {
				$thumbnail = $img_thumb;
					if($img2 = @GetImageSize($img_thumb_back)) {
						$back = $img_thumb_back;
					} else {
						if($img3 = @GetImageSize($img_thumb_side)) {
							$back = $img_thumb_side;
						} else {
							$back = $img_thumb;
						}
					}
			} else {
				$thumbnail  = base_url().'/images/instylelnylogo.jpg';
				$back  		= base_url().'/images/instylelnylogo.jpg';
			}
			
			$alt = $thumb->prod_name.'-'.$thumb->prod_no;
			
			$segment1		= $thumb->c_url_structure.'-'.$thumb->cat_id.'/';		// cat_id
			$segment2		= $thumb->des_url_structure.'-'.$thumb->des_id.'/';		// either des_id or subcat_id
			$segment3		= $thumb->sc_url_structure.'-'.$thumb->subcat_id.'/';	// either subcat_id or subsubcat_id
			$segment4		= $thumb->prod_no.'/';									// product id
			$segment5		= strtolower(trim($thumb->color_name)).'/';					// primary image
			$segment6		= str_replace('/','-',str_replace(' ','-',$thumb->prod_name)).'.html';		// primary img color	
			?>
			
			<div class="fadehover">
				<a href="<?php echo str_replace('https','http',site_url($segment1.$segment2.$segment3.$segment4.$segment5.$segment6)); ?>">
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
			</td></tr>
		</table>
		</div>
		<?php
		$i++;
	}
	echo '<div style="clear;left;">&nbsp;</div>';
} else {
	echo 'No products return';
}
?>