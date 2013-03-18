	<?php
	/*
	| ---------------------------------------------------------------------------------------------
	| Error and prompt messages
	*/
	if (isset($_SESSION['m']) && $_SESSION['m'] == 1)
		$msg = '<span class="error new_error"><-- This style number already exists.</span>';
	?>
	
	<h2 style="clear:both;"><?php echo MAIN_BODY_TITLE; ?></h1>
	
	<span style="color:red; font-size:12px; font-style: italic; text-align:center;">NOTE: FOLLOWING CHARACTERS ARE NOT ALLOWED COMMA(,) SEMI-COLONS (;) PIPES (|) CARETS (^) TILDE (~) AMPERSAND (&amp;)</span>
	
	<br /><br />

	<!--bof form============================================================================-->
	<form name="prod_frm" method="post" action="<?php echo FILE_NAME_EXT; ?>" enctype="multipart/form-data" onsubmit="return check_required_fields();">
	<table>
		<col width="200" />
		<col />
		
		<?php
		// -----------------------------------------
		// ---> Product Name
		?>
		<tr>
			<td class="common">
				<label class="form_label">Product name</label> :
			</td>
			<td class="common">
				<input type="text" id="prod_name" name="prod_name" class="inputbox" value="<? echo @$prod_name;?>" style="width: 300px;" />
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Style Number
		?>
		<tr>
			<td class="common">
				<label class="form_label">Style Number</label> :
			</td>
			<td class="common">
				<input type="text" id="prod_no" name="prod_no" class="inputbox" value="<?php echo isset($_SESSION['style_no']) ? $_SESSION['style_no'] : ''; ?>" />&nbsp; <?php echo isset($msg) ? $msg : ''; ?>
			</td>
		</tr>
		<tr><td><br /></td><td></td></tr>
		<?php
		// -----------------------------------------
		// ---> Publish at Instyle
		?>
		<tr>
			<td class="common">
				<label class="form_label">Publish at Storybook</label> :
			</td>
			<td class="common">
				<input type="radio" name="publish_at_instyle" value="Y" checked="checked" /> Yes 
				&nbsp; 
				<input type="radio" name="publish_at_instyle" value="N" /> No
				&nbsp;
				<span class="small_note">(Tick NO to unpublish. YES by default)</span>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Designer
		?>
		<tr>
			<td class="common">
				<label class="form_label">Designer</label> :
			</td>
			<td class="common">
				<select id="designer" name="designer">
					<option value=""></option>
					<?php
					if (mysql_num_rows($qry1) > 0)
					{
						while ($row1 = mysql_fetch_array($qry1))
						{ ?>
							<option value="<?php echo $row1['des_id']; ?>" <?php echo $row1['des_id'] == $p_row['designer'] ? 'selected' : ''; ?>><?php echo $row1['designer']; ?></option>
							<?php
						}
					} ?>
				</select>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Publish at Designer
		?>
		<tr>
			<td class="common">
				<label class="form_label">Publish at Cozychic</label> :
			</td>
			<td class="common">
				<input type="radio" name="publish_at_designer" value="Y" /> Yes 
				&nbsp; 
				<input type="radio" name="publish_at_designer" value="N" checked="checked" /> No
				&nbsp;
				<span class="small_note">(Tick YES to unpublish. NO by default)</span>
			</td>
		</tr>
		<tr>
			<td><br /></td>
			<td><input type="hidden" name="publish_at_designer" value="N" /></td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Category name
		?>
		<tr>
			<td class="common">
				<label class="form_label">Category name</label> :
			</td>
			<td class="common">
				<select id="cat" name="cat">
					<option value=""></option>
					<?php
					if (mysql_num_rows($qry2) > 0)
					{
						while ($row2 = mysql_fetch_array($qry2))
						{
							if ($row2['cat_id'] != '23')
							{ ?>
								<option value="<?php echo $row2['cat_id']; ?>" <?php echo $row2['cat_id'] == $p_row['cat_id'] ? 'selected' : ''; ?>><?php echo $row2['cat_name']; ?></option>
								<?php
							}
						}
					} ?>
				</select>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Subcategory name
		?>
		<tr>
			<td class="common">
				<label class="form_label">SubCategory name</label> :
			</td>
			<td class="common">
				<select id="subcat" name="subcat">
					<option value=""></option>
					<?php
					if (mysql_num_rows($qry3) > 0)
					{
						while ($row3 = mysql_fetch_array($qry3))
						{ ?> 
							<option value="<?php echo $row3['subcat_id']; ?>" <?php echo $row3['subcat_id'] == $p_row['subcat_id'] ? 'selected' : ''; ?>><?php echo $row3['subcat_name']; ?></option>
							<?php
						}
					} ?>
				</select>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Subsubcategory name
		?>
		<tr>
			<td class="common">
				<label class="form_label">SubSubCategory name</label> :
			</td>
			<td class="common">
				<select id="subsubcat" name="subsubcat">
					<option value=""></option>
					<?php
					if (mysql_num_rows($qry5) > 0)
					{
						while ($row5 = mysql_fetch_array($qry5))
						{ ?> 
							<option value="<?php echo $row5['id']; ?>" <?php echo $row5['id'] == $p_row['subsubcat_id'] ? 'selected' : ''; ?>><?php echo $row5['name']; ?></option>
							<?php
						}
					} ?>
				</select>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> New Arrival
		?>
		<tr>
			<td class="common">
				<label class="form_label">New Arrival</label> :
			</td>
			<td class="common">
				<input type="radio" name="new_arrival" value="yes" /> Yes &nbsp; <input type="radio" name="new_arrival" value="no" checked="checked" /> No
				&nbsp;
				<span class="small_note">(Tick YES for New Arrival. NO by default)</span>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Put Stock
		?>
		<tr>
			<td class="common">
				<label class="form_label">Put Stock</label> :
			</td>
			<td class="common">
				<input type="radio" name="put_stock" value="yes" checked="checked" /> Yes &nbsp; <input type="radio" name="put_stock" value="no" /> No
				&nbsp;
				<span class="small_note">(Tick NO to start with no stock. YES at 30 per size by default)</span>
			</td>
		</tr>
		<tr><td><br /></td><td></td></tr>
		<?php
		// -----------------------------------------
		// ---> Date
		?>
		<tr>
			<td class="common">
				<label class="form_label">Date</label> :
			</td>
			<td class="common">
				<input type="text" name="add_date" id="add_date" class="date-pick" value="<? echo @$add_date;?>" /><span class="text">&nbsp;(format:mm/dd/yyyy)</span>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Sale Price
		?>
		<tr>
			<td class="common">
				<label class="form_label">Our sale price</label> :
			</td>
			<td class="common">
				<input type="text" name="catalogue_price" class="inputbox" value="<? echo @$catalogue_price;?>" />
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Retail Price
		?>
		<tr>
			<td class="common">
				<label class="form_label">Retail price</label> :
			</td>
			<td class="common">
				<input type="text" name="less_discount" class="inputbox" value="<? echo @$less_discount;?>" />
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Primary Image Color
		?>
		<tr>
			<td class="common">
				<label class="form_label">Primary image color</label> :
			</td>
			<td class="common">
				<select id="primary_image_color_cs" name="cs" style="font-size:11px;">
					<option value=""> - select color - </option>
					<?php
					if (mysql_num_rows($qry4) > 0)
					{
						while ($row4 = mysql_fetch_array($qry4))
						{ ?>
							<option value="<?php echo $row4['color_name']; ?>-<?php echo $row4['color_code']; ?>"><?php echo $row4['color_name']; ?> - <?php echo $row4['color_code']; ?></option>
							<?php
						}
					} ?>
				</select>
				&nbsp;
				<span class="small_note" style="color:red;">(You must enter a primary product color)</span>
			</td>
		</tr>
		<?php
		// -----------------------------------------
		// ---> Description
		?>
		<tr>
			<td class="common">
				<label class="form_label">Description</label> :
			</td>
			<td class="common">
				<textarea name="prod_desc" rows="5" cols="40"><?php if(empty($row_)==true){ echo @$prod_desc; }else{ echo $row_['p_desc'];}?></textarea>
			</td>
		</tr>
	</table>
	<br />
	<?php
	// -----------------------------------------
	// ---> SUBMIT
	?>
	<input type="submit" name="submit" class="inputbox" value="Save product & upload picture" />
	
	</form>
	<!--eof form============================================================================-->
	
