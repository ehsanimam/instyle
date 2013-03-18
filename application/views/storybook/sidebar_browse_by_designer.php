<?php
if ($left_nav_sql->num_rows() > 0)
{
	foreach ($left_nav_sql->result_array() as $item) // ---> foreach designer
	{
		/*
		| ------------------------------------------------------------------------------------------
		| Set the base link
		*/
		$url_link = '';
		
		// Some styles
		if ($this->uri->segment(1) && $this->uri->segment(1) == $item['d_url_structure'])
		{
			$font_weight = 'font-weight:bold;color:#990000;';
		}
		else
		{
			$font_weight = 'font-weight:bold;color:#000;';
		}
		
		/*
		| ------------------------------------------------------------------------------------------
		| Query the subcat falling under the designer with products
		*/
		$subcat = $this->query_category->get_category_bydesigner_new($item['d_url_structure'], $item['c_url_structure']);
		
		if ($subcat->num_rows() > 0)
		{
			$row1 = $subcat->row_array();
		
			/*
			| ------------------------------------------------------------------------------------------
			| Designer heading
			| Putting it in here so that it will only display if there are products on subcats within it
			*/
			echo anchor($item['d_url_structure'], $item['designer'], array('style' => $font_weight)).'<br>';
		
			foreach ($subcat->result_array() as $sub_item) // ---> foreach subcat
			{
				$a_link = $item['d_url_structure'].'/'.$sub_item['sc_url_structure'];
				
				if ($this->uri->segment(2))
				{
					// Some styles
					if ($this->uri->segment(1) == $item['d_url_structure'] && ($this->uri->segment(2) == $sub_item['sc_url_structure'] OR $sc_url_structure == $sub_item['sc_url_structure']))
					{
						$bold = 'color:#990000';
					}
					else
					{
						$bold = '';
					}
				}
				
				echo anchor($a_link, $sub_item['subcat_name'], array('style' => @$bold)).'<br>';
			}
		}
	}
}
else
{
	echo 'No designer return';
}

