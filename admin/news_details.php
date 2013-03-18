<?
include("../common.php");
include('../functionsadmin.php');
  ?>
  <script language="javascript">
function del_rec(ad_id)
{
	if(confirm("Are you sure you want to delete record!"))
	{
		var formobj=document.form1;
		formobj.action='news_details.php?id='+ad_id+'&Action=Delete';
					formobj.submit();
					}
					}
	</script>
  <? 
$rno=10;
$sql="select * from tblnews  order by n_id desc";
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
}
 $pr_rs=mysql_query($sql);
include 'top.php'; 
?>
<?php 
if(isset($_GET['Action']))
	{
	$sql="delete from tblnews  where n_id='".$_GET['id']."'";
		//echo $sql;
		$rs=mysql_query($sql);
	}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="333" class="tab" align="center" valign="middle">
	
	
	<form name="form1" method="post" action="">
			<table width="85%" border="0" cellspacing="0" cellpadding="0">
				<tr valign="top" class="bodytext">
					<td class="border_color"> 
						<table border="0" cellpadding="2" width=100%>
							<tr bgcolor="#CCCCCC"><td colspan="4"><? if(@$err) echo "News Details has been updated."; ?></td></tr>
							<tr bgcolor="#CCCCCC">
								<td height="30"><h1>S.No</h1></td>
								<td><h1>Date</h1></td>
                                <td><h1>Details</h1></td>
								<!--<td><h1>Price</h1></td>-->
								<td><h1>Operation</h1></td>
							</tr>
							<?
							$counter=0;
							while($pr_row=mysql_fetch_array($pr_rs)){
							$counter++;
							?>
							<? //if($counter%2==0){?>
							<tr bgcolor='eeeeee' onMouseOver="this.bgColor='cccccc'" onMouseOut="this.bgColor='eeeeee'">
								<td class="headtxt" ><?=$counter;?></td>
								<td class="text"><?=$pr_row['n_date'];?></td>
                                <td class="text" ><? echo substr($pr_row['n_text'],0,50);?></td>
								<!--<td class="text">$<?echo $pr_row[prod_price]?></td>-->
								<td><span class="text">[</span><a href="edit_news.php?id=<?=$pr_row['n_id']?>" class="pagelinks">Edit</a><span class="text">]</span>
								<span class="text">[</span><a href="javascript:del_rec(<?=$pr_row['n_id'];?>);" class="pagelinks">Delete</a><span class="text">]</span></td>
							</tr>
						<? }?>
					</table>
				</td>
			</tr>
			<tr bgcolor='FFFFFF'>
			  <td align="right" height=30>
				<? if($cpage>1){?>
				<a href="news_details.php?cpage=<?echo $cpage-1;?>&cat_id=<?echo $cat_id;?>" class="pagelinks">Prev</a><?}?>
				<? if($cpage>2){?>
				<span class="text"> | </span> <?}?>
				<? if($cpage<$tpage){?>
				<a href="news_details.php?cpage=<?echo $cpage+1;?>&cat_id=<?echo $cat_id;?>" class="pagelinks">Next</a>
				<? }?>
			</td>
		   </tr>
			<tr bgcolor='FFFFFF'>
				<td align="left" height=30><span class="text"> Page :</span>
				<? for($i=1;$i<=$tpage;$i++){?>
				<? if($i==$cpage){?>
				<span class="text">[<?echo $i;?>]</span><? } else {?>
					<span class="text">[</span><a href="news_details.php?cpage=<?echo $i;?>&cat_id=<?echo $cat_id;?>" class="pagelinks"><?echo $i;?></a><span class="text">]</span><?}?>
				<? }?>
				</td>
			</tr>
			
		</table>
       </form>
	
	
	</td>
</tr>
</table>
<? include 'footer.php'; ?>