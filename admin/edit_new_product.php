<?php
	include("../common.php");
	include('../functionsadmin.php');
	include('security.php');

	// Dunno what a pv is
	if (empty($_GET['pv']) == false)
	{
		$sql_ = "select * from tbl_product where prod_id='".$_GET['pid']."'";
		$res_ = mysql_query($sql_);
		$rows_ = mysql_fetch_array($res_);
		if($rows_['view_status']=='Y'){
			$val = 'N';
		}
		if($rows_['view_status']=='N' || empty($rows_['view_status'])){
			$val = 'Y';
		}
		
		$sql_up = "update tbl_product set view_status='$val' where prod_id='".$_GET['pid']."'";
		$res_up= mysql_query($sql_up);
	}

	// Dunno what a pv is
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

	$rno=50;
	//$sql="select * from tbl_product where cat_id='$cat_id' order by prod_date desc";
	
	// Query products
	if (@$cat_id == 23)
	{
		$sql="select * from tbl_product where hide_sketch='Y' OR cat_id='$cat_id' order by seque asc";
	}
	else
	{
		$sql="select * from tbl_product where cat_id='$cat_id' and subcat_id='$subcat_id' order by seque asc";
	}
	
	$pr_rs=mysql_query($sql);
	$rnum=mysql_num_rows($pr_rs);
	
	if($rnum>=0)
		 {
			$mod=$rnum%$rno;
			if($mod>0)
			{
			  $tpage=($rnum-$mod)/$rno +1; 
			}
			else
			{
			  $tpage=($rnum-$mod)/$rno;
			}
			if(@$cpage=="")
			{
			  $cpage=1;       /*variable for page no.....*/
			}

			$skip=($cpage-1)*$rno;
			if(($skip+$rno)>$rnum)
			{
			  $lmt=$rnum-$skip;
			}
			else
			{
			  $lmt=$rno;
			}
			$start=$skip +1;
			$end=$skip + $lmt;
	}

	if (empty($_GET['act']) == false)
	{
		//echo $_POST["seq$v"];
		$sqlQ = "select * from tbl_product where cat_id='".$_GET['cat_id']."' and subcat_id='".$_GET['subcat_id']."' order by seque asc limit $skip,$lmt";
		$resQ = mysql_query($sqlQ);
		while($rowQ = mysql_fetch_array($resQ))
		{
			$v = $rowQ['prod_id'];
			
			//echo $_POST["seq$v"]."=";
			//echo $rowQ['seque']."<br>";
			
			if($rowQ['seque']!=$_POST["seq$v"] && $_POST["seq$v"] > 0){
				//echo $rowQ['prod_name'];
				
				$sql0 = "select * from tbl_product where prod_id='".$rowQ['prod_id']."'";
				$res0 = mysql_query($sql0);
				$row0 = mysql_fetch_array($res0);
				//echo $row0['seque'];
				//echo $rowQ['seque'];
				
				$sqlS = "update tbl_product set seque='".$row0['seque']."' where seque='".$_POST["seq$v"]."' and cat_id='".$_GET['cat_id']."'";
				$resS = mysql_query($sqlS);
				
				$SQLss = "update tbl_product set seque='".$_POST["seq$v"]."' where prod_id='".$rowQ['prod_id']."'";
				$RESss = mysql_query($SQLss);
			}
			
		}	
	}


