			<div style="border-bottom: 1px solid #999999;height: 60px;width: 760px;">
				<h3><?php echo strtoupper($page_title); ?></h3>
				<p>Use the links below to quickly find key areas of our Web site.</p>
				<!--<hr style="height: 1px;border-width: 0;color: #999999;background-color: #999999;"/>-->
			</div>
	
			<?php
			/*
			| --------------------------------------------------------------------------------------
			| Site map by categories
			*/
			?>
			<div style="border-bottom: 1px solid #999999;height: 160px;padding: 15px 0 15px 1px;width: 760px;">
			
				<?php
				$cat_res = $this->set->get_category();
				if ($cat_res->num_rows() > 0)
				{
					foreach ($cat_res->result() as $cat_rec)
					{ ?>
						<div style="vertical-align:top;display: table-cell;width: 253px;">
						
							<div class="normal_txt2"><?php echo strtoupper($cat_rec->cat_name); ?></div>
							
							<?php
							$cat_qry1 = $this->query_category->get_subcat_new($cat_rec->url_structure);
							if ($cat_qry1->num_rows() > 0)
							{
								foreach ($cat_qry1->result() as $cat_rec1)
								{
									$url  	 = '';
									$url 	.= $cat_rec1->c_url_structure.'/';
									$url 	.= $cat_rec1->sc_url_structure;
									
									echo anchor($url, $cat_rec1->subcat_name).'<br>';
								}
							} ?>
						</div>
						<?php 
					} 
				}
				else
				{
					echo '<td>No category return</td>';
				}
				?>
				
			</div>
			
			<?php
			/*
			| --------------------------------------------------------------------------------------
			| Site map by designers
			*/
			?>
			<div style="border-bottom: 1px solid #999999;height: 320px;padding: 15px 0 15px 1px;">
			
				<?php
				$designer_res = $this->set->get_designers('');
				if ($designer_res->num_rows() > 0)
				{
					$i = 1;
					foreach ($designer_res->result() as $designer_rec)
					{ ?>
						<div style="vertical-align:top;display: table-cell;width: 190px;padding: 0 0 10px 0;">
						
							<div class="normal_txt2"><?php echo strtoupper($designer_rec->designer); ?></div>
							
							<?php
							$cat_url = $this->set->get_caturl($designer_rec->catid);
							$cat_url = $cat_url->row();
							
							$url  	 = '';
							$url	.= $designer_rec->url_structure.'/';
							
							$cat_id_query = $this->set->get_category();
							
							if ($cat_id_query->num_rows() > 0)
							{
								foreach ($cat_id_query->result() as $cat_id)
								{
									$subcat_query = $this->query_category->get_category_bydesigner($designer_rec->des_id, $cat_id->cat_id);
									
									if ($subcat_query->num_rows() > 0)
									{
										if ($cat_id->cat_name == 'Clearance') echo 'For Clearance:'.br();
										
										foreach ($subcat_query->result() as $sub_item)
										{
											
											$a_url = $url . $sub_item->url_structure;
											
											echo $cat_id->cat_name == 'Clearance' ? nbs(5) : '';
											echo anchor($a_url, $sub_item->subcat_name).'<br>';
										}
									}
								}
							} ?>
						</div>
						
						<?php
						if ($i == 4 OR $i == 8 OR $i == 12 OR $i == 16 OR $i == 20) echo '<br />';
						$i++;
					}
				}
				else
				{
					echo '<td>No category return</td>';
				}
				?>
				
			</div>
			
			<?php
			/*
			| --------------------------------------------------------------------------------------
			| Site map by other pages
			*/
			?>
			<div style="border-bottom: 1px solid #999999;height: 60px;padding: 14px 0 15px 1px;width: 760px;">
				<div class="normal_txt2">
				<?php
					if ($this->session->userdata('user_loggedin'))
					{
						echo anchor('home','HOME').nbs(10);
					}
					else
					{
						echo anchor('register','REGISTER').nbs(10);
						//echo anchor('signin.html','SIGN IN').nbs(10);
					}
				
					echo anchor('press','PRESS').nbs(10);
					echo anchor('contact','CONTACT').nbs(10);
				?>
				</div>
				<br />
				<div class="normal_txt2">
					<?php
					if ($this->session->userdata('user_cat') == 'retailer')
					{ ?>
						<a href="<?php echo site_url('wholesale_ordering'); ?>" class="normal_txt" style="font-weight:normal; text-decoration:none;">Ordering</a><span class="lseparator">&nbsp; &nbsp; | &nbsp; &nbsp;</span>
						<a href="<?php echo site_url('wholesale_return_policy'); ?>" class="normal_txt" style="font-weight:normal; text-decoration:none;">Return Policy</a><span class="lseparator">&nbsp; &nbsp; | &nbsp; &nbsp;</span>
						<a href="<?php echo site_url('wholesale_shipping'); ?>" class="normal_txt" style="font-weight:normal; text-decoration:none;">Shipping</a><span class="lseparator">&nbsp; &nbsp; | &nbsp; &nbsp;</span>
						<a href="<?php echo site_url('wholesale_privacy_notice'); ?>" class="normal_txt" style="font-weight:normal; text-decoration:none;">Privacy Notice</a><span class="lseparator">&nbsp; &nbsp; | &nbsp; &nbsp;</span>
						<a href="<?php echo site_url('wholesale_order_status'); ?>" class="normal_txt" style="font-weight:normal; text-decoration:none;">Order Status</a><span class="lseparator">&nbsp; &nbsp; | &nbsp; &nbsp;</span>
						<a href="<?php echo site_url('wholesale_faq'); ?>" class="normal_txt" style="font-weight:normal; text-decoration:none;">FAQ</a>
						<?php
					}
					else
					{ ?>
						<a href="<?php echo site_url('ordering'); ?>" class="normal_txt" style="font-weight:normal; text-decoration:none;">Ordering</a><span class="lseparator">&nbsp; &nbsp; | &nbsp; &nbsp;</span>
						<a href="<?php echo site_url('return_policy'); ?>" class="normal_txt" style="font-weight:normal; text-decoration:none;">Return Policy</a><span class="lseparator">&nbsp; &nbsp; | &nbsp; &nbsp;</span>
						<a href="<?php echo site_url('shipping'); ?>" class="normal_txt" style="font-weight:normal; text-decoration:none;">Shipping</a><span class="lseparator">&nbsp; &nbsp; | &nbsp; &nbsp;</span>
						<a href="<?php echo site_url('privacy_notice'); ?>" class="normal_txt" style="font-weight:normal; text-decoration:none;">Privacy Notice</a><span class="lseparator">&nbsp; &nbsp; | &nbsp; &nbsp;</span>
						<a href="<?php echo site_url('order_status'); ?>" class="normal_txt" style="font-weight:normal; text-decoration:none;">Order Status</a><span class="lseparator">&nbsp; &nbsp; | &nbsp; &nbsp;</span>
						<a href="<?php echo site_url('faq'); ?>" class="normal_txt" style="font-weight:normal; text-decoration:none;">FAQ</a>
						<?php
					} ?>
				</div>
			</div>
<!--			
		</div>
	</td>
</tr>
</table>
-->