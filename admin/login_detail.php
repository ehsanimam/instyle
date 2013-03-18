<?php
	session_start();
	include("../common.php");
	include('../functionsadmin.php');
	include("security.php"); 
	define("TABLE","`tbl_login_detail`",true);
	define("TABLE2","`tbluser`",true);
	$rno=50;	
	function ChangeFormatDate($dt,$type) {
		$VarTotalDate = explode("-",$dt);
		if($type == 'mysql') {
			$VarDate = $VarTotalDate[1];
			$VarMonth = $VarTotalDate[0];
			$VarYear = $VarTotalDate[2];
			$CompleteDate = $VarYear.'-'.$VarMonth.'-'.$VarDate;
		} else {
			$VarDate = $VarTotalDate[2];
			$VarMonth = $VarTotalDate[1];
			$VarYear = $VarTotalDate[0];
			// Indian Format
			//$CompleteDate = $VarDate.'-'.$VarMonth.'-'.$VarYear;
			// USA Format
			$CompleteDate = $VarMonth.'-'.$VarDate.'-'.$VarYear;
		}
		return $CompleteDate;
	}

		if($_GET['search'] != 1){
			$sql = "SELECT a.`user_id`,a.`create_date` AS C_date,a.`create_time`,b.* FROM ".TABLE." AS a,".TABLE2." AS b WHERE a.`user_id`=b.`user_id` ORDER BY a.`create_date` DESC,a.`create_time` DESC";
		} else {
			if($_REQUEST['sec_box'] == "by_name" && empty($_REQUEST['sec_text']) == false){
				$sql = "SELECT a.`user_id`,a.`create_date` AS C_date,a.`create_time`,b.* FROM ".TABLE." AS a,".TABLE2." AS b WHERE a.`user_id`=b.`user_id` AND b.`uname` LIKE '".$_REQUEST['sec_text']."%' GROUP BY b.`user_id` ORDER BY a.`create_date` DESC,a.`create_time` DESC";
			
			}elseif($_REQUEST['sec_box'] == "by_region" && empty($_REQUEST['sec_text']) == false){			
				$sql = "SELECT a.`user_id`,a.`create_date` AS C_date,a.`create_time`,b.* FROM ".TABLE." AS a,".TABLE2." AS b WHERE a.`user_id`=b.`user_id` AND b.`region` LIKE '".$_REQUEST['sec_text']."%' GROUP BY b.`user_id` ORDER BY a.`create_date` DESC,a.`create_time` DESC";
			
			}elseif($_REQUEST['sec_box'] == "by_sales_rep" && empty($_REQUEST['sec_text']) == false){			
				$sql = "SELECT a.`user_id`,a.`create_date` AS C_date,a.`create_time`,b.* FROM ".TABLE." AS a,".TABLE2." AS b WHERE a.`user_id`=b.`user_id` AND b.`sales_rep` LIKE '".$_REQUEST['sec_text']."%' GROUP BY b.`user_id` ORDER BY a.`create_date` DESC,a.`create_time` DESC";
			
			}elseif($_REQUEST['sec_box'] == "top_viewers" && empty($_REQUEST['sec_text']) == true){			
				$sql = "SELECT a.`user_id`,max(a.`create_date`) AS C_date,count(a.`user_id`) AS cnt,a.`create_time`,b.`user_id`,b.`uname`,b.`e_mail`,b.`region`,b.`sales_rep` FROM ".TABLE." AS a, ".TABLE2." AS b WHERE a.`user_id`=b.`user_id` GROUP BY a.`user_id` ORDER BY cnt DESC";			
			
			}elseif($_REQUEST['sec_box'] == "last_loged" && empty($_REQUEST['sec_text']) == true){			
				$sql = "SELECT a.`user_id`,max(a.`create_date`) AS C_date,a.`create_time`,b.`user_id`,b.`uname`,b.`e_mail`,b.`region`,b.`sales_rep` FROM ".TABLE." AS a,".TABLE2." AS b WHERE a.`user_id`=b.`user_id` GROUP BY a.`user_id` ORDER BY C_date DESC";
			
			//}elseif($_REQUEST['sec_box'] == "not_loged" && empty($_REQUEST['sec_text']) == true){			
				//$sql = "SELECT * FROM ".TABLE2." WHERE `user_id` NOT IN (SELECT `user_id` FROM ".TABLE.")GROUP BY `user_id` ORDER BY `create_date` DESC";
			
			}else{
				$sql = "SELECT a.`user_id`,a.`create_date` AS C_date,a.`create_time`,b.* FROM ".TABLE." AS a,".TABLE2." AS b WHERE a.`user_id`=b.`user_id` ORDER BY a.`create_date` DESC,a.`create_time` DESC";
			}
			
		}
		//echo $sql;
		$res = mysql_query($sql);
		$records = mysql_num_rows($res);
		
		$rnum=mysql_num_rows($res);
		
        $mod=$rnum%$rno;
        if($mod>0)
        {
          $tpage=($rnum-$mod)/$rno +1; 
        }
        else
        {
          $tpage=($rnum-$mod)/$rno;
        }
        if(@$cpage=="")
        {
          $cpage=1;       /*variable for page no.....*/
        }

        $skip=($cpage-1)*$rno;
        if(($skip+$rno)>$rnum)
        {
          $lmt=$rnum-$skip;
        }
        else
        {
          $lmt=$rno;
        }
        $start=$skip +1;
        $end=$skip + $lmt;
	
		if($_GET['search'] != 1){
			$sql = "SELECT a.`user_id`,a.`create_date` AS C_date,a.`create_time`,b.* FROM ".TABLE." AS a,".TABLE2." AS b WHERE a.`user_id`=b.`user_id` ORDER BY a.`create_date` DESC,a.`create_time` DESC limit $skip,$lmt";
		} else {
			if($_REQUEST['sec_box'] == "by_name" && empty($_REQUEST['sec_text']) == false ){
				$sql = "SELECT a.`user_id`,a.`create_date` AS C_date,a.`create_time`,b.* FROM ".TABLE." AS a,".TABLE2." AS b  WHERE a.`user_id`=b.`user_id` AND b.`uname` LIKE '".$_REQUEST['sec_text']."%' GROUP BY b.`user_id` ORDER BY a.`create_date` DESC,a.`create_time` DESC limit $skip,$lmt";
			
			}elseif($_REQUEST['sec_box'] == "by_region" && empty($_REQUEST['sec_text']) == false){			
				$sql = "SELECT a.`user_id`,a.`create_date` AS C_date,a.`create_time`,b.* FROM ".TABLE." AS a,".TABLE2." AS b WHERE a.`user_id`=b.`user_id` AND b.`region` LIKE '".$_REQUEST['sec_text']."%' GROUP BY b.`user_id` ORDER BY a.`create_date` DESC,a.`create_time` DESC limit $skip,$lmt";
			
			}elseif($_REQUEST['sec_box'] == "by_sales_rep" && empty($_REQUEST['sec_text']) == false){			
				$sql = "SELECT a.`user_id`,a.`create_date` AS C_date,a.`create_time`,b.* FROM ".TABLE." AS a,".TABLE2." AS b WHERE a.`user_id`=b.`user_id` AND b.`sales_rep` LIKE '".$_REQUEST['sec_text']."%' GROUP BY b.`user_id` ORDER BY a.`create_date` DESC,a.`create_time` DESC limit $skip,$lmt";
			
			}elseif($_REQUEST['sec_box'] == "top_viewers" && empty($_REQUEST['sec_text']) == true){			
				$sql = "SELECT a.`user_id`,max(a.`create_date`) AS C_date,count(a.`user_id`) AS cnt,a.`create_time`,b.`user_id`,b.`uname`,b.`e_mail`,b.`region`,b.`sales_rep` FROM ".TABLE." AS a, ".TABLE2." AS b WHERE a.`user_id`=b.`user_id` GROUP BY a.`user_id` ORDER BY cnt DESC limit $skip,$lmt";			
			
			}elseif($_REQUEST['sec_box'] == "last_loged" && empty($_REQUEST['sec_text']) == true){			
				$sql = "SELECT a.`user_id`,max(a.`create_date`) AS C_date,a.`create_time`,b.`user_id`,b.`uname`,b.`e_mail`,b.`region`,b.`sales_rep` FROM ".TABLE." AS a,".TABLE2." AS b WHERE a.`user_id`=b.`user_id` GROUP BY a.`user_id` ORDER BY C_date DESC limit $skip,$lmt";			
			
			//}elseif($_REQUEST['sec_box'] == "not_loged" && empty($_REQUEST['sec_text']) == true){			
				//$sql = "SELECT * FROM ".TABLE2." WHERE `user_id` NOT IN (SELECT `user_id` FROM ".TABLE.")GROUP BY `user_id` ORDER BY `create_date` DESC";
				
			}else{
				$sql = "SELECT a.`user_id`,a.`create_date` AS C_date,a.`create_time`,b.* FROM ".TABLE." AS a,".TABLE2." AS b WHERE a.`user_id`=b.`user_id` ORDER BY a.`create_date` DESC,a.`create_time` DESC limit $skip,$lmt";
			}			
		}
		//echo $sql;
		$res = mysql_query($sql);
		$records = mysql_num_rows($res);		
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>In Style New York::Admin Section</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--<meta http-equiv="refresh" content="20">-->
<link href="style.css" rel="stylesheet" type=text/css>
<style type="text/css">
<!--
.style1 {
	font-size: 11px;
	font-family: Verdana, Arial;
	color: #999999;
}
-->
</style>
</head>

