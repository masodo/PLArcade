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
# Section: Announcement.php  Function: Display Announcement Section   Modified: 7/26/2019   By: MaSoDo
if(isset($settings['show_announcement'])&&$settings['show_announcement']==1) {
if(!isset($_COOKIE['DeAnn'])||(isset($_COOKIE['DeAnn'])&&$_COOKIE['DeAnn']=='NO')){
echo "<div style='width:1000px;margin-left:auto;margin-right:auto;'><div style='padding:3px;text-align:center;margin-top:-25;width:20px;height:20px;font-size:16px;font-weight:bold;float:right;background-color:#f00;color:#000;z-index:5000;opacity:1!important;'><a title='Dismiss Announcement' onClick='dismissannounce()'>X</a></div>";
require($textloc."/".$AnnounceFile);
echo "</div>";
} 
if(isset($_COOKIE['DeAnn'])&&$_COOKIE['DeAnn']=='YES'){
echo "<div style='width:1000px;margin-left:auto;margin-right:auto;'><div style='padding:3px;text-align:center;margin-top:-25;width:20px;height:20px;font-size:16px;font-weight:bold;float:right;background-color:#0f0;color:#000;z-index:5000;opacity:1!important;'><a title='Restore Announcement' onClick='restoreannounce()'>O</a></div>";
echo "</div>";
}}
?>
