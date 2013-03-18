<div id="header_wrapper">
	<div id="header">
	
		<div id="logo">
			<?php echo anchor(str_replace('https', 'http', site_url()),img(array('src'=>base_url().'images/instyle_logo.jpg','alt'=>$this->config->item('site_name')))); ?>
		</div>
		
		<div id="mainmenu">
			<?php
				/*
				|-----------------------------------------
				| NEW ARRIVALS
				| ----> requested to be hidden temporarily by joe
				$link_style = (
					$this->uri->segment(1) == 'new-arrival.html' OR 
					$this->uri->segment(1) == 'new-arrival' OR
					$this->uri->segment(1) == 'new-arrival-facets' OR
					$this->uri->segment(1) == 'new-arrival-designer.html' OR 
					$this->uri->segment(1) == 'new-arrival-designer' OR
					$this->uri->segment(1) == 'new-arrival-designer-facets'
					) ? 'active' : '';
				echo anchor(str_replace('https','http',site_url('new-arrival.html')),'NEW ARRIVALS','class="mm_first '.$link_style.'"');
				*/

				/*
				|-----------------------------------------
				| WOMENS APPAREL
				*/
				$link_style = (
					$this->uri->segment(1) == 'apparel' OR 
					$this->uri->segment(1) == 'apparel-1.html' OR 
					$this->uri->segment(1) == 'apparel-1' OR 
					$this->uri->segment(1) == 'apparel-designer-1.html' OR 
					$this->uri->segment(1) == 'apparel-designer-1' OR
					$this->uri->segment(1) == 'apparel-facets-1' OR
					$this->uri->segment(1) == 'apparel-designer-facets-1'
					) ? 'active' : '';
				echo anchor(str_replace('https','http',site_url('apparel')),'WOMENS APPAREL','class="mm_first '.$link_style.'"');
				
				// remove reference to last element
				unset($link_style);

				//
				//|-----------------------------------------
				//| OUTERWEAR
				//
				$link_style = $this->uri->segment(1) == 'outerwear' ? 'active' : '';
				echo anchor(str_replace('https','http',site_url('outerwear')),'OUTERWEAR','class="'.$link_style.'"');

				// remove reference to last element
				unset($link_style);

				/*
				//
				//|-----------------------------------------
				//| ACCESSORIES
				//
				if ($this->session->userdata('user_cat') != 'wholesale')
				{
					$link_style = (
						$this->uri->segment(1) == 'jewelry' OR 
						$this->uri->segment(1) == 'jewelry-19.html' OR 
						$this->uri->segment(1) == 'jewelry-19' OR 
						$this->uri->segment(1) == 'jewelry-designer-19.html' OR 
						$this->uri->segment(1) == 'jewelry-designer-19' OR
						$this->uri->segment(1) == 'jewelry-facets-19' OR 
						$this->uri->segment(1) == 'jewelry-designer-facets-19'
						) ? 'active' : '';
					echo anchor(str_replace('https','http',site_url('jewelry')),'ACCESSORIES','class="'.$link_style.'"');
				}

				// remove reference to last element
				unset($link_style);
				*/

				/*
				if ($this->session->userdata('user_cat') == 'wholesale')
				{
					//
					//|-----------------------------------------
					//| CLEARANCE
					//| ----> requested to be hidden temporarily by joe
					//
					$link_style = (
						$this->uri->segment(1) == 'clearance.html' OR 
						$this->uri->segment(1) == 'clearance' OR
						$this->uri->segment(1) == 'clearance-facets' OR
						$this->uri->segment(1) == 'clearance-designer.html' OR 
						$this->uri->segment(1) == 'clearance-designer' OR
						$this->uri->segment(1) == 'clearance-designer-facets'
						) ? 'active' : '';
					//echo anchor(str_replace('https','http',site_url('clearance/cocktail-dresses-75')),'CLEARANCE','class="'.$link_style.'"');
					echo anchor(str_replace('https','http',site_url('clearance/cocktail-dresses')),'CLEARANCE','class="'.$link_style.'"');

					// remove reference to last element
					unset($link_style);

					//
					//|-----------------------------------------
					//| LOGOUT - for wholesale
					//
					echo anchor(str_replace('https','http',site_url('sign_out')),'LOGOUT','style="color:red;"');
				}
				*/

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
				$live_chat = 'active';
				if ($live_chat == 'active')
				{
					//echo '<a href="javascript: void();" class="mm_last active" onclick="return win1()" style="color:white;"><img src="'.base_url().'admin/phponline/statusimage.php"></a>';
					//echo anchor('javascript: void()','LIVE CHAT','class="active"');
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
