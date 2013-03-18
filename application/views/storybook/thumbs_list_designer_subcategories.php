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
		$alts = $alttags.' by '.$item['designer_name'];
		
		/*
		| ------------------------------------------------------------------------------------------
		| Show the thumb
		*/
		echo '
			<div style="width:170px; margin:2px 5px 10px 15px; float:left; text-align:left;">'.
				anchor($url_link.'/'.$item['sc_url_structure'], img(array('src' => PROD_IMG_URL.'images/subcategory_icon/'.$item['icon_img'], 'border' => '0', 'alt' => $alts, 'title' => $alts))).'
				<br /><b>'.$item['subcat_name'].'</b>
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
