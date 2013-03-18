<?php
header('Content-disposition: attachment; filename=product_master_template_issuenewyork_jackets.csv');
header('Content-type: text/plain');
readfile('product_master_template_issuenewyork_jackets.csv');
?>