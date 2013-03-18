<?php

	// ----------------------------------------------
	// --> Create Pagination
	function l_create_pagination($page, $items_total, $limit, $list)
	{
		$number_of_pages = ceil($items_total / $limit);
		$p_before_and_after = 3;
		$p = 1;
		
		$html = '';
		
		// the HTML
		if ($p == $page) $html .= 'First';
		else $html .= '<a href="javascript:void();" onclick="goto(\'1\', \''.$list.'\')" title="First Page" name="First Page">First</a>';
		$html .= '&nbsp;';
		
		$prev = $page - 1;
		if ($p == $page) $html .= '&laquo;';
		else $html .= '<a href="javascript:void();" onclick="goto(\'1\', \''.$list.'\')" title="Previous" name="Previous">&laquo;</a>';
		$html .= '&nbsp;';
		
		if ($page > ($p_before_and_after + 1) && $p < ($page - $p_before_and_after)) { $html .= '...&nbsp;'; $p++; }
		while ($p < ($page - $p_before_and_after)) { $p++; }
		
		if ($p < $page && ($page - $p) <= $p_before_and_after)
		{	
			while (($page - $p) > 0)
			{
				if ($p == $page) $html .= $p;
				else $html .= '<a href="javascript:void();" onclick="goto(\''.$p.'\', \''.$list.'\')" title="Page '.$p.'" name="Page '.$p.'">'.$p.'</a>';
				$html .= '&nbsp;';
				$p++;
			}
		}
		
		if ($p == $page) $html .= $p;
		else $html .= '<a href="javascript:void();" onclick="goto(\''.$p.'\', \''.$list.'\')" title="Page '.$p.'" name="Page '.$p.'">'.$p.'</a>';
		$html .= '&nbsp;';
		$p++;
		
		if ($p > $page && $p <= $number_of_pages)
		{
			while (($p - $page) <= $p_before_and_after)
			{
				if ($p < ($number_of_pages + 1))
				{
					if ($p == $page) $html .= $p;
					else $html .= '<a href="javascript:void();" onclick="goto(\''.$p.'\', \''.$list.'\')" title="Page '.$p.'" name="Page '.$p.'">'.$p.'</a>';
					$html .= '&nbsp;';
				}
				$p++;
			}
		}
		
		if ($p < $number_of_pages) $html .= '...&nbsp;';
		
		$next = $page + 1;
		if ($number_of_pages == $page) $html .= '&raquo;';
		else $html .= '<a href="javascript:void();" onclick="goto(\''.$next.'\', \''.$list.'\')" title="Next" name="Next">&raquo;</a>';
		$html .= '&nbsp;';
		
		if ($number_of_pages == $page) $html .= 'Last';
		else $html .= '<a href="javascript:void();" onclick="goto(\''.$number_of_pages.'\', \''.$list.'\')" title="Last Page" name="Last Page">Last</a>';
		$html .= '&nbsp;';
		
		return $html;
	}
	
