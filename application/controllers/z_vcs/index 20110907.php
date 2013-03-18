<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	function __Construct() {
		parent::__Construct();
		$this->load->model('query_page');		
	}
	
	function index() {
		
		$slides = $this->query_page->get_slides();
		
		$jscript  = $this->set->jquery();
		$jscript .= br().'<script type="text/javascript">

					function theRotator() {
						//Set the opacity of all images to 0
						$(\'div.rotator ul li\').css({opacity: 0.0});
						
						//Get the first image and display it (gets set to full opacity)
						$(\'div.rotator ul li:first\').css({opacity: 1.0});
							
						//Call the rotator function to run the slideshow, 6000 = change to next image after 6 seconds
						
						setInterval(\'rotate()\',6000);
						
					}
					
					function rotate() {	
						//Get the first image
						var current = ($(\'div.rotator ul li.show\')?  $(\'div.rotator ul li.show\') : $(\'div.rotator ul li:first\'));
					
						if ( current.length == 0 ) current = $(\'div.rotator ul li:first\');
					
						//Get next image, when it reaches the end, rotate it back to the first image
						var next = ((current.next().length) ? ((current.next().hasClass(\'show\')) ? $(\'div.rotator ul li:first\') :current.next()) : $(\'div.rotator ul li:first\'));
						
						//Un-comment the 3 lines below to get the images in random order
						
						//var sibs = current.siblings();
							//var rndNum = Math.floor(Math.random() * sibs.length );
							//var next = $( sibs[ rndNum ] );
								
					
						//Set the fade in effect for the next image, the show class has higher z-index
						next.css({opacity: 0.0})
						.addClass(\'show\')
						.animate({opacity: 1.0}, 1000);
					
						//Hide the current image
						current.animate({opacity: 0.0}, 1000)
						.removeClass(\'show\');
						
					};
					
					
					
					$(document).ready(function() {		
						//Load the slideshow
						theRotator();
						$(\'div.rotator\').fadeIn(1000);
						$(\'div.rotator ul li\').fadeIn(1000); // tweek for IE
					});
					</script>
					<style>
						/* rotator in-page placement */
							div.rotator {
							height:570px;
							
						}
						/* rotator css */
							div.rotator ul li {
							position:absolute;
							list-style: none;
							left: 422px;
							top: 68px;
						}
						/* rotator image style */	
							div.rotator ul li img {
							background: #FFF;
							
						}
								div.rotator ul li.show {
							z-index:500;
						}

					</style>';
		
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