<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 2.0 (BETA) based on PHP-Quick-Arcade 3.0 © Jcink.com
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
# Section: acpi Place: members - Control Panel   Modified: 8/12/2019   By: MaSoDo
//require('exportuserstoforum.php');
{
message("View Only: <br /><a href='?cpiarea=members&act=Admin'>Admins</a> &middot; <a href='?cpiarea=members&act=Moderator'>Moderators</a> &middot; <a href='?cpiarea=members&act=Affiliate'>Affiliate</a> &middot; <a href='?cpiarea=members&act=Member'>Members</a> &middot; <a href='?cpiarea=members&act=Banned'>Banned</a> &middot; <a href='?cpiarea=members&act=Validating'>Validating</a>");
if(isset($_POST['members_selected'])) {
vsess();
$gselect=$_POST['members_selected'];
for($x=0;$x<=count($gselect)-1;$x++){
$f=htmlspecialchars($gselect[$x], ENT_QUOTES);

run_iquery("DELETE FROM phpqa_scores WHERE username='".$f."'");
run_iquery("DELETE FROM phpqa_leaderboard WHERE username='".$f."'");
run_iquery("DELETE FROM phpqa_accounts WHERE name='".$f."'");
run_iquery("UPDATE phpqa_games SET Champion_score = '' WHERE Champion_name='".$f."'");
run_iquery("UPDATE phpqa_games SET Champion_name = '' WHERE Champion_name='".$f."'");
run_iquery("UPDATE phpqa_games SET HOF_score = '' WHERE HOF_name='".$f."'");
run_iquery("UPDATE phpqa_games SET HOF_name = '' WHERE HOF_name='".$f."'");
run_iquery("DELETE FROM phpqa_leaderboard WHERE username='".$f."'");

}
}
/* ################## Start of change name ################## */

if (isset($_GET['change'])) {
$n=htmlspecialchars($_GET['change'], ENT_QUOTES);
	vsess();
if(isset($_POST['new_name'])){
$new_name=htmlspecialchars($_POST['new_name'], ENT_QUOTES);
}

$checkexistance = mysqli_fetch_array(run_iquery("SELECT name FROM phpqa_accounts WHERE name = '".$new_name."'"));
if($checkexistance) { 
message("The name, &quot;".$new_name."&quot; is already being used by another person."); 
} else {
run_iquery("UPDATE phpqa_games SET Champion_name = '".$new_name."' WHERE Champion_name='".$n."'");
run_iquery("UPDATE phpqa_games SET HOF_name = '".$new_name."' WHERE HOF_name='".$n."'");
run_iquery("UPDATE phpqa_leaderboard SET username = '".$new_name."' WHERE username='".$n."'");
run_iquery("UPDATE phpqa_scores SET username = '".$new_name."' WHERE username='".$n."'");
run_iquery("UPDATE phpqa_accounts SET name = '".$new_name."' WHERE name='".$n."'");
}

}
if (isset($_GET['changename'])) {
	$_GET['changename']=htmlspecialchars($_GET['changename']);
echo "<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=30% align=center class=headertableblock>Change Name</td><tr><td class=arcade1><div align=center><form action='?cpiarea=members&change=".$_GET['changename']."' method='POST'><input type='hidden' name='akey' value='".$key."'><input type=text name=new_name value=\"".$_GET['changename']."\"><input type=submit value='Change Name'></form><br /><br />";
echo "</td></tr></table></div><br>";
}
/* ################## end of change name ################## */
/* ########### PASS CHANGE ################ */
$new_pass = '';
if (isset($_GET['changepass'])) {
		$_GET['changepass']=htmlspecialchars($_GET['changepass']);
echo "<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=30% align=center class=headertableblock>Change Password</td><tr><td class=arcade1><div align=center><form action='?cpiarea=members&changepwd=".$_GET['changepass']."' method='POST'><input type='hidden' name='akey' value='".$key."'><input type=text name='new_pass' value=''><br /><input type=submit value='Change Password'></form><br /><br />Enter a new password for ".$_GET['changepass']."";
echo "</td></tr></table></div><br>";
}
if(isset($_POST['new_pass'])) {
$new_pass=md5(sha1($_POST['new_pass']));
if(isset($_GET['changepwd'])) { 
$n=htmlspecialchars($_GET['changepwd'], ENT_QUOTES);
vsess();

run_iquery("UPDATE phpqa_accounts SET pass = '".$new_pass."' WHERE name='".$n."'", 1); 
run_iquery("UPDATE PLA_users SET password = '".$new_pass."' WHERE username='".$n."'", 1);
}}
if(isset($_GET['validate'])) { vsess();
	$n=htmlspecialchars($_GET['validate'], ENT_QUOTES);
	run_iquery("UPDATE phpqa_accounts SET `group` = 'Member' WHERE name='".$n."'");
}

if(isset($_GET['deleteav'])) { 
$a=htmlspecialchars($_GET['deleteav'], ENT_QUOTES);
	vsess();
	run_iquery("UPDATE phpqa_accounts SET avatar = '' WHERE name='".$a."'"); }
if(isset($_GET['changegroupgo'])) {
$cg=htmlspecialchars($_GET['changegroupgo'], ENT_QUOTES);
$fg=htmlspecialchars($_POST['chosengroup'], ENT_QUOTES);
	vsess();
	run_iquery("UPDATE phpqa_accounts SET `group` = '".$fg."' WHERE name='".$cg."'"); }
	
if (isset($_GET['changegroup'])) {
echo "<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=30% align=center class=headertableblock>Change Usergroup of: ".$_GET['changegroup']." </td><tr><td class=arcade1><div align=center><form action='?cpiarea=members&changegroupgo=".htmlspecialchars($_GET['changegroup'])."' method='POST'><input type='hidden' name='akey' value='".$key."'>";
?>
About: <a href='javascript:alert("As an admin, a user has FULL control of the arcade. Including the ability to add games, make new admins and moderators, and more. Only make admins you trust, proceed with caution.");'>Admin [?]</a> &middot; <a href='javascript:alert("As a moderator, basic access is given. A user has the ability to delete scores, lookup IP addresses, and IP ban users. They are also able to moderate the shoutbox.");'>Moderator [?]</a>  &middot; <a href='javascript:alert("An Affiliate has the ability to download the game files. ");'>Affiliate [?]</a>&middot; <a href='javascript:alert("A member is the basic group. They can only use the arcade related features such as playing games and using the shoutbox.");'>Member [?]</a> &middot; <a href='javascript:alert("Validating users are members awaiting manual validation. They are blocked from using any means of communication in the arcade, and submitting their highscores.");'>Validating [?]</a> &middot; <a href='javascript:alert("A banned member no longer has access to the arcade. ");'>Banned [?]</a>
<select name='chosengroup'>
<option value='Admin'>Admin</option>
<option value='Moderator'>Moderator</option>
<option value='Affiliate'>Afiliate</option>
<option value='Member'>Member</option>
<option value='Validating'>Validating</option>
<option value='Banned'>Banned</option>
</select>
<input type=submit value='Change UserGroup'></form></td></tr></table></div><br>
<?php
}
if(!isset($_GET['act'])) { 
$memberdata=run_iquery("SELECT * FROM phpqa_accounts"); 
} else {
$picked=htmlspecialchars($_GET['act'], ENT_QUOTES);
$memberdata=run_iquery("SELECT * FROM phpqa_accounts WHERE `group`='".$picked."'"); 
}
?>
<form action='' method='POST'>
<?php echo "<input type='hidden' name='akey' value='$key'>"; ?>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=30% align=center class=headertableblock>Name</td><td width=70% align=center class=headertableblock>Edit</td><td width=20% align=center class=headertableblock>Email</td><td width=20% align=center class=headertableblock>IP</td><td width=60% align=center class=headertableblock><input type='checkbox' onclick="s=document.getElementsByTagName('input');for(x=0;x<s.length;x++) if (s[x].type=='checkbox') s[x].checked=this.checked" /></td>
<?php
	while($g=mysqli_fetch_array($memberdata)){ 
?>
<tr><td class=arcade1 alighn='left'><?php echo $g[1]; ?> (<i><?php echo $g['group']; ?></i>)
</td><td class=arcade1><div align=center><A href='?cpiarea=members&changegroup=<?php echo $g[1]; ?>'>[ Edit Group ]</a> <A href='?cpiarea=members&deleteav=<?php echo $g[1]; ?>&akey=<?php echo $key; ?>'>[ Delete Avatar ]</a> <A href='?cpiarea=members&changepass=<?php echo $g[1]; ?>'>[ Change Pass ]</a><A href='?cpiarea=members&changename=<?php echo $g[1]; ?>'>[ Change Name ]</a> <?php if(isset($_GET['act'])&&$_GET['act']=="Validating") { echo "<A href='?cpiarea=members&validate=$g[1]&act=Validating&akey=$key'>[ Validate ]</a>"; } ?></div></td><td class=arcade1 align='left'><?php echo $g['email']; ?></td><td class=arcade1><?php echo $g['ipaddress']; ?></td><td class=arcade1><input type='checkbox' name='members_selected[]' value='<?php echo $g[1]; ?>'></td></tr>
<?php } ?>
<tr><td class='headertableblock' colspan='5'><div align=center><input type='Submit' name='deleteaccounts' value='Delete Account(s)'></div></td></tr>
</table></div><br>
</form>
<?php
}
?>
