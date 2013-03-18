<?
session_start();
include("../common.php");
include("security.php");

if(isset($_POST['submit']))

   {
	
	if ($_FILES["file"]["type"] <> 'application/vnd.ms-excel')
    {
    $msg = "Return Code: invalid file<br /><br>";
    }
  else
    {
   

     move_uploaded_file($_FILES["file"]["tmp_name"],
      "csv/" . $_FILES["file"]["name"]);
      	  
	 $des_id = $_POST['des_id'];
     $filename=$_FILES["file"]["name"];
     $handle = fopen("csv/".$filename, "r");
	//$i = 1;
     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
     {
	
    //if($i>1) {

$import="INSERT into tbl_color_size (des_id,
									style,
									color,
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
									'$des_id',
									'$data[0]',
									'$data[1]',
									'$data[2]',
									'$data[3]',
									'$data[4]',
									'$data[5]',
									'$data[6]',
									'$data[7]',
									'$data[8]',
									'$data[9]',
									'$data[10]',
									'$data[11]',
									'$data[12]',
									'$data[13]',
									'$data[14]',
									'$data[15]'
								   )";
								   

       mysql_query($import) or die(mysql_error());
	   //}
	$i++;
     }

     fclose($handle);	
	 unlink('csv/'.$_FILES["file"]["name"]);
     $msg = "CSV has been uploaded and saved <br><br>"; 	  
	  
    }
}

include 'top.php'; 
?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
					<form name="size" action="add_size.php" method="post" enctype='multipart/form-data'>
					<? if(isset($msg)) { ?> <span style="color:#CC0000;" class="text"><strong><?=$msg?></strong></span> <? }?>
                    <table width=70% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>
                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc><td align=center colspan=2><h1>Select Designer</h1></td></tr>
                    <tr><td align=center colspan=2 class="error"><?=@$err;?></td></tr>
                    <tr><td width="40%" class="text" align="right">Designer Name : </td>
                    <td width="60%" align="left">
					<select name="des_id">
					<?php
					$get_designer = mysql_query("select * from designer");
					if(mysql_num_rows($get_designer)>0) {
						while($d_row = mysql_fetch_array($get_designer)) {
							?> <option value="<?=$d_row['des_id']?>"><?=$d_row['designer']?></option> <?php
						}
					}
					?>
					</select>
					</td></tr>
					<tr><td class="text" align="right">Browse CSV File : </td><td>
					<input type="file" name="file" size="20">
					</td></tr>
                       <tr><td colspan=2 align=center><input type="submit" name="submit" value="Upload &amp; Save" class=button style="width:120px;"> </td></tr>
                     </table>
                    </td></tr></table>
                    </form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>