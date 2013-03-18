<?
session_start();
include("../common.php");

if($_REQUEST['action']=='delete')
{
	 $delete="delete from tbl_stock where st_id='".$_REQUEST['eid']."'";
	 mysql_query($delete);
	 $msg=2;
}
if(isset($_POST['submit']))

   {
   
   
   
  
   
   		if($_REQUEST['product']!=""){
		
        $csql = "select * from tbl_product where prod_id='".$_REQUEST['product']."'"; 
		}else if($_REQUEST['subcat']!=''){
		$csql = "select * from tbl_product where subcat_id='".$_REQUEST['subcat']."'"; 
		}else{
		$csql = "select * from tbl_product where designer='".$_REQUEST['designer']."'"; 
		} 
		
		$cs3 = mysql_query($csql);
		$i=0;
		while($cs_row3 = mysql_fetch_array($cs3)){

		$color_names=explode(",",$cs_row3['colornames']);
		
		//print_r($color_names);		
				
			foreach($color_names as $col){
						
					$color_new = $_REQUEST['color'];
					
					$color_new2=explode("_",$color_new[$i]);
					
					$color_new3=$color_new2[1];
					
					
					        $color_new1=$color_new3;
							$get_color = mysql_query("SELECT * 
												FROM 
												 tblcolor
												WHERE
												  color_code='".$col."'") or die(mysql_error());
							$csrow1=mysql_fetch_array($get_color);
							
			$stock_qry="select * from tbl_stock where prod_id='".$cs_row3['prod_id']."' and cs_id='".$csrow1['color_id']."'";
			$stock_res=mysql_query($stock_qry);
			$num_stock=mysql_num_rows($stock_res);
			$stock_rec=mysql_fetch_array($stock_res);
				
			
			if($num_stock!=0){	
   
   $import="update tbl_stock set des_id='".$_REQUEST['designer']."',prod_id='".$cs_row3['prod_id']."',cs_id='".$color_new1."',size_0='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_0']."',size_2='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_2']."',size_4='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_4']."',size_6='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_6']."',size_8='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_8']."',size_10='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_10']."',size_12='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_12']."',size_14='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_14']."',size_16='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_16']."',size_xs='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_xs']."',size_s='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_s']."',size_m='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_m']."',size_l='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_l']."',size_xl='".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_xl']."' where st_id='".$stock_rec['st_id']."'";
 
            }else{
			
			
			  $import="INSERT into tbl_stock (des_id,
									cs_id,
									prod_id,
									size_0,
									size_2,
									size_4,
									size_6,
									size_8,
									size_10,
									size_12,
									size_14,
									size_16,
									size_xs,
									size_s,
									size_m,
									size_l,
									size_xl) 
							values(
									'".$_REQUEST['designer']."',
									'".$color_new1."',
									'".$cs_row3['prod_id']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_0']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_2']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_4']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_6']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_8']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_10']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_12']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_14']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_16']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_xs']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_s']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_m']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_l']."',
									'".$_REQUEST[$cs_row3[prod_id].'_'.$csrow1[color_code].'_size_xl']."'
								   )";
								   
			
			}	
 			
			
			$i++;	
						   

       $res_imp=mysql_query($import) or die(mysql_error());	
  }
  
  
  
  }	
  

		 
		 if($_REQUEST['product']!=""){
        $csql2 = "select * from tbl_product where prod_id='".$_REQUEST['product']."'"; 
		}else if($_REQUEST['subcat']!=''){
		$csql2 = "select * from tbl_product where subcat_id='".$_REQUEST['subcat']."'"; 
		}else{
		$csql2 = "select * from tbl_product where designer='".$_REQUEST['designer']."'"; 
		} 
		
		$cs32 = mysql_query($csql2);
		
		while($cs_row32 = mysql_fetch_array($cs32)){
		
		
		$col_nam=array();
		$col_id=array();

		
		foreach($_REQUEST['color'] as $col1){
		
					
					$color2=explode("_",$col1);
					
					$prod_idnew=$color2[0];
					
					$color3=$color2[1];
					
					
					
						
							$get_color1 = mysql_query("SELECT * 
												FROM 
												 tblcolor
												WHERE
												  color_id='".$color3."'") or die(mysql_error());
							$csrow11=mysql_fetch_array($get_color1);
							
							if($cs_row32['prod_id']==$prod_idnew){
							
							array_push($col_nam,$csrow11['color_code']);
							array_push($col_id,$csrow11['color_id']);
							
							}
							
							}		
		
		
		 $col_new1=implode(",",$col_nam);
		 $col_ids=implode(",",$col_id);
		 $col1=$_REQUEST['color'];

		 $get_color2 = mysql_fetch_array(mysql_query("SELECT * FROM tblcolor WHERE color_id='".$col_id[0]."'"));				
							
		 $update = "update tbl_product set primary_img_id='".$get_color2['color_code']."',colors='".$col_ids."',colornames='".$col_new1."' where prod_id='".$cs_row32['prod_id']."'"; 
		 $csu = mysql_query($update);
        }
 
  
  $msg=1;

}

