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
		$url_link = '';
		
		/*
		| ------------------------------------------------------------------------------------------
		| Set the alt tags
		*/
		$alts = $alttags;
		
		/*
		| ------------------------------------------------------------------------------------------
		| Show the thumb
		*/
		$subcat_qry = $this->query_category->get_category_bydesigner_new($item['d_url_structure'], $item['c_url_structure']);
		
		if ($subcat_qry->num_rows() > 0)
		{
			$row1 = $subcat_qry->row_array();
		
			echo '
				<div style="width:170px; margin:2px 5px 10px 15px; float:left; text-align:left;">'.
					anchor($item['d_url_structure'], img(array('src' => PROD_IMG_URL.'images/designer_icon/'.$item['icon_img'], 'border' => '0', 'alt' => $alts, 'title' => $alts))).'
					<br /><b><u>'.$item['designer'].'</u></b>
					<br />'.$item['description'].'
				</div>
			';
		}
		if (fmod($cnt, 4) == 0) echo '<div style="clear:both;"></div>';
		$cnt++;
	}
	echo '<div style="clear:left;">&nbsp;</div>';
}
else
{
	echo 'No category return';
}
