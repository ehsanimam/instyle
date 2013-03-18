<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
 include("../../../common.php"); 
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sample - CKEditor</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="sample.css" />
</head>
<body>
	<h1>s
		INSTYLE NEW YORK - NEWS LETTER LIST
	</h1>
	<table border="1" cellspacing="0" id="outputSample">
		<colgroup><col width="100" /></colgroup>
		<thead>
			<tr>
				<th>Field&nbsp;Name</th>
				<th>Value</th>
			</tr>
		</thead>
<?php

if ( isset( $_POST ) )
	$postArray = &$_POST ;			// 4.1.0 or later, use $_POST
else
	$postArray = &$HTTP_POST_VARS ;	// prior to 4.1.0, use HTTP_POST_VARS

foreach ( $postArray as $sForm => $value )
{
	if ( get_magic_quotes_gpc() )
		$postedValue = htmlspecialchars( stripslashes( $value ) ) ;
	else
		$postedValue = htmlspecialchars( $value ) ;

?>
		<tr>
			<th style="vertical-align: top"><?php echo $sForm?></th>
			<td><pre><?php echo $postedValue?></pre></td>
		</tr>
	<?php
}
?>
	</table>
    
    <?php
     if (isset($_POST['Save'])) 
	 {
        $Vtitle = $_POST['nltitle'];
	 }	
	?> 
     
	<form action="" method="post" enctype="multipart/form-data">
 <b>TITLE :</b> <input type="text" name="nltitle"  size="55" maxlength="55"/>
  &nbsp;
 <b>SUBJECT :</b> <input type="text" name="nlsubject"  size="55" maxlength="55"/>
  &nbsp;
 <b>FROM:</b> <input type="text" name="nlfrom"  size="15" maxlength="15"/>


<input type="submit" name="Save" value="Save" />
</form>

<?php


echo '<p>NEWSLETTERS</p>';
echo ' <table  style="border: 1px solid #D4E099">

      <tr>

       <td bgcolor="#9999DD" align="center" width="15"> <strong>TITLE</strong></td>
       <td bgcolor="#9999DD" align="center" width="25"><strong>SUBJECT</strong></td>
       <td bgcolor="#9999DD" align="center" width="20"><strong>FROM</strong></td>

      </tr>';  

   $qcolls = "Select title,subject,efrom from newsletter";
        if ($result=mysql_query($qcolls));
	      {
           $num=mysql_numrows($result);
           if ($num > 0)
		    {
			$i=0;
			while ($i < $num) 
			 {
				$title=mysql_result($result,$i,"title");
				$subject=mysql_result($result,$i,"subject");
				$from=mysql_result($result,$i,"efrom");
				
				echo $title;
                echo '<tr><td>' .  $title. '</td><td>' .$subject.'</td> <td>' . $from .'</td></tr>';				
		        $i++;
		     }		
			}  //if cnt>0
		   }// if there is	
		   
echo '</table>'
?>

</body>
</html>
