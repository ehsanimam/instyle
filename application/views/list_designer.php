<?php
if ($left_nav_sql->num_rows() > 0)
{
	foreach ($left_nav_sql->result() as $item)
	{
		/*
		| ------------------------------------------------------------------------------------------
		| Set the links
		*/
		$url  = '';
		$cat	 = str_replace('.html','',$this->uri->segment(1));
		if ($cat == 'new-arrival-designer')
		{
			$url 	.= 'new-arrival-designer/';			
		}
		elseif ($cat == 'clearance-designer')
		{
			$url 	.= 'clearance-designer/';		
		}
		else
		{
			$url .= $item->c_url_structure.'-designer-'.$item->cat_id.'/';		
		}
		$url .= $item->d_url_structure.'-designer-'.$item->des_id;
		
		/*
		| ------------------------------------------------------------------------------------------
		| Set the alt tags
		*/
		$alts = $alttags.' by '.$item->designer;
		
		/*
		| ------------------------------------------------------------------------------------------
		| Show the thumb
		*/
		echo '
			<div style="width:170px; height:150px; margin:2px 5px 0px 15px; float:left; text-align:left;">'.
				anchor($url.'.html',img(array('src'=>'images/designer_icon/'.$item->icon_img,'border'=>0,'alt'=>$item->alttags,'title'=>$item->alttags))).'
				<br><b>'.$item->designer.'</b>
				<br>'.$item->description.'
			</div>
		';
	}
	echo '<div style="clear:left;">&nbsp;</div>';
}
else
{
	echo 'No category return';
}
