<table border="0" cellspacing="0" cellpadding="0" align="center" style="width:780px;">
<tr>
	<td style="padding:0px 0px 15px 10px; vertical-align:top;font-size:12px;color:#999;">
	<?php 
	/*
	| -----------------------------------------
	| Modified breadcrumb by Verjel 09/20/2011
	| -----------------------------------------
	*/
	if ($view_pane_sql->num_rows() > 0)
	{
		echo generate_breadcrumb($view_pane_sql->row());
	}
	?>
	</td>
	<td style="text-align:right;">
	
		<?php
		/*
		$view_mode_link_styles = 'font-size:12px;border:1px solid #996600;padding:2px 5px;visibility:hidden;';
		<a href="javascript:void(0);" id="view_mode_link_text_top" style="<?php echo $view_mode_link_styles; ?>" onclick="change_view_mode()">View items in runway mode</a>
		*/
		?>
		
		<?php echo $this->pagination->create_links(); ?>
		
	</td>
</tr>
</table>
<?php
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
					$img_thumb 	    = $img_url.'product_front/'.$thumb->prod_no.'_'.$thumb->color_code.'.jpg';
					$img_thumb_back = $img_url.'product_back/'.$thumb->prod_no.'_'.$thumb->color_code.'.jpg';
					$img_thumb_side = $img_url.'product_side/'.$thumb->prod_no.'_'.$thumb->color_code.'.jpg';
					$img_video 	    = $img_url.'product_video/'.$thumb->prod_no.'_'.$thumb->color_code.'.flv';
					
					// check images and set default logo where necessary
					if ($img = @GetImageSize(PROD_IMG_URL.$img_thumb))
					{
						$thumbnail = PROD_IMG_URL.$img_thumb;
						if ($img2 = @GetImageSize(PROD_IMG_URL.$img_thumb_back))
						{
							$back = PROD_IMG_URL.$img_thumb_back;
						}
						else
						{
							if ($img3 = @GetImageSize(PROD_IMG_URL.$img_thumb_side))
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
						$thumbnail  = PROD_IMG_URL.'images/instylelnylogo.jpg';
						$back  		= PROD_IMG_URL.'images/instylelnylogo.jpg';
					}
					
					$facets = str_replace('-',',',$thumb->colors).',';
					$facets .= ! empty($thumb->styles) ? str_replace('-',',',$thumb->styles) : '';
					
					$alt = $thumb->prod_name.' ( '.trim(strtolower(str_replace(',',', ',$facets))).' )';
					
					// The link for the product thumb click through
					$seg1 = $thumb->d_url_structure.'/';
					$seg2 =	$thumb->prod_no.'/';
					$seg3 =	str_replace(' ','-',strtolower(trim($color_name))).'/';
					$seg4 = str_replace(' ','-',strtolower(trim($thumb->prod_name)));
					$seg = $seg1 . $seg2 . $seg3 . $seg4;
					$seg_video = $seg . '/runway-video';
					
					/*
					| -------------------------------------------------------------------------------------------
					| The Thumbnail
					*/
					?>
					<div class="fadehover" style="width:140px;height:210px;">
					
						<!--placeholder for product images with fadehover effect-->
						<a href="<?php echo site_url($seg); ?>" style="z-index:10;">
							<img class="a" src="<?php echo base_url(); ?>res.php?w=140&h=210&constrain2=1&img=<?php echo $thumbnail; ?>" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" border="0" />
							<img class="b" src="<?php echo base_url(); ?>res.php?w=140&h=210&constrain2=1&img=<?php echo $back; ?>" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" border="0" />
						</a>
						
						<?php
						/*
						<!--placeholder for video playback of product video-->
						<div id="runway_mode_player_<?php echo $i_thumb; ?>" style="position:absolute;left:0px;width:140px;height:210px;visibility:hidden;"></div>
						
						<script type="text/javascript">
							flowplayer('runway_mode_player_<?php echo $i_thumb; ?>', {src: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer-3.2.7.swf", wmode: "opaque"}, {
								clip: {
									url: "<?php echo PROD_IMG_URL.$img_video; ?>",
									// cancel the default behavior upon finish
									onBeforeFinish: function() {
										return false;
									}
								},
								onMouseOver: function() {
									$( "#dialog_runway_video_<?php echo $i_thumb; ?>" ).dialog( "open" );
								},
								// remove controls shown at start, add transparent content for mouse click purposes, and some other event listeners
								plugins: {
									controls: null,
									content: {
										url: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer.content-3.2.0.swf",
										top: 0,
										left: 0,
										width: 140,
										height: 210,
										opacity: 0.1,
										backgroundGradient: 'low',
										onClick: function() {
											window.location.href = '<?php echo site_url($seg_video); ?>';
										}
									}
								},
								// remove video on current player div on error specially '200 - No stream found'
								onError: function() {
									document.getElementById('runway_mode_player_<?php echo $i_thumb; ?>').style.display = 'none';
								}
							});
						</script>
						*/
						?>
						
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
				<tr><td colspan="2"><?php echo $thumb->prod_name.' ('.$color_name.')'; ?></td></tr>
			</table>
		</div>
		
		<?php
		/*
		<div id="dialog_runway_video_<?php echo $i_thumb; ?>" title="Large View of Runway Video" style="display:none;">
		
			<!--placeholder for video playback of product video-->
			<div id="large_runway_video_player_<?php echo $i_thumb; ?>" class="runway_mode_player" style="width:340px;height:510px;"></div>
			
		</div>
		
		<script type="text/javascript">
			// add jscript for popup video runway mode
			$( "#dialog_runway_video_<?php echo $i_thumb; ?>" ).dialog({
				autoOpen: false,
				show: "blind",
				hide: "explode",
				width: 362,
				modal: true,
				draggable: false,
				dialogClass: "dialog_runway_video",
				resizable: false,
				position: "center"
			});
			
			flowplayer('large_runway_video_player_<?php echo $i_thumb; ?>', {src: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer-3.2.7.swf", wmode: "opaque"}, {
				clip: {
					url: "<?php echo PROD_IMG_URL.$img_video; ?>",
					// cancel the default behavior upon finish
					onBeforeFinish: function() {
						return false;
					}
				},
				// remove controls shown at start, add transparent content for mouse click purposes, and some other event listeners
				plugins: {
					controls: null,
					content: {
						url: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer.content-3.2.0.swf",
						top: 0,
						left: 0,
						width: 340,
						height: 510,
						opacity: 0.1,
						backgroundGradient: 'low',
						onClick: function() {
							window.location.href = '<?php echo site_url($seg_video); ?>';
						}
					}
				}
			});
		</script>
		*/
		?>
		
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
	<td style="padding:0px 0px 15px 10px; vertical-align:top;font-size:12px;color:#999;">
	<?php 
	/*
	| -----------------------------------------
	| Modified breadcrumb by Verjel 09/20/2011
	| -----------------------------------------
	*/
	if ($view_pane_sql->num_rows() > 0)
	{
		echo generate_breadcrumb($view_pane_sql->row());
	}
	?>
	</td>
	<td style="text-align:right;">
		
		<?php
		/*
		$view_mode_link_styles = 'font-size:12px;border:1px solid #996600;padding:2px 5px;visibility:hidden;';
		<a href="javascript:void(0);" id="view_mode_link_text_btm" style="<?php echo $view_mode_link_styles; ?>" onclick="change_view_mode()">View items in runway mode</a>
		*/
		?>
		
		<?php echo $this->pagination->create_links(); ?>
		
	</td>
</tr>
</table>

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
