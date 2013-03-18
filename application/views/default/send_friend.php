<script>
	// This function reload page after 3mins (anti spam feature working with server side script too)
	// variable t declared globally at beginning
	function set_timer()
	{
		t = setTimeout("alert_msg()",180000);
	}
	function alert_msg()
	{
		alert('Your time has ran out.' + "\n" + 'Reloading page');
		window.location.reload();
	}
</script>

<div class="sendfriendphoto">
<?php
/*
| --------------------------------------------------------------------------------
| Some snipets to help prevent spam bots from spamming the form
| $the_spinner makes the fields of the form hashed and sorta randomized every second of the day
| Used a honeypot to identify bot spammers
			*/
$the_spinner = time().'#'.$this->session->userdata('ip_address').'#'.$this->config->item('site_domain').'#'.$this->config->item('a_secret_1');
			
	echo form_open('send/index',array('name'=>'frmsend')); 
?>
	<input type="hidden" name="<?php echo md5('the_spinner'); ?>" value="<?php echo md5($the_spinner); ?>" />
	<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_time'); ?>" value="<?php echo time(); ?>" />
				
	<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_image'); ?>" value="<?php echo $image; ?>" />
	<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_prod_no'); ?>" value="<?php echo $prod_no; ?>" />
	<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_backurl'); ?>" value="<?php echo current_url(); ?>" />
	<input type="hidden" name="<?php echo md5(md5($the_spinner).'the_des_url'); ?>" value="<?php echo $des_url; ?>" />
	<table width="100%" cellpadding="2" cellspacing="2" align="center">
	<tr>
		<td  class="ntxt">From :</td>
		<td ><input type="text" name="<?php echo md5(md5($the_spinner).'the_from'); ?>" id="<?php echo md5(md5($the_spinner).'the_from'); ?>" class="inputbox2" id="email1"/><span class="ntxt">(note: please enter your email address)</span></td>
	</tr>
	<tr>
		<td  class="ntxt">To :</td>
		<td ><input type="text" name="<?php echo md5(md5($the_spinner).'the_to'); ?>" id="<?php echo md5(md5($the_spinner).'the_to'); ?>" class="inputbox2" id="email" />  <span class="ntxt">(note: please enter your friend's email address)</span></td>
	</tr>
	<tr>
		<td valign="top" class="ntxt">Comments:</td>
		<td><textarea name="<?php echo md5(md5($the_spinner).'the_comment'); ?>" id="<?php echo md5(md5($the_spinner).'the_comment'); ?>" cols="50" rows="5" class="inputbox2" style=" padding:0px;" ></textarea>    </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" value="Send" name="<?php echo md5(md5($the_spinner).'the_send'); ?>" class="bottonlook2"/></td>
	</tr>
</table>
<div style="display:none;">
	<input type="email" name="<?php echo md5(md5($the_spinner).'the_honeypot'); ?>" value="" />
</div>
<?php echo form_close(); ?>
<br />
</div>