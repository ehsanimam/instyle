<table border="0" cellspacing="0" cellpadding="0" width="975" style="margin:15px 0px;">
	<tr>
		<?php
		/*
		| --------------------------------------------------------------------------------------
		| Left sidebar
		*/
		?>
		<td width="200" style="background:#F0F0F0;">
			<?php $this->load->view($this->config->slash_item('template').'left_nav'); ?>
		</td>
		<?php
		/*
		| --------------------------------------------------------------------------------------
		| Right content area - spans two (2) rows
		*/
		?>
		<td rowspan="2" style="padding-left:5px;">
			<?php $this->load->view($product_list);	?>
		</td>
	</tr>
	<tr>
		<td style="background:#F0F0F0;padding:12px;vertical-align:bottom;">
			<form name="frmsubscribe" action="" method="post" onSubmit="javascript:return _check();">
				<table cellspacing="0" cellpadding="5" border="0">
					<tbody>
					<tr>
						<td class="normal_txt txt_page_gray2" align="left">BE IN THE KNOW</td>
					</tr>
					<tr>
						<td class="txtsize10">Register to receive product updates</td>
					</tr>
					<tr>
						<td class="normal_txt txtleft"><input type="text" name="email" style="width:150px;" value="Your Email" onclick="if (this.value=='Your Email'){this.value='';}"/></td>
					</tr>
					<tr>
						<td class="normal_txt txtleft"><input type="submit" class="search_head submit" name="subscribe" value="SUBMIT"/></td>
					</tr>
					</tbody>
				</table>
			</form>	
		</td>
	</tr>
</table>

