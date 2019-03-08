<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 1.0 (ALPHA) based on PHP-Quick-Arcade 3.0 © Jcink.com
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
# Section: TournamentOption.php  Function: Tournaments/Challenges Engine   Modified: 3/8/2019   By: MaSoDo
if (!$phpqa_user_cookie) die();
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	       Arcade Tournaments/Challenges Engine
//              Coded By: http://seanj.jcink.com
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if(!$settings['enable_tournies']) {
message("The arcade admin has disabled the tournaments system. <br /><b>There is a problem with the tournament system. It will return as soon as I figure it out</b> - Admin.<br /><b>SORRY!</b>");
die();
}
error_reporting(~E_NOTICE);
if (isset($_GET['tid']) && is_numeric($_GET['tid'])) {
$ie=strstr($_SERVER['HTTP_USER_AGENT'],"MSIE");
$q=run_query("SELECT * FROM phpqa_tournaments WHERE tournament_id='".$_GET['tid']."' ORDER BY id ASC");
$q2=run_query("SELECT phpqa_games.game,phpqa_tournaments.game_id,phpqa_tournaments.misc_settings,null,null,null,null,null,null FROM phpqa_games,phpqa_tournaments WHERE phpqa_tournaments.game_id=phpqa_games.gameid AND tournament_id='".$_GET['tid']."'");
$udata=false;
while($f=mysql_fetch_assoc($q)) {$data[]=$f;if ($f['user']==$phpqa_user_cookie) $udata=$f['times_played'];}
$gameid=$data[0]['game_id'];
$gamedata=mysql_fetch_assoc($q2);
$doray = explode(",",$gamedata['misc_settings']);
$attempts=array_pop($doray);
$game=$gamedata['game'];
$numplayers=$data[0]['players'];
function img($n){global $pic, $themesloc;return "<img width='20px' height='20px' src='".$themesloc."/".(file_exists("skins/".$pic."/".$n."-bar.gif")? $pic:"Default")."/".$n."-bar.gif' border='0' />";}
//Calculating next #:
//prev#*2+1=next#
//ex:
//1*2+1=3
//3*2+1=7
//7*2+1=15, so next # is 15
$space=Array(0,1,3,7);
$table=Array();
$levels=log($numplayers,2)+1;
$real_players=0;
$tidval=0;
$attpop='';
for($x=0;$x<$levels;$x++) {
//$last=($x==$levels-1);
$last=(isset($x)&&$x==$levels-1);
$y=0;
$xx=0;
foreach($data as $v) {
$xx++;
if ($xx>=(pow(2,$x)-1)+pow(2,$x)&&$x) {
if (isset($v['level'])&&$v['level']<$x) $players[]="------";
$xx=1;
}
if (isset($v['level'])&&$v['level']>=$x) {
$score=explode(" ",$v['average_score']);
$players[]=Array($v['user'],$score[$x],$v['times_played'],$v['level']);
if (isset($x)&&$x==0) $real_players++;
$xx=0;
}
}
if (isset($last)&&!isset($players[0])) $over=false; else $over=true;
$t=$x?$numplayers/pow(2,$x):$numplayers;
for($y=0;$y<$t;$y++) if (!isset($players[$y])) $players[$y]="------";
foreach($players as $k=>$v) if (isset($v[0])&&$v[0]==$phpqa_user_cookie) $opponent=str_replace("-","",$players[($k+(($k+1)%2?1:-1))]);
for($y=0;$y<$space[$x];$y++) $table[$y].="<td></td>".($last?"":"<td></td>");
foreach($players as $k=>$v) {
$table[$y++].="<td class='challengename'>".($v!="------"?($last?"<img src='".$crowndir."/crown1.gif' /> ".$v[0]." <img src='skins/Default/crown1.gif' />":$v[0]." (".(isset($v[3])&&$v[3]>$x?$attempts:$v[2])."/".$attempts."): <b>".after_decimal($v[1],3)."</b>"):$v)."</td>".($last?"":"<td>".img($k%2?"ltu":"ltd")."</td>");
$playpop = array_keys($players);
if ($k!=array_pop($playpop)) for($z=0;$z<$space[$x+1];$z++) $table[$y++].="<td></td>".($last?"":"<td".($ie?" style='padding-left:1px'":"").">".($k%2?"":img(($z==floor($space[$x+1]/2)?"tri":"vert")))."</td>");
}
unset($players);
for($z=0;$z<$space[$x];$z++) $table[$y++].="<td></td>".($last?"":"<td></td>");
}
if (!isset($_GET['join'])) {
$q=mysql_fetch_array(run_query("SELECT `id` FROM `phpqa_tournaments` WHERE `user`='".$phpqa_user_cookie."' AND `tournament_id`='".$_GET['tid']."'"));
if ($q) message("You are already in this tournament."); else {
if ($numplayers<=$real_players) message("This Tournament is full"); else {
$tidval = $_GET['tid'];
run_query("INSERT INTO `phpqa_tournaments`(`tournament_id`,`user`) VALUES('".$tidval."','".$phpqa_user_cookie."')");
message("Joined tournament Successfully. <a href='index.php?action=tournaments&tid=".$_GET['tid']."'>Refresh</a>");
}
}
}
echo "<br />
<div align='center'><div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=60% align=center class='headertableblock'>".$game." Tournament: ".$numplayers." Players</td><tr><td class='arcade1' valign='top' align='center'>
<table style='border-collapse:collapse;' cellpadding='0'>";
foreach($table as $v) echo "\n<tr>".$v."</tr>";
echo "
</table>
".(is_numeric($udata)&&!$over?"<br />".(!$opponent?"You dont have an opponent to go against.":($udata<$attempts?"You havent used up all of your turns yet. <a href='index.php?play=".$gameid."&tournament=".$_GET['tid']."'>Play Now</a>":"You've used up all of your turns.")):($numplayers>$real_players?"<a href='index.php?action=tournaments&tid=".$_GET['tid']."&join=1'>Join</a> This Tournament":""))."
<br /><br />
</td>
</tr>
</table></div>";
} elseif (isset($_GET['submit'])&&is_numeric($_GET['submit'])&&isset($_GET['game'])) {
$q=mysql_fetch_array(run_query("SELECT * FROM phpqa_tournaments WHERE `user`='".$phpqa_user_cookie."' AND `tournament_id`='".$_COOKIE['phpqa_tourney']."'"));
$attpop = explode(",",mysql_result(run_query("SELECT `misc_settings` FROM `phpqa_tournaments` WHERE `tournament_id`='".$_COOKIE['phpqa_tourney']."'"),0));
$attempts=array_pop($attpop);
$left=($attempts-$q['times_played']);
$average=explode(" ",$q['average_score']);
if (isset($_GET['winner'])) {global $left, $average; $left=0; array_pop($average);}
echo "<div class='tableborder'><table width='100%'><tr><td class='arcade1' align='center'><br /><br /><br />Your score was: ".$_GET['submit']."<br />Your current ".(isset($_GET['st'])&&$_GET['st']==1?"highest":"average")." score is: ".array_pop($average)."<br />You have ".$left." Chance".(isset($left)&&$left==1?"":"s")." Left<br /><br />".(isset($left)&&!$_GET['winner']?"<a href='index.php?play=".$_GET['game']."&tournament=".$_COOKIE['phpqa_tourney']."'>Play Again?</a><br />":"")."<a href='index.php?action=tournaments&tid=".$_COOKIE['phpqa_tourney']."'>View Tournament Status</a><br /><br /><br /><br /></td></tr></table></div><br />";
} elseif (isset($_GET['create'])) {
$players=Array(2,4,8);
if (isset($_POST['submit'])) {
	vsess();
if (!in_array($_POST['players'],$players)) die("LoL Good thing I know JavaScript!");
// Patch - 04/20/2009
if (isset($_POST['gameid']))$_POST['gameid']=htmlspecialchars($_POST['gameid'], ENT_QUOTES);
if (!mysql_fetch_array(run_query("SELECT id FROM phpqa_games WHERE gameid='".$_POST['gameid']."'"))) die("Ha! Like I'd leave myself open to THAT one");
$max=mysql_result(run_query("SELECT MAX(tournament_id) FROM phpqa_tournaments"),0)+1;
foreach(Array('players','meth','attempts') as $v) if (!is_numeric($_POST[$v])) die();
$q=run_query("INSERT INTO phpqa_tournaments(tournament_id,user,players,game_id,misc_settings) VALUES(".$max.",'".$phpqa_user_cookie."','".$_POST['players']."','".$_POST['gameid']."','".$_POST['meth'].",".$_POST['attempts']."')");
if (!$q) echo "ERROR!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ".mysql_error(); else echo "<div class='tableborder'><table width='100%'><tr><td class='arcade1' align='center'><br /><br /><b>Tournament Created</b><br /><br />View it <a href='index.php?action=tournaments&tid=".$max."'>here</a><br /><br /><br /></td></tr></table></div>";
} else {
echo "<form method='post'><input type='hidden' name='akey' value='$key'><table class='tableborder'><tr><td class='arcade1'><center><h3>Create A Tournament</h3><br /><br /><table><tr><td>Game:</td><td><select name='gameid'>";
$q=run_query("SELECT game,gameid FROM phpqa_games ORDER BY game");
while($f=mysql_fetch_assoc($q)) echo "<option value='".$f['gameid']."'>".$f['game']."</option>";
echo "</select></td></tr><tr><td>Number of Players:</td><td><select name='players'>";
foreach($players as $v) echo "<option value='".$v."'>".$v."</option>";
echo "</select></td></tr><tr><td>Scoring Method:</td><td><select name='meth'><option value='0'>Average Score</option><option value='1'>Highest Score</option></select></td></tr><tr><td>Scoring Attempts:</td><td><select name='attempts'>";
for($x=1;$x<11;$x++) echo "<option value='".$x."'>".$x."</option>";
echo "</select></td></tr><tr><td colspan='2' align='center'><input type='submit' value='Create Tournament' name='submit' /></td></tr></table></td></table></form>";
}
} else {
$q=run_query("SELECT `tournament_id`,`game_id`,`winner`,`players`,`misc_settings` FROM `phpqa_tournaments` WHERE `players` IS NOT NULL GROUP BY `tournament_id` ORDER BY `tournament_id` DESC".(!isset($_GET['showall'])?" LIMIT 0,50":""));
$q2=run_query("SELECT `gameid`,`game` FROM `phpqa_games`");
$q3=run_query("SELECT `tournament_id`,count(`tournament_id`) FROM `phpqa_tournaments` GROUP BY `tournament_id`");
$q4=run_query("SELECT `tournament_id`,`times_played` FROM `phpqa_tournaments` WHERE `user`='".$phpqa_user_cookie."'");
while($f=mysql_fetch_array($q4)) $tournaments_in[$f[0]]=$f[1];
while($f=mysql_fetch_array($q3)) $num_players[$f[0]]=$f[1];
while($f=mysql_fetch_array($q2)) $gamename[$f[0]]=$f[1];
echo "<table class='tableborder'><tr>";
foreach(Array('Game','Players','Open Spots','Status','Erase') as $v) {
if($v == 'Erase') {
if($exist['group']=="Moderator" || $exist['group']=="Admin") {
echo "<td class='headertableblock'>".$v."</td>";
}
} else  {
echo "<td class='headertableblock'>".$v."</td>";
}
}
while($f=mysql_fetch_assoc($q)) {
$doray = explode(",",$f['misc_settings']);
$attempts=array_pop($doray);
echo "<tr><td class='arcade1'><a href='index.php?action=tournaments&tid=".$f['tournament_id']."'>".$gamename[$f['game_id']]."</a></td><td class='arcade1'>".$f['players']."</td><td class='arcade1'>".($f['players']-$num_players[$f['tournament_id']])."</td><td class='arcade1'>".($f['winner']?"Winner: ".$f['winner']:(isset($tournaments_in[$f['tournament_id']])?"Joined ".($tournaments_in[$f['tournament_id']]>=$attempts?"":"(<a href='index.php?play=".$f['game_id']."&tournament=".$f['tournament_id']."'>Play</a>)"):($f['players']==$num_players[$f['tournament_id']]?"Full":"Open (<a href='index.php?action=tournaments&tid=".$f['tournament_id']."&join=1'>Join</a>)")))."</td>";
if($exist['group']=="Moderator" || $exist['group']=="Admin") {
echo "<td class=\"arcade1\"><a href=\"?action=tournaments&tourndel=".$f['tournament_id']."&akey=".$key."\">Delete</a></td>";
}
echo "</tr>";
}
echo "</table><br />";
echo "<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1'><a href='index.php?action=tournaments&create=1'>Create</a> A Tournament</td></table></div><br />";
}
echo "<br />";
?>
