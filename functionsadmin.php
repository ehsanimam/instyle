<?php
//icm//resize function*****************88888

function RandomNumber($length) {
		$random=""; 
		srand((double)microtime()*1000000); 
		$data = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
		$data.= "BC123456789"; 
		$data.= "0FGH45OP89"; 
		for($i = 0;$i < $length;$i++) {
			$random.= substr($data,(rand()%(strlen($data))),1); 
		}
			return $random;
		}


//Function to get the file extension.
function fnGetFileExtension($strFileName)
{
	$strPos = strrpos($strFileName, ".");
	$strExtension = substr($strFileName, ($strPos+1), strlen($strFileName));

	return $strExtension;
}

//Function to get the file extension.
function GetFileExtension($strFileName)
{
	$arrExtension = explode(".", $strFileName);
	$intCount     = count($arrExtension);
	$strExtension = $arrExtension[$intCount-1];

	return $strExtension;
}


//function to get filename (without extension)
function GetFileName($strFileName)
{
	$arrFileName = explode(".", $strFileName);
	$intCount     = count($arrFileName);
	$arrFileName[$intCount-1] = "";
	$fileName     = implode(".",$arrFileName);
	$fileName = substr($fileName,0,(strlen($fileName)-1));
	return $fileName;
}

//function to get file name from the full file path
function GetFileNameFromPath($strFilePath)
{
	$strFilePath = explode("/", $strFilePath);

	$intCount     = count($strFilePath);
	return  $strFilePath[$intCount-1] ;
}


function gd2resize($srcFile,$dstWidth,$dstHeight,$dstPath,$suffix)
{

$dstPath = $dstPath.$suffix.GetFileNameFromPath($srcFile);
$dstPath = GetFileName($dstPath);
$file_ext = GetFileExtension(GetFileNameFromPath($srcFile));
$srcType  = strtolower($file_ext) ;
$dstType  = $srcType ;

   if ($srcType == "jpg"||$srcType == "jpeg")
       $handle = @imagecreatefromjpeg($srcFile);
   else if ($srcType == "png")
       $handle = @imagecreatefrompng($srcFile);
   else if ($srcType == "gif")
       {$handle = @imagecreatefromgif($srcFile);
;}
   else
       return false;
   if (!$handle)
       return false;
   $srcWidth  = @imagesx($handle);
   $srcHeight = @imagesy($handle);

   //$dstHeight = (int) (($dstWidth / $srcWidth) * $srcHeight);
   
   if($dstWidth == "16")
   {
		$dstWidth = "16";
		$dstHeight = "16";
		
   }	
   
   $newHandle = @imagecreatetruecolor($dstWidth, $dstHeight);
 	 if (!$newHandle)
         return false;


       if (!@imagecopyresampled($newHandle,$handle, 0,0,0,0, $dstWidth, $dstHeight, $srcWidth, $srcHeight))
      {
		    return false;
      }
	   @imagedestroy($handle);

       if ($dstType == "png")
           @imagepng($newHandle, $dstPath.".png");
       else if ($dstType == "jpg")
	   {

		   @imagejpeg($newHandle, $dstPath.".jpg", 90);
       }
	   else if ($dstType == "gif")
	   {
           @imagegif($newHandle,$dstPath.".gif");

		}
	   else
           return false;


	   @imagedestroy($newHandle);

	   return true;


}



function gd2resize2($srcFile,$dstWidth,$dstPath,$suffix)
{

$dstPath = $dstPath.$suffix.GetFileNameFromPath($srcFile);
$dstPath = GetFileName($dstPath);
$file_ext = GetFileExtension(GetFileNameFromPath($srcFile));
$srcType  = strtolower($file_ext) ;
$dstType  = $srcType ;

   if ($srcType == "jpg"||$srcType == "jpeg")
       $handle = @imagecreatefromjpeg($srcFile);
   else if ($srcType == "png")
       $handle = @imagecreatefrompng($srcFile);
   else if ($srcType == "gif")
       {$handle = @imagecreatefromgif($srcFile);
;}
   else
       return false;
   if (!$handle)
       return false;
   $srcWidth  = @imagesx($handle);
   $srcHeight = @imagesy($handle);

   $dstHeight = (int) (($dstWidth / $srcWidth) * $srcHeight);
   $newHandle = @imagecreatetruecolor($dstWidth, $dstHeight);
 	 if (!$newHandle)
         return false;


       if (!@imagecopyresampled($newHandle,$handle, 0,0,0,0, $dstWidth, $dstHeight, $srcWidth, $srcHeight))
      {
		   return false;
      }
	   @imagedestroy($handle);

       if ($dstType == "png")
           @imagepng($newHandle, $dstPath.".png");
       else if ($dstType == "jpg")
	   {

		   @imagejpeg($newHandle, $dstPath.".jpg", 90);
       }
	   else if ($dstType == "gif")
	   {
           @imagegif($newHandle,$dstPath.".gif");

		}
	   else
           return false;


	   @imagedestroy($newHandle);

	   return true;


}

function get_param($ParamName)
{
  global $HTTP_POST_VARS;
  global $HTTP_GET_VARS;

  $ParamValue = "";
  if(isset($HTTP_POST_VARS[$ParamName]))
    $ParamValue = $HTTP_POST_VARS[$ParamName];
  else if(isset($HTTP_GET_VARS[$ParamName]))
    $ParamValue = $HTTP_GET_VARS[$ParamName];

  return $ParamValue;
}

//Following function validates for email address.
function validateEmail($email)
{
	return ereg("^([_a-zA-Z0-9]+([\\._a-zA-Z0-9-]+)*)@([_a-zA-Z0-9-]{2,}(\\.[_a-zA-Z0-9-]{2,})*\\.[a-zA-Z]{2,3})$", $email);
}



//**********************************



function get_catname($cat_id)
{
  $query="select * from tblcat where cat_id='$cat_id'";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  echo ucwords($row['cat_name']);
}

function get_subcatname($subcat_id)
{
  $query="select * from tblsubcat where subcat_id='$subcat_id'";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  echo $row['subcat_name'];

}
function get_subsubcatname($id)
{
  $query="select * from tblsubsubcat where id='$id'";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  echo $row['name'];

}

function get_typename($type_id)
{
  $query="select * from tbltypecat where type_id='$type_id'";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  echo $row['type_name'];

}

function get_manufname($manuf_id)
{
  $query="select * from tblmanufacturer where manufacturer_id='$manuf_id'";

  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  echo ucwords($row[manufacturer_name]);

}

function get_colorname($color_id)
{
  $query="select * from tblcolor where color_id='$color_id'";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  echo ucwords($row[color_name]);
}

function get_sizename($size_id)
{
  $query="select * from tblsize where size_id='$size_id'";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  echo ucwords($row[size_name]);

}
function get_designername($size_id)
{
  $query="select * from designer where des_id='$size_id'";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  echo ucwords($row[designer]);

}

function get_colorname_email($color_id)
{
  $query="select * from tblcolor where color_id='$color_id'";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
 return ucwords($row[color_name]);
}

function get_sizename_email($size_id)
{
  $query="select * from tblsize where size_id='$size_id'";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  return ucwords($row[size_name]);

}


function get_categories()
{
  $select="select * from tblcat where cat_id!='22' order by cat_name asc";
  $result=mysql_query($select);
  echo "<select name='cat' class=combobig onchange='submit_form()'>\n<option value=''>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      echo"<option value='$row[cat_id]'>$row[cat_name]</option>";
  }
  echo "</select>";
}

function get_subcategories($cat_id)
{
  $select="select * from tblsubcat where cat_id='$cat_id' order by subcat_name";
  $result=mysql_query($select);
  echo "<select name='subcat' class=combobig onchange='submit_form()'>\n<option value='0'>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      echo"<option value=$row[subcat_id]>$row[subcat_name]</option>";
  }
  echo "</select>";

}

function get_subcategories1()
{
  $select="select * from tblsubcat where cat_id='22' order by subcat_name";
  $result=mysql_query($select);
  echo "<select name='subcat' class=combobig onchange='submit_form()'>\n<option value='0'>Select subcat</option>";
  while($row=mysql_fetch_array($result))
  {
      echo"<option value=$row[subcat_id]>$row[subcat_name]</option>";
  }
  echo "</select>";

}


function get_subsubcategories($subcat_id)
{
$select="select * from tblsubsubcat where subcat_id='$subcat_id' order by name";
 

  $result=mysql_query($select);
  echo "<select name='subsubcat' class=combobig>\n<option value='0'>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      echo"<option value=$row[id]>$row[name]</option>";
  }
  echo "</select>";

}
function get_typecategories()
{
  $select="select * from tbltypecat order by type_name ASC";
  $result=mysql_query($select);
  echo "<select name='type' class='combobig'>\n<option value=''>Select</option>\n";
  while($row=mysql_fetch_array($result))
  {
	  $typename = get_type_heading($row[heading_id]);
      echo "<option value='$row[type_id]'>$row[type_name]($typename)</option>\n";
  }
  echo "</select>";
}

function get_typecategories_edit()
{
  //$select="select * from tbltypecat where type_id='$type_id' order by type_name ASC";
  $select="select * from tbltypecat order by type_name ASC";
  $result=mysql_query($select);
  echo "<select name='type' class=combobig onchange='submit_form()'>\n<option value=''>Select</option>\n";
  while($row=mysql_fetch_array($result))
  {	
	  $typename = get_type_heading($row[heading_id]);
      echo "<option value='$row[type_id]'>$row[type_name]($typename)</option>\n";
  }
  echo "</select>";
}

function get_manufacturer()
{
  $select="select * from tblmanufacturer order by manufacturer_name asc";
  $result=mysql_query($select);
  echo "<select name='manuf' class=combobig onchange='submit_form()'><option value=''>Select</option>";
//  echo "<select name='manuf' class=combobig ><option value=''>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      echo"<option value='$row[manufacturer_id]'>$row[manufacturer_name]</option>";
  }
  echo "</select>";
}

//to get the size options in admin
function get_size($size_ids)
{
  $select1="select * from tblsize";
  $result1=mysql_query($select1);
  if($size_ids==0)
  {
      $style='selected';
  }
  echo "<select name='sizes[]' class=combobig  multiple><option value='0' $style>None</option>";
  while($row1=mysql_fetch_array($result1))
  {
      $size_arr=split(",",$size_ids);
      $style='';
      for($cnt=0;$cnt<=count($size_arr);$cnt++)
      {
          if($size_arr[$cnt]==$row1[size_id])
          {
              $style="selected";

          }
      }

      echo"<option value='$row1[size_id]' $style>$row1[size_name]&nbsp;&nbsp;</option>";
  }
   echo"</select>";
}

// ------------------------------------------------added ny icm

function get_size_add()
{
  $select1="select * from tblsize order by size_name";
  $result1=mysql_query($select1);
  echo "<select name='size' class=combobig><option value='0' selected>None</option>";
  while($row1=mysql_fetch_array($result1))
  {
      echo"<option value='$row1[size_id]' $style>$row1[size_name]&nbsp;&nbsp;</option>";
  }
   echo"</select>";
}


function get_color_add()
{
  $select1="select * from tblcolor order by color_name";
  $result1=mysql_query($select1);
  echo "<select name='color' class=combobig><option value='0' selected>None</option>";
  while($row1=mysql_fetch_array($result1))
  {
      echo"<option value='$row1[color_id]' $style>$row1[color_name]&nbsp;&nbsp; </option>";
  }
   echo"</select>";

}


function get_prod($cnt)
{
  $nam="asso".$cnt;
  $query="select * from tblproduct where no_part=1 order by prod_name asc";
  $result=mysql_query($query);
  echo "<select name='$nam' class=combobig><option value='0'>Select</option>";
    while($row=mysql_fetch_array($result))
    {
        echo"<option value='$row[prod_id]'>$row[prod_name]</option>";
    }
  echo "</select>";

}

function get_prod_add()
{
  $query="select * from tblproduct order by prod_name asc";
  $result=mysql_query($query);
  echo "<select name='prod_name' class=combobig onchange='_doreturn();'><option value='0'>Select</option>";
    while($row=mysql_fetch_array($result))
    {
        echo"<option value='$row[prod_id]'>$row[prod_name]</option>";
    }
  echo "</select>";

}
function get_prod_add_chand()
{
  $query="select * from tblproduct where cat_id='29' order by prod_name asc";
  $result=mysql_query($query);
  echo "<select name='prod_name' class=combobig onchange='_doreturn();'><option value='0'>Select</option>";
    while($row=mysql_fetch_array($result))
    {
        echo"<option value='$row[prod_id]'>$row[prod_name]</option>";
    }
  echo "</select>";

}
function get_prod_add_size()
{
  $query="select * from tblproduct order by prod_name asc";
  $result=mysql_query($query);
  echo "<select name='prod_name' class=combobig onchange='submit_form();'><option value='0'>Select</option>";
    while($row=mysql_fetch_array($result))
    {
        echo"<option value='$row[prod_id]'>$row[prod_name]</option>";
    }
  echo "</select>";

}

