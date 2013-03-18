<?
include("../common.php");
include("security.php");
?>

<title>InstyleNewyork::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">

<table width="100%" border="0" cellpadding="1" cellspacing="1">
    <tr>
      <td >
                    <!-----start-----------//-->
                    <?php
if(isset($_POST['submit']))

   {
	
	if ($_FILES["file"]["type"] <> 'application/vnd.ms-excel')
    {
    echo "Return Code: invalid file<br /> <a href='#' onclick='history.go(-1);return false;'>Click here to try again</a>";
    }
  else
    {
   
     move_uploaded_file($_FILES["file"]["tmp_name"],
      "csv/" . $_FILES["file"]["name"]);
      
	  
	 $des_id = $_POST['des_id'];
     $filename=$_FILES["file"]["name"];
     $handle = fopen("csv/".$filename, "r");
	//$i = 1;
	mysql_query("delete from tbl_color_size where des_id='".$des_id."'");
	
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
     echo "<script>opener.location.href='edit_cs.php?msg=csv_success';window.close();</script>"; 	  
	  
    }
	

   } else  { 
	  ?>
	  <form action="<?=$_SERVER['PHP_SELF']?>" method='post' enctype='multipart/form-data'>
	   <table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
		<tr>
		<td>
		<input type="hidden" name="des_id" value="<?=$_GET['des_id']?>">
		<table width=100% align=center cellspacing=2 cellpadding=2>
		<tr bgcolor=cccccc>
		<td align=center colspan=2><b>
		<font size=2 color="#000000" face="verdana,Arial">Upload &amp; update CSV</td></tr>
		<tr><td align=center colspan=2><b><font size=2 face=verdana color=red><?=@$err;?></td></tr>
		 <tr><td valign=top><font size=2 color="#000000" face="verdana,Arial">CSV File:</td>
		<td><input type="file" name="file" size="20"></td></tr>
		<tr><td colspan=2 align=center><input type="submit" name="submit" value="Upload &amp; Save" class=button style="width:100px;"> </td></tr>
		 </table>
		</td></tr></table>
	   </form>
	  <?php
   }
   ?>
   
   
                     <!-------end-------//-->
                    </td>
                  </tr>
                </table>