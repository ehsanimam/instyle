<?php
	/*
	| ------------------------------------------------------------------------------------------
	| Top tabs control
	*/
	$by_category = 2; // --> 2 means active
	if ($this->uri->segment(2) == 'product_linesheet_summary' OR $this->uri->segment(2) == 'send_product_linesheet')
		$seg_cat = $this->uri->segment(1).'/apparel';
	else $seg_cat = $this->uri->segment(1).'/'.$this->uri->segment(2);
?>
<!--bof form==================================================================================-->
<?php
	if ($file == 'page')
	{
		echo form_open('sa/send_product_linesheet', array('onsubmit'=>'return check_product_linesheet_form();'));
		?>
		<input type="hidden" id="w_prices" name="w_prices" value="Y" />
		<?php
	}
	else echo form_open('sa/product_linesheet_summary');
?>

<table border="0" cellspacing="0" cellpadding="0" width="100%">

	<?php
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar top tabs
	*/
	if ($this->uri->segment(1) != 'clearance')
	{ ?>
		<tr>
				<?php
				// -----------------------------------------
				// --> Browse by Category
				?>
			<td style="width:70px;">
				<?php echo anchor($seg_cat, img(array('src' => 'images/bu_cat1_'.$by_category.'.gif', 'border' => 0))); ?>
			</td>
			<td colspan="2" align="center" style="background:#000;padding:10px 0 0;">
				<div id="sa_cart_sidebar_link">
					<?php
					// -----------------------------------------
					// --> CART Summary
					if (ENVIRONMENT === 'development' OR ENVIRONMENT === 'testing')
					{
						$link1 = 'sa/product_linesheet_summary';
						echo anchor($link1, (img(array('src'=>'images/item_icon.gif','border'=>0,'style'=>'vertical-align:middle')).nbs(2).'('.$this->cart->total_items().')'.nbs().'view items_'), 'style="color:white;"');
					}
					else
					{
						$link1 = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? site_url('sa/product_linesheet_summary') : str_replace('http','https',site_url('sa/product_linesheet_summary'));
						echo anchor($link1, (img(array('src'=>'images/item_icon.gif','border'=>0,'style'=>'vertical-align:middle')).nbs(2).'('.$this->cart->total_items().')'.nbs().'view items'), 'class="mm_last items"');
					}
					?>
				</div>
			</td>
		</tr>
		<?php
	}
	else
	{ ?>
		<tr>
			<td colspan="3" style="background:white;color:red;height:30px;">CLEARANCE CATEGORIES</td>
		</tr>
		<?php
	}
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar upper mid nav contents (form info)
	*/
	?>
	<tr>
		<td colspan="3" class="left" style="padding:12px 12px 5px 12px;">
				Logged in as: <?php echo ucfirst($this->session->userdata('admin_sales_user')); ?>
				<br /><br />
				Recipients Name<br />
				<input type="text" id="recipients_name" name="recipients_name" style="background-color:white;color:black;width:170px;height:22px;font-size:12px;padding:0 0 0 3px;border:1px solid gray;" onchange="remember_me('recipients_name')" value="<?php echo $this->session->userdata('recipients_name'); ?>" /><br />
				Recipients Email<br />
				<input type="text" id="recipients_email" name="email" style="background-color:white;color:black;width:170px;height:22px;font-size:12px;padding:0 0 0 3px;border:1px solid gray;" onchange="remember_me('recipients_email')" value="<?php echo $this->session->userdata('recipients_email'); ?>" /><br />
				Bcc Email<br />
				<input type="text" id="bcc_email" name="bcc_email" style="background-color:white;color:black;width:170px;height:22px;font-size:12px;padding:0 0 0 3px;border:1px solid gray;" onchange="remember_me('bcc_email')" value="<?php echo $this->session->userdata('bcc_email'); ?>" /><br />
				Comments Overall<br />
				<textarea id="comments_overall" name="comments_overall" rows="10" cols="5" style="background-color:white;color:black;width:170px;font-family:inherit;font-size:12px;padding:0 0 0 3px;border:1px solid gray;" onchange="remember_me('comments_overall')"><?php echo $this->session->userdata('comments_overall'); ?></textarea>
		</td>
	</tr>
	
	<?php
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar mid nav contents where categories and subcats are displayed
	*/
	?>
	<tr>
		<td colspan="3" class="left" style="padding: 5px 12px 12px 12px;">
			<?php
			if ($file != 'page')
			$this->load->view($this->config->slash_item('template').'sales/'.$left_nav);
			?>
		</td>
	</tr>
	<?php
	/*
	| --------------------------------------------------------------------------------------
	| ROW - Left sidebar bottom nav buttons
	*/
	?>
	<tr>
		<td colspan="3" class="left" style="padding: 5px 12px 12px 12px;">
			<?php
			if (isset($this->data['view_pane']) && ($this->data['view_pane'] == 'thumbs_list_subcategory_products' OR $this->data['view_pane'] == 'thumbs_list_search_by_style_no'))
			{ ?>
				<input type="submit" class="search_head submit" name="submit" value="CONTINUE >>" style="color:red;width:175px;text-align:center;cursor:pointer;" />
				<br />
				<br />
				<?php
			}
			elseif ($file == 'page')
			{ 
				if ($this->uri->segment(2) != 'sent' && $this->uri->segment(2) != 'clear_items')
				{ ?>
					<input type="submit" class="search_head submit" name="submit" value="SEND LINESHEET PACKAGE" style="color:red;width:175px;text-align:center;cursor:pointer;" />
					<br />
					<br />
					<input type="button" class="search_head submit" name="add_more_items" value="ADD MORE ITEMS" style="width:175px;text-align:center;cursor:pointer;" onclick="window.location.href='<?php echo site_url('sa/apparel'); ?>';" />
					<br />
					<br />
					<input type="button" class="search_head submit" name="clear_items" value="CLEAR ALL ITEMS" style="width:175px;text-align:center;cursor:pointer;" onclick="window.location.href='<?php echo site_url('sa/clear_items'); ?>';" />
					<br />
					<br />
					<?php
				}
			} ?>
			<input type="button" class="search_head submit" name="logout" value="LOG OUT" style="color:red;width:175px;text-align:center;font-weight:bold;cursor:pointer;" onclick="window.location.href='<?php echo site_url('sa/log_out'); ?>';" />
		</td>
	</tr>
</table>

<?php
if ($file == 'page')
{
	echo form_close();
	echo '<!--eof form==================================================================================-->';
}
