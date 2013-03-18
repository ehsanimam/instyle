<?php

if(!function_exists('create_breadcrumb')){
	function create_breadcrumb(){
	  $ci = &get_instance();
	  $i=1;
	  $uri = $ci->uri->segment($i);
	  $link = '<div>';
	 
	  while($uri != ''){
		$prep_link = '';
	  for($j=1; $j<=$i;$j++){
		$prep_link .= $ci->uri->segment($j).'/';
	  }
	 	
		  $uri_segment = explode('-',$ci->uri->segment($i));
		  if($uri_segment[0] == 'page') {
		  	$page = (substr($uri_segment[1],1) / $ci->config->item('items_per_page')) + 1;
		  	$uri_segment = $uri_segment[0].'-'.floor($page);
		  } else {
		  	if($uri_segment[0]=='item' || $uri_segment[0]=='color') {
				$uri_segment = $uri_segment[1];
				$set_link 	 = true;
			} else {
		  		$uri_segment = $uri_segment[0];
				$set_link 	 = false;
			}
		  }
	 		
			$cat = explode('-',$ci->uri->segment(1));
			$cat_count = count($cat)-1;
			$get_cat = $ci->db->get_where('tblcat',array('cat_id'=>substr($cat[$cat_count],1)));
			$get_cat = $get_cat->row();
			
		  if($ci->uri->segment($i+1) == ''){
			$link.='<span style="list-style:none;padding:0px;margin:0px;">'.img('images/arrow_small.gif').' <a href="'.site_url($prep_link).'" style="color:#000;"><b>'.ucfirst($uri_segment).'</b></a></span> ';
		  }else{
		  
		  	if($set_link) {
				$link.='<span> '.img('images/arrow_small.gif').' '.ucfirst($uri_segment).'</span> ';
			} else {
				$link.='<span> '.img('images/arrow_small.gif').' <a href="'.site_url($prep_link).'.html" style="color:#666666;">'.ucfirst($uri_segment).'</a></span> ';
			}
		  }
	 
	  $i++;
	  $uri = $ci->uri->segment($i);
	  }
		$link .= '</div>';
		return $link;
	}
  
	function create_breadcrumb_product()
	{
		$ci = &get_instance();
		$i = 1;
		$uri = $ci->uri->segment($i);
		$link = '<div>';
		
		while ($uri != '')
		{
			$prep_link = '';
			
			for ($j = 1; $j <= $i; $j++)
			{
				$prep_link .= $ci->uri->segment($j).'/'; // --> category (seg 1)
			}
	 	
			$uri_segment = explode('-',$ci->uri->segment($i));
			
			if ($uri_segment[0] == 'page') // --> depracated
			{
				$page = (substr($uri_segment[1],1) / $ci->config->item('items_per_page')) + 1;
				$uri_segment = $uri_segment[0].'-'.floor($page);
			}
			else
			{
				if ($uri_segment[0] == 'item' || $uri_segment[0] == 'color') // --> depracated
				{
					$uri_segment = $uri_segment[1];
					$set_link 	 = true;
				}
				else
				{
					$uri_segment = $uri_segment[0];
					$set_link 	 = false;
				}
			}
			
			if ($ci->uri->segment($i + 1) == '')
			{
				$link.='<span style="list-style:none;padding:0px;margin:0px;"> '.img('images/arrow_small.gif').' <a href="'.site_url($prep_link).'" style="color:#000;"><b>'.ucfirst(substr($uri_segment,0,-5)).'</b></a></span> ';
			}
			else
			{
				if ($set_link)
				{
					$link .= '<span> '.img('images/arrow_small.gif').' '.ucfirst($uri_segment).'</span> ';
				}
				else
				{
					$link .= '<span> '.img('images/arrow_small.gif').' <a href="'.site_url($prep_link).'.html" style="color:#666666;">'.ucfirst($uri_segment).'</a></span> ';
				}
			}
	 
			$i++;
			$uri = $ci->uri->segment($i);
		}
		$link .= '</div>';
		return $link;
	}
  
	function get_full_breadcrumb_url()
	{
		$ci 	= &get_instance();
		$i		= 1;
		$uri 	= $ci->uri->segment($i);
		$link 	= '';
	 
		while ($uri != '')
		{
			$uri_segment = $ci->uri->segment($i);
			$link .= '/'.$uri_segment;
			$i++;
			$uri = $ci->uri->segment($i);
		}
		
		return $link;
	}
  
	function generate_breadcrumb($prod)
	{
		$ci = &get_instance();
		$bread = explode('/', get_full_breadcrumb_url());
		$count = count($bread) - 1;	
		
		$pref = explode('-',$ci->uri->segment(1));
		
		if ( ! in_array('designer', $pref)) // --> non-designer uri
		{
			$i = 1;
			foreach ($bread as $b)
			{
				if ($i == 1)
				{
					//category
					if ($ci->uri->segment(1) === 'sa')
					{
						$seg_num = $i + 1;
						$link_1 = 'sa/'.str_replace('-facets','',$ci->uri->segment($seg_num));
					}
					else
					{
						$seg_num = $i;
						$link_1 = str_replace('-facets','',$ci->uri->segment($seg_num));
					}
					
					$title_1 = $ci->uri->segment(1) === 'clearance' ? 'Clearance' : 'Collections';
					
					// html for bread 1
					echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor($link_1, $title_1);
					
				}
				elseif ($i == 2)
				{
					$wHtml = $count == 4 ? '.html' : '';
					
					//subcategory
					if ($count = 2 && $ci->uri->segment(1) !== 'sa')
					{
						$boldO = '<b>';
						$boldC = '</b>';
						$seg_num = $i;
						$link_2 = str_replace('-facets', '', $ci->uri->segment(1)).'/'.$ci->uri->segment($seg_num).$wHtml;
					}
					elseif ($count == 2 || $ci->set->ifpaging($ci->uri->segment(3)) || ($count = 3 && $ci->uri->segment(1) === 'sa'))
					{
						$boldO = '<b>';
						$boldC = '</b>';
						$seg_num = $i + 1;
						$link_2 = 'sa/'.str_replace('-facets','',$ci->uri->segment(2)).'/'.$ci->uri->segment($seg_num).$wHtml;
					}
					else
					{
						$boldO = '';
						$boldC = '';
						$seg_num = $i;
						$link_2 = str_replace('-facets','',$ci->uri->segment(1)).'/'.$ci->uri->segment($seg_num).$wHtml;
					}
					
					$title_2 = $ci->uri->segment(1) === 'clearance' ? 'Clearance' : 'Collections';
					
					// html for bread 2
					echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor($link_2, $boldO.$prod->subcat_name.$boldC);
				}
		// add 3 for subsubcat
				elseif ($i == 3)
				{
					// original 3rd bread crumb ($i == 3 && $count == 3 && !$ci->set->ifpaging($ci->uri->segment(3)))
					if ($count == 3 && !$ci->set->ifpaging($ci->uri->segment(3)))
					{
						echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor(str_replace('-facets','',$ci->uri->segment(1)).'/'.$ci->uri->segment(2).'/'.$ci->uri->segment(3),'<b>'.@$prod->subsubcat_name.'</b>');
					}
					else
					{
						$wHtml = $count == 5 ? '.html' : '';
						
						//subcategory
						if ($count == 3 || $ci->set->ifpaging($ci->uri->segment(4)) || ($count = 4 && $ci->uri->segment(1) === 'sa'))
						{
							$boldO = '<b>';
							$boldC = '</b>';
							$seg_num = $i + 1;
							$link_2 = 'sa/'.$ci->uri->segment(2).'/'.str_replace('-facets','',$ci->uri->segment(3)).'/'.$ci->uri->segment($seg_num).$wHtml;
						}
						else
						{
							$boldO = '';
							$boldC = '';
							$seg_num = $i;
							$link_2 = str_replace('-facets','',$ci->uri->segment(1)).'/'.$ci->uri->segment(2).'/'.$ci->uri->segment($seg_num).$wHtml;
						}
						
						$title_2 = $ci->uri->segment(1) === 'clearance' ? 'Clearance' : 'Collections';
						
						echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor($link_2, $boldO.$prod->subsubcat_name.$boldC);
					}
				}
		// change to 4
				elseif ($i == 4 && $count == 4 && !$ci->set->ifpaging($ci->uri->segment(4)))
				{
					echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor(str_replace('-facets','',$ci->uri->segment(1)).'/'.$ci->uri->segment(2).'/'.$ci->uri->segment(3).'/'.$ci->uri->segment(4), '<b>'.@$prod->subsubcat_name.'</b>');
				}
				
				$i++;
			}
		}
		else
		{
			
			$i = 1;
			foreach ($bread as $b)
			{
				if ($i == 1)
				{
					//category
					echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor(str_replace('-facets','',$ci->uri->segment($i)),$prod->cat_name);
				}
				elseif ($i == 2)
				{
					//designer
					if ($count == 2 || $ci->set->ifpaging($ci->uri->segment(3)))
					{
						$boldO = '<b>';
						$boldC = '</b>';
					}
					else
					{
						$boldO = '';
						$boldC = '';
					}
					
					$wHtml = $count == 3 ? '.html' : '';
					echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor(str_replace('-facets','',$ci->uri->segment(1)).'/'.$ci->uri->segment($i).$wHtml,$boldO.$prod->designer.$boldC);
				}
				elseif ($i == 3 && $count == 3 && !$ci->set->ifpaging($ci->uri->segment(3)))
				{
					//subcategory
					echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor(str_replace('-facets','',$ci->uri->segment(1)).'/'.$ci->uri->segment(2).'/'.$ci->uri->segment(3),'<b>'.$prod->subcat_name.'</b>');
				} 
				
				$i++;
			}
		}
		
		/*
		if($pref == 'c' || $pref == 's') {
						
			$i=1;
			foreach($bread as $b) {
				if($i == 1) {
					//category
					echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor($ci->uri->segment(1).'.html',$prod->cat_name);
					
				} elseif($i == 2) {
					//subcategory
					if($count == 2 || $ci->set->ifpaging($ci->uri->segment(3))) {
						$boldO = '<b>';
						$boldC = '</b>';
					} else {
						$boldO = '';
						$boldC = '';
					}
					$wHtml = $count == 3 ? '.html' : '';
					echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor($ci->uri->segment(1).'/'.$ci->uri->segment(2).$wHtml,$boldO.$prod->subcat_name.$boldC);					
				} elseif($i == 3 && $count == 3 && !$ci->set->ifpaging($ci->uri->segment(3))) {
					echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor($ci->uri->segment(1).'/'.$ci->uri->segment(2).'/'.$ci->uri->segment(3),'<b>'.@$prod->subsubcat_name.'</b>');
				}
				
			$i++;
			}
		} else {
			$i=1;
			foreach($bread as $b) {
				
				if($i == 1) {
					//category
					echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor($ci->uri->segment(1).'.html',$prod->cat_name);
					
				} elseif($i == 2) {
					//designer
					if($count == 2 || $ci->set->ifpaging($ci->uri->segment(3))) {
						$boldO = '<b>';
						$boldC = '</b>';
					} else {
						$boldO = '';
						$boldC = '';
					}
					$wHtml = $count == 3 ? '.html' : '';
					echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor($ci->uri->segment(1).'/'.$ci->uri->segment(2).$wHtml,$boldO.$prod->designer.$boldC);
					
				} elseif($i == 3 && $count == 3 && !$ci->set->ifpaging($ci->uri->segment(3))) {
					//subcategory
					echo img(array('src'=>'images/arrow_small.gif','style'=>'margin:0px 2px;')).anchor($ci->uri->segment(1).'/'.$ci->uri->segment(2).'/'.$ci->uri->segment(3),'<b>'.$prod->subcat_name.'</b>');
					
				} 
				
			$i++;
			}
		}
		*/
	 }
}   

?>