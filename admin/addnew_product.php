<?php
	include("../common.php");
	include('../functionsadmin.php');

	$GLOBALS['message']='';
	
	if(@$subcat=='')
	{
		$subcat=0;
	}
	if(@$subcat_manu=='')
	{
		$subcat_manu=0;
	}
	if(@$subcat_trend=='')
	{
		$subcat_trend=0;
	}
	if(@$trend=='')
	{
		$trend=0;
	}

	if (@$act == "add")
	{
		$exploded_cs = explode('-',$_POST['cs']);
		$primary_img_id = $exploded_cs[1]; // ---> code
		$colors = $exploded_cs[0]; // ---> name

		$check_prodid = mysql_query("select prod_no from tbl_product where prod_no='".$prod_no."'") or die(mysql_error());
		$num_prod = mysql_num_rows($check_prodid);

		if ($num_prod == 0)
		{
			if (empty($_POST['cat']) || empty($_POST['subcat']) || empty($_POST['designer']))
			{
				//echo 'Check Catalog,Subcatalog & Designer Feilds';
				$msg_err=13;
				$prod_return=1;
			}
			else if (empty($_POST['cs']))
			{
				$msg_err=14;
				$prod_return=1;
			}
			else
			{
				if ($add_date == '') $add_date = @date('m/d/Y',time());
				$prod_return = admin_addnew_product(
					$prod_name, 
					$prod_no, 
					$_POST['cat'], 
					$_POST['subcat'], 
					$subsubcat, 
					$_POST['new_arrival'], 
					$add_date, 
					$catalogue_price, 
					$less_discount, 
					$prod_desc, 
					$_POST['designer'], 
					$primary_img_id,
					$colors
				);
				$prod_id = mysql_insert_id();
			}
			
			if ($prod_return == 0)
			{
				$GLOBALS['message']=$GLOBALS['message']."Add new product complete"."<br>";	
				echo "
					<script type=\"text/javascript\">
						<!--
						window.location = \"edit_new_par_product.php?act=show&prod_no=".$prod_no."&mode=e\"
						//-->
					</script>
				";	
			}
		}
		else
		{
			$msg_err=1;
		}	
	}
	
	include 'top.php'; 
?>
<title><?php echo SITE_URL; ?> :: Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
	function submit_form()
	{
		document.prod_frm.method="post";
		document.prod_frm.action="addnew_product.php";
		document.prod_frm.submit();
		
	}
	function check_color()
	{
		if (document.getElementById('primary_image_color_cs').value == ' - select color - ' || document.getElementById('primary_image_color_cs').value == '')
		{
			alert('Please enter primary image color.');
			return false;
		}
	}
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#submit').click(function() {
			$('#loading').show();
		});
	});
