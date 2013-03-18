<?php

// ----------------------------------------------
// --> validate email
function l_validate_email($email)
{
	if ( ! preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i', $email))
	{
		return FALSE;
	}
	else
	{
		if (substr_count($email,"@") != 1 || stristr($email," ") || stristr($email,"\\") || stristr($email,":"))
		{
			return FALSE;
		}
		else
		{
			$exploded_email = explode("@",$email);
			if (empty($exploded_email[0]) || strlen($exploded_email[0]) > 64 || empty($exploded_email[1]))
			{
				return FALSE;
			}
			else
			{
				if (substr_count($exploded_email[1],".") == 0)
				{
					return FALSE;
				}
				else
				{
					$exploded_domain = explode(".",$exploded_email[1]);
					if (in_array("",$exploded_domain))
					{
						return FALSE;
					}
					else
					{
						foreach($exploded_domain as $value)
						{
							if (strlen($value) > 63 || !preg_match('/^[a-z0-9-]+$/i',$value))
							{
								$bad_match = 1;
								return FALSE;
								break;
							}
						}
					}
				}
			}
		}
	}
	
	return TRUE;
}

// ----------------------------------------------
// --> insert new user
function add_user($post_ary)
{
	$sa_user = $post_ary['sa_user'];
	$sa_lname = $post_ary['sa_lname'];
	$sa_email = $post_ary['sa_email'];
	$sa_pword = $post_ary['sa_pword'];
	
	$txt = "
		INSERT INTO tbladmin_sales (
			admin_sales_email,
			admin_sales_password,
			admin_sales_user,
			admin_sales_lname
		) VALUES (
			'".$sa_email."',
			'".md5($sa_pword)."',
			'".$sa_user."',
			'".$sa_lname."'
		)
	";
	$qry = mysql_query($txt) or die('Insert sales user error: '.mysql_error());
}

