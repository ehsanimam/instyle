<?
include("../common.php");
include 'top.php'; 

if (isset($_GET['del']))
	{
		$q_del = "DELETE FROM tblhome WHERE id = '".$_GET['del']."'";
		$r_del = mysql_query($q_del) or die('Delete error: '.mysql_error());
		$err="Offer has been Deleted";
	}

if(isset($_POST['btnSeq'])) {
		$get_seq = @mysql_query("select id from tblhome") or die(mysql_error());
		while($row = @mysql_fetch_array($get_seq)) {
			@mysql_query("update tblhome set seq='".$_POST[$row['id']]."' where id='".$row['id']."'");
			$err="Sequence has been Updated";
		}
		
	}

?>
<script language="javascript">

function r_u_sure() {
	var r = confirm("Are you sure you want to delete the offer?");
	if (r == true) {
		return true;
	} else {
		return false;
	}
	
}
</script>

<table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor=cccccc>
	<tr><td height="333" class="tab" align="center" valign="middle">
<!--bof form============================================================================-->
	<form name="category" action="" method="post" enctype="MULTIPART/FORM-data">
    <table border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="cccccc">
	<tr><td>
	
		<center><h1>EDIT/DELETE OFFERS</h1></center><br>
		
		<table border="0" cellspacing="2" cellpadding="2" width="800" align="center" >
			<tr>
				<td align=center colspan=6 class="error"><? if(@$err) echo $err; ?></td>
			</tr>
			<tr>
				<td class="text" width="30" style="background:#999"><b>ID</b></td>
				<td class="text" style="background:#999"><b>Sequence</b></td>
				<td class="text" style="background:#999"><b>Title</b></td>
				<td class="text" style="background:#999"><b>Description</b></td>
				<td class="text" style="background:#999"><b>Link</b></td>
				<td class="text" width="60" style="background:#999"><b>Action</b></td></tr>
			<?php
			// The Query
			$q = mysql_query("SELECT * FROM tblhome ORDER BY id ASC") or die('Query error: '.mysql_error());
			
			if (mysql_num_rows($q))
			{
				while ($r = mysql_fetch_array($q))
				{
					
			?>
			<tr>
				<td class="text" style="border-bottom:1px solid #efefef;"><?php echo $r['id']; ?></td>
				<td class="text" style="border-bottom:1px solid #efefef;"><input type="text" name="<?php echo $r['id']; ?>" value="<?php echo $r['seq']; ?>" style="width:30px;"></td>
				<td class="text" style="border-bottom:1px solid #efefef;"><?php echo $r['title1']; ?></td>
				<td class="text" style="border-bottom:1px solid #efefef;"><?php echo $r['desc1']; ?></td>
				<td class="text" style="border-bottom:1px solid #efefef;"><?php echo $r['link']; ?></td>
				<td class="text" style="border-bottom:1px solid #efefef;">
					<a href="edit_offer.php?n_id=<?php echo $r['id']; ?>">Edit</a><br />
					<a href="edit_manager.php?del=<?php echo $r['id']; ?>" onclick="return r_u_sure()">Delete</a><br />
				</td>
			</tr>
					<?php
				}
			} ?>
		</table>
		<input type="submit" name="btnSeq" value="Update Sequence" style="margin-top:5px;"> 
	
	</td></tr>
	</table>
    </form>
	<!--eof form============================================================================-->
	</td></tr>
</table>