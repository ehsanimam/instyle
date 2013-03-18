<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
	<tr>
		<td width="190" style="background: #f0f0f0;padding: 5px 14px 5px 14px;line-height: 16px;">
	
			<p style="text-align:justify;">	In Style New York, offers womens <?php echo anchor('apparel-c1/cocktaildress-c75.html','cocktail dresses'); ?>, <?php echo anchor('apparel-c1/eveningdress-c87.html','evening dresses'); ?> <?php echo anchor('apparel-c1/ballgowns-c101.html','special occassion gowns'); ?> as well as fashion accesories in <?php echo anchor('jewelry-c19/pearls-c108.html','pearls'); ?> coral jewelry, <?php echo anchor('jewelry-c19/precious-c110.html','semiprecious stone'); ?> and <?php echo anchor('jewelry-c19/costume-c109.html','costume jewelry'); ?>.</p>
			
			<p style="text-align:justify;">Come and explore our many choices for your closet this season.</p>
			
			<br />
			<object classid="clsid:166B1BCA-3F9C-11CF-8075-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,0,0" width="190" height="113">
				<param name="src" value="<?php echo base_url(); ?>images/slideshow-index/finale2.swf">
				<embed src="<?php echo base_url(); ?>images/slideshow-index/finale2.swf" pluginspage="http://www.macromedia.com/shockwave/download/" width="190" height="113"></embed>
			</object>
			<br /><br /><br /><br />
			
			<?php
				/*
				| --------------------------------------------------------------------------------------
				| This bit of code is to dispaly the selected active banners.
				| Banner dispalyed may be selected and sorted at admin >> home menu management >> home banners
				|
				*/
				$this->db->where('is_published','1');
				$this->db->order_by('sequence','desc');
				$query = $this->db->get('home_banners');
				$i = 0;
				foreach ($query->result_array() as $row):
					echo img(array('src'=>base_url().'images/banners/'.$row['banner_image'],'alt'=>'Banner Image'));
					if ($i == 0) echo br(2);
					$i++;
				endforeach; ?>
				
		</td>
		<td>
		
			<div class="rotator">
				<ul>
					<?php
					if($slides->num_rows()>0) {
						$i=1;
						foreach($slides->result() as $slide) {
						$show = $i==1?'show':'';
						?>
						<li class="<?php echo $show; ?>">
						<?php echo img('images/slideshow-index/'.$slide->image_name); ?>
						</li>
						<?php
						$i++;
						}
					} ?>
				</ul>
			</div>

		</td>
	</tr>
</table>
