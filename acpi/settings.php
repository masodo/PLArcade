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
# Section: settings.php  Function: Set Global Arcade Variables   Modified: 7/29/2019   By: MaSoDo

{ ?>
<br />
<form action='?cpiarea=settings' method=POST>
<form action='' method='POST'>
<?php echo "<input type='hidden' name='akey' value='$key'>"; ?>
<div align='center'>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=60% align=center class=headertableblock>Settings</td><td width=60% align=center class=headertableblock>Current setting</td><tr>
<?php
$in='';
$collectstuff="<?php\n//-----------------------------------------------------------------------------------/        \n//Practical-Lightning-Arcade [PLA] 2.0 (BETA based on PHP-Quick-Arcade 3.0 © Jcink.com\n//JS By: SeanJ. - Heavily Modified by PracticalLightning Web Design\n//Michael S. DeBurger [DeBurger Photo Image & Design]\n//-----------------------------------------------------------------------------------/\n//  phpQuickArcade v3.0.x © Jcink 2005-2010 quickarcade.jcink.com                        \n//\n//  Version: 3.0.23 Final. Released: Sunday, May 02, 2010\n//-----------------------------------------------------------------------------------/\n// Thanks to (Sean) http://seanj.jcink.com \n// for: JS and more\n// ---------------------------------------------------------------------------------/\n# These Settings Last Generated: ".date("F j, Y, g:i a")."\n\n\$maintenance = '0';\n\$notinstalled = '0';\n";
// Questions with a Yes/No answer.
$settingsarray=Array(
'Arcade Clock Use 24 hour Format? (def=No)'=>'enable_24hr',
'Closed Arcade?'=>'closed_arcade',
'Enable Online List?'=>'enable_onlinelist',
'Enable Password Recovery?'=>'enable_passrecovery',
'Enable Shoutbox?'=>'enable_shoutbox',
'Show Arcade Greeting Atop Arcade Info?'=>'enable_logo',
'Enable Countdown Timer?'=>'enable_timer',
'Allow users to post comments?'=>'allow_comments',
'Enable announcement?'=>'show_announcement',
'Display the arcade stats above the shoutbox/Login bar?'=>'show_stats_table',
'Disable New Registrations?'=>'disable_reg',
'Enable Admin Validation of New Members?'=>'enable_validation',
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
"Time Zone?: <select class='forminput'><option onClick=\"javascript:document.getElementById('timezone').value='America/New_York';void(0);\" value='America/New_York'>Select Arcade Default Time Zone</option><option onClick=\"javascript:document.getElementById('timezone').value='Pacific/Midway';void(0);\" value='Pacific/Midway'>(GMT-11:00) Midway Island, Samoa</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Adak';void(0);\" value='America/Adak'>(GMT-10:00) Hawaii-Aleutian</option><option onClick=\"javascript:document.getElementById('timezone').value='Etc/GMT+10';void(0);\" value='Etc/GMT+10'>(GMT-10:00) Hawaii</option><option onClick=\"javascript:document.getElementById('timezone').value='Pacific/Marquesas';void(0);\" value='Pacific/Marquesas'>(GMT-09:30) Marquesas Islands</option><option onClick=\"javascript:document.getElementById('timezone').value='Pacific/Gambier';void(0);\" value='Pacific/Gambier'>(GMT-09:00) Gambier Islands</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Anchorage';void(0);\" value='America/Anchorage'>(GMT-09:00) Alaska</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Ensenada';void(0);\" value='America/Ensenada'>(GMT-08:00) Tijuana, Baja California</option><option onClick=\"javascript:document.getElementById('timezone').value='Etc/GMT+8';void(0);\" value='Etc/GMT+8'>(GMT-08:00) Pitcairn Islands</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Los_Angeles';void(0);\" value='America/Los_Angeles'>(GMT-08:00) Pacific Time (US & Canada)</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Denver';void(0);\" value='America/Denver'>(GMT-07:00) Mountain Time (US & Canada)</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Chihuahua';void(0);\" value='America/Chihuahua'>(GMT-07:00) Chihuahua, La Paz, Mazatlan</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Dawson_Creek';void(0);\" value='America/Dawson_Creek'>(GMT-07:00) Arizona</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Belize';void(0);\" value='America/Belize'>(GMT-06:00) Saskatchewan, Central America</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Cancun';void(0);\" value='America/Cancun'>(GMT-06:00) Guadalajara, Mexico City, Monterrey</option><option onClick=\"javascript:document.getElementById('timezone').value='Chile/EasterIsland';void(0);\" value='Chile/EasterIsland'>(GMT-06:00) Easter Island</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Chicago';void(0);\" value='America/Chicago'>(GMT-06:00) Central Time (US & Canada)</option><option onClick=\"javascript:document.getElementById('timezone').value='America/New_York';void(0);\" value='America/New_York'>(GMT-05:00) Eastern Time (US & Canada)</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Havana';void(0);\" value='America/Havana'>(GMT-05:00) Cuba</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Bogota';void(0);\" value='America/Bogota'>(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Caracas';void(0);\" value='America/Caracas'>(GMT-04:30) Caracas</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Santiago';void(0);\" value='America/Santiago'>(GMT-04:00) Santiago</option><option onClick=\"javascript:document.getElementById('timezone').value='America/La_Paz';void(0);\" value='America/La_Paz'>(GMT-04:00) La Paz</option><option onClick=\"javascript:document.getElementById('timezone').value='Atlantic/Stanley';void(0);\" value='Atlantic/Stanley'>(GMT-04:00) Faukland Islands</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Campo_Grande';void(0);\" value='America/Campo_Grande'>(GMT-04:00) Brazil</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Goose_Bay';void(0);\" value='America/Goose_Bay'>(GMT-04:00) Atlantic Time (Goose Bay)</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Glace_Bay';void(0);\" value='America/Glace_Bay'>(GMT-04:00) Atlantic Time (Canada)</option><option onClick=\"javascript:document.getElementById('timezone').value='America/St_Johns';void(0);\" value='America/St_Johns'>(GMT-03:30) Newfoundland</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Araguaina';void(0);\" value='America/Araguaina'>(GMT-03:00) UTC-3</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Montevideo';void(0);\" value='America/Montevideo'>(GMT-03:00) Montevideo</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Miquelon';void(0);\" value='America/Miquelon'>(GMT-03:00) Miquelon, St. Pierre</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Godthab';void(0);\" value='America/Godthab'>(GMT-03:00) Greenland</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Argentina/Buenos_Aires' value='America/Argentina/Buenos_Aires'>(GMT-03:00) Buenos Aires</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Sao_Paulo';void(0);\" value='America/Sao_Paulo'>(GMT-03:00) Brasilia</option><option onClick=\"javascript:document.getElementById('timezone').value='America/Noronha';void(0);\" value='America/Noronha'>(GMT-02:00) Mid-Atlantic</option><option onClick=\"javascript:document.getElementById('timezone').value='Atlantic/Cape_Verde';void(0);\" value='Atlantic/Cape_Verde'>(GMT-01:00) Cape Verde Is.</option><option onClick=\"javascript:document.getElementById('timezone').value='Atlantic/Azores';void(0);\" value='Atlantic/Azores'>(GMT-01:00) Azores</option><option onClick=\"javascript:document.getElementById('timezone').value='Europe/Belfast';void(0);\" value='Europe/Belfast'>(GMT) Greenwich Mean Time : Belfast</option><option onClick=\"javascript:document.getElementById('timezone').value='Europe/Dublin';void(0);\" value='Europe/Dublin'>(GMT) Greenwich Mean Time : Dublin</option><option onClick=\"javascript:document.getElementById('timezone').value='Europe/Lisbon';void(0);\" value='Europe/Lisbon'>(GMT) Greenwich Mean Time : Lisbon</option><option onClick=\"javascript:document.getElementById('timezone').value='Europe/London';void(0);\" value='Europe/London'>(GMT) Greenwich Mean Time : London</option><option onClick=\"javascript:document.getElementById('timezone').value='Africa/Abidjan';void(0);\" value='Africa/Abidjan'>(GMT) Monrovia, Reykjavik</option><option onClick=\"javascript:document.getElementById('timezone').value='Europe/Amsterdam';void(0);\" value='Europe/Amsterdam'>(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option><option onClick=\"javascript:document.getElementById('timezone').value='Europe/Belgrade';void(0);\" value='Europe/Belgrade'>(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option><option onClick=\"javascript:document.getElementById('timezone').value='Europe/Brussels';void(0);\" value='Europe/Brussels'>(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option><option onClick=\"javascript:document.getElementById('timezone').value='Africa/Algiers';void(0);\" value='Africa/Algiers'>(GMT+01:00) West Central Africa</option><option onClick=\"javascript:document.getElementById('timezone').value='Africa/Windhoek';void(0);\" value='Africa/Windhoek'>(GMT+01:00) Windhoek</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Beirut';void(0);\" value='Asia/Beirut'>(GMT+02:00) Beirut</option><option onClick=\"javascript:document.getElementById('timezone').value='Africa/Cairo';void(0);\" value='Africa/Cairo'>(GMT+02:00) Cairo</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Gaza';void(0);\" value='Asia/Gaza'>(GMT+02:00) Gaza</option><option onClick=\"javascript:document.getElementById('timezone').value='Africa/Blantyre';void(0);\" value='Africa/Blantyre'>(GMT+02:00) Harare, Pretoria</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Jerusalem';void(0);\" value='Asia/Jerusalem'>(GMT+02:00) Jerusalem</option><option onClick=\"javascript:document.getElementById('timezone').value='Europe/Minsk';void(0);\" value='Europe/Minsk'>(GMT+02:00) Minsk</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Damascus';void(0);\" value='Asia/Damascus'>(GMT+02:00) Syria</option><option onClick=\"javascript:document.getElementById('timezone').value='Europe/Moscow';void(0);\" value='Europe/Moscow'>(GMT+03:00) Moscow, St. Petersburg, Volgograd</option><option onClick=\"javascript:document.getElementById('timezone').value='Africa/Addis_Ababa';void(0);\" value='Africa/Addis_Ababa'>(GMT+03:00) Nairobi</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Tehran';void(0);\" value='Asia/Tehran'>(GMT+03:30) Tehran</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Dubai';void(0);\" value='Asia/Dubai'>(GMT+04:00) Abu Dhabi, Muscat</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Yerevan';void(0);\" value='Asia/Yerevan'>(GMT+04:00) Yerevan</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Kabul';void(0);\" value='Asia/Kabul'>(GMT+04:30) Kabul</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Yekaterinburg';void(0);\" value='Asia/Yekaterinburg'>(GMT+05:00) Ekaterinburg</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Tashkent';void(0);\" value='Asia/Tashkent'>(GMT+05:00) Tashkent</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Kolkata';void(0);\" value='Asia/Kolkata'>(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Katmandu';void(0);\" value='Asia/Katmandu'>(GMT+05:45) Kathmandu</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Dhaka';void(0);\" value='Asia/Dhaka'>(GMT+06:00) Astana, Dhaka</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Novosibirsk';void(0);\" value='Asia/Novosibirsk'>(GMT+06:00) Novosibirsk</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Rangoon';void(0);\" value='Asia/Rangoon'>(GMT+06:30) Yangon (Rangoon)</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Bangkok';void(0);\" value='Asia/Bangkok'>(GMT+07:00) Bangkok, Hanoi, Jakarta</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Krasnoyarsk' ;void(0);\" value='Asia/Krasnoyarsk'>(GMT+07:00) Krasnoyarsk</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Hong_Kong';void(0);\" value='Asia/Hong_Kong'>(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Irkutsk';void(0);\" value='Asia/Irkutsk'>(GMT+08:00) Irkutsk, Ulaan Bataar</option><option onClick=\"javascript:document.getElementById('timezone').value='Australia/Perth';void(0);\" value='Australia/Perth'>(GMT+08:00) Perth</option><option onClick=\"javascript:document.getElementById('timezone').value='Australia/Eucla';void(0);\" value='Australia/Eucla'>(GMT+08:45) Eucla</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Tokyo';void(0);\" value='Asia/Tokyo'>(GMT+09:00) Osaka, Sapporo, Tokyo</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Seoul';void(0);\" value='Asia/Seoul'>(GMT+09:00) Seoul</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Yakutsk';void(0);\" value='Asia/Yakutsk'>(GMT+09:00) Yakutsk</option><option onClick=\"javascript:document.getElementById('timezone').value='Australia/Adelaide';void(0);\" value='Australia/Adelaide'>(GMT+09:30) Adelaide</option><option onClick=\"javascript:document.getElementById('timezone').value='Australia/Darwin';void(0);\" value='Australia/Darwin'>(GMT+09:30) Darwin</option><option onClick=\"javascript:document.getElementById('timezone').value='Australia/Brisbane';void(0);\" value='Australia/Brisbane'>(GMT+10:00) Brisbane</option><option onClick=\"javascript:document.getElementById('timezone').value='Australia/Hobart';void(0);\" value='Australia/Hobart'>(GMT+10:00) Hobart</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Vladivostok';void(0);\" value='Asia/Vladivostok'>(GMT+10:00) Vladivostok</option><option onClick=\"javascript:document.getElementById('timezone').value='Australia/Lord_Howe';void(0);\" value='Australia/Lord_Howe'>(GMT+10:30) Lord Howe Island</option><option onClick=\"javascript:document.getElementById('timezone').value='Etc/GMT-11';void(0);\" value='Etc/GMT-11'>(GMT+11:00) Solomon Is., New Caledonia</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Magadan';void(0);\" value='Asia/Magadan'>(GMT+11:00) Magadan</option><option onClick=\"javascript:document.getElementById('timezone').value='Pacific/Norfolk';void(0);\" value='Pacific/Norfolk'>(GMT+11:30) Norfolk Island</option><option onClick=\"javascript:document.getElementById('timezone').value='Asia/Anadyr';void(0);\" value='Asia/Anadyr'>(GMT+12:00) Anadyr, Kamchatka</option><option onClick=\"javascript:document.getElementById('timezone').value='Pacific/Auckland' value='Pacific/Auckland'>(GMT+12:00) Auckland, Wellington</option><option onClick=\"javascript:document.getElementById('timezone').value='Etc/GMT-12';void(0);\" value='Etc/GMT-12'>(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option><option onClick=\"javascript:document.getElementById('timezone').value='Pacific/Chatham';void(0);\" value='Pacific/Chatham'>(GMT+12:45) Chatham Islands</option><option onClick=\"javascript:document.getElementById('timezone').value='Pacific/Tongatapu';void(0);\" value='Pacific/Tongatapu'>(GMT+13:00) Nuku'alofa</option><option onClick=\"javascript:document.getElementById('timezone').value='Pacific/Kiritimati';void(0);\" value='Pacific/Kiritimati'>(GMT+14:00) Kiritimati</option></select> &nbsp; Arcade now set for: &rarr;"=>'timezone',
'Online List Duration time?(In Minutes)'=>'online_list_dur',
'Games and shouts to display per page?'=>'num_pages_of',
'Number of New Games to display in Site Info? (def. 20)'=>'ng_num',
'Number of Latest Scores to display in Site Info? (def. 14)'=>'ls_num',
'Number of Best Players to display in Site Info? (def. 10)'=>'bp_num',
'Size of Category Cell (in px square?) (def. 80)'=>'catdiv',
'Size of Category Icon (in px square?) (def. 60)'=>'catimg',
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
'Announcement File? (placed in flat folder)'=>'AnnounceFile',
'Image files folder location? (def=images)'=>'imgloc',
'Catagory Icons folder location? (def=categories)'=>'catloc',
'Avatar Gallery root folder? (def=avatars)'=>'avatarloc',
'Users Avatar folder location? (def=useravatars)'=>'useravasloc',
'Smiley/Emoticon folder location (def=emoticons)'=>'smiliesloc',
'Affiliate Banner image folder? (def=images/banners)'=>'bannerloc',
'Site CSS Themes folder? (def=skins)'=>'themesloc',
'Default CSS Theme? (def=BlackDefault)'=>'defCSS',
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
