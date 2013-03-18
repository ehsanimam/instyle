<?php
session_start();
include("../common.php");
include('../functionsadmin.php');
include 'top.php'; 
	
	$sql_ = "SELECT * FROM `tblproduct_details` WHERE `prod_id`='$prod_name'";
	$res_ = mysql_query($sql_);
	$num_ = mysql_num_rows($res_);
	if($num_ > 0){
		$row_ = mysql_fetch_array($res_);
	}


if(@$prod_name=='')
{
    $prod_name=0;
}
if(empty($_POST['cmd_cat_submit']) == false){
if(@$act=="add")
{
	if(@$prod_name>0)
	{
		if(@$part_name!='')
		{
			if(@$prod_price!='')
			{
			
				add_prodcut_details_fun($prod_name, $part_name, $prod_price, $prod_price2, $prod_disc_price, $prod_desc, $num_,  $call_price);
				
				if ($cmd_cat_submit!="Add More"){
				echo "
             	<script>
                	location.href='add_size_product.php?flow=1'
             	</script>
             	";}
				else{
				echo "
             	<script>
                	location.href='add_det_product.php?flow=1'
             	</script>
             	";}
			}
			else{$err="Please enter Price";}		
		}
		else{
			
			$err="Please enter Name";
		
		
		}
	}
	else{$err="Please select Product";}
}
}
$sql="select * from tblproduct order by prod_id desc limit 1";
$rest=mysql_query($sql)or die("Error in inserting Category");
$lat=@mysql_result($rest,0,'prod_name');
if (@$flow==1){
$prod_name=mysql_result($rest,0,'prod_id');}

?>
<title>:Admin Section</title>
<head>
<script language="javascript">
	function _doreturn(){
		document.prod_frm.submit();
	}
	
	function _number(){
	var key = window.event.keyCode;
	if(key >=48 && key <= 57)
	{
	 	return true;
	}else{
		return false;
	}	
}
</script>
</head>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	
	<form name="prod_frm" method="post" action="add_det_product.php?act=add&acts=<?php echo $_GET['acts'];?>">

	
		<table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
<tr><td align="left">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                      <!--DWLayoutTable-->
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>ADD Product Details</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><?php if($_GET['acts']!=1){ echo @$err; }?></td></tr>
						<!--<tr>
						  <td height="30" colspan="2" align="center" valign="top" class="text">Add Product Details to <b class="error"><?=$lat;?></b></td>
					  </tr>-->
					  <tr>
						  <td width="310" align="right" class="text">Select Product : </td>
						  <td width="470" align="left"><? get_prod_add();?><script>document.prod_frm.prod_name.value="<?php  echo $prod_name;?>"</script></td>
					  </tr>
					  <!--<tr>
					  	<td class="text" align="right">Select STYLE NUMBER: </td>
					    <td align="left"><? get_prod_no();?><script>document.prod_frm.prod_no.value="<?=$prod_no;?>"</script></td>
				      </tr>-->
						<tr>
					    
                  <td width="310" class="text" align="right">Product# : </td>
					    <td width="470" align="left"><input type="text" name="part_name" class="inputbox" value="<?php if(empty($row_)==true){ echo @$part_name; }else{ echo $row_['p_name'];}?>" ></td>
				      </tr>
					  <tr>
							<td class="text" align="right">Price : </td>
							<td><span class="text">$</span><input type="text" name="prod_price" class="inputbox" value="<?php if(empty($row_)==true){ echo  @$prod_price; }else{ echo $row_['price'];}?>" onKeyPress="javascript: return _number();"></td>
						</tr>
      					<tr>
							<td class="text" align="right">Price 2 : </td>
							<td><span class="text">$</span><input type="text" name="prod_price2" class="inputbox" value="<?php if(empty($row_)==true){ echo @$prod_price2; }else{ echo $row_['price2'];}?>"></td>
						</tr>
                        <tr>
							<td class="text" align="right">Net Designer Price : </td>
							<td>
								<table cellpadding="0" cellspacing="0" width="100%" border="0">
									<tr>
										<td width="40%"><span class="text">$</span><input type="text" name="prod_disc_price" class="inputbox" value="<?php if(empty($row_)==true){ echo $prod_disc_price; }else{ echo $row_['discount'];}?>" onKeyPress="javascript: return _number();"></td>
										<td width="2%">&nbsp;</td>
										<td class="text"><input name="call_price" type="checkbox" value="yes" <?php if($row_['color_price'] > 0){ echo "checked";}?> />Calculate Color Price</td>
									</tr>
								</table>	
							</td>
						</tr>
						<tr>
							<td class="text" align="right">Description : </td>
							<td>
								<textarea name="prod_desc" rows="5" cols="40"><?php if(empty($row_)==true){ echo @$prod_desc; }else{ echo $row_['p_desc'];}?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan=2 align=center>
								<input type="submit" name="cmd_cat_submit" class=button value="Add More">&nbsp;&nbsp;<input type="submit" name="cmd_cat_next" class=button value="Next Step">						
							</td>
						</tr>
					</table>
</td></tr>
</table>
	</form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>