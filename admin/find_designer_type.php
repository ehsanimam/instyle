<?
include("../common.php");

?>
<select name="destype_id">
	<option> - select type - </option>
	<?php
	$type = mysql_query("select * from designer_type where catid = ".$_GET['destype_id']);
	if(mysql_num_rows($type) > 0) {
		while($rowt = mysql_fetch_array($type)) {
			?> <option value="<?=$rowt['destype_id']?>"><?=$rowt['designer_type']?></option> <?php
		}
	}
	?>
</select>
