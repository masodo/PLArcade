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
# Section: FullScreen.php  Function: Play Game Full Screen   Modified: 2/28/2019   By: MaSoDo

if (isset($_GET['fullscreen'])) {
$fullplay = htmlspecialchars($_GET['fullscreen'], ENT_QUOTES);
$bg = mysql_fetch_array(run_query("SELECT * FROM phpqa_games WHERE gameid='".$fullplay."'"));
run_query("UPDATE phpqa_games SET `times_played`=".++$bg['times_played']." WHERE gameid='".$fullplay."'");
if (isset($bg['remotelink']) && $bg['remotelink'] == "") {

$BigGame = $fullplay.".swf"; 
echo "<script language='javascript' type='text/javascript'>window.open('fullout.php?dofull=" . $BigGame . "&H=" . $bg['gameheight'] . "&W=" . $bg['gamewidth'] . "', '_self');</script>";
} else {
$BigGame = $bg['remotelink'];
echo "<script language='javascript' type='text/javascript'>window.open('" . $BigGame . "', '_self');</script>";
}
}
?>