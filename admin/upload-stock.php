<?php
include("../common.php");
include('../functionsadmin.php');
include('security.php');
include 'top.php'; 
if($_GET['msg'] == 1){
	$msg = "Stock has been successfully uploaded";
	$msg .= '<span style="color:#333333;font-weight:normal;">'.$GLOBALS["affected_rows"].'<span>';
}
if($_GET['msg'] == 2){
	$msg = "Your Style#/Color is not matched with according to your products";
}

if(empty($_POST['cmd_cat_submit'])==false){

	$strFile1 = strtolower($_FILES["csv_"]["name"]);
	$strTempFile1 = $_FILES["csv_"]["tmp_name"];	
	move_uploaded_file($strTempFile1,"csv/".$strFile1);
	echo "<script>window.location.href='stock_process.php?file=$strFile1'</script>";
	
}
?>
<script>
function submit_form()
{
    document.prod_frm.method="post";
    document.prod_frm.action="<?php echo $_SERVER['PHP_SELF'];?>";
    document.prod_frm.submit();
    
}

function _check(){
var file_=window.document.frm.csv_.value;
	
	if(file_!="") {
		var ext=file_.substr(file_.lastIndexOf(".")).toLowerCase();		
		if(ext == '.csv') {
			return true;
		}else{
			alert(" Please upload only .CSV file ! ");			
			return false;
		}
	}else{
		alert(' Upload path should not empty ! ');		
		return false;
	}
}	
</script>
<link href="style.css" rel="stylesheet" type=text/css>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="620" class="tab" valign="top" align="center">
	<br><br><br><br>
	
	 <form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?act=add" enctype="MULTIPART/FORM-data" onsubmit="return  _check();">
		<table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
		
<tr><td align="left">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                      <!--DWLayoutTable-->
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>ADD/UPDATE STOCK </h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><?php echo $msg;?></td></tr>						
						<tr>
							<td width="310" class="text" align="right">Upload CSV: </td>
							<td width="470"><input type="file" name="csv_" id="csv_"  ></td>							
						</tr>
      							 
				      <tr>
							<td colspan=2 align=center>
								<input type="submit" name="cmd_cat_submit" class="button" value=" Upload ">							</td>
					  </tr>
					</table>
</td></tr>
</table>
	</form>
	
	
	</td>
</tr>
</table>
<?php $GLOBALS["message"]="";?>
<?php include 'footer.php'; ?>