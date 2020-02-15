<?php
$imagePath = dirname(dirname(dirname(dirname(__FILE__)))).'/radiantApp/__uploaded__/lead/';
$t = explode('/',trim($_SERVER['REDIRECT_URL']));
$imageFile = $imagePath.$t[count($t)-(1)];

if(preg_match('/(\.png|\.jpg|.jpeg|.pdf|.doc|.docx|.xls|.xlsx)$/i',$imageFile) && is_file($imageFile))
{
    $imginfo = getimagesize($imageFile);
    header('Content-type: '.$imginfo['mime']);
    readfile($imageFile);
}else{
    header("Content-type: image/png"); 
    readfile($imagePath.'../default/avatar.png');
}

