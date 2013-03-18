<?php
$p1_bold = uri_string() == 'ordering' ? 'font-weight:bold' : 'font-weight:normal';
$p2_bold = uri_string() == 'return_policy' ? 'font-weight:bold' : 'font-weight:normal';
$p3_bold = uri_string() == 'shipping' ? 'font-weight:bold' : 'font-weight:normal';
$p4_bold = uri_string() == 'privacy_notice' ? 'font-weight:bold' : 'font-weight:normal';
$p5_bold = uri_string() == 'order_status' ? 'font-weight:bold' : 'font-weight:normal';
$p6_bold = uri_string() == 'faq' ? 'font-weight:bold' : 'font-weight:normal';
$p7_bold = uri_string() == 'wholesale_ordering' ? 'font-weight:bold' : 'font-weight:normal';
$p8_bold = uri_string() == 'wholesale_return_policy' ? 'font-weight:bold' : 'font-weight:normal';
$p9_bold = uri_string() == 'wholesale_shipping' ? 'font-weight:bold' : 'font-weight:normal';
$p10_bold = uri_string() == 'wholesale_privacy_notice' ? 'font-weight:bold' : 'font-weight:normal';
$p11_bold = uri_string() == 'wholesale_order_status' ? 'font-weight:bold' : 'font-weight:normal';
$p12_bold = uri_string() == 'wholesale_faq' ? 'font-weight:bold' : 'font-weight:normal';

$press_bold = uri_string() == 'press' ? 'font-weight:bold' : 'font-weight:normal';
$sitemap_bold = uri_string() == 'sitemap' ? 'font-weight:bold' : 'font-weight:normal';
$register_bold = (uri_string() == 'register' OR uri_string() == 'wholesale/register.html') ? 'font-weight:bold' : 'font-weight:normal';
$contact_bold = uri_string() == 'contact' ? 'font-weight:bold' : 'font-weight:normal';

if ($page_title == 'sitemap')
{ ?>
	<div style="height: 55px;">
		&nbsp;
	</div>
	<div style="height: 160px;padding: 18px 0 12px 0;text-align: right;" class="normal_txt2">
		By Categories
	</div>
	<div style="height: 320px;padding: 18px 0 12px 0;text-align: right;" class="normal_txt2">
		By Designer
	</div>
	<div style="height: 60px;padding: 18px 0 15px 0;text-align: right;" class="normal_txt2">
		Other Pages
	</div>
	<?php
}
else
{ ?>
	<table width="100%" cellspacing="2" cellpadding="2" border="0">
	<?php
	if ($this->session->userdata('user_cat') == 'wholesale')
	{ ?>
		<tr><td style="padding: 5px 0;"><?php echo anchor('wholesale_ordering','ORDERING',array('style'=>$p7_bold)); ?></td></td></tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('wholesale_return_policy','RETURNS',array('style'=>$p8_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('wholesale_shipping','SHPPING',array('style'=>$p9_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('wholesale_privacy_notice','PRIVACY',array('style'=>$p10_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('wholesale_order_status','ORDER STATUS',array('style'=>$p11_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('wholesale_faq','FAQ',array('style'=>$p12_bold)); ?></a></td><tr>
		<?php
	}
	else
	{ ?>
		<tr><td style="padding: 5px 0;"><?php echo anchor('ordering','ORDERING',array('style'=>$p1_bold)); ?></td></td></tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('return_policy','RETURNS',array('style'=>$p2_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('shipping','SHPPING',array('style'=>$p3_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('privacy_notice','PRIVACY',array('style'=>$p4_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('order_status','ORDER STATUS',array('style'=>$p5_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('faq','FAQ',array('style'=>$p6_bold)); ?></a></td><tr>
		<?php
	} ?>
		
		<tr><td style="padding: 5px 0;"><?php echo anchor('press','PRESS',array('style'=>$press_bold)); ?></a></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('sitemap','SITEMAP',array('style'=>$sitemap_bold)); ?></a></td><tr>
		<?php if ($this->session->userdata('user_cat') != 'wholesale'): ?>
		<tr><td style="padding: 5px 0;"><?php echo anchor('register','REGISTER',array('style'=>$register_bold)); ?></a></td><tr>
		<?php endif; ?>
		<tr><td style="padding: 5px 0;"><?php echo anchor('contact','CONTACT',array('style'=>$contact_bold)); ?></a></td><tr>
	</table>
	<?php
}