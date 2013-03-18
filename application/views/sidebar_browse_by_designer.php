<?php
if ($left_nav_sql->num_rows() > 0)
{
	foreach ($left_nav_sql->result_array() as $item)
	{
		/*
		| ------------------------------------------------------------------------------------------
		| Set the links
		*/
		$url = $this->uri->segment(1);
		
		/*
		| ------------------------------------------------------------------------------------------
		| Designer heading
		*/
		echo anchor($url.'/'.$item['d_url_structure'], $item['designer'], array('style'=>'color:#000;font-weight:bold;')).'<br>';
		
		/*
		| ------------------------------------------------------------------------------------------
		| Query the subcat falling under the designer
		*/
		$subcat = $this->query_category->get_category_bydesigner($item['des_id'], $item['cat_id']);	
		
		if ($subcat->num_rows() > 0)
		{
			foreach ($subcat->result_array() as $sub_item)
			{
				$a_url = $url.'/'.$item['d_url_structure'].'/'.$sub_item['url_structure'];
				if ($this->uri->segment(3))
				{
					//$bold = $this->set->get_id($this->uri->segment(3)) == $sub_item->subcat_id ? 'color:#000' : '';
					if ($this->set->get_id($this->uri->segment(3)) == $sub_item['subcat_id'] && $this->set->get_id($this->uri->segment(2)) == $item['des_id'])
					{
						$bold = 'color:#000';
					}
					else
					{
						$bold = '';
					}
				}
				echo anchor($a_url, $sub_item['subcat_name'], array('style' => @$bold)).'<br>';
			}
		}
	}
}
else
{
	echo 'No designer return';
}

