<div id="header_wrapper">
	<div id="header">
	
		<div id="logo">
			<?php echo anchor(str_replace('https', 'http', site_url()),img(array('src'=>site_url('images/'.$this->config->item('template').'/storybook_logo.png'), 'alt'=>$this->config->item('site_name')))); ?>
		</div>
		
		<div id="mainmenu">
			<?php
			/*
			|-----------------------------------------
			| MAIN MENU ITEMS
			*/
			// ---> SHOP
			$link_style = ($this->uri->segment(1) == 'sweaters') ? 'active' : '';
			echo anchor(str_replace('https','http',site_url('sweaters')),'SHOP COLLECTION','class="mm_first '.$link_style.'"');
			
			// remove reference to last element
			unset($link_style);
			
			// ---> MEET JAMIE
			$link_style = ($this->uri->segment(1) == 'meet_jamie') ? 'active' : '';
			echo anchor(str_replace('https','http',site_url('meet_jamie')),'MEET JAMIE','class="'.$link_style.'"');
			
			// remove reference to last element
			unset($link_style);
			
			// ---> ABOUT
			$link_style = ($this->uri->segment(1) == 'about') ? 'active' : '';
			echo anchor(str_replace('https','http',site_url('about')),'ABOUT','class="'.$link_style.'"');
			
			// remove reference to last element
			unset($link_style);

			/*
			|-----------------------------------------
			| REGISTER - for consumers
			*/
			if ($this->session->userdata('user_cat') != 'wholesale')
			{
				$link_style = uri_string() == 'register' ? 'active' : '';
				$link2 = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? site_url('register') : str_replace('http','https',site_url('register'));
				
				echo anchor((ENVIRONMENT === 'development' OR ENVIRONMENT === 'testing') ? site_url('register') : $link2,'REGISTER','class="'.$link_style.'"');
			}

			// remove reference to last element
			unset($link_style);
			
			/*
			| ---------------------------------------------------------------------------------------
			| hiding signin temporarily
			|
			$link_style = ($this->uri->segment(1) == 'singin.html') ? 'active' : '';
			echo anchor(site_url('signin.html'),'SIGN IN','class="'.$link_style.'"');
			*/

			/*
			|-----------------------------------------
			| SHOPPING CART
			*/
			if (ENVIRONMENT === 'development' OR ENVIRONMENT === 'testing')
			{
				$link1 = site_url('cart');
				echo anchor($link1, (img(array('src'=>'images/item_icon.gif','border'=>0,'style'=>'vertical-align:middle')).nbs(2).'('.$this->cart->total_items().')'.nbs().'ITEMS_'),'class="mm_last items"');
			}
			else
			{
				$link1 = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? site_url('cart') : str_replace('http','https',site_url('cart'));
				echo anchor($link1, (img(array('src'=>'images/item_icon.gif','border'=>0,'style'=>'vertical-align:middle')).nbs(2).'('.$this->cart->total_items().')'.nbs().'ITEMS'),'class="mm_last items"');
			}
			
			/*
			|-----------------------------------------
			| LIVE CHAT
			*/
			$live_chat = 'not_active';
			if ($live_chat == 'active')
			{
				//echo '<a href="javascript: void();" class="mm_last active" onclick="return win1()" style="color:white;"><img src="'.base_url().'admin/phponline/statusimage.php"></a>';
				echo anchor('javascript: void()','LIVE CHAT','class="active"');
			}
			/*
			else
			{
				$link_style = ($this->uri->segment(1) == 'contact.html') ? 'active' : '';
				echo anchor(site_url('contact.html'),'CONTACT','class="'.$link_style.'"');
			}
			*/
			?>
		</div>
		
		<script language="JavaScript" type="text/javascript">
			function win1()
			{
				window.open("<?php echo base_url(); ?>admin/phponline/client.php","Window1","menubar=no,width=520,height=300,toolbar=no");
			}			
			function win_pop()
			{
				window.open("chat_popup.php","Chat Popup","menubar=no,width=600,height=450,toolbar=no,scrollbars=yes");
				return false;
			}
		</script>
			
	</div> <!--eof header-->
</div> <!--eof header_wrapper-->
