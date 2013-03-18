<?php
session_start();
include("../common.php");
include('../functionsadmin.php');
include 'top.php'; 
$flg=0;
if(@$prod_name=='')
{
    $prod_name=0;
}
if(@$prod_det_name=='')
{
    $prod_det_name=0;
}

if(@$eid!="")
{
	$sel="delete from tbl_dimensions where d_id='$eid' ";
	mysql_query($sel);
	echo "
             <script>
                location.href='edit_dimension_price.php'
             </script>
             ";
}
if(@$prod_id!='')
{
	$prod_name=$prod_id;	
}
	if(empty($_POST['ok']) == false){
	 $sql_ = "select * from tbl_dimensions where prod_id='$prod_name' and part_id='$prod_det_name'";
	 $res_ = mysql_query($sql_);
		while($row_ = mysql_fetch_array($res_)) {
		$v = $row_['d_id'];
		$text_value = $_POST["seq_$v"];
		$check_ = is_numeric($text_value)."<br>";
		if($check_ == 1){
			$sql_seq = "update tbl_dimensions set seque='".$_POST["seq_$v"]."' where d_id='".$v."'";
			mysql_query($sql_seq);	
		 }			
		}
	}
?>
<script>
function submit_form()
{
    document.prod_frm.method="post";
    document.prod_frm.action="edit_dimension_price.php";
    document.prod_frm.submit();
    
}

function _key(){ 
		if(event.keyCode < 48 || event.keyCode > 57) {
			event.returnValue = false;
		}
	}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	
	<form name="prod_frm" method="post" action="edit_dimension_price.php?action=editit">
		<table width=98% border="1" bordercolor="cccccc" cellspacing="0" cellpadding="0">
<tr><td align="left">
                    <table width=100% align=center cellspacing="2" cellpadding="2">
                      <!--DWLayoutTable-->
                    <tr bgcolor=cccccc><td align=center colspan=3><h1>Edit Dimensions</h1></td></tr>
                    <tr><td align=center colspan=3 class="error"><?=@$err;?></td></tr>
						<tr>
						  <td width="437" align="right" class="text">Select Product : </td>
						  <td width="482" colspan="2" align="left"><?php get_prod_submit();?>
					      <script>document.prod_frm.prod_name.value="<?=$prod_name;?>"</script></td>
					  </tr>
					  <tr>
					    
                  <td class="text" align="right">Select# : </td>
					    <td colspan="2" align="left"><?php get_prod_det_submit($prod_name);?><script>document.prod_frm.prod_det_name.value="<?=$prod_det_name;?>"</script><input type="hidden" name="act1" value="show"></td>
				      </tr>
					  <?php if(@$act1=="show") {
					  $sel="select * from tbl_dimensions where prod_id='$prod_name' and part_id='$prod_det_name' order by seque asc";
					  $res=mysql_query($sel);
					  $num=mysql_num_rows($res);
					  ?>
					  <tr>
							<td colspan="3" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1">
							  <!--DWLayoutTable-->
							  <tr bgcolor=cccccc>
							  	<td width="14%" align="center" valign="middle"><h1>Sequence</h1></td>
								<td width="35%" align="center" valign="middle"><h1>Size</h1></td>
							    <td width="21%" align="center" valign="middle"><h1>Price</h1></td>
							    <td width="30%" align="center" valign="middle">&nbsp;</td>
							  </tr>
							  <? while($row=mysql_fetch_array($res))
	    						{
									$det=$row['d_id'];
							  ?>
							  <tr bgcolor='eeeeee' onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='eeeeee'">							  	
							    <td align="center" valign="middle" class="text"><input type="text" name="seq_<?php echo $row['d_id'];?>" id="seq_<?php echo $row['d_id'];?>" value="<?=$row['seque'];?>" size="2" onkeypress="_key();" maxlength="2" /></td>
								<td align="center" valign="middle" class="text"><?=$row['size'];?></td>
							    <td align="center" valign="middle" class="text">$<?=$row['price'];?></td>
							    <td align="center" valign="middle">
								<span class="text">[</span><a href="#" class="pagelinks" onclick="javascript:window.open('edit_dimension_popup.php?eid=<?=@$det;?>','','height=300 width=400')">edit</a><span class="text">]</span>
								<span class="text">[</span><a href="<?php echo $_SERVER['PHP_SELF'];?>?eid=<?=@$det;?>" class="pagelinks">delete</a><span class="text">]</span></td>
						      </tr>
							  <? }?>							  
						    </table></td>
					  </tr>
						<? }?>						
			  </table>
</td></tr>
<tr>
	<td style="padding-left:15px;" align="left"><input type="submit" value=" Submit Sequence " name="ok" <?php if($num <= 0){ echo "disabled";} ?> /></td>
</tr>
</table>
	<input type="hidden" name="partID" value="<?php echo $prod_det_name;?>" />
	<input type="hidden" name="pID" value="<?php echo $prod_name;?>" />
	</form>
	
	
	</td>
</tr>
</table>
<?php include 'footer.php'; ?>