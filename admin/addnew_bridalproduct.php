<?php
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php"); 
$GLOBALS['message']='';
if(@$subcat=='')
{
    $subcat=0;
}
if(@$subcat_manu=='')
{
    $subcat_manu=0;
}

if(@$subcat_trend=='')
{
    $subcat_trend=0;
}

if(@$trend=='')
{
    $trend=0;
}

if(@$act=="add")
{
$color= implode(",",$_POST['cs']);
$color_name=array();
foreach($_POST['cs'] as $col){

$getpic = mysql_query("SELECT  * FROM  tblcolor  WHERE color_id='".$col."'") or die(mysql_error());
$getres=mysql_fetch_array($getpic);
array_push($color_name,$getres[color_code]);
}
$colorname= implode(",",$color_name);


      $check_prodid=mysql_query("select prod_no from tbl_product where prod_no='".$prod_no."'") or die(mysql_error());
	  $num_prod=mysql_num_rows($check_prodid);

      if($num_prod==0){
	  
	  $cat=22;

   		$prod_return=admin_addnew_product($prod_name,$prod_no, $cat, $subcat,$subsubcat,$add_date,$catalogue_price, $less_discount,$prod_desc,$_REQUEST['designer'],$color,$colorname);
		$prod_id = mysql_insert_id();
		
		if($prod_return==0)
		{
		
				$GLOBALS['message']=$GLOBALS['message']."Add new product complete"."<br>";	
				echo "<script type=\"text/javascript\">
									<!--
									window.location = \"edit_new_par_bridalimages.php?prod_id=".$prod_id."\"
									//-->
									</script>
								";	
		}
		
		}else{
$msg_err=1;

}	
	
}
include 'top.php'; 
?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function submit_form()
{
    document.prod_frm.method="post";
    document.prod_frm.action="addnew_bridalproduct.php";
    document.prod_frm.submit();
    
}
</script>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
	$('#submit').click(function() {
	  $('#loading').show();
	});
});
</script>
<script>
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
	}
	
	
	
	function getCs(strURL) {		
		
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('csdiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
				
	}
</script>
   <link type="text/css" href="js/datePicker.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataPicker.js"></script>
	<script type="text/javascript" src="js/date.js"></script>
    

	<script type="text/javascript">
	$(function()
{
	$('.date-pick').datePicker()
	$('#add_date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				//$('#add_date').dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
	
});
	</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="620" class="tab" valign="top" align="center">
	
	
	 <form name="prod_frm" method="post" action="addnew_bridalproduct.php?act=add" enctype="multipart/form-data">
		<table width=90% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
<tr><td align="left">
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                <!--DWLayoutTable-->
                <tr bgcolor=cccccc>
                  <td align=center colspan=2><h1>ADD Product</h1></td>
                </tr>
                <?php if($msg_err==1){?>
                <tr>
                  <td align=center colspan=2 class="error">This style number already exists.</td>
                </tr>
                <?php } ?>
                <tr>
                  <td align=center colspan=2 class="error"><? echo @$GLOBALS["message"]?></td>
                </tr>
                <tr> 
                  <td class="text" align="right">Product name : </td>
                  <td><input type="text" name="prod_name" class="inputbox" value="<? echo @$prod_name;?>"></td>
                </tr>
				<tr> 
                  <td class="text" align="right">Style Number : </td>
                  <td><input type="text" name="prod_no" class="inputbox" value="<? echo @$prod_no;?>"></td>
                </tr>
                <tr> 
                  <td width="310" class="text" align="right">Category name : </td>
                  <td width="470"><input type="text" class="inputbox" value="Bridal" readonly></td>
                </tr>
                <tr> 
                  <td class="text" align="right">SubCategory name : </td>
                  <td> 
                    <? @get_subcategories1();?>
                    <script>document.prod_frm.subcat.value="<?=$subcat;?>"</script>               </td>
                </tr>
                <tr> 
                  <td class="text" align="right"> Sub SubCategory name : </td>
                  <td> 
                    <? @get_subsubcategories($subcat);?>
                    <script>document.prod_frm.subsubcat.value="<?=$subsubcat;?>"</script>                  </td>
                </tr>
				<tr> 
                  <td class="text" align="right">Designer : </td>
                  <td> 
				  <select name="designer"  class='combobig'>
				  	<option value=""> - select designer - </option>
                    <?php
					$get_designer = @mysql_query("select * from designer where catid='22'");
					if(mysql_num_rows($get_designer) > 0) {
						while($row = mysql_fetch_array($get_designer)) {
							?>
							<option value="<?=$row['des_id']?>"><?=$row['designer']?></option>
							<?
						}
					}
					?>
				   </select>				  </td>
                </tr>
                <tr> 
                  <td class="text" align="right">Date : </td>
                  <td align="left"><input name="add_date" id="add_date" class="date-pick" value="<? echo @$add_date;?>"/> <span class="text">(format:mm/dd/yyyy)</span>
                    </td>
                </tr>
				<tr> 
                  <td class="text" align="right">Our sale price : </td>
                  <td><input type="text" name="catalogue_price" class="inputbox" value="<? echo @$catalogue_price;?>"></td>
                </tr>
				<tr> 
                  <td class="text" align="right">Retail price  : </td>
                  <td><input type="text" name="less_discount" class="inputbox" value="<? echo @$less_discount;?>"></td>
                </tr>
				<!--<tr> 
                  <td class="text" align="right">Shipping Cost : </td>
                  <td><input type="text" name="shipping_cost" class="inputbox" value="<? echo @$shipping_cost;?>"></td>
                </tr>-->
                 
				<tr > 
                  <td class="text" align="right">Color : </td>
                  <td align="left" class="text"><select name="cs[]" style="font-size:11px;" multiple="multiple">
						<option> - select color - </option>
					 <?php
					$cs1 = mysql_query("select * from tblcolor order by color_name asc") or die(mysql_error());
                    while($cs_row1 = mysql_fetch_array($cs1)){
						?>
						<option value="<?=$cs_row1['color_id']?>" <?php echo in_array($cs_row1['color_id'],$color_ids) ? 'selected' : ''; ?>><?=$cs_row1['color_name']?> - <?=$cs_row1['color_code']?></option>
						<?
					}
					?> </select> 
				  </td>
                </tr>
				<tr>
					<td class="text" align="right">Description : </td>
						<td>
							<textarea name="prod_desc" rows="5" cols="40"><?php if(empty($row_)==true){ echo @$prod_desc; }else{ echo $row_['p_desc'];}?></textarea>						</td>
				</tr>
                <tr>
						<td align="center" colspan="2" class="error" >
                        NOTE :Please Upload Image with name &lt;style number&gt;_&lt;color code&gt;.jpg 
										</td>
				</tr>
                <tr> 
                  <td colspan=2 align=center> <input type="submit" name="cmd_cat_submit" class="inputbox" value="Save product & upload picture">                  </td>
                </tr>
              </table>
</td></tr>
</table>
	</form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>