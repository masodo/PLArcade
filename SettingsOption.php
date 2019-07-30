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
# Section: SettingsOption.php  Function: User Definable Configuration   Modified: 7/29/2019   By: MaSoDo
if (isset($_COOKIE['phpqa_user_c'])) {
if($exist[6] == "Validating") {
message("!ALERT!: Sorry, your account is still in validation. This means you cannot: submit your highscores, shout on the shoutbox, or edit your profile. Please wait for an admin to validate your account, then you'll be ready to play.");
die();
}
?>
<br />
<div align='center'>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=20% align=center class=headertableblock>Main Menu</td><td width=80% align=center class=headertableblock>Information</td><tr>
<td class=arcade1 align="left" valign="top">
<div class=headertableblock>Your Profile</div>
<br />
-- <a href="index.php?action=settings&p=newemail">Edit Email</a><br />
-- <a href="index.php?action=settings&p=avatar">Edit Avatar</a><br />
<br />
<div class=headertableblock>Arcade Settings</div>
<br />
<?php 
if(!$settings['override_userprefs']) {
?>
-- <a href='index.php?action=settings&p=display'>Preferences</a><br />
<?php
}
?>
-- <a href='index.php?action=settings&p=skin'>Skin Chooser</a><br />
-- <a href='index.php?action=settings&p=pass'>Change Password</a><br />
</td>
<td class=arcade1 valign="top" align="left">
<?php
if ($_GET['action']=="settings" && isset($_GET['p'])=="") {
echo "<div align='center'>Welcome to your arcade controls. Your last 10 scores:<hr>";
	$selectfrom = run_iquery("SELECT * FROM phpqa_scores WHERE username='$phpqa_user_cookie' ORDER BY phpdate DESC LIMIT 0,10");
while($s=mysqli_fetch_array($selectfrom)){ 
$parse_stamp = date($datestamp, $s[5]);
echo "<i>$s[2]</i> in <a href='index.php?id=$s[6]'><i>$s[7]</i></a> on $parse_stamp <br />";
}
echo "</div>";
}
if (isset($_GET['p']) && $_GET['p'] == "avatar") {
$remoteavatar = '';
unset($problem);
if(isset($_POST['remoteavatar']))$remoteavatar=htmlspecialchars($_POST['remoteavatar'], ENT_QUOTES);
$message=$remoteavatar;
$message=str_replace("#", "&#35;", $message);
$message=str_replace("&&#35;62;", "&#62;", $message); 
$message=str_replace("&&#35;60;", "&#60;", $message); 
$message  = htmlspecialchars($message, ENT_QUOTES);
$message=str_replace("javascript", "java&nbsp;script", $message);
if (strtolower(substr($remoteavatar,0,11))=="javascript:") { $problem.="Invalid characters in avatar URL"; }
if (isset($_POST['remoteavatar']) || isset($_FILES['remoteavatar']['name'])) {
vsess();
// ---------------------
// Upload an avatar
// ---------------------
if(isset($settings['upload_av_max_size'])) {
if(isset($_FILES['remoteavatar']['name'])) { 
global $exist;
$message="./useravatars/".$exist['name'].".img";
$imgcontents=@file_get_contents($_FILES['remoteavatar']['tmp_name']);
if(!isset($imgcontents)) $problem.="Failed to read file.<br />";
if(!@getimagesize($_FILES['remoteavatar']['tmp_name'])) $problem.="Invalid image file, or your webhost is not setup correctly to read images.<br />";
if(preg_match("/tEXtComment/i", $imgcontents)) $problem.="Image files with tEXTcomment not allowed.<br />";
if($_FILES['remoteavatar']['size'] > $settings['upload_av_max_size']) $problem.="The avatar is too large in file size to be uploaded.";
if(!isset($problem)) $uploadavatar = @move_uploaded_file($_FILES['remoteavatar']['tmp_name'], $message);
if(!isset($uploadavatar)) $problem.="Failed to upload your avatar to the server. Please contact the arcade administrator.";
}
}
if(!isset($problem)) { 
	run_iquery("UPDATE phpqa_accounts SET avatar = '".$message."' WHERE name='".$phpqa_user_cookie."'"); 
	echo "Avatar Updated."; 
} else { 
	echo $problem; 
}
} else {
echo "<div align=center>Current Avatar:<br />";
if($exist['avatar'] !="" ) { echo "<img src='".$exist['avatar']."'><br /><br />"; } else { echo "None<br /><br />"; }
// Remote avatar
echo "<form action='index.php?action=settings&p=avatar' method='POST'>";
echo "<input type='hidden' name='akey' value='".$key."'>";
echo "Enter URL To Remote Avatar:<br />";
echo "<input type='text' name='remoteavatar' value='".$exist['avatar']."'>";
echo "<input type='submit' name='submit' value='Submit'></form>";
if(isset($settings['upload_av_max_size'])) {
//Upload avatar
echo "<form action='index.php?action=settings&p=avatar' method='POST' enctype='multipart/form-data'>";
echo "<input type='hidden' name='akey' value='".$key."'>";
echo "Upload an avatar from your computer:<br />";
echo "<input type='file' name='remoteavatar'>";
echo "<input type='submit' name='submit' value='Submit'></form>";
echo "<br /><form action='index.php?action=settings&p=avatar' method='POST'><input type='hidden' name='akey' value='".$key."'><input type=hidden name='remoteavatar' value='blank.gif'><input type=submit value='Remove Avatar'></form>";
}
echo "<hr>";
echo "<form action='index.php?action=settings&p=avatar' method='POST'>Gallery Choices:<br /><br />";
echo "<input type='hidden' name='akey' value='".$key."'>";
echo '<select size="1" name="gallery">';
$dir = "./avatars/";
if (is_dir($dir)) {
   if ($dh = opendir($dir)) {
       while (($file = readdir($dh)) !== false) {
		   if ($file != ".." && $file != "." && $file != "man.gif") {
           echo "<option value='$file'>$file</option>";
		   }
       }
       closedir($dh);
   }
}
echo "</select><input type='submit' name='submit' value='Go'></form>";
if (isset($_POST['gallery'])) {
$gallery=$_POST['gallery'];
$gallery=str_replace("..", "", $gallery);
$dir = "./avatars/$gallery";
if (is_dir($dir)) {
	echo "<form action='index.php?action=settings&p=avatar' method='POST'>";
	echo "<input type='hidden' name='akey' value='$key'>";
   if ($dh = opendir($dir)) {
$x=2;
       while (($file = readdir($dh)) !== false) {
		   if ($file != ".." && $file != ".") {
           echo " [<input type='radio' name='remoteavatar' value='".$avatarloc."/".$gallery."/".$file."'>]<a href=\"javascript:document.getElementsByName('remoteavatar')[".$x."].checked='checked';void(0);\"><img src='".$avatarloc."/".$gallery."/".$file."'></a> ";
                   $x++;
		   }
       }
closedir($dh);
echo "<br /><br /><input type=submit name='submit' value='Select'></form>";
   }}}}

} elseif(isset($_GET['p']) && $_GET['p'] == "pass") {
if (isset($_POST['newpass'])) {
if ($_POST['newpass'] != "") {
$UpDated = md5(sha1($_POST['newpass']));
vsess();
run_iquery("UPDATE phpqa_accounts SET pass = '$UpDated' WHERE name='$phpqa_user_cookie'", 1);
run_iquery("UPDATE PLA_users SET password = '$UpDated' WHERE username='$phpqa_user_cookie'", 1);
echo "Password updated. You must now login again.";
} else {
echo "You didn't enter a new password. Please go back and fill out the input box.";
}
} else {
echo '<form action="index.php?action=settings&p=pass" method="POST">';
echo "<input type='hidden' name='akey' value='$key'>";
echo 'New Password: <input type="text" name="newpass">';
echo '<br /><input type="submit" value="Change Password"></form>';
}
} elseif(isset($_GET['p']) && $_GET['p'] == "newemail") {
if (isset($_POST['newemail'])) {
if ($_POST['newemail'] != "") {
if(is_email($_POST['newemail'])) {
$UpDated = htmlspecialchars($_POST['newemail'], ENT_QUOTES);
vsess();
run_iquery("UPDATE phpqa_accounts SET email = '$UpDated' WHERE name='$phpqa_user_cookie'");
echo "Email updated.";
} else {
echo "Invalid email address.";
}
} else {
echo "You didn't enter a new email. Please go back and fill out the input box.";
}
} else {
echo '<form action="index.php?action=settings&p=newemail" method="POST">';
echo "<input type='hidden' name='akey' value='$key'>";
echo "Your current email on file is: <b>$exist[3]</b>.<br /><br />New Email: <input type=\"text\" name=\"newemail\">";
echo '<br /><input type="submit" value="Change Email"></form>';
}
} elseif(isset($_GET['p']) && $_GET['p'] == "display") {
global $timezone;
if (isset($_POST['viewavatars'])) {
if (isset($_POST['viewavatars']))$viewavatars = htmlspecialchars($_POST['viewavatars'], ENT_QUOTES);
if (isset($_POST['viewshoutbox']))$viewshoutbox = htmlspecialchars($_POST['viewshoutbox'], ENT_QUOTES); // ENT QUOTES EDDY ENT QUOTES AHUHUHUHUH
if (isset($_POST['numberofgamesperpage']))$numberofgamesperpage = htmlspecialchars($_POST['numberofgamesperpage'], ENT_QUOTES);
if (isset($_POST['viewtop']))$viewtop = htmlspecialchars($_POST['viewtop'], ENT_QUOTES);
if (isset($_POST['allowmemoradmin']))$allowmemoradmin = htmlspecialchars($_POST['allowmemoradmin'], ENT_QUOTES);
if (isset($_POST['timezone']))$timezone = htmlspecialchars($_POST['timezone'], ENT_QUOTES);
if (isset($_POST['showinfo']))$showinfo = htmlspecialchars($_POST['showinfo'], ENT_QUOTES);
if (isset($_POST['showshout']))$showshout = htmlspecialchars($_POST['showshout'], ENT_QUOTES);
if (isset($_POST['showcats']))$showcats = htmlspecialchars($_POST['showcats'], ENT_QUOTES);
if (isset($_POST['showindex']))$showindex = htmlspecialchars($_POST['showindex'], ENT_QUOTES);
if (isset($_POST['idxview']))$idxview = htmlspecialchars($_POST['idxview'], ENT_QUOTES);
if (isset($_POST['sortord']))$sortord = htmlspecialchars($_POST['sortord'], ENT_QUOTES);
vsess();
run_iquery("UPDATE phpqa_accounts SET settings = '$viewavatars|$viewshoutbox|$numberofgamesperpage|$viewtop|$allowmemoradmin|$acct_setting[5]|$showinfo|$showshout|$showcats|$showindex|$idxview|$sortord' WHERE name='$phpqa_user_cookie'");
echo "Settings updated! <a href='index.php?action=settings&amp;p=display'>Reload</a> to see changes...";
} else {
echo '<form action="index.php?action=settings&p=display" method="POST">';
echo "<input type='hidden' name='akey' value='$key'>";
//
// Show email?
//
echo "Show My email publicly in my profile?";
echo '<select size="1" name="viewavatars">';
if ($acct_setting[0] == "Yes") {
echo "<option value='Yes' selected>Yes</option>";
echo "<option value='No'>No</option>";
} else {
echo "<option value='No' selected>No</option>";
echo "<option value='Yes'>Yes</option>";
}
echo "</select><br />";
// 
// View Shoutbox
//
echo "View the Shoutbox?";
echo '<select size="1" name="viewshoutbox">';
if ($acct_setting[1] == "Yes") {
echo "<option value='Yes' selected>Yes</option>";
echo "<option value='No'>No</option>";
} else { 
echo "<option value='No' selected>No</option>";
echo "<option value='Yes'>Yes</option>";
}
echo "</select><br />";
// 
// Number of games per page?
//
echo "Games & Shouts per page?<br />";
echo "<input type='text' name='numberofgamesperpage' value='$acct_setting[2]' onblur='if (this.value!=parseFloat(this.value)) alert(\"Games per page must be a number.\")'><br />";
// 
// View Top Area
//
echo "View the Arcade header?";
echo '<select size="1" name="viewtop">';
if ($acct_setting[3] == "Yes") {
echo "<option value='Yes' selected>Yes</option>";
echo "<option value='No'>No</option>";
} else { 
echo "<option value='No' selected>No</option>";
echo "<option value='Yes'>Yes</option>";
}
echo "</select><br />";
echo "Allow other members/the admin to contact you by Email?";
echo '<select size="1" name="allowmemoradmin">';
if ($acct_setting[4] == "Yes") {
echo "<option value='Yes' selected>Yes</option>";
echo "<option value='No'>No</option>";
} else { 
echo "<option value='No' selected>No</option>";
echo "<option value='Yes'>Yes</option>";
}
echo "</select><br />";
//
// Default Collapse Behavior MSD
//
echo "<br /><hr />";
echo "Default: Collapse or Expand <b>Arcade Info</b>?";
echo '<select size="1" name="showinfo">';
if ($acct_setting[6] == "divHidden") {
echo "<option value='divHidden' selected>Collapse</option>";
echo "<option value='divVisible'>Expand</option>";
} else { 
echo "<option value='divVisible' selected>Expand</option>";
echo "<option value='divHidden'>Collapse</option>";
}
echo "</select><br />";
echo "Default: Collapse or Expand <b>Shoutbox</b>?";
echo '<select size="1" name="showshout">';
if ($acct_setting[7] == "divHidden") {
echo "<option value='divHidden' selected>Collapse</option>";
echo "<option value='divVisible'>Expand</option>";
} else { 
echo "<option value='divVisible' selected>Expand</option>";
echo "<option value='divHidden'>Collapse</option>";
}
echo "</select><br />";
echo "Default: Collapse or Expand <b>Categories</b>?";
echo '<select size="1" name="showcats">';
if ($acct_setting[8] == "divHidden") {
echo "<option value='divHidden' selected>Collapse</option>";
echo "<option value='divVisible'>Expand</option>";
} else { 
echo "<option value='divVisible' selected>Expand</option>";
echo "<option value='divHidden'>Collapse</option>";
}
echo "</select><br />";
echo "Default: Collapse or Expand <b>Games Index</b>?";
echo '<select size="1" name="showindex">';
if ($acct_setting[9] == "divHidden") {
echo "<option value='divHidden' selected>Collapse</option>";
echo "<option value='divVisible'>Expand</option>";
} else { 
echo "<option value='divVisible' selected>Expand</option>";
echo "<option value='divHidden'>Collapse</option>";
}
echo "</select><br /><hr />";
//
// Index View Option
//
echo "Selected <b>Layout</b>?";
echo '<select size="1" name="idxview">';
if ($acct_setting[10] == "CV") {
echo "<option value='GV'>Grid View</option>";
echo "<option value='CV' selected>Classic View</option>";
} else { 
echo "<option value='GV' selected>Grid View</option>";
echo "<option value='CV'>Classic View</option>";
}
echo "</select><br />";
//
// Index Sort Option
//
echo "Selected Games <b>Sort Order</b>?";
echo '<select size="1" name="sortord">';
if ($acct_setting[11] == "alph") {
echo "<option value='alph' selected>Name (A~Z)</option>";
echo "<option value='sid'>Date (New~Old)</option>";
} else { 
echo "<option value='alph'>Name (A~Z)</option>";
echo "<option value='sid' selected>Date</option>";
}
echo "</select><br /><hr />";
?>
<br />
<br />
<input type='submit' name='' value='Update settings'>
<?php
echo '</form>';
}
} elseif (isset($_GET['p']) && $_GET['p'] == "skin") {
if (isset($_POST['skinsettings'])) {
$updateskin=htmlspecialchars($_POST['updateskin'], ENT_QUOTES);
vsess();
run_iquery("UPDATE phpqa_accounts SET skin = '$updateskin' WHERE name='$phpqa_user_cookie'");
echo "Skin Updated";
} else {
echo '<form action="index.php?action=settings&p=skin" method="POST">';
echo "<input type='hidden' name='akey' value='$key'>";
echo '<select size="1" name="updateskin" onchange="document.getElementsByTagName(\'link\')[0].href=\'skins/\'+this.value+\'.css\'">';
echo "<option value='$exist[7]'>Select Skin... ($exist[7])</option>";
  $handle = opendir("skins");
  while (false!==($topic=readdir($handle)))
   {
     if( $topic == '.' || $topic == '..' )
       continue;
       $forumtopiclist [basename($topic,".css")] = @filemtime($s."/".$topic);
     }
  arsort($forumtopiclist);
  foreach($forumtopiclist as $v=>$k) echo "<option value='$v'>$v</option>";
echo '</select><br /><br /><br />';
echo "<input type=submit value='Update Skin' name='skinsettings'></form>"; 
}
}
?>
</td></tr>
</table>
</div>
<br />
<?php
} else {
echo "<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td width='80%' align='center' class='headertableblock'>Error</td></tr><tr><td width='80%' align='center' class='arcade1'>You cannot edit your profile while logged out. Please login.</td></tr></table></div>";
}
?>
