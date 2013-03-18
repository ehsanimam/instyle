<?php
$p1_bold = uri_string() == 'p1/ordering.html' ? 'font-weight:bold' : 'font-weight:normal';
$p2_bold = uri_string() == 'p2/return_policy.html' ? 'font-weight:bold' : 'font-weight:normal';
$p3_bold = uri_string() == 'p3/shipping.html' ? 'font-weight:bold' : 'font-weight:normal';
$p4_bold = uri_string() == 'p4/privacy_notice.html' ? 'font-weight:bold' : 'font-weight:normal';
$p5_bold = uri_string() == 'p5/order_status.html' ? 'font-weight:bold' : 'font-weight:normal';
$p6_bold = uri_string() == 'p6/faq.html' ? 'font-weight:bold' : 'font-weight:normal';
$p7_bold = uri_string() == 'p7/wholesale_ordering.html' ? 'font-weight:bold' : 'font-weight:normal';
$p8_bold = uri_string() == 'p8/wholesale_return_policy.html' ? 'font-weight:bold' : 'font-weight:normal';
$p9_bold = uri_string() == 'p9/wholesale_shipping.html' ? 'font-weight:bold' : 'font-weight:normal';
$p10_bold = uri_string() == 'p10/wholesale_privacy_notice.html' ? 'font-weight:bold' : 'font-weight:normal';
$p11_bold = uri_string() == 'p11/wholesale_order_status.html' ? 'font-weight:bold' : 'font-weight:normal';
$p12_bold = uri_string() == 'p12/wholesale_faq.html' ? 'font-weight:bold' : 'font-weight:normal';

$press_bold = uri_string() == 'press.html' ? 'font-weight:bold' : 'font-weight:normal';
$sitemap_bold = uri_string() == 'sitemap.html' ? 'font-weight:bold' : 'font-weight:normal';
$register_bold = (uri_string() == 'register.html' OR uri_string() == 'wholesale/register.html') ? 'font-weight:bold' : 'font-weight:normal';
$contact_bold = uri_string() == 'contact.html' ? 'font-weight:bold' : 'font-weight:normal';

if (isset($page_title) && $page_title == 'sitemap')
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
		<tr><td style="padding: 5px 0;"><?php echo anchor('p7/wholesale_ordering.html','ORDERING',array('style'=>$p7_bold)); ?></td></td></tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('p8/wholesale_return_policy.html','RETURNS',array('style'=>$p8_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('p9/wholesale_shipping.html','SHPPING',array('style'=>$p9_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('p10/wholesale_privacy_notice.html','PRIVACY',array('style'=>$p10_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('p11/wholesale_order_status.html','ORDER STATUS',array('style'=>$p11_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('p12/wholesale_faq.html','FAQ',array('style'=>$p12_bold)); ?></a></td><tr>
		<?php
	}
	else
	{ ?>
		<tr><td style="padding: 5px 0;"><?php echo anchor('p1/ordering.html','ORDERING',array('style'=>$p1_bold)); ?></td></td></tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('p2/return_policy.html','RETURNS',array('style'=>$p2_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('p3/shipping.html','SHPPING',array('style'=>$p3_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('p4/privacy_notice.html','PRIVACY',array('style'=>$p4_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('p5/order_status.html','ORDER STATUS',array('style'=>$p5_bold)); ?></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('p6/faq.html','FAQ',array('style'=>$p6_bold)); ?></a></td><tr>
		<?php
	} ?>
		
		<tr><td style="padding: 5px 0;"><?php echo anchor('press.html','PRESS',array('style'=>$press_bold)); ?></a></td><tr>
		<tr><td style="padding: 5px 0;"><?php echo anchor('sitemap.html','SITEMAP',array('style'=>$sitemap_bold)); ?></a></td><tr>
		<?php if ($this->session->userdata('user_cat') != 'wholesale'): ?>
		<tr><td style="padding: 5px 0;"><?php echo anchor('register.html','REGISTER',array('style'=>$register_bold)); ?></a></td><tr>
		<?php endif; ?>
		<tr><td style="padding: 5px 0;"><?php echo anchor('contact.html','CONTACT',array('style'=>$contact_bold)); ?></a></td><tr>
	</table>
	<?php
}