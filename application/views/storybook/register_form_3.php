<br />
			<table border="0" cellspacing="0" cellpadding="0">
				<tr><td style="width:200px;height:25px;">E-mail Address *</td>
					<td><input type="text" value="<?php echo set_value('email'); ?>" class="inputbox" name="email" /></td>
				</tr>
				<tr><td style="width:200px;height:25px;">Password *</td>
					<td><input type="password" value="" class="inputbox" name="pword" /></td>
				</tr>
				<tr><td style="height:25px;">Company / Store *</td>
					<td><input type="text" value="<?php echo set_value('store_name'); ?>" class="inputbox" name="store_name" /></td>
				</tr>
				<tr><td style="height:25px;">First Name *</td>
					<td><input type="text" value="<?php echo set_value('firstname'); ?>" class="inputbox" name="firstname" /></td>
				</tr>
				<tr><td style="height:25px;">Last Name *</td>
					<td><input type="text" value="<?php echo set_value('lastname'); ?>" class="inputbox" name="lastname" /></td>
				</tr>
				<tr><td style="height:25px;">Federal Tax ID</td>
					<td><input type="text" value="<?php echo set_value('fed_tax_id'); ?>" class="inputbox" name="fed_tax_id" /></td>
				</tr>
				<tr><td style="height:25px;">Address 1 *</td>
					<td><input type="text" value="<?php echo set_value('address1'); ?>" class="inputbox" name="address1" /></td>
				</tr>
				<tr><td style="height:25px;">Address 2</td>
					<td><input type="text" value="<?php echo set_value('address2'); ?>" class="inputbox" name="address2" /></td>
				</tr>
				<tr><td style="height:25px;">City *</td>
					<td><input type="text" value="<?php echo set_value('city'); ?>" class="inputbox" name="city" /></td>
				</tr>
				<tr><td style="height:25px;">Country *</td>
					<td>
					<select name="country">
					<option value=""> - select country - </option>
						<?php
						$get_country = $this->query_page->get_country();
						if($get_country->num_rows()>0) {
							foreach($get_country->result() as $country) {
								?>
								<option value="<?php echo $country->countries_name; ?>" <?php echo set_select('country',$country->countries_name); ?>><?php echo $country->countries_name; ?></option>
								<?php
							}
						}
						?>
					</select>
					</td>
				</tr>
				<tr><td style="height:25px;">State/Province *</td>
					<td>
					<select name="state">
					<option value=""> - select state - </option>
						<?php
						$get_states = $this->query_page->get_states();
						if($get_states->num_rows()>0) {
							foreach($get_states->result() as $state) {
								?>
								<option value="<?php echo $state->state_name; ?>" <?php echo set_select('state',$state->state_name); ?>><?php echo $state->state_name; ?></option>
								<?php
							}
						}
						?>
					</select>
					</td>
				</tr>
				<tr><td style="height:25px;">Zip *</td>
					<td><input type="text" value="<?php echo set_value('zipcode'); ?>" class="inputbox" name="zipcode" /></td>
				</tr>
				<tr><td style="height:25px;">Telephone *</td>
					<td><input type="text" value="<?php echo set_value('telephone'); ?>" class="inputbox" name="telephone" /></td>
				</tr>
				<tr><td style="height:25px;">Fax</td>
					<td><input type="text" value="<?php echo set_value('fax'); ?>" class="inputbox" name="fax" /></td>
				</tr>
				<!--
				<tr><td style="height:40px;">How did you hear about us?</td>
					<td><input type="text" value="" class="inputbox" name="howhearabout" /></td>
				</tr>
				<tr><td style="height:40px;">Add me to newsletter for rewards?</td>
					<td><input type="radio" value="1" name="receive_productupd" checked />Yes &nbsp; 
						<input type="radio" value="0" name="receive_productupd" />No</td>
				</tr>
				-->
				<tr><td>&nbsp;</td><td><input type="submit" value="Submit" name="btnSubmit" /></td>
				</tr>
			</table><br>
			<?php echo $this->config->item('site_name'); ?> respects your privacy and does not share e-mail addresses with third parties.
			<br><br>