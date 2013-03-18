<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends Frontend_Controller {

	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		if ($this->config->item('site_domain') === 'www.youdomain.com' && $this->session->userdata('pass_thru') !== 'OK')
		{
			if ($this->input->get('v', TRUE) === '1')
			{
				$this->session->set_userdata('pass_thru', 'OK');
				redirect(site_url(), 'location');
			}
			else
			{
				$this->load->view('maintenance');
			}
		}
		else
		{
			$slides = $this->query_page->get_slides();
			$slide_show = '';
			if ($slides->num_rows() > 0)
			{
				$i = 0;
				foreach ($slides->result_array() as $slide)
				{
					//if ($i == 0) $slide_show .= '["'.$this->config->item('PROD_IMG_URL').'images/slideshow-index/'.$slide['image_name'].'", "", "", ""]';
					//$slide_show .= ',["'.$this->config->item('PROD_IMG_URL').'images/slideshow-index/'.$slide['image_name'].'", "", "", ""]';
					//$i++;
					if ($i == 0)
					{
						$slide_show .= '["'.$this->config->item('PROD_IMG_URL').'images/slideshow-index/'.$slide['image_name'].'", "'.$slide['link'].'", "", "","'.$slide['title'].'","'.$slide['title'].'"]';
					}
					else
					{
						$slide_show .= ', ["'.$this->config->item('PROD_IMG_URL').'images/slideshow-index/'.$slide['image_name'].'", "'.$slide['link'].'", "", "","'.$slide['title'].'","'.$slide['title'].'"]';
					}
					$i++;
				}
			}
			
			$jscript  = $this->set->jquery();

			$jscript .= '
				<script type="text/javascript" src="'.base_url().'jscript/fadeslideshow/fadeslideshow.js"></script>
			';
			$jscript .= '
				<script type="text/javascript">
					var mygallery=new fadeSlideShow({
						wrapperid: "fadeshow1", //ID of blank DIV on page to house Slideshow
						dimensions: [743, 581], //width/height of gallery in pixels. Should reflect dimensions of largest image
						imagearray: ['.$slide_show.'], //added alt tag and title new imagearray ["image", "optional url", "optional target file", "optional description","alt tag","title"]
						displaymode: {type:\'auto\', pause:3500, cycles:0, wraparound:false, randomize:true},
						persist: true, //remember last viewed slide and recall within same session?
						fadeduration: 500, //transition duration (milliseconds)
						descreveal: "none",
						togglerid: ""
					})
				</script>
			';
			
			/*
			| ------------------------------------------------------------------------------
			| Adding a db query to tblmeta pagename = index.php
			| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
			*/
			if ($this->session->userdata('user_cat') == 'wholesale') $pagename = 'wholesale_index.php';
			else $pagename = 'index.php';
			
			// this is the database query which should be eventually transferred at models/query_page.php
			//$DB3 = $this->load_db();
			$this->db->order_by('seq', 'asc'); // offer manager links
			$offers_links = $this->db->get('tblhome'); // offer manager links
			
			$index_page = $this->db->get_where('pages', array('title_code' => 'index_page')); // index page left side text
			$index_page = $index_page->row();
			
			$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
			$meta_row = $q_meta->row();
			
			// Common content variables
			$data = array(
				'file'				=> 'index',
				'offers'			=> $offers_links,
				'index_page'		=> $index_page,
				'slides'			=> $slides,
				'jscript'			=> $jscript,
				'page_footer_meta'	=> $meta_row->dfooter, // added this variable for the footer text meta
				'site_title'		=> $meta_row->title,
				'site_keywords'		=> $meta_row->keyword,
				'site_description'	=> $meta_row->description,
				'footer_text'		=> $meta_row->dfooter
			);
			
			//$this->output->cache(7200);
			$this->load->view($this->config->slash_item('template').'template',$data);
		}
	}
	
	function page()
	{
		/*
		| ------------------------------------------------------------------------------
		| Get the page number from uri segment (1) - p1 = '1'
		*/
		$get_page = $this->query_page->get_page(ltrim($this->uri->segment(1),'p'));
		$row = $get_page->row();
		
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta join pages where t.pagename = p.title_code+'.php'
		| Resulting row has tblmeta.dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		|
		*/
		$title_code = $row->title_code;
		$pagename = $title_code.'.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		//$DB3 = $this->load_db();
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		$data = array(
			'file'				=> 'page',
			'page_title'		=> $row->title,
			'page_text'			=> $row->text,
			'page_footer_meta'	=> $meta_row->dfooter, // added this variable for the footer text meta
			'site_title'		=> $meta_row->title,
			'site_keywords'		=> $meta_row->keyword,
			'site_description'	=> $meta_row->description,
			'footer_text'		=> $meta_row->dfooter
		);
		$this->load->view('template',$data);
	}

	function newsletter()
	{
		// Get newsletter id
		$n_id = $this->uri->segment(2);
		
		$q_newsletter = $this->query_page->get_newsletter($n_id);
		$news_row = $q_newsletter->row();
		
		if ($this->uri->segment(3) === 'view')
		{
			$body_message = '
				<table id="wrapper" border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#333333;">
				<tr><td align="center">
				
					<table id="container" border="0" cellpadding="0" cellspacing="0" width="660" style="background:#efefef;">
						<tr>
							<td id="top_notice" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;background:#333333;padding:10px 20px;">
								If you are unable to see this message, <a href="'.str_replace('https','http',base_url()).'newsletter/'.$n_id.'/view" style="color:white;">Click here</a> to view.<br />
								To ensure delivery to your inbox, please add info@instylenewyork.com to your address book. 
							</td>
						</tr>
			';
			$body_message .= $news_row->message;
			$body_message .= '
						<tr>
							<td id="bottom_notice" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;background:#333333;padding:10px 20px 20px 20px;">
								To adjust your email preferences or to unsubscribe from email advertisements from '.$this->config->item('site_domain').', please <a href="" style="color:white;">Click here</a>.<br />
								'.$this->config->item('site_name').', 230 West 38th Street, New York, NY 10018
							</td>
						</tr>
						
					</table> <!--#container-->
				
				</td></tr>
				</table> <!--#wrapper-->
			';
		}
		else
		{
			$body_message = '
				<table id="wrapper" border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#333333;">
				<tr><td align="center">
				
					<table id="container" border="0" cellpadding="0" cellspacing="0" width="660" style="background:#efefef;">
						<tr>
							<td id="top_notice" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;background:#333333;padding:10px 20px;">
								If you are unable to see this message, <a href="'.str_replace('https','http',base_url()).'newsletter/'.$n_id.'/'.$this->uri->segment(3).'" style="color:white;">Click here</a> to view.<br />
								To ensure delivery to your inbox, please add info@instylenewyork.com to your address book. 
							</td>
						</tr>
			';
			$body_message .= $news_row->message;
			$body_message .= '
					<tr>
						<td id="bottom_notice" colspan="9" style="font-family:Arial;font-size:10px;color:white;text-align:center;background:#333333;padding:10px 20px 20px 20px;">
							To adjust your email preferences or to unsubscribe from email advertisements from '.$this->config->item('site_domain').', please <a href="'.base_url().'register/opt_out/'.$this->uri->segment(3).'" style="color:white;">Click here</a>.<br />
							'.$this->config->item('site_name').', 230 West 38th Street, New York, NY 10018
						</td>
					</tr>
					
				</table> <!--#container-->
			
			</td></tr>
			</table> <!--#wrapper-->
			';
		}
		
		echo $body_message;
	}
}