function get_prat_add_size($pid)
{
  $query="select * from tblproduct_details where prod_id='$pid' order by p_name asc";
  $result=mysql_query($query);   
 
  echo "<select name='part_name' class=combobig onchange='submit_form()'><option value='0'>Select</option>";
    while($row=mysql_fetch_array($result))
    {
        echo "<option value='$row[det_id]'>$row[p_name]</option>";
    }
  echo "</select>";

}

function get_add_Dsize($pid)
{  
  $query_="select * from tblproduct_details where det_id='$pid' order by p_name asc";
  $result_=mysql_query($query_);
  $row_=mysql_fetch_array($result_);
  
  $query="select * from tblproduct_size where prod_id='".$row_['prod_id']."'";
  $result=mysql_query($query);
  echo "<select name='size_name' class=combobig><option value='0'>Select</option>";
    while($row=mysql_fetch_array($result))
    {
        if(empty($row[size_id1])==false){
		echo "<option value='$row[size_id1]'>$row[size_id1]</option>";
		}
		if(empty($row[size_id2])==false){
		echo "<option value='$row[size_id2]'>$row[size_id2]</option>";
		}
		if(empty($row[size_id3])==false){
		echo "<option value='$row[size_id3]'>$row[size_id3]</option>";
		}
		if(empty($row[size_id4])==false){
		echo "<option value='$row[size_id4]'>$row[size_id4]</option>";
		}
		if(empty($row[size_id5])==false){
		echo "<option value='$row[size_id5]'>$row[size_id5]</option>";
		}
    }
  echo "</select>";

}

function get_manu_subcategories($man_id)
{
  $select="select * from tblmanusubcat where manu_id='$man_id' order by sub_cat_name asc";
  //$select="select * from tblmanusubcat";
  $result=mysql_query($select);
  echo "<select name='subcat_manu' class=combobig><option value='0'>Select</option>";
  while($row=mysql_fetch_array($result))
  {
     //if($row[sub_cat_id] == $man_id)
      echo"<option value='$row[sub_cat_id]'>$row[sub_cat_name]</option>";
  }
  echo "</select>";

}

function get_trend_subcategories($man_id)
{
  $select="select * from tbltrendsubcat where trend_id='$man_id' order by subcat_name";
  $result=mysql_query($select);
  echo "<select name='subcat_trend' class=combobig><option value='0'>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      echo"<option value='$row[subcat_id]'>$row[subcat_name]</option>";
  }
  echo "</select>";

}

// ------------------------------------------------end

//to get the size options in frontend
function get_size_option($size_ids)
{
  $select1="select * from tblsize order by size_name asc";
  $result1=mysql_query($select1);

  echo "<select name='sizes' class=radio><option value='0'>Select Size</option>";
  while($row1=mysql_fetch_array($result1))
  {
      $size_arr=split(",",$size_ids);
      $style='';
      for($cnt=0;$cnt<=count($size_arr);$cnt++)
      {
          if($size_arr[$cnt]==$row1[size_id])
          {
            echo"<option value='$row1[size_id]' $style>$row1[size_name]&nbsp;&nbsp;</option>";

          }
      }


  }
   echo"</select>";
}


function get_color($color_ids)
{
  $select1="select * from tblcolor order by color_name asc";
  $result1=mysql_query($select1);
  if($color_ids==0)
  {
      $style='selected';
  }
  echo "<select name='colors[]' class=combobig  size=4  multiple><option value='0' $style>None</option>";
  while($row1=mysql_fetch_array($result1))
  {
      $color_arr=split(",",$color_ids);
      $style='';
      for($cnt=0;$cnt<=count($color_arr);$cnt++)
      {

          if($color_arr[$cnt]==$row1[color_id])
          {
              $style="selected";

          }
      }

      echo"<option value='$row1[color_id]' $style>$row1[color_name]&nbsp;&nbsp; </option>";
  }
   echo"</select>";

}

//to get the size options in frontend
function get_color_option($color_ids)
{
  $select1="select * from tblcolor order by color_name asc";
  $result1=mysql_query($select1);

  echo "<select name='colors' class=radio><option value='0'>Select Color</option>";
  while($row1=mysql_fetch_array($result1))
  {
      $color_arr=split(",",$color_ids);

      for($cnt=0;$cnt<=count($color_arr);$cnt++)
      {
          if($color_arr[$cnt]==$row1[color_id])
          {
            echo"<option value='$row1[color_id]' >$row1[color_name]&nbsp;&nbsp;</option>";

          }
      }


  }
   echo"</select>";
}

//code edited by infynita starts

function admin_add_product($product_name,$product_no, $cat, $subcat, $manuf, $manu_sub, $add_date, $trend, $trend_sub, $s1, $s2, $s3, $sale, $product_desc, $type)
{
	$err=check_empty_product($cat, $product_name, $type, $subcat);
	if($err=='0')
	{
		$err1=dateCheck($add_date);
		if($err1=='0')
		{
			//$prod_date=date('Y-m-d');
			/*$sql="insert into
			tblproduct(prod_name,prod_no, cat_id, subcat_id, type_id, manufacturer_id, manu_sub_id, prod_date, trend_id, trend_sub_id, suggest1, suggest2, suggest3, prod_desc, on_sale)";
			$sql=$sql." values('$product_name','$product_no', '$cat', '$subcat','$type', '$manuf', '$manu_sub', '$add_date', '$trend', '$trend_sub', '$s1', '$s2', '$s3', '$product_desc', '$sale')";*/
			//$sql = addslashes($sql);
			$seq_sql = "select max(seque) from tblproduct where cat_id='".$cat."'";
			$seq_res = mysql_query($seq_sql);
			$seq_row = mysql_fetch_array($seq_res);
			$seq_num = mysql_num_rows($seq_res);
			
			if($seq_row[0] > 0 && $seq_num == 1):
				$seqes = $seq_row[0] + 1; 
			else:	
				$seqes = 1;
			endif;
		
			$sql="insert into
			tblproduct(prod_name,seque, prod_no, cat_id, subcat_id, type_id, manufacturer_id, manu_sub_id, prod_date, trend_id, trend_sub_id, suggest1, suggest2, suggest3, prod_desc, on_sale)";
			$sql=$sql." values('$product_name','$seqes','$product_no', '$cat', '$subcat','$type', '$manuf', '$manu_sub', '$add_date', '$trend', '$trend_sub', '$s1', '$s2', '$s3', '$product_desc', '$sale')";				
			
			mysql_query($sql)or die("Error");
			return 0;
		}
		else
		{
			$GLOBALS["message"]=$GLOBALS["message"];
			return 1;
		}
	}
	else
	{
		$GLOBALS["message"]=$GLOBALS["message"];
		return 1;
	}
}

//code edited by infynita ends


//Check blank for Product Details
function check_empty_product($cat, $product_name, $type, $subcat)
{
    
	 if($cat=="" || $product_name=="") //|| $subcat=="0")
     {
        if($product_name=="")
        {
             $GLOBALS["message"]=$GLOBALS["message"]."Please enter Product Name"."<br>";
        }

        if($cat=="")
		{
		     $GLOBALS["message"]=$GLOBALS["message"]."Please choose Category"."<br>";
        }

        /*if($subcat=="0")
		{
		     $GLOBALS["message"]=$GLOBALS["message"]."Please choose Sub-Category"."<br>";
        }*/
		 return 1;
     }else{return 0;}
}

//Check for date when adding products (code added by infynita)

function dateCheck($date)
   {
   		$yr=date('Y');
		if($date =="")
		 {
		 	$GLOBALS["message"]=$GLOBALS["message"]."Please enter date"."<br>";
		 	return 1;
		 }
		$datebits=explode('-',$date);
		
		if(count($datebits)!=3){
		$datebits=explode('/',$date);
		}
		
		 
   		/*if (count($datebits=explode('-',$date))!=3)
   		{
   			$GLOBALS["message"]=$GLOBALS["message"]."Please use '-' as date seprator"."<br>";
   			return 1;
   		}*/
   		$year = intval($datebits[2]);
   		$month = intval($datebits[0]);
   		$day = intval($datebits[1]);
		if ($year>$yr)
		{
		       		$GLOBALS["message"]=$GLOBALS["message"]."Please enter correct Year"."<br>";
		       		return 1; // date out of range
		}
       	if (($month<1) || ($month>12) || ($day<1) || (($month==2) && ($day>28+(!($year%4))-(!($year%100))+(!($year%400)))) || ($day>30+(($month>7)^($month&1))))
       {
       		$GLOBALS["message"]=$GLOBALS["message"]."Please enter correct date"."<br>";
       		return 1; // date out of range
		}
		else{return 0;	}
   }



function admin_edit_product($product_name, $product_no, $cat, $subcat, $manuf, $manu_sub, $add_date, $trend, $subcat_trend, $s1, $s2, $s3, $sale, $product_desc, $prod_id, $type)
{
	$err=check_empty_product($cat, $product_name, $type, $subcat);
	
	if ($err=='0')
        {
		$err1=dateCheck($add_date);
		if($err1=='0')
		{
			$add_date = date('Y-m-d',strtotime($add_date));
			$sql="update tblproduct
			set prod_name='$product_name',
			prod_no='$product_no',
			cat_id='$cat',
			subcat_id='$subcat',
			type_id='$type',
			manufacturer_id='$manuf',
			manu_sub_id='$manu_sub',
			prod_date='$add_date',
			trend_id='$trend',
			trend_sub_id='$subcat_trend',
			suggest1='$s1',
			suggest2='$s2',
			suggest3='$s3',
			prod_desc='$product_desc',
			on_sale='$sale'
			where prod_id='$prod_id'";

			mysql_query($sql)or die("Error");

			return 0;
		  }
		else
		{
			$GLOBALS["message"]=$GLOBALS["message"];
			 return 1;
		}
        }
        else
        {
            $GLOBALS["message"]=$GLOBALS["message"];
             return 1;
        }
}

