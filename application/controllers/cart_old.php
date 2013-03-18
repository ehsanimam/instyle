<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller
{
	function __Construct()
	{
		parent::__Construct();
		
		$this->load->model('query_category');
		$this->load->model('query_product');
		$this->load->model('query_users');
		$this->load->model('query_page');		
	  
		$this->load->add_package_path(APPPATH.'third_party/formtoemail/');
	}
	
	function index() {
		
		$jscript = $this->set->jquery();
		$jscript .= '
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
				function getFee(strURL) {
					var req = getXMLHTTP();
					if (req) {
						req.onreadystatechange = function() {
							if (req.readyState == 4) {
								// only if "OK"
								if (req.status == 200) {
									document.getElementById(\'shipdiv\').innerHTML=req.responseText;
									document.getElementById(\'label_select_ship_country\').innerHTML=\'Your country is USA\';
									document.getElementById(\'input_select_ship_country\').style.display=\'none\';
									document.getElementById(\'ship_ship_country\').value=\'United States\';
								} else {
									alert("There was a problem while using XMLHTTP:\n" + req.statusText);
								}
							}				
						}			
						req.open("GET", strURL, true);
						req.send(null);
					}
				}
				function remove_ship_options(strURL2) {
					var req2 = getXMLHTTP();
					if (req2) {
						req2.onreadystatechange = function() {
							if (req2.readyState == 4) {
								// only if "OK"
								if (req2.status == 200) {
									document.getElementById(\'label_ship\').style.display=\'none\';
									document.getElementById(\'text_ship\').innerHTML=req2.responseText;
									document.getElementById(\'input_ship\').style.display=\'none\';
									document.getElementById(\'info_ship_1\').style.display=\'none\';
									document.getElementById(\'info_ship_2\').style.display=\'none\';
									document.getElementById(\'info_ship_3\').style.display=\'none\';
								} else {
									alert("There was a problem while using XMLHTTP:\n" + req2.statusText);
								}
							}				
						}			
						req2.open("GET", strURL2, true);
						req2.send(null);
					}
				}
			</script>
		';
		$jscript	.= $this->set->fade_thumbs_js();
		
		//$default_ship_method = $this->query_product->get_default_ship_fee();
		$get_products_oncart = $this->query_product->get_products_oncart(19);
		
		//$DB2 = $this->load_session_db();
		
		if ($this->session->userdata('user_cat') != 'wholesale')
		{
			$data_shipping = array(
				'shipping_fee'		=> '',
				'shipping_id'		=> '',
				'shipping_country'	=> '',
				'shipping_courier'	=> ''
			);
			$this->session->unset_userdata($data_shipping);
		
			$reset_checkbox = 'onload="reset_checkboxes()"';
			$function_reset_checkboxes = '
				<script>
					function reset_checkboxes() {
						frmlen=document.forms.length
						for(i=0;i<frmlen;i++)
							{document.forms[i].reset()}
						document.getElementById("dvloader").style.display="none";
					}
				</script>
			';
			$div_loader = '<div style="display:block" id="dvloader"><img src="'.base_url().'images/loadingAnimation.gif" /><br />Loading</div>';
		}
		else
		{
			$reset_checkbox = '';
			$function_reset_checkboxes = '';
			$div_loader = '';
		}
		
		$data = array(
			'file'							=> 'cart_basket',
			'jscript'						=> $jscript,
			'get_products_oncart'			=> $get_products_oncart,
			'reset_checkbox'				=> $reset_checkbox,
			'function_reset_checkboxes' 	=> $function_reset_checkboxes,
			'div_loader'					=> $div_loader,
			'site_title'					=> $this->config->item('site_title'),
			'site_keywords'					=> $this->config->item('site_keywords'),
			'site_description'				=> $this->config->item('site_description'),
			'footer_text'					=> $this->config->item('site_name').' Checkout Step 1'
		);
		$this->load->view('template',$data);
	}
	
	function add_cart()
	{
		$cat_id			= $this->input->post('cat_id');
		$subcat_id		= $this->input->post('subcat_id');
		$color_code		= $this->input->post('color_code');
		$des_id			= $this->input->post('des_id');
		$prod_sku		= $this->input->post('prod_sku');
		$prod_no		= $this->input->post('prod_no');
		$prod_name		= $this->input->post('prod_name');
		$price			= $this->input->post('price');
		$qty			= $this->input->post('qty');
		$size			= $this->input->post('size');
		$previous_url	= $this->input->post('current_url');
		$prod_image		= $this->input->post('prod_image');
		$color			= $this->input->post('label_color');
		$designer		= $this->input->post('label_designer');

		// This function allows for zero integer as not empty in a variable
		// especially made for size '0' which is always mistekan as empty for isset() function
		function is_empty($var, $allow_false = false, $allow_ws = false) {
			if (!isset($var) || is_null($var) || ($allow_ws == false && trim($var) == "" && !is_bool($var)) || ($allow_false === false && is_bool($var) && $var === false) || (is_array($var) && empty($var))) {   
				return true;
			} else {
				return false;
			}
		}
		
		//$DB2 = $this->load_session_db();
		
		if ($cat_id <> 19 && is_empty($size))
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please select a product size.</div>');
			redirect($previous_url, 'location', 301);
		} 
		
		if ( ! $qty)
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please select quantity.</div>');
			redirect($previous_url, 'location', 301);
		}
		
		if ($price == '0.00')
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Product has no price. Please select another product.</div>');
			redirect($previous_url, 'location', 301);
		}
		
		$data = array(
               'id'      => $prod_sku,
               'qty'     => $qty,
               'price'   => $price,
               'name'    => $prod_name,
               'options' => array(
					'size' 			=> $size, 
					'prod_no' 		=> $prod_no, 
					'color_code' 	=> $color_code,
					'des_id'		=> $des_id,
					'cat_id'		=> $cat_id,
					'subcat_id'		=> $subcat_id,
					'prod_image'	=> $prod_image,
					'color'			=> $color,
					'designer'		=> $designer,
					'current_url'	=> $previous_url
				)
            );
		$this->cart->insert($data); 
		// Asked to be removed
		//$this->session->set_flashdata('flashMsg','<div class="successMsg">The product you selected has been added to your cart.</div>');
		redirect('cart', 'location', 302);
	}
	
	function update_cart()
	{
		$data = $_POST;
		$this->cart->update($data); 
		
		$this->session->set_flashdata('flashMsg','<div class="successMsg">Cart has been updated.</div>');
		redirect('cart', 'location', 302);
	}
	
	function update_shipfee()
	{
		$ship_id 		= $this->uri->segment(3);
		$ship_method	= $this->query_product->get_single_shipping($ship_id);
		$new_fee 		= $ship_method->fix_fee;
		
		//$DB2 = $this->load_session_db();
		
		$this->session->set_userdata(array(
			'shipping_courier'	=> $ship_method->courier,
			'shipping_fee'		=> $new_fee,
			'shipping_id'		=> $ship_id,
			'shipping_country'	=> 'United States'
		));
		?>
		
		<input type="hidden" name="ship_id" value="<?php echo $ship_id; ?>" />
		<input type="hidden" name="ship_courier" value="<?php echo $ship_method->courier; ?>" />
		<input type="hidden" name="ship_fee" value="<?php echo $new_fee; ?>" />
		<strong><?php echo $this->config->item('currency'); ?><?php echo $this->cart->format_number($this->cart->total() + $new_fee); ?></strong>
		
		<?php
	}
	
	function remove_ship_options()
	{
		//$DB2 = $this->load_session_db();
		
		$this->session->set_userdata('shipping_courier','DHL for countries other than USA');
		$datum = array(
			'shipping_fee'		=> '',
			'shipping_id'		=> '',
		);
		$this->session->unset_userdata($datum);
		
		echo 'Shipping via DHL for countries outside USA';
	}
	
	function process_cart()
	{
		//$DB2 = $this->load_session_db();
		
		$previous_url		= $this->input->post('current_url');
		$ship_country		= $this->input->post('ship_country');
		$ship_ship_country	= $this->input->post('ship_ship_country');
		
		if ($ship_country == '' && $ship_ship_country == '')
		{
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">Please select shipping options or select a country!</div>');
			redirect($previous_url, 'location', 301);
		}
		
		/*
		| --------------------------------------------------------------------------------------
		| Setting session shipping information for if USA or other countries
		*/
		if ($this->session->userdata('user_cat') == 'wholesale')
		{
			if ($this->session->userdata('shipping_country') != 'United States')
			{
				$shipping_id		= '';
				$shipping_courier	= 'DHL for countries other than USA';
				$shipping_fee		= '';
		
				$this->session->set_userdata(
					array(
						'shipping_courier'	=> $shipping_courier,
						'shipping_fee'		=> $shipping_fee,
						'shipping_id'		=> $shipping_id
					)
				);
			}
		}
		else
		{
			if ($this->input->post('ship_country')) $this->session->set_userdata('shipping_country',$this->input->post('ship_country'));
		}
		
		if ( ! $this->session->userdata('user_loggedin'))
		{
			redirect('cart/customer_info', 'location', 301);
		}
		else
		{
			redirect('cart/confirm_order', 'location', 301);
		}
	}
	
	/*
	| ------------------------------------------------------------------------------------------
	| This is the new cart registration process - an automated process and will be needing a new table
	| while affecting the old table as well
	*/
	function customer_info()
	{
		$data = array(
			'file'					=> 'customer_info',
			'jscript'				=> '',
			'site_title'			=> $this->config->item('site_title'),
			'site_keywords'			=> $this->config->item('site_keywords'),
			'site_description'		=> $this->config->item('site_description'),
			'footer_text'			=> $this->config->item('site_name').' Checkout Step 2'
		);
		$this->load->view('template',$data);
	}
	
	function signin_register()
	{
		$data = array(
			'file'					=> 'signin_register',
			'jscript'				=> '',
			'site_title'			=> $this->config->item('site_title'),
			'site_keywords'			=> $this->config->item('site_keywords'),
			'site_description'		=> $this->config->item('site_description')
		);
		$this->load->view('template',$data);
	}
	
	function confirm_order()
	{
		$jscript = $this->set->jquery().'
			<link type="text/css" href="'.base_url().'jscript/themes/base/jquery.ui.all.css" rel="stylesheet" />
			<script type="text/javascript" src="'.base_url().'jscript/external/jquery.bgiframe-2.1.1.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.core.js"></script>					
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.widget.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.mouse.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.button.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.draggable.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.position.js"></script>
			<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.dialog.js"></script>
			
			<script>
				// increase the default animation speed to exaggerate the effect
				$.fx.speeds._default = 1000;
				$(function() {
					$( "#dialog" ).dialog({
						autoOpen: false,
						show: "blind",
						hide: "explode",
						width: 600,
						position: "center",
						zIndex: 9999
					});
					
					$( "#opener" ).click(function() {
						$( "#dialog" ).dialog( "open" );
						return false;
					});
					
					$( "#dialog_return_policy_agree" ).dialog({
						autoOpen: false,
						show: "blind",
						hide: "explode",
						width: 800,
						position: "center",
						zIndex: 9999
					});
					
					$( "#return_policy_agree" ).click(function() {
						$( "#dialog_return_policy_agree" ).dialog( "open" );
						return false;
					});
				});
			</script>
		';
		
		//$DB2 = $this->load_session_db();
		
		if ($this->session->userdata('user_cat') == 'wholesale')
		{
			$q_user_info = $this->query_users->get_single_user_tbluser_wholesale($this->session->userdata('user_id'));
		}
		else
		{
			$q_user_info = $this->query_users->get_single_user_tbluser($this->session->userdata('user_id'));
		}
		
		$get_products_oncart = $this->query_product->get_products_oncart(19); // ----> used for suggesting
		
		$data = array(
			'file'					=> 'confirm_order',
			'jscript'				=> $jscript,
			'cur_user_info'			=> $q_user_info,
			'get_products_oncart'	=> $get_products_oncart,
			'site_title'			=> $this->config->item('site_title'),
			'site_keywords'			=> $this->config->item('site_keywords'),
			'site_description'		=> $this->config->item('site_description'),
			'footer_text'			=> 'Order Confirmation For '.$this->config->item('site_domain')
		);
		
		$this->load->view('template',$data);
	}
	
	function submit_order()
	{
		$p_card_type		= $this->input->post('payment_card_type');
		$p_card_num			= $this->input->post('payment_card_num');
		$p_exp_date			= $this->input->post('payment_exp_date');
		$p_card_code		= $this->input->post('payment_card_code');
		
		$p_first_name		= $this->input->post('payment_first_name');
		$p_last_name		= $this->input->post('payment_last_name');
		$p_email			= $this->input->post('email');
		$p_telephone		= $this->input->post('payment_telephone');
		$p_store_name		= $this->input->post('payment_storename') ? $this->input->post('payment_storename') : '';
		
		$p_address_1		= $this->input->post('payment_address_1');
		$p_address_2		= $this->input->post('payment_address_2');
		$p_city				= $this->input->post('payment_city');
		$p_state			= $this->input->post('payment_state');
		$p_country			= $this->input->post('payment_country');
		$p_zip				= $this->input->post('payment_zip');
		
		$sh_address1		= $this->input->post('shipping_address1');
		$sh_address2		= $this->input->post('shipping_address2');
		$sh_city			= $this->input->post('shipping_city');
		$sh_state			= $this->input->post('shipping_state');
		$sh_country			= $this->input->post('shipping_country');
		$sh_zipcode			= $this->input->post('shipping_zipcode');
		
		//$DB2 = $this->load_session_db();
		
		if ($this->session->userdata('user_cat') === 'user')
		{
			$agree_to_return_policy = $this->input->post('agree_to_return_policy');
			$user_array['agree_policy'] = $agree_to_return_policy  == 'aye' ? TRUE : FALSE;
		}
		else $user_array['agree_policy'] = NULL;
		
		$user_array['p_first_name'] 	= $p_first_name;
		$user_array['p_last_name'] 		= $p_last_name;
		$user_array['p_email'] 			= $p_email;
		$user_array['p_telephone'] 		= $p_telephone;
		$user_array['p_store_name'] 	= $p_store_name;
		
		$user_array['sh_address1']		= $sh_address1;
		$user_array['sh_address2']		= $sh_address2;
		$user_array['sh_city']			= $sh_city;
		$user_array['sh_state']			= $sh_state;
		$user_array['sh_country']		= $sh_country;
		$user_array['sh_zipcode']		= $sh_zipcode;
		
		if ($this->session->userdata('user_cat') === 'user')
		{
			$grand_total = $this->cart->total() + $this->session->userdata('shipping_fee');
		
			if ( ! $p_card_type || !$p_card_num || !$p_exp_date || !$p_card_code)
			{
				$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please complete payment detail fields</div>');
				redirect('cart/confirm_order', 'location', 301);
			}
		
			if ($agree_to_return_policy != 'aye')
			{
				$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please agree to the Return Policy</div>');
				redirect('cart/confirm_order', 'location', 301);
			}
		}
		else $grand_total = $this->cart->total();
		
		if ( ! $sh_address1 || !$sh_city || !$sh_state || !$sh_country || !$sh_zipcode)
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please enter shipping address fields correctly</div>');
			redirect('cart/confirm_order', 'location', 301);
		}
	
		// Log order
		$order_log_id = $this->_log_order($user_array);
		
		// access default message content
		require ('email_order_confirmation.php');
		
		// send order to admin
		$email_message = $email_content;
		
		$this->load->library('email');
		if (ENVIRONMENT === 'development') $this->email->set_newline("\r\n"); // ---> some code to fix the email sending
		
		$my_email = $this->config->item('info_email');
		$from_email = $this->config->item('info_email');
		
		$this->email->from($from_email, $this->config->item('site_name'));
		
		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			$this->email->to($this->config->item('dev1_email'));
		}
		else
		{
			$this->email->to($p_email);
			$this->email->cc($my_email);
			$this->email->bcc($this->config->item('dev1_email')); // ----> for debuggin purposes only
		}
		
		$this->email->subject($this->config->item('site_name').' Product Order');
		$this->email->message($email_message);
		
		if ( ! $this->email->send())
		{
			echo "Email was not sent!";
			if (ENVIRONMENT == 'development')
			{
				//echo br().$this->email->print_debugger();
				//die(); // ---> for debugging purposes
			}
		}
		// end send email confirmation
		
		//$DB2 = $this->load_session_db();
		
		$this->cart->destroy();
		$data = array(
			'shipping_courier'	=> '',
			'shipping_fee'		=> '',
			'shipping_id'		=> ''
		);
		$this->session->unset_userdata($data);
		
		redirect('cart/order_sent','location',301);
	}
	
	function order_sent() {
		
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'order_sent.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		//$DB3 = $this->load_db();
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
		//$DB2 = $this->load_session_db();
		
		$userid = $this->session->userdata('user_id');
		$order_log = $this->query_users->get_user_orders($userid);
		$order_log = $order_log->row();
		$order_log_details = $this->query_users->get_user_order_details($order_log->order_log_id);
		
		$data = array(
			'file' 					=> 'order_sent',
			'order_log'				=> $order_log,
			'order_log_details'		=> $order_log_details,
			'jscript'				=> '',
			'page_footer_meta'		=> $meta_row->dfooter, // added this variable for the footer text meta
			'site_title'			=> $meta_row->title,
			'site_keywords'			=> $meta_row->keyword,
			'site_description'		=> $meta_row->description,
			'footer_text'			=> $meta_row->dfooter
		);
		$this->load->view('template',$data);
	}

	function _log_order($user_array)
	{
		//$DB2 = $this->load_session_db();
		
		// insert user and shipping data to order log
		$log_data = array(
			'user_id'			=> $this->session->userdata('user_id'),
			'date_ordered'		=> date('d, F Y - h:i',time()),
			'courier'			=> $this->session->userdata('shipping_courier'),
			'shipping_fee'		=> (int)$this->session->userdata('shipping_fee'),
			'amount'			=> $this->cart->total() + $this->session->userdata('shipping_fee'),
			
			'firstname'			=> $user_array['p_first_name'],
			'lastname'			=> $user_array['p_last_name'],
			'email'				=> $user_array['p_email'],
			'telephone'			=> $user_array['p_telephone'],
			'store_name'		=> $user_array['p_store_name'],
		
			'ship_address1'		=> $user_array['sh_address1'],
			'ship_address2'		=> $user_array['sh_address2'],
			'ship_country'		=> $user_array['sh_country'],
			'ship_state'		=> $user_array['sh_state'],
			'ship_city'			=> $user_array['sh_city'],
			'ship_zipcode'		=> $user_array['sh_zipcode'],
			
			'agree_policy'		=> $user_array['agree_policy']
		);
		$this->query_product->insert_order_log($log_data);
		
		$order_log_id	= $this->db->insert_id();
		$random_code	= strtoupper(random_string('alnum', 16)); // ----> randon_string() - a CI string helper function.
		
		// insert cart/order details to order log detail
		$i = 1;
		foreach ($this->cart->contents() as $items):
			$log_detail_data = array(
				'order_log_id'			=> $order_log_id,
				'transaction_code'		=> $random_code,
				'image'					=> $items['options']['prod_image'],
				'prod_sku'				=> $items['id'],
				'prod_no'				=> $items['options']['prod_no'],
				'prod_name'				=> $items['name'],
				'color'					=> $items['options']['color'],
				'size'					=> $items['options']['size'],
				'designer'				=> $items['options']['designer'],
				'qty'					=> $items['qty'],
				'unit_price'			=> $items['price'],
				'subtotal'				=> $items['subtotal']
			);
		$this->query_product->insert_order_log_detail($log_detail_data);
		$i++;
		endforeach;
		
		return $order_log_id;
	}
}
