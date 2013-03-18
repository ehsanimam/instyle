<!--
<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="180" style="background:#f0f0f0; padding:5px 10px 3px 10px;">
		<?php //$this->load->view('page_left_menu'); ?>
	</td>
	<td>
		<div id="bodycontent">
-->
			<h3><?php echo strtoupper($page_title); ?></h3>
			<p>
				<div align="left" style="font-size:14px;">CLICK ANY COVER TO VIEW ARTICLE</div>
				<br />
				<div align="left">
					For press inquiries, please email <a href="mailto:press@instylenewyork.com">press@instylenewyork.com</a>.
				</div>
			</p>
			
				<table cellpadding="0" cellspacing="0" width="750" border="0" align="left">
					<tr><td valign="top" width="750">
						<table cellpadding="4" cellspacing="0" width="100%" border="0" align="left">
							<tr><td valign="top" width="120" align="left">

								<?php
								/*
								switch (ENVIRONMENT)
								{
									case 'development':
										$DB3 = $this->load->database('local', TRUE);
									break;

									case 'testing';
										$DB3 = $this->load->database('instyle', TRUE);
									break;
									
									default:
										$DB3 = $this->load->database('instyle', TRUE);
								}
								*/

								$res = $this->db->query('SELECT * FROM tbl_press');
							
								if ($res->num_rows() > 0)
								{
									echo '<table width="90%" border="0" cellpadding="10" cellspacing="0" align="left">';
									echo '<tr>';
									
									for ($i = 0; $i <= $res->num_rows(); $i = $i + 1)
									{
										foreach ($res->result_array() as $rows)
										{
											$i++;
											if ($i % 5 == 0)
											{
												echo '<td align="left">';
												?>
												
												<a rel="press_photos" class="press_group" href="#inline<?php echo $rows['press_id']?>" title="<?php echo $rows['title']?>">
													<img alt="<?php echo $rows['title']?>" src="<?php echo base_url(); ?>images/press_cover/thumb/<?php echo $rows['cover_img']?>" style="border:1px solid #666666;" />
												</a>
												
												<?php
												echo $rows['title'].'</td></tr><tr>';
											}
											else
											{
												echo '<td align="left">';
												?>
												
												<a rel="press_photos" class="press_group" href="#inline<?php echo $rows['press_id']?>" title="<?php echo $rows['title']?>">
													<img alt="<?php echo $rows['title']?>" src="<?php echo base_url(); ?>images/press/press_cover/thumb/<?php echo $rows['cover_img']?>" style="border:1px solid #666666;" />
												</a>
												
												<?php echo $rows['title'].'</td>';
											}
										}
									}
									echo '</tr></table>';
								} ?>
								
							</td></tr>
						</table>
					
							<?php
							/*
							$img_width = $this->db->query('SELECT * FROM press_img_width');
							$row1 = $img_width->row_array();
							$width = $row1['width'];
							*/
							
							$res = $this->db->query('SELECT * FROM tbl_press');
							if ($res->num_rows() > 0)
							{ ?>
								<div style="display: none; width:550px;">
								<?php
								foreach ($res->result_array() as $rows)
								{ ?>					
									<div id="inline<?php echo $rows['press_id']?>" style="overflow:auto;">
										<img alt="<?php echo $rows['title']?>" src="<?php echo base_url(); ?>images/press/press_1/<?php echo $rows['img_1']?>" title="<?php echo $rows['title']?>" /><br />
										<img alt="<?php echo $rows['title']?>" src="<?php echo base_url(); ?>images/press/press_2/<?php echo $rows['img_2']?>" title="<?php echo $rows['title']?>" />
									</div>
									<?php
								} ?>
								</div>
								<?php
							} ?>
					
					</td></tr>
				</table>
<!--				
		</div>
	</td>
</tr>
</table>
-->