function move_files($prod_no,$dst_designer, $dst_cat, $dst_subcat)
{

if ($dst_cat=='1') {$to_cat='WMANSAPREL';}
if ($dst_cat=='19') {$to_cat='JWLRYACCSRIES';}
if ($dst_cat=='23') {$to_cat='CLRNCE';}

  $sql="select * from designer where des_id='$dst_designer'";
  $p_rs=mysql_query($sql);
  $p_row=mysql_fetch_array($p_rs);
  $to_designer=$p_row['folder'];

  $sql="select * from tblsubcat where subcat_id='$dst_subcat'";
  $p_rs=mysql_query($sql);
  $p_row=mysql_fetch_array($p_rs);
  $to_sub=$p_row['folder'];
	

$dest=$to_cat.'/'.$to_designer.'/'.$to_sub.'/';


 $getpic = mysql_query("SELECT tp.prod_no, tp.prod_id,d.folder as designer_folder, subcat.folder AS subcat_folder, tcs.color_name,tcs.color_code,tp.prod_no,ts.size_0, ts.size_2, ts.size_4, ts.size_6, ts.size_8, ts.size_10, ts.size_12, ts.size_14, ts.size_16,ts.size_fs, ts.st_id,
														case cat.cat_id
														  when '1'
															then 'WMANSAPREL'
														  when '19'
															then 'JWLRYACCSRIES'
														  when '22'
															then 'BRIDAL'
														  when '23'
															then 'WMANSAPREL'
														  else 'CLRNCE'
														end as cat_folder
														FROM
														  tbl_product tp
														  LEFT JOIN designer d ON d.des_id=tp.designer
														  LEFT JOIN tblcat cat ON cat.cat_id = tp.cat_id
														  LEFT JOIN tblsubcat subcat ON subcat.subcat_id = tp.subcat_id
														  LEFT JOIN tbl_stock ts ON ts.prod_no = tp.prod_no
														  LEFT JOIN tblcolor tcs ON tcs.color_name = ts.color_name
														WHERE
														  tp.prod_no ='".$_REQUEST['prod_no']."'") or die(mysql_error());							
							
					$base_site_url	 = '../';						
                       if(@mysql_num_rows($getpic)) {
                             while($irow = @mysql_fetch_array($getpic)) {
                                $img_url		 = $base_site_url.'product_assets/'.$irow['cat_folder'].'/'.$irow['designer_folder'].'/'.$irow['subcat_folder'].'/';
                              
								
                                $img_thumb 	     = $img_url.'product_front/'.$irow['prod_no'].'_'.$irow['color_code'].'.jpg';
                                $img_thumb_back  = $img_url.'product_back/'.$irow['prod_no'].'_'.$irow['color_code'].'.jpg';
                                $img_thumb_side  = $img_url.'product_side/'.$irow['prod_no'].'_'.$irow['color_code'].'.jpg';
							
                                $video			 = $img_url.'product_video/'.$irow['prod_no'].'_'.$irow['color_code'].'.flv';
								
$icon  = $img_url.'product_coloricon/'.$irow['prod_no'].'_'.$irow['color_code'].'.jpg';								
								
								if($img = @GetImageSize($icon)) {
								 //echo '<br>';
								// echo $icon.'<br>';
								 $to_icon= $base_site_url.'product_assets/'.$dest.'product_coloricon/'.$irow['prod_no'].'_'.$irow['color_code'].'.jpg';
								 //echo $to_icon;
								 
								if ($icon!=$to_icon){ 
								if (!copy($icon, $to_icon)) {echo "failed to copy $file...\n";}								 }
								 

								}
								
								
								if($img = @GetImageSize($img_thumb)) {
								 //echo '<br>';
								 //echo $img_thumb.'<br>';
								 $to_front= $base_site_url.'product_assets/'.$dest.'product_front/'.$irow['prod_no'].'_'.$irow['color_code'].'.jpg';
								 //echo $to_front;
								if ($img_thumb!=$to_front) { 
								if (!copy($img_thumb, $to_front)) {echo "failed to copy $file...\n";}																 }

								}
								if($img = @GetImageSize($img_thumb_back)) {
								 //echo '<br>';								
								// echo $img_thumb_back.'<br>';								
								 $to_back= $base_site_url.'product_assets/'.$dest.'product_back/'.$irow['prod_no'].'_'.$irow['color_code'].'.jpg';
								// echo $to_back;	
								if ($img_thumb_back!=$to_back)
								{
								if (!copy($img_thumb_back, $to_back)) {echo "failed to copy $file...\n";}																								 							}
								}
								if($img = @GetImageSize($img_thumb_side)) {
								 //echo '<br>';								
								// echo $img_thumb_side.'<br>';								
								 $to_side= $base_site_url.'product_assets/'.$dest.'product_side/'.$irow['prod_no'].'_'.$irow['color_code'].'.jpg';
								// echo $to_side;
								if ($img_thumb_side!=$to_side) {
								if (!copy($img_thumb_side, $to_side)) {echo "failed to copy $file...\n";}								 								}
								}
								if($img = @GetImageSize($video)) {
								 //echo '<br>';								
								// echo $video.'<br>';								
								 $to_video= $base_site_url.'product_assets/'.$dest.'product_video/'.$irow['prod_no'].'_'.$irow['color_code'].'.flv';	
								// echo $to_video;
								if (!copy($video, $to_video)) {echo "failed to copy $file...\n";}																 							
								}
                             }
                           }

}

function admin_edit_new_product(
	$prod_id, 
	$prod_name, 
	$prod_no, 
	$cat, 
	$subcat, 
	$subsubcat, 
	$new_arrival, 
	$clearance, 
	$catalogue_price, 
	$less_discount, 
	$wholesale_price, 
	$prod_desc, 
	$designer, 
	$primary_img, 
	$primary_img_id, 
	$colors)
{
	$err = check_empty_product($cat, $prod_name, '', $subcat);
	//$err = check_empty_product($cat, $prod_name, $subcat);
	/*
	echo $prod_id;
	echo '<br />'.$prod_name;
	echo '<br />'.$prod_no;
	echo '<br />'.$cat;
	echo '<br />'.$subcat;
	echo '<br />'.$subsubcat;
	echo '<br />'.$catalogue_price;
	echo '<br />'.$less_discount;
	echo '<br />'.$wholesale_price;
	echo '<br />'.$prod_desc;
	echo '<br />'.$designer;
	echo '<br />'.$primary_img;
	echo '<br />'.$primary_img_id;
	echo '<br />'.$new_arrival;
	echo '<br />'.$clearance;
	echo '<br />'.$colors; die();
	*/

	if ($err == '0')
	{
		//$err1 = dateCheck($add_date); // ----> removed in instyle as product date is on per color basis already
		$err1 = '0'; // ----> replace above code
		if ($err1 == '0')
		{
		    $prod_return = move_files($prod_no, $designer, $cat, $subcat);
		
            //exit;  		
		
			$add_date = isset($add_date) ? @date("Y-m-d",@strtotime($add_date)) : '';
			$sql="update tbl_product
			set prod_name='$prod_name',
			prod_no='$prod_no',
			cat_id='$cat',
			subcat_id='$subcat',
			subsubcat_id='$subsubcat',
			prod_date='$add_date',
			prod_desc='$prod_desc',
			catalogue_price='$catalogue_price',
			less_discount='$less_discount',
			wholesale_price='$wholesale_price',
			designer='$designer',
			primary_img='$primary_img',
			primary_img_id='$primary_img_id',
			colors='$colors',
			new_arrival = '$new_arrival',
			clearance = '$clearance'";

			/*if($video!=''){
			$sql.=",video='$video' ";
			}*/
			$sql.=" where prod_no='$prod_no'";

			//echo $sql;
			//exit;

			mysql_query($sql) or die("Edit product error: ".mysql_error());

			return 0;
		}
		else
		{
			$GLOBALS["message"]=$GLOBALS["message"];
			return 1;
		}
	}
	else
	{
		$GLOBALS["message"]=$GLOBALS["message"];
		return 1;
	}
}


function admin_edit_zoom_product($prod_id, $zoom_img1, $zoom_img2, $zoom_img3)
{
			$sqlsel = sprintf("select * from tblzoom_img where prod_id=%d",$prod_id);
			$data = MyQuery($sqlsel);
			
			if($data[0] !=""){

			$sql="update tblzoom_img
			set zoom_img1='$zoom_img1',
			zoom_img2='$zoom_img2',
			zoom_img3='$zoom_img3'
			where prod_id='$prod_id'";
			}
			else
			{
				$sql = sprintf("insert into tblzoom_img (prod_id, zoom_img1, zoom_img2, zoom_img3) values(%d, '%s', '%s', '%s')", $prod_id, $zoom_img1, $zoom_img2, $zoom_img3);
			}

			echo $sql;
			//exit;
			mysql_query($sql)or die("Error");
			if($prod_id==0)
			{
				$sql = sprintf("select prod_id from tblzoom_img where zoom_img1='%s'", $zoom_img1);
				$data = MyQuery($sql);
				$prod_id=$data[0];
			}
			return $prod_id;
}



function add_cart_product($prod_id,$session_cartid,$size_id,$color_id)
{
    if($size_id=='')
    {
        $size_id=0;
    }
    if($color_id=='')
    {
        $color_id=0;
    }

	$to_date=date("Y-m-d");
	$sql="select * from tblcart where cart_id='$session_cartid' and prod_id='$prod_id' and size_cartid='$size_id' and color_cartid='$color_id' ";
	$rs=mysql_query($sql);
	$num_row=mysql_num_rows($rs);
	if($num_row<=0)
	{
		$sql="INSERT INTO tblcart(cart_id,shop_date,prod_id,size_cartid,color_cartid,paid)
                 VALUES ('$session_cartid', '$to_date', '$prod_id','$size_id','$color_id','0')";
		mysql_query($sql) or die("Error");
//		echo $sql;
		return 1;
	}
	else
	{
		//$GLOBALS["message"]="Already added in Cart<br>";
		//return 0;
	}
}

function checkMail(&$supplier_email)
   {

     // checking validity of emailid

        if(!(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$supplier_email)))
        {
          $GLOBALS["message"]="Email not valid.";
          $supplier_email="";
          return 1;
        }
        else
        {
            return 0;
        }
   }

function return_country($country)
{
	$sql="select * from tblcountry where countries_id='$country'";
	$rs=mysql_query($sql);
	$row=mysql_fetch_array($rs);
	//echo $row[countries_name];
	$country_name=$row[countries_name];
	return $country_name;
}

function return_state($state)
{
	$sql="select * from tblstates where state_id='$state'";
	$rs=mysql_query($sql);
	$row=mysql_fetch_array($rs);
   //echo $row[state_name];
	$state_name=$row[state_name];
	return $state_name;
}

function shipping_value_check($fname,$lname,$country,$city,$state,$zip,$email,$add1,$add2)
{

    if($fname==""||$lname==""||$country==""||$city==""||$state==""||$zip==""||$email==""||$add1==""||$add2=="")
    {
        if($fname=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."First Name Can't be blank<br>";
        }
        if($lname=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."Last Name Can't be blank<br>";
        }

        if($country=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."Country Can't be blank<br>";
        }
        if($city=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."City Can't be blank<br>";
        }
        if($state=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."State Can't be blank<br>";
        }
        if($zip=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."Zip Can't be blank<br>";
        }
        if($email=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."Email Address Can't be blank<br>";
        }

		if($add1=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."Address1 Can't be blank.<br>";
        }
		if($add2=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."Address2 Can't be blank.<br>";
        }
		return 1;
    }
	else
	{
		if(checkMail($email)==1)
		{

			return 1;
		}
		else
		{
			return 0;
		}
	}
}


function billing_address_check($fname,$lname,$address,$country,$city,$state,$zip,$email,$add1,$add2)
{
	 if($fname==""||$lname==""||$country==""||$city==""||$state==""||$zip==""||$email==""||$add1==""||$add2=="")
    {
        if($fname=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."First Name Can't be blank<br>";
        }
        if($lname=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."Last Name Can't be blank<br>";
        }

        if($country=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."Country Can't be blank<br>";
        }
        if($city=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."City Can't be blank<br>";
        }
        if($state=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."State Can't be blank<br>";
        }
        if($zip=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."Zip Can't be blank<br>";
        }
        if($email=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."Email Address Can't be blank<br>";
        }
				if($add1=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."Address1 Can't be blank.<br>";
        }
				if($add2=="")
        {
            $GLOBALS["message"]=$GLOBALS["message"]."Address2 Can't be blank.<br>";
        }
				return 1;
    }
	else
	{
		if(checkMail($email)==1)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
}


//Buyer Adding ***************************
function buyer_insert($session_ship_email,$session_ship_fname,$session_ship_lname,$session_ship_phone,$session_ship_add1,$session_ship_add2,$session_ship_city,$session_ship_state,$session_ship_zip,$session_ship_country,$transid,$session_cartid)
{
	$to_date=date("Y-m-d");

	$sql="INSERT INTO tblbuyer_det
       (email, fname, lname, phone, add1, add2, city, state, zip, country, order_id,cart_id)
	VALUES ('$session_ship_email', '$session_ship_fname', '$session_ship_lname', '$session_ship_phone', '$session_ship_add1', '$session_ship_add2', '$session_ship_city', '$session_ship_state', '$session_ship_zip', '$session_ship_country', '$transid','$session_cartid')";

	mysql_query($sql) or die ("Buyer Error");
}

//Submit Order

function order_insert($session_cartid,$qty,$amount,$tax,$transid,$payment_type,$ship_charge,$ship_method,$account_holder,$expire_date,$cvv2,$card_issue_phone)
{
	if($payment_type==1)
	{
		$account_holder="";
		$expire_date="";
		$cvv2="";
		$card_issue_phone="";
	}
	$order_date=date("Y-m-d");

$sql="INSERT INTO tblorder
(order_date,cart_id,qty,amount,taxes, payment_type,payment_status,shipping_charge)
VALUES ('$order_date', '$session_cartid', '$qty', '$amount', '$tax','$payment_type', '0','$ship_charge')";



	 mysql_query($sql) or die("Error 1");

	$sql="select order_id from tblorder order by order_id desc limit 1 ";

    $arrOrd = mysql_query($sql);

	$row = mysql_fetch_assoc($arrOrd);

	//$birow=mysql_fetch_array($birs);

	$transid = $row['order_id'];//order_id


	return $transid;

}

function ship_address($session_ship_bemail,$session_ship_bfname,$session_ship_blname,$session_ship_bphone,$session_ship_bphone,$session_ship_badd1,$session_ship_badd2,$session_ship_bcity,$session_ship_bstate,$session_ship_bzip,$session_ship_bcountry,$session_cartid)
{
	$sql="update tblbuyer_det set
			ship_email='$session_ship_bemail',
		    ship_fname='$session_ship_bfname',
			ship_lname='$session_ship_blname',

			ship_phone='$session_ship_bphone',
			ship_add1='$session_ship_badd1',
			ship_add2='$session_ship_badd2',
			ship_city='$session_ship_bcity',
			ship_state='$session_ship_bstate',
			ship_zip='$session_ship_bzip',
			ship_country='$session_ship_bcountry'
			where cart_id ='$session_cartid'
			";
			mysql_query($sql) or die("Error 2");
			return 0;

}



function showSelected($option,$value)
{
	if($option==$value)
	print "selected" ;
}
function showChecked($option,$value)
{
	if($option==$value)
	print "selected" ;
}

//code added by Infynita to add category

function admin_add_style($cat, $strFile1,$priority,$heading_id,$title,$description,$keyword,$alttags,$url_structure)
{
	$chkcat = "select * from tblstyle where style_name = '$cat' AND heading_id = '$heading_id'";
	$hcat = mysql_query($chkcat);

	if(mysql_num_rows($hcat) <= 0)
	{
		$strFile1        =  strtolower($_FILES["cat_image"]["name"]);
		$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];

    	 //Change the File1 and Update the File1 in db.
		if (!empty($strFile1) && file_exists($strTempFile1))
		{
			if (!empty($strOldFile1) && file_exists("../images/category/".$strOldFile1))
			{
				//Delete the image file from server
				unlink("../images/category/".$strOldFile1);
			}
			$strFileName1   = $strFile1;
			//Upload the File1.
			copy($strTempFile1,"../images/category/".$strFileName1);
			
			gd2resize("../images/category/".$strFileName1,162,125,"../images/category/thumb/","");
   		}

   		if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

	   $strPDF_P =  $_FILES["pdF_price"]["name"];	
	   $strPDF_C =  $_FILES["pdF_color"]["name"];
	   
	   $seq_sql = "select max(ordering) from tblstyle";
			$seq_res = mysql_query($seq_sql);
			$seq_row = mysql_fetch_array($seq_res);
			$seq_num = mysql_num_rows($seq_res);
			
			if($seq_row[0] > 0 && $seq_num == 1):
				$seqes = $seq_row[0] + 1; 
			else:	
				$seqes = 1;
			endif;
	   
	   $sql="insert into tblstyle (style_name,style_img,pdf_p,pdf_c,priority,heading_id,ordering,title,description,keyword,alttags,url_structure) values ('$cat','$strFile1','$strPDF_P','$strPDF_C','$priority','$heading_id','$seqes','".addslashes($title)."','".addslashes($description)."','".addslashes($keyword)."','".addslashes($alttags)."','".addslashes($url_structure)."')";
	   mysql_query($sql)or die("Error in inserting style: ".mysql_error());
	
	   $lat=mysql_insert_id();
	   $imgn="no_img.jpg";
	   $dat=date('Y-m-d');
	   $sbid=0;
	
	   for($cnt=0;$cnt<4;$cnt++)
	   {
			//$sql="insert into tblright (img_name, img_date, cat_id, which_page) values ('$imgn', '$dat', '$sbid', '$lat')";
			//mysql_query($sql);
	   }
  	}else{
      $lat = -1;
  	}
   return $lat;

}

