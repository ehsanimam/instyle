<?php
if ($left_nav_sql->num_rows() > 0)
{
	foreach ($left_nav_sql->result() as $item)
	{
		/*
		| ------------------------------------------------------------------------------------------
		| Set the links
		*/
		$url  	 = '';
		$cat	 = str_replace('.html','',$this->uri->segment(1));
		if ($cat == 'new-arrival-designer' OR $cat == 'new-arrival-designer-facets')
		{
			$url 	.= 'new-arrival-designer/';			
		}
		elseif ($cat == 'clearance-designer' OR $cat == 'clearance-designer-facets')
		{
			$url 	.= 'clearance-designer/';		
		}
		else
		{
			$url 	.= $item->c_url_structure.'-designer-'.$item->cat_id.'/';		
		}		
		$url 	.= $item->d_url_structure.'-'.$item->des_id;
		
		/*
		| ------------------------------------------------------------------------------------------
		| Designer heading
		*/
		echo anchor($url.'.html',$item->designer,array('style'=>'color:#000;font-weight:bold;')).'<br>';
		
		/*
		| ------------------------------------------------------------------------------------------
		| Query the subcat falling under the designer
		*/
		if ($cat == 'new-arrival-designer' OR $cat == 'new-arrival-designer-facets')
		{
			$subcat	= $subcat = $this->query_category->get_newarrival_bydesigner($item->des_id);
		}
		elseif ($cat == 'clearance-designer' OR $cat == 'clearance-designer-facets')
		{
			$subcat	= $this->query_category->get_clearance_bydesigner($item->des_id);
		}
		else
		{
			$subcat = $this->query_category->get_category_bydesigner($item->des_id, $item->cat_id);	
		}
		
		if ($subcat->num_rows() > 0)
		{
			foreach ($subcat->result() as $sub_item)
			{
				$a_url = $url.'/'.$sub_item->url_structure.'-'.$sub_item->subcat_id.'.html';
				if ($this->uri->segment(3))
				{
					//$bold = $this->set->get_id($this->uri->segment(3)) == $sub_item->subcat_id ? 'color:#000' : '';
					if ($this->set->get_id($this->uri->segment(3)) == $sub_item->subcat_id && $this->set->get_id($this->uri->segment(2)) == $item->des_id)
					{
						$bold = 'color:#000';
					}
					else
					{
						$bold = '';
					}
				}
				echo anchor($a_url,$sub_item->subcat_name,array('style'=>@$bold)).'<br>';
			}
		}
	}
}
else
{
	echo 'No designer return';
}

