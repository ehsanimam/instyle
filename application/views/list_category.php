<?php
if($left_nav_sql->num_rows() > 0)
{
	$cnt = 1;
	foreach ($left_nav_sql->result() as $item)
	{
		$url  = '';
		$cat	 = str_replace('.html','',$this->uri->segment(1));
		
		if($cat == 'new-arrival') {
			$url 	.= 'new-arrival/';			
		} elseif($cat == 'clearance') {
			$url 	.= 'clearance/';		
		} else {
			$url .= $item->c_url_structure.'-'.$item->cat_id.'/';		
		}		
		
		$url .= $item->sc_url_structure.'-'.$item->subcat_id;
		
		echo '
			<div style="width:170px; margin:0px 5px 10px 15px; float:left; text-align:left;">'.
				anchor($url.'.html',img(array('src'=>'images/subcategory_icon/'.$item->icon_img,'border'=>0,'alt'=>$item->alttags,'title'=>$item->alttags))).
				'<br><b>'.$item->subcat_name.'</b>
				<br>'.$item->description.'
			</div>
		';
		
		if (fmod($cnt, 4) == 0) echo '<div style="clear:both;"></div>';
		
		$cnt++;
	}
	echo '<div style="clear:left;">&nbsp;</div>';
} else {
	echo 'No category return';
}
?>