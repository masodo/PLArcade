<?php
function message($info,$title) {
echo "<div align='center'><div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=60% align=center class=headertableblock>$title</td><tr><td class=arcade1 valign=top><div align=center>$info</div></td></table></div><br>";
}
?>
<br />
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2002/REC-xhtml1-20020801/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title> Practical-Lightning-Arcade [PLA] 2.0 (ALPHA) Install Wizard</title>
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
message("<div align='left'><font color='".$checkcol."'>- PHP 4 or higher</font> (installed: v<b>".$tryvers."</b>)<br />- MySQL 4 or higher<br />-UNIX/Win NT OS/FreeBSD</DIV><br /><BR />The above software is needed to install your PHPQA.","System Requirements");

message("Step 1: CHMOD 777 your:<br /> arcade_conf.php<br />/arcade/ folder <br /> /pics/ folder<br /> /tmp/ folder.<br />flat/announce.php","Install Start...");

echo "<div align='center'><div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=60% align=center class=headertableblock>Permissions check</td><tr><td class=arcade1 valign=top><div align=center>";

$files=Array('skins/BlackDefault.css','skins/GrayDefault.css','skins/Default.css','skins/','arcade_conf.php','flat/announce.php','arcade','arcade/pics','arcade/gamedata');


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

if(!$failure)  { echo "<br /><br /><a href='PLArcade_v2.0-Install.php?step=2'>Proceed.</a>"; } else {
echo "The check has failed. If you know the files are chmodded, please proceeed. if not, you MUST chmod them.<br /><br />"; 

echo "<a href='PLArcade_v2.0-Install.php?step=2'>Proceed anyway...</a>";
}
echo"</div></td></table></div><br>";

} elseif (isset($_GET['step'])&&$_GET['step'] == '2') {
message("Enter your MySQL database details below. They will be tested; then written to the config file.", "Database Check");
//########################################################################################

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Incompatible Function Block #1
if(isset($_POST['mysqli_dbuser'])) {
echo "<script>alert('Checking Database Connection!');</script>";
$dbhost = $_POST['mysqli_host'];
$dbuser = $_POST['mysqli_dbuser'];
$dbpass = $_POST['mysqli_dbpass'];
$dbname = $_POST['mysqli_dbname'];
$SiteURL = $_POST['SiteURL'];
$iconnect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
if (!$iconnect) { 
echo "There was an error with the database. A detailed report of the error is available below.<br /><br /><textarea cols=70 rows=20>$h</textarea><br /><br />You should check your password and database details. If you find that they are correct, but your <br />arcade is still not functioning please contact your hosting provider."; 
die();
}
echo "<script>alert('Database Connection Success!');</script>";

//########################################################################################
// start tables

mysqli_query($iconnect,"SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';");


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

//
// Database: `PLArcade`
//
 
// ------------------------------------------------------//
 

// Table structure for table `phpqa_accounts`

mysqli_query($iconnect,"CREATE TABLE`phpqa_accounts` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `pass` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `ipaddress` varchar(255) NOT NULL default '',
  `avatar` varchar(255) NOT NULL default '',
  `group` varchar(255) NOT NULL default '',
  `skin` varchar(255) NOT NULL default '',
  `settings` longtext NOT NULL,
  `tournaments` int(11) default '0',
  `logins` int(11) NOT NULL default '0',
  `vtstamp` int(10) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;
");

// ------------------------------------------------------
// Table structure for table `phpqa_affiliate`

mysqli_query($iconnect,"CREATE TABLE`phpqa_affiliate` (
  `id` int(11) NOT NULL auto_increment,
  `img` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `refs` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
");
// Dumping data for table `phpqa_affiliate`

mysqli_query($iconnect,"INSERT INTO `phpqa_affiliate` VALUES(6, 'DeBurgerGameRoom.gif', 'http://DeBurger.com/ARCADE ', 'The DeBurger Game Room', 5, '', 0, 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_affiliate` VALUES(10, 'PLA.jpg', 'http://practicallightning.com/ARCADE/', 'PracticalLightning Arcade', 1, 'cERSbvd', 0, 1);");

// ------------------------------------------------------
// Table structure for table `phpqa_cats`

mysqli_query($iconnect,"CREATE TABLE`phpqa_cats` (
  `id` int(11) NOT NULL auto_increment,
  `cat` varchar(15) default NULL,
  `displayorder` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;
");
// Dumping data for table `phpqa_cats`

mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(1, 'New', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(2, 'Dead', 50);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(3, 'Pinball', 7);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(4, 'Arcade', 2);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(5, 'Word Game', 8);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(6, 'Other', 9);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(7, 'Mahjongg', 6);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(8, 'Board', 17);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(9, 'Table Game', 15);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(10, 'Slots', 10);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(11, 'Dice', 11);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(12, 'Match', 5);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(13, 'Hidden Object', 16);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(14, 'Spot Difference', 14);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(15, 'Escape', 13);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(16, 'No Score', 20);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(17, 'Cards', 3);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(18, 'Sports', 12);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(19, 'Physics', 18);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(20, 'DOS', 21);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(21, 'Slingo', 4);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(23, 'Testing', 22);");
mysqli_query($iconnect,"INSERT INTO `phpqa_cats` VALUES(24, 'Platform', 7);");

// ------------------------------------------------------
// Table structure for table `phpqa_emotes`

mysqli_query($iconnect,"CREATE TABLE`phpqa_emotes` (
  `id` int(40) NOT NULL auto_increment,
  `filename` varchar(40) default NULL,
  `code` varchar(32) default NULL,
  `description` varchar(128) default NULL,
  `enabled` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=126 ;
");
// Dumping data for table `phpqa_emotes`

// data for table `phpqa_emotes`
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(1, '1.gif', ':)', 'basic smiley', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(2, '10.gif', ':p', 'toungue out', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(3, '11.gif', ':sweat:', 'sweat', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(4, '14.gif', '>.<', 'grimmace', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(5, '3.gif', ':(', 'sad face', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(6, '5.gif', '[:D]', 'grin', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(7, 'wavey.gif', '[wavey]', 'wavey guy', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(8, 'angry.gif', 'angry', 'angry face', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(9, 'th_computerbrain.gif', 'hack', 'hacking', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(10, 'question.gif', '[quest]', 'guestion', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(11, 'hi.gif', '[hi]', 'Hi', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(12, 'thumbsup.gif', '[thumbup]', 'thumbs up', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(13, 'SM074.gif', '!@#$%', 'cussing', 1);");
mysqli_query($iconnect,"INSERT INTO `phpqa_emotes` VALUES(14, 'SM039.gif', 'OhYeah', 'Happy Nanna Dance', 1);");
// ------------------------------------------------------
// Table structure for table `phpqa_games`

mysqli_query($iconnect,"CREATE TABLE`phpqa_games` (
  `id` int(11) NOT NULL auto_increment,
  `game` varchar(255) default NULL,
  `gameid` varchar(255) NOT NULL default '',
  `gameheight` smallint(3) NOT NULL default '0',
  `gamewidth` smallint(3) NOT NULL default '0',
  `about` varchar(512) character set utf8 NOT NULL,
  `gamecat` varchar(255) NOT NULL default '',
  `remotelink` varchar(255) NOT NULL default '',
  `Champion_name` varchar(255) NOT NULL default '',
  `Champion_score` decimal(20,0) default NULL,
  `times_played` int(11) default '0',
  `scoring` varchar(8) default 'HI' COMMENT 'added MSD',
  `platform` varchar(8) default 'FL' COMMENT 'added MSD',
  `rate` tinyint(3) default NULL COMMENT 'added MSD',
  `tags` varchar(64) default NULL COMMENT 'added MSD',
  `HOF_name` varchar(255) NOT NULL,
  `HOF_score` decimal(20,0) default NULL,
  `exclusiv` tinyint(1) NOT NULL default '0',
  UNIQUE KEY `id` (`id`),
  KEY `gamecat` (`gamecat`),
  KEY `gameid` (`gameid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=950 ;
");


// ------------------------------------------------------// data for table `phpqa_games`
mysqli_query($iconnect,"INSERT INTO `phpqa_games`  (
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
mysqli_query($iconnect,"INSERT INTO `phpqa_games` VALUES(2, 'Tetris', 'Tetris', 381, 400, 'Make rows of blocks but dont overload the screen.', 4, '', '', NULL, NULL, 'HI', 'FL', NULL, NULL);");
mysqli_query($iconnect,"INSERT INTO `phpqa_games`  (
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
mysqli_query($iconnect,"INSERT INTO `phpqa_games`  (
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
mysqli_query($iconnect,"INSERT INTO `phpqa_games`  (
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
mysqli_query($iconnect,"INSERT INTO `phpqa_games`  (
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
mysqli_query($iconnect,"INSERT INTO `phpqa_games`  (
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
mysqli_query($iconnect,"INSERT INTO `phpqa_games`  (
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
mysqli_query($iconnect,"INSERT INTO `phpqa_games`  (
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
mysqli_query($iconnect,"INSERT INTO `phpqa_games`  (
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

mysqli_query($iconnect,"INSERT INTO `phpqa_accounts` (`id`, `name`, `pass`, `email`, `ipaddress`, `avatar`, `group`, `skin`, `settings`, `logins`) VALUES(1, 'Admin', '0c7540eb7e65b553ec1ba6b20de79608', 'admin@localhost', '{$_SERVER['REMOTE_ADDR']}', '', 'Admin', 'Default', '', 0);");
mysqli_query($iconnect,"INSERT INTO `phpqa_accounts` (`id`, `name`, `pass`, `email`, `ipaddress`, `avatar`, `group`, `skin`, `settings`, `logins`) VALUES(45, 'user', '68f32b5f0943904f5eac13096f25d756', 'admin@localhost', '{$_SERVER['REMOTE_ADDR']}', '', 'Member', 'Default', '', 0);");

// Table structure for table `phpqa_leaderboard`

mysqli_query($iconnect,"CREATE TABLE`phpqa_leaderboard` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `thescore` decimal(20,0) default NULL,
  `gamename` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `username` (`username`),
  KEY `username_2` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2800 ;
");

// ------------------------------------------------------
// Table structure for table `phpqa_logs`

mysqli_query($iconnect,"CREATE TABLE`phpqa_logs` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
");


// ------------------------------------------------------
// Table structure for table `phpqa_scores`

mysqli_query($iconnect,"CREATE TABLE`phpqa_scores` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1809 ;
");

// ------------------------------------------------------
// Table structure for table `phpqa_sessions`

mysqli_query($iconnect,"CREATE TABLE`phpqa_sessions` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `time` varchar(255) NOT NULL default '',
  `location` varchar(255) NOT NULL default '',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3083 ;
");
// ------------------------------------------------------
// Table structure for table `phpqa_shoutbox`

mysqli_query($iconnect,"CREATE TABLE`phpqa_shoutbox` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `shout` mediumtext NOT NULL,
  `ipa` varchar(255) NOT NULL default '',
  `tstamp` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=166 ;
");

// ------------------------------------------------------
// Table structure for table `phpqa_tournaments`

mysqli_query($iconnect,"CREATE TABLE`phpqa_tournaments` (
  `id` int(11) NOT NULL auto_increment,
  `tournament_id` int(11) default NULL,
  `user` text,
  `players` int(11) default NULL,
  `level` int(11) default '0',
  `average_score` text,
  `times_played` int(11) default '0',
  `game_id` text,
  `winner` text,
  `misc_settings` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;
");
// Table structure for table `phpqa_wall`

mysqli_query($iconnect,"CREATE TABLE`phpqa_wall` (
  `id` int(11) NOT NULL auto_increment,
  `Wyear` int(11) NOT NULL,
  `Wplace` smallint(6) NOT NULL,
  `Wgames` int(11) NOT NULL,
  `Wname` varchar(80) NOT NULL,
  `Wavatar` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;
");

// ------------------------------------------------------
// Table structure for table `PLA_attach_files`

mysqli_query($iconnect,"CREATE TABLE`PLA_attach_files` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `owner_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  `topic_id` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_ext` varchar(64) NOT NULL,
  `file_mime_type` varchar(64) NOT NULL,
  `file_path` text NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `download_counter` int(10) unsigned NOT NULL default '0',
  `uploaded_at` int(10) unsigned NOT NULL,
  `secure_str` varchar(32) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
");

// ------------------------------------------------------
// Table structure for table `PLA_bans`

mysqli_query($iconnect,"CREATE TABLE`PLA_bans` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(200) default NULL,
  `ip` varchar(255) default NULL,
  `email` varchar(80) default NULL,
  `message` varchar(255) default NULL,
  `expire` int(10) unsigned default NULL,
  `ban_creator` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
");
// ------------------------------------------------------
// Table structure for table `PLA_categories`

mysqli_query($iconnect,"CREATE TABLE`PLA_categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `cat_name` varchar(80) NOT NULL default 'New Category',
  `disp_position` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
");
// Dumping data for table `PLA_categories`

mysqli_query($iconnect,"INSERT INTO `PLA_categories` VALUES(3, 'General Discussion', 2);");
// ------------------------------------------------------
// Table structure for table `PLA_censoring`

mysqli_query($iconnect,"CREATE TABLE`PLA_censoring` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `search_for` varchar(60) NOT NULL default '',
  `replace_with` varchar(60) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
");
// ------------------------------------------------------
// Table structure for table `PLA_config`

mysqli_query($iconnect,"CREATE TABLE`PLA_config` (
  `conf_name` varchar(255) NOT NULL default '',
  `conf_value` text,
  PRIMARY KEY  (`conf_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
// Dumping data for table `PLA_config`

mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_cur_version', '1.4.4');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_database_revision', '5');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_board_title', 'PracticalLightning Arcade - Forum');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_board_desc', 'Forum for Members of PracticalLightning Arcade');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_default_timezone', '-5');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_time_format', 'H:i:s');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_date_format', 'Y-m-d');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_check_for_updates', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_check_for_versions', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_timeout_visit', '5400');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_timeout_online', '300');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_redirect_delay', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_show_version', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_show_user_info', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_show_post_count', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_signatures', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_smilies', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_smilies_sig', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_make_links', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_default_lang', 'English');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_default_style', 'Oxygen');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_default_user_group', '3');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_topic_review', '15');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_disp_topics_default', '30');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_disp_posts_default', '25');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_indent_num_spaces', '4');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_quote_depth', '3');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_quickpost', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_users_online', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_censoring', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_ranks', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_show_dot', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_topic_views', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_quickjump', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_gzip', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_additional_navlinks', '1 = <a href=\"/ARCADE/\">ARCADE</a>');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_report_method', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_regs_report', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_default_email_setting', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_mailing_list', 'arcade@MyDomain.com');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_avatars', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_avatars_dir', 'img/avatars');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_avatars_width', '60');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_avatars_height', '60');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_avatars_size', '15360');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_search_all_forums', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_sef', 'Default');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_admin_email', 'arcade@MyDomain.com');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_webmaster_email', 'arcade@MyDomain.com');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_subscriptions', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_smtp_host', NULL);");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_smtp_user', NULL);");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_smtp_pass', NULL);");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_smtp_ssl', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_regs_allow', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_regs_verify', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_announcement', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_announcement_heading', 'Sample announcement');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_announcement_message', '<p>Enter your announcement here.</p>');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_rules', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_rules_message', 'Enter your rules here.');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_maintenance', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_maintenance_message', 'The forums are temporarily down for maintenance. Please try again in a few minutes.<br /><br />Administrator');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_default_dst', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('p_message_bbcode', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('p_message_img_tag', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('p_message_all_caps', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('p_subject_all_caps', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('p_sig_all_caps', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('p_sig_bbcode', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('p_sig_img_tag', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('p_sig_length', '400');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('p_sig_lines', '4');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('p_allow_banned_email', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('p_allow_dupe_email', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('p_force_guest_email', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_show_moderators', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_mask_passwords', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_pun_pm_inbox_size', '100');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_pun_pm_outbox_size', '100');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_pun_pm_show_new_count', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('o_pun_pm_show_global_link', '0');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('attach_always_deny', 'html,htm,php,php3,php4,exe,com,bat');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('attach_basefolder', 'extensions/pun_attachment/attachments/');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('attach_create_orphans', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('attach_icon_folder', '/FORUM/extensions/pun_attachment/img/');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('attach_icon_extension', 'txt,doc,pdf,wav,mp3,ogg,avi,mpg,mpeg,png,jpg,jpeg,gif');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('attach_icon_name', 'text.png,doc.png,doc.png,audio.png,audio.png,audio.png,video.png,video.png,video.png,image.png,image.png,image.png,image.png');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('attach_subfolder', '7e72976a5a799fec1ef6e246f8cbb17b');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('attach_use_icon', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('attach_disp_small', '1');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('attach_small_height', '60');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('attach_small_width', '60');");
mysqli_query($iconnect,"INSERT INTO `PLA_config` VALUES('attach_disable_attach', '0');");

// ------------------------------------------------------
// Table structure for table `PLA_extensions`

mysqli_query($iconnect,"CREATE TABLE`PLA_extensions` (
  `id` varchar(150) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `version` varchar(25) NOT NULL default '',
  `description` text,
  `author` varchar(50) NOT NULL default '',
  `uninstall` text,
  `uninstall_note` text,
  `disabled` tinyint(1) NOT NULL default '0',
  `dependencies` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
// ------------------------------------------------------
// Table structure for table `PLA_extension_hooks`

mysqli_query($iconnect,"CREATE TABLE`PLA_extension_hooks` (
  `id` varchar(150) NOT NULL default '',
  `extension_id` varchar(50) NOT NULL default '',
  `code` text,
  `installed` int(10) unsigned NOT NULL default '0',
  `priority` tinyint(1) unsigned NOT NULL default '5',
  PRIMARY KEY  (`id`,`extension_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");

// ------------------------------------------------------
// Table structure for table `PLA_forums`

mysqli_query($iconnect,"CREATE TABLE`PLA_forums` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `forum_name` varchar(80) NOT NULL default 'New forum',
  `forum_desc` text,
  `redirect_url` varchar(100) default NULL,
  `moderators` text,
  `num_topics` mediumint(8) unsigned NOT NULL default '0',
  `num_posts` mediumint(8) unsigned NOT NULL default '0',
  `last_post` int(10) unsigned default NULL,
  `last_post_id` int(10) unsigned default NULL,
  `last_poster` varchar(200) default NULL,
  `sort_by` tinyint(1) NOT NULL default '0',
  `disp_position` int(10) NOT NULL default '0',
  `cat_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;
");

// ------------------------------------------------------
// Table structure for table `PLA_forum_perms`

mysqli_query($iconnect,"CREATE TABLE`PLA_forum_perms` (
  `group_id` int(10) NOT NULL default '0',
  `forum_id` int(10) NOT NULL default '0',
  `read_forum` tinyint(1) NOT NULL default '1',
  `post_replies` tinyint(1) NOT NULL default '1',
  `post_topics` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`group_id`,`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
// Dumping data for table `PLA_forum_perms`

mysqli_query($iconnect,"INSERT INTO `PLA_forum_perms` VALUES(2, 5, 0, 0, 0);");
mysqli_query($iconnect,"INSERT INTO `PLA_forum_perms` VALUES(3, 5, 0, 0, 0);");
mysqli_query($iconnect,"INSERT INTO `PLA_forum_perms` VALUES(2, 6, 0, 0, 0);");
mysqli_query($iconnect,"INSERT INTO `PLA_forum_perms` VALUES(3, 6, 0, 0, 0);");

// ------------------------------------------------------
// Table structure for table `PLA_forum_subscriptions`

mysqli_query($iconnect,"CREATE TABLE`PLA_forum_subscriptions` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `forum_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
// Dumping data for table `PLA_forum_subscriptions`


// ------------------------------------------------------
// Table structure for table `PLA_groups`

mysqli_query($iconnect,"CREATE TABLE`PLA_groups` (
  `g_id` int(10) unsigned NOT NULL auto_increment,
  `g_title` varchar(50) NOT NULL default '',
  `g_user_title` varchar(50) default NULL,
  `g_moderator` tinyint(1) NOT NULL default '0',
  `g_mod_edit_users` tinyint(1) NOT NULL default '0',
  `g_mod_rename_users` tinyint(1) NOT NULL default '0',
  `g_mod_change_passwords` tinyint(1) NOT NULL default '0',
  `g_mod_ban_users` tinyint(1) NOT NULL default '0',
  `g_read_board` tinyint(1) NOT NULL default '1',
  `g_view_users` tinyint(1) NOT NULL default '1',
  `g_post_replies` tinyint(1) NOT NULL default '1',
  `g_post_topics` tinyint(1) NOT NULL default '1',
  `g_edit_posts` tinyint(1) NOT NULL default '1',
  `g_delete_posts` tinyint(1) NOT NULL default '1',
  `g_delete_topics` tinyint(1) NOT NULL default '1',
  `g_set_title` tinyint(1) NOT NULL default '1',
  `g_search` tinyint(1) NOT NULL default '1',
  `g_search_users` tinyint(1) NOT NULL default '1',
  `g_send_email` tinyint(1) NOT NULL default '1',
  `g_post_flood` smallint(6) NOT NULL default '30',
  `g_search_flood` smallint(6) NOT NULL default '30',
  `g_email_flood` smallint(6) NOT NULL default '60',
  `g_pun_attachment_allow_download` tinyint(1) default '1',
  `g_pun_attachment_allow_upload` tinyint(1) default '1',
  `g_pun_attachment_allow_delete` tinyint(1) default '0',
  `g_pun_attachment_allow_delete_own` tinyint(1) default '1',
  `g_pun_attachment_upload_max_size` int(10) default '2000000',
  `g_pun_attachment_files_per_post` tinyint(3) default '1',
  `g_pun_attachment_disallowed_extensions` text,
  PRIMARY KEY  (`g_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;
");
// Dumping data for table `PLA_groups`

mysqli_query($iconnect,"INSERT INTO `PLA_groups` VALUES(1, 'Administrators', 'Administrator', 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 0, -1, '');");
mysqli_query($iconnect,"INSERT INTO `PLA_groups` VALUES(2, 'Guest', NULL, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 60, 30, 0, 0, 0, 0, 0, 0, 0, '');");
mysqli_query($iconnect,"INSERT INTO `PLA_groups` VALUES(3, 'Members', NULL, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 60, 30, 60, 1, 1, 0, 1, 2000000, 1, NULL);");
mysqli_query($iconnect,"INSERT INTO `PLA_groups` VALUES(4, 'Moderators', 'Moderator', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 2000000, 1, NULL);");
mysqli_query($iconnect,"INSERT INTO `PLA_groups` VALUES(5, 'Affiliate', NULL, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 30, 30, 60, 1, 1, 0, 1, 2000000, 1, NULL);");

// ------------------------------------------------------
// Table structure for table `PLA_online`

mysqli_query($iconnect,"CREATE TABLE`PLA_online` (
  `user_id` int(10) unsigned NOT NULL default '1',
  `ident` varchar(200) NOT NULL default '',
  `logged` int(10) unsigned NOT NULL default '0',
  `idle` tinyint(1) NOT NULL default '0',
  `csrf_token` varchar(40) NOT NULL default '',
  `prev_url` varchar(255) default NULL,
  `last_post` int(10) unsigned default NULL,
  `last_search` int(10) unsigned default NULL,
  UNIQUE KEY `PLA_online_user_id_ident_idx` (`user_id`,`ident`(40)),
  KEY `PLA_online_ident_idx` (`ident`(40)),
  KEY `PLA_online_logged_idx` (`logged`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
");
// ------------------------------------------------------
// Table structure for table `PLA_posts`

mysqli_query($iconnect,"CREATE TABLE`PLA_posts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `poster` varchar(200) NOT NULL default '',
  `poster_id` int(10) unsigned NOT NULL default '1',
  `poster_ip` varchar(39) default NULL,
  `poster_email` varchar(80) default NULL,
  `message` text,
  `hide_smilies` tinyint(1) NOT NULL default '0',
  `posted` int(10) unsigned NOT NULL default '0',
  `edited` int(10) unsigned default NULL,
  `edited_by` varchar(200) default NULL,
  `topic_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `PLA_posts_topic_id_idx` (`topic_id`),
  KEY `PLA_posts_multi_idx` (`poster_id`,`topic_id`),
  KEY `PLA_posts_posted_idx` (`posted`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;
");

// ------------------------------------------------------
// Table structure for table `PLA_pun_pm_messages`

mysqli_query($iconnect,"CREATE TABLE`PLA_pun_pm_messages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sender_id` int(10) unsigned NOT NULL default '0',
  `receiver_id` int(10) unsigned default NULL,
  `lastedited_at` int(10) unsigned NOT NULL default '0',
  `read_at` int(10) unsigned NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `body` text NOT NULL,
  `status` varchar(9) NOT NULL default 'draft',
  `deleted_by_sender` tinyint(1) NOT NULL default '0',
  `deleted_by_receiver` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `PLA_pun_pm_messages_sender_id_idx` (`sender_id`),
  KEY `PLA_pun_pm_messages_receiver_id_idx` (`receiver_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;
");
// Dumping data for table `PLA_pun_pm_messages`

// ------------------------------------------------------
// Table structure for table `PLA_ranks`

mysqli_query($iconnect,"CREATE TABLE`PLA_ranks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `rank` varchar(50) NOT NULL default '',
  `min_posts` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
");
// Dumping data for table `PLA_ranks`

mysqli_query($iconnect,"INSERT INTO `PLA_ranks` VALUES(1, 'New member', 0);");
mysqli_query($iconnect,"INSERT INTO `PLA_ranks` VALUES(2, 'Member', 10);");

// ------------------------------------------------------
// Table structure for table `PLA_reports`

mysqli_query($iconnect,"CREATE TABLE`PLA_reports` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `post_id` int(10) unsigned NOT NULL default '0',
  `topic_id` int(10) unsigned NOT NULL default '0',
  `forum_id` int(10) unsigned NOT NULL default '0',
  `reported_by` int(10) unsigned NOT NULL default '0',
  `created` int(10) unsigned NOT NULL default '0',
  `message` text,
  `zapped` int(10) unsigned default NULL,
  `zapped_by` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `PLA_reports_zapped_idx` (`zapped`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
");

// ------------------------------------------------------
// Table structure for table `PLA_search_cache`

mysqli_query($iconnect,"CREATE TABLE`PLA_search_cache` (
  `id` int(10) unsigned NOT NULL default '0',
  `ident` varchar(200) NOT NULL default '',
  `search_data` text,
  PRIMARY KEY  (`id`),
  KEY `PLA_search_cache_ident_idx` (`ident`(8))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
// ------------------------------------------------------
// Table structure for table `PLA_search_matches`

mysqli_query($iconnect,"CREATE TABLE`PLA_search_matches` (
  `post_id` int(10) unsigned NOT NULL default '0',
  `word_id` int(10) unsigned NOT NULL default '0',
  `subject_match` tinyint(1) NOT NULL default '0',
  KEY `PLA_search_matches_word_id_idx` (`word_id`),
  KEY `PLA_search_matches_post_id_idx` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");

// ------------------------------------------------------
// Table structure for table `PLA_search_words`

mysqli_query($iconnect,"CREATE TABLE`PLA_search_words` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `word` varchar(20) character set utf8 collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`word`),
  KEY `PLA_search_words_id_idx` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=670 ;
");

// ------------------------------------------------------
// Table structure for table `PLA_subscriptions`

mysqli_query($iconnect,"CREATE TABLE`PLA_subscriptions` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `topic_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");

// ------------------------------------------------------
// Table structure for table `PLA_topics`

mysqli_query($iconnect,"CREATE TABLE`PLA_topics` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `poster` varchar(200) NOT NULL default '',
  `subject` varchar(255) NOT NULL default '',
  `posted` int(10) unsigned NOT NULL default '0',
  `first_post_id` int(10) unsigned NOT NULL default '0',
  `last_post` int(10) unsigned NOT NULL default '0',
  `last_post_id` int(10) unsigned NOT NULL default '0',
  `last_poster` varchar(200) default NULL,
  `num_views` mediumint(8) unsigned NOT NULL default '0',
  `num_replies` mediumint(8) unsigned NOT NULL default '0',
  `closed` tinyint(1) NOT NULL default '0',
  `sticky` tinyint(1) NOT NULL default '0',
  `moved_to` int(10) unsigned default NULL,
  `forum_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `PLA_topics_forum_id_idx` (`forum_id`),
  KEY `PLA_topics_moved_to_idx` (`moved_to`),
  KEY `PLA_topics_last_post_idx` (`last_post`),
  KEY `PLA_topics_first_post_id_idx` (`first_post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;
");
// ------------------------------------------------------
// Table structure for table `PLA_users`

mysqli_query($iconnect,"CREATE TABLE`PLA_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned NOT NULL default '3',
  `username` varchar(200) NOT NULL default '',
  `password` varchar(40) NOT NULL default '',
  `salt` varchar(12) default NULL,
  `email` varchar(80) NOT NULL default '',
  `title` varchar(50) default NULL,
  `realname` varchar(40) default NULL,
  `url` varchar(100) default NULL,
  `facebook` varchar(100) default NULL,
  `twitter` varchar(100) default NULL,
  `linkedin` varchar(100) default NULL,
  `skype` varchar(100) default NULL,
  `jabber` varchar(80) default NULL,
  `icq` varchar(12) default NULL,
  `msn` varchar(80) default NULL,
  `aim` varchar(30) default NULL,
  `yahoo` varchar(30) default NULL,
  `location` varchar(30) default NULL,
  `signature` text,
  `disp_topics` tinyint(3) unsigned default NULL,
  `disp_posts` tinyint(3) unsigned default NULL,
  `email_setting` tinyint(1) NOT NULL default '1',
  `notify_with_post` tinyint(1) NOT NULL default '0',
  `auto_notify` tinyint(1) NOT NULL default '0',
  `show_smilies` tinyint(1) NOT NULL default '1',
  `show_img` tinyint(1) NOT NULL default '1',
  `show_img_sig` tinyint(1) NOT NULL default '1',
  `show_avatars` tinyint(1) NOT NULL default '1',
  `show_sig` tinyint(1) NOT NULL default '1',
  `access_keys` tinyint(1) NOT NULL default '0',
  `timezone` float NOT NULL default '0',
  `dst` tinyint(1) NOT NULL default '0',
  `time_format` int(10) unsigned NOT NULL default '0',
  `date_format` int(10) unsigned NOT NULL default '0',
  `language` varchar(25) NOT NULL default 'English',
  `style` varchar(25) NOT NULL default 'Oxygen',
  `num_posts` int(10) unsigned NOT NULL default '0',
  `last_post` int(10) unsigned default NULL,
  `last_search` int(10) unsigned default NULL,
  `last_email_sent` int(10) unsigned default NULL,
  `registered` int(10) unsigned NOT NULL default '0',
  `registration_ip` varchar(39) NOT NULL default '0.0.0.0',
  `last_visit` int(10) unsigned NOT NULL default '0',
  `admin_note` varchar(30) default NULL,
  `activate_string` varchar(80) default NULL,
  `activate_key` varchar(8) default NULL,
  `avatar` tinyint(3) unsigned NOT NULL default '0',
  `avatar_width` tinyint(3) unsigned NOT NULL default '0',
  `avatar_height` tinyint(3) unsigned NOT NULL default '0',
  `pun_pm_new_messages` int(10) default NULL,
  `pun_pm_long_subject` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `PLA_users_registered_idx` (`registered`),
  KEY `PLA_users_username_idx` (`username`(8))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;
");
// Dumping data for table `PLA_users`

mysqli_query($iconnect,"INSERT INTO `PLA_users` VALUES(1, 2, 'Guest', '68f32b5f0943904f5eac13096f25d756', NULL, 'arcade@MyDomain.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 'English', 'Oxygen', 4, 1562273690, NULL, NULL, 1561663153, '127.0.0.1', 1564352562, NULL, NULL, NULL, 2, 60, 60, NULL, 1);");
mysqli_query($iconnect,"INSERT INTO `PLA_users` VALUES(2, 1, 'Admin', '0c7540eb7e65b553ec1ba6b20de79608', NULL, 'arcade@MyDomain.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, 0, 1, 1, 0, -5, 1, 0, 0, 'English', 'Oxygen', 4, 1561823556, NULL, NULL, 1561663153, '127.0.0.1', 1564407011, NULL, NULL, NULL, 1, 60, 60, 1, 1);");
mysqli_query($iconnect,"INSERT INTO `PLA_users` VALUES(3, 3, 'user', '68f32b5f0943904f5eac13096f25d756', NULL, 'arcade@MyDomain.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 'English', 'Oxygen', 4, 1562273690, NULL, NULL, 1561663153, '127.0.0.1', 1564352562, NULL, NULL, NULL, 2, 60, 60, NULL, 1);");

// Writing to the conf.
$conf=@fopen('arcade_conf.php', 'w');

$goforit = @fwrite($conf,"<?php\n\$maintenance='0';\n\$notinstalled='0';\n\$settings['enable_onlinelist']='1';\n\$settings['enable_passrecovery']='1';\n\$settings['enable_shoutbox']='1';\n\$settings['enable_logo']='0';\n\$settings['enable_timer']='0';\n\$settings['allow_comments']='1';\n\$settings['show_announcement']='0';\n\$settings['show_stats_table']='1';\n\$settings['disable_reg']='0';\n\$settings['enable_validation']='0';\n\$settings['use_cheat_protect']='0';\n\$settings['upload_av_max_size']='0';\n\$settings['use_seccode']='1';\n\$settings['allow_guests']='1';\n\$settings['override_userprefs']='0';\n\$settings['arcade_title']='Practical Lightning Arcade [PLA v1.0 beta]';\n\$settings['datestamp']='jS F Y - h:i A';\n\$settings['online_list_dur']='60';\n\$settings['timezone']='America/New_York';\n\$settings['num_pages_of']='10';\n\$settings['ng_num']='20';\n\$settings['ls_num']='14';\n\$settings['bp_num']='10';\n\$settings['catdiv']='80';\n\$settings['catimg']='60';\n\$settings['banned_mails']='';\n\$settings['banned_usernames']='Tasos,TasosP13';\n\$settings['upload_av_max_size']='200000';\n\$phpmyadminloc='';\n\$textloc='flat';\n\$AnnounceFile='announce.php';\n\$imgloc='images';\n\$catloc='categories';\n\$avatarloc='avatars';\n\$useravasloc='useravatars';\n\$smiliesloc='emoticons';\n\$bannerloc='images/banners';\n\$themesloc='skins';\n\$gamesloc='arcade';\n\$arcurl='".$SiteURL."';\n\$arcgreet='Welcome to the Practical Lightning Arcade (BETA)';\n\$ResetTime ='2025,02,31,20,01,0';\n\$toetag='mornoovening-sm.gif';\n\$adminplayas='admin';\n\$siteemail='arcade@MyNewArcade.tld';\n\$BCCcatchall='ArcadeMember@MyNewArcade.tld';\n\$dbhost='".$dbhost."';\n\$dbuser='".$dbuser."';\n\$dbpass='".$dbpass."';\n\$dbname='".$dbname."';\n?>");

if(!$goforit) { 
message("arcade_conf.php could not be opened for writing. Please check the permissions.","Failed to write to conf");
}else{
message("Your new arcade is installed! Congratulations! <a href='index.php'>Click here to get started</a>. <br /><br /><br /><font color='red'>Login with the name: <u>admin</u> and password of: <u>admin</u>. <i>Change this password</i> when you login! You may also change your name if you like.</font><br /><br /><H1>DELETE THIS INSTALL.PHP NOW</H1>","Complete");
}
}

?>
<form action='PLArcade_v2.0-Install.php?step=2' method='POST'>
<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><td width='60%' align='center' class='headertableblock'>Database Details</td><td width='60%' align='center' class='headertableblock'></td><tr>
<tr><td class='arcade1' align='left'><b>Enter your database host:</b><br /></td><td class='arcade1' align='left'><input type='text' name='mysqli_host' value ='localhost' /></td></tr><tr><td class='arcade1' align='left'><b>Enter your database name:</b></td><td class='arcade1' align='left'><input type='text' name='mysqli_dbname' value='' /></td></tr><tr><td class='arcade1'><b>Enter your MySQL Username:</b></td><td class='arcade1'><input type='text' name='mysqli_dbuser' value='' /></td></tr><tr><td class='arcade1' align='left'><b>Password:</b></td><td class='arcade1' align='left'><input type='password' name='mysqli_dbpass' value='' /></td></tr><tr><td class='arcade1' align='left'><b>Site URL:</b> Web Address of your arcade (no trailing slash)</td><td class='arcade1' align='left'><input type='text' name='SiteURL' value='http://MySite.tld/PLArcade' /></td></tr></div></td>

<tr><td class=headertableblock colspan='2'><div align='center'><input type='submit' name='postDB' value='Install to Database' /></div></td></tr>


</table></div>
<br />
</form>


<?php
}
?>
<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1'><?php echo date('md')=='0401'?'Gilligans Arcade':'<b>Practical-Lightning-Arcade [PLA] 2.0 </b> (ALPHA)'; ?> based on <b>PHP-Quick-Arcade 3.0</b> &copy; <a href='http://Jcink.com'>Jcink.com</a><br />JS By: <a href='http://seanj.jcink.com'>SeanJ</a>. -  Heavily Modified by <font size='2' face='Lucida Console'><b><a href='http://www.practicallightning.com' target='_blank'>practical<sub><img src='http://infinitelyremote.com/image-box/PL_logo_sm.gif' alt='PracticalLightning.com' border='0'></sub>lightning</a></b></font> Web Design [<i><a title='DeBurger Photo Image &amp; Design'>DPI&ampD</a></i>]</td></tr></table></div></div><br />
</body>
</html>
