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
# Section: settings.php  Function: Set Global Arcade Variables   Modified: 3/28/2019   By: MaSoDo

{ ?>
<br />
<form action='?cpiarea=settings' method=POST>
<form action='' method='POST'>
<?php echo "<input type='hidden' name='akey' value='$key'>"; ?>
<div align='center'>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=60% align=center class=headertableblock>Settings</td><td width=60% align=center class=headertableblock>Current setting</td><tr>
<?php
$in='';
$collectstuff="<?php\n//-----------------------------------------------------------------------------------/        \n//Practical-Lightning-Arcade [PLA] 1.0 (BETA based on PHP-Quick-Arcade 3.0 © Jcink.com\n//JS By: SeanJ. - Heavily Modified by PracticalLightning Web Design\n//Michael S. DeBurger [DeBurger Photo Image & Design]\n//-----------------------------------------------------------------------------------/\n//  phpQuickArcade v3.0.x © Jcink 2005-2010 quickarcade.jcink.com                        \n//\n//  Version: 3.0.23 Final. Released: Sunday, May 02, 2010\n//-----------------------------------------------------------------------------------/\n// Thanks to (Sean) http://seanj.jcink.com \n// for: JS and more\n// ---------------------------------------------------------------------------------/\n# These Settings Last Generated: ".date("F j, Y, g:i a")."\n\n\$maintenance = '0';\n\$notinstalled = '0';\n";
// Questions with a Yes/No answer.
$settingsarray=Array(
'Enable Online List?'=>'enable_onlinelist',
'Enable Password Recovery?'=>'enable_passrecovery',
'Enable Shoutbox?'=>'enable_shoutbox',
'Use logo at the top of every page? (Logo takes the name of the skin and looks for the image in the arcade images folder if enabled)'=>'enable_logo',
'Enable Countdown Timer?'=>'enable_timer',
'Allow users to post comments?'=>'allow_comments',
'Display the arcade stats above the shoutbox/Login bar?'=>'show_stats_table',
'Disable New Registrations?'=>'disable_reg',
'Enable Admin Validation of New Members?'=>'enable_validation',
//'Use Cheat Protection? <br /> Note:(Can cause problems for users with firewalls)'=>'use_cheat_protect',
'Override user prefs with admin prefs?'=>'override_userprefs',
'Allow Guests to play? (This means that if someone does not have an account, they can still play, but they cannot submit their score.)'=>'allow_guests',
'Require security code to prevent spambots? (Needs GD library image functions to work. If you see a red x in a box  on the signup after you enable this, your host doesn\'t have GD library, and it won\'t work.)'=>'use_seccode',
'Enable sending email to users if they are top, and the score has been defeated?'=>'email_scores',
'Enable email validation? This ensures the email that a user enters when they sign up is real.'=>'enable_email_validation',
);
foreach($settingsarray as $k=>$v){
if(isset($_POST[$v])) {
$in=htmlspecialchars($_POST[$v], ENT_QUOTES);
}
$collectstuff.='$settings[\''.$v.'\']=\''.$in.'\';'."\n";
echo "<tr><td class='arcade1'><b>$k</b></td><td class='arcade1'>";
echo "<select size='1' name='$v'>";
if (!$settings[$v]) {
echo "<option value='0' selected>No</option>";
echo "<option value='1'>Yes</option>";
} else {
echo "<option value='1' selected>Yes</option>";
echo "<option value='0'>No</option>";
}
echo "<br></td></tr>";
}
// Questions with an input box that need to be typed in
$settingsarray2=Array(
'Arcade name?'=>'arcade_title',
'GMDate() format?'=>'datestamp',
"Time zone: <select class='forminput'><option value='-12' Onclick=\"javascript:document.getElementById('timezone').value='-12';void(0);\">(GMT - 12:00 hours) Enitwetok, Kwajalien</option><option Onclick=\"javascript:document.getElementById('timezone').value='-11';void(0);\">(GMT - 11:00 hours) Midway Island, Samoa</option><option value='-10' Onclick=\"javascript:document.getElementById('timezone').value='-10';void(0);\">(GMT - 10:00 hours) Hawaii</option><option value='-9' Onclick=\"javascript:document.getElementById('timezone').value='-9';void(0);\">(GMT - 9:00 hours) Alaska</option><option value='-8' Onclick=\"javascript:document.getElementById('timezone').value='-8';void(0);\">(GMT - 8:00 hours) Pacific Time (US &amp; Canada)</option><option value='-7' Onclick=\"javascript:document.getElementById('timezone').value='-7';void(0);\">(GMT - 7:00 hours) Mountain Time (US &amp; Canada)</option><option value='-6' Onclick=\"javascript:document.getElementById('timezone').value='-6';void(0);\">(GMT - 6:00 hours) Central Time (US &amp; Canada), Mexico City</option><option value='-5' Onclick=\"javascript:document.getElementById('timezone').value='-5';void(0);\">(GMT - 5:00 hours) Eastern Time (US &amp; Canada), Bogota, Lima, Quito</option><option value='-4' Onclick=\"javascript:document.getElementById('timezone').value='-3';void(0);\">(GMT - 4:00 hours) Atlantic Time (Canada), Caracas, La Paz</option><option value='-3.5'>(GMT - 3:30 hours) Newfoundland</option><option value='-3' Onclick=\"javascript:document.getElementById('timezone').value='-3';void(0);\">(GMT - 3:00 hours) Brazil, Buenos Aires, Georgetown, Falkland Is.</option><option value='-2' Onclick=\"javascript:document.getElementById('timezone').value='-2';void(0);\">(GMT - 2:00 hours) Mid-Atlantic, Ascention Is., St Helena</option><option value='-1' Onclick=\"javascript:document.getElementById('timezone').value='-1';void(0);\">(GMT - 1:00 hours) Azores, Cape Verde Islands</option><option value='0'>(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</option><option value='1' Onclick=\"javascript:document.getElementById('timezone').value='1';void(0);\">(GMT + 1:00 hours) Berlin, Brussels, Copenhagen, Madrid, Paris, Rome</option><option value='2' Onclick=\"javascript:document.getElementById('timezone').value='2';void(0);\">(GMT + 2:00 hours) Kaliningrad, South Africa, Warsaw</option><option value='3' Onclick=\"javascript:document.getElementById('timezone').value='3';void(0);\">(GMT + 3:00 hours) Baghdad, Riyadh, Moscow, Nairobi</option><option value='3.5'>(GMT + 3:30 hours) Tehran</option><option value='4'>(GMT + 4:00 hours) Abu Dhabi, Baku, Muscat, Tbilisi</option><option value='4.5' Onclick=\"javascript:document.getElementById('timezone').value='4.5';void(0);\">(GMT + 4:30 hours) Kabul</option><option value='5' Onclick=\"javascript:document.getElementById('timezone').value='5';void(0);\">(GMT + 5:00 hours) Ekaterinburg, Islamabad, Karachi, Tashkent</option><option value='5.5' Onclick=\"javascript:document.getElementById('timezone').value='5.5';void(0);\">(GMT + 5:30 hours) Bombay, Calcutta, Madras, New Delhi</option><option value='6' Onclick=\"javascript:document.getElementById('timezone').value='6';void(0);\">(GMT + 6:00 hours) Almaty, Colomba, Dhakra</option><option value='7'>(GMT + 7:00 hours) Bangkok, Hanoi, Jakarta</option><option value='8' Onclick=\"javascript:document.getElementById('timezone').value='8';void(0);\">(GMT + 8:00 hours) Beijing, Hong Kong, Perth, Singapore, Taipei</option><option value='9' Onclick=\"javascript:document.getElementById('timezone').value='9';void(0);\">(GMT + 9:00 hours) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option><option value='9.5' Onclick=\"javascript:document.getElementById('timezone').value='9.5';void(0);\">(GMT + 9:30 hours) Adelaide, Darwin</option><option value='10' Onclick=\"javascript:document.getElementById('timezone').value='10';void(0);\">(GMT + 10:00 hours) Melbourne, Papua New Guinea, Sydney, Vladivostok</option><option value='11' Onclick=\"javascript:document.getElementById('timezone').value='11';void(0);\">(GMT + 11:00 hours) Magadan, New Caledonia, Solomon Islands</option><option value='12' Onclick=\"javascript:document.getElementById('timezone').value='12';void(0);\">(GMT + 12:00 hours) Auckland, Wellington, Fiji, Marshall Island</option></select>"=>'timezone',
'Online List Duration time?(In Minutes)'=>'online_list_dur',
'Games and shouts to display per page?'=>'num_pages_of',
'Banned E-Mail Addresses? (Separate by commas)'=>'banned_mails',
'Banned Usernames? (Separate by commas)'=>'banned_usernames',
'Maxium size of avatar upload files in bytes? Leave blank to disallow avatar uploads.'=>'upload_av_max_size',
);
foreach($settingsarray2 as $k=>$v){
if (isset($_POST[$v])) {
$in=stripslashes(htmlspecialchars($_POST[$v], ENT_QUOTES));
}
$collectstuff.='$settings[\''.$v.'\']=\''.$in.'\';'."\n";
echo "<tr><td class='arcade1'><b>$k</b></td><td class='arcade1'>";
$idstuff='';
if($v=="timezone") $idstuff="id='timezone'";
echo "<input type='text' {$idstuff} name='".htmlspecialchars($v)."' value='$settings[$v]'>";
echo "<br></td></tr>";
}

$settingsarray3=Array(
'URL to phpMyAdmin Database Utility? (if available.)'=>'phpmyadminloc',
'Flat database (.txt) folder location? (def=flat)'=>'textloc',
'Image files folder location? (def=images)'=>'imgloc',
'Catagory Icons folder location? (def=categories)'=>'catloc',
'Avatar Gallery root folder? (def=avatars)'=>'avatarloc',
'Users Avatar folder location? (def=useravatars)'=>'useravasloc',
'Smiley/Emoticon folder location (def=emoticons)'=>'smiliesloc',
'Affiliate Banner image folder? (def=images/banners)'=>'bannerloc',
'Site CSS Themes folder? (def=skins)'=>'themesloc',
'Games root folder? (def=arcade)'=>'gamesloc',
'Site complete URL? (example: http://deburger.com/ARCADE)'=>'arcurl',
'Arcade Greeting? (def=Welcome to the Practical Lightning Arcade)'=>'arcgreet',
'Countdown Target Time? (yyyy,mo,dd,hh,mm,se)'=>'ResetTime',
'Footer Image? (stored in image file folder)'=>'toetag',
'Admin plays as this user? (def=admin)'=>'adminplayas',
'Site Email sent from this email address?'=>'siteemail',
'Show Group Emails as Sent TO:?'=>'BCCcatchall',
);
foreach($settingsarray3 as $k=>$v){
if (isset($_POST[$v])) {
$in=stripslashes(htmlspecialchars($_POST[$v], ENT_QUOTES));
}
$collectstuff.='$'.$v.'=\''.$in.'\';'."\n";
echo "<tr><td class='arcade1'><b>$k</b></td><td class='arcade1'>";
$idstuff='';
echo "<input type='text' {$idstuff} name='".htmlspecialchars($v)."' value='".$$v."'>";
echo "<br></td></tr>";
}
global $dbhost, $dbuser, $dbpass, $dbname, $dbport, $dbsocket;
$collectstuff.="\$dbhost='$dbhost';\n\$dbuser='$dbuser';\n\$dbpass='$dbpass';\n\$dbname='$dbname';\n\$dbport='$dbport';\n\$dbsocket='$dbsocket';\n";
$collectstuff.="\n?>";
?>
<tr><td class='headertableblock' colspan='2'><div align=center><input type=submit name=SettingsUpdate value='Update Settings'></div></td></tr>
</table></div><br>
</form>
<br>
<?php 
// Write St00f
if(isset($_POST['SettingsUpdate'])) {
vsess();
$imagefile = fopen("arcade_conf.php", "w");
fwrite($imagefile,  $collectstuff);
}
// St00f
}


?>
