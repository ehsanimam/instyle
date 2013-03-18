<?php if ( ! defined('BASEPATH')) exit('ERROR 404: Page not found');
class Set extends CI_Model
{
	function errorMsg($msg)
	{
		$msg = '<div class="errorMsg">'.$msg.'</div>';
		return $msg;
	}
	
	function successMsg($msg)
	{
		$msg = '<div class="successMsg">'.$msg.'</div>';
		return $msg;
	}
	
	function navigation($nav)
	{
		$data = array(
			'navigation'	=> $nav
		);
		$this->session->set_userdata($data);
		return $this;
	}
	
	function jquery()
	{
		$jquery = '<script type="text/javascript" src="'.base_url().'jscript/jquery-1.4.2.js"></script>';
		return $jquery;
	}
	
	function jquery_ui()
	{
		$jquery = '
			<link type="text/css" href="'.base_url().'jscript/themes/base/jquery.ui.all.css" rel="stylesheet" />
			<script type="text/javascript" src="'.base_url().'jscript/external/jquery.bgiframe-2.1.3.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.core.js"></script>					
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.widget.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.mouse.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.button.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.draggable.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.position.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.dialog.js"></script>
		';
		return $jquery;
	}
	
	function jquery_fancybox()
	{
		$jquery = '
			<script type="text/javascript" src="'.base_url().'jscript/fancybox/jquery.fancybox-1.3.1.js"></script>
			<link rel="stylesheet" type="text/css" href="'.base_url().'jscript/fancybox/jquery.fancybox-1.3.1.css" media="screen" />
			<script type="text/javascript">
				$(document).ready(function() {
					$("a.sa_thumbs_group").fancybox({
						"padding"			: 20,
						"cyclic"			: true,
						"autoScale"			: false,
						"showCloseButton"	: true,
						"showNavArrows"		: true,
						"width"				: 750,
						"height"			: "auto",
						"transitionIn"		: "fade",
						"transitionOut"		: "fade"
					});
				});
			</script>
		';
		return $jquery;
	}
	
