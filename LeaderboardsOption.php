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
# Section: Leaderboards.php  Function: Display of Leaderboards   Modified: 3/18/2019   By: MaSoDo

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//		  Leaderboards
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$scoreboard = run_query("SELECT phpqa_accounts.name,phpqa_accounts.avatar, COUNT(phpqa_leaderboard.username) AS champions FROM phpqa_accounts
LEFT JOIN phpqa_leaderboard ON phpqa_accounts.name = phpqa_leaderboard.username
GROUP BY phpqa_leaderboard.username
ORDER BY champions DESC LIMIT 1,50000");
$scoreboardc = mysql_fetch_array(run_query("SELECT phpqa_accounts.name,phpqa_accounts.avatar, COUNT(phpqa_leaderboard.username) AS champions FROM phpqa_accounts
LEFT JOIN phpqa_leaderboard ON phpqa_accounts.name = phpqa_leaderboard.username
GROUP BY phpqa_leaderboard.username
ORDER BY champions DESC LIMIT 0,3"));
if ($scoreboardc['avatar'] == ''){ $scoreboardc['avatar'] = $avatarloc.'/man.gif'; }
 echo "<br /><div><table width='33%' cellpadding='5' cellspacing='1'>";
 echo "<tr><td width='100%' align=center class='headertableblock' style='font-size:24px'><img alt='image' src='".$crowndir."/crown1.gif' /> Arcade Champion: <img image src='".$crowndir."/crown1.gif' /></td></tr>";
echo "<tr><td class='arcade1'><div style='font-size:16px; color: gold;' align='center'>with <I>".$scoreboardc['champions']."</I> wins</div><div align='center' style='font-size:24px'><i><A href=\"index.php?action=profile&amp;user=".$scoreboardc['name']."\"><img src='".$scoreboardc['avatar']."' /><br />".$scoreboardc['name']."</a></i></div></td></tr>";
echo "</table></div><div style='position:absolute;display:none;margin-top:-100px;margin-left:110px;' id='leadboxpopup'><img /></div><br />";
 echo "<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'>";
 echo "<td width='2%' align=left class='headertableblock'>UsersName</td><td width='30%' align=center class='headertableblock'>Totals</td>";
while($scores=mysql_fetch_array($scoreboard)){ 
if ($scores['avatar'] == ''){ $scores['avatar'] = $avatarloc.'/man.gif'; }
if ($scores['champions'] > 0) {
// avatar popup here "leadboxpopup"
echo"<tr><td class='arcade1'><div align='center'><A href='index.php?action=profile&amp;user=".$scores['name']."' onmouseover=\"s=document.getElementById('leadboxpopup');s.style.display='';s.getElementsByTagName('img')[0].src='" . $scores['avatar'] . "';\" onmousemove=\"s=document.getElementById('leadboxpopup').style;s.top=document.body.scrollTop+2+event.clientY;s.left=document.body.scrollLeft+event.clientX;\" onmouseout=\"document.getElementById('leadboxpopup').style.display='none'\"><b>".$scores['name']."</b></a></div></td><td class='arcade1'><div align='center'>".$scores['champions']." wins</div></td></td></tr>";
}}
echo "</table></div><br />";
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//		End Leaderboards
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
?>
