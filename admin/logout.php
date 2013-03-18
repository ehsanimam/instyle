<?PHP
session_start();
function set_session($ParamName, $ParamValue)
{
  global ${$ParamName};
  if(session_is_registered($ParamName))
    session_unregister($ParamName);
  ${$ParamName} = $ParamValue;
  session_register($ParamName);
}
function get_session($ParamName)
{
  global $HTTP_POST_VARS;
  global $HTTP_GET_VARS;
  global ${$ParamName};
  $ParamValue = "";
  if(!isset($HTTP_POST_VARS[$ParamName]) && !isset($HTTP_GET_VARS[$ParamName]) && session_is_registered($ParamName))
    $ParamValue = ${$ParamName};
  return $ParamValue;
}

//Set sessions

 $test =  session_register("session_admin");
 $test="";
if($test="")
{
header("Location: index.php");
exit;	
}


//Unregister the session variable if registered previously.
if(session_is_registered("session_admin"))
	session_unregister("session_admin");
session_destroy();
header("Location: index.php");
exit;	
?>