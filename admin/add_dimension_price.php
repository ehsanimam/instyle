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
if(@$size_name=='')
{
    $size_name=0;
}

if(@$act=="add")
{
/*echo "Product name=".$prod_name;
echo "part_name=".$part_name;
echo "size_name=".$size_name;
echo "price=".$price;
exit();*/

	if(@$prod_name>0)
	{
		if(@$part_name>0)
		{
			if($size_name>0 || $size_name!="")
			{
			if($price!='')
			{
				
						$sql="insert into tbl_dimensions(`prod_id`,`part_id`,`size`,`price`)values('$prod_name','$part_name','$size_name','$price')";
						mysql_query($sql);
						
						if($cmd_cat_submit == "Done")
						echo "
             			<script>
                			location.href='add_dimension_price.php?flow=2'
             			</script>
             			";
						else
						echo "
             			<script>
                			location.href='add_dimension_price.php?flow=1'
             			</script>
             			";
					}
				else{$err="Please Enter Price";}	
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
    document.prod_frm.action="add_dimension_price.php";
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
	
	
	<form name="prod_frm" method="post" action="add_dimension_price.php?act=add">
		<table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
<tr><td align="left">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                      <!--DWLayoutTable-->
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>ADD Dimensions</h1></td></tr>
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
                  		  <td align="right" class="text">Select Size #: </td>
						  <td align="left"><?get_add_Dsize($part_name);?><script>document.prod_frm.size_name.value="<?=$size_name;?>"</script></td>
					  </tr>
						<!--<tr>
							<td class="text" align="right">Price 5: </td>
							<td><input name="price5" type="text" id="price5" class="inputbox" onKeyPress="javascript: return _number();"></td>
						</tr>-->
                        <tr>
                          <td class="text" align="right">Price : </td>
                          <td><input type="text" name="price" class="inputbox" value="<? echo @$price;?>"></td>
                        </tr>
                       <tr>
							<td colspan=2 align=center>
								<!--<input type="submit" name="cmd_cat_submit" class=button value="Add More">-->		
								<input type="submit" name="cmd_cat_submit" class=button value="Done" >							</td>
						</tr>
					</table>
</td></tr>
</table>
	</form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>