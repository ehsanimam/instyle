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
				
			<tr><td style="height:25px;">Name *</td>
				<td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_name'); ?>" /></td>
			</tr>
            <tr><td style="width:200px;height:25px;">E-mail Address *</td>
				<td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_email'); ?>" /></td>
			</tr>	
			<tr><td style="height:25px;">Dress Size</td>
				<td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_size'); ?>" /></td>
			</tr>
			<tr><td style="height:25px;">State/Province</td>
				<td><input type="text" value="" class="inputbox" name="<?php echo md5(md5($the_spinner).'the_state'); ?>" /></td>
			</tr>
				
			<tr><td>&nbsp;</td><td>
				<input type="submit" value="Submit" name="<?php echo md5(md5($the_spinner).'submit'); ?>" /></td>
			</tr>
            <tr>
                <td>&nbsp;</td>
                <td><p> <?php echo $this->config->item('site_name'); ?>  respects your privacy and does not share e-mail addresses with third parties.</p></td></tr>
			</table><br>
			
			<div style="display:none;">
					<input type="email" name="<?php echo md5(md5($the_spinner).'the_honeypot'); ?>" value="" />
			</div>
			