<div class="content" id="page-1">
<span><strong>Apparel Size Chart (in)</strong></span>
    <table width="100%" cellpadding="2" cellspacing="2" align="center">
        <tr>
        	<td style="height:280px;vertical-align:top;">
            <?php
            $get_tblsize = $this->query_page->get_tblsize_modal();
			
            if($get_tblsize->num_rows()>0) {
            ?><br />
            <table cellpadding="4" border="1" style="border-collapse:collapse;" align="center">
            <tr><td style="width:100px;background:#000;color:#fff;"><strong>Size</strong></td>
            <td style="width:100px;background:#000;color:#fff;"><strong>Bust (in)</strong></td>
            <td style="width:100px;background:#000;color:#fff;"><strong>Waist (in)</strong></td>
            <td style="width:100px;background:#000;color:#fff;"><strong>Hip (in)</strong></td></tr>
            <?php
            foreach($get_tblsize->result() as $srow) {
            ?>
            <tr style="background:#efefef;"><td><?php echo $srow->size_name; ?></td><td><?php echo $srow->bust; ?></td><td><?php echo $srow->waist; ?></td><td><?php echo $srow->hip; ?></td></tr>
            <?php
            }
            ?>
            </table>
            <?php
        }
        ?>        	</td>
    	</tr>
	</table> 
</div>


<div class="content" id="page-2">
<span><strong>Apparel Size Chart (cm)</strong></span>
    <table width="100%" cellpadding="2" cellspacing="2" align="center">
        <tr>
        	<td style="height:280px;vertical-align:top;">
            <?php
            $get_tblsize = $this->query_page->get_tblsize_modal();			
            if($get_tblsize->num_rows()>0) {
            ?><br />
            <table cellpadding="4" border="1" style="border-collapse:collapse;" align="center">
            <tr><td style="width:100px;background:#000;color:#fff;"><strong>Size</strong></td>
            <td style="width:100px;background:#000;color:#fff;"><strong>Bust (cm)</strong></td>
            <td style="width:100px;background:#000;color:#fff;"><strong>Waist (cm)</strong></td>
            <td style="width:100px;background:#000;color:#fff;"><strong>Hip (cm)</strong></td></tr>
            <?php
            foreach($get_tblsize->result() as $srow) {
			   $bust=$srow->bust * 2.54;
			   $bust=substr($bust,0,5);
			   $waist=$srow->waist * 2.54;
			   $waist=substr($waist,0,5);			   
			   $hip=$srow->hip * 2.54;	
               //add 3 to size 10
               if($srow->size_name == '10')
                $hip += 3;

			   $hip=substr($hip,0,5);			   		   			   
            ?>
            <tr style="background:#efefef;"><td><?php echo $srow->size_name; ?></td><td><?php echo $bust;?></td><td><?php echo $waist;?></td><td><?php echo $hip;?></td></tr>
            <?php
            }
            ?>
            </table>
            <?php
        }
        ?>        	</td>
    	</tr>
	</table> 
<span><strong>Measuring Info</strong></span>
	<div style="text-align: center;"><IMG SRC="<?php echo base_url(); ?>images/measuringInfo.jpg" border=0 width="565" height="410" alt="Measuring Info" longdesc="Measuring Information" /></div>