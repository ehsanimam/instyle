<?php
if($left_nav_sql->num_rows() > 0) {
	foreach($left_nav_sql->result() as $item) {
		$url  	 = '';
		$url 	.= $item->c_url_structure.'-c'.$item->cat_id.'/';
		$url 	.= $item->sc_url_structure.'-c'.$item->subcat_id;
				
		if($this->session->userdata('faceted_subcat_id') == $item->subcat_id) {
			$font_weight = 'font-weight:bold;color:#000;';
		} else {
			$font_weight = 'font-weight:normal';
		}
		
		echo anchor($url.'.html',$item->subcat_name,array('style'=>$font_weight)).'<br>';		
	}
} else {
	echo 'No category return';
}
?>