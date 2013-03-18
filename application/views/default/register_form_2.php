<?php 

			/*
			| --------------------------------------------------------------------------------
			| Some snipets to help prevent spam bots from spamming the form
			| $the_spinner makes the fields of the form hashed and sorta randomized every second of the day
			| Used a honeypot to identify bot spammers
			*/
			$the_spinner = time().'#'.$this->session->userdata('ip_address').'#'.$this->config->item('site_domain').'#'.$this->config->item('a_secret_1');

?>

<br />
			<table border="0" cellspacing="0" cellpadding="0">
				<input type="hidden" name="<?php echo md5('the_spinner'); ?>" value="<?php echo md5($the_spinner); ?>" />
				<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_time'); ?>" value="<?php echo time(); ?>" />
				
				<tr><td style="width:200px;height:25px;">E-mail Address *</td>
					<td><input type="text" value="<?php echo set_value('email'); ?>" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_email'); ?>" /></td>
				</tr>
				<tr><td style="height:25px;"></td>
					<td></td>
				</tr>
				<tr><td style="height:25px;">First Name *</td>
					<td><input type="text" value="<?php echo set_value('firstname'); ?>" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_firstname'); ?>" /></td>
				</tr>
				<tr><td style="height:25px;">Last Name *</td>
					<td><input type="text" value="<?php echo set_value('lastname'); ?>" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_lastname'); ?>" /></td>
				</tr>
				<tr><td style="height:25px;">Best Contact Telephone Or Cell *</td>
					<td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_telephone'); ?>" /></td>
				</tr>
				<tr><td style="height:25px;">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr><td style="height:25px;">Ship To Address 1 *</td>
					<td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_address1'); ?>" /></td>
				</tr>
				<tr><td style="height:25px;">Address 2</td>
					<td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_address2'); ?>" /></td>
				</tr>
				<tr><td style="height:25px;">Country *</td>
					<td>
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
					</td>
				</tr>
				<tr><td style="height:25px;">State/Province *</td>
					<td>
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
					</td>
				</tr>
				<tr><td style="height:25px;">City *</td>
					<td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_city'); ?>" /></td>
				</tr>
				<tr><td style="height:25px;">Postal/Zip Code *</td>
					<td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_zipcode'); ?>" /></td>
				</tr>
				<tr><td style="height:40px;">How did you hear about us?</td>
					<td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_howhearabout'); ?>" /></td>
				</tr>
				<tr><td style="height:40px;">Add me to newsletter for rewards?</td>
					<td><input type="radio" value="1" name="<?php echo md5(md5($the_spinner).'the_receive_productupd'); ?>" checked="yes" />Yes &nbsp; 
						<input type="radio" value="0" name="<?php echo md5(md5($the_spinner).'the_receive_productupd'); ?>" />No</td>
				</tr>
				<tr><td>&nbsp;</td><td><input type="submit" value="Submit" name="<?php echo md5(md5($the_spinner).'submit'); ?>" /></td>
				</tr>
			</table><br>
			<?php echo $this->config->item('site_name'); ?> respects your privacy and does not share e-mail addresses with third parties.
			<br><br>
			<div style="display:none;">
					<input type="email" name="<?php echo md5(md5($the_spinner).'the_honeypot'); ?>" value="" />
			</div>
			