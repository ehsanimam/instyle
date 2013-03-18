<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query_page extends CI_Model {

	function get_qty() {
		$html = '<script>
				function getXMLHTTP() { //fuction to return the xml http object
						var xmlhttp=false;	
						try
						{
							xmlhttp=new XMLHttpRequest();
						}
						catch(e)
						{
							try
							{
								xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
							}
							catch(e)
							{
								try
								{
									xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
								}
								catch(e1)
								{
									xmlhttp=false;
								}
							}
						}
						return xmlhttp;
					}
					
				function getQty(strURL)
				{
					var req = getXMLHTTP();
					if (req)
					{
						req.onreadystatechange = function() {
							if (req.readyState == 4)
							{
								// only if "OK"
								if (req.status == 200)
								{
									document.getElementById(\'qtydiv\').innerHTML=req.responseText;
								}
								else
								{
									alert("There was a problem while using XMLHTTP:\n" + req.statusText);
								}
							}				
						}
						req.open("GET", strURL, true);
						req.send(null);
					}
				}
				</script>';
		return $html;
	}
	
	function product_color_stocks($size, $color, $prod_no)
	{
		$size_name = 'size_'.$size;
		
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT $size_name 
			FROM tbl_stock 
			WHERE color_name = '".str_replace('%20',' ',$color)."' 
				AND prod_no = '".$prod_no."'
		");
		
		return $q;
	}
	
	function get_tblsize_modal()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("SELECT * FROM tblsize where bust<>'0' and size_name<>'fs'");
		return $q;
	}
	
	function get_slides()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query('SELECT * FROM tbl_index_image ORDER BY seq');
		return $q;
	}	
	
	/*
	| -----------------------------------------------------------------------------------
	| Changing url structure with pages using title codes instead of page_id
	*/
	function get_page($title_code)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('pages',array('title_code'=>$title_code));
		return $q;
	}
	// above to change below (below for commenting out)
	function get_page_($page_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('pages',array('page_id'=>$page_id));
		return $q;
	}
	/*-----------------------------------------------------------------------------------*/
	
	function get_country()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query('select * from tblcountry order by seq desc, countries_name');
		return $q;
	}
	
	function get_states()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get('tblstates');
		return $q;
	}
	
	function get_press()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get('tbl_press');
		return $q;
	}
	
	/*
	| -----------------------------------------------------------------------------------
	| Added query for tbl_newsletter
	*/
	function get_newsletter($n_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('tbl_newsletter',array('newsletter_id'=>$n_id));
		return $q;
	}
	
	/*
	/  pages
	*/
	
	function check_page_meta($n_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('tblmeta',array('pagename' => $n_id . '.php'));
		return $q;
	}
	
	function get_page_meta($n_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('tblmeta',array('pagename' => $n_id . '.php'));
		return $q;
	}
	
	function just_pages()
	{
		//$DB3 = $this->_load_db();
		$this->db->select('pagename');
		$this->db->from('tblmeta');
		$q = $this->db->get();
		return $q->result_array();
	}

/*	
	function _load_db()
	{
		// load the respective database
		switch (ENVIRONMENT)
		{
			case 'development':
				$DB = $this->load->database('local', TRUE);
			break;

			case 'testing':
			default:
				$DB = $this->load->database('instylemoscow', TRUE);
		}
		
		return $DB;
	}
*/
}
