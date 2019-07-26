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
# Section: Leaderboards.php  Function: Display of Hall of Fame   Modified: 7/26/2019   By: MaSoDo

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//		  SnapShot
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Incompatible Function Block #1
$Wyears = run_query("SELECT DISTINCT `Wyear` FROM `phpqa_wall` ORDER BY `Wyear` ASC");


while($WYsee = mysql_fetch_array($Wyears)) {
$Wyear = date("Y");
if ($WYsee['Wyear'] == $Wyear) { die("<script>alert('We Already Have This SnapShot!')</script>"); }
}

$Wscoreboard = run_query("SELECT `name`,`avatar`, COUNT(`phpqa_leaderboard`.`username`) AS `champions` FROM `phpqa_accounts` LEFT JOIN `phpqa_leaderboard` ON `phpqa_accounts`.`name` = `phpqa_leaderboard`.`username` GROUP BY `phpqa_leaderboard`.`username` ORDER BY `champions` DESC LIMIT 0,3");
$Wscores=mysql_fetch_array($Wscoreboard);


if ($Wscores['avatar'] == ''){ $Wscores['avatar'] = $avatarloc.'/man.gif'; }

$trop = 1;
$Wyear = date("Y");
$Wplace = $trop;
$Wgames = $Wscores['champions'];
$Wname = $Wscores['name'];
$Wavatar = $Wscores['avatar'];

run_query("INSERT INTO `phpqa_wall` (`Wyear`,`Wplace`,`Wgames`,`Wname`,`Wavatar`) VALUES (".$Wyear.",".$Wplace.",".$Wgames.",'".$Wname."','".$Wavatar."')");

while($Wscores=mysql_fetch_array($Wscoreboard)){
$trop = $trop + 1;
$Wyear = date("Y");
$Wplace = $trop;
$Wgames = $Wscores['champions'];
$Wname = $Wscores['name'];
$Wavatar = $Wscores['avatar'];
run_query("INSERT INTO `phpqa_wall` (`Wyear`,`Wplace`,`Wgames`,`Wname`,`Wavatar`) VALUES (".$Wyear.",".$Wplace.",".$Wgames.",'".$Wname."','".$Wavatar."')");
}
//END Incompatible Function Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//		End SnapShot
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
echo "<h1>SnapShot Taken</h1>";
?>