include 'top.php'; 
?>
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
	
	
	
	function getCs1(strURL) {		
		
		var req1 = getXMLHTTP();
		
		if (req1) {
			
			req1.onreadystatechange = function() {
				if (req1.readyState == 4) {
					// only if "OK"
					if (req1.status == 200) {
					//alert(req1.responseText);						
						document.getElementById('stockdiv').innerHTML=req1.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req1.statusText);
					}
				}				
			}			
			req1.open("GET", strURL, true);
			req1.send(null);
		}
				
	}
	
	function getprod(strURL) {
		
		var req1 = getXMLHTTP();

		if (req1) {
			
			req1.onreadystatechange = function() {
				if (req1.readyState == 4) {
					// only if "OK"
					if (req1.status == 200) {	
					//alert(req1.responseText);
						//document.getElementById('proddiv').innerHTML=req1.responseText;
						var res =req1.responseText;
					 	res1= res.split('@');
						document.getElementById('proddiv').innerHTML=res1[0];			
						document.getElementById('report').innerHTML=res1[1];				
						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req1.statusText);
					}
				}				
			}			
			req1.open("GET", strURL, true);
			req1.send(null);
		}
				
	}
	
	function getCs(strURL) {		
		
		var req1 = getXMLHTTP();
		
		if (req1) {
			
			req1.onreadystatechange = function() {
				if (req1.readyState == 4) {
					// only if "OK"
					if (req1.status == 200) {
					//alert(req1.responseText);						
						document.getElementById('checkdiv').innerHTML=req1.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req1.statusText);
					}
				}				
			}			
			req1.open("GET", strURL, true);
			req1.send(null);
		}
				
	}
	
	function getCs2(strURL) {	
	
	//alert(strURL);	
		
		var req1 = getXMLHTTP();
		
		if (req1) {
			
			req1.onreadystatechange = function() {
				if (req1.readyState == 4) {
					// only if "OK"
					if (req1.status == 200) {
					//alert(req1.responseText);						
						document.getElementById('displayprod').innerHTML=req1.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req1.statusText);
					}
				}				
			}			
			req1.open("GET", strURL, true);
			req1.send(null);
		}
				
	}
	
	function getCs3(strURL) {	
	
	//alert(strURL);	
		
		var req1 = getXMLHTTP();
		
		if (req1) {
			
			req1.onreadystatechange = function() {
				if (req1.readyState == 4) {
					// only if "OK"
					if (req1.status == 200) {
					//alert(req1.responseText);						
						document.getElementById('subcatdiv').innerHTML=req1.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req1.statusText);
					}
				}				
			}			
			req1.open("GET", strURL, true);
			req1.send(null);
		}
				
	}
	
	
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function validForm(passForm) 
  {		
		if (passForm.designer.value == "") 
		 {
				alert("Please select designer")          
				document.myform.designer.focus()
				return false
          }	

	 }  
//-->
</script>
<title>In Style New York::Admin Section</title>

<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
					<form name="myform" action="add_color_size.php" method="post" enctype='multipart/form-data' onSubmit="return validForm(this)">
					<? if($msg==1) { ?> <span style="color:#CC0000;" class="text"><strong>Stock added successfully.</strong></span><br /><br /> <? }?>
                    <? if($msg==2) { ?> <span style="color:#CC0000;" class="text"><strong>Stock deleted successfully.</strong></span><br /><br /> <? }?>
                   <div id="checkdiv" class="error"></div> <br />
                    <table width=90% border=1 bordercolor=#cccccc cellspacing=0 cellpadding=0>
					<tr><td>
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=#cccccc><td align=center colspan="2"><h1>EDIT STOCK</h1></td></tr>
                     <tr><td align=right colspan="2"><div id="report" class="error"><a href="viewstock.php">Generate Stock Report</a></div></td></tr>
					<tr> <td class="text" align="right">Designer:</td>
						<td align="left"> 
							<select name="designer" onChange="getCs3('subcat.php?des_id='+this.value);getprod('product.php?des_id='+this.value);getCs2('allitems.php?des_id='+this.value+'&option=designer');">
							<option value=""> - select designer - </option>
							<?php
							$get_designer = @mysql_query("select * from designer");
							if(mysql_num_rows($get_designer) > 0) {
							while($row = mysql_fetch_array($get_designer)) {
							?>
							<option value="<?=$row['des_id']?>"><?=$row['designer']?></option>
							<?
							}
							}
							?>
							</select>
						</td>
					</tr>
                    <tr>
                        <td class="text" align="right">Subcat:</td>
						  <td align="left" class="text"><div id="subcatdiv">Select Subcat</div>
				  </td>
					</tr>
                    <tr>
                        <td class="text" align="right">Style Number #:</td>
						  <td align="left" class="text"><div id="proddiv">Select Product</div>
				  </td>
					</tr>
					<tr>
					<td align="left" class="text" colspan="2"><div id="stockdiv"></div></td>
					</tr>
                    
                    <tr>
					<td align="left" class="text" colspan="2"><div id="displayprod"></div></td>
					</tr>
					
                       <tr><td colspan=2 align=center><input type="submit" name="submit" value="Upload &amp; Save" class=button style="width:120px;"> </td></tr>
                     </table>
                    </td></tr></table>
                    
                    </form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>
