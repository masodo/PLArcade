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
# Section: Arcade.php  Function: Main Organization Page   Modified: 6/10/2019   By: MaSoDo
//-----------------------------------------------------------------------------------/
require "./Preliminary.php";
require "./Functions.php";
require "./PageHead.php";
require "./HeaderBlock.php";
require "./AddStyle.php";
require "./JavaScript.php";
require "./SmileyPop.php";
require "./FullScreen.php";
if (!isset($_GET['act'])) {
require "./ArcadeInfo.php";
require "./ShoutBox.php";
require "./Categories.php";
require "./NavShout.php";
} else { echo "<br />"; message("Game Over!"); }
if (isset($_GET['play']) && $_GET['play']) require "./PlayOption.php"; // Playing?
if (isset($_GET['action']) && $_GET['action'] == "forgotpass") require "./ForgotPassOption.php";
elseif (isset($_GET['action']) && $_GET['action'] == "members") require "./MembersOption.php";
elseif (isset($_GET['action']) && $_GET['action'] == "register") require "./RegisterOption.php";
elseif (isset($_GET['action']) && $_GET['action'] == "Online") require "./OnlineOption.php";
elseif (isset($_GET['action']) && $_GET['action'] == "profile") require "./ProfileOption.php";
elseif (isset($_GET['action']) && $_GET['action'] == "leaderboards") require "./LeaderboardsOption.php";
elseif (isset($_GET['action']) && $_GET['action'] == "HOF") require "./HOFboardsOption.php";
elseif (isset($_GET["action"]) && $_GET['action'] == "settings") require "./SettingsOption.php";
if (isset($id) || isset($_GET['do']) && $_GET['do'] == "newscore" || isset($_GET['autocom'])) { 
require "./ScoringOption.php";
}
if(isset($_GET['cparea'])||isset($_GET['cpiarea'])) {
require "./AdminOption.php";
} elseif(isset($_GET['modcparea'])) {
require "./ModOption.php";
} else {
if ($IDXV == 'GV'){  				// You"re on the index. OK.
require "./IndexOption.php";
} else {
require "./IndexOptionCV.php";
}
}
require "./PageMaker.php";
require "./FooterBlock.php";
?>
