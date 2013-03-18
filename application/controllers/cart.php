<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends Frontend_Controller {

	function __Construct()
	{
		parent::__Construct();
	}
	
	function index()
	{
		//print_r($this->cart->contents());
		//die();
		
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
		
		$this->data = array(
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
		
		$this->load->view($this->config->slash_item('template').'template', $this->data);
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
		$prod_image		= $this->input->post('prod_image');
		$previous_url	= $this->input->post('current_url');
		$color			= $this->input->post('label_color');
		$designer		= $this->input->post('label_designer');
		
		$qty			= $this->input->post('qty');
		$size			= $this->input->post('size');

		// This function allows for zero integer as not empty in a variable
		// especially made for size '0' which is always mistekan as empty for isset() function
		function is_empty($var, $allow_false = false, $allow_ws = false) {
			if (!isset($var) || is_null($var) || ($allow_ws == false && trim($var) == "" && !is_bool($var)) || ($allow_false === false && is_bool($var) && $var === false) || (is_array($var) && empty($var))) {   
				return true;
			} else {
				return false;
			}
		}
		
		if ($cat_id <> 19 && is_empty($size))
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please select a product size.</div>');
			redirect($previous_url, 'location');
		} 
		
		if ( ! $qty)
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please select quantity.</div>');
			redirect($previous_url, 'location');
		}
		
		if ($price == '0.00')
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Product has no price. Please select another product.</div>');
			redirect($previous_url, 'location');
		}

		/*
		echo $cat_id.'<br />';
		echo $subcat_id.'<br />';
		echo $color_code.'<br />';
		echo $des_id.'<br />';
		echo $prod_sku.'<br />';
		echo $prod_no.'<br />';
		echo $prod_name.'<br />';
		echo $price.'<br />';
		echo $prod_image.'<br />';
		echo $previous_url.'<br />';
		echo $color.'<br />';
		echo $designer.'<br />';
		
		echo $qty.'<br />';
		echo $size.'<br />';
		die();
		*/

		$this->data = array(
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

		$this->cart->insert($this->data);
		
		// Asked to be removed
		//$this->session->set_flashdata('flashMsg','<div class="successMsg">The product you selected has been added to your cart.</div>');
		redirect('cart', 'location');
	}
	
	function update_cart()
	{
		$data = $_POST;
		$this->cart->update($data); 
		
		$this->session->set_flashdata('flashMsg','<div class="successMsg">Cart has been updated.</div>');
		redirect('cart', 'location');
	}
	
	function update_shipfee()
	{
		$ship_id 		= $this->uri->segment(3);
		$ship_method	= $this->query_product->get_single_shipping($ship_id);
		$new_fee 		= $ship_method->fix_fee;
		
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
		$previous_url		= $this->input->post('current_url');
		$ship_country		= $this->input->post('ship_country');
		$ship_ship_country	= $this->input->post('ship_ship_country');
		
		if ($ship_country == '' && $ship_ship_country == '')
		{
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">Please select shipping options or select a country!</div>');
			redirect($previous_url, 'location');
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
			redirect('cart/customer_info', 'location');
		}
		else
		{
			redirect('cart/confirm_order', 'location');
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
		$this->load->view($this->config->slash_item('template').'template',$data);
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
		$this->load->view($this->config->slash_item('template').'template',$data);
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
		
		$this->load->view($this->config->slash_item('template').'template',$data);
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
				redirect('cart/confirm_order', 'location', 302);
			}
		
			if ($agree_to_return_policy != 'aye')
			{
				$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please agree to the Return Policy</div>');
				redirect('cart/confirm_order', 'location', 302);
			}
		}
		else $grand_total = $this->cart->total();
		
		if ( ! $sh_address1 || !$sh_city || !$sh_state || !$sh_country || !$sh_zipcode)
		{
			$this->session->set_flashdata('flashMsg','<div class="errorMsg">Please enter shipping address fields correctly</div>');
			redirect('cart/confirm_order', 'location', 302);
		}
	
		// Log order
		if ($this->session->userdata('user_cat') === 'user')
		{
			$order_log_id = $this->_log_order($user_array); //for retail
		}
		elseif ($this->session->userdata('user_cat') === 'wholesale')
		{
			$order_log_id = $this->min_order_required($user_array); //for wholesale	
		}
		
		// access default message content
		require ('email_order_confirmation.php');
		
		// send order to admin
		$email_message_to_admin = $email_content;
		
		// send order to user
		$email_message_to_user = $email_content_2;
		
		// load library
		$this->load->library('email', $config);
		
		if (ENVIRONMENT === 'development')
		{
			$this->email->set_crlf("\r\n"); // ---> some code to fix the email sending
			$this->email->set_newline("\r\n"); // ---> some code to fix the email sending
		}
		
		$my_email = $this->config->item('info_email');
		$from_email = $this->config->item('info_email');
		
		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// from site info email
			$this->email->from($from_email, $this->config->item('site_name'));
			
			// subject
			$this->email->subject($this->config->item('site_name').' Product Order [Dev - user email]');
			
			// developer email
			$this->email->to($this->config->item('dev1_email'));
			
			// content
			$this->email->message($email_message_to_user);
			
			if ( ! $this->email->send())
			{
				echo "Email was not sent!";
				if (ENVIRONMENT == 'development')
				{
					echo br().$this->email->print_debugger();
					die();
				}
			}
			
			// ====================> clear email variables
			$this->email->clear();

			// from site info email
			$this->email->from($from_email, $this->config->item('site_name'));
			
			// subject
			$this->email->subject($this->config->item('site_name').' Product Order [Dev - admin email]');
			
			// developer email
			$this->email->to($this->config->item('dev1_email'));

			// reply to customers email address
			$this->email->reply_to($p_email);
			
			// content
			$this->email->message($email_message_to_admin);
			
			if ( ! $this->email->send())
			{
				echo "Email was not sent!";
				if (ENVIRONMENT == 'development')
				{
					echo br().$this->email->print_debugger();
					die();
				}
			}
		}
		else
		{
			// from site info email
			$this->email->from($from_email, $this->config->item('site_name'));
			
			//$this->email->bcc($this->config->item('dev1_email')); // ----> for debuggin purposes only
			
			// subject
			$this->email->subject($this->config->item('site_name').' Product Order');
			
			$send_to = $p_email;  // ----> user email
			$this->email->to($send_to);
			// content
			$this->email->message($email_message_to_user);
			
			if ( ! $this->email->send())
			{
				echo "Email was not sent!";
				if (ENVIRONMENT == 'development')
				{
					echo br().$this->email->print_debugger();
					die();
				}
			}
			
			// ====================> clear email variables
			$this->email->clear();

			// from site info email
			$this->email->from($from_email, $this->config->item('site_name'));

			// developers email address array for debugging purposes
			$dev_email = array($this->config->item('dev1_email'), $this->config->item('dev2_email'));
			
			$this->email->bcc($dev_email); // ----> for debuggin purposes only
			
			// subject
			$this->email->subject($this->config->item('site_name').' Product Order');
			
			$send_to = $my_email;  // ----> admin email (site info email)
			$this->email->to($send_to);

			// reply to customers email address
			$this->email->reply_to($p_email);

			// content
			$this->email->message($email_message_to_admin);
			
			if ( ! $this->email->send())
			{
				echo "Email was not sent!";
				if (ENVIRONMENT == 'development')
				{
					echo br().$this->email->print_debugger();
					die();
				}
			}
		}
		
		/*
			// test view - debugging purposes
			$datum['html1'] = $email_message_to_admin;
			$datum['html2'] = $email_message_to_user;
			$this->load->view('order', $datum);
		*/
			
		$this->cart->destroy();
		$data = array(
			'shipping_courier'	=> '',
			'shipping_fee'		=> '',
			'shipping_id'		=> ''
		);
		$this->session->unset_userdata($data);
		
		redirect('cart/order_sent','location');
	}
	
	function order_sent() {
		
		/*
		| ------------------------------------------------------------------------------
		| Adding a db query to tblmeta pagename = index.php
		| Resulting row has dfooter that is editable at admin Meta Management >> Edit/Delit Meta
		*/
		$pagename = 'order_sent.php';
		
		// this is the database query which should be eventually transferred at models/query_page.php
		$q_meta = $this->db->get_where('tblmeta',array('pagename'=>$pagename));
		$meta_row = $q_meta->row();
		
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
		$this->load->view($this->config->slash_item('template').'template',$data);
	}

	function _log_order($user_array)
	{
		// insert user and shipping data to order log
		$log_data = array(
			'user_id'			=> $this->session->userdata('user_id'),
			'date_ordered'		=> @date('d, F Y - h:i',time()),
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
	
	function min_order_required($user_array)
	{
		/*
		| ------------------------------------------------------------------------------
		| This function check if the wholesale user has previous orders if not
		| it will require 15 minimum units
		*/
		$totqty = 0;
		$user_id = $this->session->userdata('user_id');
		$check = $this->query_product->check_first_order($user_id);
		
		//count cart items
		foreach ($this->cart->contents() as $items)
		{
			$totqty += $items['qty'];
		}
		
		if ($check->row()->qty < 15 && $totqty < 15)
		{
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">Minimun First Order 15 Units. Please add more items to cart.</div>');
			redirect('cart', 'location');
		}
		else		
		{
			$order_log_id = $this->_log_order($user_array);
		}
		
		return $order_log_id;
	}
}
