<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 2.0 (ALPHA) based on PHP-Quick-Arcade 3.0 © Jcink.com
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
# Section: ForumGate.php Function: GoTo Forum   Modified: 7/26/2019   By: MaSoDo

$time=time();
if (isset($_COOKIE['phpqa_user_c'])) {
$phpqa_user_cookie = $_COOKIE['phpqa_user_c'];
$w="Visiting the Forums";}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Updated Function Block #1
$areyouthere=@mysqli_fetch_array(run_iquery("SELECT name FROM phpqa_sessions WHERE name='".$phpqa_user_cookie."'"));
if(!$areyouthere) {
global $w; 
run_iquery("INSERT INTO phpqa_sessions (name,time,location) VALUES ('$phpqa_user_cookie','$time','$w')"); 
} else {
global $w; 
$areyouthere=run_iquery("UPDATE `phpqa_sessions` SET `time` = '$time', `location` = '$w' WHERE name='$phpqa_user_cookie'");
}
//END Updated Function Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
header("Location: /FORUM/");
?>
