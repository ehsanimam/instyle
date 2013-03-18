<?
session_start();
include("../common.php");
include('../functionsadmin.php');
include 'top.php'; 

if(@$prod_name=='')
{
    $prod_name=0;
}
if(@$part_name=='')
{
    $part_name=0;
}

if(@$act=="add")
{
	if(@$prod_name>0)
	{
		if(@$part_name>0)
		{
			if($size1!='')
			{
				if($color!='')
				{
					if($prod_stock!='')
					{
						add_prodcut_size_fun($prod_name, $part_name, $wood, $size1, $size2, $size3, $size4, $size5, $color, $prod_stock);
						
						if($cmd_cat_submit == "Done")
						echo "
             			<script>
                			location.href='add_size_product.php?flow=2'
             			</script>
             			";
						else
						echo "
             			<script>
                			location.href='add_size_product.php?flow=1'
             			</script>
             			";
					}
					else{$err="Please enter the stock";}
				}
				else{$err="Please select Color";}
			}
			else{$err="Please select Size";}
		}
		else{$err="Please select Part";}
	}
	else{$err="Please select Product";}
}

if($flow==2){
	$err = "Successfully added";
}

$sql="select * from tblproduct order by prod_id desc limit 1";
$rest=mysql_query($sql)or die("Error in inserting Category");
$lat=@mysql_result($rest,0,'prod_name');
if (@$flow==1){
$prod_name=mysql_result($rest,0,'prod_id');}
?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function submit_form()
{
    document.prod_frm.method="post";
    document.prod_frm.action="add_size_product.php";
    document.prod_frm.submit();
    
}


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
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	
	<form name="prod_frm" method="post" action="add_size_product.php?act=add">
		<table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
<tr><td align="left">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                      <!--DWLayoutTable-->
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>ADD Size and color Details</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><? echo @$err;?></td></tr>
						<!--<tr>
						  <td height="30" colspan="2" align="center" valign="top" class="text">Last added Product was <b class="error"><?=$lat;?></b></td>
					  </tr>-->
						<tr>
						  <td width="310" align="right" class="text">Select Product : </td>
						  <td width="470" align="left"><? get_prod_add_size();?>
						  <script>document.prod_frm.prod_name.value="<?=$prod_name;?>"</script></td>
					  </tr>
						<tr>
						  
                  <td align="right" class="text">Select #: </td>
						  <td align="left"><?get_prat_add_size($prod_name);?><script>document.prod_frm.part_name.value="<?=$part_name;?>"</script></td>
					  </tr>
						<tr>
							<td class="text" align="right">Wood Type: </td>
							<td><input name="wood" type="text" id="wood" class="inputbox"></td>
						</tr>						
						<tr>
							<td class="text" align="right">Size 1: </td>
							<td><input name="size1" type="text" id="size1" class="inputbox"></td>
						</tr>
						
						<tr>
							<td class="text" align="right">Size 2: </td>
							<td><input name="size2" type="text" id="size2" class="inputbox"></td>
						</tr>
						
						<tr>
							<td class="text" align="right">Size 3: </td>
							<td><input name="size3" type="text" id="size3" class="inputbox"></td>
						</tr>
						
						<tr>
							<td class="text" align="right">Size 4: </td>
							<td><input name="size4" type="text" id="size4" class="inputbox"></td>
						</tr>
						
						<tr>
							<td class="text" align="right">Size 5: </td>
							<td><input name="size5" type="text" id="size5" class="inputbox"></td>
						</tr>
						<!--<tr>
							<td class="text" align="right">Price 5: </td>
							<td><input name="price5" type="text" id="price5" class="inputbox" onKeyPress="javascript: return _number();"></td>
						</tr>-->
                        <tr>
							<td class="text" align="right">Color: </td>
							<td><input name="color" type="text" id="color" class="inputbox"></td>
						</tr>
                        <tr>
                          <td class="text" align="right">Stock : </td>
                          <td><input type="text" name="prod_stock" class="inputbox" value="<? echo @$prod_stcok;?>"></td>
                        </tr>
                       <tr>
							<td colspan=2 align=center>
								<!--<input type="submit" name="cmd_cat_submit" class=button value="Add More">-->		
								<input type="submit" name="cmd_cat_submit" class=button value="Done" >								
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