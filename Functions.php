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
# Section: Functions.php  Function: Some Common Functions   Modified: 2/28/2019   By: MaSoDo

function rangecheck($a){
if (substr($a,-1)!=".") $a.=".";
$ip=$_SERVER['REMOTE_ADDR'];
return substr($ip,0,strlen($a))==$a;
}
$bannedfile = file($textloc."/banned.txt"); 
foreach($bannedfile as $a_banned_ip) {
if (rangecheck($a_banned_ip)) { 
message("You have been banned from this arcade.");
die();
}
} 
?>