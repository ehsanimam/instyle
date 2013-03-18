<?php
if ($left_nav_sql->num_rows() > 0)
{
	foreach ($left_nav_sql->result_array() as $item)
	{
		if ($this->uri->segment(2) && $this->set->get_id($this->uri->segment(2)) == $item['subcat_id'])
		{
			$font_weight = 'font-weight:bold;color:#000;';
		}
		else
		{
			$font_weight = 'font-weight:normal';
		}
		
		/*
		| ------------------------------------------------------------------------------------------
		| Category heading
		*/
		echo anchor(uri_string().'/'.$item['sc_url_structure'], $item['subcat_name'], array('style' => $font_weight)).'<br>';
		
		/*
		| ------------------------------------------------------------------------------------------
		| Check for subsbucats
		*/
		$subsubcat = $this->query_category->get_subsubcat($item['subcat_id']);
		
		if ($this->uri->segment(2) && $subsubcat->num_rows() > 0 && $this->set->get_id($this->uri->segment(2))==$item['subcat_id'])
		{
			foreach ($subsubcat->result_array() as $sub_item)
			{
				if ($this->uri->segment(2) && $this->uri->segment(3) && $this->set->get_id($this->uri->segment(3)) == $sub_item['id'])
				{
					$sub_font_weight = 'font-weight:normal;color:#660000;';
				}
				else
				{
					$sub_font_weight = 'font-weight:normal';
				}
				
				$a_url = $url.'/'.$sub_item['url_structure'].'-c'.$sub_item['id'].'.html';
				echo '&nbsp; &nbsp; &nbsp; '.anchor($a_url, $sub_item['name'], array('style' => $sub_font_weight)).'<br>';
			}
		}
	}
}
else
{
	echo 'No category return';
}
