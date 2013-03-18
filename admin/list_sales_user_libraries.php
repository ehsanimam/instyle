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
	
// ----------------------------------------------
// --> validate email
function validate_email($email)
{
	if ( ! preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i', $email))
	{
		return FALSE;
	}
	else
	{
		if (substr_count($email,"@") != 1 || stristr($email," ") || stristr($email,"\\") || stristr($email,":"))
		{
			return FALSE;
		}
		else
		{
			$exploded_email = explode("@",$email);
			if (empty($exploded_email[0]) || strlen($exploded_email[0]) > 64 || empty($exploded_email[1]))
			{
				return FALSE;
			}
			else
			{
				if (substr_count($exploded_email[1],".") == 0)
				{
					return FALSE;
				}
				else
				{
					$exploded_domain = explode(".",$exploded_email[1]);
					if (in_array("",$exploded_domain))
					{
						return FALSE;
					}
					else
					{
						foreach($exploded_domain as $value)
						{
							if (strlen($value) > 63 || !preg_match('/^[a-z0-9-]+$/i',$value))
							{
								$bad_match = 1;
								return FALSE;
								break;
							}
						}
					}
				}
			}
		}
	}
	
	return TRUE;
}

// ----------------------------------------------
// --> insert new user
function add_user($post_ary)
{
	$sa_user = $post_ary['sa_user'];
	$sa_lname = $post_ary['sa_lname'];
	$sa_email = $post_ary['sa_email'];
	$sa_pword = $post_ary['sa_pword'];
	
	$txt = "
		INSERT INTO tbladmin_sales (
			admin_sales_email,
			admin_sales_password,
			admin_sales_user,
			admin_sales_lname
		) VALUES (
			'".$sa_email."',
			'".md5($sa_pword)."',
			'".$sa_user."',
			'".$sa_lname."'
		)
	";
	$qry = mysql_query($txt) or die('Insert sales user error: '.mysql_error());
}

