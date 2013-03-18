<?php
if ($left_nav_sql->num_rows() > 0)
{
	foreach ($left_nav_sql->result_array() as $item)
	{
		/*
		| ------------------------------------------------------------------------------------------
		| Set the links
		*/
		$url = $this->uri->segment(1).'/'.$item['d_url_structure'];
		
		/*
		| ------------------------------------------------------------------------------------------
		| Set the alt tags
		*/
		$alts = $alttags.' by '.$item['designer'];
		
		/*
		| ------------------------------------------------------------------------------------------
		| Show the thumb
		*/
		echo '
			<div style="width:170px; height:150px; margin:2px 5px 0px 15px; float:left; text-align:left;">
				'.anchor($url.'.html', img(array('src' => 'images/designer_icon/'.$item['icon_img'], 'border' => '0', 'alt' => $alts, 'title' => $alts))).'<br>'.$item['designer'].'
			</div>
		';
	}
	echo '<div style="clear:left;">&nbsp;</div>';
}
else
{
	echo 'No category return';
}
