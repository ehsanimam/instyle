<?php
class Paging
{
    var $base_url           = ''; 
	var $total_rows         = 0; 
	var $per_page           = 0; 
	var $num_page           = 0;
	var $cur_page	 		= 0; 
	var $first_link   		= '&lsaquo; First';
	var $next_link			= '&gt;';
	var $prev_link			= '&lt;';
	var $last_link			= 'Last &rsaquo;';
	var $full_tag_open		= '';
	var $full_tag_close		= '';
	var $first_tag_open		= '&nbsp;';
	var $first_tag_close	= '&nbsp;';
	var $last_tag_open		= '&nbsp;';
	var $last_tag_close		= '&nbsp;';
	var $cur_tag_open		= '&nbsp;<strong>';
	var $cur_tag_close		= '</strong>&nbsp;';
	var $next_tag_open		= '&nbsp;';
	var $next_tag_close		= '&nbsp;';
	var $prev_tag_open		= '&nbsp;';
	var $prev_tag_close		= '&nbsp;';
	var $num_tag_open		= '&nbsp;';
	var $num_tag_close		= '&nbsp;';
	var $dropdown_class     = '';
	var $link_class         = '';
	
	function initialize($params = array())
	{
		if (count($params) > 0){
			foreach ($params as $key => $val){
				if (isset($this->$key)){
					$this->$key = $val;
				}
			}
		}
		$this->_init();
	}
	
	function _init()
	{
			$this->num_page = $this->total_rows == 0 ? 1 : ceil($this->total_rows/$this->per_page); 
			$this->cur_page = ($this->cur_page > $this->num_page || $this->cur_page == "") ? 1 : $this->cur_page;
	}
	
	function create_links()
	{
		$link = "";
		for($i = 1; $i <= $this->num_page; $i++){
			$link .= ($i == $this->cur_page) ? $this->cur_tag_open.$i.$this->cur_tag_close : " <a href=\"$this->base_url$i\" class=\"$this->link_class\">".$i."</a> &nbsp;";
		}
		return $link;
	}
	
	function first_link()
	{
		$__FUNCTION__ = $this->num_page/$this->num_page;
		return $this->cur_page == $__FUNCTION__ ? $this->first_tag_open.$this->first_link.$this->first_tag_close : " <a href=\"$this->base_url$__FUNCTION__\" class=\"$this->link_class\">".$this->first_link."</a> ";
	}
	
	function last_link()
	{
		$__FUNCTION__ = $this->num_page/1;
		return $this->cur_page == $__FUNCTION__ ? $this->last_tag_open.$this->last_link.$this->last_tag_close : " <a href=\"$this->base_url$__FUNCTION__\" class=\"$this->link_class\">".$this->last_link."</a> ";
	}
	
	function next_link()
	{
	    $__FUNCTION__ = $this->cur_page + 1;
		return $this->num_page < $__FUNCTION__ ? $this->next_tag_open.$this->next_link.$this->next_tag_close : " <a href=\"$this->base_url$__FUNCTION__\" class=\"$this->link_class\">".$this->next_link."</a> ";
	}
	
   function prev_link()
	{
	    $__FUNCTION__ = $this->cur_page - 1;
		return $__FUNCTION__ <= 0 ? $this->prev_tag_open.$this->prev_link.$this->prev_tag_close : " <a href=\"$this->base_url$__FUNCTION__\" class=\"$this->link_class\">".$this->prev_link."</a> ";
	}
	
	function page_details()
	{
		$start = ($this->cur_page-1)* $this->per_page + 1;
		$end   = ($this->cur_page == $this->num_page || $this->num_page == 1) ? $this->total_rows : $this->cur_page * $this->per_page;
		return  "($start - $end of $this->total_rows)";
	}
	
	function dropdown_links()
	{
		$dropdown = "<select name=\"page\" id=\"page\" class=\"$this->dropdown_class\" onchange=\"javascript:window.location.href=$this->base_url+document.getElementById('page').value\">";
		for($i = 1; $i <= $this->num_page; $i++){
			$start = ($i-1)*$this->per_page + 1;
		    $end   = $i == $this->num_page ? $this->total_rows : $i * $this->per_page;
			$dropdown .= $i == $this->cur_page ? "<option value=\"$i\" selected>$start - $end</option>" : "<option value=\"$i\">$start - $end</option>";
		}
		$dropdown .= "</select>";
		return $dropdown;
	}
	
	
	
	
	
}