<!--
<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0;">
<tr>
	<td width="180" style="background:#f0f0f0; padding:5px 10px 3px 10px;">
		<?php //$this->load->view('page_left_menu'); ?>
	</td>
	<td>
		<div id="bodycontent">
-->
			<h3><?php echo strtoupper($page_title); ?></h3>
			<p>
			<?php
			if ($view == 'contact_form')
			{ ?>
				For all inquires please complete the form below and press submit. We will contact you within 24 hours Monday through Friday
				<hr>
				<?php echo form_open('contact/process_send'); ?>
				<?php echo $this->session->flashdata('flashMsg'); ?>
				
				<?php 
				/*
				| --------------------------------------------------------------------------------
				| Some snipets to help prevent spam bots from spamming the form
				| $the_spinner makes the fields of the form hashed and sorta randomized every second of the day
				| Used a honeypot to identify bot spammers
				*/
				$the_spinner = time().'#'.$this->session->userdata('ip_address').'#'.$this->config->item('site_domain').'#'.$this->config->item('a_secret_1');
				?>
				
				<table border="0" cellspacing="0" cellpadding="5">
					<input type="hidden" name="<?php echo md5('the_spinner'); ?>" value="<?php echo md5($the_spinner); ?>" />
					<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_time'); ?>" value="<?php echo time(); ?>" />
					
					<tr><td>Name *</td><td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_name'); ?>" /></td></tr>
					<tr><td>State / Province *</td><td>
						<select name="<?php echo md5(md5($the_spinner).'the_state'); ?>">
						<option value=""> - select state - </option>
						<?php
						
							$get_states = $this->query_page->get_states();
							if($get_states->num_rows()>0) {
								foreach($get_states->result() as $state) {
									?>
									<option value="<?php echo $state->state_name; ?>"><?php echo $state->state_name; ?></option>
									<?php
								}
							}
						
						?>
						</select>
					</td></tr>
					<tr><td>Country *</td><td>
						<select name="<?php echo md5(md5($the_spinner).'the_country'); ?>">
						<option value=""> - select country - </option>
						<?php
						
							$get_country = $this->query_page->get_country();
							if($get_country->num_rows()>0) {
								foreach($get_country->result() as $country) {
									?>
									<option value="<?php echo $country->countries_name; ?>"><?php echo $country->countries_name; ?></option>
									<?php
								}
							}
						
						?>
						</select>
					</td></tr>
					<tr><td>Telephone:</td><td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_telephone'); ?>" /></td></tr>
					<tr><td>Email *</td><td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_email'); ?>" /></td></tr>
					<tr><td>Questions/Comments </td><td><textarea name="<?php echo md5(md5($the_spinner).'the_comment'); ?>" style="width:300px;height:150px;"></textarea></td></tr>
					<tr><td>&nbsp;</td><td>
									Would you like to receive product updates from <?php echo $this->config->item('site_name'); ?> by Email? <br>
									<input type="radio" name="<?php echo md5(md5($the_spinner).'the_recieveupdate'); ?>" value="1" checked="yes"> Yes &nbsp;
									<input type="radio" name="<?php echo md5(md5($the_spinner).'the_recieveupdate'); ?>" value="0"> No 
								</td></tr>
					<tr><td>&nbsp;</td><td><input type="submit" value="Submit" name="<?php echo md5(md5($the_spinner).'btnsubmit'); ?>" /></td></tr>		
				</table>
				
				<div style="display:none;">
					<input type="email" name="<?php echo md5(md5($the_spinner).'the_honeypot'); ?>" value="" />
				</div>
				
				<?php echo form_close();
			}
			else
			{ ?>
				Thank you for contacting us. You will be hearing from us within 24 hours to better assist you.
				<?php
			} ?>
			</p>
<!--
		</div>
	</td>
</tr>
</table>

-->