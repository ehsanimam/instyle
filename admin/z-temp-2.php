<?php
	error_reporting(E_ALL);	
	ini_set("display_errors", 1);
	
	include("../common.php");
	
	if (isset($_POST['submit']) && $_POST['submit'] && $_FILES["front"]['error'] == 0)
	{
		$file_name = $_FILES["front"]['name'];
		$file_temp = $_FILES["front"]['tmp_name'];
		
		$uploadFilesTo1 = '../'.$_POST['folder'].'product_front/';
		$uploadFilesTo2 = '../../products/'.$_POST['folder'].'product_front/';
		
		if ( ! move_uploaded_file($file_temp, $uploadFilesTo1.'/'.$file_name))
			$set1 = 'Not uploaded to main domain';
		if ( ! copy($uploadFilesTo1.'/'.$file_name, $uploadFilesTo2.'/'.$file_name))
			$set2 = 'Not copied to subdomain';
	}
	
	$upload_folder	 = 'product_assets/WMANSAPREL/basixblacklabel/cocktail/';
?>
	<form action="" method="POST" enctype="multipart/form-data">
	
		<input type="hidden" name="folder" value="<?php echo $upload_folder; ?>" />
		Image: <input type="file" name="front" />
		<input type="submit" name="submit" value="Submit" />
		
	</form>
	
	<?php
	echo isset($set1) ? $set1.'<br />' : '';
	echo isset($set2) ? $set2.'<br />' : '';
	//echo ini_get('open_basedir');
	?>