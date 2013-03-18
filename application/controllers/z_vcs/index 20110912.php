<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	function __Construct() {
		parent::__Construct();
		$this->load->model('query_page');		
	}
	
	function index() {
		
		$slides = $this->query_page->get_slides();
		$slide_show = '';
		if ($slides->num_rows() > 0)
		{
			$i = 0;
			foreach ($slides->result_array() as $slide):
				if ($i == 0) $slide_show .= '["images/slideshow-index/'.$slide['image_name'].'", "", "", ""]';
				$slide_show .= ',["images/slideshow-index/'.$slide['image_name'].'", "", "", ""]';
				$i++;
			endforeach;
		}
		
		$jscript  = $this->set->jquery();

		$jscript .= '
			<script type="text/javascript" src="'.base_url().'jscript/fadeslideshow/fadeslideshow.js"></script>
		';
		$jscript .= '
			<script type="text/javascript">
				var mygallery=new fadeSlideShow({
					wrapperid: "fadeshow1", //ID of blank DIV on page to house Slideshow
					dimensions: [755, 581], //width/height of gallery in pixels. Should reflect dimensions of largest image
					imagearray: ['.$slide_show.'],
					displaymode: {type:\'auto\', pause:3500, cycles:0, wraparound:false, randomize:true},
					persist: true, //remember last viewed slide and recall within same session?
					fadeduration: 500, //transition duration (milliseconds)
					descreveal: "none",
					togglerid: ""
				})
			</script>
		';
		
		$data = array('file'				=> 'index',
					  'slides'				=> $slides,
					  'jscript'				=> $jscript,
					  'site_title'			=> $this->config->item('site_title'),
					  'site_keywords'		=> $this->config->item('site_keywords'),
					  'site_description'	=> $this->config->item('site_description')
					 );
		$this->load->view('template',$data);
	}
	
	function page() {
		$get_page = $this->query_page->get_page(substr($this->uri->segment(1),-1));
		$row = $get_page->row();
		
		$data = array('file'				=> 'page',
					  'page_title'			=> $row->title,
					  'page_text'			=> $row->text,
					  'site_title'			=> $this->config->item('site_title'),
					  'site_keywords'		=> $this->config->item('site_keywords'),
					  'site_description'	=> $this->config->item('site_description')
					 );
		$this->load->view('template',$data);
	}
	

}

?>