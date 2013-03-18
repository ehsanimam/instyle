<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0px 25px 0px;">
	<?php
	/*
	| ------------------------------------------------------------------------------------
	| Bread crumbs
	*/
	?>
	<tr>
		<td colspan="2" style="padding: 5px 0 15px;">
		<?php 
		// breadcrumb; 
		$des 	= explode('-',$this->uri->segment(1));
		$bread  = explode('/',get_full_breadcrumb_url());
		$count = count($bread);
		
		$ary_new_clearance = array('New Arrival','new arrival','Clearance','clearance','Yes','yes','Y','y');
		if (in_array($product->new_arrival,$ary_new_clearance) && ($this->uri->segment(1) == 'new-arrival' OR $this->uri->segment(1) == 'new-arrival-designer'))
		{
			echo anchor($this->uri->segment(1).'.html',$product->cat_name).nbs(2).'/'.nbs(2);
			echo anchor('new-arrival-designer/'.$this->uri->segment(2).'.html',$product->designer).nbs(2).'/'.nbs(2);
			echo anchor($this->uri->segment(1).'/'.($this->uri->segment(1) == 'new-arrival-designer' ? $this->uri->segment(2).'/' : '').$this->uri->segment(3).'.html',$product->subcat_name).nbs(2).'/'.nbs(2);
			echo '<b>'.$product->prod_name.'</b>'.nbs(2).'/'.nbs(2);
			echo ucfirst(strtolower($this->uri->segment(5)));
			
			// assign $des_url for 'send to friend' link back use
			$des_url = 'new-arrival-designer/'.$this->uri->segment(2).'.html';
		}
		elseif (in_array($product->clearance,$ary_new_clearance))
		{
			echo anchor($this->uri->segment(1).'.html',$product->cat_name).nbs(2).'/'.nbs(2);
			echo anchor('clearance-designer/'.$this->uri->segment(2).'.html',$product->designer).nbs(2).'/'.nbs(2);
			echo anchor($this->uri->segment(1).'/'.($this->uri->segment(1) == 'clearance-designer' ? $this->uri->segment(2).'/' : '').$this->uri->segment(3).'.html',$product->subcat_name).nbs(2).'/'.nbs(2);
			echo '<b>'.$product->prod_name.'</b>'.nbs(2).'/'.nbs(2);
			echo ucfirst(strtolower($this->uri->segment(5)));
			
			// assign $des_url for 'send to friend' link back use
			$des_url = 'clearance-designer/'.$this->uri->segment(2).'.html';
		}
		else
		{
			// set params for bread crumbs
			$url1 = $this->set->get_caturl($product->cat_id);
			$row1 = $url1->row_array();
			$c_url_structure = $row1['url_structure'];
			
			$url2 = $this->set->get_subcaturl($product->subcat_id);
			$row2 = $url2->row_array();
			$sc_url_structure = $row2['url_structure'];

			// breadcrumbs
			echo anchor($c_url_structure, $product->cat_name).nbs(2).'/'.nbs(2); // ----> bread 1 - category
			echo anchor($this->uri->segment(1).'/'.$sc_url_structure, $product->designer).nbs(2).'/'.nbs(2); // ----> bread 2 - designer
			echo anchor($this->uri->segment(1).'/'.$sc_url_structure, $product->subcat_name).nbs(2).'/'.nbs(2); // ----> bread 3 - subcat
			echo '<b>'.ucwords($this->uri->segment(3)).' '.$product->prod_name.'</b>'.nbs(2); // ----> bread 4 - prod name
			//echo '/'.nbs(2).ucfirst(strtolower(trim($this->uri->segment(5)))); // ----> seg5 - color
			
			// assign $des_url for 'send to friend' link back use
			$des_url = uri_string();
		} ?>
		</td>
	</tr>
	<?php
	/*
	| ------------------------------------------------------------------------------------
	| Content of product detail
	*/
	?>
	<tr>
		<td rowspan="2" style="position:relative;width:340px;height:510px;padding: 0 15px 3px 0;">
			<?php
			/*
			| ------------------------------------------------------------------------------------
			| Left side large iamge view of product first column - (spans two (2) rows)
			*/
			if ($product->color_name == '')
			{
				$color_code = $product->primary_img_id;
			}
			else
			{
				$color_code = $product->color_code;
			}
			
			$img_path 			= 'product_assets/'.$product->c_folder.'/'.$product->d_folder.'/'.$product->sc_folder.'/';
			$img_name 			= $product->prod_no.'_'.$color_code;
			
			$img_large			= PROD_IMG_URL.$img_path.'product_front/'.$img_name.'.jpg';
			$img_thumb			= PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_3.jpg';
			
			$img_front			= PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_2.jpg';
			$img_side			= PROD_IMG_URL.$img_path.'product_side/thumbs/'.$img_name.'_2.jpg';
			$img_back			= PROD_IMG_URL.$img_path.'product_back/thumbs/'.$img_name.'_2.jpg';
			
			$img_front_thumb	= PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_3.jpg';
			$img_side_thumb		= PROD_IMG_URL.$img_path.'product_side/thumbs/'.$img_name.'_3.jpg';
			$img_back_thumb		= PROD_IMG_URL.$img_path.'product_back/thumbs/'.$img_name.'_3.jpg';

			$img_front_large	= PROD_IMG_URL.$img_path.'product_front/'.$img_name.'.jpg';
			$img_side_large		= PROD_IMG_URL.$img_path.'product_side/'.$img_name.'.jpg';
			$img_back_large		= PROD_IMG_URL.$img_path.'product_back/'.$img_name.'.jpg';

			// The image as link -----------------------------------------------------------------
			// Set zoomWitdh and zoomHeight to '0' to remove zoom window else set as is
			?>
			<div style="position:relative;">
			
				<!--placeholder for image of product with cloudzoom effect-->
				<a href="<?php echo $img_large; ?>" id="zoom1" class="cloud-zoom" rel="zoomWidth:635,zoomHeight:508,adjustX:-1,adjustY:0">
					<img src="<?php echo $img_thumb; ?>" alt="<?php echo $product->prod_desc; ?>" border="0" />
				</a>
				
				<?php
				/*
				| -----------------
				| code changed to above to accomodate the resized thumbs
				<!--placeholder for image of product with cloudzoom effect-->
				<a href="<?php echo $img_large; ?>" id="zoom1" class="cloud-zoom" rel="zoomWidth:635,zoomHeight:508,adjustX:-1,adjustY:0">
					<img src="<?php echo base_url(); ?>res.php?w=340&h=510&constrain2=1&img=<?php echo $img_thumb; ?>" alt="<?php echo $product->prod_desc; ?>" border="0" />
				</a>
				*/
				?>
				
				<!--placeholder for video playback of product-->
				<div id="zoom_player" style="position:absolute;left:0px;top:0px;width:340px;height:510px;"></div>
				
				<?php
				/*
				| ------------------------------------------------------------------------------------
				| This is code snippet to be able to utilize a javascript to show the other colors
				| avalable for the product number. Both color links and color swatch links will
				| show the respective product_front image of the prod_no.
				|
				| Because we need to load all colors, will not be using $img_thumb for this but rather
				| the raw data from the query which is also used for the color links and swatches
				*/
				$get_color_list = $this->query_category->get_available_colors($product->prod_no);
			
				if ($get_color_list->num_rows() > 0)
				{
					foreach ($get_color_list->result() as $color)
					{
						if ($color->color_code == $color_code)
						{
							$id1 = $product->prod_no.'_'.$color->color_code;
							$id5 = $product->prod_no.'_'.$color->color_code.'_side';
							$id6 = $product->prod_no.'_'.$color->color_code.'_back';
							$java1 = '';
							$java2 = '';
							$style = "visibility:hidden;z-index:10000;";
						}
						else
						{
							$id1 = $product->prod_no.'_'.$color->color_code;
							$id5 = $product->prod_no.'_'.$color->color_code.'_side';
							$id6 = $product->prod_no.'_'.$color->color_code.'_back';
							$java1 = "cancelclosetime(); document.getElementById('zoom_player').style.visibility='hidden';";
							$java2 = "closetime(); document.getElementById('zoom_player').style.visibility='visible';";
							$style = "visibility:hidden;z-index:10000;";
						}
						?>
						<div class="mouseoverdiv" id="<?php echo $id1; ?>" style="<?php echo $style; ?>">
							<div style="position:relative;">
								<?php
								$image = PROD_IMG_URL.$img_path.'product_front/thumbs/'.$product->prod_no.'_'.$color->color_code.'_3';
								//echo anchor($img_path.'product_front/thumbs/'.$product->prod_no.'_'.$color->color_code.'_3.jpg', img(array('src'=>$image.'.jpg','border'=>'0','alt'=>$product->prod_desc,'title'=>'')), array('onmouseover'=>$java1,'onmouseout'=>$java2));
								?>
							</div>
							<a href="<?php echo $img_path.'product_front/thumbs/'.$product->prod_no.'_'.$color->color_code.'_3.jpg'; ?>" onmouseover="<?php echo $java1; ?>" onmouseout="<?php echo $java2; ?>">
								<img src="<?php echo $image.'.jpg'; ?>" border="0" alt="<?php echo $product->prod_desc; ?>" title=""/>
							</a>
						</div>
						<div class="mouseoverdiv" id="<?php echo $id5; ?>" style="<?php echo $style; ?>">
							<div style="position:relative;">
								<?php
								$image = PROD_IMG_URL.$img_path.'product_side/thumbs/'.$product->prod_no.'_'.$color->color_code.'_3';
								//echo anchor($img_path.'product_side/thumbs/'.$product->prod_no.'_'.$color->color_code.'_3.jpg', img(array('src'=>$image.'.jpg','border'=>'0','alt'=>$product->prod_desc,'title'=>'')), array('onmouseover'=>$java1,'onmouseout'=>$java2));
								?>
								<a href="<?php echo $img_path.'product_side/thumbs/'.$product->prod_no.'_'.$color->color_code.'_3.jpg'; ?>" onmouseover="<?php echo $java1; ?>" onmouseout="<?php echo $java2; ?>">
									<img src="<?php echo $image.'.jpg'; ?>" border="0" alt="<?php echo $product->prod_desc; ?>" title=""/>
								</a>
							</div>
						</div>
						<div class="mouseoverdiv" id="<?php echo $id6; ?>" style="<?php echo $style; ?>">
							<div style="position:relative;">
								<?php
								$image = PROD_IMG_URL.$img_path.'product_back/thumbs/'.$product->prod_no.'_'.$color->color_code.'_3';
								//echo anchor($img_path.'product_back/thumbs/'.$product->prod_no.'_'.$color->color_code.'_3.jpg', img(array('src'=>$image.'.jpg','border'=>'0','alt'=>$product->prod_desc,'title'=>'')), array('onmouseover'=>$java1,'onmouseout'=>$java2));
								?>
								<a href="<?php echo $img_path.'product_back/thumbs/'.$product->prod_no.'_'.$color->color_code.'_3.jpg'; ?>" onmouseover="<?php echo $java1; ?>" onmouseout="<?php echo $java2; ?>">
									<img src="<?php echo $image.'.jpg'; ?>" border="0" alt="<?php echo $product->prod_desc; ?>" title=""/>
								</a>
							</div>
						</div>
						<?php
					}
				}
			?>
			
			</div>
		</td>
		<td>
			<?php
			/*
			| ------------------------------------------------------------------------------------
			| Right side content detail view
			| ------------------------------------------------------------------------------------
			*/
			echo $this->session->flashdata('flashMsg'); ?>
			<?php
			/*
			| ------------------------------------------------------------------------------------
			| Product Number
			*/
			?>
			<div class="prdno" id="click_div"><?php echo $product->prod_no; ?></div>
			<?php
			/*
			| ------------------------------------------------------------------------------------
			| Product  Name
			*/
			?>
			<div class="prdname"><?php echo strtoupper($product->prod_name); ?></div>
			<?php
			/*
			| ------------------------------------------------------------------------------------
			| Price
			*/
			if ($this->session->userdata('user_cat') == 'wholesale') $price = number_format($product->wholesale_price,2);
			else $price = number_format($product->catalogue_price,2);
			?>
			<span class="prdname1"><?php echo ($this->session->userdata('user_cat') == 'wholesale') ? 'WHOLESALE PRICE:' : 'PRICE:'; ?> <?php echo $this->config->item('currency'); ?><?php echo $price; ?></span>
			<br />			
			<?php
			/*
			| ------------------------------------------------------------------------------------
			| MSRP Price displayed at clearance only
			*/
			$ary_clear = array('Clearance','clearance','Yes','yes','Y','y');
			if(in_array($product->clearance,$ary_clear))
			{ ?>
				<span class="prdname1">MSRP RETAIL: </span><strike><span class="retail"><?php echo $this->config->item('currency'); ?><?php echo number_format($product->less_discount,2); ?></span></strike>
				<br />
				<?php
			} ?>
			<br />
			<?php
			/*
			| ------------------------------------------------------------------------------------
			| Color Name
			*/
			?>
			<div id="paginate-slider1">
			
				<div class="prdname">
					AVAILABLE COLORS: &nbsp; &nbsp;
					<span class="style1">
						<?php
						//$url 	   = explode('/',get_full_breadcrumb_url());
						$url	   = explode('/',uri_string());
						$uri_count = count($url)-2;
						
						for ($i = 0; $i < $uri_count; $i++)
						{
							@$new_url .= $url[$i].'/';
						}
						
						if ($get_color_list->num_rows() > 0)
						{
							$i = 0;
							foreach ($get_color_list->result() as $color)
							{
								$id2 = $product->prod_no.'_'.$color->color_code;
								$java3 = "showObj('".$id2."',this); document.getElementById('zoom_player').style.visibility='hidden';";
								$java4 = "closetime(); document.getElementById('zoom_player').style.visibility='visible';";
						
								$link_txt = $product->color_code == $color->color_code ? 'txt_page_black' : 'normal_txtn';
								if ($i != 0) echo nbs().' | '.nbs();
								echo anchor($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.$this->uri->segment(4), $color->color_name, array('class'=>$link_txt,'onmouseover'=>$java3,'onmouseout'=>$java4));
								$i++;
							}
						}
						else
						{ ?>
							Out of Stock
							<?php
						} ?>
					</span>
				</div>
				
				<?php
				/*
				| ------------------------------------------------------------------------------------
				| Color Swatch
				*/
				?>
				<span class="midtxt">[ Mouse over color icons to view colors / Click any icon to change color ]</span>
				<br /><br />
				<?php
					if ($get_color_list->num_rows() > 0)
					{
						foreach ($get_color_list->result() as $color)
						{
							$id3 = $product->prod_no.'_'.$color->color_code;
							$java5 = "showObj('".$id3."',this); document.getElementById('zoom_player').style.visibility='hidden';";
							$java6 = "closetime(); document.getElementById('zoom_player').style.visibility='visible';";
						
							$swatch_style = $product->color_code == $color->color_code ? 'border:1px solid #333;padding:2px;' : 'padding: 3px;';
							echo anchor($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.str_replace(' ','-',strtolower(trim($color->color_name))).'/'.$this->uri->segment(4), img(array('src'=>PROD_IMG_URL.$img_path.'product_coloricon/'.$product->prod_no.'_'.$color->color_code.'.jpg','width'=>'20','style'=>$swatch_style)), array('onmouseover'=>$java5,'onmouseout'=>$java6)).nbs(7);
						}
					}
				?>
				<br /><br />
				
			</div> <!--/end of #paginat-slider1 -->
			
			<div id="sizet"></div>
			<?php
			/*
			| ------------------------------------------------------------------------------------
			| Size chart and more
			*/
			?>
			<div id="sizetx">

				<!--bof form========================================================================-->
				<?php
				if (ENVIRONMENT === 'development' OR ENVIRONMENT === 'testing')
				{
					echo form_open('cart/add_cart',array('name'=>'frmCart'));
				}
				else
				{
					// ----> This bit of code is to transfer the user to SSL secure pages
					echo form_open(str_replace('http','https',base_url()).'cart/add_cart.html',array('name'=>'frmCart'));
				}
				
				/*
				| ------------------------------------------------------------------------------------
				| Size chart
				*/
				?>
				<table cellspacing="0" cellpadding="0" border="0" width="200">
					<tr>
						<td style="font-size:12px;" width="70%">
							<?php
							/*
							| ------------------------------------------------------------------------------
							| Label for Size
							*/
							if ($product->cat_id <> 19) //----> 19 is not Accessories
							{ ?>
								<strong>SIZE</strong> 
								<span style="font-size:10px;">&nbsp;[<a id="opener" href="javascript:void(0);">SIZE CHART</a>]</span>
								<?php
							}
							else
							{ ?>
								<div id="qtydiv" style="width:150px;margin-left:0px;">
									<input type="hidden" name="size" value="0">
									<strong>QTY</strong><br>
									<select name="qty" style="font-size:11px;width:45px;">
									
										<?php 
										/*
										| ------------------------------------------------------------------------------------
										| stocks for accessories
										*/
										$get_qty = $this->query_page->product_color_stocks(0, $product->color_name, $product->prod_no);	
										
										if ($get_qty->num_rows() > 0)
										{
											$row 			= $get_qty->row();		
											$stock_colsize	= 'size_0'; 
											$stock_count	= $row->$stock_colsize;  
											
											if ($stock_count == 0)
											{
												$msg = 'Out of stock';
											}
											else
											{
												$msg = 'In stock';
											}
											
											for ($i = 1; $i <= $stock_count; $i++)
											{ ?>
												<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
												<?php
											}		
											
											$stock_msg = $msg;
										}
										else
										{ ?>
											<option value=""> 0 </option>
											<?php
											$stock_msg = '<span style="color:#ff0000;">Out of stock</span>';
										} ?>
										
									</select> &nbsp; <?php echo $stock_msg;
									
									/*
									| ------------------------------------------------------------------------------------
									| END stock for accessories
									*/
									?>
								</div>
								<?php
							} ?>
						</td>
						<td style="font-size:12px;padding-left:10px;">
							<?php
							/*
							| ------------------------------------------------------------------------------
							| Label for QTY
							*/
							if ($product->cat_id <> 19 && $product->color_name <> '')
							{ ?>
								<strong>QTY</strong>
								<?php
							} ?>
						</td>
					</tr>
					<tr>
						<td>
							<?php
							/*
							| ------------------------------------------------------------------------------
							| Drop down list for Size
							| And CART DETAILS
							<input type="hidden" name="prod_image" value="<?php echo $img_thumb; ?>" />
							*/
							?>
							<input type="hidden" name="cat_id" value="<?php echo $product->cat_id; ?>" />
							<input type="hidden" name="subcat_id" value="<?php echo $product->subcat_id; ?>" />
							<input type="hidden" name="color_code" value="<?php echo $product->color_code; ?>" />
							<input type="hidden" name="des_id" value="<?php echo $product->des_id; ?>" />
							<input type="hidden" name="prod_sku" value="<?php echo $product->prod_no.'_'.$product->color_code; ?>" />
							<input type="hidden" name="prod_no" value="<?php echo $product->prod_no; ?>" />
							<input type="hidden" name="prod_name" value="<?php echo $product->prod_name; ?>" />
							<input type="hidden" name="price" value="<?php echo $price; ?>" />
							<input type="hidden" name="prod_image" value="<?php echo $img_path.'product_front/thumbs/'.$img_name.'_2.jpg'; ?>" />
							<input type="hidden" name="current_url" value="<?php echo current_url(); ?>" />
							<input type="hidden" name="label_color" value="<?php echo $product->color_name; ?>" />
							<input type="hidden" name="label_designer" value="<?php echo $product->designer; ?>" />
							<?php
							if ($product->cat_id <> 19)
							{
								if ($product->color_name <> '')
								{ ?>
									<select name="size" style="font-size:11px;width:130px;" onChange="getQty('<?php echo base_url(); ?>qty/index/'+this.value+'/<?=$product->prod_no?>/<?=$product->des_id?>/<?=strtoupper($product->color_name)?>')">
										<option value="">-select a size-</option>
										
										<?php
										$get_size = $this->query_category->get_sizes($product->cat_id);
										$check_stock = $this->query_product->check_stock($product->prod_no,$product->color_name);
										
										if ($get_size->num_rows() > 0)
										{
											foreach ($get_size->result() as $size)
											{
												// to use fs instead of xs in tbl_stock
												$size_stock = ($size->size_name == 'fs') ? 'size_xs' : 'size_'.$size->size_name;
												// do not display sizes with no stock
												if ($check_stock[$size_stock] != 0)
												{ ?>
													<option value="<?php echo $size->size_name; ?>">Size <?php echo $size->size_name; ?></option>
													<?php
												}
											}
										} ?>
									</select>
									<?php
								}
								else
								{ ?>
									<br />
									<span style="color:#ff0000;">OUT&nbsp;OF&nbsp;STOCK&nbsp;</span>
									<?php
								}
							} ?>
						</td>
						<td>
							<?php
							/*
							| ------------------------------------------------------------------------------
							| Drop down list for Qty
							*/
							?>
							<div id="qtydiv" style="width:150px;margin-left:10px;">
								<?php
								if ($product->cat_id <> 19 && $product->color_name <> '')
								{ ?>
									<select name="qty" style="font-size:11px;width:45px;" class="qty">
										<option value=""> 0 </option>
									</select>
									<?php
								} ?>
							</div>
						</td>
					</tr>
				</table>
				<br />
				<?php
				/*
				| ------------------------------------------------------------------------------------
				| Add to cart button, Add to bag button, Send inquiry button
				*/
				
				// check if item is pre-order
				$exp_now = explode('/',@date('m/d/Y',time()));
				$time_now = @mktime(0,0,0,$exp_now[0],$exp_now[1],$exp_now[2]);
				if ($product->stock_date != '' OR $product->stock_date != NULL)
					$time_db = @strtotime($product->stock_date);
				else $time_db = '';
				if ($time_db > $time_now) $pre_order = TRUE;
				else $pre_order = FALSE;
				
				if ($pre_order)
				{
					echo '<div data-tooltip="sticky1" style="width:350px;">';
					echo strtoupper('<strong>Availability :</strong>').nbs(2).' <span style="color:red;">Ships '.$product->stock_date.' reserve by pre order below</span>';
					$btn_image = 'images/btn_pre-order.gif';
				}
				// Choice of text and choice of button image for the submit button if wholeslae or consumer
				else if ($this->session->userdata('user_cat') == 'wholesale')
				{
					echo '<div>';
					echo strtoupper('<strong>Availability:</strong> AS PER DELIVERY DATES');
					$btn_image = 'images/btn_addtoinquiry.jpg';
				}
				else
				{
					echo '<div>';
					echo strtoupper('<strong>Availability:</strong> Ships Within 5-7 Business Days (<span style="color:red;">We Ship Globally</span>)');
					$btn_image = 'images/btn_addtobag.gif';
				}
				?>
				
				<br />
				<input type="hidden" name="addcart" value="addcart" />
				<input type="image" src="<?php echo base_url().$btn_image; ?>" class="addtobag" style="margin:3px 0px;" />
				
				<?php
				echo '</div>';
				echo form_close();
				?>
				<!--eof form========================================================================-->
				
				<?php
				// The div="dialog" below seem to show everytime the load is refreshed
				?>
				<div id="dialog" title="SIZE CHART" style="display:none;">
					<p>		
					<?php
					if ($product->cat_id <> 19)
					{
						$this->load->view('size_chart');
					}
					?>
					</p>
				</div>
				
				<div id="dialogsendfriend" title="SEND THIS PHOTO TO FRIEND">
					<p>
					<?php $this->load->view(
						'send_friend',
						array(
							'image' => $img_thumb.'_3.jpg',
							'des_url' => $des_url,
							'prod_no' => $product->prod_no
						)
					); ?>
					</p>
				</div>

			</div>
			<br />
			<table border="0" align="left">
				<?php
				/*
				| ------------------------------------------------------------------------------------
				| Sociables
				*/
				?>
				<tr><td>
					<a href="javascript:void(0);" onclick="return addthis_sendto('facebook');"><img src="<?php echo base_url(); ?>images/facebook.gif" border="0" hspace="2"></a> 
					<a href="javascript:void(0);" onclick="return addthis_sendto('twitter');"><img src="<?php echo base_url(); ?>images/twitter.gif" border="0" hspace="2"></a>
					<a href="javascript:void(0);" onclick="return addthis_sendto('print');"><img src="<?php echo base_url(); ?>images/print.gif" border="0" hspace="2"></a>
					
					<!-- Place this tag where you want the +1 button to render -->
					<g:plusone size="medium" annotation="none"></g:plusone>
					
 				</td></tr>
				<?php
				/*
				| ------------------------------------------------------------------------------------
				| Send photo to friend button
				*/

				// Remove send to friend from wholesale ordering
				if ($this->session->userdata('user_cat') != 'wholesale')
				{ ?>
					<!---- Hide Send to friend 
					<tr><td>
						<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=xa-4a67ed4c7662278c"></script>
						<a id="sendfriend" href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/send_dress.gif" border="0" /></a>
					</td></tr>
					---->
					<?php
				}
				
				/*
				| ------------------------------------------------------------------------------------
				| Product overview
				*/
				?>
				<tr><td>
					<br />
					<strong>PRODUCT OVERVIEW:</strong><br />
					<?php echo $product->prod_desc; ?>
					<br /><br />
				</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="vertical-align:bottom;height:90px;">
			<?php
			/*
			| ------------------------------------------------------------------------------------
			| Other views and video
			*/
			if ($img = @GetImageSize(PROD_IMG_URL.$img_path.'product_front/thumbs/'.$img_name.'_2.jpg'))
			//if (file_exists(PROD_IMG_URL.$img_path.'product_front/'.$img_name)) // ----> doesn't work for files on other servers
			{ 
				$id7 = rtrim($img_name,'.jpg');
				$java7 = "showObj('".$id7."',this);";
				$java8 = "closetime(); flowplayer('zoom_player').show();";
				
			?>
				<a href='<?php echo $img_front_large; ?>' class='cloud-zoom-gallery' title='Front view' rel="useZoom: 'zoom1', smallImage: '<?php echo $img_front_thumb; ?>'" onclick="$f('zoom_player').hide(); small_video_thumb_refresh();" onmouseover="<?php echo $java7; ?>" onmouseout="<?php echo $java8; ?>">
					<img src="<?php echo $img_front; ?>" alt = "Front" style="border:1px solid #333;"/>
				</a>
				<?php
			}		
			
			if ($img = @GetImageSize(PROD_IMG_URL.$img_path.'product_side/thumbs/'.$img_name.'_2.jpg'))
			{ 
				$id8 = rtrim($img_name,'.jpg').'_side';
				$java9 = "showObj('".$id8."',this);";
				$java10 = "closetime(); flowplayer('zoom_player').show();";
			?>
				<a href='<?php echo $img_side_large; ?>' class='cloud-zoom-gallery' title='Side view' rel="useZoom: 'zoom1', smallImage: '<?php echo $img_side_thumb; ?>'" onclick="$f('zoom_player').hide(); small_video_thumb_refresh();" onmouseover="<?php echo $java9; ?>" onmouseout="<?php echo $java10; ?>">
					<img src="<?php echo $img_side; ?>" alt = "Side" style="border:1px solid #333;"/>
				</a>
				<?php
			}

			if ($img = @GetImageSize(PROD_IMG_URL.$img_path.'product_back/thumbs/'.$img_name.'_2.jpg'))
			{ 
				$id9 = rtrim($img_name,'.jpg').'_back';
				$java11 = "showObj('".$id9."',this);";
				$java12 = "closetime(); flowplayer('zoom_player').show();";
				?>
				
				<a href='<?php echo $img_back_large; ?>' class='cloud-zoom-gallery' title='Back view' rel="useZoom: 'zoom1', smallImage: '<?php echo $img_back_thumb; ?>'" onclick="$f('zoom_player').hide(); small_video_thumb_refresh();" onmouseover="<?php echo $java11; ?>" onmouseout="<?php echo $java12; ?>">
					<img src="<?php echo $img_back; ?>" alt = "Back" style="border:1px solid #333;"/>
				</a>
				<?php
			}

			// the get_headers function is not 100% full proof and there is remote chance that the first header list
			// might change in the future thereby causing the substr to have to change too...
			// sticking this function just in case
			if (get_http_response_code(PROD_IMG_URL.$img_path.'product_video/'.$img_name.'.flv') === '200' && $runway_mode == FALSE)
			{ ?>
			
				<div id="flow_player" style="width:60px;height:90px;display:inline-block;border:1px solid #333;position:relative;bottom:1px;"></div>
				
				<script type="text/javascript">
					flowplayer('flow_player', {src: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer-3.2.7.swf", wmode: "opaque"}, {
						clip: {
							url: "<?php echo PROD_IMG_URL.$img_path.'product_video/'.rtrim($img_name,'.jpg').'.flv'; ?>",
							// cancel the default behavior upon finish
							onBeforeFinish: function() {
								return false;
							}
						},
						// install video on separate div on onmouseover
						onMouseOver: function() {
							document.getElementById('zoom1').style.visibility = "hidden";
							flowplayer('zoom_player', {src: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer-3.2.7.swf", wmode: "opaque"}, {
								clip: {
									url: "<?php echo PROD_IMG_URL.$img_path.'product_video/'.rtrim($img_name,'.jpg').'.flv'; ?>",
									// cancel the default behavior upon finish
									onBeforeFinish: function() {
										return false;
									}
								},
								// remove controls shown at start
								plugins: {
									controls: null,
									content: {
										url: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer.content-3.2.0.swf",
										top: 0,
										left: 0,
										width: 340,
										height: 510,
										opacity: 0.1,
										backgroundGradient: 'low'
									}
								}
							});
						},
						// remove video on mouseout
						onMouseOut: function() {
							document.getElementById('zoom1').style.visibility = "visible";
							$f('zoom_player').hide();
						},
						// remove controls shown at start, add transparent content for mouse click purposes, and some other event listeners
						plugins: {
							controls: null,
							content: {
								url: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer.content-3.2.0.swf",
								top: 0,
								left: 0,
								width: 60,
								height: 90,
								opacity: 0.1,
								backgroundGradient: 'low',
								onClick: function() {
									document.getElementById('zoom1').style.visibility = "hidden";
									// reload small video thumb to remove mouseover and mouseout events
									flowplayer('flow_player', {src: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer-3.2.7.swf", wmode: "opaque"}, {
										clip: {
											url: "<?php echo PROD_IMG_URL.$img_path.'product_video/'.rtrim($img_name,'.jpg').'.flv'; ?>",
											// cancel the default behavior upon finish
											onBeforeFinish: function() {
												return false;
											}
										},
										// remove controls shown at start
										plugins: {
											controls: null,
											content: {
												url: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer.content-3.2.0.swf",
												top: 0,
												left: 0,
												width: 60,
												height: 90,
												opacity: 0.1,
												backgroundGradient: 'low'
											}
										}
									});
								}
							}
						},
						// remove video on current player div on error specially '200 - No stream found'
						onError: function() {
							document.getElementById('flow_player').innerHTML = '';
							document.getElementById('flow_player').style.border = 'none';
						}
					});
					
				</script>
				<?php
			}
			
			if ($runway_mode == TRUE)
			{ ?>
			
				<div id="flow_player" style="width:60px;height:90px;display:inline-block;border:1px solid #333;position:relative;bottom:1px;"></div>
				
				<script type="text/javascript">
					flowplayer('flow_player', "<?php echo base_url(); ?>jscript/flowplayer/flowplayer-3.2.7.swf", {
						clip: {
							url: "<?php echo PROD_IMG_URL.$img_path.'product_video/'.rtrim($img_name,'.jpg').'.flv'; ?>",
							// cancel the default behavior upon finish
							onBeforeFinish: function() {
								return false;
							}
						},
						// remove controls shown at start, add transparent content for mouse click purposes, and some other event listeners
						plugins: {
							controls: null
						}
					});
					document.getElementById('zoom1').style.visibility = "hidden";
					flowplayer('zoom_player', {src: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer-3.2.7.swf", wmode: "opaque"}, {
						clip: {
							url: "<?php echo PROD_IMG_URL.$img_path.'product_video/'.rtrim($img_name,'.jpg').'.flv'; ?>",
							// cancel the default behavior upon finish
							onBeforeFinish: function() {
								return false;
							}
						},
						// remove controls shown at start
						plugins: {
							controls: null,
							content: {
								url: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer.content-3.2.0.swf",
								top: 0,
								left: 0,
								width: 340,
								height: 510,
								opacity: 0.1,
								backgroundGradient: 'low'
							}
						}
					});
				</script>
				<?php
			}
			?>
		</td>
	</tr>
