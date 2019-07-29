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
# Section: acpi Place: Email - Administrator Control Panel   Modified: 7/29/2019   By: MaSoDo

{ 

$q=run_iquery("SELECT email,settings FROM phpqa_accounts");
while($mailing=mysqli_fetch_array($q)) {

$settings=explode("|", $mailing[1]);
if(isset($settings[4]) &&  $settings[4] != "No") {
global $list;
$list.= "$mailing[0], ";
}
}
?>
<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1'>
<form action="?cpiarea=Email" method="post">
<h1>Email List</h1><br />
List of users on your mailing list: <br />
<?php
if (isset($_POST['mailheaders']))$hd = $_POST['mailheaders'];
if (isset($_POST['subject'])) {
	vsess();
$seeto = $BCCcatchall;
$members = $_POST['members'];
$mailsub = $_POST['subject'];
$mailbody = $_POST['email_body'];
$headers = "From: $hd\nBcc: $members\n";
$g=@mail($seeto,$mailsub,$mailbody,$headers);
if(!$g) echo "<br /> Error: The mail(); command has been disabled by your hosting provider for security reasons. The emails <font color=red>could not be sent</font>. Talk to your hosting provider, or follow the directions on sending the email right from your email client.";
}
?>
<textarea rows="5" cols="60" name="members">
<?php echo $list; ?>
</textarea><br />
<input type='hidden' name='akey' value='<?php echo $key; ?>'>
The above users will be sent an email announcement. If your host does not allow people to send mail with <br /> the form below, you can <b>cut</b> and <b>paste</b> the above box into your email addresses (like AOL.com or Yahoo etc) "Send to" address box.<br /><br /><br />
Members addresses will be hidden. <br /> Email will show as sent to:<b> <?php echo($BCCcatchall); ?> </b>**<br />
 Type the <b>email you want users to be able to reply to (or not)</b>  (ex use noreply@thearcade.tld) :<br />
 <input type=text name=mailheaders value='<?php echo $siteemail; ?>'> ** (These defaults are set in AdminCP &quot;Settings&quot;)<br />
<br />
Type the <b>subject</b> of the email: <br />
<input type=text name='subject'><br />
Type your <b>message</b> here: <br /><br />
<textarea rows="20" cols="80" name="email_body">
</textarea> <BR />
<input type=submit value=Submit name=post>
</form>
</td></tr></table></div><br />
<?php } 
?>
