<?php
	include("../common.php");
	include('../functionsadmin.php');

	$uri_cat_id = $_GET['cat_id'];
	$uri_des_id = isset($_GET['des_id']) ? $_GET['des_id'] : '';
	$uri_subcat_id = $_GET['subcat_id'];

	/*
	| -----------------------------------------------------------------------------------------
	| Query designer & tblsubcat to get the proper word used on csv filename
	*/
	$des_select = "SELECT * FROM designer WHERE des_id = '".$uri_des_id."'";
	$des_result = mysql_query($des_select) or dei ('Select Designer error: '.mysql_error());
	$des_record = mysql_fetch_array($des_result);
	$file_part_des = str_replace(array('_','-'),array('','',),$des_record['folder']);
	
	$subcat_select = "SELECT * FROM tblsubcat WHERE subcat_id = '".$uri_subcat_id."'";
	$subcat_result = mysql_query($subcat_select) or dei ('Else / Select Subcat error: '.mysql_error());
	$subcat_record = mysql_fetch_array($subcat_result);
	$file_part_subcat = str_replace(array('_','-'),array('','',),$subcat_record['folder']);
	
	$csv_filename = 'product_master_template_'.$file_part_des.'_'.$file_part_subcat.'.csv';
	
	// query for subcat row info 
	$select1 = "select * from tblsubcat where subcat_id='".$uri_subcat_id."'";
	$result1 = mysql_query($select1);
	$row1 = mysql_fetch_array($result1);
	
	// set $subcat_id via get url variable
	$subcat_id = $uri_subcat_id;

	// supposed breadcrumb atop the thumbs view
	$hans = isset($_SESSION['hansel']) ? $_SESSION['hansel'] : '';
	$pos = strpos($hans, '->');
	if ($pos === false && isset($_SESSION['hansel']))
	{
		$_SESSION['hansel'] = $_SESSION['hansel']."->"."<a href='edit_new_product_designer.php?cat_id=".$cat_id."&des_id= ".$des_id."&subcat_id=".$uri_subcat_id."'>".$row1['subcat_name']."</a>";
	}

	// pv is when you publish or unpublish an item
	// ---------- (2012-01-08-rey)
	// This code is originally here but I didn't know the pv yet. Now that I know it if for the update of view status of
	// a product, i just changed the reference from prod_id to prod_no and added the jscript window location function so
	// as not to reuse the url for the update request.
	if (empty($_GET['pv']) == false)
	{
		$sql_ = "SELECT * FROM tbl_product WHERE prod_no = '".$_GET['pno']."'";
		$res_ = mysql_query($sql_);
		$rows_ = mysql_fetch_array($res_);
		if ($rows_['view_status'] == 'Y')
		{
			$val = 'N';
		}
		if ($rows_['view_status'] == 'N' || empty($rows_['view_status']))
		{
			$val = 'Y';
		}
		
		$sql_up = "UPDATE tbl_product SET view_status = '$val' WHERE prod_no = '".$_GET['pno']."'";
		$res_up = mysql_query($sql_up) or die('View status update error: '.mysql_error());
		
		$str3_cpage = isset($_GET['cpage']) ? '&cpage='.$_GET['cpage'] : '';
		$view_page = isset($_GET['view']) ? '&view='.$_GET['view'] : '';
		
		echo '
			<script>
				window.location.href="edit_new_product_designer.php?cat_id='.$uri_cat_id.'&des_id='.$uri_des_id.'&subcat_id='.$uri_subcat_id.$str3_cpage.'";
			</script>
		';
	}

	// Dunno what an sk is
	if (empty($_GET['sk']) == false)
	{
		$sql_ = "select * from tbl_product where prod_id='".$_GET['pid']."'";
		$res_ = mysql_query($sql_);
		$rows_ = mysql_fetch_array($res_);
		if($rows_['hide_sketch']=='Y'){
			$val = 'N';
		}
		if($rows_['hide_sketch']=='N'){
			$val = 'Y';
		}
		$sql_up = "update tbl_product set hide_sketch='$val' where prod_id='".$_GET['pid']."'";
		$res_up= mysql_query($sql_up);
	}

	/*
	| -----------------------------------------------------------------------------------------
	| Pagination Section
	*/
	$rno = 100; // ----> number of rows per page

	// Check url for view = clearance
	if (isset($_GET['view']) && $_GET['view'] == 'clearance') $view = $_GET['view'];
	
	// Query Clerarance products
	$sql_clr = "
		SELECT * 
		FROM tbl_product 
		WHERE 
			cat_id = '".$uri_cat_id."' 
			AND subcat_id = '".$uri_subcat_id."' 
			AND designer = '".$uri_des_id."' 
			AND (
				clearance = 'Clearnace' 
				OR clearance = 'clearance' 
				OR clearance = 'Yes' 
				OR clearance = 'yes' 
				OR clearance = 'Y' 
				OR clearance = 'y'
			) 
		ORDER BY 
			seque ASC, 
			prod_no ASC
	";
	
	// Query Regular products
	if (@$cat_id != '')
	{
		$sql_reg = "
			SELECT * 
			FROM tbl_product 
			WHERE 
				cat_id = '".$uri_cat_id."' 
				AND subcat_id = '".$uri_subcat_id."' 
				AND designer = '".$uri_des_id."' 
				AND (
					clearance != 'Clearnace' 
					AND clearance != 'clearance' 
					AND clearance != 'Yes' 
					AND clearance != 'yes' 
					AND clearance != 'Y' 
					AND clearance != 'y'
				) 
			ORDER BY 
				seque ASC, 
				prod_no ASC
		";
	} 
	else
	{
		$sql_reg = "
			SELECT * 
			FROM tbl_product 
			WHERE 
				subcat_id = '".$uri_subcat_id."' 
				AND designer = '".$uri_des_id."' 
				AND (
					clearance != 'Clearnace' 
					AND clearance != 'clearance' 
					AND clearance != 'Yes' 
					AND clearance != 'yes' 
					AND clearance != 'Y' 
					AND clearance != 'y'
				) 
			ORDER BY 
				seque ASC, 
				prod_no ASC
		";
	}

	$pr_rs_clr = mysql_query($sql_clr);
	$pr_rs_reg = mysql_query($sql_reg);
	$rnum_clr = mysql_num_rows($pr_rs_clr);
	$rnum_reg = mysql_num_rows($pr_rs_reg);
	
	// Pagination code
	// Cpage is current page
	$cpage = isset($_GET['cpage']) ? $_GET['cpage'] : '';
	
	// Regular pages
		if ($rnum_reg >= 0)
		{
			$mod_reg = $rnum_reg % $rno;
			
			if ($mod_reg > 0)
			{
				$tpage_reg = ($rnum_reg - $mod_reg) / $rno + 1; 
			}
			else
			{
				$tpage_reg = ($rnum_reg - $mod_reg) / $rno;
			}
			
			if ($cpage == "")
			{
				$cpage = 1;
			}

			// $skip - Offset for database pagination query
			$skip = ($cpage - 1) * $rno;
			
			// $lmt - limit for database pagination query
			if (($skip + $rno) > $rnum_reg)
			{
				$lmt = $rnum_reg - $skip;
			}
			else
			{
				$lmt = $rno;
			}
			
			// Start and end
			$start = $skip + 1;
			$end = $skip + $lmt;
		}
		
	// Clearance pages
		if ($rnum_clr >= 0)
		{
			$mod_clr = $rnum_clr % $rno;
			
			if ($mod_clr > 0)
			{
				$tpage_clr = ($rnum_clr - $mod_clr) / $rno + 1; 
			}
			else
			{
				$tpage_clr = ($rnum_clr - $mod_clr) / $rno;
			}
			
			if ($cpage == "")
			{
				$cpage = 1;
			}

			// $skip - Offset for database pagination query
			$skip_clr = ($cpage - 1) * $rno;
			
			// $lmt - limit for database pagination query
			if (($skip_clr + $rno) > $rnum_clr)
			{
				$lmt_clr = $rnum_clr - $skip_clr;
			}
			else
			{
				$lmt_clr = $rno;
			}
			
			// Start and end
			$start_clr = $skip_clr + 1;
			$end_clr = $skip_clr + $lmt_clr;
		}
	/*
	| End Pagination Section
	| -----------------------------------------------------------------------------------------
	*/

	// Act is up (up for update)
	// ---------- (2012-01-08-rey)
	// This code is originally here but I didn't know what it was for.
	// Now I know that it is for the update of sequencing of
	// a product, i just changed the reference from prod_id to prod_no and added the jscript window location function so
	// as not to reuse the url for the update request.
	if (empty($_GET['act']) == false)
	{
		$sqlQ = "SELECT * FROM tbl_product WHERE designer = '".$uri_des_id."' ORDER BY seque ASC, prod_no ASC";
		if ( ! empty($_POST['psc']))
		{
			$sqlQ = "SELECT * FROM tbl_product WHERE prod_no LIKE '%".trim($_POST['psc'])."%'";
		}	

		$resQ = mysql_query($sqlQ);
		
		while ($rowQ = mysql_fetch_array($resQ))
		{
			$v = $rowQ['prod_no'];

			if (isset($_POST["seq$v"]) && $rowQ['seque'] != $_POST["seq$v"] && ($_POST["seq$v"] != ''))
			{
				$SQLss = "UPDATE tbl_product SET seque = '".$_POST["seq$v"]."' WHERE prod_no = '".$rowQ['prod_no']."'";
				$RESss = mysql_query($SQLss) or die ('Seq update error: '.mysql_error());
			}
		}
		
		$str2_cpage = isset($_GET['cpage']) ? '&cpage='.$_GET['cpage'] : '';
		$view_page = isset($_GET['view']) ? '&view='.$_GET['view'] : '';
		
		echo '
			<script>
				window.location.href="edit_new_product_designer.php?cat_id='.$uri_cat_id.'&des_id='.$uri_des_id.'&subcat_id='.$uri_subcat_id.$str2_cpage.$view_page.'";
			</script>
		';
	}

	/*
	| -----------------------------------------------------------------------------------------
	| Query product thumbs list display
	*/
	if (isset($_POST['searchP']) == true && empty($_GET['pv']) == true && empty($_GET['sk']) == true && empty($_GET['act']) == true)
	{
		$sql = "select * from tbl_product where prod_no LIKE '%".trim($_POST['psc'])."%'";
	}
	else
	{
		//--------------------------------------------------------
		if (isset($view) && $view == 'clearance') // ----> clearance
		{
			$sql = "
				SELECT * 
				FROM tbl_product 
				WHERE 
					cat_id = '".$uri_cat_id."' 
					AND designer = '".$uri_des_id."' 
					AND (
						clearance = 'Clearnace' 
						OR clearance = 'clearance' 
						OR clearance = 'Yes' 
						OR clearance = 'yes' 
						OR clearance = 'Y' 
						OR clearance = 'y'
					) 
				ORDER BY seque ASC 
				LIMIT ".$skip_clr.",".$lmt_clr."";
		}
		else
		{
			if (@$cat_id != '')
			{
				// default query
				$sql = "
					SELECT * 
					FROM tbl_product 
					WHERE 
						cat_id = '".$uri_cat_id."' 
						AND subcat_id = '".$uri_subcat_id."' 
						AND designer = '".$uri_des_id."' 
						AND (
							clearance != 'Clearnace' 
							AND clearance != 'clearance' 
							AND clearance != 'Yes' 
							AND clearance != 'yes' 
							AND clearance != 'Y' 
							AND clearance != 'y'
						) 
					ORDER BY 
						seque ASC, 
						prod_no ASC 
					LIMIT ".$skip.",".$lmt."";
			} 
			else
			{
				$sql = "
					SELECT * 
					FROM tbl_product 
					WHERE 
						subcat_id = '".$uri_subcat_id."' 
						AND designer = '".$uri_des_id."' 
						AND (
							clearance != 'Clearnace' 
							AND clearance != 'clearance' 
							AND clearance != 'Yes' 
							AND clearance != 'yes' 
							AND clearance != 'Y' 
							AND clearance != 'y'
						) 
					ORDER BY 
						seque ASC, 
						prod_no ASC 
					LIMIT ".$skip.",".$lmt."";
			} 
		}

		if ( ! empty($_POST['psc']))
		{
			$sql = "select * from tbl_product where prod_no like '%".trim($_POST['psc'])."%'";	
		}
	}
	
	/*
	| -----------------------------------------------------------------------------------------
	| Search product number via top menu quick search link
	| Use this to dispaly list of product/s
	*/
	if (isset($_GET['tqs']) && $_GET['tqs'] == 1)
	{
		$like_prod_no = trim($_POST['top_quick_search']);
		$sql = "SELECT * FROM tbl_product WHERE prod_no LIKE '%".$like_prod_no."%'";
		$re_tqs = mysql_query($sql) or die('Slect TQS error: '.mysql_error());
		$ro_tqs = mysql_fetch_array($re_tqs);
		
		$uri_cat_id = $ro_tqs['cat_id'];
		$uri_des_id = $ro_tqs['designer'];
		$uri_subcat_id = $ro_tqs['subcat_id'];
	}
	
	$pr_rs = mysql_query($sql);

	include 'top.php'; 
