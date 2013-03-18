<?php 
//set_time_limit(500);
//ini_set("display_errors",1);

include("../common.php");
include("security.php");
include('../functionsadmin.php');

?>
<html>
	<head>
		<title></title>
	</head>
<body>
	<center><h1>Please wait ... do not refresh this page.</h1></center>
</body>	
</html>

<?php
	$strFile1 = 'csv/'.str_replace('csv/','',$_GET['file']);
	
	// temporarily set deisgner for site_ini field manually per csv upload
	//$site_ini = 'jiovani';
	//$site_ini = 'basix';
	$site_ini = 'instyle';
	//$site_ini = '';
	
	$columnheadings = 0;
	$i = 0;
	$count = 0;
	$filecontents = file($strFile1,FILE_IGNORE_NEW_LINES); // ----> file() returns an array of the file on a per line basis
	
	$records = (sizeof($filecontents) - 1);
	echo $records.' rows<br />';

	// for each row $i
	for ($i = $columnheadings; $i < sizeof($filecontents); $i++)
	{
		if ($i == 0) // ----> first row are headings. do nothing.
		{
			$fields = $filecontents[0];
			
			/*
			| --------------------------------------------------------------------------------------
			| This code here does the following:
			| Assign an associative $key to the CSV fields for easier association
			| Check for any possible errors on CSV heading 
			*/
			$fields = explode(',',$filecontents[0]);
			$column_name = array();
			while ($field_item = current($fields))
			{
				// allows to trim possible whitespaces on column headers
				$column_name[key($fields)] = trim($field_item);
				next($fields);
			}
			
			// function is_empty allows for zero integer as valid entry
			function is_empty($var, $allow_false = false, $allow_ws = false) {
				if (!isset($var) || is_null($var) || ($allow_ws == false && trim($var) == "" && !is_bool($var)) || ($allow_false === false && is_bool($var) && $var === false) || (is_array($var) && empty($var))) {   
					return true;
				} else {
					return false;
				}
			}
			
			// associate the keys to fields
			$csv_key_email = array_search('Email',$column_name);
				if (is_empty($csv_key_email)) $field_empty_err = TRUE;
			$csv_key_pwd = array_search('pwd',$column_name);
				if (is_empty($csv_key_pwd)) $field_empty_err = TRUE;
			$csv_key_first_name = array_search('First Name',$column_name);
				if (is_empty($csv_key_first_name)) $field_empty_err = TRUE;
			$csv_key_last_name = array_search('Last Name',$column_name);
				if (is_empty($csv_key_last_name)) $field_empty_err = TRUE;
			$csv_key_comp = array_search('comp',$column_name);
				if (is_empty($csv_key_comp)) $field_empty_err = TRUE;
			$csv_key_tel = array_search('tel',$column_name);
				if (is_empty($csv_key_tel)) $field_empty_err = TRUE;
			$csv_key_cel = array_search('cel',$column_name);
				if (is_empty($csv_key_cel)) $field_empty_err = TRUE;
			$csv_key_fax = array_search('fax',$column_name);
				if (is_empty($csv_key_fax)) $field_empty_err = TRUE;
			$csv_key_adr1 = array_search('adr1',$column_name);
				if (is_empty($csv_key_adr1)) $field_empty_err = TRUE;
			$csv_key_adr2 = array_search('adr2',$column_name);
				if (is_empty($csv_key_adr2)) $field_empty_err = TRUE;
			$csv_key_country = array_search('Country',$column_name);
				if (is_empty($csv_key_country)) $field_empty_err = TRUE;
			$csv_key_city = array_search('city',$column_name);
				if (is_empty($csv_key_city)) $field_empty_err = TRUE;
			$csv_key_zip = array_search('zip',$column_name);
				if (is_empty($csv_key_zip)) $field_empty_err = TRUE;
			$csv_key_state = array_search('State',$column_name);
				if (is_empty($csv_key_state)) $field_empty_err = TRUE;
			$csv_key_email2 = array_search('email2',$column_name);
				if (is_empty($csv_key_email2)) $field_empty_err = TRUE;
			$csv_key_dress_size = array_search('Dress Size',$column_name);
				if (is_empty($csv_key_dress_size)) $field_empty_err = TRUE;
			
			// for debuggin purposes
			echo '<br />Email: '.$csv_key_email;
			echo '<br />pwd: '.$csv_key_pwd;
			echo '<br />First Name: '.$csv_key_first_name;
			echo '<br />Last Name: '.$csv_key_last_name;
			echo '<br />comp: '.$csv_key_comp;
			echo '<br />tel: '.$csv_key_tel;
			echo '<br />cel: '.$csv_key_cel;
			echo '<br />fax: '.$csv_key_fax;
			echo '<br />adr1: '.$csv_key_adr1;
			echo '<br />adr2: '.$csv_key_adr2;
			echo '<br />Country: '.$csv_key_country;
			echo '<br />city: '.$csv_key_city;
			echo '<br />zip: '.$csv_key_zip;
			echo '<br />State: '.$csv_key_state;
			echo '<br />email2: '.$csv_key_email2;
			echo '<br />Dress Size: '.$csv_key_dress_size;
			
			$leave_page = FALSE;
			
			if (isset($field_empty_err))
			{
				unset($field_empty_err);
				echo '
					<script>
						alert("There is an error with one of your CSV column headings."+"\n"+"Please fix then upload again.");
					</script>'
				;
				$leave_page = TRUE;
			}
			
			if ($leave_page)
			{
				echo '
					<script>
						window.location.href="upload-user.php";
					</script>
				';
			}
			
			?>
			<!--
			<script>
				alert('Continue...');
			</script>
			-->
			<?php
		}
		else
		{
		   	$data =  explode(",", $filecontents[$i]);
			
			$q_sel = "SELECT * FROM tbluser_data WHERE email = '".trim($data[$csv_key_email])."'";
			$check_q = mysql_query($q_sel) or die('Check email on db error: '.mysql_error());
			
			if (trim($data[$csv_key_first_name]) == '')
			{
				$exp_email = explode('@',trim($data[$csv_key_email]));
				$use_firstname = $exp_email[0];
			}
			else $use_firstname = trim($data[$csv_key_first_name]);
			
			if (mysql_num_rows($check_q) == 0)
			{
				// insert into tbluser_data
				$insert_query1 = "
					INSERT INTO tbluser_data (
						firstname,
						lastname,
						company,

						telephone,
						cellphone,
						fax,
						address1,
						address2,
						country,
						city,
						state_province, 
						zip_postcode,
						email,
						password,
						
						receive_productupd,
						
						dresssize,
						is_active,
						site_ini
					)
					VALUES (
						'".$use_firstname."',
						'".trim($data[$csv_key_last_name])."',
						'".trim($data[$csv_key_comp])."',
						
						'".trim($data[$csv_key_tel])."',
						'".trim($data[$csv_key_cel])."',
						'".trim($data[$csv_key_fax])."',
						'".trim($data[$csv_key_adr1])."',
						'".trim($data[$csv_key_adr2])."',
						'".trim($data[$csv_key_country])."',
						'".trim($data[$csv_key_city])."',
						'".trim($data[$csv_key_state])."',
						'".trim($data[$csv_key_zip])."',
						'".trim($data[$csv_key_email])."',
						'".trim($data[$csv_key_pwd])."',
						
						'1',
						
						'".trim($data[$csv_key_dress_size])."',
						'1',
						'".$site_ini."'
					)";
				mysql_query($insert_query1) or die('tbluser_data insert error: '.mysql_error());
				
				$q_sel2 = "SELECT * FROM tbluser WHERE e_mail = '".trim($data[$csv_key_email])."'";
				$check_q2 = mysql_query($q_sel2) or die('Check email on db error: '.mysql_error());
				
				if (mysql_num_rows($check_q2) == 0)
				{
					// insert into tbluser
					$insert_query2 = "
						INSERT INTO tbluser (
							e_mail,
							user_name,
							user_password,
							uname,
							access_level,
							create_date,
							isregistered,
							received_produpdate
						)
						VALUES (
							'".trim($data[$csv_key_email])."',
							'".trim($data[$csv_key_email])."',
							'".trim($data[$csv_key_pwd])."',
							'".$use_firstname." ".trim($data[$csv_key_last_name])."',
							'0',
							'".date('Y-m-d', time())."',
							'1',
							'1'
						)
					";
					mysql_query($insert_query2) or die('tbluser insert error: '.mysql_error());
				}

				$count++;
				$err = 0;
			}
			else $err = 1;
		}
	}
	
	$file = strtolower($strFile1);
	unlink("$file");
	
    if ($err == 1)
	{
		echo "<script>window.location.href='upload-user.php?msg=2'</script>"; 
	}
	else
	{
    	echo "<script>window.location.href='upload-user.php?msg=1&count=".$count."&rec=".$records."'</script>";
	}
?>
