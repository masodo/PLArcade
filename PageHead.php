<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 1.0 (BETA) based on PHP-Quick-Arcade 3.0 © Jcink.com
//Tournaments & JS By: SeanJ. - Heavily Modified by PracticalLightning Web Design
//Michael S. DeBurger [DeBurger Photo Image & Design]
//-----------------------------------------------------------------------------------/
//  phpQuickArcade v3.0.x © Jcink 2005-2010 quickarcade.jcink.com                        
//
//  Version: 3.0.23 Final. Released: Sunday, May 02, 2010
//-----------------------------------------------------------------------------------/
// Thanks to (Sean) http://seanj.jcink.com 
// for: Tournies, JS, and more
// ---------------------------------------------------------------------------------/
# Section: PageHead.php  Function: HTML Page Heading   Modified: 6/12/2019   By: MaSoDo
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2002/REC-xhtml1-20020801/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title> <?php echo $settings['arcade_title']; ?> </title>
<link rel='stylesheet' type='text/css' href='./skins/<?php echo $pic; ?>.css'>
<link rel="apple-touch-icon" sizes="57x57" href="/icon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/icon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/icon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/icon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/icon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/icon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/icon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/icon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/icon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/icon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">
<link rel="manifest" href="/icon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/icon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
.divVisible {display:block;}
.divHidden{display:none;} 
</style>
<script language="javascript" type="text/javascript"> 
function CollapseExpand1() {
var divObject = document.getElementById("MyDiv1"); 
var currentCssClass = divObject.className; 
if (divObject.className == ""){
divObject.className = "divVisible"; 
document.getElementById("btn1").src = "<?php echo $imgloc; ?>/closed.png";
}
if (divObject.className == "divVisible"){
divObject.className = "divHidden";
document.getElementById("btn1").src = "<?php echo $imgloc; ?>/closed.png";
} else {
divObject.className = "divVisible";
document.getElementById("btn1").src = "<?php echo $imgloc; ?>/open.png";
}
}
function CollapseExpand2() {
var divObject = document.getElementById("MyDiv2"); 
var currentCssClass = divObject.className; 
if (divObject.className == ""){
divObject.className = "divVisible"; 
document.getElementById("btn2").src = "<?php echo $imgloc; ?>/closed.png";
}
if (divObject.className == "divVisible"){
divObject.className = "divHidden";
document.getElementById("btn2").src = "<?php echo $imgloc; ?>/closed.png";
} else {
divObject.className = "divVisible";
document.getElementById("btn2").src = "<?php echo $imgloc; ?>/open.png";
}
}
function CollapseExpand3() {
var divObject = document.getElementById("MyDiv3"); 
var currentCssClass = divObject.className; 
if (divObject.className == ""){
divObject.className = "divVisible"; 
document.getElementById("btn3").src = "<?php echo $imgloc; ?>/closed.png";
}
if (divObject.className == "divVisible"){
divObject.className = "divHidden";
document.getElementById("btn3").src = "<?php echo $imgloc; ?>/closed.png";
} else {
divObject.className = "divVisible";
document.getElementById("btn3").src = "<?php echo $imgloc; ?>/open.png";
}
}
function CollapseExpand4() {
var divObject = document.getElementById("MyDiv4"); 
var currentCssClass = divObject.className; 
if (divObject.className == ""){
divObject.className = "divVisible"; 
document.getElementById("btn4").src = "<?php echo $imgloc; ?>/closed.png";
}
if (divObject.className == "divVisible"){
divObject.className = "divHidden";
document.getElementById("btn4").src = "<?php echo $imgloc; ?>/closed.png";
} else {
divObject.className = "divVisible";
document.getElementById("btn4").src = "<?php echo $imgloc; ?>/open.png";
}
}
function anchorlink(L) { window.location.href="#" + L + ""; }
</script>
</head>

<body><a id="top" name="top"></a>
<?php
if(isset($_GET['action']) && $_GET['action'] =='emotes') {} else {
if(isset($settings['closed_arcade']) && $settings['closed_arcade'] == 1 && !isset($_COOKIE['phpqa_user_c'])){} else {
?>
<div style="text-align:left; margin-bottom: 5px; margin-top: 5px;"><input id="Button1" type="button" value='&#8595; Go to Bottom of Page &#8595;' onclick="anchorlink('bottom');" style="font-size:16px; font-weight:bold; color:silver;" /></div>
<?php }} ?>
