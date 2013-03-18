<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
	<tr>
		<?php
		/*
		| --------------------------------------------------------------------------------------
		| This first column cell is the left side bar
		*/
		?>
		<td width="190" style="background: #f0f0f0;padding: 5px 14px 5px 14px;line-height: 16px;">
	
			<p style="text-align:justify;"><?php echo $index_page->text; ?></p>
			
			<br />
			<?php 
				foreach ($offers->result() as $row)    //Offer Manager Links
					{
			?>
			<p style="text-align:justify;"><?php echo anchor($row->link, $row->desc1,array('title' => $row->title1 , 'class' => 'offers')); ?></p>
			<?php
			
					}
			/*
			| --------------------------------------------------------------------------------------
			| Video area at left sidebar of home page
			| This sectino is being removed pending offers management
			*/
			?>
			<br />
			<div style="display:none;">
			<object classid="clsid:166B1BCA-3F9C-11CF-8075-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,0,0" width="190" height="113">
				<param name="src" value="<?php echo base_url(); ?>images/slideshow-index/finale2.swf">
				<embed src="<?php echo base_url(); ?>images/slideshow-index/finale2.swf" pluginspage="http://www.macromedia.com/shockwave/download/" width="190" height="113"></embed>
			</object>
			</div>
			<br /><br /><br /><br />
			
			<?php
				/*
				| --------------------------------------------------------------------------------------
				| This bit of code is to dispaly the selected active banners.
				| Banner dispalyed may be selected and sorted at admin >> home menu management >> home banners
				| This sectino is being removed pending offers management
				*/
				$this->db->where('is_published','1');
				$this->db->order_by('sequence','desc');
				$query = $this->db->get('home_banners');
				$i = 0;
				foreach ($query->result_array() as $row):
					echo '<div style="display:none;">'.img(array('src'=>base_url().'images/banners/'.$row['banner_image'],'alt'=>'Banner Image')).'</div>';
					if ($i == 0) echo br(2);
					$i++;
				endforeach; ?>
				
		</td>
		<?php
		/*
		| --------------------------------------------------------------------------------------
		| This 2nd column cell is the right content where the slide show is for home page
		*/
		?>
		<td style="padding-left: 15px;">
		
			<div id="fadeshow1"></div>
			
		</td>
	</tr>
</table>
