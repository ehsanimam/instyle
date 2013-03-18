<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sa extends Admin_Sales_Controller
{
	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		$this->data['designers_ary'] = $this->get_designers();
		
		if (in_array($this->uri->segment(2), $this->sa_users_ary))
		{
			// Greet the user
			echo 'Hi '.$this->uri->segment(2).'!<br />';
			echo 'Please wait while loading...';

			// Get the email from the sa_users_ary
			$key = array_search($this->uri->segment(2), $this->sa_users_ary);
			$admin_sales_email = $this->sa_users_ary[$key + 2];
			$admin_sales_lname = $this->sa_users_ary[$key + 1];
			
			// set session data
			$sesdata = array(
				'admin_sales_loggedin'	=> true,
				'admin_sales_user'		=> $this->uri->segment(2),
				'admin_sales_lname'		=> $admin_sales_lname,
				'admin_sales_email'		=> $admin_sales_email
			);
			$this->session->set_userdata($sesdata);
			
			// go and send user to page one of admin sales tools
			redirect('sa/apparel', 'location');
		}
		
		if ($this->uri->segment(4) && ! is_numeric($this->uri->segment(4)))
		{
			// check if logged in
			//if (ENVIRONMENT !== 'development')
				$this->check_sales_admin_logged_in();
			
			// show the product detail page
			$this->show_product_detail($this->uri->segment(3), $this->uri->segment(4));
			$this->load->view($this->config->slash_item('template').'template', $this->data);
		}
		else if ($this->uri->segment(3) !== FALSE)
		{
			// check if logged in
			//if (ENVIRONMENT !== 'development')
				$this->check_sales_admin_logged_in();
			
			if (in_array($this->uri->segment(3), $this->get_subcategories()))
			{
				// show the subcategory product thumbs ====================================
				$this->show_subcat_products($this->uri->segment(2), $this->uri->segment(3));
				$this->load->view($this->config->slash_item('template').'sales/template', $this->data);
			}
			else
			{
				// if all else fails
				show_404();
			}
		}
		else if ($this->uri->segment(2))
		{
			// check if logged in
			//if (ENVIRONMENT !== 'development')
				$this->check_sales_admin_logged_in();
			
			if (in_array($this->uri->segment(2), $this->get_categories()))
			{
				// show the browse by category page ============================================================
				$this->show_subcats($this->uri->segment(2));
				$this->load->view($this->config->slash_item('template').'sales/template', $this->data);
			}
			elseif ($this->uri->segment(2) == 'multi_search')
			{
				// show the product line sheet summary page ============================================================
				$this->show_product_linesheet('', 'multi_search');
				$this->load->view($this->config->slash_item('template').'sales/template', $this->data);
			}
			elseif ($this->uri->segment(2) == 'product_linesheet_summary')
			{
				// show the product line sheet summary page ============================================================
				$this->show_product_linesheet($_POST);
				$this->load->view($this->config->slash_item('template').'sales/template', $this->data);
			}
			elseif ($this->uri->segment(2) == 'send_product_linesheet')
			{
				// send product line sheets ============================================================
				$this->send_product_linesheet($_POST);
		
				$array_items = array(
					'recipients_name' => '',
					'recipients_email' => '',
					'bcc_email' => '',
					'comments_overall' =>''
				);
				$this->session->unset_userdata($array_items);
				
				redirect('sa/sent', 'location');
			}
			elseif ($this->uri->segment(2) == 'sent')
			{
				// show_product_linesheet
				$this->show_product_linesheet('', 'sent');
				$this->load->view($this->config->slash_item('template').'sales/template', $this->data);
			}
			else
			{
				// if all else fails
				show_404();
			}
		}
		else
		{
			// Nothing to do here
			show_404();
		}
	}
	
	function update_cart()
	{
		$p_exp = explode('=', $_GET['val']);
		// array(prod_no, color_code, prod_name, wholesale_price, colors, prod_color, path_to_img)
		$prod_item[$p_exp[0].'_'.$p_exp[1]] = array($p_exp[0], $p_exp[1], $p_exp[2], $p_exp[3], $p_exp[4], $p_exp[5], $p_exp[6]);
		
		// set price to $1 for zero wholesale price to be able to add to cart
		$price = $p_exp[3] == 0 ? 1 : $p_exp[3];
		
		$product_data = array(
			'id'      => $p_exp[0].'_'.$p_exp[1],
			'qty'     => 1,
			'price'   => $price,
			'name'    => $p_exp[2],
			'options' => array(
				'prod_no' 			=> $p_exp[0],
				'color_code' 		=> $p_exp[1],
				'available_colors'	=> $p_exp[4],
				'product_color'		=> $p_exp[5],
				'image_url'			=> $p_exp[6],
				'val'				=> $_GET['val']
			)
		);

		if (isset($_GET['d']) && $_GET['d'] == 'desel')
		{
			// remove item to cart
			$product_rowid = $this->cart->insert($product_data);
			$data_1 = array(
				'rowid' => $product_rowid,
				'qty' => 0
			);
			$this->cart->update($data_1);
			
			// remove reference to last element
			unset($product_rowid);
			unset($data_1);
			
			// -----------------------------------------
			// --> CART Summary
			if (ENVIRONMENT === 'development' OR ENVIRONMENT === 'testing')
			{
				$link1 = site_url('sa/product_linesheet_summary');
				echo anchor($link1, (img(array('src'=>'images/item_icon.gif','border'=>0,'style'=>'vertical-align:middle')).nbs(2).'('.$this->cart->total_items().')'.nbs().'view items_'), 'style="color:white;"');
			}
			else
			{
				$link1 = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? site_url('sa/product_linesheet_summary') : str_replace('http','https',site_url('sa/product_linesheet_summary'));
				echo anchor($link1, (img(array('src'=>'images/item_icon.gif','border'=>0,'style'=>'vertical-align:middle')).nbs(2).'('.$this->cart->total_items().')'.nbs().'view items'), 'class="mm_last items"');
			}
		}
		else
		{
			// insert item to cart
			$this->cart->insert($product_data);
			
			// -----------------------------------------
			// --> CART Summary
			if (ENVIRONMENT === 'development' OR ENVIRONMENT === 'testing')
			{
				$link1 = site_url('sa/product_linesheet_summary');
				echo anchor($link1, (img(array('src'=>'images/item_icon.gif','border'=>0,'style'=>'vertical-align:middle')).nbs(2).'('.$this->cart->total_items().')'.nbs().'view items_'), 'style="color:white;"');
			}
			else
			{
				$link1 = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? site_url('sa/product_linesheet_summary') : str_replace('http','https',site_url('sa/product_linesheet_summary'));
				echo anchor($link1, (img(array('src'=>'images/item_icon.gif','border'=>0,'style'=>'vertical-align:middle')).nbs(2).'('.$this->cart->total_items().')'.nbs().'view items'), 'class="mm_last items"');
			}
		}
	}
	
	function check_cart()
	{
		// check if cart has items or none
		echo $this->cart->total_items();
	}

	function update_summary()
	{
		if ($_POST['is_edit_price'] == 'N')
		{
			$data = $_POST;
			$this->cart->update($data);
		}
		else
		{
			$z = $this->cart->total_items();
			
			// destroy old cart and insert everything again
			$this->cart->destroy();
			
			for ($y = 1; $y <= $z; $y++)
			{
				$p_exp = explode('=', $_POST['cart_val_'.$y]);
				// array(prod_no, color_code, prod_name, wholesale_price, colors, prod_color, path_to_img)
				$prod_item[$p_exp[0].'_'.$p_exp[1]] = array($p_exp[0], $p_exp[1], $p_exp[2], $p_exp[3], $p_exp[4], $p_exp[5], $p_exp[6]);
				
				// set new price to $1 for zero wholesale price to be able to add to cart
				$price = $p_exp[3] == $_POST['price_'.$y] ? $p_exp[3] : $_POST['price_'.$y] ;
				
				$product_data = array(
					'id'      => $p_exp[0].'_'.$p_exp[1],
					'qty'     => 1,
					'price'   => $price,
					'name'    => $p_exp[2],
					'options' => array(
						'prod_no' 			=> $p_exp[0],
						'color_code' 		=> $p_exp[1],
						'available_colors'	=> $p_exp[4],
						'product_color'		=> $p_exp[5],
						'image_url'			=> $p_exp[6],
						'val'				=> $_POST['cart_val_'.$y]
					)
				);
				
				// insert item to cart
				$this->cart->insert($product_data);
			}
		}
		
		redirect('sa/product_linesheet_summary', 'location');
	}

	function search_products()
	{
		$this->data['designers_ary'] = $this->designers_ary;

		$search = $this->input->post('search');
		$prod_no_string	= $this->input->post('style_no');
		$d_url_structure = $this->input->post('d_url_structure');
		$c_url_structure = $this->input->post('c_url_structure');
		$sc_url_structure = $this->input->post('sc_url_structure');
		
		if ($search == TRUE)
		{
			// show the serached product thumbs
			$this->show_search_products($prod_no_string, $c_url_structure, $sc_url_structure);
			$this->load->view($this->config->slash_item('template').'sales/template', $this->data);
		}
		else
		{
			// send back to home
			redirect(site_url('sa/apparel'), 'location');
		}
	}
	
	function search_multi_products()
	{
		$this->data['designers_ary'] = $this->designers_ary;

		$search = $this->input->post('search');
		$style_ary	= $this->input->post('style_ary');
		$c_url_structure = 'apparel'; // --> temporarily defaulting to apparel (must change to adap to different cats of designers
		$sc_url_structure = '';
		
		if ($search == TRUE)
		{
			// show the serached product thumbs
			$this->show_search_products($style_ary, $c_url_structure, $sc_url_structure);
			$this->load->view($this->config->slash_item('template').'sales/template', $this->data);
		}
		else
		{
			// send back to home
			redirect(site_url('sa/apparel'), 'location');
		}
	}
	
	function clear_items()
	{
		// destroy cart
		$this->cart->destroy();
		
		$array_items = array(
			'recipients_name' => '',
			'recipients_email' => '',
			'bcc_email' => '',
			'comments_overall' =>''
		);
		$this->session->unset_userdata($array_items);
		
		// show the product line sheet summary page ============================================================
		$this->show_product_linesheet('', 'empty_cart');
		$this->load->view($this->config->slash_item('template').'sales/template', $this->data);
	}
	
	function remembering()
	{
		// set session for input field
		switch ($_POST['id'])
		{
			case "recipients_name":
				if ($_POST['val'] != '')
				{
					$this->session->set_userdata('recipients_name', $_POST['val']);
					echo $this->session->userdata('recipients_name');
				}
				else $this->session->unset_userdata('recipients_name');
			break;
			
			case "recipients_email":
				if ($_POST['val'] != '')
				{
					$this->session->set_userdata('recipients_email', $_POST['val']);
					echo $this->session->userdata('recipients_email');
				}
				else $this->session->unset_userdata('recipients_email');
			break;
			
			case "bcc_email":
				if ($_POST['val'] != '')
				{
					$this->session->set_userdata('bcc_email', $_POST['val']);
					echo $this->session->userdata('bcc_email');
				}
				else $this->session->unset_userdata('bcc_email');
			break;
			
			case "comments_overall":
				if ($_POST['val'] != '')
				{
					$this->session->set_userdata('comments_overall', $_POST['val']);
					echo $this->session->userdata('comments_overall');
				}
				else $this->session->unset_userdata('comments_overall');
			break;
			
			default:
				$array_items = array(
					'recipients_name' => '',
					'recipients_email' => '',
					'bcc_email' => '',
					'comments_overall' =>''
				);
				$this->session->unset_userdata($array_items);
				echo '';
			break;
		}
	}
	
	function log_out()
	{
		// destroy user session
		$ary_sesdata = array(
			'admin_sales_loggedin'	=> FALSE,
			'admin_sales_user'		=> '',
			'admin_sales_lname'		=> '',
			'admin_sales_email'		=> ''
		);
		$this->session->unset_userdata($ary_sesdata);

		// destroy input fields session
		$array_items = array(
			'recipients_name' => '',
			'recipients_email' => '',
			'bcc_email' => '',
			'comments_overall' =>''
		);
		$this->session->unset_userdata($array_items);
		
		$this->check_sales_admin_logged_in('log_out');
	}
}
