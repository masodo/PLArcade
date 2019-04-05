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
# Section: acp.php  Function: (Experimental) Administrator Control Panel   Modified: 4/5/2019   By: MaSoDo
$place = htmlspecialchars($_GET['cpiarea']); 
if (isset($_REQUEST['acpcheck'])) die();
if (isset($_COOKIE['acpcheck'])) die();
if ($acpcheck !="ok") die("You cannot access this area directly.");
if($place == "idx") {
require "acpi/idx.php";
} elseif ($place == "addgames") {
require "acpi/addgames.php";
} elseif($place == "tar_import") {
require "acpi/tar_import.php";
} elseif($place == "tar_importH5") {
require "acpi/tar_importH5.php";
} elseif($place == "skin") {
require "acpi/skin.php";
}

if ($place == "editor") {
require "acpi/editor.php";
}

if($place == "games") {
require "acpi/games.php";
}

if ($place == 'emotes') {
require "acpi/emotes.php";
}

if ($place == 'mysql') {
require "acpi/mysql.php";
} elseif($place=="members") {
require "acpi/members.php";
}

if ($place == 'bannedIPlist') {
require "acpi/bannedIPlist.php";
}
	
if($place == "Cheating_Attempts") {
require "acpi/Cheating_Attempts.php";
}

if ($place == 'settings') {
require "acpi/settings.php";
} 

if ($place == 'cats') {
require "acpi/cats.php";
} 

if($place == "Email") {
require "acpi/Email.php";
}

if ($place == 'filter') {
require "acpi/filter.php";
}
if ($place == 'snapshot') {
require "acpi/SnapShot.php";
}
if ($place == 'affiliates') {
require "acpi/affiliate.php";
}
?>
