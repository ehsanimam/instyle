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
	 					
		  if($ci->uri->segment($i+1) == ''){
			$link.='<span style="list-style:none;padding:0px;margin:0px;"> '.img('images/arrow_small.gif').' <a href="'.site_url($prep_link).'" style="color:#000;"><b>'.ucfirst($uri_segment).'</b></a></span> ';
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
	  
	  function create_breadcrumb_product(){
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
	 					
		  if($ci->uri->segment($i+1) == ''){
			$link.='<span style="list-style:none;padding:0px;margin:0px;"> '.img('images/arrow_small.gif').' <a href="'.site_url($prep_link).'" style="color:#000;"><b>'.ucfirst(substr($uri_segment,0,-5)).'</b></a></span> ';
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
	  
	  function get_full_breadcrumb_url(){
	  $ci 	= &get_instance();
	  $i	= 1;
	  $uri 	= $ci->uri->segment($i);
	  $link = '';
	 
	  while($uri != ''){
	 	
		  $uri_segment = $ci->uri->segment($i);
	 
		  $link.='/'.$uri_segment;
	 
	  $i++;
	  $uri = $ci->uri->segment($i);
	  }
		return $link;
	  }
}   

?>