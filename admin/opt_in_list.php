<?php 
session_start();
include("../common.php");
include("security.php");
if($_GET['action'] == 'delete')
{
 $delete="delete from tblemail_subscribe where email_addr='".$_GET['eid']."'";
 mysql_query($delete);
 echo '>>>>'.$delete;


 header('location:opt_in_list.php');
 //delete the related urls!!!!!!!!!!!!!!!!!!
}

$rno=1500;
if($_GET['search'] == 1) {
	$select = "SELECT email_id,ts.email_addr te,uname,date(ts.create_date) as vdate,tu.create_date as cdate,xdate
FROM tblemail_subscribe as ts
LEFT JOIN tbluser as tu ON ts.email_addr = tu.e_mail
LEFT JOIN tbluser_data as td ON email_addr = td.email
Left join (select email,max(create_date) as xdate from tbl_login_detail group by email) as ld on ld.email=td.email where ts.email_addr like '".$_POST['sec_text']."%' order by tu.create_date desc,ts.email_addr";
}else{
	$select="SELECT email_id,ts.email_addr te,uname,date(ts.create_date) as vdate,tu.create_date as cdate,xdate
FROM tblemail_subscribe as ts
LEFT JOIN tbluser as tu ON ts.email_addr = tu.e_mail
LEFT JOIN tbluser_data as td ON email_addr = td.email
Left join (select email,max(create_date) as xdate from tbl_login_detail group by email) as ld on ld.email=td.email order by tu.create_date desc,email_addr asc";
}

//echo $select.':'.$_GET['search'].':'.$_POST['sec_text'];
$res = mysql_query($select);
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


if($_GET['search'] == 1) {
	$sql = "SELECT email_id,ts.email_addr te,uname,date(ts.create_date) as vdate,tu.create_date as cdate,xdate
FROM tblemail_subscribe as ts
LEFT JOIN tbluser as tu ON ts.email_addr = tu.e_mail
LEFT JOIN tbluser_data as td ON email_addr = td.email
Left join (select email,max(create_date) as xdate from tbl_login_detail group by email) as ld on ld.email=td.email where ts.email_addr like '".$_POST['sec_text']."%' order by ts.create_date desc,tu.email_addr asc limit $skip,$lmt";
}else{
	//$sql="select * from tblemail_subscribe order by create_date desc,email_addr asc limit $skip,$lmt";
	$sql = "SELECT email_id,ts.email_addr te,uname,date(ts.create_date) as vdate,tu.create_date as cdate,xdate
FROM tblemail_subscribe as ts
LEFT JOIN tbluser as tu ON ts.email_addr = tu.e_mail
LEFT JOIN tbluser_data as td ON email_addr = td.email
Left join (select email,max(create_date) as xdate from tbl_login_detail group by email) as ld on ld.email=td.email order by tu.create_date desc,email_addr asc limit $skip,$lmt";
}

//$sql="select * from tbluser order by create_date desc,uname asc limit $skip,$lmt";
$result=mysql_query($sql);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<!--<meta http-equiv="refresh" content="20" > -->
<title>Instyle New York::Admin</title>
<script>
function confirm_delete()
{
var agree=confirm("Are you sure you wish to delete the record?");
if (agree)
return true ;
else
return false ;
}
</script>
<link href="style.css" rel="stylesheet" type=text/css>
</head>
<body>
<table width="100%" border="0" cellpadding="1" cellspacing="1">

    <tr>
      <td > <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor=gray >
          <tr>
            <td colspan="2" height=50 align="center" >
             <font size=2  face="verdana,Arial">
              <b>Administration Section</b> </font> </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff"><div align="left">
                <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="gray">
                  <tr>
                    <td width="28%" align=center bgcolor="#cccccc" valign="top">

                    <?php include 'admin_left_menu.php';?>

                    </td>
                    <td width="72%" class=partner valign=top align=center >&nbsp;&nbsp;
					<table cellpadding="0" cellspacing="0" width="600" border="0">
						<form name="frm" action="<?php echo $_SERVER['PHP_SELF'];?>?search=1" method="post">
						<tr>
							<td align="right" class="text" style="padding-right:60px;">Search by email:&nbsp;<input type="text" name="sec_text" value="<?php echo $_POST['sec_text'];?>">&nbsp;&nbsp;<input type="submit" value=" Search "></td>
						</tr>
						</form>
						<tr>
							<td>
							<span class="text"> Page :</span>
							<?php for($i=1;$i<=$tpage;$i++){?>
							<?php if($i==$cpage){?>
							<span class="text">[<?php echo $i;?>]</span><?php } else {?>
							<span class="text">[</span><a href="opt_in_list.php?cpage=<?php echo $i;?>&search=<?php echo $_REQUEST['search'];?>&sec_text=<?php echo $_REQUEST['sec_text'];?>" class="pagelinks"><?php echo $i;?></a><span class="text">]</span><?}?>
							<?php }?>
							</td>
						</tr>
						<tr>
							<td height="15"></td>
						</tr>
					</table>
                    <!-----start-----------//-->
                    <form name="faq" action="edit_user.php" method="post">
                    <table width=100% border=1 bordercolor=cccccc cellspacing=0 cellpadding=0><tr><td>

                    <table width=100% align=center cellspacing=2 cellpadding=2>
                    <tr bgcolor=cccccc>
                    <td align=center colspan=6><b><font size=2 color="#000000" face="verdana,Arial">OPT IN LIST</font></b></td></tr>



 <tr align=center>
                    <td width="20%" align="right"><font size=1 color="#000000" face="verdana,Arial">
					NAME</font></td>
                    <td width="20%" align="right"><font size=1 color="#000000" face="verdana,Arial">
					EMAIL</font></td>
                    <td width="15%" align="left">
                  
					</td>
					<td width="13%" align="left"><font size=1 color="#000000" face="verdana,Arial">
						DATE VALIDATED</font></td>                    
              
					<td width="13%" align="left"><font size=1 color="#000000" face="verdana,Arial">
						DATE JOINED</font></td>                    
              
					<td width="19%" align="left"><font size=1 color="#000000" face="verdana,Arial">
						DATE LAST LOGIN</font></td>                    
                    </tr>
                    







                    <?php 
					$ctr=0;
					while($row=mysql_fetch_array($result)){
					$ctr=$ctr+1;
					?>
                    <tr align=center>
                    <td width="20%" align="left"><font size=1 color="#000000" face="verdana,Arial">
					<?php echo $ctr.'.'.$row[uname]?></font></td>
                    <td width="20%" align="right"><font size=1 color="#000000" face="verdana,Arial">
					<?=$row[te]?></font></td>
                    <td width="15%" align="left">
                    <a href="#" onClick="javascript:window.open('optin_edit_popup.php?eid=<?=$row[te];?>','','height=350 width=500')" class="pagelinks">[edit]</a>
                    &nbsp;&nbsp;<a href="opt_in_list.php?eid=<?=$row[te];?>&action=delete" onClick="return confirm_delete()" class="pagelinks">[delete]</a>
					</td>
					<td width="13%" align="left"><font size=1 color="#000000" face="verdana,Arial">
						<?=$row[vdate]?></font></td>                    
              
					<td width="13%" align="left"><font size=1 color="#000000" face="verdana,Arial">
						<?=$row[cdate]?></font></td>                    
              
					<td width="19%" align="left"><font size=1 color="#000000" face="verdana,Arial">
						<?=$row[xdate]?></font></td>                    
                    </tr>
                    
                     <? } ?>


                   </table>					
                    </td></tr>					
					</table>
                    <p>&nbsp;</p>
                    </form>
                     <!-------end-------//-->
                    </td>
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
