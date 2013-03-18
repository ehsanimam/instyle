<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Resize Image</title>

<meta name="coverage" content="worldwide" />
<meta name="Content-Language" content="english" />
<meta name="resource-type" content="document" />
<meta name="robots" content="all,index,follow" />
<meta name="classification" content="Instyle New York" />
<meta name="rating" content="general" />
<meta name="revisit-after" content="10 days" />
<link href="<?php echo base_url(); ?>style/main.css" rel="stylesheet" type="text/css"/>
<?php echo $this->set->jquery(); ?>
<script type="text/javascript">
function resize_ajax_request() {
  $('#ajax-placeholder').html('<p><?php echo img('images/ajaxloader.gif'); ?></p>');
  $('#ajax-placeholder').load("<?php echo base_url(); ?>resize/index");
}
</script>
</head>
<body><br />
<table border="0" align="center" style="border:1px solid #999;width:300px;">
<tr><td style="text-align:center;background:#efefef;color:#333333;padding:10px 0px;">
<strong>RESIZE IMAGES:</strong> </td>
</tr>
<tr><td style="padding:20px;" align="center">
<input type="button" onclick="resize_ajax_request()" value="Resize Now!" />
<div id="ajax-placeholder">
  <p></p>
</div>
</td></tr></table>
</body>
</html>