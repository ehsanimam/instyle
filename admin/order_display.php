<?
session_start();
include("security.php");

include '../common.php';
include '../functionsadmin.php';
$sort = "order_id";



if($_GET['sortby'])
   $sort = $_GET['sortby'];

$prev_sort = $sort;

$order = 'asc';

if($_GET['orderby'])
   $order = $_GET['orderby'];

if($prev_sort == $sort)
{
   if($order == 'asc')  
      $order = 'desc';
   else
      $order = 'asc';
}
   
$rno=20;
$sql="select * from tblorder order by $sort $order";
$pr_rs=mysql_query($sql);
$rnum=mysql_num_rows($pr_rs);
if($rnum>=0)
     {
        $mod=$rnum%$rno;
        if($mod>0)
        {
          $tpage=($rnum-$mod)/$rno +1; 
        }
        else
        {
          $tpage=($rnum-$mod)/$rno;
        }
        if($cpage=="")
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
}
$sql="select * from tblorder order by $sort $order limit $skip,$lmt";
 
$pr_rs=mysql_query($sql);
?>
<html>
<head>
<title>Fashion::Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type=text/css>
<script>
function submit_form()
{
    document.prod_frm.method="post";
    document.prod_frm.action="add_product.php";
    document.prod_frm.submit();

}
</script>
</head>

<body>
<table width="100%" border="0" cellpadding="1" cellspacing="1">

    <tr>
      <td > <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor=gray >
          <tr>
            <td colspan="2" height=45 align="center" >
            <h1>7thavenuedirect Administration Section</h1> </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff"><div align="left">
                <table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="gray">
                  <tr>
                    <td width="32%" align=center bgcolor="#cccccc" valign=top>

                    <?include 'admin_left_menu.php';?>

                    </td>
                    <td width="68%"  valign=top align=center >&nbsp;&nbsp;

                    <!-----------------start--------------------//-->
  
  
  
  
          <form name="news_disp_frm" method="post" action="add_new_news.php?act=add">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr valign="top" class="bodytext">
					<td class="border_color"> 
                      <table border="0" cellpadding="5" width=100%>
							<tr class="border_color">
								<td class="text" width=20%><a href="order_display.php?sortby=order_id&orderby=<?= $order ?>"><font color="#000000"><b>Order No</b></font></a></td>
								<td class="text" width=20%><a href="order_display.php?sortby=order_date&orderby=<?= $order ?>"><font color="#000000"><b>Order Date</b></font></a></td>
								<td class="text" width=10%><a href="order_display.php?sortby=qty&orderby=<?= $order ?>"><font color="#000000"><b>Qty</b></font></a></td>
								<td class="text" width=20% align='right'><a href="order_display.php?sortby=amount&orderby=<?= $order ?>"><font color="#000000"><b>Amount</b></font></a></td>
								<td class="text" width=10% align='right'><a href="order_display.php?sortby=payment_status&orderby=<?= $order ?>"><font color="#000000"><b>Payment</b></font></a></td>
								<td class="text" width=20% align='right'><b>Operation</b></td>
							</tr>
							<?
							$counter=0;
                            while($pr_row=mysql_fetch_array($pr_rs))
							{
								$tot_qty=$tot_qty+$pr_row[qty];
								$tot_amount=$tot_amount+$pr_row[amount];
								$counter++;
							?>
							<tr bgcolor="#eeeeee" onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='eeeeee'">
								<td width=20% class="text"><?echo $pr_row[order_id];?></td>
								<td width=20% class="text"><?echo $pr_row[order_date];?></td>
								<td width=10% class="text"><?echo $pr_row[qty]?></td>
								<td width=20% align="right" class="text">$<?echo $pr_row[amount]?></td>
								<td width=10% class="text"><?if($pr_row[payment_status] != "Done"){echo 'N';}else{echo 'Y';}?></td>
								<td width=20% align='right' class="text">[<a href="admin_order_details.php?transaction_id=<?echo $pr_row[order_id];?>&cart_id=<?echo $pr_row[cart_id];?>&option=<?echo 'o';?>" class="linktxt">Details</a>]
								[<a href="admin_order_details.php?transaction_id=<?echo $pr_row[order_id];?>&cart_id=<?echo $pr_row[cart_id];?>&option=<?echo 'd';?>" class="linktxt">Delete</a>]</td>
							</tr>
							<?}?>
							<tr>
								<td class="text"><b>Total</b></td>
								<td></td>
								<td class="text"><b><?echo $tot_qty;?></b></td>
								<td align="right" class="text"><b>$<?=$tot_amount;?></b></td>
								<td align="right" colspan=2>
								<?if($cpage>1){?>
								<a href="order_display.php?cpage=<?echo $cpage-1;?>" class="linktxt1">Prev</a><?}?> | 
								<?if($cpage<$tpage){?>
								<a href="order_display.php?cpage=<?echo $cpage+1;?>" class="linktxt1">Next</a>
								<?}?>
								</td>
                            </tr>
							<tr bgcolor='999999'>
								<td align="left" class="text" colspan=6>Page :
									<?for($i=1;$i<=$tpage;$i++){?>
										[<a href="order_display.php?cpage=<?echo $i;?>" class="leftlink"><font color=="<?if($i==$cpage){?>#0000ff<?}?>"><?echo $i;?></font></a>]
									<?}?>
								</td>
							</tr>
                          </table>
   		</td>
				</tr>
			</table>
            </form>





 <!-------end-------//-->



                    </td>
                  </tr>
                </table>
                 <br><br>
              </div>
            </td>
          </tr>
        </table></td>
    </tr>

</table>
</body>
</html>