function admin_add_color($cat,$strFile1,$priority,$heading_id,$title,$description,$keyword,$alttags,$url_structure)
{
	$chkcat = "select * from tblcolors where color_name = '$cat' AND heading_id = '$heading_id'";
	$hcat = mysql_query($chkcat);

	if (mysql_num_rows($hcat) <= 0)
	{
		$strFile1        =  strtolower($_FILES["cat_image"]["name"]);
		$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];

    	 //Change the File1 and Update the File1 in db.
		if (!empty($strFile1) && file_exists($strTempFile1))
		{
			if (!empty($strOldFile1) && file_exists("../images/category/".$strOldFile1))
			{
				//Delete the image file from server
				unlink("../images/category/".$strOldFile1);
			}
			$strFileName1   = $strFile1;
			//Upload the File1.
			copy($strTempFile1,"../images/category/".$strFileName1);
			
			gd2resize("../images/category/".$strFileName1,162,125,"../images/category/thumb/","");
   		}

   		if ($strFileName1 == "") $strFileName1 = $strOldFile1;

		$strPDF_P =  $_FILES["pdF_price"]["name"];	
		$strPDF_C =  $_FILES["pdF_color"]["name"];
	   
		$seq_sql = "select max(ordering) from tblcolors";
		$seq_res = mysql_query($seq_sql);
		$seq_row = mysql_fetch_array($seq_res);
		$seq_num = mysql_num_rows($seq_res);
		
		if ($seq_row[0] > 0 && $seq_num == 1):
			$seqes = $seq_row[0] + 1; 
		else:
			$seqes = 1;
		endif;
	   
		$sql = "insert into tblcolors (color_name,color_img,pdf_p,pdf_c,priority,heading_id,ordering,title,description,keyword,alttags,url_structure) values ('$cat','$strFile1','$strPDF_P','$strPDF_C','$priority','$heading_id','$seqes','".addslashes($title)."','".addslashes($description)."','".addslashes($keyword)."','".addslashes($alttags)."','".addslashes($url_structure)."')";
		mysql_query($sql)or die("Error in inserting Color: ".mysql_error());
	
		$lat = mysql_insert_id();
		$imgn = "no_img.jpg";
	    $dat = date('Y-m-d');
		$sbid = 0;
	
		for ($cnt = 0; $cnt < 4; $cnt++)
		{
			//$sql="insert into tblright (img_name, img_date, cat_id, which_page) values ('$imgn', '$dat', '$sbid', '$lat')";
			//mysql_query($sql);
		}
	}
	else
	{
		$lat = -1;
  	}
	return $lat;
}


//code added by Infynita to add category
function admin_add_event($cat, $strFile1,$priority,$heading_id,$title,$description,$keyword,$alttags,$url_structure)
{
   $chkcat = "select * from tblevent where event_name = '$cat'";
   $hcat = mysql_query($chkcat);

   if(mysql_num_rows($hcat) <= 0)
   {
		$strFile1        =  strtolower($_FILES["cat_image"]["name"]);
		$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];

    	 //Change the File1 and Update the File1 in db.
		if (!empty($strFile1) && file_exists($strTempFile1))
		{
			if (!empty($strOldFile1) && file_exists("../images/category/".$strOldFile1))
			{
				//Delete the image file from server
				unlink("../images/category/".$strOldFile1);
			}
			$strFileName1   = $strFile1;
			//Upload the File1.
			copy($strTempFile1,"../images/category/".$strFileName1);
			
			gd2resize("../images/category/".$strFileName1,162,125,"../images/category/thumb/","");
   		}

   		if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

	   $strPDF_P =  $_FILES["pdF_price"]["name"];	
	   $strPDF_C =  $_FILES["pdF_color"]["name"];
	   
	   $seq_sql = "select max(ordering) from tblevent";
			$seq_res = mysql_query($seq_sql);
			$seq_row = mysql_fetch_array($seq_res);
			$seq_num = mysql_num_rows($seq_res);
			
			if($seq_row[0] > 0 && $seq_num == 1):
				$seqes = $seq_row[0] + 1; 
			else:	
				$seqes = 1;
			endif;
	   
	   $sql="insert into tblevent (event_name,event_img,pdf_p,pdf_c,priority,heading_id,ordering,title,description,keyword,alttags,url_structure) values ('$cat','$strFile1','$strPDF_P','$strPDF_C','$priority','$heading_id','$seqes','".addslashes($title)."','".addslashes($description)."','".addslashes($keyword)."','".addslashes($alttags)."','".addslashes($url_structure)."')";
	   mysql_query($sql)or die("Error in inserting Event");
	
	   $lat=mysql_insert_id();
	   $imgn="no_img.jpg";
	   $dat=date('Y-m-d');
	   $sbid=0;
	
	   for($cnt=0;$cnt<4;$cnt++)
	   {
			//$sql="insert into tblright (img_name, img_date, cat_id, which_page) values ('$imgn', '$dat', '$sbid', '$lat')";
			//mysql_query($sql);
	   }
  	}else{
      $lat = -1;
  	}
   return $lat;

}

//code added by webguy same as above but for trends instead of event
function admin_add_material($cat,$strFile1,$priority,$heading_id,$title,$description,$keyword,$alttags,$url_structure)
{
	$chkcat = "select * from tblmaterial where material_name = '$cat' AND heading_id = '$heading_id'";
	$hcat = mysql_query($chkcat);

	if (mysql_num_rows($hcat) <= 0)
	{
		$strFile1        =  strtolower($_FILES["cat_image"]["name"]);
		$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];

		//Change the File1 and Update the File1 in db.
		if (!empty($strFile1) && file_exists($strTempFile1))
		{
			if (!empty($strOldFile1) && file_exists("../images/material/".$strOldFile1))
			{
				//Delete the image file from server
				unlink("../images/material/".$strOldFile1);
			}
			$strFileName1   = $strFile1;
			//Upload the File1.
			copy($strTempFile1,"../images/material/".$strFileName1);
			
			gd2resize("../images/material/".$strFileName1,162,125,"../images/material/thumb/","");
   		}

   		if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

		$strPDF_P =  $_FILES["pdF_price"]["name"];	
		$strPDF_C =  $_FILES["pdF_color"]["name"];
	   
		$seq_sql = "select max(ordering) from tblmaterial";
		$seq_res = mysql_query($seq_sql);
		$seq_row = mysql_fetch_array($seq_res);
		$seq_num = mysql_num_rows($seq_res);
		
		if ($seq_row[0] > 0 && $seq_num == 1):
			$seqes = $seq_row[0] + 1; 
		else:	
			$seqes = 1;
		endif;
	   
		$sql = "insert into tblmaterial (material_name,material_img,pdf_p,pdf_c,priority,heading_id,ordering,title,description,keyword,alttags,url_structure) values ('$cat','$strFile1','$strPDF_P','$strPDF_C','$priority','$heading_id','$seqes','".addslashes($title)."','".addslashes($description)."','".addslashes($keyword)."','".addslashes($alttags)."','".addslashes($url_structure)."')";
		mysql_query($sql)or die("Error in inserting material: ".mysql_error());
	
		$lat=mysql_insert_id();
		$imgn="no_img.jpg";
		$dat=date('Y-m-d');
		$sbid=0;
	
		for($cnt=0;$cnt<4;$cnt++)
		{
			//$sql="insert into tblright (img_name, img_date, cat_id, which_page) values ('$imgn', '$dat', '$sbid', '$lat')";
			//mysql_query($sql);
		}
  	}
	else
	{
		$lat = -1;
  	}
	return $lat;
}

function admin_add_trend($cat,$strFile1,$priority,$heading_id,$title,$description,$keyword,$alttags,$url_structure)
{
	$chkcat = "select * from tbltrend where trend_name = '$cat' AND heading_id = '$heading_id'";
	$hcat = mysql_query($chkcat);

	if (mysql_num_rows($hcat) <= 0)
	{
		$strFile1        =  strtolower($_FILES["cat_image"]["name"]);
		$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];

		//Change the File1 and Update the File1 in db.
		if (!empty($strFile1) && file_exists($strTempFile1))
		{
			if (!empty($strOldFile1) && file_exists("../images/trend/".$strOldFile1))
			{
				//Delete the image file from server
				unlink("../images/trend/".$strOldFile1);
			}
			$strFileName1   = $strFile1;
			//Upload the File1.
			copy($strTempFile1,"../images/trend/".$strFileName1);
			
			gd2resize("../images/trend/".$strFileName1,162,125,"../images/trend/thumb/","");
   		}

   		if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

		$strPDF_P =  $_FILES["pdF_price"]["name"];	
		$strPDF_C =  $_FILES["pdF_color"]["name"];
	   
		$seq_sql = "select max(ordering) from tbltrend";
		$seq_res = mysql_query($seq_sql);
		$seq_row = mysql_fetch_array($seq_res);
		$seq_num = mysql_num_rows($seq_res);
			
		if ($seq_row[0] > 0 && $seq_num == 1):
			$seqes = $seq_row[0] + 1; 
		else:	
			$seqes = 1;
		endif;
	   
		$sql = "insert into tbltrend (trend_name,trend_img,pdf_p,pdf_c,priority,heading_id,ordering,title,description,keyword,alttags,url_structure) values ('$cat','$strFile1','$strPDF_P','$strPDF_C','$priority','$heading_id','$seqes','".addslashes($title)."','".addslashes($description)."','".addslashes($keyword)."','".addslashes($alttags)."','".addslashes($url_structure)."')";
		mysql_query($sql)or die("Error in inserting trend: ".mysql_error());
	
		$lat=mysql_insert_id();
		$imgn="no_img.jpg";
		$dat=date('Y-m-d');
		$sbid=0;
	
		for($cnt=0;$cnt<4;$cnt++)
		{
			//$sql="insert into tblright (img_name, img_date, cat_id, which_page) values ('$imgn', '$dat', '$sbid', '$lat')";
			//mysql_query($sql);
		}
  	}
	else
	{
      $lat = -1;
  	}
	return $lat;
}

function admin_add_category($cat, $strFile1, $priority, $heading_id, $title, $description, $keyword, $alttags, $url_structure)
{
	$chkcat = "select * from tblcat where cat_name = '$cat'";
	$hcat = mysql_query($chkcat);

	if (mysql_num_rows($hcat) <= 0)
	{
		$strFile1        =  strtolower($_FILES["cat_image"]["name"]);
		$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];

		//Change the File1 and Update the File1 in db.
		if ( ! empty($strFile1) && file_exists($strTempFile1))
		{
			if ( ! empty($strOldFile1) && file_exists("../images/category/".$strOldFile1))
			{
				//Delete the image file from server
				unlink("../images/category/".$strOldFile1);
			}
			$strFileName1   = $strFile1;
			//Upload the File1.
			copy($strTempFile1,"../images/category/".$strFileName1);
			
			gd2resize("../images/category/".$strFileName1,162,125,"../images/category/thumb/","");
   		}

   		if (isset($strFileName1) && $strFileName1 == "") { $strFileName1 = $strOldFile1; }

		$strPDF_P =  $_FILES["pdF_price"]["name"];	
		$strPDF_C =  $_FILES["pdF_color"]["name"];
	   
		$seq_sql = "select max(ordering) from tblcat";
			$seq_res = mysql_query($seq_sql);
			$seq_row = mysql_fetch_array($seq_res);
			$seq_num = mysql_num_rows($seq_res);
			
			if ($seq_row[0] > 0 && $seq_num == 1):
				$seqes = $seq_row[0] + 1; 
			else:
				$seqes = 1;
			endif;
	   
		$sql = "
			INSERT INTO tblcat (
				cat_name,
				cat_img,
				folder,
				pdf_p,
				pdf_c,
				priority,
				heading_id,
				ordering,
				title,
				description,
				keyword,
				alttags,
				url_structure
			) VALUES (
				'$cat',
				'$strFile1',
				'".strtoupper($url_structure)."',
				'$strPDF_P',
				'$strPDF_C',
				'$priority',
				'".(int)($heading_id)."',
				'$seqes',
				'".addslashes($title)."',
				'".addslashes($description)."',
				'".addslashes($keyword)."',
				'".addslashes($alttags)."',
				'".addslashes($url_structure)."'
			)
		";
		mysql_query($sql)or die("Error in inserting Category - ".mysql_error());
	
		$lat = mysql_insert_id();
		$imgn = "no_img.jpg";
		$dat = date('Y-m-d');
		$sbid = 0;
	
		for ($cnt = 0; $cnt < 4; $cnt++)
		{
			$sql = "insert into tblright (img_name, img_date, cat_id, which_page) values ('$imgn', '$dat', '$sbid', '$lat')";
			mysql_query($sql);
		}
  	}
	else
	{
		$lat = -1;
  	}
	return $lat;
}

