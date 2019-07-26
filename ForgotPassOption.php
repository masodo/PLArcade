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
# Section: ForgotPassOption.php  Function: Password Recovery   Modified: 7/26/2019   By: MaSoDo

if($settings['enable_passrecovery']) {
if (isset($_POST['sendto_user'])) {
if (isset($_POST['sendto_email'])&&$_POST['sendto_email'] == "") { 
message("You forgot to type in an email.");
die();
}
if ($_POST['sendto_user'] == "") { 
message("You left the username line blank.");
die();
}
$u=htmlspecialchars($_POST['sendto_user']);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Incompatible Function Block #1
$getmailuser = @mysql_fetch_array(run_query("SELECT name,pass,email FROM phpqa_accounts WHERE name='$u'", 1));
if (!$getmailuser) { 
message("The user, $u is not registered here."); 
die();
}
if (strtolower($_POST['sendto_email']) != strtolower($getmailuser['email'])) {
message("The email on file for $u, does not match the email you inputted. Please try again.");
die();
//END Incompatible Function Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

} else {
// Send the email now...
$SiteDomain = "http://".htmlspecialchars($_SERVER['HTTP_HOST']).htmlspecialchars($_SERVER['PHP_SELF'])."?action=login&userID=$getmailuser[0]&pword=$getmailuser[1]&recovery=1";
$hd="admin@{$_SERVER['HTTP_HOST']}";
$members = $getmailuser['email'];
$mailsub = "Password Recovery From ".$settings['arcade_title']."";
$mailbody = "Dear ".$u.", \n\r\n\r\n\r A password recovery attempt has been made on your account at the ".$settings['arcade_title'].". If you did not request password recovery please disregard this email. The IP address of the internet user who did this was ".$_SERVER['REMOTE_ADDR'].". \n\r\n\r\n\r Visit the link below to access your account again: \n\r\r\n ----------------------------------------------- \n\r\n\r ".$SiteDomain." \n\r\n\r-----------------------------------------------\n\r\n\r IMPORTANT: When you login, visit change password in your profile settings to create a new password. \n\r\n\r\n\rThank you for your participation!\n\r".$settings['arcade_title']."";
$headers = "From: $hd\n\r";
$mailfail=@mail($members,$mailsub,$mailbody,$headers);
if($mailfail) { message("Password recovery email sent. You should recieve it in the next 5 minutes to an hour depending on the speed of the mail server."); } else { message("Failed to send the email."); }
}
}
?>
<div align='center'>
<div class='tableborder'><table width=100%% cellpadding='4' cellspacing='1'><td width=60%% align=center class=headertableblock>Send Password</td><tr>
<td class=arcade1 valign="top"><div align=center><form action='' method=post enctype="multipart/form-data" name="postbox">
<br />Your Arcade Username: <br /><input type=text name=sendto_user value=''><br /><br />
<br />Your Email: <br /><input type=text name=sendto_email><br /><br />
<br /><br /><input type=submit value='Request Password'></div>
 </td>
</table>
</div>
<br /><br />
<?php
} else {
message("Sorry, password recovery is not enabled on this arcade.");
}
?>
