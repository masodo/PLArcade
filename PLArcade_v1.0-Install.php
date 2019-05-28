<?php
function message($info,$title) {
echo "<div align='center'><div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=60% align=center class=headertableblock>$title</td><tr><td class=arcade1 valign=top><div align=center>$info</div></td></table></div><br>";
}
?>
<br />
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2002/REC-xhtml1-20020801/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title> Practical-Lightning-Arcade [PLA] 1.0 (BETA) Install Wizard</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-15" /> 
<link rel='stylesheet' type='text/css' href='./skins/Default.css'>
</head>
<body>
<?php
message("Welcome to the <b>Practical Lightning Arcade</b> install wizard. This installer will guide you through the rest of the process to get your arcade online.","Welcome");
if(!isset($_GET['step'])) {
$PV = explode(".",phpversion());
$tryvers = array_shift($PV);
if ($tryvers < 4) {
$checkcol = 'red';
} else { $checkcol = 'green'; }
message("<div align='left'><font color='".$checkcol."'>- PHP 4 or higher</font> (installed: v<b>".$tryvers."</b>)<br />- MySQL 4 or higher [This Arcade NOT COMPATIBLE with PHPv7+]<br />-UNIX/Win NT OS/FreeBSD</DIV><br /><BR />The above software is needed to install your PHPQA.","System Requirements");

message("Step 1: CHMOD 777 your:<br /> arcade_conf.php<br />/arcade/ folder <br /> /pics/ folder<br /> /tmp/ folder.<br />flat/emote_faces.txt and flat/emote_pics.txt","Install Start...");

echo "<div align='center'><div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=60% align=center class=headertableblock>Permissions check</td><tr><td class=arcade1 valign=top><div align=center>";

$files=Array('skins/BlackDefault.css','skins/GrayDefault.css','skins/Default.css','skins/','arcade_conf.php','flat/emotes_faces.txt','flat/emotes_pics.txt','arcade','arcade/pics','arcade/gamedata','tmp','tars','tarsH5');


if ($_SERVER['WINDIR']) {

echo "Windows NT<sup>TM</sup> was detected. CHMOD is not necessary, proceed to install.";

} else {

foreach ($files as $k=>$v){
$g=substr(sprintf("%o",fileperms("./$v")),-3);
if($g == 777) { 
echo "Chmod check <font color=green>OK</font> on <font color=blue>$v</font><br />"; 
} else {
echo "Chmod check<font color=red>FAILED</font> on <font color=blue>$v</font><br />";
$failure=1; 
}

}
}

if(!$failure)  { echo "<br /><br /><a href='PLArcade_v1.0-Install.php?step=2'>Proceed.</a>"; } else {
echo "The check has failed. If you know the files are chmodded, please proceeed. if not, you MUST chmod them.<br /><br />"; 

echo "<a href='PLArcade_v1.0-Install.php?step=2'>Proceed anyway...</a>";
}
echo"</div></td></table></div><br>";

} elseif (isset($_GET['step'])&&$_GET['step'] == '2') {
message("Enter your MySQL database details below. They will be tested; then written to the config file.", "Database Check");
//########################################################################################
if(isset($_POST['mysql_dbuser'])) {
echo "<script>alert('Checking Database Connection!');</script>";
$dbhost = $_POST['mysql_host'];
$dbuser = $_POST['mysql_dbuser'];
$dbpass = $_POST['mysql_dbpass'];
$dbname = $_POST['mysql_dbname'];
$SiteURL = $_POST['SiteURL'];
$connect = @mysql_connect($dbhost,$dbuser,$dbpass);
$selection = @mysql_select_db($dbname);
$h=mysql_error();
if (!$connect || !$selection) { 
echo "There was an error with the database. A detailed report of the error is available below.<br /><br /><textarea cols=70 rows=20>$h</textarea><br /><br />You should check your password and database details. If you find that they are correct, but your <br />arcade is still not functioning please contact your hosting provider."; 
die();
}
echo "<script>alert('Database Connection Success!');</script>";

//########################################################################################
// start tables

mysql_query("SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';");


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

//
// Database: `PLArcade`
//
 
// ------------------------------------------------------//
 
//
// Table structure for table `phpqa_accounts`
//
 
mysql_query("CREATE TABLE `phpqa_accounts` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `pass` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `ipaddress` varchar(255) NOT NULL default '',
  `avatar` varchar(255) NOT NULL default '',
  `group` varchar(255) NOT NULL default '',
  `skin` varchar(255) NOT NULL default '',
  `settings` longtext character set latin1 NOT NULL,
  `logins` int(11) NOT NULL default '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");
// ------------------------------------------------------//
 
//
// Table structure for table `phpqa_cats`
//
 
mysql_query("CREATE TABLE `phpqa_cats` (
  `id` int(11) NOT NULL auto_increment,
  `cat` varchar(15) default NULL,
  `displayorder` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");
// ------------------------------------------------------//
 
//
// Table structure for table `phpqa_games`
//
 
mysql_query("CREATE TABLE `phpqa_games` (
  `id` int(11) NOT NULL auto_increment,
  `game` varchar(255) default NULL,
  `gameid` varchar(255) NOT NULL default '',
  `gameheight` smallint(3) NOT NULL default '0',
  `gamewidth` smallint(3) NOT NULL default '0',
  `about` varchar(512) NOT NULL default '',
  `gamecat` varchar(255) NOT NULL default '',
  `remotelink` varchar(255) NOT NULL default '',
  `Champion_name` varchar(255) NOT NULL default '',
  `Champion_score` decimal(20,0) default NULL,
  `times_played` int(11) default '0',
  `scoring` varchar(8) default 'HI' COMMENT 'added MSD',
  `platform` varchar(8) default 'FL' COMMENT 'added MSD',
  `rate` tinyint(3) default NULL COMMENT 'added MSD',
  `tags` varchar(64) default NULL COMMENT 'added MSD',
  `HOF_name` varchar(255) NOT NULL default '',
  `HOF_score` decimal(20,0) default NULL,
  UNIQUE KEY `id` (`id`),
  KEY `gamecat` (`gamecat`),
  KEY `gameid` (`gameid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");
// ------------------------------------------------------//
 
//
// Table structure for table `phpqa_leaderboard`
//
 
mysql_query("CREATE TABLE `phpqa_leaderboard` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `thescore` decimal(20,0) default NULL,
  `gamename` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `username` (`username`),
  KEY `username_2` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");
// ------------------------------------------------------//
 
//
// Table structure for table `phpqa_logs`
//
 
mysql_query("CREATE TABLE `phpqa_logs` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `thescore` decimal(20,0) default NULL,
  `ip` varchar(255) NOT NULL default '0',
  `comment` varchar(255) NOT NULL default '',
  `phpdate` int(10) NOT NULL default '0',
  `gameidname` varchar(255) NOT NULL default '',
  `cheaturl` varchar(255) NOT NULL default '',
  `log_type` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `username` (`username`),
  KEY `gameidname` (`gameidname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
// ------------------------------------------------------//
 
//
// Table structure for table `phpqa_scores`
//
 
mysql_query("CREATE TABLE `phpqa_scores` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `thescore` decimal(20,0) default NULL,
  `ip` varchar(255) NOT NULL default '0',
  `comment` varchar(255) NOT NULL default '',
  `phpdate` int(10) NOT NULL default '0',
  `gameidname` varchar(255) NOT NULL default '',
  `gamename` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `username` (`username`),
  KEY `gameidname` (`gameidname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");
// ------------------------------------------------------//
 
//
// Table structure for table `phpqa_sessions`
//
 
mysql_query("CREATE TABLE `phpqa_sessions` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `time` varchar(255) NOT NULL default '',
  `location` varchar(255) NOT NULL default '',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");
// ------------------------------------------------------//
 
//
// Table structure for table `phpqa_shoutbox`
//
 
mysql_query("CREATE TABLE `phpqa_shoutbox` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `shout` mediumtext NOT NULL,
  `ipa` varchar(255) NOT NULL default '',
  `tstamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");
// ------------------------------------------------------//

//
// Table structure for table `phpqa_wall`
//

mysql_query("CREATE TABLE `phpqa_wall` (
  `id` int(11) NOT NULL auto_increment,
  `Wyear` int(11) NOT NULL,
  `Wplace` smallint(6) NOT NULL,
  `Wgames` int(11) NOT NULL,
  `Wname` varchar(80) NOT NULL,
  `Wavatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");

// ------------------------------------------------------//

//
// Table structure for table `phpqa_affiliate`
//

mysql_query("CREATE TABLE `phpqa_affiliate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
");

// end tables

// Add Data

// data for table `phpqa_affiliate`

mysql_query("INSERT INTO `phpqa_affiliate` VALUES(1, 'DeBurgerGameRoom.gif', 'http://DeBurger.com/ARCADE ', 'The DeBurger Game Room', 1, '');");
mysql_query("INSERT INTO `phpqa_affiliate` VALUES(2, 'PracticalLightning.jpg', 'http://PracticalLightning.com/ARCADE', 'PracticalLightning Arcade ', 2, '');");

// data for table `phpqa_cats`

mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(1, 'New', 1);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(2, 'Dead', 50);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(3, 'Pinball', 7);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(4, 'Arcade', 2);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(5, 'Word Game', 8);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(6, 'Other', 9);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(7, 'Mahjongg', 6);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(8, 'Board', 17);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(9, 'Table Game', 15);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(10, 'Slots', 10);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(11, 'Dice', 11);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(12, 'Match', 5);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(13, 'Hidden Object', 16);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(14, 'Spot Difference', 14);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(15, 'Escape', 13);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(16, 'No Score', 20);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(17, 'Cards', 3);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(18, 'Sports', 12);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(19, 'Physics', 18);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(20, 'DOS', 21);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(21, 'Slingo', 4);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(23, 'Testing', 22);");
mysql_query("INSERT INTO `phpqa_cats` (`id`, `cat`, `displayorder`) VALUES(24, 'Platform', 7);");



mysql_query("INSERT INTO `phpqa_games`  (
`id` ,
`game` ,
`gameid` ,
`gameheight` ,
`gamewidth` ,
`about` ,
`gamecat` ,
`remotelink` ,
`Champion_name` ,
`Champion_score` ,
`times_played` ,
`scoring` ,
`platform` ,
`rate` ,
`tags`
)
VALUES (
NULL , 'Hexxagon', 'Hexxagon', 346, 388, 'Overtake the computers jewels.', '4', '', '', NULL, NULL, 'HI', 'FL', NULL, NULL);");
mysql_query("INSERT INTO `phpqa_games` VALUES(2, 'Tetris', 'Tetris', 381, 400, 'Make rows of blocks but dont overload the screen.', 4, '', '', NULL, NULL, 'HI', 'FL', NULL, NULL);");
mysql_query("INSERT INTO `phpqa_games`  (
`id` ,
`game` ,
`gameid` ,
`gameheight` ,
`gamewidth` ,
`about` ,
`gamecat` ,
`remotelink` ,
`Champion_name` ,
`Champion_score` ,
`times_played` ,
`scoring` ,
`platform` ,
`rate` ,
`tags`
)
VALUES (
NULL , 'Flasteroids', 'Flasteroids', 500, 350, 'A twist on the game asteroids, created by Bodekaer.', 4, '', '', NULL, NULL, 'HI', 'FL', NULL, NULL);");
mysql_query("INSERT INTO `phpqa_games`  (
`id` ,
`game` ,
`gameid` ,
`gameheight` ,
`gamewidth` ,
`about` ,
`gamecat` ,
`remotelink` ,
`Champion_name` ,
`Champion_score` ,
`times_played` ,
`scoring` ,
`platform` ,
`rate` ,
`tags`
)
VALUES (
NULL , 'Snake', 'Snake', 319, 359, 'Snake... Just like on your cellphone.', 4, '', '', NULL, NULL, 'HI', 'FL', NULL, NULL);");
mysql_query("INSERT INTO `phpqa_games`  (
`id` ,
`game` ,
`gameid` ,
`gameheight` ,
`gamewidth` ,
`about` ,
`gamecat` ,
`remotelink` ,
`Champion_name` ,
`Champion_score` ,
`times_played` ,
`scoring` ,
`platform` ,
`rate` ,
`tags`
)
VALUES (
NULL , 'Simon', 'Simon', 400, 400, 'Test your memmory.', 4, '', '', NULL, NULL, 'HI', 'FL', NULL, NULL);");
mysql_query("INSERT INTO `phpqa_games`  (
`id` ,
`game` ,
`gameid` ,
`gameheight` ,
`gamewidth` ,
`about` ,
`gamecat` ,
`remotelink` ,
`Champion_name` ,
`Champion_score` ,
`times_played` ,
`scoring` ,
`platform` ,
`rate` ,
`tags`
)
VALUES (
NULL , 'Asteroids', 'Asteroids', 394, 499, 'The hit arcade classic.', 4, '', '', NULL, NULL, 'HI', 'FL', NULL, NULL);");
mysql_query("INSERT INTO `phpqa_games`  (
`id` ,
`game` ,
`gameid` ,
`gameheight` ,
`gamewidth` ,
`about` ,
`gamecat` ,
`remotelink` ,
`Champion_name` ,
`Champion_score` ,
`times_played` ,
`scoring` ,
`platform` ,
`rate` ,
`tags`
)
VALUES (
NULL , 'Space Invaders', 'Invaders', 429, 500, 'Blast Aliens in this classic game!', 4, '', '', NULL, NULL, 'HI', 'FL', NULL, NULL);");
mysql_query("INSERT INTO `phpqa_games`  (
`id` ,
`game` ,
`gameid` ,
`gameheight` ,
`gamewidth` ,
`about` ,
`gamecat` ,
`remotelink` ,
`Champion_name` ,
`Champion_score` ,
`times_played` ,
`scoring` ,
`platform` ,
`rate` ,
`tags`
)
VALUES (
NULL , 'Duke Nukem (Original)', 'DukeNukem1', 480, 640, 'Your mission is to stop Dr. Proton, a madman bent on ruling the world with his army of Techbots. As the irrepressible hero Duke Nukem, youll chase Dr. Proton deep into the Earth, then to his lunar space station, and eventually into the Earths ', 20, './arcade/gamedata/DukeNukem1','', NULL, NULL, 'HI', 'H5', NULL, NULL);");
mysql_query("INSERT INTO `phpqa_games`  (
`id` ,
`game` ,
`gameid` ,
`gameheight` ,
`gamewidth` ,
`about` ,
`gamecat` ,
`remotelink` ,
`Champion_name` ,
`Champion_score` ,
`times_played` ,
`scoring` ,
`platform` ,
`rate` ,
`tags`
)
VALUES (
NULL , 'MADMIKE GAME', 'MADMIKE', 480, 640, 'THE MADMIKE GAME in qBasic . . . by maDMIKE soFTWARE doODLES', 20, './arcade/gamedata/madmike','', NULL, NULL, 'HI', 'H5', NULL, NULL);");
mysql_query("INSERT INTO `phpqa_games`  (
`id` ,
`game` ,
`gameid` ,
`gameheight` ,
`gamewidth` ,
`about` ,
`gamecat` ,
`remotelink` ,
`Champion_name` ,
`Champion_score` ,
`times_played` ,
`scoring` ,
`platform` ,
`rate` ,
`tags`
)
VALUES (
NULL , '10 x 10 Arabian Nights', '10x10-arabic_Origon', 480, 800, 'Fill up the 10x10 board with tiles. A challenging Arabian themed puzzle game that requires patience and strategy.', 6, './arcade/gamedata/10x10-arabic_Origon','', NULL, NULL, 'HI', 'H5', NULL, NULL);");

mysql_query("INSERT INTO `phpqa_accounts` (`id`, `name`, `pass`, `email`, `ipaddress`, `avatar`, `group`, `skin`, `settings`, `logins`) VALUES(1, 'Admin', '0c7540eb7e65b553ec1ba6b20de79608', 'admin@localhost', '{$_SERVER['REMOTE_ADDR']}', '', 'Admin', 'Default', '', 0);");
mysql_query("INSERT INTO `phpqa_accounts` (`id`, `name`, `pass`, `email`, `ipaddress`, `avatar`, `group`, `skin`, `settings`, `logins`) VALUES(45, 'user', '68f32b5f0943904f5eac13096f25d756', 'admin@localhost', '{$_SERVER['REMOTE_ADDR']}', '', 'Member', 'Default', '', 0);");

// Writing to the conf.
$conf=@fopen('arcade_conf.php', 'w');

$goforit = @fwrite($conf,"<?php\n\$maintenance='0';\n\$notinstalled='0';\n\$settings['enable_onlinelist']='1';\n\$settings['enable_passrecovery']='1';\n\$settings['enable_shoutbox']='1';\n\$settings['enable_logo']='0';\n\$settings['enable_timer']='0';\n\$settings['allow_comments']='1';\n\$settings['show_stats_table']='1';\n\$settings['disable_reg']='0';\n\$settings['enable_validation']='0';\n\$settings['use_cheat_protect']='0';\n\$settings['upload_av_max_size']='0';\n\$settings['use_seccode']='1';\n\$settings['allow_guests']='1';\n\$settings['override_userprefs']='0';\n\$settings['arcade_title']='Practical Lightning Arcade [PLA v1.0 beta]';\n\$settings['datestamp']='jS F Y - h:i A';\n\$settings['online_list_dur']='60';\n\$settings['timezone']='-5';\n\$settings['num_pages_of']='10';\n\$settings['banned_mails']='';\n\$settings['banned_usernames']='Tasos,TasosP13';\n\$settings['upload_av_max_size']='200000';\n\$phpmyadminloc='';\n\$textloc='flat';\n\$imgloc='images';\n\$catloc='categories';\n\$avatarloc='avatars';\n\$useravasloc='useravatars';\n\$smiliesloc='emoticons';\n\$bannerloc='images/banners';\n\$themesloc='skins';\n\$gamesloc='arcade';\n\$arcurl='".$SiteURL."';\n\$arcgreet='Welcome to the Practical Lightning Arcade (BETA)';\n\$ResetTime ='2025,02,31,20,01,0';\n\$toetag='mornoovening-sm.gif';\n\$adminplayas='admin';\n\$siteemail='arcade@MyNewArcade.tld';\n\$BCCcatchall='ArcadeMember@MyNewArcade.tld';\n\$dbhost='".$dbhost."';\n\$dbuser='".$dbuser."';\n\$dbpass='".$dbpass."';\n\$dbname='".$dbname."';\n?>");

if(!$goforit) { 
message("arcade_conf.php could not be opened for writing. Please check the permissions.","Failed to write to conf");
}else{
message("Your new arcade is installed! Congratulations! <a href='index.php'>Click here to get started</a>. <br /><br /><br /><font color='red'>Login with the name: <u>admin</u> and password of: <u>admin</u>. <i>Change this password</i> when you login! You may also change your name if you like.</font><br /><br /><H1>DELETE THIS INSTALL.PHP NOW</H1>","Complete");
}
}

?>
<form action='PLArcade_v1.0-Install.php?step=2' method='POST'>
<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><td width='60%' align='center' class='headertableblock'>Database Details</td><td width='60%' align='center' class='headertableblock'></td><tr>
<tr><td class='arcade1' align='left'><b>Enter your database host:</b><br /></td><td class='arcade1' align='left'><input type='text' name='mysql_host' value ='localhost' /></td></tr><tr><td class='arcade1' align='left'><b>Enter your database name:</b></td><td class='arcade1' align='left'><input type='text' name='mysql_dbname' value='' /></td></tr><tr><td class='arcade1'><b>Enter your MySQL Username:</b></td><td class='arcade1'><input type='text' name='mysql_dbuser' value='' /></td></tr><tr><td class='arcade1' align='left'><b>Password:</b></td><td class='arcade1' align='left'><input type='password' name='mysql_dbpass' value='' /></td></tr><tr><td class='arcade1' align='left'><b>Site URL:</b> Web Address of your arcade (no trailing slash)</td><td class='arcade1' align='left'><input type='text' name='SiteURL' value='http://MySite.tld/PLArcade' /></td></tr></div></td>

<tr><td class=headertableblock colspan='2'><div align='center'><input type='submit' name='postDB' value='Install to Database' /></div></td></tr>


</table></div>
<br />
</form>


<?php
}
?>
<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1'><?php echo date('md')=='0401'?'Gilligans Arcade':'<b>Practical-Lightning-Arcade [PLA] 1.0 </b> (BETA)'; ?> based on <b>PHP-Quick-Arcade 3.0</b> &copy; <a href='http://Jcink.com'>Jcink.com</a><br />JS By: <a href='http://seanj.jcink.com'>SeanJ</a>. -  Heavily Modified by <font size='2' face='Lucida Console'><b><a href='http://www.practicallightning.com' target='_blank'>practical<sub><img src='http://infinitelyremote.dynu.net/image-box/PL_logo_sm.gif' alt='PracticalLightning.com' border='0'></sub>lightning</a></b></font> Web Design [<i><a title='DeBurger Photo Image &amp; Design'>DPI&ampD</a></i>]</td></tr></table></div></div><br />
</body>
</html>