function admin_add_mcategory($cat, $strFile1,$priority)
{
   $chkcat = "select * from tblmajcat where cat_name = '$cat'";
   $hcat = mysql_query($chkcat);

   if(mysql_num_rows($hcat) <= 0)
   {
		$strFile1        =  strtolower($_FILES["cat_image"]["name"]);
		$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];

    	 //Change the File1 and Update the File1 in db.
		if (!empty($strFile1) && file_exists($strTempFile1))
		{
			if (!empty($strOldFile1) && file_exists("../images/category/".$strOldFile1))
			{
				//Delete the image file from server
				unlink("../images/category/".$strOldFile1);
			}
			$strFileName1   = $strFile1;
			//Upload the File1.
			copy($strTempFile1,"../images/category/".$strFileName1);
			
			gd2resize("../images/category/".$strFileName1,162,125,"../images/category/thumb/","");
   		}

   		if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

	   $strPDF_P =  $_FILES["pdF_price"]["name"];	
	   $strPDF_C =  $_FILES["pdF_color"]["name"];
	   $sql="insert into tblmajcat (cat_name,cat_img,pdf_p,pdf_c,priority) values ('$cat','$strFile1','$strPDF_P','$strPDF_C','$priority')";
	   mysql_query($sql)or die("Error in inserting Category");
	
	   $lat=mysql_insert_id();
	   $imgn="no_img.jpg";
	   $dat=date('Y-m-d');
	   $sbid=0;
	
	   for($cnt=0;$cnt<4;$cnt++)
	   {
			$sql="insert into tblmright (img_name, img_date, cat_id, which_page) values ('$imgn', '$dat', '$sbid', '$lat')";
			mysql_query($sql);
	   }
  	}else{
      $lat = -1;
  	}
   return $lat;

}
function admin_newcatimg($strFile1, $catid)
{
	$strFile1        =  strtolower($_FILES["cat_image"]["name"]);
	//echo "<br>";
	$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];
	//echo "<br>";
     //Change the File1 and Update the File1 in db.
	if (!empty($strFile1) && file_exists($strTempFile1))
	{
		if (!empty($strOldFile1) && file_exists("../images/category/".$strOldFile1))
		{
				//Delete the image file from server
				unlink("../images/category/".$strOldFile1);
				unlink("../images/category/thumb/".$strOldFile1);
		}
		$strFileName1   = $strFile1;
		//Upload the File1.
		copy($strTempFile1,"../images/category/".$strFileName1);
		gd2resize("../images/category/".$strFileName1,162,125,"../images/category/thumb/","");
   }
	
   if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

   $sql="update tblcat set cat_img='$strFile1' where cat_id ='$catid'";
   //echo "<br>";
			mysql_query($sql) or die("Error updating tblcat");

	$sql="update tblindex set main_img='$strFile1' where cat_id ='$catid'";
   mysql_query($sql) or die("Error updating tblsubcat");

}
function admin_newmcatimg($strFile1, $catid)
{
	$strOldFile1=$strFile1        =  strtolower($_FILES["cat_image"]["name"]);
	//echo "<br>";
	$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];
	//echo "<br>";
     //Change the File1 and Update the File1 in db.
	if (!empty($strFile1) && file_exists($strTempFile1))
	{
		if (!empty($strOldFile1) && file_exists("../images/category/".$strOldFile1))
		{
				//Delete the image file from server
				unlink("../images/category/".$strOldFile1);
				unlink("../images/category/thumb/".$strOldFile1);
		}
		$strFileName1   = $strFile1;
		//Upload the File1.
		copy($strTempFile1,"../images/category/".$strFileName1);
		gd2resize("../images/category/".$strFileName1,200,262,"../images/category/thumb/","");
   }
	
   if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

   $sql="update tblmajcat set cat_img='$strFile1' where cat_id ='$catid'";
//  echo "<br>".$sql;
			mysql_query($sql) or die("Error updating tblcat".mysql_error());

	//$sql="update tblindex set main_img='$strFile1' where cat_id ='$catid'";
   //mysql_query($sql) or die("Error updating tblsubcat");

}
function admin_newsmallcatimg($strFile1, $catid)
{
	$strFile1        =  $_FILES["prod_image"]["name"];
	//echo "<br>";
	$strTempFile1    =  $_FILES["prod_image"]["tmp_name"];
	//echo "<br>";
     //Change the File1 and Update the File1 in db.
	if (!empty($strFile1) && file_exists($strTempFile1))
	{
		if (!empty($strOldFile1) && file_exists("../images/smallcategory/".$strOldFile1))
		{
				//Delete the image file from server
				unlink("../images/smallcategory/".$strOldFile1);
		}
		$strFileName1   = $strFile1;
		//Upload the File1.
		copy($strTempFile1,"../images/smallcategory/".$strFileName1);
   }

   if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

   $sql="update tblcat set img_name='$strFile1' where cat_id ='$catid'";
   //echo "<br>";
			mysql_query($sql) or die("Error updating tblcat");

}

function admin_ins_subcat($catid, $subname,$title,$description,$keyword,$alttags,$url_structure,$footer_text)
{
	$chksubcat = "select * from tblsubcat where cat_id = '$catid' and subcat_name = '$subname'";
	$hsubcat = mysql_query($chksubcat);
	
	if (mysql_num_rows($hsubcat) <= 0 )
	{
		$strFile1        =  $_FILES["i_image"]["name"];
		$strTempFile1    =  $_FILES["i_image"]["tmp_name"];
		
		if ( ! empty($strFile1) && file_exists($strTempFile1))
		{
			$randomno = RandomNumber(5);
			$strFileName1 = $randomno.strtolower($strFile1);
			
			//Upload the File1.
			copy($strTempFile1,"../images/subcategory_icon/".$strFileName1);
			// Copy to image repo
			copy($strTempFile1, IMG_REPO_URL_VAR."images/subcategory_icon/".$strFileName1);

			gd2resize("../images/subcategory_icon/".$strFileName1,169,129,"../images/subcategory_icon/thumb/","");
			gd2resize("../images/subcategory_icon/".$strFileName1,579,446,"../images/subcategory_icon/zoom/","");
			// at image repo
			gd2resize(IMG_REPO_URL_VAR."images/subcategory_icon/".$strFileName1,169,129,IMG_REPO_URL_VAR."images/subcategory_icon/thumb/","");
			gd2resize(IMG_REPO_URL_VAR."images/subcategory_icon/".$strFileName1,579,446,IMG_REPO_URL_VAR."images/subcategory_icon/zoom/","");
		}
		else $strFileName1 = '';
		
		$strPDF_P = '';	
	   	$strPDF_C = '';
		
	    $seq_sql = "select max(ordering) from tblsubcat where cat_id='".$catid."'";
		$seq_res = mysql_query($seq_sql);
		$seq_row = mysql_fetch_array($seq_res);
		$seq_num = mysql_num_rows($seq_res);
		
		if($seq_row[0] > 0 && $seq_num == 1):
			$seqes = $seq_row[0] + 1; 
		else:	
			$seqes = 1;
		endif;
		
		$insert_query="insert into tblsubcat(subcat_name,cat_id,icon_img,folder,pdf_c,ordering,title,description,keyword,alttags,url_structure,footer)values('$subname','$catid','$strFileName1','".strtolower($url_structure)."','$strPDF_C','$seqes','".addslashes($title)."','".addslashes($description)."','".addslashes($keyword)."','".addslashes($alttags)."','".addslashes($url_structure)."','".addslashes($footer_text)."')";
		$result = mysql_query($insert_query) or die('Error inserting new sub cat: '.mysql_error());
		
		$lat = mysql_insert_id();
	}else{
	    $lat = -1;
	}
	return $lat;
}

function admin_ins_subsubcat($catid,$subcatid,$subname,$title,$description,$keyword,$alttags,$url_structure)
{
	
	$chksubcat = "select * from tblsubsubcat where cat_id ='$catid' and subcat_id ='$subcatid' and name = '$subname'";
	$hsubcat = mysql_query($chksubcat);
	
	if (mysql_num_rows($hsubcat) <= 0 )
	{
		$strFile1        =  $_FILES["i_image"]["name"];
		$strTempFile1    =  $_FILES["i_image"]["tmp_name"];
		
		if ( ! empty($strFile1) && file_exists($strTempFile1))
		{
			/*if (!empty($strOldFile1) && file_exists("../images/subcategory_icon/".$strOldFile1))
			{
					//Delete the image file from server
					unlink("../images/subcategory_icon/".$strOldFile1);
			}*/
		
			$randomno=RandomNumber(5);
			$strFileName1   = $randomno.strtolower($strFile1);
			
			//Upload the File1.
			copy($strTempFile1,"../images/subsubcategory_icon/".$strFileName1);
			// Copy to image repo
			copy($strTempFile1, IMG_REPO_URL_VAR."images/subsubcategory_icon/".$strFileName1);

			gd2resize("../images/subsubcategory_icon/".$strFileName1,169,129,"../images/subsubcategory_icon/thumb/","");
			//gd2resize("../images/subcategory_icon/".$strFileName1,579,446,"../images/subcategory_icon/zoom/","");
			// at image repo
			gd2resize(IMG_REPO_URL_VAR."images/subsubcategory_icon/".$strFileName1,169,129,IMG_REPO_URL_VAR."images/subsubcategory_icon/thumb/","");
		}
		
		//$strPDF_P =  strtolower($_FILES["pdF_price"]["name"]);	
	   	//$strPDF_C =  strtolower($_FILES["pdF_color"]["name"]);
		
			$seq_sql = "select max(ordering) from tblsubsubcat where cat_id='".$catid."' and subcat_id='".$subcatid."'";
			$seq_res = mysql_query($seq_sql);
			$seq_row = mysql_fetch_array($seq_res);
			$seq_num = mysql_num_rows($seq_res);
			
			if($seq_row[0] > 0 && $seq_num == 1):
				$seqes = $seq_row[0] + 1; 
			else:	
				$seqes = 1;
			endif;
			
		if (isset($strFileName1) && $strFileName1 != '') $file_name = $strFileName1;
		else $file_name = NULL;
		
		$insert_query = "
			insert into tblsubsubcat (
				name,
				cat_id,
				subcat_id,
				icon_img,
				folder,
				ordering,
				title,
				description,
				keyword,
				alttags,
				url_structure
			) values (
				'$subname',
				'$catid',
				'$subcatid',
				'$file_name',
				'$url_structure',
				'$seqes',
				'".addslashes($title)."',
				'".addslashes($description)."',
				'".addslashes($keyword)."',
				'".addslashes($alttags)."',
				'".addslashes($url_structure)."'
			)
		";
		mysql_query($insert_query) or die(mysql_error());
		
		$lat = mysql_insert_id();
	}
	else
	{
	    $lat = -1;
	}
	return $lat;
}

function admin_ins_typecat($type_name,$heading,$title,$description,$keyword,$alttags)
{
	
	
	$chksubcat = "select * from tbltypecat where type_name = '$type_name' and heading_id='$heading'";
	$hsubcat = mysql_query($chksubcat);
	if(mysql_num_rows($hsubcat) <= 0 )
	{
		$insert_query="insert into tbltypecat(type_name,heading_id,title,description,keyword,alttags)values('$type_name','$heading','".addslashes($title)."','".addslashes($description)."','".addslashes($keyword)."','".addslashes($alttags)."')";
		mysql_query($insert_query);
		$lat=mysql_insert_id();
	}else{
	    $lat = -1;
	}
	return $lat;
}
function admin_ins_typesubcat($type_name,$heading,$title,$description,$keyword,$alttags)
{
	
	$chksubcat = "select * from tbltypesubcat where type_name = '$type_name' and heading_id='$heading'";
	$hsubcat = mysql_query($chksubcat);
	if(mysql_num_rows($hsubcat) <= 0 )
	{
		$insert_query="insert into tbltypesubcat(type_name,heading_id,title,description,keyword,alttags)values('$type_name','$heading','".addslashes($title)."','".addslashes($description)."','".addslashes($keyword)."','".addslashes($alttags)."')";
		mysql_query($insert_query);
		$lat=mysql_insert_id();
	}else{
	    $lat = -1;
	}
	return $lat;
}
function admin_add_sub_img($subid, $strFile1)
{
		$strFile1        =  $_FILES["prod_image"]["name"];
		$strTempFile1    =  $_FILES["prod_image"]["tmp_name"];
		//Change the File1 and Update the File1 in db.
		if (!empty($strFile1) && file_exists($strTempFile1))
		{
			if (!empty($strOldFile1) && file_exists("../images/subcategory/".$strOldFile1))
			{
					//Delete the image file from server
					unlink("../images/subcategory/".$strOldFile1);
			}
			$strFileName1   = $strFile1;
			//Upload the File1.
			copy($strTempFile1,"../images/subcategory/".$strFileName1);
	   }

	   if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

	   $sql="update tblsubcat set img_name='$strFile1' where subcat_id ='$subid'";
	   //echo "<br>";
			mysql_query($sql) or die("Error updating tblsubcat");
}


