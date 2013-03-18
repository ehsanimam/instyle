<?php
	function products_count()
	{
		$sel = "SELECT * FROM designer ORDER BY designer ASC";
		$qry = mysql_query($sel) or die('Get Designers Error - '.mysql_error());
		
		return $qry;
	}

	function create_pagination($page, $items_total, $limit, $sel)
	{
		$number_of_pages = ceil($items_total / $limit);
		$p_before_and_after = 3;
		$p = 1;
		
		//$link_url = $_SERVER['QUERY_STRING'] == '' ? $_SERVER['REQUEST_URI'].'?' : $_SERVER['REQUEST_URI'].'&';
		
		$html = '';
		
		// the HTML
		if ($p == $page) $html .= 'First';
		else $html .= '<a href="javascript:void();" onclick="goto(\'1\', \''.$sel.'\')" title="First Page" name="First Page">First</a>';
		$html .= '&nbsp;';
		
		$prev = $page - 1;
		if ($p == $page) $html .= '&laquo;';
		else $html .= '<a href="javascript:void();" onclick="goto(\'1\', \''.$sel.'\')" title="Previous" name="Previous">&laquo;</a>';
		$html .= '&nbsp;';
		
		if ($page > ($p_before_and_after + 1) && $p < ($page - $p_before_and_after)) { $html .= '...&nbsp;'; $p++; }
		while ($p < ($page - $p_before_and_after)) { $p++; }
		
		if ($p < $page && ($page - $p) <= $p_before_and_after)
		{	
			while (($page - $p) > 0)
			{
				if ($p == $page) $html .= $p;
				else $html .= '<a href="javascript:void();" onclick="goto(\''.$p.'\', \''.$sel.'\')" title="Page '.$p.'" name="Page '.$p.'">'.$p.'</a>';
				$html .= '&nbsp;';
				$p++;
			}
		}
		
		if ($p == $page) $html .= $p;
		else $html .= '<a href="javascript:void();" onclick="goto(\''.$p.'\', \''.$sel.'\')" title="Page '.$p.'" name="Page '.$p.'">'.$p.'</a>';
		$html .= '&nbsp;';
		$p++;
		
		if ($p > $page && $p <= $number_of_pages)
		{
			while (($p - $page) <= $p_before_and_after)
			{
				if ($p < ($number_of_pages + 1))
				{
					if ($p == $page) $html .= $p;
					else $html .= '<a href="javascript:void();" onclick="goto(\''.$p.'\', \''.$sel.'\')" title="Page '.$p.'" name="Page '.$p.'">'.$p.'</a>';
					$html .= '&nbsp;';
				}
				$p++;
			}
		}
		
		if ($p < $number_of_pages) $html .= '...&nbsp;';
		
		$next = $page + 1;
		if ($number_of_pages == $page) $html .= '&raquo;';
		else $html .= '<a href="javascript:void();" onclick="goto(\''.$next.'\', \''.$sel.'\')" title="Next" name="Next">&raquo;</a>';
		$html .= '&nbsp;';
		
		if ($number_of_pages == $page) $html .= 'Last';
		else $html .= '<a href="javascript:void();" onclick="goto(\''.$number_of_pages.'\', \''.$sel.'\')" title="Last Page" name="Last Page">Last</a>';
		$html .= '&nbsp;';
		
		return $html;
	}
	
	function update_sequence($post_ary)
	{
		$sqlQ = "SELECT * FROM tbl_product WHERE designer = '".$post_ary['des_id']."' ORDER BY seque ASC, prod_no ASC";
		
		if ( ! empty($_POST['psc']))
		{
			$sqlQ = "SELECT * FROM tbl_product WHERE prod_no LIKE '%".trim($_POST['psc'])."%'";
		}	

		$resQ = mysql_query($sqlQ);
		
		while ($rowQ = mysql_fetch_array($resQ))
		{
			$v = $rowQ['prod_no'];

			if (isset($post_ary['seq'.$v]) && ($rowQ['seque'] != $post_ary['seq'.$v]) && ($post_ary['seq'.$v] != ''))
			{
				$SQLss = "UPDATE tbl_product SET seque = '".$post_ary['seq'.$v]."' WHERE prod_no = '".$rowQ['prod_no']."'";
				$RESss = mysql_query($SQLss) or die ('Seq update error: '.mysql_error());
				
				// free up mysql memory
				mysql_free_result($RESss);
			}
		}
		
		// free up mysql memory
		mysql_free_result($resQ);
		
		// --------------------------------------------------------------------
		// ---> Sequencing is independent of each site.
		// commenting this section of the code
		/*
		// connet to remote db
		$host_remote="64.207.150.168";
		$username_remote="joereyrusty_icm";
		$password_remote="!@R00+@dm!N";
		$db_remote="icmbasix_main";
		
		// ---> update remote db
		// connet to remote db
		$conn_remote = mysql_connect($host_remote,$username_remote,$password_remote);
		mysql_select_db($db_remote,$conn_remote);
		
			$sqlQ2 = "SELECT * FROM tbl_product WHERE designer = '".$post_ary['des_id']."' ORDER BY seque ASC, prod_no ASC";
			
			if ( ! empty($_POST['psc']))
			{
				$sqlQ2 = "SELECT * FROM tbl_product WHERE prod_no LIKE '%".trim($_POST['psc'])."%'";
			}	

			$resQ2 = mysql_query($sqlQ2);
			
			while ($rowQ2 = mysql_fetch_array($resQ2))
			{
				$v = $rowQ2['prod_no'];

				if (isset($post_ary['seq'.$v]) && ($rowQ['seque'] != $post_ary['seq'.$v]) && ($post_ary['seq'.$v] != ''))
				{
					$SQLss2 = "UPDATE tbl_product SET seque = '".$post_ary['seq'.$v]."' WHERE prod_no = '".$rowQ2['prod_no']."'";
					$RESss2 = mysql_query($SQLss2) or die ('Seq update error: '.mysql_error());
					
					// free up mysql memory
					mysql_free_result($RESss2);
				}
			}
			
			// free up mysql memory
			mysql_free_result($resQ2);
			
		// close remote db connection
		mysql_close($conn_remote);
		*/
	}
	
	function update_publish($get_ary, $post_variable)
	{
		$pub_loc = substr($get_ary['pn'], 0, 1);
		$prod_no = substr($get_ary['pn'], 1);
		
		$sql_pub = "SELECT * FROM tbl_product WHERE prod_no = '".$prod_no."'";
		$res_pub = mysql_query($sql_pub) or die('Select error - '.mysql_error());
		$row_pub = mysql_fetch_array($res_pub);

		if ($row_pub['view_status'] == 'Y')
		{
			if ($pub_loc == 1 && $post_variable != 'Y') $val = 'Y2';
			if ($pub_loc == 2 && $post_variable != 'Y') $val = 'Y1';
		}
		if ($row_pub['view_status'] == 'Y1')
		{
			if ($pub_loc == 1 && $post_variable != 'Y') $val = 'N';
			if ($pub_loc == 2 && $post_variable == 'Y') $val = 'Y';
		}
		if ($row_pub['view_status'] == 'Y2')
		{
			if ($pub_loc == 1 && $post_variable == 'Y') $val = 'Y';
			if ($pub_loc == 2 && $post_variable != 'Y') $val = 'N';
		}
		if ($row_pub['view_status'] == '') // ---> in case empty from old record
		{
			if ($pub_loc == 1 && $post_variable == 'Y') $val = 'Y1';
			if ($pub_loc == 2 && $post_variable == 'Y') $val = 'Y2';
		}
		
		// free up mysql memory
		mysql_free_result($row_pub);
		
		$sql_up = "UPDATE tbl_product SET view_status = '".$val."' WHERE prod_no = '".$prod_no."'";
		$res_up = mysql_query($sql_up) or die('View status update error: '.mysql_error());
		
		// free up mysql memory
		mysql_free_result($res_up);
		
		$host_remote="216.70.104.66";
		$username_remote="joe_taveras";
		$password_remote="!@R00+@dm!N";
		$db_remote="joe_moscow";

		// ---> update remote db
		// connet to remote db
		$conn_remote = mysql_connect($host_remote,$username_remote,$password_remote);
		mysql_select_db($db_remote,$conn_remote);
		
			$res_up2 = mysql_query($sql_up) or die('View status update error: '.mysql_error());
			
			// free up mysql memory
			mysql_free_result($res_up2);
			
		// close remote db connection
		mysql_close($conn_remote);
	}
	