<body link="#0000FF" vlink="#0000FF" alink="#0000FF">
<table width="100%" border="0" cellpadding="1" cellspacing="1">

    <tr>
      <td > <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor=gray >
          <tr>
            <td colspan="2" height=50 align="center" >
             <font size=2  face="verdana,Arial">
              <b>In Style New York Private Area Administration Section</b></font> </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff"><div align="left">
                <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="gray">
                  <tr>
                    <td width="27%" align=center bgcolor="#DCDCDC" valign="top"><?php include('admin_left_menu.php');?></td>
                    <td width="73%" class=partner valign=top align=center ><table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
					 <form name="frm" action="<?php echo $_SERVER['PHP_SELF'];?>?search=1" method="post">
					 <tr>
                        <td align="right">
							<input type="text" name="sec_text" id="sec_text">&nbsp;&nbsp;
							<select name="sec_box" id="sec_box">
								<option value="" selected="selected">-Select</option>
								<option value="by_name" <?php if($_REQUEST['sec_box'] == "by_name"){ echo $selected = "selected";} else { echo $selected = "";}?>>- Search by name</option>
								<option value="by_region" <?php if($_REQUEST['sec_box'] == "by_region"){ echo $selected = "selected";} else { echo $selected = "";}?>>- Search by region</option>
								<option value="by_sales_rep" <?php if($_REQUEST['sec_box'] == "by_sales_rep"){ echo $selected = "selected";} else { echo $selected = "";}?>>- Search by sales rep</option>								
								<option value="top_viewers" <?php if($_REQUEST['sec_box'] == "top_viewers"){ echo $selected = "selected";} else { echo $selected = "";}?>>- Search by top viewers</option>
								<option value="last_loged" <?php if($_REQUEST['sec_box'] == "last_loged"){ echo $selected = "selected";} else { echo $selected = "";}?>>- Search by last loged in</option>
								<!--<option value="not_loged" <?php if($_REQUEST['sec_box'] == "not_loged"){ echo $selected = "selected";} else { echo $selected = "";}?>>- Search by not loged in</option>-->
							</select>&nbsp;<input type="submit" value=" Search ">
						&nbsp;&nbsp;</td>
                      </tr>
					  </form>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0>
                          <tr>
                            <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
                              <tr>
                                <td height="20" colspan="6" align="center" bgcolor="cccccc"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Login Details</font></b></td>
                                </tr>
                              <tr>
                                <td width="18%" height="20" bgcolor="#DDDDDD" align="center">&nbsp;<b><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Name</font></b></td>
								<td width="23%" height="20" bgcolor="#DDDDDD" align="center">&nbsp;<b><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Email</font></b></td>
								<td width="15%" height="20" bgcolor="#DDDDDD" align="center">&nbsp;<b><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Region</font></b></td>
								<td width="14%" height="20" bgcolor="#DDDDDD" align="center">&nbsp;<b><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Sales Rep</font></b></td>
                                <td width="16%" bgcolor="#DDDDDD" align="center"><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Login Date</font></b></td>
                                <td width="14%" height="20" align="center" bgcolor="#DDDDDD"><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Login Time</font></b></td>
                                
                              </tr>
							  <?php if($records <= 0):?>
                              <tr>
                                <td height="100" colspan="6" align="center"><b><font color="#990000" size="2" face="Verdana, Arial, Helvetica, sans-serif">No Record Found</font></b></td>
                              </tr>
							  <?php
							  		else:
										while($row_ = mysql_fetch_array($res)):
										/*$sql_ = "SELECT * FROM ".TABLE2." WHERE `user_id`='".$row['user_id']."'";
										$res_ = mysql_query($sql_);
										$row_ = mysql_fetch_array($res_)*/;
											

							  ?>
                              <tr>
                                <td height="20" class="txt" align="center" >&nbsp;<?php echo $row_['uname'];?></td>
                                <td height="20" align="center">&nbsp;<a href="mailto:<?php echo $row_['e_mail'];?>" class="txt_line"><?php echo $row_['e_mail'];?></a></td>
								<td height="20" class="txt" align="center" >&nbsp;<?php echo $row_['region'];?></td>
								<td height="20" class="txt" align="center" >&nbsp;<?php echo $row_['sales_rep'];?></td>
								<td align="center" class="txt"><?php echo ChangeFormatDate($row_['C_date'],"")?></td>
                                <td height="20" align="center" class="txt"><?php if(empty($row_['create_time']) == true) { echo "-";}else{ echo $row_['create_time'];}?></td>
                              </tr>
							  <tr>
							  	<td height="5" colspan="6"></td>
							  </tr>
							  <?php
							  			endwhile;
							  		endif;
							  ?>                            
                            </table></td>
                          </tr>
                        </table>                        
						</td>
                      </tr>
                      <tr>
                        <td>
							<span class="text"> Page :</span>
							<?for($i=1;$i<=$tpage;$i++){?>
							<?if($i==$cpage){?>
							<span class="text">[<?echo $i;?>]</span><? } else {?>
								<span class="text">[</span><a href="login_detail.php?cpage=<?echo $i;?>&sec_box=<?php echo $_REQUEST['sec_box'];?>&sec_text=<?php echo $_REQUEST['sec_text'];?>&search=<?php echo $_GET['search'];?>" class="pagelinks"><?echo $i;?></a><span class="text">]</span><?}?>
							<?}?>
						</td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table></td>
    </tr>

</table>
</body>
</html>
