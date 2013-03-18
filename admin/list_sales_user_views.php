<h2><?php echo MAIN_BODY_TITLE.' &nbsp; &nbsp; '; ?></h2>

<div id="content_wrapper">

	<div id="content2" class="content">
		
		<!--Top Tabs-->
		
		<!--bof form============================================================================-->
		<form name="menu_tab_frm" method="post" action="">

		<ul class="view_tabs">
			<?php
			if ($l === 'inact')
			{
				$select_inactive_list = 'class="selected"';
				$select_active_list = '';
				$text1 = 'Show Active Users';
				$text2 = 'Inactive Users';
			}
			else
			{
				$select_inactive_list = '';
				$select_active_list = 'class="selected"';
				$text1 = 'Active Users List';
				$text2 = 'Show Inactive Users';
			}
			?>
			<li <?php echo $select_active_list; ?>><a href="list_sales_user.php" onclick=""><?php echo $text1; ?></a></li>
			<li <?php echo $select_inactive_list; ?>><a href="list_sales_user.php?sel=inact" onclick=""><?php echo $text2; ?></a></li>
			<li><a href="add_sales_user.php" onclick="">Add New User</a></li>
		</ul>
		
		</form>
		<!--eof form============================================================================-->
		
		<!--Middle Table-->
		
		<!--bof form============================================================================-->
		<form name="prod_list_disp_frm" method="post" action="list_products.php?sel=<?php echo $sel; ?><?php echo isset($_GET['p']) ? '&p='.$_GET['p'] : ''; ?>">

			<input type="hidden" name="des_id" value="<?php echo $des_id; ?>" />
			<input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>" />
			<input type="hidden" name="subcat_id" value="<?php echo $subcat_id; ?>" />
			
			<br /><br />
			
			<div class="common" style="float:left;"><?php echo $user_count; ?> users total</div>
			<div class="common" style="float:right;">Number of entries per page: <?php echo $user_count < $limit ? 'All' : $user_count; ?></a></div>
			<div class="common" style="text-align:center;">
				<?php echo $pagination; ?>
			</div>
			<div style="clear:both;"></div>
			
			<table width="100%" border="0" cellspacing="2" cellpadding="0" style="margin: 10px 0;">
				<col width="50" />
				<col width="175" />
				<col width="75" />
				<col />
				<col width="75" />
				<tr bgcolor="#CCCCCC" height="30">
					<?php
					// -----------------------------------------
					// ---> Headings
					?>
					<td align="center"></td>
					<td align="center"><h1>User</h1></td>
					<td align="center"><h1>User Code</h1></td>
					<td align="center"><h1>Email Address</h1></td>
					<td align="center"><h1>Actions</h1></td>
				</tr>
				
				<?php
				$counter = 0;
				if (mysql_num_rows($qry1) > 0)
				{
					while ($user_row = mysql_fetch_array($qry1))
					{
						$counter++; ?>
					<tr bgcolor="#eeeeee" onMouseOver="this.bgColor='#cccccc'" onMouseOut="this.bgColor='#eeeeee'" class="text">
					
						<!--1 Item Counter-->
						<td align="left" class="reg_cell"><?php echo $counter; ?></td>
					
						<!--2 User-->
						<td align="left" class="reg_cell">
							<?php echo ucfirst($user_row['admin_sales_user']).' '.ucfirst($user_row['admin_sales_lname']); ?>
						</td>
					
						<!--3 Sales User Code-->
						<td align="center" class="reg_cell"><?php echo $user_row['admin_sales_code']; ?></td>
					
						<!--4 Email Address-->
						<td align="left" class="reg_cell"><?php echo $user_row['admin_sales_email']; ?></td>
					
						<!--5 Actions-->
						<td align="center" class="reg_cell">
							<!--
							<span class="text">[</span><a href="edit_sales_user.php?ee=<? echo md5($user_row['admin_sales_email']); ?>" class="pagelinks">Edit</a><span class="text">]</span>
							<span class="text">[</span><a href="javascript:void();" class="pagelinks" onclick="cfm_deactivate('<? echo md5($user_row['admin_sales_email']); ?>')">Deactivate</a><span class="text">]</span>
							<span class="text">[</span><a href="javascript:void();" class="pagelinks" onclick="cfm_delete('<? echo md5($user_row['admin_sales_email']); ?>')">Del</a><span class="text">]</span>
							-->
							<a href="edit_sales_user.php?ee=<? echo md5($user_row['admin_sales_email']); ?>"><img src="<?php echo SITE_URL; ?>images/btn_edit_20.png" alt="Edit" title="Edit User" name="Edit User" height="15" /></a>
							<img src="<?php echo SITE_URL; ?>images/btn_remove_20.png" alt="Deactive" title="Deactivate User" name="Deactivate User" height="15" onclick="cfm_deactivate('<? echo md5($user_row['admin_sales_email']); ?>')" style="cursor:pointer;" />
							<img src="<?php echo SITE_URL; ?>images/btn_del_20.png" alt="Delete" title="Delete User" name="Delete User" height="15" onclick="cfm_delete('<? echo md5($user_row['admin_sales_email']); ?>')" style="cursor:pointer;" />
						</td>
						
					</tr>
						<?php
					}
				}
				else
				{ ?>
					<tr bgcolor="#eeeeee" onMouseOver="this.bgColor='#cccccc'" onMouseOut="this.bgColor='#eeeeee'" class="text">
						<td colspan="5" align="center" class="reg_cell"><span style="color:red;">No records.</span></td>
					</tr>
					<?php
				}
				
				// free up mysql memory
				mysql_free_result($qry1);
				?>
				
			</table>
			
			<div class="common" style="float:left;"><?php echo $user_count; ?> users total</div>
			<div class="common" style="float:right;">Number of entries per page: <?php echo $user_count < $limit ? 'All' : $user_count; ?></a></div>
			<div class="common" style="text-align:center;">
				<?php echo $pagination; ?>
			</div>
			<div style="clear:both;"></div>
			
		</form>
		<!--eof form============================================================================-->
		
	</div>
	
</div> <!-- #content_wrapper -->

