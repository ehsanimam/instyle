<?php
if ($left_nav_sql->num_rows() > 0)
{
	foreach ($left_nav_sql->result_array() as $item)
	{
		/*
		| ------------------------------------------------------------------------------------------
		| Set the links
		*/
		$url = uri_string().'/'.$item['sc_url_structure'];
		
		/*
		| ------------------------------------------------------------------------------------------
		| Set the alt tags
		*/
		$alts = $alttags.' by '.$item['alt'];
		
		/*
		| ------------------------------------------------------------------------------------------
		| Show the thumb
		*/
		echo '
			<div style="width:170px; height:150px; margin:2px 5px 0px 15px; float:left; text-align:left;">
				'.anchor($url, img(array('src' => 'images/subcategory_icon/'.$item['icon_img'], 'border' => 0, 'alt' => $alttags, 'title' => $alttags))).'<br>'.$item['subcat_name'].'
			</div>
		';
	}
	echo '<div style="clear:left;">&nbsp;</div>';
}
else
{
	echo 'No category return';
}
