<?php
if ($view_pane_sql->num_rows() > 0)
{
	$cnt = 1;
	foreach ($view_pane_sql->result_array() as $item)
	{
		/*
		| ------------------------------------------------------------------------------------------
		| Set the base links
		*/
		$url_link = uri_string();
		
		/*
		| ------------------------------------------------------------------------------------------
		| Set the alt tags
		*/
		$alts = $alttags;
		
		/*
		| ------------------------------------------------------------------------------------------
		| Show the thumb
		*/
		echo '
			<div style="width:170px; margin:2px 5px 10px 15px; float:left; text-align:left;">
				'.anchor($url_link.'/'.$item['sc_url_structure'], img(array('src' => 'images/subcategory_icon/'.$item['icon_img'], 'border' => '0', 'alt' => $alts, 'title' => $alts))).'
				<br /><b><u>'.$item['subcat_name'].'</u></b>
				<br />'.$item['description'].'
			</div>
		';
		
		if (fmod($cnt, 4) == 0) echo '<div style="clear:both;"></div>';
		$cnt++;
	}
	echo '<div style="clear:left;">&nbsp;</div>';
}
else
{
	echo 'No category return';
}
