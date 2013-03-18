<?php
if ($this->uri->segment(2) == 'activate' OR $this->uri->segment(2) == 'authenticate')
{ ?>
	<table width="100%" cellspacing="2" cellpadding="2" border="0">
		<tr><td>ACTIVATION</a></td><tr>
	</table>
	<?php
}
else
{ ?>
	<table width="100%" cellspacing="2" cellpadding="2" border="0">
		<!--<tr><td><?php echo anchor('home/account','MY ACCOUNT'); ?></td></td></tr>-->
		<tr><td><?php echo anchor('wholesale/home','MY ORDERS'); ?></a></td><tr>
		<tr><td><?php echo anchor('cart','MY CART'); ?></a></td><tr>
		<tr><td><?php echo anchor('sign_out.html','LOG OUT'); ?></a></td><tr>
	</table>
	<?php
}