function admin_addsubimg_catindex($subid, $catid, $strFile1)
{
	$strFile1        =  $_FILES["prod_image"]["name"];
	$strTempFile1    =  $_FILES["prod_image"]["tmp_name"];
	$sql="select * from tblright where which_page='$catid'";
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);
	$d=date('Y-m-d');
	if($num<4)
	{
		$sel="insert into tblright (img_name, img_date, cat_id, which_page) values ('$strFile1', '$d', '$subid', '$catid')";
		mysql_query($sel) or die("Error inserting tbright");
	}
	else
	{
			$sql1="select * from tblright where which_page ='$catid' order by img_date ASC limit 1";
			$r=mysql_query($sql1);
			$idc=mysql_result($r,0,0);
			$d=date('Y-m-d');

			$sql="update tblright set img_name='$strFile1',
			img_date='$d',
			cat_id='$subid'
			where Id='$idc'";
			mysql_query($sql) or die("Error updating tbright");
	}
}


function admin_newsubcatimg($strFile1, $catid)
{
	$strFile1        =  $_FILES["cat_image"]["name"];
	//echo "<br>";
	$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];
	//echo "<br>";
     //Change the File1 and Update the File1 in db.
	if (!empty($strFile1) && file_exists($strTempFile1))
	{
		if (!empty($strOldFile1) && file_exists("../images/subcategory/".$strOldFile1))
		{
				//Delete the image file from server
				unlink("../images/subcategory/".$strOldFile1);
		}
		$strFileName1   = $strFile1;
		//Upload the File1.
		copy($strTempFile1,"../images/subcategory/".$strFileName1);
   }

   if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

   $sql="update tblsubcat set img_name='$strFile1' where subcat_id ='$catid'";
   mysql_query($sql) or die("Error updating tblsubcat");

   $sql="update tblright set img_name='$strFile1' where cat_id ='$catid'";
   mysql_query($sql) or die("Error updating tblsubcat");

}


function admin_newtrendimg($strFile1, $catid)
{
	$strFile1        =  $_FILES["cat_image"]["name"];
	//echo "<br>";
	$strTempFile1    =  $_FILES["cat_image"]["tmp_name"];
	//echo "<br>";
     //Change the File1 and Update the File1 in db.
	if (!empty($strFile1) && file_exists($strTempFile1))
	{
		if (!empty($strOldFile1) && file_exists("../images/trend/".$strOldFile1))
		{
				//Delete the image file from server
				unlink("../images/trend/".$strOldFile1);
		}
		$strFileName1   = $strFile1;
		//Upload the File1.
		copy($strTempFile1,"../images/trend/".$strFileName1);
   }

   if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

   $sql="update tbltrend set trend_img='$strFile1' where trend_id ='$catid'";
   mysql_query($sql) or die("Error updating tbltrend");

}


function get_main_categories()
{
  $select="select * from tblmaincat order by main_cat_name asc";
  $result=mysql_query($select);
  echo "<select name='cat' class=combobig><option value=''>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      echo"<option value='$row[maincat_id]'>$row[main_cat_name]</option>";
  }
  echo "</select>";
}

function get_trends()
{
  $select="select * from tbltrend order by trend_name asc";
  $result=mysql_query($select);
  echo "<select name='trend' class=combobig><option value=''>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      echo"<option value='$row[trend_id]'>$row[trend_name]</option>";
  }
  echo "</select>";
}

function get_trends_add_prod()
{
  $select="select * from tbltrend order by trend_name asc";
  $result=mysql_query($select);
  echo "<select name='trend' class=combobig onchange='submit_form()'><option value='0'>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      echo"<option value='$row[trend_id]'>$row[trend_name]</option>";
  }
  echo "</select>";
}



function admin_ins_manu($manuname)
{
	$chkmanu = "select * from tblmanufacturer where manufacturer_name = '$manuname'";
	$hmanu = mysql_query($chkmanu);
	if(mysql_num_rows($hmanu) <= 0)
	{
		$insert_query="insert into tblmanufacturer(manufacturer_name)values('$manuname')";
		mysql_query($insert_query);
		$lat=mysql_insert_id();
	}else
	    $lat = -1;
	return $lat;
}

function admin_add_manu_img($subid,$strFile1)
	{

	        $strFile1  =  $_FILES["prod_image"]["name"];
			$strTempFile1   =  $_FILES["prod_image"]["tmp_name"];

			//Change the File1 and Update the File1 in db.
			if (!empty($strFile1) && file_exists($strTempFile1))
			{
				if (!empty($strOldFile1) && file_exists("../images/manufaturer/".$strOldFile1))
				{
						//Delete the image file from server
						unlink("../images/manufaturer/".$strOldFile1);
				}
				$strFileName1   = $strFile1;
				//Upload the File1.
				copy($strTempFile1,"../images/manufaturer/".$strFileName1);
		   }

		   if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }



		  $sql="update tblmanufacturer set img_name='$strFile1' where manufacturer_id ='$subid'";
		  mysql_query($sql) or die("Error updating tblsubcat");

}


function admin_add_small_manu_img($subid,$strFile2)
{
	$strFile2        =  $_FILES["cat_image"]["name"];
	$strTempFile2    =  $_FILES["cat_image"]["tmp_name"];

	   //Change the File2 and Update the File2 in db.
	if (!empty($strFile2) && file_exists($strTempFile2))
	{
		if (!empty($strOldFile2) && file_exists("../images/smallmanufaturer/".$strOldFile2))
		{
				//Delete the image file from server
				unlink("../images/smallmanufaturer/".$strOldFile2);
		}
		$strFileName2   = $strFile2;
		//Upload the File2.
		copy($strTempFile2,"../images/smallmanufaturer/".$strFileName2);
	 }

   if ($strFileName2 == "") { $strFileName2 = $strOldFile2; }

   $sql="update tblmanufacturer set small_img='$strFile2' where manufacturer_id ='$subid'";
   mysql_query($sql) or die("Error updating tblsubcat");
}

function add_manu_tblmandt($subid)
{
	$sbid=0;
	for($cnt=0;$cnt<4;$cnt++)
	{
		$sql="insert into tblmandt (manu_id, subcat_id) values ('$subid', '$sbid')";
		mysql_query($sql);
	}
}



function manu_ins_subcat($catid, $subname, $strFile1)
{
	
	$chkmsubcat = "select * from tblmanusubcat where manu_id = '$catid' and sub_cat_name = '$subname' ";
	$hmsubcat = mysql_query($chkmsubcat);
	
	if(mysql_num_rows($hmsubcat) <= 0)
	{
		$strFile1        =  $_FILES["prod_image"]["name"];
		$strTempFile1    =  $_FILES["prod_image"]["tmp_name"];
	
		 //Change the File1 and Update the File1 in db.
		if (!empty($strFile1) && file_exists($strTempFile1))
		{
			if (!empty($strOldFile1) && file_exists("../images/submanufaturer/".$strOldFile1))
			{
					//Delete the image file from server
					unlink("../images/submanufaturer/".$strOldFile1);
			}
			$strFileName1   = $strFile1;
			//Upload the File1.
			copy($strTempFile1,"../images/submanufaturer/".$strFileName1);
	   }
	
		if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }
	
		$insert_query="insert into tblmanusubcat(manu_id, sub_cat_name, img_name)values('$catid','$subname', '$strFile1')";
		mysql_query($insert_query);
		$lat=mysql_insert_id();
	}else
		$lat = -1;
	return $lat;
}

	

function  admin_add_products_img($lat, $cnt)
{
	    	$nam='prod_image'.$cnt;
	    	$strFile1        =  strtolower($_FILES[$nam]["name"]);
	     	$strTempFile1    =  $_FILES[$nam]["tmp_name"];
			$randomno_1=RandomNumber(4);
			$randomno_2=RandomNumber(4);
         	//Change the File1 and Update the File1 in db.
		if (!empty($strFile1) && file_exists($strTempFile1))
	     	{
		 	if (!empty($strOldFile1) && file_exists("../product_picture/".$strOldFile1))
			{
				//Delete the image file from server
				unlink("../product_picture/".$strOldFile1);
			}
			$strFileName1   = $randomno_1.$strFile1;
			//Upload the File1.
			copy($strTempFile1,"product_picture/".$strFileName1);

			gd2resize("product_picture/".$strFileName1,162,125,"product_picture/thumb/","");
			gd2resize("product_picture/".$strFileName1,300,220,"product_picture/medium/","");
			gd2resize("product_picture/".$strFileName1,579,446,"product_picture/zoom/","");
			gd2resize("product_picture/".$strFileName1,63,42,"product_picture/mini_thumb/","");
			//gd2resize("product_picture/".$strFileName1,250,"product_picture/","");
			
			$sql="update tblproduct set prod_image0='$strFileName1' where prod_id ='$lat'";
			mysql_query($sql) or die("Error updating tblproduct");
			
		    }
               	//if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

      		$strFile1_2        =  strtolower($_FILES["sketch_img"]["name"]);
			$strTempFile1_2    =  $_FILES["sketch_img"]["tmp_name"]; 
			$strFileName2= $randomno_2.$strFile1_2;	
			
		 if($strFile1_2!=''){	
			copy($strTempFile1_2,"product_picture/sketch/big/".$strFileName2);
			gd2resize("product_picture/sketch/big/".$strFileName2,162,125,"product_picture/sketch/",""); 
			gd2resize("product_picture/sketch/big/".$strFileName2,579,446,"product_picture/sketch/zoom/",""); 	
			
			$sql="update tblproduct set sketch_img='$strFileName2' where prod_id ='$lat'";
			mysql_query($sql) or die("Error updating tblproduct");
		}		

}

function add_prodcut_details_fun($pid, $pname, $pprice, $pprice2, $pdprice, $pdesc, $num, $call_price_y)
{
	
	if($call_price_y=='yes'){
		$color_price_ = $pdprice;//round(($pdprice)+($pdprice*8/100));
	}else{
		$color_price_ = 0;
	}	
	 
	if($num > 0){
		
		if(empty($pprice2) == true){ $pprice2=0; }
		$insert_query = "UPDATE `tblproduct_details` SET ";
		$insert_query.= "`p_name`='".$pname."',";
		$insert_query.= "`price`=". $pprice.",";
		$insert_query.= "`price2`='".$pprice2."',";
		$insert_query.= "`color_price`='".$color_price_."',";
		$insert_query.= "`discount`=".$pdprice.",";
		$insert_query.= "`p_desc`='".$pdesc."'";
		$insert_query.= " WHERE `prod_id`='".$pid."'";
		
	}else{
		$insert_query="insert into tblproduct_details(prod_id, p_name, price, price2, color_price, discount, p_desc) values ('$pid','$pname','$pprice', '$pprice2','$color_price_','$pdprice','$pdesc')";
	}
	
	mysql_query($insert_query);
	$s="select * from tblproduct where prod_id='$pid'";
	$result=mysql_query($s);
	$row=mysql_fetch_array($result);
	$cnt=$row['no_part'];
	$cnt=$cnt+1;
	$sql="update tblproduct set no_part='$cnt' where prod_id ='$pid'";
	mysql_query($sql);
}

function add_prodcut_size_fun($pid, $prid, $woodtype, $siid1, $siid2, $siid3, $siid4, $siid5, $coid, $pstock)
{
	$insert_query="insert into tblproduct_size (prod_id, part_id, wood_type, size_id1,size_id2,size_id3, size_id4, size_id5,  color_id, stock) values ('$pid','$prid', '$woodtype','$siid1','$siid2','$siid3','$siid4','$siid5','$coid','$pstock')";
	mysql_query($insert_query);
}

function get_subcategories_toshow($cat_id, $sub_id, $cnt)
{
  $nam="subcat".$cnt;
  $select="select * from tblsubcat where cat_id='$cat_id' order by subcat_name asc";
  $result=mysql_query($select);
  echo "<select name='$nam' class=combobig><option value='0'>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      if($sub_id!=$row[subcat_id])
      {
      		echo"<option value='$row[subcat_id]'>$row[subcat_name]</option>";
      }
      else
      {
      		echo"<option value='$row[subcat_id]' selected>$row[subcat_name]</option>";
      }
  }
  echo "</select>";

}

