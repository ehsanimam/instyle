<?
session_start();
include("../common.php");
include('../functionsadmin.php');
include("security.php");

$img_id  = $_POST['img_id'];
$prod_id = $_POST['prod_id'];
$act     = $_POST['act'];
$mode    = $_POST['mode'];



$get_img = mysql_fetch_array(mysql_query("select * from tbl_product_imgs where img_id='".$_GET['img_id']."'"));


?>
<title>In Style New York::Admin Section</title>
<link href="style.css" rel="stylesheet" type="text/css">

	<center><span  class="text"><strong>VIEW VIDEO</strong><br />
	<span style="color:#ff0000;"><strong><? echo @$msg;?></strong></span>&nbsp;</span></center>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td class="tab" align="center" valign="middle">

          <script>
imgvideoFx = new Fx.Reveal($('imgvideo'),{duration: 500, mode: 'horizontal'});
imgFx= new Fx.Reveal($('imgmain'),{duration: 500, mode: 'horizontal'});
$('closebtn').addEvent('click',function(){imgvideoFx.dissolve();imgFx.reveal();$('closebtn').style.visibility='hidden';});
$('showVideo').set('href','javascript:void(0)');
$('showVideo').addEvent('click',function(){showVideofn()});


var showVideofn=function(){
imgFx.dissolve();
imgvideoFx.reveal();

var visibVid=function(){

$('vidcont').style.visibility='visible';
$('vidcont').style.width="450px";
$('vidcont').style.height="750px";

}

$('vidcont').style.width="1px";
$('vidcont').style.height="1px";
//$('vidcont').style.visibility='hidden';
var obj = new Swiff('/flash/player.swf', {
    id: 'productSwff',
    width: 450,
    height: 750,
	container:$('vidcont'),
    params: {
        wmode: 'transparent',
        bgcolor: '#000'
    },
	vars:{
	autostart:true,
	file:'http://www.basixblacklabel.com/admin/product_video/D5285A.flv',
	author:'BASIX BLACK LABEL',
	playerready:visibVid,
	repeat:'always',
	icons:false
	}
	
});

//$('closebtn').style.visibility='visible';	
return false;
}
</script>

	
	</td>
</tr>
</table>