//echo '$search:'.$search;
/*
if(@$search)
{
	$sql="select * from tbl_product where prod_no like '%".trim($_POST['psc'])."'";
	else
	*/
	//--------------------------------------------------------
	if(isset($_POST['searchP'])==true && empty($_GET['pv'])==true && empty($_GET['sk'])==true && empty($_GET['act'])==true)
	{
		$sql = "select * from tbl_product where prod_no LIKE '%".trim($_POST['psc'])."%'";
				/*
				$sqlS = "select * from tbl_product where prod_no='".trim($_POST['psc'])."'";
				$rsS = mysql_query($sqlS);
				$rnumS=mysql_num_rows($rsS);
		if($rnumS > 0){
			 	$rowS = mysql_fetch_array($rsS);
			//echo $sql="select * from tbl_product where prod_no='".$rowS['prod_no']."' order by prod_date desc";
				$sql="select * from tbl_product where prod_no='".trim($rowS['prod_no'])."'";
		}else{
				$sqlS = "select * from tbl_product where prod_name='".trim($_POST['psc'])."'";	
				$rsS = mysql_query($sqlS);
				$rnumS=mysql_num_rows($rsS);
			if($rnumS > 0){
				$rowS = mysql_fetch_array($rsS);
				$sql="select * from tbl_product where prod_name='".trim($rowS['prod_name'])."'";
			}else{
				$msg = "<font style='font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FF0000; font-size:11px;'>No product found</font>";
				$sql="select * from tbl_product where cat_id='$cat_id' and subcat_id='$subcat_id' order by seque asc limit $skip,$lmt";
			}
			*/
		//}
	}
	else
	{
		//--------------------------------------------------------
		if(@$cat_id==23)
		{
			$sql="select * from tbl_product where hide_sketch='Y' OR cat_id='$cat_id' order by seque asc limit $skip,$lmt";
		}
		else
		{
			// default query
			$sql="select * from tbl_product where cat_id='$cat_id' and subcat_id='$subcat_id' order by seque asc limit $skip,$lmt";
		}
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
		window.document.news_disp_frm.action="<?php echo $_SERVER['PHP_SELF'];?>?cat_id=<?php echo $_GET['cat_id']?>&subcat_id=<?php echo $_GET['subcat_id']?>";
		window.document.news_disp_frm.method = "post";
		window.news_disp_frm.submit();
	}	
}

function _do(ss){
	window.document.news_disp_frm.action="<?php echo $_SERVER['PHP_SELF'];?>?cat_id=<?php echo $_GET['cat_id']?>&subcat_id=<?php echo $_GET['subcat_id']?>&cpage=<?php echo $_GET['cpage']?>&pv=1&pid="+ss;
	window.document.news_disp_frm.method = "post";
	window.document.news_disp_frm.submit();
	
}

function _do_sketch(ss){
	window.document.news_disp_frm.action="<?php echo $_SERVER['PHP_SELF'];?>?cat_id=<?php echo $_GET['cat_id']?>&subcat_id=<?php echo $_GET['subcat_id']?>&cpage=<?php echo $_GET['cpage']?>&sk=1&pid="+ss;
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
		window.document.news_disp_frm.action = "<?php echo $_SERVER['PHP_SELF'];?>?act=up&cat_id=<?php echo $_GET['cat_id']?>&subcat_id=<?php echo $_GET['subcat_id']?>&cpage=<?php echo $_GET['cpage']; ?>";
		window.document.news_disp_frm.method = "post";
		window.document.news_disp_frm.submit();
	}
	function _updates_(frm){
		window.document.news_disp_frm.action = "<?php echo $_SERVER['PHP_SELF'];?>?act=&cat_id=<?php echo $_GET['cat_id']?>&subcat_id=<?php echo $_GET['subcat_id']?>&cpage=<?php echo $_GET['cpage']; ?>";
		window.document.news_disp_frm.method = "post";
		window.document.news_disp_frm.submit();
	}
	
</script>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-autocomplete/jquery.autocomplete.min.js">
	/******************************
	* jQuery Autocomplete Plugin
	* http://docs.jquery.com/Plugins/Autocomplete
	*******************************/
</script>
<link rel="stylesheet" type="text/css" href="js/jquery-autocomplete/jquery.autocomplete.css" />
<?php
	echo '