function update_table_right($sub_id, $cat_id, $rid)
{
	if($sub_id!='0')
	{
		$sel="select * from tblsubcat where subcat_id='$sub_id'";
		$result=mysql_query($sel);
		$row=mysql_fetch_array($result);
		$imgn=$row[img_name];
		$dat=date('Y-m-d');

		$sql="update tblright set img_name='$imgn', img_date='$dat', cat_id='$sub_id' where which_page ='$cat_id' and Id='$rid'";
		mysql_query($sql);
   }
}


function get_subcatmanu_toshow($cat_id, $sub_id, $cnt)
{
  $nam="subcat".$cnt;
  $select="select * from tblmanusubcat where manu_id='$cat_id' order by sub_cat_name asc";
  $result=mysql_query($select);
  echo "<select name='$nam' class=combobig><option value='0'>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      if($sub_id!=$row[sub_cat_id])
      {
      		echo"<option value='$row[sub_cat_id]'>$row[sub_cat_name]</option>";
      }
      else
      {
      		echo"<option value='$row[sub_cat_id]' selected>$row[sub_cat_name]</option>";
      }
  }
  echo "</select>";

}

function get_subcattrend_toshow($cat_id, $sub_id, $cnt)
{
  $nam="subcat".$cnt;
  $select="select * from tbltrendsubcat where trend_id='$cat_id' order by subcat_name asc";
  $result=mysql_query($select);
  echo "<select name='$nam' class=combobig><option value='0'>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      if($sub_id!=$row[subcat_id])
      {
      		echo"<option value='$row[subcat_id]'>$row[subcat_name]</option>";
      }
      else
      {
      		echo"<option value='$row[subcat_id]' selected>$row[subcat_name]</option>";
      }
  }
  echo "</select>";

}

function update_table_manu($sub_id, $cat_id, $rid)
{
	if($sub_id!='0')
	{
		$sql="update tblmandt set subcat_id='$sub_id' where manu_id='$cat_id' and det_id='$rid'";
		mysql_query($sql);
   }
}

function update_table_trend($sub_id, $cat_id, $rid)
{
	if($sub_id!='0')
	{
		$sql="update tblmandt set subcat_id='$sub_id' where trend_id='$cat_id' and det_id='$rid'";
		mysql_query($sql);
   }
}


function trend_ins_subcat($catid, $subname, $strFile1)
{

	$chktsubcat = "select * from tbltrendsubcat where trend_id = '$catid' and subcat_name = '$subname' ";
	$htsubcat = mysql_query($chktsubcat);
	
	if(mysql_num_rows($htsubcat) <= 0)
	{
		$strFile1        =  $_FILES["prod_image"]["name"];
		$strTempFile1    =  $_FILES["prod_image"]["tmp_name"];
	
		 //Change the File1 and Update the File1 in db.
		if (!empty($strFile1) && file_exists($strTempFile1))
		{
			if (!empty($strOldFile1) && file_exists("../images/subtrend/".$strOldFile1))
			{
					//Delete the image file from server
					unlink("../images/subtrend/".$strOldFile1);
			}
			$strFileName1   = $strFile1;
			//Upload the File1.
			copy($strTempFile1,"../images/subtrend/".$strFileName1);
	   }
	
		if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }
	
		$insert_query="insert into tbltrendsubcat (trend_id, subcat_name, img_name)values('$catid','$subname', '$strFile1')";
		mysql_query($insert_query);
		$lat=mysql_insert_id();
   }else
        $lat = -1;
	return $lat;
}


function update_submanu_img($subid,$strFile1)
{
	        $strFile1  =  $_FILES["prod_image"]["name"];
			$strTempFile1   =  $_FILES["prod_image"]["tmp_name"];

			//Change the File1 and Update the File1 in db.
			if (!empty($strFile1) && file_exists($strTempFile1))
			{
				if (!empty($strOldFile1) && file_exists("../images/submanufaturer/".$strOldFile1))
				{
						//Delete the image file from server
						unlink("../images/submanufaturer/".$strOldFile1);
				}
				$strFileName1   = $strFile1;
				//Upload the File1.
				copy($strTempFile1,"../images/submanufaturer/".$strFileName1);
		   }

		   if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

		  $sql="update tblmanusubcat set img_name='$strFile1' where sub_cat_id ='$subid'";
		  mysql_query($sql) or die("Error updating tblsubcat");
}


function update_subtrend_img($subid,$strFile1)
{
	        $strFile1  =  $_FILES["prod_image"]["name"];
			$strTempFile1   =  $_FILES["prod_image"]["tmp_name"];

			//Change the File1 and Update the File1 in db.
			if (!empty($strFile1) && file_exists($strTempFile1))
			{
				if (!empty($strOldFile1) && file_exists("../images/subtrend/".$strOldFile1))
				{
						//Delete the image file from server
						unlink("../images/subtrend/".$strOldFile1);
				}
				$strFileName1   = $strFile1;
				//Upload the File1.
				copy($strTempFile1,"../images/subtrend/".$strFileName1);
		   }

		   if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }

		  $sql="update tbltrendsubcat set img_name='$strFile1' where subcat_id ='$subid'";
		  mysql_query($sql) or die("Error updating tblsubcat");
}


function admin_ins_trend($trendname)
{
	$chktrend = "select * from tbltrend where trend_name = '$trendname' ";
	$htrend = mysql_query($chktrend);
	
	if(mysql_num_rows($htrend) <= 0)
	{
		$insert_query="insert into tbltrend(trend_name)values('$trendname')";
		mysql_query($insert_query);
		$lat=mysql_insert_id();
	}else
	    $lat = -1;
	return $lat;
}

function admin_add_trend_img($subid,$strFile1)
	{

	        $strFile1  =  $_FILES["prod_image"]["name"];
			$strTempFile1   =  $_FILES["prod_image"]["tmp_name"];

			//Change the File1 and Update the File1 in db.
			if (!empty($strFile1) && file_exists($strTempFile1))
			{
				if (!empty($strOldFile1) && file_exists("../images/trend/".$strOldFile1))
				{
						//Delete the image file from server
						unlink("../images/trend/".$strOldFile1);
				}
				$strFileName1   = $strFile1;
				//Upload the File1.
				copy($strTempFile1,"../images/trend/".$strFileName1);
		   }

		   if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }



		  $sql="update tbltrend set trend_img='$strFile1' where trend_id ='$subid'";
		  mysql_query($sql) or die("Error updating tblsubcat");

}


function admin_add_small_trend_img($subid,$strFile2)
{
	$strFile2        =  $_FILES["cat_image"]["name"];
	$strTempFile2    =  $_FILES["cat_image"]["tmp_name"];

	   //Change the File2 and Update the File2 in db.
	if (!empty($strFile2) && file_exists($strTempFile2))
	{
		if (!empty($strOldFile2) && file_exists("../images/smalltrend/".$strOldFile2))
		{
				//Delete the image file from server
				unlink("../images/smalltrend/".$strOldFile2);
		}
		$strFileName2   = $strFile2;
		//Upload the File2.
		copy($strTempFile2,"../images/smalltrend/".$strFileName2);
	 }

   if ($strFileName2 == "") { $strFileName2 = $strOldFile2; }

   $sql="update tbltrend set small_img='$strFile2' where trend_id ='$subid'";
   mysql_query($sql) or die("Error updating tblsubcat");
}
function admin_update_location($name)
{
$sql="update tblaboutus set a_desc='$name' where a_id=2";
 mysql_query($sql) or die("Error updating tblsubcat");
}
function admin_update_event($name)
{
$sql="update tblaboutus set a_desc='$name' where a_id=3";
 mysql_query($sql) or die("Error updating tblsubcat");
}
function admin_update_vision($name)
{
$sql="update tblaboutus set a_desc='$name' where a_id=1";
 mysql_query($sql) or die("Error updating tblsubcat");
}
function admin_update_press($name)
{
$sql="update tblaboutus set a_desc='$name' where a_id=8";
mysql_query($sql) or die("Error updating tblsubcat");

}
function admin_update_news($name)
{
$sql="update tblaboutus set a_desc='$name' where a_id=4";
 mysql_query($sql) or die("Error updating tblsubcat");
}
function admin_update_contact($name)
{
$sql="update tblaboutus set a_desc='$name' where a_id=5";
 mysql_query($sql) or die("Error updating tblsubcat");
}
function admin_update_site($name)
{
$sql="update tblaboutus set a_desc='$name' where a_id=6";
 mysql_query($sql) or die("Error updating tblsubcat");
}
function admin_update_legal($name)
{
$sql="update tblaboutus set a_desc='$name' where a_id=7";
 mysql_query($sql) or die("Error updating tblsubcat");
}
function add_trend_tblmandt($subid)
{
	$sbid=0;
	for($cnt=0;$cnt<4;$cnt++)
	{
		$sql="insert into tblmandt (trend_id, subcat_id) values ('$subid', '$sbid')";
		mysql_query($sql);
	}
}


function get_subcat_index1($table, $cid)
{
  if ($table=="tblcat"){get_cat($cid);}
  if ($table=="tblmanufacturer"){get_manu($cid);}
  if ($table=="tbltrend"){get_t($cid);}
}

function get_subcat_index($cnt)
{
	$nam="toshow".$cnt;
	echo "<select name=$nam class=combobig><option value=''>Select</option>";
	echo "</select>";
}

function get_cat($cnt)
{
  $nam="toshow".$cnt;
  $select="select * from tblcat order by cat_name asc";
  $result=mysql_query($select);
  echo "<select name=$nam class=combobig><option value=''>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      echo"<option value='$row[cat_id]'>$row[cat_name]</option>";
  }
  echo "</select>";
}

function get_manu($cnt)
{
  $nam="toshow".$cnt;
  $select="select * from tblmanufacturer order by manufacturer_name asc";
  $result=mysql_query($select);
  echo "<select name=$nam class=combobig><option value=''>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      echo"<option value='$row[manufacturer_id]'>$row[manufacturer_name]</option>";
  }
  echo "</select>";
}

function get_t($cnt)
{
  $nam="toshow".$cnt;
  $select="select * from tbltrend order by trend_name asc";
  $result=mysql_query($select);
  echo "<select name=$nam class=combobig><option value=''>Select</option>";
  while($row=mysql_fetch_array($result))
  {
      echo"<option value='$row[trend_id]'>$row[trend_name]</option>";
  }
  echo "</select>";
}


function update_mainimage($strFile2)
{
	$strFile2        =  $_FILES["cat_image"]["name"];
	$strTempFile2    =  $_FILES["cat_image"]["tmp_name"];

	   //Change the File2 and Update the File2 in db.
	if (!empty($strFile2) && file_exists($strTempFile2))
	{
		if (!empty($strOldFile2) && file_exists("../images/".$strOldFile2))
		{
				//Delete the image file from server
				unlink("../images/".$strOldFile2);
		}
		$strFileName2   = $strFile2;
		//Upload the File2.
		copy($strTempFile2,"../images/".$strFileName2);
	 }

   if ($strFileName2 == "") { $strFileName2 = $strOldFile2; }

   $sql="update tblindex set main_img='$strFile2' where Id ='1'";
   mysql_query($sql) or die("Error updating tblsubcat");
}

function update_index_cat_values($tabl, $catid, $idx)
{
	$sql="update tblindex set main_img='$tabl', cat_id='$catid' where Id ='$idx'";
	mysql_query($sql) or die("Error updating tblsubcat");
}

function uplink_product_iamges($prod_id, $cnt)
{
	$nam='prod_image'.$cnt;
	$sel="select * from tblproduct where prod_id='$prod_id'";
	$result=mysql_query($sel);
	$row=mysql_fetch_array($result);
	$img=$row[$nam];

	if($img!='')
	{
		$file_name1="product_picture/$img";
		$file_name2="product_picture/medium/$img";
		$file_name3="product_picture/thumb/$img";
		$file_name4="product_picture/zoom/$img";
		$file_name5="product_picture/mini_thumb/$img";
		$file_name_sketch="product_picture/sketch/$img";
		$file_name_sketch_zoom="product_picture/sketch/zoom/$img";
		$file_name_sketch_big="product_picture/sketch/big/$img";
		


		if(@file_exists($file_name1)) {unlink($file_name1);}
		if(@file_exists($file_name2)) {unlink($file_name2);}
		if(@file_exists($file_name3)) {unlink($file_name3);}
		if(@file_exists($file_name4)) {unlink($file_name4);}
		if(@file_exists($file_name5)) {unlink($file_name5);}
		if(@file_exists($file_name_sketch)) {
			@unlink($file_name_sketch);
			@unlink($file_name_sketch_zoom);
			@unlink($file_name_sketch_big);
		}
	}

}

function unlink_zoom_img($prod_id, $cnt)
{
	$nam='zoom_img'.$cnt;
	$sel="select * from tblzoom_img where prod_id='$prod_id'";
	$result=mysql_query($sel);
	$row=mysql_fetch_array($result);
	$img=$row[$nam];

	if($img!='')
	{
		$file_name1="product_picture/zoom1/$img";
		$file_name2="product_picture/zoom2/$img";

		if(@file_exists($file_name1)) {unlink($file_name1);}
		if(@file_exists($file_name2)) {unlink($file_name2);}
	}
}