</table>

<script type="text/javascript">

	featuredcontentslider.init({
		id: "slider1",  //id of main slider DIV
		contentsource: ["inline", ""],  //Valid values: ["inline", ""] or ["ajax", "path_to_file"]
		toc: "markup",  //Valid values: "#increment", "markup", ["label1", "label2", etc]
		nextprev: ["", ""],  //labels for "prev" and "next" links. Set to "" to hide. For ex: ["Previous", "Next"].
		revealtype: "mouseover", //Behavior of pagination links to reveal the slides: "click" or "mouseover"
		enablefade: [true, 0.2],  //[true/false, fadedegree]
		autorotate: [false, 7000],  //[true/false, pausetime]
		onChange: function(previndex, curindex){  //event handler fired whenever script changes slide
			//previndex holds index of last slide viewed b4 current (1=1st slide, 2nd=2nd etc)
			//curindex holds index of currently shown slide (1=1st slide, 2nd=2nd etc)
		}
	})

</script>
	
<!-- Place this render call where appropriate (for google +1)-->
<script type="text/javascript">
	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
</script>

<!-- Click function on image views to reload small video thumb -->
<script type="text/javascript">

	function small_video_thumb_refresh()
	{
		document.getElementById('zoom1').style.visibility = 'visible';
		flowplayer('flow_player', {src: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer-3.2.7.swf", wmode: "opaque"}, {
			clip: {
				url: "<?php echo PROD_IMG_URL.$img_path.'product_video/'.rtrim($img_name,'.jpg').'.flv'; ?>",
				// cancel the default behavior upon finish
				onBeforeFinish: function() {
					return false;
				}
			},
			// install video on separate div on onmouseover
			onMouseOver: function() {
				document.getElementById('zoom1').style.visibility = "hidden";
				$f('zoom_player').show();
			},
			// remove video on mouseout
			onMouseOut: function() {
				document.getElementById('zoom1').style.visibility = "visible";
				$f('zoom_player').hide();
			},
			// remove controls shown at start, add transparent content for mouse click purposes, and some other event listeners
			plugins: {
				controls: null,
				content: {
					url: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer.content-3.2.0.swf",
					top: 0,
					left: 0,
					width: 60,
					height: 90,
					opacity: 0.1,
					backgroundGradient: 'low',
					onClick: function() {
						document.getElementById('zoom1').style.visibility = "hidden";
						// reload small video thumb to remove mouseover and mouseout events
						flowplayer('flow_player', {src: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer-3.2.7.swf", wmode: "opaque"}, {
							clip: {
								url: "<?php echo PROD_IMG_URL.$img_path.'product_video/'.rtrim($img_name,'.jpg').'.flv'; ?>",
								// cancel the default behavior upon finish
								onBeforeFinish: function() {
									return false;
								}
							},
							// remove controls shown at start
							plugins: {
								controls: null,
								content: {
									url: "<?php echo base_url(); ?>jscript/flowplayer/flowplayer.content-3.2.0.swf",
									top: 0,
									left: 0,
									width: 60,
									height: 90,
									opacity: 0.1,
									backgroundGradient: 'low'
								}
							}
						});
					}
				}
			},
			// remove video on current player div on error specially '200 - No stream found'
			onError: function() {
				document.getElementById('flow_player').innerHTML = '';
				document.getElementById('flow_player').style.border = 'none';
			}
		});
	}
	
</script>

<!--HTML for the tooltips for pre-order-->
<div id="mystickytooltip" class="stickytooltip">
	<div style="padding:5px">

		<div id="sticky1" class="atip" style="width:200px">
			<img src="<?php echo base_url(); ?>res.php?w=60&h=90&constrain2=1&img=<?php echo $img_front_thumb; ?>" style="float:left;padding-right:5px;" />
			This product will be on stock by <?php echo $product->stock_date; ?>.<br /><br />
			Pre order now to reserve your dress.
			<br style="clear:both;" />
		</div>

	</div>

	<div class="stickystatus"></div>
</div>

<div id="prod_detail_intro">
	<img src="<?php echo base_url(); ?>images/product_detail_intro_screen.jpg" alt="Intro Screen" />
</div>

<?php
	/*
	| ----------------------------------------
	| A quick function to get the 3-digit HTTP response code
	| Taken from http://www.php.net/manual/en/function.get-headers.php#97684
	| Works to check for files in order servers
	*/
	function get_http_response_code($theURL)
	{
		$headers = @get_headers($theURL);
		return substr($headers[0], 9, 3);
	}
	
