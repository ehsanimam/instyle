<?php
session_start();
include("../common.php");

function MyQuery($sql)
	{
		global $link, $DEBUG, $db;
		if($DEBUG){
			echo("MyQuery:$sql;<BR>\n");
		}
		mysql_query($db);
		if($s = mysql_query($sql)){
			$f = mysql_fetch_array($s);
			mysql_free_result($s);
		} else {
			echo("Error in my query ");
		}
		return $f;
	}

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
	function Now()
	{
		$tm = getdate(time(0));
		return sprintf("%d-%02d-%02d %02d:%02d:%02d", $tm['year'], $tm['mon'], $tm['mday'], $tm['hours'], $tm['minutes'], $tm['seconds']);
	}


if($_GET['user_id'] != ""){
	if($_GET['say']=="yes"){
			@mysql_query("update tbluser set isregistered=1 where user_id=".$_GET['user_id']) or die(mysql_error());
			$rs = @mysql_fetch_array(@mysql_query("SELECT * from tbluser where user_id='".$_GET['user_id']."'")) or die(mysql_error());
				  $strbody="";
				  $strbody.="
				  <table width='60%' border='0' align='center' cellpadding='0' cellspacing='0'>          
						 <tr bgcolor='#336699'>
						  <td colspan=2><font color='#ffffff'><stong>Welcome to Instyle New York</strong></font></td>
					 </tr>  
					<tr>
						  <td width='33%' height='25' >User Name :</td>
						  <td width='67%'>".$rs['e_mail']."</td>
						</tr>
						  <tr>
						  <td width='33%' height='25' >Password :</td>
						  <td width='67%'>".$rs['user_password']."</td>
						</tr>
					  </table>";
						
				$to=$rs['e_mail'];
				$subject = "Inform Username & Password";
				$body= $strbody;
				
				/*$headers  = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
				$headers .= "From:info@instylenewyork.com\r\n";*/
				
				//$headers .= 'Cc: database@innerconcept.com' . "\r\n";
				//$headers .= 'Bcc: database@innerconcept.com' . "\r\n";
				//$headers .= 'Bcc: bubun_ich@yahoo.co.in' . "\r\n";
				
				$headers = 'From:info@instylenewyork.com'. "\r\n".
        "Content-Type: text/html; charset=us-ascii\r\n";
		
				if (mail($to, $subject, $body, $headers))
				{
					$msg=" Approve completed!! ";
						
				}
					//$sqlupd = sprintf("update tbluser_data set register_status='%s' where user_id=%d", Now(),$rs['user_id']);  
					//mysql_query($sqlupd)or die("Error:".$sqlupd);
			 
	}
	else
	{
			$msg=" Thank you for approve";
	}
}
else
{
	$msg = "no customer to activate";
}

echo $msg;
?>
