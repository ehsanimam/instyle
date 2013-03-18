<?php
	$get_page_1 = $this->db->get_where('pages',array('title_code'=>'wholesale_return_policy'));
	$row1 = $get_page_1->row();
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin:15px 0;">
<tr>
	<td>
	<div>
	<h3><?php echo strtoupper($row1->title); ?></h3>
	<p><?php echo $row1->text; ?></p>
	</div>
	</td>
</tr>
</table>
