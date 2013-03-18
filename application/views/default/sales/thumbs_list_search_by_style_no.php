<table border="0" cellspacing="0" cellpadding="0" align="center" style="width:780px;">
<tr>
	<td width="50%" style="padding:0px 0px 15px 10px; vertical-align:top;font-size:12px;color:#999;">
		<?php echo img(array('src'=>base_url().'images/arrow_small.gif','style'=>'margin:0px 2px;')).'<b>Search results for: '.$prod_no_string.'</b>'; ?>
	</td>
	<td width="50%" style="text-align:right;">
	
		<?php
		/*
		$view_mode_link_styles = 'font-size:12px;border:1px solid #996600;padding:2px 5px;visibility:hidden;';
		<a href="javascript:void(0);" id="view_mode_link_text_top" style="<?php echo $view_mode_link_styles; ?>" onclick="change_view_mode()">View items in runway mode</a>
		*/
		?>
		
		<?php //echo $this->pagination->create_links(); ?>
		
	</td>
</tr>
</table>
<?php
// -----------------------------------------
// --> Set check for items already in cart
foreach ($this->cart->contents() as $content):
	$checked[$content['id']] = 'checked="checked"';
endforeach;


if ($view_pane_sql->num_rows() > 0)
{
	/*
	| ---------------------------------------------------------------------------------
	| The counter $i_thumb is to differentiate tag id's for all thumbs
	| The counter $ii limits upto 5 thumbs per row while being float=left.
	| The counter $ii allows for possible uneven product name rows under each thumb and making
	| the next row aligned horizontally circumventing the float left css property.
	*/
	$ii = 1;
	$i_thumb = 1;
	foreach ($view_pane_sql->result() as $thumb)
	{ ?>
		<div style="width:141px;float:left;margin:2px 0px 15px 15px;">
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr><td colspan="2" style="height:210px;">
			
					<?php
					$primary_img_id = $thumb->primary_img_id;
					$color_name		= $thumb->color_name;
				
					$cat_id = $thumb->cat_id;
				
					// assign the primary images
					$img_url		= 'product_assets/'.$thumb->cat_folder.'/'.$thumb->folder.'/'.$thumb->subcat_folder.'/';
					$img_thumb 	    = $img_url.'product_front/thumbs/'.$thumb->prod_no.'_'.$thumb->color_code.'_1.jpg';
					$img_thumb_back = $img_url.'product_back/thumbs/'.$thumb->prod_no.'_'.$thumb->color_code.'_1.jpg';
					$img_thumb_side = $img_url.'product_side/thumbs/'.$thumb->prod_no.'_'.$thumb->color_code.'_1.jpg';
					$img_video 		= $img_url.'product_video/'.$thumb->prod_no.'_'.$thumb->color_code.'.flv';
					
					// check images and set default logo where necessary
					$local_path = 'D:\www\joetaveras\instylenewyork\httpdocs\\';
					$img = ENVIRONMENT == 'development' ? @GetImageSize($local_path.$img_thumb) : @GetImageSize(PROD_IMG_URL.$img_thumb);
					$img2 = ENVIRONMENT == 'development' ? @GetImageSize($local_path.$img_thumb_back) : @GetImageSize(PROD_IMG_URL.$img_thumb_back);
					$img3 = ENVIRONMENT == 'development' ? @GetImageSize($local_path.$img_thumb_side) : @GetImageSize(PROD_IMG_URL.$img_thumb_side);
					if ($img)
					{
						$thumbnail = PROD_IMG_URL.$img_thumb;
						if ($img2)
						{
							$back = PROD_IMG_URL.$img_thumb_back;
						}
						else
						{
							if ($img3)
							{
								$back = PROD_IMG_URL.$img_thumb_side;
							}
							else
							{
								$back = PROD_IMG_URL.$img_thumb;
							}
						}
					}
					else
					{
						$thumbnail  = PROD_IMG_URL.'images/instylelnylogo_1.jpg';
						$back  		= PROD_IMG_URL.'images/instylelnylogo_1.jpg';
					}
					
					$facets = str_replace('-',',',$thumb->colors).',';
					$facets .= ! empty($thumb->styles) ? str_replace('-',',',$thumb->styles) : '';
					
					$alt = $thumb->prod_name.' ( '.trim(strtolower(str_replace(',',', ',$facets))).' )';
					
					// The link for the product line sheet image
					$seg = 'product_assets/'.$thumb->cat_folder.'/'.$thumb->folder.'/'.$thumb->subcat_folder.'/product_linesheet/';
					
					/*
					| -------------------------------------------------------------------------------------------
					| The Thumbnail
					*/
					?>
					<div id="<?php echo $thumb->prod_no.'_'.$thumb->color_code; ?>" class="fadehover" style="width:140px;height:210px;">
					
						<?php
						/*
						| ---------------------------
						| New display of thumbs using resized image at product_<view>/thumbs fodler
						| Image name ending in '_1'
						| Using fancybox to popup product line sheet image
						*/
						$href_text = base_url($seg.$thumb->prod_no.'_'.$thumb->color_code.'.jpg');
						if (file_exists($seg.$thumb->prod_no.'_'.$thumb->color_code.'.jpg'))
						{
							// with product line image
							$class_text = 'sa_thumbs_group';
							$java_01 = '';
							?>
							
							<!--placeholder for product images with fadehover effect-->
							<a class="<?php echo $class_text; ?>" href="<?php echo $class_text != '' ? $href_text : 'javascript:void();' ; ?>" style="z-index:10;" <?php echo $java_01; ?>>
								<img class="a" src="<?php echo $thumbnail; ?>" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" border="0" />
								<img class="b" src="<?php echo $back; ?>" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" border="0" />
							</a>
						
							<?php
						}
						/*
						else
						{
							// if no product line sheet image yet
							$class_text = '';
							$java_01 = 'onclick="alert(\'Product has no line sheet image yet.\');"';
						}
						*/
						?>
						
					</div>
					
				</td></tr>
				<tr><td colspan="2">
					<?php
					/*
					| ---------------------------
					| The selection check box
					*/
					
					// -----------------------------------------
					// --> Summary of info needed to include in the check box value.
					$value = $thumb->prod_no.'='.$thumb->color_code.'='.$thumb->prod_name.'='.$thumb->wholesale_price.'='.$thumb->colors.'='.$thumb->color_name.'='.$img_url;
					
					// -----------------------------------------
					// --> Check if item is already in cart and check it
					$item_id = $thumb->prod_no.'_'.$thumb->color_code;
					?>
					<span style="color:red;">Add To Sales Package</span> <input type="checkbox" name="package_item[]" id="<?php echo $value; ?>" value="<?php echo $value; ?>" style="float:right;" <?php echo isset($checked[$item_id]) ? $checked[$item_id] : ''; ?> onclick="sa_add_to_cart('<?php echo site_url('sa/update_cart'); ?>', '<?php echo $value; ?>');" />
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
							$price = number_format($thumb->wholesale_price,2);
							echo $this->config->item('currency').$price;
							?>
						</span>
					</td>
				</tr>
				<tr><td colspan="2"><?php echo $thumb->prod_name.'<br />('.$color_name.')'; ?></td></tr>
			</table>
		</div>
		
		<?php
		if ($ii < 5) $ii++;
		else
		{
			$ii = 1;
			echo '<div style="clear:both;">&nbsp;</div>';
		}
		$i_thumb++;
	}
	echo '<div style="clear:both;">&nbsp;</div>';
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
	<td width="50%" style="padding:0px 0px 15px 10px; vertical-align:top;font-size:12px;color:#999;"></td>
	<td width="50%" style="text-align:right;"></td>
</tr>
<tr>
	<td colspan="2">
		<?php //print_r($this->cart->contents()); // --> for debugging purposes ?>
	</td>
</tr>
</table>

<?php
if ($file != 'page')
{
	echo form_close();
	echo '<!--eof form==================================================================================-->';
}
?>
	
	<!-- Place this javascript function for the runway veiw mode -->
	<script type="text/javascript">

		var thumbs_view_mode;
		function change_view_mode()
		{
			if (thumbs_view_mode == 1)
			{
				for(i_thumb = 1; i_thumb < <?php echo $i_thumb; ?>; i_thumb++)
				{
					document.getElementById('runway_mode_player_'+i_thumb).style.zIndex = "0";
				}
				document.getElementById('view_mode_link_text_top').innerHTML = "View items in runway mode";
				document.getElementById('view_mode_link_text_btm').innerHTML = "View items in runway mode";
				thumbs_view_mode = 0;
			}
			else
			{
				for(i_thumb = 1; i_thumb < <?php echo $i_thumb; ?>; i_thumb++)
				{
					document.getElementById('runway_mode_player_'+i_thumb).style.zIndex = "50";
				}
				document.getElementById('view_mode_link_text_top').innerHTML = "View items in photo mode";
				document.getElementById('view_mode_link_text_btm').innerHTML = "View items in photo mode";
				thumbs_view_mode = 1;
			}
		}
		
	</script>
