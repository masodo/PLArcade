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
# Section: RegisterOption.php  Function: Register for the Arcade   Modified: 7/23/2019   By: MaSoDo
if (isset($_POST['usernamesign']) && $_POST['usernamesign'] != "" && isset($_POST['postpassword']) && $_POST['postpassword'] !="") {
$name = htmlspecialchars($_POST['usernamesign'], ENT_QUOTES);
$pass = md5(sha1(htmlspecialchars($_POST['postpassword'])));
$email= htmlspecialchars($_POST['emailsign'], ENT_QUOTES);
// Banned usernames -.-
$banned_u=explode(",", $settings['banned_usernames']);
foreach($banned_u as $k=>$v) {
if(strtolower($v)==strtolower($name) || strtolower($v)==strtolower($email)) { message("Sorry, that username is banned."); 
die();
}
}
// Banned emails -.-
$banned_m=explode(",", $settings['banned_mails']);
foreach($banned_m as $k=>$v) {
if(strtolower($v)==strtolower($email)) { message("Sorry, that email is banned."); 
die();
}
}
$senttext = "";
$senttext = str_replace("'", "&amp;#39;", $senttext);
$query = run_query("SELECT * FROM phpqa_accounts WHERE name='$name' OR email='$email'");
$exist = @mysql_fetch_array($query);
if ($exist) { 	// M&Ms commcerial - He DOES exist! D'Ooh
if($name==$exist['name']) { message("Sorry, that username, <b>$name</b>  already exists. Please choose another."); }
if($email==$exist['email']) { message("Sorry, that email, <b>$email</b>  already exists on another account. Please choose another."); }


// Security code
} elseif(isset($settings['use_seccode']) && isset($_SESSION['captcha']) != isset($_POST['capcode'])) {
message("The security code entered was wrong. Please try again."); 
} elseif (isset($_POST['postpassword2']) != isset($_POST['postpassword'])) {
message("The entered passwords do not match, please try again.");
} elseif (isset($_POST['agreed']) && $_POST['agreed'] != "iagreed") {
message("You must agree to the Terms of use. Please check the box.");
} elseif(!is_email($email)) {
message("The email you entered was invalid.");
} else  {
$status='Member';
if(isset($settings['enable_validation'])&&$settings['enable_validation'] == '1') $status='Validating';
if(isset($_POST['dont'])) {
$s_settings='||||No||||||';
} else {
$s_settings='||||||||||';
}
if(isset($settings['enable_email_validation'])&&$settings['enable_email_validation'] == '1'){
echo "<script>alert('Registration Email Sent!')</script>";
$raw_password=rand(0,10).rand(0,10).rand(0,10).rand(0,10).rand(0,10).rand(0,10).rand(0,10).rand(0,10).rand(0,10);
$pass = md5(sha1($raw_password));
$hd="admin@{$_SERVER['HTTP_HOST']}";
$mailsub = "Message from " . $settings['arcade_title'] . "- Validate your email.";
$mailbody = "Dear " . $name .", \n\r\n\r\n\r Our records indicate that you have registered an account at {$settings['arcade_title']}. Your details are as follows: \n\r\n\r ----------------------------------------------- \n\r\n\r Username: " . $name . "\n\r\n\r Temporary Password: " . $raw_password . " \n\r\n\r -----------------------------------------------\n\r\n\r\n\r Login with your user name and the temporary password. Once logged-in you can click on &quot;settings&quot; to create a new password. \n\r\n\r\n\rIf you did not request this password change, please IGNORE and DELETE this
email immediately. \n\r\n\r\n\r IP address of user who signed up: {$_SERVER['REMOTE_ADDR']}";
$headers = "From: ".$hd."\nBcc: ".$siteemail."\n";
@mail($email,$mailsub,$mailbody,$headers);
}
$regtime = time();
run_query("INSERT INTO `phpqa_accounts` (`name`,`pass`,`email`,`ipaddress`,`avatar`,`group`,`skin`,`settings`) VALUES ('$name','$pass','$email','$ipa','','$status','$defCSS','$s_settings')", 1);
run_query("INSERT INTO `PLA_users` (`username`,`password`,`email`,`registration_ip`,`group_id`,`registered`) VALUES ('$name','$pass','$email','$ipa','3','$regtime')", 1);
if(isset($settings['enable_email_validation'])&&$settings['enable_email_validation'] != '1') { 
	message("Welcome to the arcade, <b>$name</b>!<br /><br /> Click the '<i>Login</i>' link above, enter your name and password and login to begin playing!");
} else {
	message("Welcome to the arcade, <b>$name</b>! Please check your <b>e-mail</b>.<br /> This arcade requires that you validate your email address. <br /><br />You have been given a new password via email which you must use to login.");
}
if($settings['enable_validation']) message("Note: The Administrator has enabled <b>validation</b> on this arcade. This means that each account must be approved by the administrator to post messages, use settings, or the shoutbox. As a validating user you will not be able to submit your score yet so please be patient, thank you.");
}
}
if(isset($settings['use_seccode'])&&$settings['use_seccode'] == '1') {
$spam=rand(0,999999);
$_SESSION['captcha']=$spam;
}
if(isset($settings['disable_reg']) && $settings['disable_reg'] != '1') {
?>
<form action='?action=register' method='POST'>
<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><td width='60%' align='center' class='headertableblock'>Register</td><td width='60%' align='center' class='headertableblock'></td><tr>
 <tr><td class="arcade1" align="left"><b>Enter a user name</b><br />Note: username cannot contain most special characters.</td><td class="arcade1" align="left"><input type='text' name='usernamesign' /></td></tr>
 <?php if(isset($settings['enable_email_validation']) && $settings['enable_email_validation'] != '1') { ?><tr><td class="arcade1" align="left"><b>Enter a password</b><br />Choose a secure password and dont make it your username or something easy to guess.</td><td class="arcade1" align="left"><input type="password" name="postpassword" value="" /></td></tr><tr><td class="arcade1" align="left"><b>Re-enter your password</b><br />Please re-enter your password exactly as it was above.</td><td class="arcade1" align="left"><input type="password" name="postpassword2" value="" /></td></tr><?php } ?>
  <?php if(isset($settings['enable_email_validation']) && $settings['enable_email_validation'] == '1') { ?><tr><td class="arcade1" align="left"><b>A temporary password will be emailed to you.</b><br />Login with your user name and the temporary password. Once logged-in you can click on &quot;settings&quot; to create a new password.</td><td class="arcade1" align="left"><input type="hidden" name="postpassword" value="t3mp0r4ry" /></td></tr><input type="hidden" name="postpassword2" value="t3mp0r4ry" /><?php } ?>
<tr><td class="arcade1" align="left"><b>Email</b><br />Please enter your email.</td><td class="arcade1" align="left"><input type="text" name="emailsign" value="" /></td></tr>
 <?php if(isset($settings['use_seccode'])) { ?>
 <tr><td class="arcade1" align="left"><b>Your security code</b><br />If you do not see any numbers, or see a broken image, please contact the arcade administrator to repair the problem.</td><td class="arcade1" align="left"><img src="?captcha=1"></td></tr>
 <tr><td class="arcade1" align="left"><b>Confirm your security code</b><br />Please enter the code shown above in image format.
Note: Only numbers are permitted. A "0" is a numerical zero, not the alphabetical "O".</td><td class="arcade1" align="left"><input type="text" name="capcode" value="" /></td></tr>
<?php } ?>
 </div></td></table></div>
<br />
<div align='center'>
<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><td width=60% align=center class='headertableblock'>Terms of use</td><tr>
<td class='arcade1' valign='top'><div align='center' style='text-align:justify;'>
Please read fully and check the 'I agree' box ONLY if you agree to the terms 
<br /><br />Please remember that we are not responsible for any messages posted. We do not vouch for or warrant the accuracy, completeness or usefulness of any message, and are not responsible for the contents of any message. The messages express the views of the author of the message, not necessarily the views of this arcade. Any user who feels that a posted message is objectionable is encouraged to contact us immediately by email. We have the ability to remove objectionable messages and we will make every effort to do so, within a reasonable time frame, if we determine that removal is necessary. You agree, through your use of this service, that you will not use this arcade to post any material which is knowingly false and/or defamatory, inaccurate, abusive, vulgar, hateful, harassing, obscene, profane, sexually oriented, threatening, invasive of a person's privacy, or otherwise violative of any law. You agree not to post any copyrighted material unless the copyright is owned by you or by this arcade. You also agree that you will not try to cheat the system to gain a highscore.<br /><br /><br />I agree to the Terms of use:<input type='checkbox' value='iagreed' name='agreed' /><br /><br />Disallow emails from this arcade? <input type='checkbox' name='dont'><br />If you do this, you won't recieve news and updates, and won't get emails when your highscores are taken.</div></div>
<tr><td class=headertableblock colspan='0'><div align='center'><input type='submit' name='post' value='Register Me!' /></div></td></tr>
</form>
 </td></table>
</div><br />
<?php
} else { message("Sorry, the admin has disabled new registrations for this arcade at this time. Please try again at a later date."); }
?>