function unlink_product_images($img_id)
{
	
	$row = mysql_fetch_array(mysql_query("select * from tbl_product_imgs where img_id='".$img_id."'")) or die(mysql_error());
	
				@unlink("product_picture/".$row['img_01']);
				@unlink("product_picture/thumb/".$row['img_01']);
				@unlink("product_picture/zoom/".$row['img_01']);
				@unlink("product_picture/mini_thumb/".$row['img_01']);
				
				@unlink("product_picture/".$row['img_02']);
				@unlink("product_picture/thumb/".$row['img_02']);
				@unlink("product_picture/zoom/".$row['img_02']);
				@unlink("product_picture/mini_thumb/".$row['img_02']);
				
				@unlink("product_picture/".$row['img_03']);
				@unlink("product_picture/thumb/".$row['img_03']);
				@unlink("product_picture/zoom/".$row['img_03']);
				@unlink("product_picture/mini_thumb/".$row['img_03']);
				
				@unlink("product_picture/".$row['img_04']);
				@unlink("product_picture/thumb/".$row['img_04']);
				@unlink("product_picture/zoom/".$row['img_04']);
				@unlink("product_picture/mini_thumb/".$row['img_04']);
				
				@unlink("product_picture/".$row['img_back']);
				@unlink("product_picture/thumb/".$row['img_back']);
				@unlink("product_picture/zoom/".$row['img_back']);
				@unlink("product_picture/mini_thumb/".$row['img_back']);
				
				@unlink("product_picture/sketch/".$row['color_icon']);
				
				
}

function unlink_prod_images($img_id, $cnt)
{
	$ret = 0;
	$nam='img_'.$cnt;
	$sel="select * from tbl_product_imgs where img_id='".$img_id."'";
	$result=mysql_query($sel) or die(mysql_error());
	$row=mysql_fetch_array($result);
	$img=$row['img_'.$cnt];
	
	if($img!='')
	{
		$file_name1="product_picture/$img";
		$file_name3="product_picture/thumb/$img";
		$file_name4="product_picture/zoom/$img";
		$file_name5="product_picture/mini_thumb/$img";
		//$file_name_sketch="product_picture/sketch/$img";

		if(@file_exists($file_name1)) {unlink($file_name1);}
		if(@file_exists($file_name3)) {unlink($file_name3);}
		if(@file_exists($file_name4)) {unlink($file_name4);}
		if(@file_exists($file_name5)) {unlink($file_name5);}
		
		$selupd="update tbl_product_imgs set $nam='' where img_id='$img_id'";
		$result=mysql_query($selupd);
		$ret = $result;
	}
	return $ret;
}




function uplink_product_iamges_sketch($prod_id)
{
	$nam='sketch_img';
	$sel="select * from tblproduct where prod_id='$prod_id'";
	$result=mysql_query($sel);
	$row=mysql_fetch_array($result);
	$img=$row[$nam];

	if($img!='')
	{
		
		$file_name_sketch="product_picture/sketch/$img";
		$file_name_sketch_zoom="product_picture/sketch/zoom/$img";
		$file_name_sketch_big="product_picture/sketch/big/$img";
		
		if(@file_exists($file_name_sketch)) {
			@unlink($file_name_sketch);
			@unlink($file_name_sketch_zoom);
			@unlink($file_name_sketch_big);
		}
	}
}

function unlink_product_images_sketch($prod_id)
{
	$nam='sketch_img';
	$sel="select * from tbl_product where prod_id='$prod_id'";
	$result=mysql_query($sel);
	$row=mysql_fetch_array($result);
	$img=$row[$nam];

	if($img!='')
	{
		
		$file_name_sketch="product_picture/sketch/$img";
		$file_name_sketch_zoom="product_picture/sketch/zoom/$img";
		$file_name_sketch_big="product_picture/sketch/big/$img";
		
		if(@file_exists($file_name_sketch)) {
			@unlink($file_name_sketch);
			@unlink($file_name_sketch_zoom);
			@unlink($file_name_sketch_big);
		}
	}
}



function get_prod_view($id,$status)
{
  if($status == 'Y'){ $checked="checked"; }else{ $checked = ''; }
  echo "<input name='prv' type='checkbox' value='$id' onclick='submit_form()' $checked />";
  /*$sql = "update tblproduct set view_status='N' where prod_id='$id'";
  $res = mysql_query($sql);*/

}	
function get_prod_submit()
{
  
  $query="select * from tblproduct order by prod_name asc";
  $result=mysql_query($query);
  echo "<select name='prod_name' class=combobig onchange='submit_form()'><option value='0'>Select</option>";
  
  /*if($prod_no != "")
  {
  	echo $quer_y="select * from tblproduct where prod_no='$prod_no'";
	$qu = mysql_query($quer_y);
	$row_s = mysql_fetch_array($qu);
	$Fid = $row_s['prod_id'];
  }*/
    while($row=mysql_fetch_array($result))
    {
        /*if($Fid == $row['prod_id']){
			$select = 'selected';
		}else{
			$select = '';
		}*/
		
		echo"<option value='$row[prod_id]'>$row[prod_name]</option>";
    }
  echo "</select>";

}

//-----------------------------------------------------------------

function get_prod_no()
{
  $query="select * from tblproduct where prod_no<>'' order by prod_no asc";
  $result=mysql_query($query);
  echo "<select name='prod_no' class=combobig onchange='submit_form()'><option value=''>Select</option>";
    while($row=mysql_fetch_array($result))
    {
        echo"<option value='$row[prod_id]'>$row[prod_no]</option>";
    }
  echo "</select>";
}


//-----------------------------------------------------------------


function get_prod_det_submit($prod_id)
{
	$query="select * from tblproduct_details where prod_id='$prod_id' order by p_name asc";
	
	  $result=mysql_query($query);
	  echo "<select name='prod_det_name' class=combobig onchange='submit_form()'><option value='0'>Select</option>";
	    while($row=mysql_fetch_array($result))
	    {
	        echo"<option value='$row[det_id]'>$row[p_name]</option>";
	    }
  echo "</select>";
}

//code edited by Pla starts

function get_type_heading($heading_id)
{
	$ret = "";
	$query="select * from tbl_type_headings where id='$heading_id'";
	 $r = MyQuery($query);
	if(isset($r[1]) || $r[1]!=""){	
		$ret = $r[1];
	}
	return $ret;
}

function MyQuery($sql)
	{
		global $link, $DEBUG, $db;
		if($DEBUG){
			echo("MyQuery:$sql;<BR>\n");
		}
		mysql_query($db);
		if($s = mysql_query($sql)){
			$f = mysql_fetch_row($s);
			mysql_free_result($s);
		} else {
			echo("Error in my query ");
		}
		return $f;
	}


function SelectValue($sql, $name, $val) 
	{ 
		global $link, $db; 
		if(@$DEBUG){ 
			echo("SelectValue:$sql;<BR>\n"); 
		}  
		mysql_query($db);
		if($s = mysql_query($sql)){
			printf("<select name=$name>\n"); 
				while ($r=mysql_fetch_array($s)) {
				if($r[9] == $val){
					printf("<option value=\"%s\" selected>%s</option>\n", $r[9], $r[1]); 
				} else {
					printf("<option value=\"%s\">%s</option>\n", $r[9], $r[1]); 
				}
			}  
			echo("</select>\n"); 
		mysql_free_result($s);
		} else { 
			echo("Error in query statement."); 
		}  
	}  

function admin_addnew_product(
	$prod_name, 
	$prod_no, 
	$cat, 
	$subcat, 
	$subsubcat, 
	$new_arrival, 
	$add_date, 
	$catalogue_price, 
	$less_discount, 
	$prod_desc, 
	$designer, 
	$primary_img_id,
	$colors)
{
	$err = check_empty_product($cat, $prod_name, $type, $subcat);
	
	if ($err=='0')
	{
		$err1 = dateCheck($add_date);
		if ($err1 == '0')
		{
			$seq_sql = "select max(seque) from tbl_product where cat_id='".$cat."'";
			$seq_res = mysql_query($seq_sql);
			$seq_row = mysql_fetch_array($seq_res);
			$seq_num = mysql_num_rows($seq_res);
			
			if ($seq_row[0] > 0 && $seq_num == 1):
				$seqes = $seq_row[0] + 1; 
			else:	
				$seqes = 1;
			endif;
			
			$add_date = date('m/d/Y',strtotime($add_date));
			$sqlins = sprintf("
				insert into tbl_product (
					prod_id, 
					seque, 
					prod_name, 
					prod_no, 
					view_status, 
					hide_sketch, 
					cat_id, 
					subcat_id,
					subsubcat_id, 
					prod_date, 
					prod_desc,
					catalogue_price, 
					less_discount, 
					designer, 
					primary_img_id, 
					colors, 
					new_arrival
				) VALUES (
					0, 
					%d, 
					'%s', 
					'%s', 
					'Y', 
					'N', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s'
				)",
				$seqes, 
				$prod_name,
				$prod_no, 
				$cat, 
				$subcat, 
				$subsubcat, 
				$add_date,
				$prod_desc, 
				$catalogue_price, 
				$less_discount, 
				$designer, 
				$primary_img_id, 
				$colors, 
				$new_arrival
			);
			mysql_query($sqlins)or die("Add new product error: ".mysql_error());
			
			$stock_ckech_qry = mysql_query("
				SELECT * FROM tbl_stock WHERE prod_no = '".$prod_no."' AND color_name = '".$colors."'
			") or die (mysql_error());
			
			if (@mysql_num_rows($stock_ckech_qry) == 0)
			{
				$sqlins2 = mysql_query("
					INSERT INTO tbl_stock (
						prod_no, 
						color_name,
						stock_date
					)
					VALUES (
						'".trim($prod_no)."', 
						'".trim($colors)."', 
						'".trim($add_date)."'
					)
				") or die("Insert new product into stock error: ".mysql_error());
			}
			
			return 0;
		}
		else
		{
			$GLOBALS["message"]=$GLOBALS["message"];
			return 1;
		}
	}
	else
	{
		$GLOBALS["message"]=$GLOBALS["message"];
		return 1;
	}
}

function  admin_addnew_zoom_products_img($cnt)
{
	    	$nam='zoom_img'.$cnt;
			$fold='zoom'.$cnt;
	    	$strFile1        =  strtolower($_FILES[$nam]["name"]);
	     	$strTempFile1    =  $_FILES[$nam]["tmp_name"];
			$randomno_1=RandomNumber(4);
			//Change the File1 and Update the File1 in db.
		if (!empty($strFile1) && file_exists($strTempFile1))
	     	{
		 	if (!empty($strOldFile1) && file_exists("../product_picture/".$fold."/".$strOldFile1))
			{
				//Delete the image file from server
				@unlink("../product_picture/".$fold."/".$strOldFile1);
			}
			$strFileName1   = $randomno_1.$strFile1;
				//Upload the File1.
				copy($strTempFile1,"product_picture/".$fold."/".$strFileName1);
		    }
               	//if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }
		return $strFileName1;
}



function  admin_addnew_products_img($cnt)
{
	    	$nam='prod_image'.$cnt;
	    	$strFile1        =  strtolower($_FILES[$nam]["name"]);
	     	$strTempFile1    =  $_FILES[$nam]["tmp_name"];
			$randomno_1=RandomNumber(4);
			//Change the File1 and Update the File1 in db.
		if (!empty($strFile1) && file_exists($strTempFile1))
	     	{
		 	//if (!empty($strOldFile1) && file_exists("../product_picture/".$strOldFile1))
			//{
				//Delete the image file from server
			//	@unlink("../product_picture/".$strOldFile1);
			//}
			$strFileName1   = $randomno_1.$strFile1;
			//Upload the File1.
			copy($strTempFile1,"product_picture/".$strFileName1);			

			gd2resize2("product_picture/".$strFileName1,140,"product_picture/thumb/","");
			gd2resize2("product_picture/".$strFileName1,800,"product_picture/zoom/","");
			gd2resize2("product_picture/".$strFileName1,60,"product_picture/mini_thumb/","");
			gd2resize2("product_picture/".$strFileName1,325,"product_picture/","");
			
		    }
               	//if ($strFileName1 == "") { $strFileName1 = $strOldFile1; }
		return $strFileName1;
}

function admin_add_sketch()
{
      		$strFile1_2        =  strtolower($_FILES["prod_image5"]["name"]);
			$strTempFile1_2    =  $_FILES["prod_image5"]["tmp_name"]; 			
			$randomno_2=RandomNumber(4);
			$strFileName2= $randomno_2.$strFile1_2;	
         	
		 if($strFile1_2!=''){	
			copy($strTempFile1_2,"product_picture/sketch/".$strFileName2);
			gd2resize("product_picture/sketch/".$strFileName2,40,40,"product_picture/sketch/",""); 	
		}		
	return $strFileName2;
}

function alert($str,$link,$main){
	?><script language="JavaScript">alert(" <?=$str?>");</script><?                                        
	if ($link!=""){
	   ?><script language="JavaScript">window.location='<?=$link?>';</script><?
	   exit();
	}	
	if ($main!=""){
		?><script language="JavaScript">opener.window.location='<?=$main?>';    window.close();</script>  <?      	                                  
		exit();
	}		
}

//code edited by Pla ends



?>
