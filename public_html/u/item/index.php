<?php
$imagePath = dirname(dirname(dirname(dirname(__FILE__)))).'/radiantApp/__uploaded__/item/';
$t = explode('/',trim($_SERVER['REDIRECT_URL']));
$imageFile = $imagePath.$t[count($t)-(1)];

if(preg_match('/(\.png|\.jpg|.jpeg)$/i',$imageFile) && is_file($imageFile))
{
    $imginfo = getimagesize($imageFile);
    header('Content-type: '.$imginfo['mime']);
    readfile($imageFile);
}else{
    header("Content-type: image/png"); 
    readfile($imagePath.'../default/jobLogo.png');
}

