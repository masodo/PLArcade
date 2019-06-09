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
# Section: ProfileOption.php  Function: View User Profile Page   Modified: 6/9/2019   By: MaSoDo
if (isset($_COOKIE['phpqa_user_c'])) {
$profiledata=@mysql_fetch_array(run_query("SELECT * FROM phpqa_accounts WHERE name='".$user."'"));
$ggggg=explode("|",$profiledata['settings']);
if (!isset($profiledata)) {
message("Error: No username with the name, <b>$user</b> exists");
} else {
$lq=run_query("SELECT `gameid`,`game`,`about`,`Champion_score` FROM phpqa_games WHERE Champion_name='".$user."'");
$q=run_query("SELECT count(id) FROM phpqa_shoutbox WHERE name='".$user."'");
$LastOn = '';
if($profiledata['vtstamp']!=0){
$LastOn=date($datestamp,$profiledata['vtstamp']);
}
?>
<div align='center'>
<div class='tableborder'>
<table width='100%' cellpadding='4' cellspacing='1'>
<tr><td width=60% align=center class='headertableblock'>Profile Data</td><td width=60% align=center class='headertableblock'>Setting</td></tr>
<tr><td class='arcade1' align='left'><b>Name</b><br /></td><td class='arcade1' align='left'><?php echo $user; ?></td></tr>
<tr><td class='arcade1' align='left'><b>Last Login</b><br /></td><td class='arcade1' align='left'><?php echo $LastOn; ?></td></tr>
<tr><td class='arcade1' align='left'><b>Group</b></td><td class='arcade1' align='left'><?php echo $profiledata['group']; ?></td></tr>
<tr><td class='arcade1' align='left'><b>Skin</b><br /></td><td class='arcade1' align='left'>Default</td></tr>
<tr><td class='arcade1' align='left'><b>Total Shouts</b><br /></td><td class='arcade1' align='left'><?php echo mysql_result($q,0); ?></td></tr>
<tr><td class='arcade1' align='left'><b>Total Champions</b></td><td class='arcade1' align='left'><?php echo mysql_num_rows($lq); ?></td></tr>
<tr><td class='arcade1' align='left'><b>Contact</b></td><td class='arcade1' align='left'>[ <?php 
if($ggggg[0] != 'No') { // F-ZERO LOL
echo $profiledata['email'];
} else {
echo "Private";
}
?> ]</td></tr>
<?php if (isset($profiledata['avatar'])){ ?><tr><td class='arcade1' align='left'><b>Avatar</b><br /></td><td class='arcade1'><img src='<?php echo $profiledata['avatar'] ?>'></td></tr><?php } ?>
<?php if (!isset($profiledata['avatar'])){ ?><tr><td class='arcade1' align='left'><b>Avatar</b><br /></td><td class='arcade1'><img src='<?php echo $avitarloc; ?>/man.gif'></td></tr><?php } ?>
</table>
</div>
<br /> <br />
<?php
$scoreboardc = run_query("SELECT phpqa_accounts.name, COUNT(phpqa_leaderboard.username) AS champions FROM phpqa_accounts
LEFT JOIN phpqa_leaderboard ON phpqa_accounts.name = phpqa_leaderboard.username
GROUP BY phpqa_leaderboard.username
ORDER BY champions DESC LIMIT 0,10000");
$x=1;
while($checkpos=mysql_fetch_array($scoreboardc)){
IF(isset($_GET['user']) && $_GET['user'] == "$checkpos[name]") {
 echo "<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'>";
 echo "<td width='2%' align=center class='headertableblock'>UsersName</td><td width='30%' align=center class='headertableblock'>";
if($x == "3" || $x == "2" || $x == "1") echo "<img alt='image' src='$crowndir/crown{$x}.gif' />";
echo "$user is ".ordsuf($x)." in the Arcade.";
if($x == "3" || $x == "2" || $x == "1") echo "<img alt='image' src='$crowndir/crown{$x}.gif' />";
echo "</td>";
echo "<tr><td class='arcade1'><div align='center'><i><A href=\"index.php?action=profile&amp;user=".$checkpos['name']."\">".$checkpos['name']."</a></i></div></td><td class='arcade1'><div align='center'><I>".$checkpos['champions']."</I> wins</div></td></td></tr>";
echo "</table></div>";
} else {
$x++;
}
}
?>
<br /><br />
<div align='center'><div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><td width='100%' align='center' class='headertableblock' colspan='3'>Games that <?php echo $user; ?> is champion.</td><tr>
<?php
while($getstats=mysql_fetch_array($lq)){
?>
<tr>
<td class='arcade1' width=2%><img width='20' height='20' src='<?php echo $gamesloc; ?>/pics/<?php echo $getstats['gameid']; ?>.gif' /></td><td class='arcade1' align='left'><b><a href='index.php?play=<?php echo $getstats['gameid']; ?>'><?php echo $getstats['game']; ?></a></b> - <?php echo $getstats['about']; ?></b><br /></td><td class='arcade1' width='20%' align='center'>Score to beat: <br /><b><?php echo str_replace('-', '', $getstats['Champion_score']); ?></b></td>
<?php
}
?>
</tr></table></div><br /><br />
<?php
}} else {message("Sorry, guests may not view profiles!<br />Please <a href='index.php?action=register#registration'>Register</a> or <a href='index.php#Login'>Login</a>");}
?>
