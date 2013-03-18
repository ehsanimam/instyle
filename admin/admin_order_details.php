<?
session_start();
include("../common.php");
include('../functionsadmin.php');
include 'top.php'; 

if($act=="del")
{
	$sql="delete from tblcart where cart_id='$cart_id'";
	mysql_query($sql);
	$sql="delete from tblbuyer_det where order_id='$trans_id'";
	mysql_query($sql);
	$sql="delete from tblorder where order_id='$trans_id'";
	mysql_query($sql);
	echo "
	     <script>
			 location.href='order_display.php'
		 </script>
	     ";
}
$sql="select * from tblorder where order_id='$transaction_id'";

$or_rs=mysql_query($sql);
$or_row=mysql_fetch_array($or_rs);
$cart_id = $or_row['cart_id'];
$trans_id=$or_row[order_id];
?>
<script>
function back_to_display()
{
	location.href='order_display.php';
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle" bgcolor=eeeeee>
	
	
	
	
	<?
							  $sql="select * from tblbuyer_det,tblshipping_det where tblshipping_det.buyer_id = tblbuyer_det.buyer_id and tblbuyer_det.buyer_id=".$or_row['buyer_id']." and tblshipping_det.session_id = '".$cart_id ."'";
							  $buy_rs=mysql_query($sql);
							  $buy_row=mysql_fetch_array($buy_rs);
							 
							 $ccsql="select * from tblccdetails where buyer_id=".$or_row['buyer_id']." and sessionid = '".$cart_id ."'";
							 $cc_rs=mysql_query($ccsql);
							  $cc_row=mysql_fetch_array($cc_rs);
							
							   
							  ?>
          <form name="news_disp_frm" method="post" action="admin_order_details.php?act=del">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr valign="top" class="bodytext">
					<td align="left">
						<table border="0" cellpadding="5" width=100% bgcolor=eeeeee>
						  <!--DWLayoutTable-->
							<tr>
								<td width=362 align="right" class="text">Invoice No :</td>
								<td colspan="4" valign="middle" class="text" ><?echo $or_row[order_id];?></td>
							</tr>
							<tr>
								<td width=362 align="right" class="text">Shipping Date :</td>
								<td colspan="4" valign="middle" class="text" ><? if($buy_row[shipping_date])echo $buy_row[shipping_date]; else echo "-";?>								  &nbsp; &nbsp;[&nbsp;<a href="#" class="pagelinks" onClick="javascript:window.open('editdate.php?shipdate=<?=$buy_row[shipping_date]?>&id=<?=$buy_row[shipping_id];?>&orderid=<?=$transaction_id ?>&cart_id=<?=$cart_id?>','','height=200 width=500 scrollbars')">Edit</a>&nbsp;]</td>
						    </tr>
							<tr>
								<td width=362 align="right" class="text">Order Date :</b></td>
								<td colspan="4" valign="middle" class="text" ><?echo $or_row[order_date];?></td>
						    </tr>

							<tr>
								<td width=362 align="right" class="text" >Quantity :</td>
								<td colspan="4" valign="middle" class="text" ><?echo $or_row[qty];?></td>
						    </tr>
							<tr>
								<td width=362 align="right" class="text" >Amount :</td>
								<td colspan="4" valign="middle" class="text">$<?echo $or_row[amount];?></td>
						    </tr>
							<input type="hidden" name="trans_id" value="<?echo $trans_id;?>">
							<input type="hidden" name="cart_id" value="<?echo $cart_id;?>">
							<input type="hidden" name="order_no" value="<?echo $order_no;?>">


							

							<tr>
								<td width=362 align="right" class="text" >Name :</td>
								<td colspan="4" valign="middle" class="text"><? echo $buy_row[fname]." ".$buy_row[lname];?></td>
						    </tr>
							<tr>
								<td width=362 align="right" class="text" >Email :</td>
								<td colspan="4" valign="middle" class="text"><? echo $buy_row[email];?></td>
						    </tr>
							<tr>
								<td width=362 align="right" class="text" >Country :</td>
								<td colspan="4" valign="middle" class="text" ><? echo return_country($buy_row[country]);?></td>
						    </tr>
							<tr>
								<td width=362 align="right" class="text" >Phone No. :</td>
								<td colspan="4" valign="middle" class="text"><? echo $buy_row[phone];?></td>
						    </tr>
       
                            <tr>
								<td width=362 align="right" class="text" >Shipping Name :</td>
								<td colspan="4" valign="middle" class="text"><?echo $buy_row[ship_fname]." ".$buy_row[ship_lname];?></td>
						    </tr>
							<tr>
								<td width=362 align="right" class="text" >Shipping Email :</td>
								<td colspan="4" valign="middle" class="text"><?echo $buy_row[ship_email];?></td>
						    </tr>
                            <tr>
								<td width=362 align="right" class="text" >Shipping Address :</td>
								<td colspan="4" valign="middle" class="text"><?echo $buy_row[ship_add1]." ".$buy_row[ship_add2];?></td>
						    </tr>
                             <tr>
								<td width=362 align="right" class="text" >Shipping City :</td>
								<td colspan="4" valign="middle" class="text"><?echo $buy_row[ship_city];?></td>
						    </tr>
                            <tr>
								<td width=362 align="right" class="text" >Shipping state :</td>
								<td colspan="4" valign="middle" class="text"><?echo return_state($buy_row[ship_state]);?></td>
						    </tr>
       
                            <tr>
								<td width=362 align="right" class="text" >Shipping Zip :</td>
								<td colspan="4" valign="middle" class="text"><?echo $buy_row[ship_zip];?></td>
						    </tr>

							<tr>
								<td width=362 align="right" class="text" >Shipping Country :</td>
								<td colspan="4" valign="middle" class="text" ><?echo return_country($buy_row[ship_country]);?></td>
						    </tr>
							<tr>
								<td width=362 align="right" class="text" >Shipping Phone No. :</td>
								<td colspan="4" valign="middle" class="text"><?echo $buy_row[phone];?></td>
						    </tr>
							<tr>
								<td class="text"  bgcolor="cccccc" colspan="5"><b>Payment Details</b></td>
							</tr>
							 <tr>
								<td width=362 align="right" class="text" > Name on the Card :</td>
								<td colspan="4" valign="middle" class="text"><?echo $cc_row[cname];?></td>
						    </tr>
                            <tr>
								<td width=362 align="right" class="text" >Credit Card Number :</td>
								<td colspan="4" valign="middle" class="text"><?echo $cc_row[ccno];?></td>
						    </tr>
       
                            <tr>
								<td width=362 align="right" class="text" >Expiry Date :</td>
								<td colspan="4" valign="middle" class="text"><?echo $cc_row[ccmonth]." ".$cc_row[ccyear];?></td>
						    </tr>

							<tr>
								<td width=362 align="right" class="text" >Security Code :</td>
								<td colspan="4" valign="middle" class="text" ><?echo $cc_row[ccode];?></td>
						    </tr>
							<tr>
								<td width=362 align="right" class="text" >Credit Card Type :</td>
								<td colspan="4" valign="middle" class="text"><?echo $cc_row[cctype];?></td>
						    </tr>

							<tr bgcolor=cccccc>
							  <td class="text" width="362"><b>Product Name</b></td>
							  <td width="230" class="text" align="center"><b>Size, Color</b></td>
							  <td width="65" class="text" align="center"><b>Qty</b></td>
							  <td width="79" align="right" class="text"><b>Price</b></td>
							  <td width="95" align="right" class="text"><b>Amount</b></td>
							</tr>
							<?
							$counter=0;
							//$sql="select * from tblcart,tblproduct where tblcart.prod_id=tblproduct.prod_id and tblcart.cart_id='$cart_id' order by prod_name";
							$sql="select discount,size_cartid,color_cartid,p_name,prod_name,cart_qty,price from tblcart,tblproduct_details,tblproduct where tblproduct.prod_id = tblproduct_details.prod_id and tblcart.prod_id = tblproduct_details.det_id and tblcart.cart_id='$cart_id' order by prod_name"; 
							
							$pr_rs=mysql_query($sql);
							while($pr_row=mysql_fetch_array($pr_rs))
							{
                                if($pr_row[discount]!=0)
                                {
                                    $price=$pr_row[price] - $pr_row[discount];
                                }
                                else
                                {
                                    $price=$pr_row[price];
                                }
								$amount=$pr_row[cart_qty]*$price;
								$tot_amount = $tot_amount + $amount;
        
        
							?>
							<tr >
								<td class="text"><?echo $pr_row[prod_name]."-".$pr_row[p_name];?></td>
								<td class="text" align="center"><?get_sizename($pr_row[size_cartid]);?>, <?get_colorname($pr_row[color_cartid]);?></td>
								<td class="text" align="center"><?echo $pr_row[cart_qty]?></td>
								<td class="text" align="right">$<?echo $price;?></td>
								<td class="text" align="right">$<?echo $amount;?></td>
							</tr>
							<?}?>
							<tr >
								<td class="text" colspan="4" align="right"><b>Total:</b></td>
								<td class="text" align="right">$<?echo $tot_amount;?></td>
							</tr>
							
							<? if($option=="d"){?>
							<tr>
							  <td colspan="5" align="center"><b><font color="aa0000">Do you want to Delete this order?</font></b></td>
							</tr>
							<tr>
							  <td colspan="5" align="center">
							  <input type="submit" name="btn_yes" class=button value=" Yes ">
							  <input type="button" name="btn_No" class=button value=" No " onClick="back_to_display();">
							  </td>
							</tr>
							<?}else{?>
							<tr>
							  <td colspan="5" align="center">
							  <input type="button" name="btn_back" value="Back to Order List" class=button onClick="back_to_display();">
							  </td>
							</tr>
							<?}?>
						</table>

					</td>
				</tr>
			</table>
            </form>
	
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>