	function date_picker()
	{
		$html = '<link type="text/css" href="'.base_url().'jscript/themes/base/jquery.ui.all.css" rel="stylesheet" />
					<script type="text/javascript" src="'.base_url().'jscript/jquery-1.4.2.js"></script>
					<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.core.js"></script>
					<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.widget.js"></script>				
					<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.datepicker.js"></script>
					<script type="text/javascript">
					$(function() {
						$(\'#datepicker\').datepicker({
							showButtonPanel: true,
							dateFormat:	\'yy-mm-dd\'
						});
					});
					</script>
					<style type="text/css">
					.ui-datepicker { font-size:11px; }
					</style>';
		return $html;
	}
	
	function confirm_dialog()
	{	
		$dlg = '';
		$s   = 10;
		if ($this->uri->segment(3) == 'withdraw_ewallet' || $this->uri->segment(3) == 'view_ewallet')
		{
			for ($i = 1; $i <= $s; $i++)
			{
				$dlg .= ' var dlg = $("#dialog'.$i.'").dialog({
									  modal: true,
									  height: 300,
									  width: 700,
									  autoOpen: false
							});
			
							$("#opener'.$i.'").click(function() {
								$(\'#dialog'.$i.'\').dialog(\'open\');
								 $(\'#dialog'.$i.'\').dialog(\'option\', \'buttons\', { 
								"Ok": function() { $(this).dialog("close"); }
								 });
								return false;
							});
							dlg.parent().appendTo($("#frmWithdraw"));';
			}
		}
	
		$html = '<link type="text/css" href="'.base_url().'jscript/themes/base/jquery.ui.all.css" rel="stylesheet" />
				<script type="text/javascript" src="'.base_url().'jscript/jquery-1.4.2.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/external/jquery.bgiframe-2.1.1.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.core.js"></script>					
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.widget.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.mouse.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.button.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.draggable.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.position.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.dialog.js"></script>
				<script type="text/javascript">
				$(function(){
					    $("#confirmDelete").dialog({
								  modal: true,
								  height: 190,
								  width: 400,
								  autoOpen: false
						}); 
						
						'.$dlg.'
 
				  });
					
					function confirmDelete(name, urlid, msg) {
					  var delUrl = "'.site_url().'" + urlid;
					  $(\'#confirmDelete\').html(msg + ": \'" + name + "\'");
					  $(\'#confirmDelete\').dialog(\'option\', \'buttons\', { 
						"No": function() { $(this).dialog("close"); },
						"Yes": function() { window.location.href = delUrl; }  });
					  $(\'#confirmDelete\').dialog(\'open\');
					}												

				</script>';
		return $html;	
	}

	function autocomplete()
	{
		// added autocomplete.js for search queries
		$autocomplete_ja = '
			<link rel="stylesheet" type="text/css" href="'.base_url().'jscript/jquery-autocomplete/jquery.autocomplete.css" />
			<script type="text/javascript" src="'.base_url().'jscript/jquery-autocomplete/jquery.autocomplete.min.js"></script>
			<script type="text/javascript">
				$().ready(function() {
					$("#search_by_style").autocomplete("'.base_url().'jscript/jquery-autocomplete/get_style_list.php", {
						width: 158,
						matchContains: true,
						max: 20,
						selectFirst: false
					});
				});
			</script>
		';
		
		return $autocomplete_ja;
	}
	
	function pagination($base_url, $total_rows, $per_page, $cur_page)
	{
		$this->load->library('paging');
		
		$config  =  array('base_url'		=> $base_url, 
						  'total_rows'  	=> $total_rows, 
						  'per_page'	 	=> $per_page, 
						  'cur_page'	 	=> $cur_page, 
						  'first_link'   	=> img(array('src'=>base_url().'images/start_off.gif' ,'border'=>0,'class'=>'paging_img')).'Start',
						  'next_link'		=> img(array('src'=>base_url().'images/next_off.gif','border'=>0,'class'=>'paging_img')).'Next',
						  'prev_link'		=> img(array('src'=>base_url().'images/previous_off.gif','border'=>0,'class'=>'paging_img')).'Previous',
						  'last_link'		=> img(array('src'=>base_url().'images/end_off.gif','border'=>0,'class'=>'paging_img')).'End',
						  'first_tag_open'	=> ' <span class="text_small"> ',
						  'first_tag_close'	=> ' </span> ',
						  'last_tag_open'	=> ' <span class="text_small"> ',
						  'last_tag_close'	=> ' </span> ',
						  'next_tag_open'	=> ' <span class="text_small"> ', 
						  'next_tag_close'	=> ' </span> ',
						  'prev_tag_open'	=> ' <span class="text_small"> ',
						  'prev_tag_close'	=> ' </span> ',
						  'dropdown_class'  => '',
		                  'link_class'      => 'text_small'
		                  );
		                 
		$this->paging->initialize($config);

		$pagination  = $this->paging->first_link();
		$pagination .= $this->paging->prev_link();
		$pagination .= " <span class=\"text_small\">".$this->paging->page_details()."</span> ";
		$pagination .= $this->paging->next_link();
		$pagination .= $this->paging->last_link();
		return $pagination;
	}
	
	function fade_thumbs_js()
	{
		$html	= '
			<script type="text/javascript">
				$(document).ready(function(){
					$("img.a").hover(
						function() {
							$(this).stop().animate({"opacity": "0"}, "slow");
						},
						function() {
							$(this).stop().animate({"opacity": "1"}, "slow");
						}
					);
				});
			</script>
			<style>							
				div.fadehover {
					position: relative;
				}
				img.a {
					position: absolute;
					left: 0;
					top: 0;
					z-index: 10;
				}
				img.b {
					position: absolute;
					left: 0;
					top: 0;
					z-index: 1;
				}
			</style>
		';
		return $html;
	}
	
	function get_id($segment)
	{
		$getem 		= rtrim($segment,'.html');
		$getem 		= explode('-',$getem);
		$last_seg 	= count($getem) - 1;
		
		$new_getem	= $getem[$last_seg];
		
		return $new_getem;
	}
	
	function get_seg_prefix($segment)
	{
		$getem 		= explode('-',$segment);		
		$last_seg 	= count($getem) - 1;		
		
		$isHtml 	= $getem[$last_seg];
		
		return substr($isHtml,0,1);
	}
	
	function ifpaging($segment)
	{
		$getem 		= explode('-',$segment);			
		$isHtml 	= $getem[0];
	
		if ($isHtml == 'page')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function ifproduct()
	{
		$get_item = explode('/',$this->uri->uri_string());
		$count = count($get_item);
		
		if ($count > 5)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function get_prod_id()
	{
		$prod_id = $this->uri->segment(4);
		return $prod_id;
	}
	
	function get_color_code()
	{
		//$DB3 = $this->_load_db();
		$color_name = str_replace('_',' ',trim(strtoupper($this->uri->segment(5))));
		$get_color = $this->db->get_where('tblcolor',array('color_name'=>$color_name));
		$get_color = $get_color->row();
		
		if ( ! empty($get_color->color_code))
		{
			$color_code = $get_color->color_code;
		}
		else
		{
			$color_code = '';
		}
		
		return $color_code;
	}
	
	function get_top_navigation()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->get_where('tblcat',array('view_status'=>'Y'));
		return $q;
	}
	
	function get_category()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("select * from tblcat where view_status='Y' order by ordering asc ");
		return $q;
	}
	
	function get_subcategory($cat_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("
			SELECT
				sc.subcat_id, sc.subcat_name, sc.icon_img, sc.folder, sc.styling,
				sc.title, sc.description, sc.keyword, sc.alttags, sc.url_structure AS sc_url_structure,
				c.cat_id, c.cat_name, c.url_structure AS c_url_structure
			FROM
				tblsubcat sc
				JOIN tblcat c ON c.cat_id = sc.cat_id
			WHERE
				sc.view_status = 'Y'
				AND c.cat_id = '".$cat_id."'
			ORDER BY
				sc.ordering
		");
		return $q;
	}
	
	/*
	| -------------------------------------------------------------
	| Original author: Verjs
	| Renamed to accomodate query for facet after this function
	| Same intentions - select 'style' group by 'style' for further explode()
	*/
	function get_styling_($subcat_id, $designer)
	{
		//$DB3 = $this->_load_db();
		$m = $this->db->get_where('tblsubcat',array('subcat_id'=>$subcat_id));
		$m = $m->row();
		
		if(!empty($m->styling)) {
			$in = substr($m->styling,0,-1);
		} else {
			$in = 0;
		}

		if($designer <> '') {
			$and_designer = "AND tp.designer = '".$designer."'";
		} else {
			$and_designer = '';
		}
		
				
		$r = $this->db->query("SELECT
								  group_concat(DISTINCT tp.styles) as style_name
								FROM
								  tbl_product tp
								WHERE
								  tp.subcat_id = '".$subcat_id."'
								".$and_designer."
								AND
								  tp.styles <> ''");
		return $r;
	}
	
	/*
	| -------------------------------------------------------------
	| STYLING FACETS
	| -------------------------------------------------------------
	| Query for facets - Styles
	| Same intentions - select 'styles' group by 'styles' for further explode()
	| Cosidering $fileter (new_arriavls and clearance)
	*/
	function get_styling($subcat_id,$designer,$filter)
	{
		//$DB3 = $this->_load_db();
		
		$this->db->distinct('styles');
		$this->db->from('tbl_product');
		$this->db->join('tblstyle','tblstyle.style_name = tbl_product.styles','left');
		
		if ($subcat_id != '') $this->db->where('subcat_id',$subcat_id);
		if ($designer != '') $this->db->where('designer',$designer);
		
		if ($filter != '')
		{
			if ($filter == 'new-arrival')
			{
				$na_where = "(new_arrival = 'New Arrival' OR new_arrival = 'Yes' OR new_arrival = 'yes' OR new_arrival = 'Y' OR new_arrival = 'y')";
				$this->db->where($na_where);
				$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'yes' AND clearance != 'Y' AND clearance != 'y')";
				$this->db->where($not_clearance);
			}
			if ($filter == 'clearance')
			{
				$c_where = "(clearance = 'Clearance' OR clearance = 'Yes' OR clearance = 'yes' OR clearance = 'Y' OR clearance = 'y')";
				$this->db->where($c_where);
			}
		}
		else
		{
			$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'yes' AND clearance != 'Y' AND clearance != 'y')";
			$this->db->where($not_clearance);
		}

		$this->db->where('tbl_product.view_status','Y');
		//$this->db->where('u','p'); // ---> for debussing purposes
		$this->db->group_by('styles');
		$query = $this->db->get();
		
		if ($query->num_rows() > 1)
		{
			return $query;
		}
		else if ($query->num_rows() == 1)
		{
			$row = $query->row_array();
			if (empty($row['styles']) OR $row['styles'] == NULL) return FALSE;
			else return $query;	
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	| -------------------------------------------------------------
	| Original author: Verjs
	| Renamed to accomodate query for facet after this function
	| Same intentions - select 'colors' group by 'colors' for further explode()
	*/
	function get_colors_($subcat_id, $designer)
	{
		if ($designer <> '')
		{
			$and_designer = "AND tp.designer = '".$designer."'";
		}
		else
		{
			$and_designer = '';
		}
		
		//$DB3 = $this->_load_db();
		$q = $this->db->query("SELECT
								  group_concat(DISTINCT tp.colors) as color_name
								FROM
								  tbl_product tp
								WHERE
								  tp.subcat_id = '".$subcat_id."'
								".$and_designer."
								AND
								  tp.colors <> ''
								  ");
		return $q;
	}
	
	/*
	| -------------------------------------------------------------
	| Query for facets - colors
	| Same intentions - select 'colors' group by 'colors' for further explode()
	| Cosidering $fileter (new_arriavls and clearance)
	*/
	function get_colors($subcat_id,$designer,$filter)
	{
		//$DB3 = $this->_load_db();
	
		$this->db->distinct('colors');
		if ($subcat_id != '') $this->db->where('subcat_id',$subcat_id);
		
		if ($filter != '')
		{
			if ($filter == 'new-arrival')
			{
				$na_where = "(new_arrival = 'New Arrival' OR new_arrival = 'Yes' OR new_arrival = 'Y' OR new_arrival = 'y')";
				$this->db->where($na_where);
				$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'Y' AND clearance != 'y')";
				$this->db->where($not_clearance);
			}
			if ($filter == 'clearance')
			{
				$c_where = "(clearance = 'Clearance' OR clearance = 'Yes' OR clearance = 'Y' OR clearance = 'y')";
				$this->db->where($c_where);
			}
		}
		else
		{
			$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'Y' AND clearance != 'y')";
			$this->db->where($not_clearance);
		}
		
		//$this->db->where('u','p');
		$this->db->group_by('colors');
		$query = $this->db->get('tbl_product');
		
		if ($query->num_rows() > 1)
		{
			return $query;
		}
		else if ($query->num_rows() == 1)
		{
			$row = $query->row_array();
			if (empty($row['colors']) OR $row['colors'] == NULL) return FALSE;
			else return $query;	
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	| -------------------------------------------------------------
	| COLOR FACETS
	| -------------------------------------------------------------
	| Query for facets - tbl_stock.color_facets
	| Select 'color_facets' from tbl_stock
	*/
	function get_color_facets($subcat_id,$designer,$filter)
	{
		//$DB3 = $this->_load_db();
		
		$select_string = "tbl_product.prod_no,
			tbl_product.colors,
			tbl_stock.color_name,
			tbl_stock.color_facets
		";
		$this->db->select($select_string);
		
		$this->db->from('tbl_product');
		$this->db->join('tbl_stock','tbl_stock.prod_no = tbl_product.prod_no','left');
		$this->db->join('tblcolor','tblcolor.color_name = tbl_stock.color_name','left');
		$this->db->where('tbl_product.view_status','Y');
		
		if ($subcat_id != '') $this->db->where('tbl_product.subcat_id',$subcat_id);
		
		if ($filter != '')
		{
			if ($filter == 'new-arrival')
			{
				$na_where = "(new_arrival = 'New Arrival' OR new_arrival = 'Yes' OR new_arrival = 'yes' OR new_arrival = 'Y' OR new_arrival = 'y')";
				$this->db->where($na_where);
				$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'yes' AND clearance != 'Y' AND clearance != 'y')";
				$this->db->where($not_clearance);
			}
			if ($filter == 'clearance')
			{
				$c_where = "(clearance = 'Clearance' OR clearance = 'Yes' OR clearance = 'yes' OR clearance = 'Y' OR clearance = 'y')";
				$this->db->where($c_where);
			}
		}
		else
		{
			$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'yes' AND clearance != 'Y' AND clearance != 'y')";
			$this->db->where($not_clearance);
		}
		
		//$this->db->where('u','p');
		$this->db->group_by('tbl_stock.color_facets');
		$query = $this->db->get();
		
		if ($query->num_rows() > 1)
		{
			return $query;
		}
		else if ($query->num_rows() == 1)
		{
			$row = $query->row_array();
			if (empty($row['colors']) OR $row['colors'] == NULL) return FALSE;
			else return $query;	
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	| -------------------------------------------------------------
	| EVENTS FACETS
	| -------------------------------------------------------------
	| Query for facets - EVENTS
	| Same intentions - select 'events' group by 'events' for further explode()
	| Cosidering $fileter (new_arriavls and clearance)
	*/
	function get_events($subcat_id,$designer,$filter)
	{
		//$DB3 = $this->_load_db();

		$this->db->distinct('events');
		$this->db->from('tbl_product');
		$this->db->join('tblevent','tblevent.event_name = tbl_product.events','left');
		
		if ($subcat_id != '') $this->db->where('subcat_id',$subcat_id);
		if ($designer != '') $this->db->where('designer',$designer);
		
		if ($filter != '')
		{
			if ($filter == 'new-arrival')
			{
				$na_where = "(new_arrival = 'New Arrival' OR new_arrival = 'Yes' new_arrival = 'yes' OR new_arrival = 'Y' OR new_arrival = 'y')";
				$this->db->where($na_where);
				$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'yes' AND clearance != 'Y' AND clearance != 'y')";
				$this->db->where($not_clearance);
			}
			if ($filter == 'clearance')
			{
				$c_where = "(clearance = 'Clearance' OR clearance = 'Yes' OR clearance = 'yes' OR clearance = 'Y' OR clearance = 'y')";
				$this->db->where($c_where);
			}
		}
		else
		{
			$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'yes' AND clearance != 'Y' AND clearance != 'y')";
			$this->db->where($not_clearance);
		}
		
		$this->db->where('tbl_product.view_status','Y');
		//$this->db->where('u','p');
		$this->db->group_by('events');
		$query = $this->db->get();
		
		if ($query->num_rows() > 1)
		{
			return $query;
		}
		else if ($query->num_rows() == 1)
		{
			$row = $query->row_array();
			if (empty($row['events']) OR $row['events'] == NULL) return FALSE;
			else return $query;	
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	| -------------------------------------------------------------
	| MATERIAL FACETS
	| -------------------------------------------------------------
	| Query for facets - MATERIALS
	| Same intentions - select 'events' group by 'events' for further explode()
	| Cosidering $fileter (new_arriavls and clearance)
	*/
	function get_materials($subcat_id,$designer,$filter)
	{
		//$DB3 = $this->_load_db();

		$this->db->distinct('materials');
		$this->db->from('tbl_product');
		$this->db->join('tblmaterial','tblmaterial.material_name = tbl_product.materials','left');
		
		if ($subcat_id != '') $this->db->where('subcat_id',$subcat_id);
		if ($designer != '') $this->db->where('designer',$designer);
		
		if ($filter != '')
		{
			if ($filter == 'new-arrival')
			{
				$na_where = "(new_arrival = 'New Arrival' OR new_arrival = 'Yes' new_arrival = 'yes' OR new_arrival = 'Y' OR new_arrival = 'y')";
				$this->db->where($na_where);
				$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'yes' AND clearance != 'Y' AND clearance != 'y')";
				$this->db->where($not_clearance);
			}
			if ($filter == 'clearance')
			{
				$c_where = "(clearance = 'Clearance' OR clearance = 'Yes' OR clearance = 'yes' OR clearance = 'Y' OR clearance = 'y')";
				$this->db->where($c_where);
			}
		}
		else
		{
			$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'yes' AND clearance != 'Y' AND clearance != 'y')";
			$this->db->where($not_clearance);
		}
		
		$this->db->where('tbl_product.view_status','Y');
		//$this->db->where('u','p');
		$this->db->group_by('materials');
		$query = $this->db->get();
		
		if ($query->num_rows() > 1)
		{
			return $query;
		}
		else if ($query->num_rows() == 1)
		{
			$row = $query->row_array();
			if (empty($row['materials']) OR $row['materials'] == NULL) return FALSE;
			else return $query;	
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	| -------------------------------------------------------------
	| TRENDS FACETS
	| -------------------------------------------------------------
	| Query for facets - TRENDS
	| Same intentions - select 'events' group by 'events' for further explode()
	| Cosidering $fileter (new_arriavls and clearance)
	*/
	function get_trends($subcat_id,$designer,$filter)
	{
		//$DB3 = $this->_load_db();

		$this->db->distinct('trends');
		$this->db->from('tbl_product');
		$this->db->join('tbltrend','tbltrend.trend_name = tbl_product.trends','left');
		
		if ($subcat_id != '') $this->db->where('subcat_id',$subcat_id);
		if ($designer != '') $this->db->where('designer',$designer);
		
		if ($filter != '')
		{
			if ($filter == 'new-arrival')
			{
				$na_where = "(new_arrival = 'New Arrival' OR new_arrival = 'Yes' new_arrival = 'yes' OR new_arrival = 'Y' OR new_arrival = 'y')";
				$this->db->where($na_where);
				$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'yes' AND clearance != 'Y' AND clearance != 'y')";
				$this->db->where($not_clearance);
			}
			if ($filter == 'clearance')
			{
				$c_where = "(clearance = 'Clearance' OR clearance = 'Yes' OR clearance = 'yes' OR clearance = 'Y' OR clearance = 'y')";
				$this->db->where($c_where);
			}
		}
		else
		{
			$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'yes' AND clearance != 'Y' AND clearance != 'y')";
			$this->db->where($not_clearance);
		}
		
		$this->db->where('tbl_product.view_status','Y');
		//$this->db->where('u','p');
		$this->db->group_by('trends');
		$query = $this->db->get();
		
		if ($query->num_rows() > 1)
		{
			return $query;
		}
		else if ($query->num_rows() == 1)
		{
			$row = $query->row_array();
			if (empty($row['trends']) OR $row['trends'] == NULL) return FALSE;
			else return $query;	
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	| -------------------------------------------------------------
	| FACETS
	| -------------------------------------------------------------
	| Query for facets - facet_type: colors, styles, materials, events, trends
	| Cosidering $fileter (new_arriavls and clearance)
	*/
	function get_facets($facet_type, $subcat_id, $designer, $filter)
	{
		//$DB3 = $this->_load_db();
		
		switch ($facet_type)
		{
			case 'colors':
				$select_string = "tbl_product.prod_no,
					tbl_product.colors,
					tbl_stock.color_name,
					tbl_stock.color_facets
				";
				$this->db->select($select_string);
				$this->db->from('tbl_product');
				$this->db->join('tbl_stock','tbl_stock.prod_no = tbl_product.prod_no','left');
				$this->db->join('tblcolor','tblcolor.color_name = tbl_stock.color_name','left');
			break;
			
			case 'styles':
				$this->db->distinct('styles');
				$this->db->from('tbl_product');
				$this->db->join('tblstyle','tblstyle.style_name = tbl_product.styles','left');
			break;
			
			case 'materials':
				$this->db->distinct('materials');
				$this->db->from('tbl_product');
				$this->db->join('tblmaterial','tblmaterial.material_name = tbl_product.materials','left');
			break;
			
			case 'events':
				$this->db->distinct('events');
				$this->db->from('tbl_product');
				$this->db->join('tblevent','tblevent.event_name = tbl_product.events','left');
			break;
			
			case 'trends':
				$this->db->distinct('trends');
				$this->db->from('tbl_product');
				$this->db->join('tbltrend','tbltrend.trend_name = tbl_product.trends','left');
			break;
		}
		
		if ($subcat_id != '') $this->db->where('subcat_id',$subcat_id);
		if ($designer != '') $this->db->where('designer',$designer);
		
		if ($filter != '')
		{
			if ($filter == 'new-arrival')
			{
				$na_where = "(new_arrival = 'New Arrival' OR new_arrival = 'Yes' OR new_arrival = 'yes' OR new_arrival = 'Y' OR new_arrival = 'y')";
				$this->db->where($na_where);
				$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'yes' AND clearance != 'Y' AND clearance != 'y')";
				$this->db->where($not_clearance);
			}
			if ($filter == 'clearance')
			{
				$c_where = "(clearance = 'Clearance' OR clearance = 'Yes' OR clearance = 'yes' OR clearance = 'Y' OR clearance = 'y')";
				$this->db->where($c_where);
			}
		}
		else
		{
			$not_clearance = "(clearance != 'Clearance' AND clearance != 'Yes' AND clearance != 'yes' AND clearance != 'Y' AND clearance != 'y')";
			$this->db->where($not_clearance);
		}

		//=$this->db->where('u','p'); // ---> for debussing purposes
		
		// hub site view status settings
		$where_view_status = "(tbl_product.view_status = 'Y' OR tbl_product.view_status = 'Y1')";
		// designer site view status settings
		//$where_view_status = "(tbl_product.view_status = 'Y' OR tbl_product.view_status = 'Y2')";
		
		$this->db->where($where_view_status);
		
		switch ($facet_type)
		{
			case 'colors':
				$this->db->group_by('tbl_stock.color_facets');
			break;
			
			case 'styles':
				$this->db->group_by('styles');
			break;
			
			case 'materials':
				$this->db->group_by('materials');
			break;
			
			case 'events':
				$this->db->group_by('events');
			break;
			
			case 'trends':
				$this->db->group_by('trends');
			break;
		}
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 1)
		{
			return $query;
		}
		else if ($query->num_rows() == 1)
		{
			$row = $query->row_array();
			if (empty($row[$facet_type]) OR $row[$facet_type] == NULL) return FALSE;
			else return $query;	
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	| -------------------------------------------------------------
	| CROSS CHECKING OF FACETS FROM CSV AGAINST FACET TABLE
	| -------------------------------------------------------------
	*/
	function x_check($facet_category,$facet)
	{
		//$DB3 = $this->_load_db();

		// add fulltext index to search column
		$query = mysql_query("
			ALTER TABLE tbl".$facet_category."
			ADD FULLTEXT (".$facet_category."_name)
		");
		
		$this->db->select($facet_category.'_name');
		$this->db->from('tbl'.$facet_category);
		
		$where_match = "MATCH(".$facet_category."_name) AGAINST('".$facet."')";
		$this->db->where($where_match);
		//$this->db->where('u','p'); // ----> for debugging purposes
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
			
			// remove fulltext index to search column
			$query = mysql_query("
				ALTER TABLE tbl".$facet_category."
				DROP INDEX (".$facet_category."_name)
			");
			
			if (empty($row[$facet_category.'_name']) OR $row[$facet_category.'_name'] == NULL) return FALSE;
			else return TRUE;	
		}
		else
		{
			// remove fulltext index to search column
			$query = mysql_query("
				ALTER TABLE tbl".$facet_category."
				DROP INDEX (".$facet_category."_name)
			");
			
			return FALSE;
		}
	}
	
	/*
	| -------------------------------------------------------------
	| Added by Verjs to fix the footer text of the products pages
	*/
	function get_footer_category($cat_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("SELECT footer FROM tblcat WHERE cat_id='".$cat_id."'");
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $row->footer;
		} else {
			return $this->config->item('footer_text');
		}
	}
	/*
	| -------------------------------------------------------------
	| Added by Verjs to fix the footer text for products pages
	*/
	function get_footer_subcategory($subcat_id) {
		$q = $this->db->query("SELECT footer FROM tblsubcat WHERE subcat_id='".$subcat_id."'");
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $row->footer;
		} else {
			return $this->config->item('footer_text');
		}
	}
	/*
	| -------------------------------------------------------------
	| Added by Verjs to fix the footer text for products pages
	*/
	function get_footer_designer($des_id)
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("SELECT footer FROM designer WHERE des_id='".$des_id."'");
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $row->footer;
		} else {
			return $this->config->item('footer_text');
		}
	}
	
	function get_designers($cat_id)
	{
		//$DB3 = $this->_load_db();

		/*
		| -----------------------------------------------------------------
		| Two options for function get_designers
		| 1.0	Get all designers
		| 2.0	Get respective designer given param #cat_id
		*/
		if ($cat_id)
		{
			$q = $this->db->get_where('designer',array('catid'=>$cat_id));
		}
		else
		{
			$q = $this->db->get('designer');
		}
		return $q;
	}
	
	function get_chatlive()
	{
		//$DB3 = $this->_load_db();
		$q = $this->db->query("SELECT * FROM bvars where bname='online'");
		return $q->row();
	}	

	function get_caturl($cat_id)
	{
		//$DB3 = $this->_load_db();
		$this->db->select('url_structure');
		$this->db->from('tblcat');
		$this->db->where('cat_id',$cat_id);
		return $this->db->get();
	}
	
	function get_subcaturl($subcat_id)
	{
		//$DB3 = $this->_load_db();
		$this->db->select('url_structure');
		$this->db->from('tblsubcat');
		$this->db->where('subcat_id',$subcat_id);
		return $this->db->get();
	}
	
	function get_subsubcaturl($subsubcat_id)
	{
		//$DB3 = $this->_load_db();
		$this->db->select('url_structure');
		$this->db->from('tblsubsubcat');
		$this->db->where('id',$subsubcat_id);
		return $this->db->get();
	}
	
	/*
	| -------------------------------------------------------------
	| Added by to fix the new url structure
	*/
	function get_id_of($field, $url_structure)
	{
		if ($field === 'des') $table = 'designer';
		else $table = 'tbl'.$field;
		
		if ($field === 'subsubcat') $id = 'id';
		else $id = $field.'_id';
		
		//$DB3 = $this->_load_db();
		$this->db->select($id);
		$this->db->from($table);
		$this->db->where('url_structure',$url_structure);
		//$this->db->where('u', 'p');
		$q = $this->db->get();
		$row = $q->row_array();
		return $row[$id];
	}

	/*
	| -------------------------------------------------------------
	| Added for the sales package site
	*/
	function jscript_sa_add_to_cart()
	{
		if ($this->cart->total_items() == 0)
			$stext = '
				alert("Please select items to send.");
				return false;
			';
		else $stext = 'return true;';
			
		$jscript = '
			<script>
				function getXMLHTTP() { //fuction to return the xml http object
					var xmlhttp=false;	
					try {
						xmlhttp=new XMLHttpRequest();
					}
					catch(e) {
						try {			
							xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
						}
						catch(e) {
							try {
								xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
							}
							catch(e1) {
								xmlhttp=false;
							}
						}
					}
					return xmlhttp;
				}
				function sa_add_to_cart(strURL, strValue) { //the request
					if (document.getElementById(strValue).checked == true)
					{
						params = "val=" + strValue;
						var req = getXMLHTTP();
						if (req) {
							req.onreadystatechange = function() {
								if (req.readyState == 4) {
									// only if "OK"
									if (req.status == 200) {
										document.getElementById(\'sa_cart_sidebar_link\').innerHTML=req.responseText;
									} else {
										alert("There was a problem while using XMLHTTP:\n" + req.statusText);
									}
								}				
							}			
							req.open("GET", strURL + "?" + params, true);
							req.send();
						}
					}
					else
					{
						alert("You have just de-selected an item from the list?");
						
						params = "d=desel&val=" + strValue;
						var req = getXMLHTTP();
						if (req) {
							req.onreadystatechange = function() {
								if (req.readyState == 4) {
									// only if "OK"
									if (req.status == 200) {
										document.getElementById(\'sa_cart_sidebar_link\').innerHTML=req.responseText;
									} else {
										alert("There was a problem while using XMLHTTP:\n" + req.statusText);
									}
								}				
							}			
							req.open("GET", strURL + "?" + params, true);
							req.send();
						}
					}
				}
				function sa_remove_from_cart(strURL, strValue) { //the request
					c = confirm("Are you sure you want to de-select the item?");
					if (C == true)
					{
						params = "d=desel&val=" + strValue;
						var req = getXMLHTTP();
						if (req) {
							req.onreadystatechange = function() {
								if (req.readyState == 4) {
									// only if "OK"
									if (req.status == 200) {
										document.getElementById(\'sa_cart_sidebar_link\').innerHTML=req.responseText;
									} else {
										alert("There was a problem while using XMLHTTP:\n" + req.statusText);
									}
								}				
							}			
							req.open("GET", strURL + "?" + params, true);
							req.send();
						}
					}
					else return false;
				}
			</script>
		';
		
		return $jscript;
	}
	
	// more for the sales package site
	function jscript_sa_input_field_sessions_1()
	{
		$jscript = '
			<script type="text/javascript">
				function getXMLHTTP() { //fuction to return the xml http object
					var xmlhttp=false;	
					try {
						xmlhttp=new XMLHttpRequest();
					}
					catch(e) {
						try {
							xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
						}
						catch(e) {
							try {
								xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
							}
							catch(e1) {
								xmlhttp=false;
							}
						}
					}
					return xmlhttp;
				}
				function remember_me(id) { //the request
					strURL = "'.site_url('sa/remembering').'";
					val = document.getElementById(id).value;
					val = "id=" + id + "&val=" + val;
					//val = "id=" + id + "&val=" + val.replace(/ /g, "_");
					var req = getXMLHTTP();
					if (req) {
						req.onreadystatechange = function() {
							if (req.readyState == 4) {
								// only if "OK"
								if (req.status == 200) {
									document.getElementById("test5835").innerHTML=req.responseText;
									document.getElementById("comments_overall").value=req.responseText;
								} else {
									alert("There was a problem while using XMLHTTP:\n" + req.statusText);
								}
							}				
						}			
						req.open("POST", strURL, true);
						req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						req.setRequestHeader("Content-length", val.length);
						req.setRequestHeader("Connection", "close");
						req.send(val);
					}
				}
			</script>
		';
		
		return $jscript;
	}
	
	// more for the sales package site
	function jscript_sa_input_field_sessions_2()
	{
		$jscript = '
			<script type="text/javascript">
				function remember_me(id) { //the request
					strURL = "'.site_url('sa/remembering').'";
					val = document.getElementById(id).value;
					val = "id=" + id + "&val=" + val;
					//val = "id=" + id + "&val=" + val.replace(/ /g, "_");
					var req = getXMLHTTP();
					if (req) {
						req.onreadystatechange = function() {
							if (req.readyState == 4) {
								// only if "OK"
								if (req.status == 200) {
									document.getElementById("test5835").innerHTML=req.responseText;
									document.getElementById("comments_overall").value=req.responseText;
								} else {
									alert("There was a problem while using XMLHTTP:\n" + req.statusText);
								}
							}				
						}			
						req.open("POST", strURL, true);
						req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						req.setRequestHeader("Content-length", val.length);
						req.setRequestHeader("Connection", "close");
						req.send(val);
					}
				}
			</script>
		';
		
		return $jscript;
	}
}
