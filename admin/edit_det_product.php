<?
session_start();
include("../common.php");
include('../functionsadmin.php');
include 'top.php'; 
if(@$prod_name==''){$prod_name=0;}
//if(@$prod_det_name==''){$prod_det_name=0;}
if(@$action=="editit")
{
	
	echo $sel="update tblproduct_details set p_name='$pr_name', price='$prod_price', discount='$prod_disc_price', p_desc='$prod_desc' where prod_id='$update_id' ";
	mysql_query($sel);
	if(@$flg!='1')
	{
		echo "
             <script>
                location.href='edit_det_product.php'
             </script>
             ";
	}
	else
	{
		echo "
             <script>
                location.href='edit_par_product.php?act=show&prod_id=$prod_name&mode=e'
             </script>
             ";
	}
}
if(@$prod_id!='')
{
	$prod_name=$prod_id;
	$prod_no = $prod_id;
	$flg=1;	
}

 if($prod_name != ''){
	$PID = $prod_name;
  } 
   if($prod_no != ''){
	$PID = $prod_no;
  } 
  
  if($PID != ''){
  	echo "<script>window.location.href='edit_par_product.php?act=show&prod_id=".$PID."&mode=e'</script>";
  }
?>
<title>Instyle New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function submit_form()
{
    document.prod_frm.method="post";
    document.prod_frm.action="edit_det_product.php";
	//document.prod_frm.action="edit_par_product.php?act=show&prod_id='"+<?php echo $PID;?>+"'&mode=e";
    document.prod_frm.submit();
    
}
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	
	<form name="prod_frm" method="post" action="edit_det_product.php?action=editit">
		<table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
<tr><td align="left">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                      <!--DWLayoutTable-->
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>Edit Product Details</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><?=@$err;?><input type="hidden" name="flg" value="<?=@$flg;?>"></td></tr>
						
					  <tr>
						  <td width="310" align="right" class="text">Select Product : </td>
						  <td width="470" align="left"><? get_prod_submit($prod_no);?><script>document.prod_frm.prod_name.value="<?=$prod_name;?>"</script></td>
					  </tr>
					  <tr>
					  	<td class="text" align="right">Select STYLE NUMBER: </td>
					    <td align="left"><? get_prod_no();?><script>document.prod_frm.prod_no.value="<?=$prod_no;?>"</script><input type="hidden" name="act1" value="show"></td>
				      </tr>
					 
					  <? if(@$act1=="show") {
					 
					  $sel="select * from tblproduct_details where prod_id='$PID'";
					  $res=mysql_query($sel);
					  $row=mysql_fetch_array($res);
					  $u_id= $row['prod_id'];
					  $rowid=$row['det_id'];
					  $pr_name=$row['p_name'];
					  $prod_price=$row['price'];
					  $prod_disc_price=$row['discount'];
					  $prod_desc=$row['p_desc'];
					  ?>
					  <tr>
					    
                  <td class="text" align="right">Product # : </td>
					    <td><input type="text" name="pr_name" class="inputbox" value="<? echo $pr_name;?>" ></td>
				      </tr>
					  <tr>
							<td class="text" align="right">MSRP : </td>
							<td><span class="text">$</span><input type="text" name="prod_price" class="inputbox" value="<? echo $prod_price;?>" ></td>
						</tr>
      
                        <tr>
							<td class="text" align="right">Net Designer Price : </td>
							<td><span class="text">$</span><input type="text" name="prod_disc_price" class="inputbox" value="<? echo $prod_disc_price;?>"></td>
						</tr>
						<tr>
							<td class="text" align="right">Description : </td>
							<td>
								<textarea name="prod_desc" rows="5" cols="40"><? echo $prod_desc;?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan=2 align=center><input type="hidden" name="rowid" value="<?=@$rowid;?>">
								<input type="hidden" name="update_id" value="<?=@$u_id;?>">
								<input type="submit" name="cmd_cat_submit" class=button value="Update">								
							</td>
						</tr>
						<? }?>
					</table>
</td></tr>
</table>
	</form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>