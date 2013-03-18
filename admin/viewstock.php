<?php
ob_start();
session_start();
include("../common.php");

if($_REQUEST['des_id']==''){
$html = '<table cellpadding="0" cellspacing="0" border="1" bordercolor="#CCCCCC" style="border-collapse: collapse" width="77%" align="center">
<Tr align="center">
		<th width=3% class="print">&nbsp;ID&nbsp;</th>
	<th align=left width=11% class="print">Designer Name</th>
	<th align=left width=9% class="print">Style Number</th>
	<th align=left width=4% class="print">Color</th>
	<th align=left width=5% class="print">Size 0</th>
	<th align=left width=5% class="print">Size 2</th>
	<th align=left width=4% class="print">Size 4</th>
	<th align=left width=5% class="print">Size 6</th>
	<th align=left width=5% class="print">Size 8</th>
	<th align=left width=5% class="print">Size 10</th>
	<th align=left width=5% class="print">Size 12</th>
	<th align=left width=5% class="print">Size 14</th>
	<th align=left width=5% class="print">Size 16</th>
	<th align=left width=6% class="print">Size XS</th>
	<th align=left width=5% class="print">Size S</th>
	<th align=left width=5% class="print">Size M</th>
	<th align=left width=5% class="print">Size L</th>
	<th align=left width=5% class="print">Size XL</th>
</tr>';
}else if($_REQUEST['subcat_id']!=''){


	$sqls3 = "select * from designer where des_id='".$_REQUEST['des_id']."'";
	$qrys3=mysql_query($sqls3);
	$rows3=mysql_fetch_array($qrys3);
	$designer_name = $rows3['designer'];
	
	
	$sqls4 = "select * from tblsubcat where subcat_id='".$_REQUEST['subcat_id']."'";
	$qrys4=mysql_query($sqls4);
	$rows4=mysql_fetch_array($qrys4);
	$subcat_name = $rows4['subcat_name'];
	
	
	$html = '<table cellpadding="0" cellspacing="0" border="1" bordercolor="#CCCCCC" style="border-collapse: collapse" width="77%" align="center">
<Tr align="left" style="background-color:#FFFFFF;"><td colspan=17 align=left class="print"><strong>'.$designer_name.'</strong></td></tr><Tr align="left" style="background-color:#FFFFFF;"><td colspan=17 align=left class="print"><strong>'.$subcat_name.'</strong></td></tr><Tr align="center">
	<th width=3% class="print">&nbsp;ID&nbsp;</th>
	<th align=left width=9% class="print">Style Number</th>
	<th align=left width=4% class="print">Color</th>
	<th align=left width=5% class="print">Size 0</th>
	<th align=left width=5% class="print">Size 2</th>
	<th align=left width=4% class="print">Size 4</th>
	<th align=left width=5% class="print">Size 6</th>
	<th align=left width=5% class="print">Size 8</th>
	<th align=left width=5% class="print">Size 10</th>
	<th align=left width=5% class="print">Size 12</th>
	<th align=left width=5% class="print">Size 14</th>
	<th align=left width=5% class="print">Size 16</th>
	<th align=left width=6% class="print">Size XS</th>
	<th align=left width=5% class="print">Size S</th>
	<th align=left width=5% class="print">Size M</th>
	<th align=left width=5% class="print">Size L</th>
	<th align=left width=5% class="print">Size XL</th>
</tr>';


}else{

	$sqls3 = "select * from designer where des_id='".$_REQUEST['des_id']."'";
	$qrys3=mysql_query($sqls3);
	$rows3=mysql_fetch_array($qrys3);
	$designer_name = $rows3['designer'];


$html = '<table cellpadding="0" cellspacing="0" border="1" bordercolor="#CCCCCC" style="border-collapse: collapse" width="77%" align="center">
<Tr align="left" style="background-color:#FFFFFF;"><td colspan=17 align=left class="print"><strong>'.$designer_name.'</strong></td></tr><Tr align="center">
	<th width=3% class="print">&nbsp;ID&nbsp;</th>
	<th align=left width=9% class="print">Style Number</th>
	<th align=left width=4% class="print">Color</th>
	<th align=left width=5% class="print">Size 0</th>
	<th align=left width=5% class="print">Size 2</th>
	<th align=left width=4% class="print">Size 4</th>
	<th align=left width=5% class="print">Size 6</th>
	<th align=left width=5% class="print">Size 8</th>
	<th align=left width=5% class="print">Size 10</th>
	<th align=left width=5% class="print">Size 12</th>
	<th align=left width=5% class="print">Size 14</th>
	<th align=left width=5% class="print">Size 16</th>
	<th align=left width=6% class="print">Size XS</th>
	<th align=left width=5% class="print">Size S</th>
	<th align=left width=5% class="print">Size M</th>
	<th align=left width=5% class="print">Size L</th>
	<th align=left width=5% class="print">Size XL</th>
</tr>';
}		
		if($_REQUEST['des_id']==''){
			$sql1="select * from tbl_stock where des_id!='' and prod_id!='' order by st_id desc";
			$result=mysql_query($sql1);
$num_rows = mysql_num_rows($result);
if($num_rows==0)
{

	$html.='<Tr  height=22 align="left" height=60 style="background-color:#FFFFFF;">
	<td colspan=18 align=center>No Data Found</td></tr>';
}
else
{	
$count=1;
while($rs=mysql_fetch_array($result))
{
	extract($rs);
	if($Gender == 'F') $gen= "Female" ; 
	if($Gender == 'M') $gen= "Male";
	$phone1=$Home_Phone;
	$phone2=$Mobile;
	$emer1=$Emergency1;
	$emer2=$Emergency2;
	$address=$rs['Address'];
	$city=$rs['City'];
	$state=$rs['State'];
	$zip=$rs['PinCode'];
	
	$phone1=($phone1? '(H) '.$phone1:'');
	$phone2=($phone2? '(C) '.$phone2:'');
	 
	$Availabe_Hrs=stripslashes($rs['Availabe_Hrs']);
	
	$sqls1 = "select * from designer where des_id='".$rs['des_id']."'";
	$qrys1=mysql_query($sqls1);
	$rows1=mysql_fetch_array($qrys1);
	$designer = $rows1['designer'];
	
	$sqls = "select * from tbl_product where prod_id='".$rs['prod_id']."'";
	$qrys=mysql_query($sqls);
	$rows=mysql_fetch_array($qrys);
	$prod_no = $rows['prod_no'];
	
	$sqls2 = "select * from tblcolor where color_id='".$rs['cs_id']."'";
	$qrys2=mysql_query($sqls2);
	$rows2=mysql_fetch_array($qrys2);
	$color = $rows2['color_name'];
	
	
if($_REQUEST['des_id']==''){	
	$html.="<Tr  height=30 align='left' style='background-color:#FFFFFF;'>
<td  class='print'>$count</td><td  class='print'>$designer</td><td  align=left class='print'>$prod_no</td><td  align=left class=print>$color</td>
<td align=left class='print'>$rs[size_0]</td><td align=left class='print'>$rs[size_2]</td><td align=left class=print>$rs[size_4]</td><td align=left class=print>$rs[size_6]</td><td align=left class=print>$rs[size_8]</td><td align=left class=print>$rs[size_10]</td><td class=print>$rs[size_12]</td><td class=print>$rs[size_14]</td><td class=print>$rs[size_16]</td><td class=print>$rs[size_xs]</td><td class=print>$rs[size_s]</td><td class=print>$rs[size_m]</td><td class=print>$rs[size_l]</td><td class=print>$rs[size_xl]</td></tr>";

}else{
$html.="<Tr  height=30 align='left' style='background-color:#FFFFFF;'>
<td  class='print'>$count</td><td  align=left class='print'>$prod_no</td><td  align=left class=print>$color</td>
<td align=left class='print'>$rs[size_0]</td><td align=left class='print'>$rs[size_2]</td><td align=left class=print>$rs[size_4]</td><td align=left class=print>$rs[size_6]</td><td align=left class=print>$rs[size_8]</td><td align=left class=print>$rs[size_10]</td><td class=print>$rs[size_12]</td><td class=print>$rs[size_14]</td><td class=print>$rs[size_16]</td><td class=print>$rs[size_xs]</td><td class=print>$rs[size_s]</td><td class=print>$rs[size_m]</td><td class=print>$rs[size_l]</td><td class=print>$rs[size_xl]</td></tr>";
}
	$count++;
	}
}

$html.='</table>';
		}else if($_REQUEST['subcat_id']!=''){
		
		
		$subcat_qry="select * from tbl_product where subcat_id='".$_REQUEST['subcat_id']."'";
		$subcat_res=mysql_query($subcat_qry);
		
$num_rows = mysql_num_rows($subcat_res);
if($num_rows==0)
{

	$html.='<Tr  height=22 align="left" height=60 style="background-color:#FFFFFF;">
	<td colspan=18 align=center>No Data Found</td></tr>';
}
else
{	
$count=1;
while($subcat_rec=mysql_fetch_array($subcat_res)){

        $colornames=explode(",",$subcat_rec['colors']); 
		
		foreach($colornames as $col){
		
		$sql1="select * from tbl_stock where des_id='".$_REQUEST['des_id']."' and cs_id='".$col."' and prod_id='".$subcat_rec['prod_id']."' order by st_id desc";
		$result=mysql_query($sql1);
		$rs=mysql_fetch_array($result);

	extract($rs);
	if($Gender == 'F') $gen= "Female" ; 
	if($Gender == 'M') $gen= "Male";
	$phone1=$Home_Phone;
	$phone2=$Mobile;
	$emer1=$Emergency1;
	$emer2=$Emergency2;
	$address=$rs['Address'];
	$city=$rs['City'];
	$state=$rs['State'];
	$zip=$rs['PinCode'];
	
	$phone1=($phone1? '(H) '.$phone1:'');
	$phone2=($phone2? '(C) '.$phone2:'');
	 
	$Availabe_Hrs=stripslashes($rs['Availabe_Hrs']);
	
	$sqls1 = "select * from designer where des_id='".$rs['des_id']."'";
	$qrys1=mysql_query($sqls1);
	$rows1=mysql_fetch_array($qrys1);
	$designer = $rows1['designer'];
	
	$sqls = "select * from tbl_product where prod_id='".$rs['prod_id']."'";
	$qrys=mysql_query($sqls);
	$rows=mysql_fetch_array($qrys);
	$prod_no = $rows['prod_no'];
	
	$sqls2 = "select * from tblcolor where color_id='".$rs['cs_id']."'";
	$qrys2=mysql_query($sqls2);
	$rows2=mysql_fetch_array($qrys2);
	$color = $rows2['color_name'];
	
	
if($_REQUEST['des_id']==''){	
	$html.="<Tr  height=30 align='left' style='background-color:#FFFFFF;'>
<td  class='print'>$count</td><td  class='print'>$designer</td><td  align=left class='print'>$prod_no</td><td  align=left class=print>$color</td>
<td align=left class='print'>$rs[size_0]</td><td align=left class='print'>$rs[size_2]</td><td align=left class=print>$rs[size_4]</td><td align=left class=print>$rs[size_6]</td><td align=left class=print>$rs[size_8]</td><td align=left class=print>$rs[size_10]</td><td class=print>$rs[size_12]</td><td class=print>$rs[size_14]</td><td class=print>$rs[size_16]</td><td class=print>$rs[size_xs]</td><td class=print>$rs[size_s]</td><td class=print>$rs[size_m]</td><td class=print>$rs[size_l]</td><td class=print>$rs[size_xl]</td></tr>";

}else{
$html.="<Tr  height=30 align='left' style='background-color:#FFFFFF;'>
<td  class='print'>$count</td><td  align=left class='print'>$prod_no</td><td  align=left class=print>$color</td>
<td align=left class='print'>$rs[size_0]</td><td align=left class='print'>$rs[size_2]</td><td align=left class=print>$rs[size_4]</td><td align=left class=print>$rs[size_6]</td><td align=left class=print>$rs[size_8]</td><td align=left class=print>$rs[size_10]</td><td class=print>$rs[size_12]</td><td class=print>$rs[size_14]</td><td class=print>$rs[size_16]</td><td class=print>$rs[size_xs]</td><td class=print>$rs[size_s]</td><td class=print>$rs[size_m]</td><td class=print>$rs[size_l]</td><td class=print>$rs[size_xl]</td></tr>";
}
	$count++;
	}
}
}
$html.='</table>';		
		
		
		
		
		
		
		}else{
		
		$sql1="select * from tbl_stock where des_id='".$_REQUEST['des_id']."' and prod_id!='' order by st_id desc";
		$result=mysql_query($sql1);
$num_rows = mysql_num_rows($result);
if($num_rows==0)
{

	$html.='<Tr  height=22 align="left" height=60 style="background-color:#FFFFFF;">
	<td colspan=18 align=center>No Data Found</td></tr>';
}
else
{	
$count=1;
while($rs=mysql_fetch_array($result))
{
	extract($rs);
	if($Gender == 'F') $gen= "Female" ; 
	if($Gender == 'M') $gen= "Male";
	$phone1=$Home_Phone;
	$phone2=$Mobile;
	$emer1=$Emergency1;
	$emer2=$Emergency2;
	$address=$rs['Address'];
	$city=$rs['City'];
	$state=$rs['State'];
	$zip=$rs['PinCode'];
	
	$phone1=($phone1? '(H) '.$phone1:'');
	$phone2=($phone2? '(C) '.$phone2:'');
	 
	$Availabe_Hrs=stripslashes($rs['Availabe_Hrs']);
	
	$sqls1 = "select * from designer where des_id='".$rs['des_id']."'";
	$qrys1=mysql_query($sqls1);
	$rows1=mysql_fetch_array($qrys1);
	$designer = $rows1['designer'];
	
	$sqls = "select * from tbl_product where prod_id='".$rs['prod_id']."'";
	$qrys=mysql_query($sqls);
	$rows=mysql_fetch_array($qrys);
	$prod_no = $rows['prod_no'];
	
	$sqls2 = "select * from tblcolor where color_id='".$rs['cs_id']."'";
	$qrys2=mysql_query($sqls2);
	$rows2=mysql_fetch_array($qrys2);
	$color = $rows2['color_name'];
	
	
if($_REQUEST['des_id']==''){	
	$html.="<Tr  height=30 align='left' style='background-color:#FFFFFF;'>
<td  class='print'>$count</td><td  class='print'>$designer</td><td  align=left class='print'>$prod_no</td><td  align=left class=print>$color</td>
<td align=left class='print'>$rs[size_0]</td><td align=left class='print'>$rs[size_2]</td><td align=left class=print>$rs[size_4]</td><td align=left class=print>$rs[size_6]</td><td align=left class=print>$rs[size_8]</td><td align=left class=print>$rs[size_10]</td><td class=print>$rs[size_12]</td><td class=print>$rs[size_14]</td><td class=print>$rs[size_16]</td><td class=print>$rs[size_xs]</td><td class=print>$rs[size_s]</td><td class=print>$rs[size_m]</td><td class=print>$rs[size_l]</td><td class=print>$rs[size_xl]</td></tr>";

}else{
$html.="<Tr  height=30 align='left' style='background-color:#FFFFFF;'>
<td  class='print'>$count</td><td  align=left class='print'>$prod_no</td><td  align=left class=print>$color</td>
<td align=left class='print'>$rs[size_0]</td><td align=left class='print'>$rs[size_2]</td><td align=left class=print>$rs[size_4]</td><td align=left class=print>$rs[size_6]</td><td align=left class=print>$rs[size_8]</td><td align=left class=print>$rs[size_10]</td><td class=print>$rs[size_12]</td><td class=print>$rs[size_14]</td><td class=print>$rs[size_16]</td><td class=print>$rs[size_xs]</td><td class=print>$rs[size_s]</td><td class=print>$rs[size_m]</td><td class=print>$rs[size_l]</td><td class=print>$rs[size_xl]</td></tr>";
}
	$count++;
	}
}

$html.='</table>';
		
		}
		
	

$fileName = 'StockPrintexcel.xls';

header('Pragma: public');
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");                  // Date in the past   
header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');     // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0');    // HTTP/1.1
header ("Pragma: no-cache");
header("Expires: 0");
header('Content-Transfer-Encoding: none');
header('Content-Type: application/vnd.ms-excel;');                 // This should work for IE & Opera
header("Content-type: application/x-msexcel");                    // This should work for the rest
header('Content-Disposition: attachment; filename="'.$fileName.'"'); 

//readfile($export_file);
//echo $tsv;
echo $html;

?>