<script type="text/javascript">
	$().ready(function() {
	    $("#psc").autocomplete("get_style_list.php?cat_id='.$_GET['cat_id'].'&subcat_id='.$_GET['subcat_id'].'", {
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
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	<!--bof form=============================================================================-->
	<form name="news_disp_frm" method="post" action="<?=$_SERVER['PHP_SELF']?>?cat_id=<?php echo $_GET['cat_id']?>&subcat_id=<?php echo $_GET['subcat_id']?>">
	<input type="hidden" value="sec" name="searchP" id="searchP" />
		<table width="90%" border="0" cellspacing="0" cellpadding="0">
		<tr valign="top" class="bodytext"><td class="border_color"> 
		
			<table border="0" cellpadding="2" width=100%>
				<?php
				/*
				| ----------------------------------------------------------------------------
				| Search Area for Style #
				*/
				?>
				<tr bgcolor="#CCCCCC">
					<td colspan="6" align="center"><?php echo $msg;?></td>
					<td  align="right" colspan="2"><h1>Search Style#: </h1></td>
					<td><h1><input type="text" name="psc" id="psc" size="10" value="<?php echo $_POST['psc'];?>" /></h1></td>
					<td><h1><input type="submit" name="scc" id="scc" value="Search" onclick="javascript:do_submit();" /></h1></td>
				</tr>
				
				<?php
				/*
				| ----------------------------------------------------------------------------
				| Table Headers
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
					<!--<td><h1>Price</h1></td>-->
					<td><h1>Operation</h1></td>
				</tr>
				
				<?php
				$counter=0;
				while ($pr_row=mysql_fetch_array($pr_rs))
				{
					$counter++;
					/*
					| -------------------------------------------------------------------------------------
					| Iterate through the product query
					*/
					?>
					<?//if($counter%2==0){?>
					<tr bgcolor='eeeeee' onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='eeeeee'">
						<td><input type="text" size="3" maxlength="5" name='seq<?php echo $pr_row['prod_id']?>' id="seq<?php echo $pr_row['prod_id']?>" value="<?php echo $pr_row['seque']; ?>" onkeypress="_key();" onkeydown="_key2('<?php echo $pr_row['prod_id']?>');" />
						</td>
						<?php 
						/*
						| -------------------------------------------------------------------------------------
						| Get the images
						*/
						$qFolder = @mysql_query(
							"SELECT
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
								LEFT JOIN designer d ON d.des_id=tp.designer
								LEFT JOIN tblcat cat ON cat.cat_id = tp.cat_id
								LEFT JOIN tblsubcat subcat ON subcat.subcat_id = tp.subcat_id
								LEFT JOIN tblcolor tcs ON tcs.color_code = tp.primary_img_id
							WHERE
								tp.prod_no = '".$pr_row['prod_no']."'"
						);
						$folder = @mysql_fetch_array($qFolder);
						$base_site_url	 = SITE_URL;	// ----> Using defined SITE_URL at ../common.php
								
						$img_url		 = $base_site_url.'product_assets/'.$folder['cat_folder'].'/'.$folder['designer_folder'].'/'.$folder['subcat_folder'].'/';
						$img_thumb 	     = $img_url.'product_front/'.$pr_row['prod_no'].'_'.$pr_row['primary_img_id'].'.jpg';
						$img_thumb_back  = $img_url.'product_back/'.$pr_row['prod_no'].'_'.$pr_row['primary_img_id'].'.jpg';
						$img_thumb_side  = $img_url.'product_side/'.$pr_row['prod_no'].'_'.$pr_row['primary_img_id'].'.jpg';
						
						//die($img_thumb_back);
						if($img = @GetImageSize($img_thumb)) {
							$thumb = $img_thumb;
						} elseif($img2 = @GetImageSize($img_thumb_side)) {
							$thumb = $img_thumb_side;
						} elseif($img3 = @GetImageSize($img_thumb_back)) {
							$thumb = $img_thumb_back;
						} else {
							$thumb = $base_site_url.'images/instylelnylogo.jpg';
						} ?>
						
						<td class="headtxt" width=><img src="<?=$base_site_url?>res.php?w=60&constrain2=1&img=<?php echo $thumb;?>" width=63></td>
						
						<?php if($pr_row['view_status'] == 'Y'){ $checked="checked"; }else{ $checked = ''; }?>
						<td align="center"><input name='prv<?php echo $pr_row['prod_id']?>' id="prv<?php echo $pr_row['prod_id']?>" type='checkbox' value='<?php echo $pr_row['view_status']?>' <?php echo $checked;?> onclick="javascript: _do('<?php echo $pr_row['prod_id']?>');" /></td>
						
						<?php if($pr_row['hide_sketch'] == 'Y'){ $checked="checked"; }else{ $checked = ''; }?>
						<td align="center"><input name='skc<?php echo $pr_row['prod_id']?>' id="skc<?php echo $pr_row['prod_id']?>" type='checkbox' value='<?php echo $pr_row['hide_sketch']?>' <?php echo $checked;?> onclick="javascript: _do_sketch('<?php echo $pr_row['prod_id']?>');" /></td>
						<td class="text"><? get_catname($pr_row['cat_id']);?></td>
						<td class="text" ><? get_subcatname($pr_row['subcat_id']);?></td>
						<td class="text" >
							<?php
							@$get_des = mysql_fetch_array(mysql_query("select * from designer where des_id = '".$pr_row['designer']."'"));
							echo $get_des['designer'];
							?>
						</td>
						<td class="text"><? echo $pr_row['prod_name']?></td>
						<td class="text"><? echo $pr_row['prod_no']?></td>
						<!--<td class="text">$<?echo $pr_row[prod_price]?></td>-->
						
						<?php 
						if($_GET['cat_id']==22) $page_url='edit_new_par_bridalproduct';
						else $page_url='edit_new_par_product';
						?>
						
						<td>
							<span class="text">[</span><a href="<?=$page_url?>.php?act=show&prod_no=<? echo $pr_row['prod_no'];?>&mode=<? echo 'e';?>" class="pagelinks">Edit</a><span class="text">]</span>
							<span class="text">[</span><a href="<?=$page_url?>.php?act=show&prod_no=<? echo $pr_row['prod_no'];?>&mode=<? echo 'd';?>&cat_id=<?=$pr_row['cat_id']?>&subcat_id=<?=$pr_row['subcat_id']?>" class="pagelinks">Delete</a><span class="text">]</span>
								<!-- <span class="text">[</span><a href="add_zoom_img_product.php?prod_id=<? echo $pr_row['prod_id'];?>&mode=e" class="pagelinks">AddZoom</a><span class="text">]</span></td> -->
						</td>
					</tr>
					<?php
				} ?>
			</table>
		</td></tr>
		<tr bgcolor='FFFFFF'><td align="right" height=30>
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td width="13%" align="left"><input type="button" name="b1" value="Update Sequence" onclick="javascript:_update('news_disp_frm');" /></td>
					<td width="87%" align="right">
						<?if($cpage>1){?>
							<a href="edit_new_product.php?cpage=<? echo $cpage-1;?>&cat_id=<?=$cat_id;?>&subcat_id=<?=$subcat_id;?>" class="pagelinks">Prev</a><?}?>
						<?if($cpage>2){?>
							<span class="text"> | </span> <? }?>
						<?if($cpage<$tpage){?>
							<a href="edit_new_product.php?cpage=<? echo $cpage+1;?>&cat_id=<?=$cat_id;?>&subcat_id=<?=$subcat_id;?>" class="pagelinks">Next</a>
						<?}?>
						&nbsp;&nbsp;
					</td>
				</tr>
			</table>
		</td></tr>
		<tr bgcolor='FFFFFF'>
			<td align="left" height=30><span class="text"> Page :</span>
				<?for($i=1;$i<=$tpage;$i++){?>
					<?if($i==$cpage){?>
						<span class="text">[<?echo $i;?>]</span>
					<? } else {?>
						<span class="text">[</span><a href="edit_new_product.php?cpage=<?=$i;?>&cat_id=<?=$cat_id;?>&subcat_id=<?=$subcat_id;?>" class="pagelinks"><?echo $i;?></a><span class="text">]</span>
					<?}?>
				<?}?>
			</td>
		</tr>
		</table>
	</form>
	
</td></tr>
</table>
<? include 'footer.php'; ?>