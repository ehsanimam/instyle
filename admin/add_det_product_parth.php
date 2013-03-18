<?
session_start();
include("../common.php");
include('../functionsadmin.php');
/*include 'top.php'; 

if($prod_name=='')
{
    $prod_name=0;
}

if($act=="add")
{
	if($prod_name>0)
	{
		if($part_name!='')
		{
			if($prod_price!='')
			{
				add_prodcut_details_fun($prod_name, $part_name, $prod_price, $prod_disc_price, $prod_desc);
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
		else{$err="Please enter Name";}
	}
	else{$err="Please select Product";}
}

$sql="select * from tblproduct order by prod_id desc limit 1";
$rest=mysql_query($sql)or die("Error in inserting Category");
$lat=mysql_result($rest,0,'prod_name');
if ($flow==1){
$prod_name=mysql_result($rest,0,'prod_id');}

*/
//lets start

/*
$sql="select * from tblproduct";
$r=mysql_query($sql) or die("err 1");
while ($line = mysql_fetch_array($r, MYSQL_ASSOC))
{
$detid = "select det_id from tblproduct_details where prod_id=$line[prod_id]";
$dtid = mysql_query($detid);
$dtid = mysql_result($dtid,0,'det_id');

$sq= "insert into tblproduct_size values (' ',";
$sq .= "'".$line[prod_id]."','".$dtid."','','','','".$line[prod_name]."'";
$sq .= ");";
echo $sq;
$k = mysql_query($sq) or die("WTF");
echo "         Ok<br />";

}
*/
?>

<!--

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	
	<form name="prod_frm" method="post" action="add_det_product.php?act=add">
		<table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
<tr><td align="left">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                     
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>ADD Product Details</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><?=$err;?></td></tr>
						
						<tr>
						  <td width="310" align="right" class="text">Select Product : </td>
						  <td width="470" align="left"><?get_prod_add();?><script>document.prod_frm.prod_name.value="<?=$prod_name;?>"</script></td>
					  </tr>
						<tr>
					    <td width="310" class="text" align="right">Name : </td>
					    <td width="470" align="left"><input type="text" name="part_name" class="inputbox" value="<?echo $part_name;?>" ></td>
				      </tr>
					  <tr>
							<td class="text" align="right">Price : </td>
							<td><span class="text">$</span><input type="text" name="prod_price" class="inputbox" value="<?echo $prod_price;?>" ></td>
						</tr>
      
                        <tr>
							<td class="text" align="right">Discount Price : </td>
							<td><span class="text">$</span><input type="text" name="prod_disc_price" class="inputbox" value="<?echo $prod_disc_price;?>"></td>
						</tr>
						<tr>
							<td class="text" align="right">Description : </td>
							<td>
								<textarea name="prod_desc" rows="5" cols="40"><?echo $prod_desc;?></textarea>
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
-->
<?//include 'footer.php'; ?>