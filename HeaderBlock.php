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
# Section: HeaderBlock.php  Function: Top of the Page   Modified: 3/18/2019   By: MaSoDo

$CPH = 0;
$CPF = 0;
$CPD = 0;
$catquer2 = run_query("(SELECT platform,gamecat FROM phpqa_games)");
$cp=@mysql_fetch_array($catquer2);
while($cp=@mysql_fetch_array($catquer2)){
if ($cp['platform'] == 'H5') { 
$CPH = $CPH+1;
if ($cp['gamecat'] == '2') {
$CPH = $CPH-1;
} 
if ($cp['gamecat'] == '20') {
$CPH = $CPH-1;
$CPD = $CPD+1;
}
}
if ($cp['platform'] == 'FL') {
$CPF = $CPF+1; 
if ($cp['gamecat'] == '2') {
$CPF = $CPF-1;
} 
}
}
if(isset($settings['enable_logo'])) {
if(isset($_GET['action']) && $_GET['action'] =='emotes') {} else {
echo "<div align='center' style='margin-top: 0px; width:100%;'>"; 
if (!isset($_GET['fullscreen'])) {echo "<a href='index.php?plat=FL' title='List Only Flash Games'><img src='$arcurl/$imgloc/flash.png' style='width:75px; margin-bottom:15px; margin-right:10%;' /></a>";}
echo "<a href='index.php' title='$arcgreet'><img src='arcade/pics/$pic.gif' border='0' /></a>";
if (!isset($_GET['fullscreen'])) {echo "<a href='index.php?plat=H5' title='List Only HTML5 Games'><img src='$arcurl/$imgloc/HTML5.png' style='width:75px; margin-bottom:15px; margin-left:10%;' /></a>";}
echo "<div style='position:relative; width:640px; top:10px; font-size: 14px; color: yellow; background-color: navy; padding:3px;'>Currently Featuring <b>$CPF Flash</b> Games, <b>$CPH HTML5</b> Games &amp; <b>$CPD DOS</b> Games<hr /><b>Countdown to Arcade Score Reset:<br /><div id='countbox'></div></div>";
echo "</div>";
}}
?>