</script>
<script>
	function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
	}
	function getCs(strURL)
	{
		var req = getXMLHTTP();
		if (req)
		{
			req.onreadystatechange = function()
			{
				if (req.readyState == 4)
				{
					// only if "OK"
					if (req.status == 200)
					{
						document.getElementById('csdiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
	}
</script>
<link type="text/css" href="js/datePicker.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.dataPicker.js"></script>
<script type="text/javascript" src="js/date.js"></script>
<script type="text/javascript">
	$(function()
	{
		$('.date-pick').datePicker()
		$('#add_date').bind(
			'dpClosed',
			function(e, selectedDates)
			{
				var d = selectedDates[0];
				if (d) {
					d = new Date(d);
					//$('#add_date').dpSetStartDate(d.addDays(1).asString());
				}
			}
		);
	});
</script>
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td height="620" class="tab" valign="top" align="center">
	
	<!--bof form============================================================================-->
	<form name="prod_frm" method="post" action="addnew_product.php?act=add" enctype="multipart/form-data" onsubmit="return check_color();">
	<table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
	<tr><td align="left">
		<table width=100% align=center cellspacing=2 cellpadding=2>
			<!--DWLayoutTable-->
			<tr bgcolor=cccccc>
				<td align=center colspan=2><h1>ADD Product</h1></td>
			</tr>
			
				<?php
				/*
				| ---------------------------------------------------------------------------------------------
				| Error and prompt messages
				*/
				if(isset($msg_err) && $msg_err==1){?>
				<tr>
					<td align=center colspan=2 class="error">This style number already exists.</td>
				</tr>
				<?php } ?>
				<?php if(isset($msg_err) && $msg_err==13){?>
				<tr>
					<td align=center colspan=2 class="error">Pls Check Catalog,Subcatalog and Designer Entries.</td>
				</tr>
				<?php } ?>
				<?php if(isset($msg_err) && $msg_err==14){?>
				<tr>
					<td align=center colspan=2 class="error">Pls Check Primary Image Color Entry.</td>
				</tr>
				<?php } ?>
				<tr>
					<td align=center colspan=2 class="error"><? echo @$GLOBALS["message"]?></td>
				</tr>
			
            <tr>
            	<td colspan="2" style="color:red; font-size:12px; text-align:center;"> NOTE: FOLLOWING CHARACTERS ARE NOT ALLOWED COMMA(,) SEMI-COLONS (;) PIPES (|) CARETS (^) TILDE (~) AMPERSAND (&amp;)</td>
            </tr>
			<tr> 
				<td class="text" align="right">Product name : </td>
				<td>
					<input type="text" name="prod_name" class="inputbox" value="<? echo @$prod_name;?>">
				</td>
			</tr>
			<tr> 
				<td class="text" align="right">Style Number : </td>
				<td>
					<input type="text" name="prod_no" class="inputbox" value="<? echo @$prod_no;?>">
				</td>
			</tr>
			<tr> 
				<td width="310" class="text" align="right">Category name : </td>
				<td width="470"> 
                    <select name="cat">
						<option value=""></option>
						<?php
						$sq = "select * from tblcat";
						$get_category = @mysql_query($sq);
						if (mysql_num_rows($get_category) > 0)
						{
							while ($row = mysql_fetch_array($get_category))
							{
								if ($row['cat_id'] != '23')
								{ ?>
									<option value="<?=$row['cat_id']?>" <?php echo $row['cat_id']==$p_row['cat_id'] ? 'selected' : ''; ?>><?=$row['cat_name']?></option>
									<?php
								}
							}
						} ?>
					</select>
				</td>
			</tr>
			<tr> 
				<td class="text" align="right">SubCategory name : </td>
				<td> 
					<select name="subcat">
						<option value=""></option>
						<?php
						$sq = "select * from tblsubcat order by subcat_name asc";
						$get_subcategory = @mysql_query($sq);
						if (mysql_num_rows($get_subcategory) > 0)
						{
							while ($rowx1 = mysql_fetch_array($get_subcategory))
							{ ?> 
								<option value="<?=$rowx1['subcat_id']?>" <?php echo $rowx1['subcat_id']==$p_row['subcat_id'] ? 'selected' : ''; ?>><?=$rowx1['subcat_name']?></option>
								<?php
							}
						} ?>
					</select>
				</td>
			</tr>
			<tr> 
				<td class="text" align="right"> Sub SubCategory name : </td>
				<td> 
                    <? @get_subsubcategories($subcat);?>
                    <script>document.prod_frm.subsubcat.value="<?=$subsubcat;?>"</script>
				</td>
			</tr>
			<tr> 
				<td class="text" align="right">Designer : </td>
				<td> 
					<select name="designer">
						<option value=""></option>
						<?php
						$get_designer = @mysql_query("select * from designer");
						if (mysql_num_rows($get_designer) > 0)
						{
							while ($row = mysql_fetch_array($get_designer))
							{ ?>
								<option value="<?=$row['des_id']?>" <?php echo $row['des_id']==$p_row['designer'] ? 'selected' : ''; ?>><?=$row['designer']?></option>
								<?php
							}
						} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="text" align="right">New Arrival?:</td>
				<td align="left" class="text">
				  	<input type="radio" name="new_arrival" value="yes" /> Yes &nbsp; 
				  	<input type="radio" name="new_arrival" value="no" /> No
				</td>
			</tr>
			<tr> 
				<td class="text" align="right">Date : </td>
				<td align="left">
					<input type="text" name="add_date" id="add_date" class="date-pick" value="<? echo @$add_date;?>" /><span class="text">&nbsp;(format:mm/dd/yyyy)</span>
				</td>
			</tr>
			<tr> 
				<td class="text" align="right">Our sale price : </td>
				<td>
					<input type="text" name="catalogue_price" class="inputbox" value="<? echo @$catalogue_price;?>">
				</td>
			</tr>
			<tr> 
				<td class="text" align="right">Retail price  : </td>
				<td>
					<input type="text" name="less_discount" class="inputbox" value="<? echo @$less_discount;?>">
				</td>
			</tr>
			<!--<tr> 
				<td class="text" align="right">Shipping Cost : </td>
				<td><input type="text" name="shipping_cost" class="inputbox" value="<? echo @$shipping_cost;?>"></td>
			</tr>-->
			<tr> 
				<td class="text" align="right">Primary image color : </td>
				<td align="left" class="text">
					<select id="primary_image_color_cs" name="cs" style="font-size:11px;">
						<option value=""> - select color - </option>
						<?php
						$cs1 = mysql_query("select * from tblcolor order by color_name asc") or die(mysql_error());
						while ($cs_row1 = mysql_fetch_array($cs1))
						{ ?>
							<option value="<?=$cs_row1['color_name']?>-<?=$cs_row1['color_code']?>"><?=$cs_row1['color_name']?> - <?=$cs_row1['color_code']?></option>
							<?
						} ?>
					</select> 
				</td>
			</tr>
			<tr>
				<td class="text" align="right">Description : </td>
				<td>
					<textarea name="prod_desc" rows="5" cols="40"><?php if(empty($row_)==true){ echo @$prod_desc; }else{ echo $row_['p_desc'];}?></textarea>
				</td>
			</tr>
			<tr> 
				<td colspan=2 align=center> <input type="submit" name="cmd_cat_submit" class="inputbox" value="Save product & upload picture" /></td>
			</tr>
		</table>
	</td></tr>
	</table>
	</form>
	<!--eof form============================================================================-->
	
</td></tr>
</table>
<? include 'footer.php'; ?>
