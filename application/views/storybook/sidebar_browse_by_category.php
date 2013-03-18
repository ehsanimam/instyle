<?php
if ($left_nav_sql->num_rows() > 0)
{
	foreach ($left_nav_sql->result_array() as $item) // ---> foreach subcategory
	{
		/*
		| ------------------------------------------------------------------------------------------
		| Set the base link
		*/
		$url_link = isset($caturl) ? $caturl : $this->uri->segment(1);
		
		// Some styles
		if (($this->uri->segment(2) && $this->uri->segment(2) == $item['sc_url_structure']) OR (isset($sc_url_structure) && $sc_url_structure == $item['sc_url_structure']))
		{
			$font_weight = 'font-weight:bold;color:#990000;';
		}
		else
		{
			$font_weight = 'font-weight:normal';
		}
		
		/*
		| ------------------------------------------------------------------------------------------
		| List subcategory
		*/
		echo anchor($url_link.'/'.$item['sc_url_structure'], $item['subcat_name'], array('style' => $font_weight)).'<br>';
		
		/*
		| ------------------------------------------------------------------------------------------
		| Check for subsbucats
		*/
		$subsubcat = $this->query_category->get_subsubcat_new($item['sc_url_structure']);
		
		//if ($this->uri->segment(2) && $subsubcat->num_rows() > 0 && $this->set->get_id($this->uri->segment(2)) == $item['subcat_id'])
		if ($this->uri->segment(2) && $subsubcat->num_rows() > 0)
		{
			foreach ($subsubcat->result_array() as $sub_item)
			{
				$a_link = $url_link.'/'.$item['sc_url_structure'].'/'.$sub_item['ssc_url_structure'];
				
				// Some styles
				if ($this->uri->segment(1) && $this->uri->segment(1) && $this->uri->segment(3) == $sub_item['ssc_url_structure'])
				{
					$sub_font_weight = 'font-weight:normal;color:#990000;';
				}
				else
				{
					$sub_font_weight = 'font-weight:normal';
				}
				
				echo '&nbsp; &nbsp; &nbsp; '.anchor($a_link, $sub_item['subsubcat_name'], array('style' => $sub_font_weight)).'<br>';
			}
		}
	}
}
else
{
	echo 'No category return';
}
