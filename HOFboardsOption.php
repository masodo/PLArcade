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
# Section: Leaderboards.php  Function: Display of Hall of Fame   Modified: 3/20/2019   By: MaSoDo

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//		  Leaderboards
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$scoreboard = run_query("SELECT phpqa_accounts.name,phpqa_accounts.avatar, COUNT(phpqa_games.HOF_name) AS HOF_champ FROM phpqa_accounts
LEFT JOIN phpqa_games ON phpqa_accounts.name = phpqa_games.HOF_name
GROUP BY phpqa_games.HOF_name
ORDER BY HOF_champ DESC LIMIT 1,50000");
$scoreboardc = mysql_fetch_array(run_query("SELECT phpqa_accounts.name,phpqa_accounts.avatar, COUNT(phpqa_games.HOF_name) AS HOF_champ FROM phpqa_accounts
LEFT JOIN phpqa_games ON phpqa_accounts.name = phpqa_games.HOF_name
GROUP BY phpqa_games.HOF_name
ORDER BY HOF_champ DESC LIMIT 0,3"));
if ($scoreboardc['avatar'] == ''){ $scoreboardc['avatar'] = $avatarloc.'/man.gif'; }
 echo "<br /><div><table width='33%' cellpadding='5' cellspacing='1'>";
 echo "<tr><td width='100%' align=center class='headertableblock' style='font-size:24px'><img alt='image' src='".$crowndir."/crown1.gif' /> Hall of Fame Champion: <img image src='".$crowndir."/crown1.gif' /></td></tr>";
echo "<tr><td class='arcade1'><div style='font-size:16px; color: gold;' align='center'>With <I>".$scoreboardc['HOF_champ']."</I> Games</div><div align='center' style='font-size:24px'><i><a href=\"index.php?action=profile&amp;user=".$scoreboardc['name']."\"><img src='".$scoreboardc['avatar']."' /><br />".$scoreboardc['name']."</a></i></div></td></tr>";
echo "</table></div><div style='position:absolute;display:none;margin-top:-100px;margin-left:110px;' id='leadboxpopup'><img /></div><br />";
 echo "<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'>";
 echo "<td width='2%' align=left class='headertableblock'>UsersName</td><td width='30%' align=center class='headertableblock'>Totals</td>";
while($scores=mysql_fetch_array($scoreboard)){ 
if ($scores['avatar'] == ''){ $scores['avatar'] = $avatarloc.'/man.gif'; }
if ($scores['HOF_champ'] > 0) {
// avatar popup here "leadboxpopup"
echo"<tr><td class='arcade1'><div align='center'><A href='index.php?action=profile&amp;user=".$scores['name']."' onmouseover=\"s=document.getElementById('leadboxpopup');s.style.display='';s.getElementsByTagName('img')[0].src='" . $scores['avatar'] . "';\" onmousemove=\"s=document.getElementById('leadboxpopup').style;s.top=document.body.scrollTop+2+event.clientY;s.left=document.body.scrollLeft+event.clientX;\" onmouseout=\"document.getElementById('leadboxpopup').style.display='none'\"><b>".$scores['name']."</b></a></div></td><td class='arcade1'><div align='center'>".$scores['HOF_champ']." Games</div></td></td></tr>";
}}
echo "</table></div><br />";

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//		  Wall of Fame
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
echo "<div class='tableborder' ><table width='100%' cellpadding='5' cellspacing='1'><tr><td width='100%' align=center class='headertableblock' style='font-size:24px'>" . $settings['arcade_title'] ." Wall of Fame</td></tr></table>";
// the height property below may need to be adjusted as the years go by...
echo "<div style='height:450px; padding-bottom:20px;'>";

$Wyears = run_query("SELECT DISTINCT `Wyear` FROM `phpqa_wall` ORDER BY `Wyear` ASC");
while($WYsee = mysql_fetch_array($Wyears)) {
$ShowYear = $WYsee['Wyear'];
$Wscoreboard = run_query("SELECT * FROM `phpqa_wall` WHERE `Wyear` = $ShowYear ORDER BY `Wplace` ASC LIMIT 0,3");
$Wscores=mysql_fetch_array($Wscoreboard);
if ($Wscores['Wavatar'] == ''){ $Wscores['Wavatar'] = $avatarloc.'/man.gif'; }
$Wyear = $ShowYear;
$WLyear = $Wyear - 1;
$Wplace = $Wscores['Wplace'];
$Wgames = $Wscores['Wgames'];
$Wname = $Wscores['Wname'];
$Wavatar = $Wscores['Wavatar'];
echo "<div style='width:200px; height: 300px; float:left; margin-left:15px; margin-top:15px;'><table style='text-align:center;' width='100%' cellpadding='5' cellspacing='0'><tr><th colspan='2' class='headertableblock'>Season: ". $WLyear ." /  ". $Wyear ."</th></tr>";
echo "<tr><td colspan='2' class='arcade1'>1st Place <img src='$crowndir/crown1.gif' /> ". $Wgames ." Games</td></tr>";
echo "<tr><td colspan='2' class='arcade1'><a href=\"index.php?action=profile&amp;user=".$Wname."\"><img src='$Wavatar' height='150' alt='" . $Wname . "' /></a></td></tr>";
echo "<tr><td colspan='2' class='arcade1'><a href=\"index.php?action=profile&amp;user=".$Wname."\"><b>". $Wname ."</b></a><hr /></td></tr>";

while($Wscores=mysql_fetch_array($Wscoreboard)){
if ($Wscores['Wavatar'] == ''){ $Wscores['Wavatar'] = $avatarloc.'/man.gif'; }
$plaque = '';
$Wplace = $Wscores['Wplace'];
$Wgames = $Wscores['Wgames'];
$Wname = $Wscores['Wname'];
$Wavatar = $Wscores['Wavatar'];
if ($Wplace == 2) { $plaque = "2nd Place<br /><img src='$crowndir/crown2.gif' /><br />"; }  
if ($Wplace == 3) { $plaque = "3rd Place<br /><img src='$crowndir/crown3.gif' /><br />"; }  
echo "<td class='arcade1' width='50%'><table style='text-align:center;' width='100%' cellpadding='5' cellspacing='0'><tr><td>" . $plaque . $Wgames ." Games</td></tr>";
echo "<tr><td><a href=\"index.php?action=profile&amp;user=".$Wname."\"><img src='$Wavatar' alt='" . $Wname . "' height='70' /></a></td></tr>";
echo "<tr><td><a href=\"index.php?action=profile&amp;user=".$Wname."\"><b>". $Wname ."</b></a></td></tr></table></td>";
}
echo "</div></table></div>";
}
echo "</div>";
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//		End Leaderboards
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
?>