?>
<style type="text/css">
a.L:link{ font-family:"Arial Narrow";font-weight:normal;color: #0000FF;font-size:11px;text-decoration: none;}
a.L:M:active{ font-family:"Arial Narrow";font-weight:normal;color:#0000FF;font-size:11px;text-decoration: none;}
a.L:visited{ font-family:"Arial Narrow";font-weight:normal;color:#0000FF;font-size:11px;text-decoration: none;}
a.L:hover{ font-family: "Arial Narrow" ;font-weight: 700;color:#0000FF;font-size:11px;text-decoration: None;}
</style>
<script language="javascript">
function do_submit(){
	var x = window.document.getElementById('psc').value;
	if(x != ''){
		window.document.news_disp_frm.action="<?php echo $_SERVER['PHP_SELF'];?>?cat_id=<?php echo $uri_cat_id?>&des_id=<?php echo $uri_des_id?>&subcat_id=<?php echo $uri_subcat_id?>";
		window.document.news_disp_frm.method = "post";
		window.news_disp_frm.submit();
	}	
}

function _do(ss){
	window.document.news_disp_frm.action="<?php echo $_SERVER['PHP_SELF'];?>?cat_id=<?php echo $uri_cat_id?>&des_id=<?php echo $uri_des_id?>&subcat_id=<?php echo $uri_subcat_id?>&cpage=<?php echo isset($_GET['cpage']) ? $_GET['cpage'] : ''; ?>&pv=1&pno="+ss;
	window.document.news_disp_frm.method = "post";
	window.document.news_disp_frm.submit();
	
}

function _do_sketch(ss){
	window.document.news_disp_frm.action="<?php echo $_SERVER['PHP_SELF'];?>?cat_id=<?php echo $uri_cat_id?>&des_id=<?php echo $uri_des_id?>&subcat_id=<?php echo $uri_subcat_id?>&cpage=<?php echo $_GET['cpage']?>&sk=1&pid="+ss;
	window.document.news_disp_frm.method = "post";
	window.document.news_disp_frm.submit();
	
}
</script>
<script language="javascript">
	
	function _key(){
		if(event.keyCode < 48 || event.keyCode > 57) {
			event.returnValue = false;
		}
	}
	
	function _key2(squ){
		var xx = 'seq'+squ;
		var x = window.document.getElementById(xx).value;
		if(x == ''){
			if(event.keyCode == 96){
				event.returnValue = false;
			}
		}
	}
	
	function _update(frm){		
		window.document.news_disp_frm.action="<?php echo $_SERVER['PHP_SELF'];?>?act=up&cat_id=<?php echo $uri_cat_id?>&des_id=<?php echo $uri_des_id?>&subcat_id=<?php echo $uri_subcat_id?>&cpage=<?php echo isset($_GET['cpage']) ? $_GET['cpage'] : ''; ?>";
		window.document.news_disp_frm.method = "post";
		window.document.news_disp_frm.submit();
	}
	function _updates(frm){		
		window.document.news_disp_frm.action="<?php echo $_SERVER['PHP_SELF'];?>?act=&cat_id=<?php echo $uri_cat_id?>&des_id=<?php echo $uri_des_id?>&subcat_id=<?php echo $uri_subcat_id?>&cpage=<?php echo $_GET['cpage']; ?>";
		window.document.news_disp_frm.method = "post";
		window.document.news_disp_frm.submit();
	}
	
</script>

<?php
	echo '
<script type="text/javascript">
	// This is search field on thumbs list
	$().ready(function() {
	    $("#psc").autocomplete("get_style_list.php?cat_id", {
	        width: 100,
	        matchContains: true,
			max: 20,
	        selectFirst: false
	    });
	});
</script>
	';
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td height="333" class="tab" align="center" valign="middle">
	
	<!--bof form=============================================================================-->
	<form name="news_disp_frm" method="post" action="<?=$_SERVER['PHP_SELF']?>?cat_id=<?php echo $uri_cat_id?>&subcat_id=<?php echo $uri_subcat_id?>">
	
	<input type="hidden" value="sec" name="searchP" id="searchP" />
    <?php //echo $_SESSION['hansel']; ?>
	
	<table width="90%" border="0" cellspacing="0" cellpadding="0">
	<tr valign="top" class="bodytext">
		<td class="border_color">
	
			<table border="0" cellpadding="2" width=100%>
			<?php
			if (isset($msg))
			{
				echo '<tr><td colspan="10" align="center" height="30" style="vertical-align:middle;">'.$msg.'</td></tr>';
			}
			?>
			<tr bgcolor="#CCCCCC">
				<td colspan="3" align="left">
					<?php
					/*
					| -------------------------------------------------------------------------------------
					| Pagination part of the table header at upper left corner (regular sale products)
					*/
					?>
					<span class="text">Regular Sale Pages:</span><br />
					<?php
					if ( ! isset($view))
					{
						for ($i = 1; $i <= $tpage_reg; $i++)
						{
							if ($i == $cpage)
							{ ?>
								<span class="text">[<?echo $i;?>]</span>
								<?php
							}
							else
							{ ?>
								<span class="text">[</span><a href="edit_new_product_designer.php?cpage=<?=$i;?>&cat_id=<?=$cat_id;?>&des_id=<?=$des_id;?>&subcat_id=<?=$subcat_id;?>" class="pagelinks"><?echo $i;?></a><span class="text">]</span>
								<?php
							}
						}
					}
					else
					{
						for ($i = 1; $i <= $tpage_reg; $i++)
						{ ?>
							<span class="text">[</span><a href="edit_new_product_designer.php?cpage=<?=$i;?>&cat_id=<?=$cat_id;?>&des_id=<?=$des_id;?>&subcat_id=<?=$subcat_id;?>" class="pagelinks"><?echo $i;?></a><span class="text">]</span>
							<?php
						}
					} ?>
				</td>
				<td colspan="3" align="left">
					<?php
					/*
					| -------------------------------------------------------------------------------------
					| Pagination part of the table header at upper mid (clearance products)
					*/
					?>
					<span class="text">Clearance Pages:</span><br />
					<?php
					if (isset($view) && $view == 'clearance')
					{
						for ($i = 1; $i <= $tpage_clr; $i++)
						{
							if ($i == $cpage)
							{ ?>
								<span class="text">[<?echo $i;?>]</span>
								<?php
							}
							else
							{ ?>
								<span class="text">[</span><a href="edit_new_product_designer.php?cpage=<?=$i;?>&cat_id=<?=$cat_id;?>&des_id=<?=$des_id;?>&subcat_id=<?=$subcat_id;?>&view=clearance" class="pagelinks"><?echo $i;?></a><span class="text">]</span>
								<?php
							}
						}
					}
					else
					{
						for ($i = 1; $i <= $tpage_clr; $i++)
						{ ?>
							<span class="text">[</span><a href="edit_new_product_designer.php?cpage=<?=$i;?>&cat_id=<?=$cat_id;?>&des_id=<?=$des_id;?>&subcat_id=<?=$subcat_id;?>&view=clearance" class="pagelinks"><?echo $i;?></a><span class="text">]</span>
							<?php
						}
					} ?>
				</td>
					<?php
					/*
					| -------------------------------------------------------------------------------------
					| Search Area
					*/
					?>
				<td  align="right" colspan="2"><h1>Search Style#: </h1></td>
				<td><h1><input type="text" name="psc" id="psc" size="10" value="<?php echo isset($_POST['psc']) ? $_POST['psc'] : '';?>" /></h1></td>
				<td><h1><input type="submit" name="scc" id="scc" value="Search" onclick="javascript:do_submit()" /></h1></td>
			</tr>
					<?php
					/*
					| -------------------------------------------------------------------------------------
					| Table headings
					*/
					?>
			<tr bgcolor="#CCCCCC">
				<td><h1>Sequence</h1></td>
				<td height="30"><h1>Image</h1></td>
				<td><h1>Publish</h1></td>
				<td align="center"><h1>On Sale</h1></td>
				<td><h1>Category</h1></td>
				<td><h1>SubCategory</h1></td>
				<td align="center"><h1>Designer</h1></td>
				<td align="center"><h1>Product Name</h1></td>
				<td><h1>Style#</h1></td>
				<td><h1>Operation</h1></td>
			</tr>
			
			<?php
			$counter = 0;
			while ($pr_row = mysql_fetch_array($pr_rs))
			{
				$counter++;
					/*
					| -------------------------------------------------------------------------------------
					| Iterate through the product query
					*/
				?>
				
				<tr bgcolor='eeeeee' onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='eeeeee'">
					<td> <!--Sequence-->
						<input type="text" size="3" maxlength="5" name='seq<?php echo $pr_row['prod_no']?>' id="seq<?php echo $pr_row['prod_no']?>" value="<?php echo $pr_row['seque']; ?>" onkeypress="_key();" onkeydown="_key2('<?php echo $pr_row['prod_no']?>');" />
					</td>
					
					<?php 
						/*
						| -------------------------------------------------------------------------------------
						| Get the images
						*/
					$qFolder = @mysql_query("SELECT
												d.folder as designer_folder, subcat.folder AS subcat_folder, tcs.color_name,tcs.color_code,
												case cat.cat_id
												  when '1'
													then 'WMANSAPREL'
												  when '19'
													then 'JWLRYACCSRIES'
												  when '22'
													then 'BRIDAL'
												  when '23'
													then 'CLRNCE'
												  else 'WMANSAPREL'
												end as cat_folder 
											FROM
											  tbl_product tp
											  JOIN designer d ON d.des_id=tp.designer
											  JOIN tblcat cat ON cat.cat_id = tp.cat_id
											  JOIN tblsubcat subcat ON subcat.subcat_id = tp.subcat_id
											  LEFT JOIN tblcolor tcs ON tcs.color_name = tp.primary_img_id
											WHERE
											  tp.prod_no = '".$pr_row['prod_no']."' 
											");
					$folder = @mysql_fetch_array($qFolder);
					$base_site_url = SITE_URL;  // ----> Using defined SITE_URL at ../common.php
					
					$img_url = $base_site_url.'product_assets/'.$folder['cat_folder'].'/'.$folder['designer_folder'].'/'.$folder['subcat_folder'].'/';
					$img_thumb = $img_url.'product_front/'.$pr_row['prod_no'].'_'.$pr_row['primary_img_id'].'.jpg';
					$img_thumb_back = $img_url.'product_back/'.$pr_row['prod_no'].'_'.$pr_row['primary_img_id'].'.jpg';
					$img_thumb_side = $img_url.'product_side/'.$pr_row['prod_no'].'_'.$pr_row['primary_img_id'].'.jpg';

					if ($img = @GetImageSize($img_thumb))
					{
						$thumb = $img_thumb;
					}
					elseif ($img2 = @GetImageSize($img_thumb_side))
					{
						$thumb = $img_thumb_side;
					}
					elseif ($img3 = @GetImageSize($img_thumb_back))
					{
						$thumb = $img_thumb_back;
					}
					else
					{
						$thumb = SITE_URL.'images/default_img_icon.jpg';
					}
					
					// Image
					?>
					<td class="headtxt" width="65">
						<img src="<?=SITE_URL?>res.php?w=60&constrain2=1&img=<?php echo $thumb;?>" width="63">
					</td>
					
					<?php
					// Pubish
					if ($pr_row['view_status'] == 'Y') $checked="checked";
					else $checked = '';
					?>
					<td align="center">
						<input name='prv<?php echo $pr_row['prod_no']?>' id="prv<?php echo $pr_row['prod_no']?>" type='checkbox' value='<?php echo $pr_row['view_status']?>' <?php echo $checked;?> onclick="javascript: _do('<?php echo $pr_row['prod_no']?>');" />
					</td>
					
					<?php
					if ($pr_row['hide_sketch'] == 'Y') $checked="checked";
					else $checked = '';
					?>
					<td align="center">
						<input name='skc<?php echo $pr_row['prod_id']?>' id="skc<?php echo $pr_row['prod_id']?>" type='checkbox' value='<?php echo $pr_row['hide_sketch']?>' <?php echo $checked;?> onclick="javascript: _do_sketch('<?php echo $pr_row['prod_id']?>');" />
					</td>
					<td class="text"><?php echo get_catname($pr_row['cat_id']);?></td>
					<td class="text" ><?php echo get_subcatname($pr_row['subcat_id']);?></td>
					<td class="text" >
						<?php
						@$get_des = mysql_fetch_array(mysql_query("select * from designer where des_id = '".$pr_row['designer']."'"));
						echo $get_des['designer'];
						?>
					</td>
					<td class="text"><?php echo $pr_row['prod_name']?></td>
					<td class="text"><?php echo $pr_row['prod_no']?></td>
					
					<?php 
					if ($uri_cat_id == 22) $page_url='edit_new_par_bridalproduct';
					else $page_url='edit_new_par_product';
					?>
					
					<td>
						<span class="text">[</span><a href="<?=$page_url?>.php?act=show&prod_no=<? echo $pr_row['prod_no'];?>&mode=<? echo 'e';?>" class="pagelinks">Edit</a><span class="text">]</span>
						<span class="text">[</span><a href="<?=$page_url?>.php?act=show&prod_no=<? echo $pr_row['prod_no'];?>&mode=<? echo 'd';?>&cat_id=<?=$pr_row['cat_id']?>&subcat_id=<?=$pr_row['subcat_id']?>&des_id=<?=$uri_des_id?>" class="pagelinks">Delete</a><span class="text">]</span>

					</td>
				</tr>
				<?php
			} ?>
			</table>
			
		</td>
	</tr>
	<tr bgcolor='FFFFFF'>
		<td align="right" height=30>
		
		  	<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td width="13%" align="left"><input type="button" name="b1" value="Update Sequence" onclick="javascript:_update('news_disp_frm');" /></td>
				<td width="87%" align="right">
					<?php
					if ($cpage > 1)
					{ ?>
						<a href="edit_new_product_designer.php?cpage=<? echo $cpage-1;?>&cat_id=<?=$cat_id;?>&des_id=<?=$des_id;?>&subcat_id=<?=$subcat_id;?>" class="pagelinks">Prev</a>
						<?php
					}
					if ($cpage > 2)
					{ ?>
						<span class="text"> | </span>
						<?php
					}
					if ($cpage < $tpage_reg)
					{ ?>
						<a href="edit_new_product_designer.php?cpage=<? echo $cpage+1;?>&cat_id=<?=$cat_id;?>&des_id=<?=$des_id;?>&subcat_id=<?=$subcat_id;?>" class="pagelinks">Next</a>
						<?php
					} ?>
					&nbsp;&nbsp;
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr bgcolor='FFFFFF'>
		<td align="left" height=30>
			<span class="text"> Page :</span>
			<?php
			for ($i = 1; $i <= $tpage_reg; $i++)
			{
				if ($i == $cpage)
				{ ?>
					<span class="text">[<?echo $i;?>]</span>
					<?php
				}
				else
				{ ?>
					<span class="text">[</span><a href="edit_new_product_designer.php?cpage=<?=$i;?>&cat_id=<?=$cat_id;?>&des_id=<?=$des_id;?>&subcat_id=<?=$subcat_id;?>" class="pagelinks"><?echo $i;?></a><span class="text">]</span>
					<?php
				}
			} ?>
		</td>
	</tr>
	</table>

	</form>

</td></tr>
</table>
<? include 'footer.php'; ?>