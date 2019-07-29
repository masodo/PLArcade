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

if(!$failure)  { echo "<br /><br /><a href='PLArcade_v1.0-Install.php?step=2'>Proceed.</a>"; } else {
echo "The check has failed. If you know the files are chmodded, please proceeed. if not, you MUST chmod them.<br /><br />"; 

echo "<a href='PLArcade_v1.0-Install.php?step=2'>Proceed anyway...</a>";
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

mysqli_query("SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';");


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

//
// Database: `PLArcade`
//
 
// ------------------------------------------------------//
 

// Table structure for table `phpqa_accounts`

mysqli_query("CREATE TABLE`phpqa_accounts` (
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

mysqli_query("CREATE TABLE`phpqa_affiliate` (
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

mysqli_query("INSERT INTO `phpqa_affiliate` VALUES(6, 'DeBurgerGameRoom.gif', 'http://DeBurger.com/ARCADE ', 'The DeBurger Game Room', 5, '', 0, 1);");
mysqli_query("INSERT INTO `phpqa_affiliate` VALUES(10, 'PLA.jpg', 'http://practicallightning.com/ARCADE/', 'PracticalLightning Arcade', 1, 'cERSbvd', 0, 1);");

// ------------------------------------------------------
// Table structure for table `phpqa_cats`

mysqli_query("CREATE TABLE`phpqa_cats` (
  `id` int(11) NOT NULL auto_increment,
  `cat` varchar(15) default NULL,
  `displayorder` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;
");
// Dumping data for table `phpqa_cats`

mysqli_query("INSERT INTO `phpqa_cats` VALUES(1, 'New', 1);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(2, 'Dead', 50);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(3, 'Pinball', 7);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(4, 'Arcade', 2);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(5, 'Word Game', 8);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(6, 'Other', 9);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(7, 'Mahjongg', 6);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(8, 'Board', 17);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(9, 'Table Game', 15);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(10, 'Slots', 10);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(11, 'Dice', 11);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(12, 'Match', 5);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(13, 'Hidden Object', 16);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(14, 'Spot Difference', 14);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(15, 'Escape', 13);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(16, 'No Score', 20);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(17, 'Cards', 3);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(18, 'Sports', 12);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(19, 'Physics', 18);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(20, 'DOS', 21);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(21, 'Slingo', 4);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(23, 'Testing', 22);");
mysqli_query("INSERT INTO `phpqa_cats` VALUES(24, 'Platform', 7);");

// ------------------------------------------------------
// Table structure for table `phpqa_emotes`

mysqli_query("CREATE TABLE`phpqa_emotes` (
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
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(1, '1.gif', ':)', 'basic smiley', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(2, '10.gif', ':p', 'toungue out', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(3, '11.gif', ':sweat:', 'sweat', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(4, '14.gif', '>.<', 'grimmace', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(5, '3.gif', ':(', 'sad face', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(6, '5.gif', '[:D]', 'grin', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(7, 'wavey.gif', '[wavey]', 'wavey guy', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(8, 'angry.gif', 'angry', 'angry face', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(9, 'th_computerbrain.gif', 'hack', 'hacking', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(10, 'question.gif', '[quest]', 'guestion', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(11, 'hi.gif', '[hi]', 'Hi', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(12, 'thumbsup.gif', '[thumbup]', 'thumbs up', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(13, 'SM074.gif', '!@#$%', 'cussing', 1);");
mysqli_query("INSERT INTO `phpqa_emotes` VALUES(14, 'SM039.gif', 'OhYeah', 'Happy Nanna Dance', 1);");
// ------------------------------------------------------
// Table structure for table `phpqa_games`

mysqli_query("CREATE TABLE`phpqa_games` (
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
mysqli_query("INSERT INTO `phpqa_games`  (
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
mysqli_query("INSERT INTO `phpqa_games` VALUES(2, 'Tetris', 'Tetris', 381, 400, 'Make rows of blocks but dont overload the screen.', 4, '', '', NULL, NULL, 'HI', 'FL', NULL, NULL);");
mysqli_query("INSERT INTO `phpqa_games`  (
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
mysqli_query("INSERT INTO `phpqa_games`  (
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
mysqli_query("INSERT INTO `phpqa_games`  (
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
mysqli_query("INSERT INTO `phpqa_games`  (
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
mysqli_query("INSERT INTO `phpqa_games`  (
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
mysqli_query("INSERT INTO `phpqa_games`  (
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
mysqli_query("INSERT INTO `phpqa_games`  (
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
mysqli_query("INSERT INTO `phpqa_games`  (
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

mysqli_query("INSERT INTO `phpqa_accounts` (`id`, `name`, `pass`, `email`, `ipaddress`, `avatar`, `group`, `skin`, `settings`, `logins`) VALUES(1, 'Admin', '0c7540eb7e65b553ec1ba6b20de79608', 'admin@localhost', '{$_SERVER['REMOTE_ADDR']}', '', 'Admin', 'Default', '', 0);");
mysqli_query("INSERT INTO `phpqa_accounts` (`id`, `name`, `pass`, `email`, `ipaddress`, `avatar`, `group`, `skin`, `settings`, `logins`) VALUES(45, 'user', '68f32b5f0943904f5eac13096f25d756', 'admin@localhost', '{$_SERVER['REMOTE_ADDR']}', '', 'Member', 'Default', '', 0);");

// Table structure for table `phpqa_leaderboard`

mysqli_query("CREATE TABLE`phpqa_leaderboard` (
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

mysqli_query("CREATE TABLE`phpqa_logs` (
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

mysqli_query("CREATE TABLE`phpqa_scores` (
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

mysqli_query("CREATE TABLE`phpqa_sessions` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `time` varchar(255) NOT NULL default '',
  `location` varchar(255) NOT NULL default '',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3083 ;
");
// ------------------------------------------------------
// Table structure for table `phpqa_shoutbox`

mysqli_query("CREATE TABLE`phpqa_shoutbox` (
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

mysqli_query("CREATE TABLE`phpqa_tournaments` (
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

mysqli_query("CREATE TABLE`phpqa_wall` (
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

mysqli_query("CREATE TABLE`PLA_attach_files` (
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

mysqli_query("CREATE TABLE`PLA_bans` (
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

mysqli_query("CREATE TABLE`PLA_categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `cat_name` varchar(80) NOT NULL default 'New Category',
  `disp_position` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
");
// Dumping data for table `PLA_categories`

mysqli_query("INSERT INTO `PLA_categories` VALUES(3, 'General Discussion', 2);");
// ------------------------------------------------------
// Table structure for table `PLA_censoring`

mysqli_query("CREATE TABLE`PLA_censoring` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `search_for` varchar(60) NOT NULL default '',
  `replace_with` varchar(60) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
");
// ------------------------------------------------------
// Table structure for table `PLA_config`

mysqli_query("CREATE TABLE`PLA_config` (
  `conf_name` varchar(255) NOT NULL default '',
  `conf_value` text,
  PRIMARY KEY  (`conf_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
// Dumping data for table `PLA_config`

mysqli_query("INSERT INTO `PLA_config` VALUES('o_cur_version', '1.4.4');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_database_revision', '5');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_board_title', 'PracticalLightning Arcade - Forum');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_board_desc', 'Forum for Members of PracticalLightning Arcade');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_default_timezone', '-5');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_time_format', 'H:i:s');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_date_format', 'Y-m-d');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_check_for_updates', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_check_for_versions', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_timeout_visit', '5400');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_timeout_online', '300');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_redirect_delay', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_show_version', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_show_user_info', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_show_post_count', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_signatures', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_smilies', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_smilies_sig', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_make_links', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_default_lang', 'English');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_default_style', 'Oxygen');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_default_user_group', '3');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_topic_review', '15');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_disp_topics_default', '30');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_disp_posts_default', '25');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_indent_num_spaces', '4');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_quote_depth', '3');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_quickpost', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_users_online', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_censoring', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_ranks', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_show_dot', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_topic_views', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_quickjump', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_gzip', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_additional_navlinks', '1 = <a href="/ARCADE/">ARCADE</a>');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_report_method', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_regs_report', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_default_email_setting', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_mailing_list', 'arcade@MyDomain.com');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_avatars', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_avatars_dir', 'img/avatars');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_avatars_width', '60');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_avatars_height', '60');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_avatars_size', '15360');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_search_all_forums', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_sef', 'Default');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_admin_email', 'arcade@MyDomain.com');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_webmaster_email', 'arcade@MyDomain.com');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_subscriptions', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_smtp_host', NULL);");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_smtp_user', NULL);");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_smtp_pass', NULL);");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_smtp_ssl', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_regs_allow', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_regs_verify', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_announcement', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_announcement_heading', 'Sample announcement');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_announcement_message', '<p>Enter your announcement here.</p>');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_rules', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_rules_message', 'Enter your rules here.');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_maintenance', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_maintenance_message', 'The forums are temporarily down for maintenance. Please try again in a few minutes.<br /><br />Administrator');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_default_dst', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('p_message_bbcode', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('p_message_img_tag', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('p_message_all_caps', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('p_subject_all_caps', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('p_sig_all_caps', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('p_sig_bbcode', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('p_sig_img_tag', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('p_sig_length', '400');");
mysqli_query("INSERT INTO `PLA_config` VALUES('p_sig_lines', '4');");
mysqli_query("INSERT INTO `PLA_config` VALUES('p_allow_banned_email', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('p_allow_dupe_email', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('p_force_guest_email', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_show_moderators', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_mask_passwords', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_pun_pm_inbox_size', '100');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_pun_pm_outbox_size', '100');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_pun_pm_show_new_count', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('o_pun_pm_show_global_link', '0');");
mysqli_query("INSERT INTO `PLA_config` VALUES('attach_always_deny', 'html,htm,php,php3,php4,exe,com,bat');");
mysqli_query("INSERT INTO `PLA_config` VALUES('attach_basefolder', 'extensions/pun_attachment/attachments/');");
mysqli_query("INSERT INTO `PLA_config` VALUES('attach_create_orphans', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('attach_icon_folder', '/FORUM/extensions/pun_attachment/img/');");
mysqli_query("INSERT INTO `PLA_config` VALUES('attach_icon_extension', 'txt,doc,pdf,wav,mp3,ogg,avi,mpg,mpeg,png,jpg,jpeg,gif');");
mysqli_query("INSERT INTO `PLA_config` VALUES('attach_icon_name', 'text.png,doc.png,doc.png,audio.png,audio.png,audio.png,video.png,video.png,video.png,image.png,image.png,image.png,image.png');");
mysqli_query("INSERT INTO `PLA_config` VALUES('attach_subfolder', '7e72976a5a799fec1ef6e246f8cbb17b');");
mysqli_query("INSERT INTO `PLA_config` VALUES('attach_use_icon', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('attach_disp_small', '1');");
mysqli_query("INSERT INTO `PLA_config` VALUES('attach_small_height', '60');");
mysqli_query("INSERT INTO `PLA_config` VALUES('attach_small_width', '60');");
mysqli_query("INSERT INTO `PLA_config` VALUES('attach_disable_attach', '0');");

// ------------------------------------------------------
// Table structure for table `PLA_extensions`

mysqli_query("CREATE TABLE`PLA_extensions` (
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
// Dumping data for table `PLA_extensions`

mysqli_query("INSERT INTO `PLA_extensions` VALUES('pun_pm', 'Private Messaging', '2.4.2', 'Allows users to send and receive private messages.', 'PunBB Development Team', '// Delete extension options from the config\n		forum_config_remove(array(\n			''o_pun_pm_outbox_size'',\n			''o_pun_pm_inbox_size'',\n			''o_pun_pm_show_new_count'',\n			''o_pun_pm_show_global_link''));\n\n		$forum_db->drop_table(''pun_pm_messages'');\n\n		$forum_db->drop_field(''users'', ''pun_pm_new_messages'');\n		$forum_db->drop_field(''users'', ''pun_pm_long_subject'');', 'WARNING! All users messages will be removed during the uninstall process. It is strongly recommended you to disable "Private Messages" extension instead or to upgrade it without uninstalling.', 0, '||');");
mysqli_query("INSERT INTO `PLA_extensions` VALUES('pun_attachment', 'Attachment', '1.1.19', 'Allows users to attach files to posts.', 'PunBB Development Team', '$attached_files = scandir(FORUM_ROOT.$forum_config[''attach_basefolder''].$forum_config[''attach_subfolder''].DIRECTORY_SEPARATOR);\n		foreach ($attached_files as $file)\n			if ($file != ''.'' && $file != ''..'')\n				unlink(FORUM_ROOT.$forum_config[''attach_basefolder''].$forum_config[''attach_subfolder''].DIRECTORY_SEPARATOR.$file);\n		rmdir(FORUM_ROOT.$forum_config[''attach_basefolder''].$forum_config[''attach_subfolder'']);\n\n		$forum_db->drop_table(''attach_files'');\n		$forum_db->drop_field(''groups'', ''g_pun_attachment_allow_download'');\n		$forum_db->drop_field(''groups'', ''g_pun_attachment_allow_upload'');\n		$forum_db->drop_field(''groups'', ''g_pun_attachment_allow_delete'');\n		$forum_db->drop_field(''groups'', ''g_pun_attachment_allow_delete_own'');\n		$forum_db->drop_field(''groups'', ''g_pun_attachment_upload_max_size'');\n		$forum_db->drop_field(''groups'', ''g_pun_attachment_files_per_post'');\n		$forum_db->drop_field(''groups'', ''g_pun_attachment_disallowed_extensions'');\n\n		forum_config_remove(array(''attach_always_deny'', ''attach_basefolder'', ''attach_create_orphans'', ''attach_cur_version'', ''attach_icon_folder'', ''attach_icon_extension'', ''attach_icon_name'', ''attach_subfolder'', ''attach_disable_attach'', ''attach_disp_small'', ''attach_small_height'', ''attach_small_width'', ''attach_use_icon''));', 'WARNING: all users'' attachments will be removed during the uninstallation process. It is recommended that you disable the "pun_attachment" extension instead, or upgrade it without uninstalling.', 0, '||');");

// ------------------------------------------------------
// Table structure for table `PLA_extension_hooks`

mysqli_query("CREATE TABLE`PLA_extension_hooks` (
  `id` varchar(150) NOT NULL default '',
  `extension_id` varchar(50) NOT NULL default '',
  `code` text,
  `installed` int(10) unsigned NOT NULL default '0',
  `priority` tinyint(1) unsigned NOT NULL default '5',
  PRIMARY KEY  (`id`,`extension_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
// Dumping data for table `PLA_extension_hooks`

mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('pf_change_details_settings_validation', 'pun_pm', '// Validate option ''quote beginning of message''\n			if (!isset($_POST[''form''][''pun_pm_long_subject'']) || $_POST[''form''][''pun_pm_long_subject''] != ''1'')\n				$form[''pun_pm_long_subject''] = ''0'';\n			else\n				$form[''pun_pm_long_subject''] = ''1'';', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('pf_change_details_settings_email_fieldset_end', 'pun_pm', '// Per-user option ''quote beginning of message''\nif ($forum_config[''p_message_bbcode''] == ''1'')\n{\n	if (!isset($lang_pun_pm))\n	{\n		if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n			include $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n		else\n			include $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n	}\n\n	$forum_page[''item_count''] = 0;\n\n?>\n			<fieldset class="frm-group group<?php echo ++$forum_page[''group_count''] ?>">\n				<legend class="group-legend"><strong><?php echo $lang_pun_pm[''PM settings''] ?></strong></legend>\n				<fieldset class="mf-set set<?php echo ++$forum_page[''item_count''] ?>">\n					<legend><span><?php echo $lang_pun_pm[''Private messages''] ?></span></legend>\n					<div class="mf-box">\n						<div class="mf-item">\n							<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[''fld_count''] ?>" name="form[pun_pm_long_subject]" value="1"<?php if ($user[''pun_pm_long_subject''] == ''1'') echo '' checked="checked"'' ?> /></span>\n							<label for="fld<?php echo $forum_page[''fld_count''] ?>"><?php echo $lang_pun_pm[''Begin message quote''] ?></label>\n						</div>\n					</div>\n				</fieldset>\n<?php ($hook = get_hook(''pun_pm_pf_change_details_settings_pre_pm_settings_fieldset_end'')) ? eval($hook) : null; ?>\n			</fieldset>\n<?php\n}\nelse\n	echo "\\t\\t\\t".''<input type="hidden" name="form[pun_pm_long_subject]" value="''.$user[''pun_pm_long_subject''].''" />''."\\n";', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('hd_head', 'pun_pm', '// Incuding styles for pun_pm\n			if (defined(''FORUM_PAGE'') && ''pun_pm'' == substr(FORUM_PAGE, 0, 6))\n			{\n				if ($forum_user[''style''] != ''Oxygen'' && file_exists($ext_info[''path''].''/css/''.$forum_user[''style''].''/pun_pm.min.css''))\n					$forum_loader->add_css($ext_info[''url''].''/css/''.$forum_user[''style''].''/pun_pm.min.css'', array(''type'' => ''url'', ''media'' => ''screen''));\n				else\n					$forum_loader->add_css($ext_info[''url''].''/css/Oxygen/pun_pm.min.css'', array(''type'' => ''url'', ''media'' => ''screen''));\n			}', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('mi_new_action', 'pun_pm', 'if ($action == ''pun_pm_send'' && !$forum_user[''is_guest''])\n{\n	if(!defined(''PUN_PM_FUNCTIONS_LOADED''))\n		require $ext_info[''path''].''/functions.php'';\n\n	if (!isset($lang_pun_pm))\n	{\n		if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n			include $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n		else\n			include $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n	}\n\n	$pun_pm_body = isset($_POST[''req_message'']) ? $_POST[''req_message''] : '''';\n	$pun_pm_subject = isset($_POST[''pm_subject'']) ? $_POST[''pm_subject''] : '''';\n	$pun_pm_receiver_username = isset($_POST[''pm_receiver'']) ? $_POST[''pm_receiver''] : '''';\n	$pun_pm_message_id = isset($_POST[''message_id'']) ? (int) $_POST[''message_id''] : false;\n\n	if (isset($_POST[''send_action'']) && in_array($_POST[''send_action''], array(''send'', ''draft'', ''delete'', ''preview'')))\n		$pun_pm_send_action = $_POST[''send_action''];\n	elseif (isset($_POST[''pm_draft'']))\n		$pun_pm_send_action = ''draft'';\n	elseif (isset($_POST[''pm_send'']))\n		$pun_pm_send_action = ''send'';\n	elseif (isset($_POST[''pm_delete'']))\n		$pun_pm_send_action = ''delete'';\n	else\n		$pun_pm_send_action = ''preview'';\n\n	($hook = get_hook(''pun_pm_after_send_action_set'')) ? eval($hook) : null;\n\n	if ($pun_pm_send_action == ''draft'')\n	{\n		// Try to save the message as draft\n		// Inside this function will be a redirect, if everything is ok\n		$pun_pm_errors = pun_pm_save_message($pun_pm_body, $pun_pm_subject, $pun_pm_receiver_username, $pun_pm_message_id);\n		// Remember $pun_pm_message_id = false; inside this function if $pun_pm_message_id is incorrect\n\n		// Well... Go processing errors\n\n		// We need no preview\n		$pun_pm_msg_preview = false;\n	}\n	elseif ($pun_pm_send_action == ''send'')\n	{\n		// Try to send the message\n		// Inside this function will be a redirect, if everything is ok\n		$pun_pm_errors = pun_pm_send_message($pun_pm_body, $pun_pm_subject, $pun_pm_receiver_username, $pun_pm_message_id);\n		// Remember $pun_pm_message_id = false; inside this function if $pun_pm_message_id is incorrect\n\n		// Well... Go processing errors\n\n		// We need no preview\n		$pun_pm_msg_preview = false;\n	}\n	elseif ($pun_pm_send_action == ''delete'' && $pun_pm_message_id !== false)\n	{\n		pun_pm_delete_from_outbox(array($pun_pm_message_id));\n		redirect(forum_link($forum_url[''pun_pm_outbox'']), $lang_pun_pm[''Message deleted'']);\n	}\n	elseif ($pun_pm_send_action == ''preview'')\n	{\n		// Preview message\n		$pun_pm_errors = array();\n		$pun_pm_msg_preview = pun_pm_preview($pun_pm_receiver_username, $pun_pm_subject, $pun_pm_body, $pun_pm_errors);\n	}\n\n	($hook = get_hook(''pun_pm_new_send_action'')) ? eval($hook) : null;\n\n	$pun_pm_page_text = pun_pm_send_form($pun_pm_receiver_username, $pun_pm_subject, $pun_pm_body, $pun_pm_message_id, false, false, $pun_pm_msg_preview);\n\n	// Setup navigation menu\n	$forum_page[''main_menu''] = array(\n		''inbox''		=> ''<li class="first-item"><a href="''.forum_link($forum_url[''pun_pm_inbox'']).''"><span>''.$lang_pun_pm[''Inbox''].''</span></a></li>'',\n		''outbox''	=> ''<li><a href="''.forum_link($forum_url[''pun_pm_outbox'']).''"><span>''.$lang_pun_pm[''Outbox''].''</span></a></li>'',\n		''write''		=> ''<li class="active"><a href="''.forum_link($forum_url[''pun_pm_write'']).''"><span>''.$lang_pun_pm[''Compose message''].''</span></a></li>'',\n	);\n\n	// Setup breadcrumbs\n	$forum_page[''crumbs''] = array(\n		array($forum_config[''o_board_title''], forum_link($forum_url[''index''])),\n		array($lang_pun_pm[''Private messages''], forum_link($forum_url[''pun_pm''])),\n		array($lang_pun_pm[''Compose message''], forum_link($forum_url[''pun_pm_write'']))\n	);\n\n	($hook = get_hook(''pun_pm_pre_send_output'')) ? eval($hook) : null;\n\n	define(''FORUM_PAGE'', ''pun_pm-write'');\n	require FORUM_ROOT.''header.php'';\n\n	// START SUBST - <!// forum_main -->\n	ob_start();\n\n	echo $pun_pm_page_text;\n\n	$tpl_temp = trim(ob_get_contents());\n	$tpl_main = str_replace(''<!// forum_main -->'', $tpl_temp, $tpl_main);\n	ob_end_clean();\n	// END SUBST - <!// forum_main -->\n\n	require FORUM_ROOT.''footer.php'';\n}\n\n$section = isset($_GET[''section'']) ? $_GET[''section''] : null;\n\nif ($section == ''pun_pm'' && !$forum_user[''is_guest''])\n{\n	if (!isset($lang_pun_pm))\n	{\n		if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n			include $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n		else\n			include $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n	}\n\n	if (!defined(''PUN_PM_FUNCTIONS_LOADED''))\n		require $ext_info[''path''].''/functions.php'';\n\n	$pun_pm_page = isset($_GET[''pmpage'']) ? $_GET[''pmpage''] : '''';\n\n	($hook = get_hook(''pun_pm_pre_page_building'')) ? eval($hook) : null;\n\n	// pun_pm_get_page() performs everything :)\n	// Remember $pun_pm_page correction inside pun_pm_get_page() if this variable is incorrect\n	$pun_pm_page_text = pun_pm_get_page($pun_pm_page);\n\n	// Setup navigation menu\n	$forum_page[''main_menu''] = array(\n		''inbox''		=> ''<li class="first-item''.($pun_pm_page == ''inbox'' ? '' active'' : '''').''"><a href="''.forum_link($forum_url[''pun_pm_inbox'']).''"><span>''.$lang_pun_pm[''Inbox''].''</span></a></li>'',\n		''outbox''	=> ''<li''.(($pun_pm_page == ''outbox'') ? '' class="active"'' : '''').''><a href="''.forum_link($forum_url[''pun_pm_outbox'']).''"><span>''.$lang_pun_pm[''Outbox''].''</span></a></li>'',\n		''write''		=> ''<li''.(($pun_pm_page == ''write'' || $pun_pm_page == ''compose'') ? '' class="active"'' : '''').''><a href="''.forum_link($forum_url[''pun_pm_write'']).''"><span>''.$lang_pun_pm[''Compose message''].''</span></a></li>'',\n	);\n\n	// Setup breadcrumbs\n	$forum_page[''crumbs''] = array(\n		array($forum_config[''o_board_title''], forum_link($forum_url[''index''])),\n		array($lang_pun_pm[''Private messages''], forum_link($forum_url[''pun_pm'']))\n	);\n\n	if ($pun_pm_page == ''inbox'')\n		$forum_page[''crumbs''][] = array($lang_pun_pm[''Inbox''], forum_link($forum_url[''pun_pm_inbox'']));\n	else if ($pun_pm_page == ''outbox'')\n		$forum_page[''crumbs''][] = array($lang_pun_pm[''Outbox''], forum_link($forum_url[''pun_pm_outbox'']));\n	else if ($pun_pm_page == ''write'' || $pun_pm_page == ''compose'')\n		$forum_page[''crumbs''][] = array($lang_pun_pm[''Compose message''], forum_link($forum_url[''pun_pm_write'']));\n\n	($hook = get_hook(''pun_pm_pre_page_output'')) ? eval($hook) : null;\n\n	define(''FORUM_PAGE'', ''pun_pm-''.$pun_pm_page);\n	require FORUM_ROOT.''header.php'';\n\n	// START SUBST - <!// forum_main -->\n	ob_start();\n\n	echo $pun_pm_page_text;\n\n	$tpl_temp = trim(ob_get_contents());\n	$tpl_main = str_replace(''<!// forum_main -->'', $tpl_temp, $tpl_main);\n	ob_end_clean();\n	// END SUBST - <!// forum_main -->\n\n	require FORUM_ROOT.''footer.php'';\n}', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('aop_features_avatars_fieldset_end', 'pun_pm', '// Admin options\nif (!isset($lang_pun_pm))\n{\n	if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n		include $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n	else\n		include $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n}\n\n$forum_page[''group_count''] = $forum_page[''item_count''] = 0;\n\n?>\n			<div class="content-head">\n				<h2 class="hn"><span><?php echo $lang_pun_pm[''Features title''] ?></span></h2>\n			</div>\n			<fieldset class="frm-group group<?php echo ++$forum_page[''group_count''] ?>">\n				<legend class="group-legend"><span><?php echo $lang_pun_pm[''PM settings''] ?></span></legend>\n				<div class="sf-set set<?php echo ++$forum_page[''item_count''] ?>">\n					<div class="sf-box text">\n						<label for="fld<?php echo ++$forum_page[''fld_count''] ?>"><span><?php echo $lang_pun_pm[''Inbox limit''] ?></span><small><?php echo $lang_pun_pm[''Inbox limit info''] ?></small></label><br />\n						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[''fld_count''] ?>" name="form[pun_pm_inbox_size]" size="6" maxlength="6" value="<?php echo $forum_config[''o_pun_pm_inbox_size''] ?>" /></span>\n					</div>\n				</div>\n				<div class="sf-set set<?php echo ++$forum_page[''item_count''] ?>">\n					<div class="sf-box text">\n						<label for="fld<?php echo ++$forum_page[''fld_count''] ?>"><span><?php echo $lang_pun_pm[''Outbox limit''] ?></span><small><?php echo $lang_pun_pm[''Outbox limit info''] ?></small></label><br />\n						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[''fld_count''] ?>" name="form[pun_pm_outbox_size]" size="6" maxlength="6" value="<?php echo $forum_config[''o_pun_pm_outbox_size''] ?>" /></span>\n					</div>\n				</div>\n				<fieldset class="mf-set set<?php echo ++$forum_page[''item_count''] ?>">\n					<legend><span><?php echo $lang_pun_pm[''Navigation links''] ?></span></legend>\n					<div class="mf-box">\n						<div class="mf-item">\n							<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[''fld_count''] ?>" name="form[pun_pm_show_new_count]" value="1"<?php if ($forum_config[''o_pun_pm_show_new_count''] == ''1'') echo '' checked="checked"'' ?> /></span>\n							<label for="fld<?php echo $forum_page[''fld_count''] ?>"><?php echo $lang_pun_pm[''Snow new count''] ?></label>\n						</div>\n						<div class="mf-item">\n							<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[''fld_count''] ?>" name="form[pun_pm_show_global_link]" value="1"<?php if ($forum_config[''o_pun_pm_show_global_link''] == ''1'') echo '' checked="checked"'' ?> /></span>\n							<label for="fld<?php echo $forum_page[''fld_count''] ?>"><?php echo $lang_pun_pm[''Show global link''] ?></label>\n						</div>\n					</div>\n				</fieldset>\n<?php ($hook = get_hook(''pun_pm_aop_features_pre_pm_settings_fieldset_end'')) ? eval($hook) : null; ?>\n			</fieldset>\n<?php', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('aop_features_validation', 'pun_pm', '$form[''pun_pm_inbox_size''] = (!isset($form[''pun_pm_inbox_size'']) || (int) $form[''pun_pm_inbox_size''] <= 0) ? ''0'' : (string)(int) $form[''pun_pm_inbox_size''];\n			$form[''pun_pm_outbox_size''] = (!isset($form[''pun_pm_outbox_size'']) || (int) $form[''pun_pm_outbox_size''] <= 0) ? ''0'' : (string)(int) $form[''pun_pm_outbox_size''];\n\n			if (!isset($form[''pun_pm_show_new_count'']) || $form[''pun_pm_show_new_count''] != ''1'')\n				$form[''pun_pm_show_new_count''] = ''0'';\n\n			if (!isset($form[''pun_pm_show_global_link'']) || $form[''pun_pm_show_global_link''] != ''1'')\n				$form[''pun_pm_show_global_link''] = ''0'';\n\n			($hook = get_hook(''pun_pm_aop_features_validation_end'')) ? eval($hook) : null;', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('fn_delete_user_end', 'pun_pm', '$query = array(\n				''DELETE''	=> ''pun_pm_messages'',\n				''WHERE''		=> ''receiver_id = ''.$user_id.'' AND deleted_by_sender = 1''\n			);\n			$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);\n\n			$query = array(\n				''UPDATE''	=> ''pun_pm_messages'',\n				''SET''		=> ''deleted_by_receiver = 1'',\n				''WHERE''		=> ''receiver_id = ''.$user_id\n			);\n			$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('hd_visit_elements', 'pun_pm', '// ''New messages (N)'' link\n			if (!$forum_user[''is_guest''] && $forum_config[''o_pun_pm_show_new_count''])\n			{\n				global $lang_pun_pm;\n\n				if (!isset($lang_pun_pm))\n				{\n					if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n						include $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n					else\n						include $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n				}\n\n				// TODO: Do not include all functions, divide them into 2 files\n				if(!defined(''PUN_PM_FUNCTIONS_LOADED''))\n					require $ext_info[''path''].''/functions.php'';\n\n				($hook = get_hook(''pun_pm_hd_visit_elements_pre_change'')) ? eval($hook) : null;\n\n				//$visit_elements[''<!// forum_visit -->''] = preg_replace(''#(<p id="visit-links" class="options">.*?)(</p>)#'', ''$1 <span><a href="''.forum_link($forum_url[''pun_pm_inbox'']).''">''.pun_pm_unread_messages().''</a></span>$2'', $visit_elements[''<!// forum_visit -->'']);\n				if ($forum_user[''g_read_board''] == ''1'' && $forum_user[''g_search''] == ''1'')\n				{\n					$visit_links[''pun_pm''] = ''<span id="visit-pun_pm"><a href="''.forum_link($forum_url[''pun_pm_inbox'']).''">''.pun_pm_unread_messages().''</a></span>'';\n				}\n\n				($hook = get_hook(''pun_pm_hd_visit_elements_after_change'')) ? eval($hook) : null;\n			}', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('vt_row_pre_post_contacts_merge', 'pun_pm', 'global $lang_pun_pm;\n\n			if (!isset($lang_pun_pm))\n			{\n				if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n					include $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n				else\n					include $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n			}\n\n			($hook = get_hook(''pun_pm_pre_post_contacts_add'')) ? eval($hook) : null;\n\n			// Links ''Send PM'' near posts\n			if (!$forum_user[''is_guest''] && $cur_post[''poster_id''] > 1 && $forum_user[''id''] != $cur_post[''poster_id''])\n				$forum_page[''post_contacts''][''PM''] = ''<span class="contact"><a title="''.$lang_pun_pm[''Send PM''].''" href="''.forum_link($forum_url[''pun_pm_post_link''], $cur_post[''poster_id'']).''">''.$lang_pun_pm[''PM''].''</a></span>'';\n\n			($hook = get_hook(''pun_pm_after_post_contacts_add'')) ? eval($hook) : null;', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('fn_generate_navlinks_end', 'pun_pm', '// Link ''PM'' in the main nav menu\n			if (isset($links[''profile'']) && $forum_config[''o_pun_pm_show_global_link''])\n			{\n				global $lang_pun_pm;\n\n				if (!isset($lang_pun_pm))\n				{\n					if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n						include $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n					else\n						include $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n				}\n\n				if (''pun_pm'' == substr(FORUM_PAGE, 0, 6))\n					$links[''profile''] = str_replace('' class="isactive"'', '''', $links[''profile'']);\n\n				($hook = get_hook(''pun_pm_pre_main_navlinks_add'')) ? eval($hook) : null;\n\n				$links[''profile''] .= "\\n\\t\\t".''<li id="nav_pun_pm"''.(''pun_pm'' == substr(FORUM_PAGE, 0, 6) ? '' class="isactive"'' : '''').''><a href="''.forum_link($forum_url[''pun_pm'']).''"><span>''.$lang_pun_pm[''Private messages''].''</span></a></li>'';\n\n				($hook = get_hook(''pun_pm_after_main_navlinks_add'')) ? eval($hook) : null;\n			}', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('pf_view_details_pre_header_load', 'pun_pm', '// Link in the profile\n			if (!$forum_user[''is_guest''] && $forum_user[''id''] != $user[''id''])\n			{\n				if (!isset($lang_pun_pm))\n				{\n					if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n						include $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n					else\n						include $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n				}\n\n				($hook = get_hook(''pun_pm_pre_profile_user_contact_add'')) ? eval($hook) : null;\n\n				$forum_page[''user_contact''][''PM''] = ''<li><span>''.$lang_pun_pm[''PM''].'': <a href="''.forum_link($forum_url[''pun_pm_post_link''], $id).''">''.$lang_pun_pm[''Send PM''].''</a></span></li>'';\n\n				($hook = get_hook(''pun_pm_after_profile_user_contact_add'')) ? eval($hook) : null;\n			}', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('pf_change_details_about_pre_header_load', 'pun_pm', '// Link in the profile\n			if (!$forum_user[''is_guest''] && $forum_user[''id''] != $user[''id''])\n			{\n				if (!isset($lang_pun_pm))\n				{\n					if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n						include $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n					else\n						include $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n				}\n\n				($hook = get_hook(''pun_pm_pre_profile_user_contact_add'')) ? eval($hook) : null;\n\n				$forum_page[''user_contact''][''PM''] = ''<li><span>''.$lang_pun_pm[''PM''].'': <a href="''.forum_link($forum_url[''pun_pm_post_link''], $id).''">''.$lang_pun_pm[''Send PM''].''</a></span></li>'';\n\n				($hook = get_hook(''pun_pm_after_profile_user_contact_add'')) ? eval($hook) : null;\n			}', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('co_modify_url_scheme', 'pun_pm', 'if ($forum_config[''o_sef''] != ''Default'' && file_exists($ext_info[''path''].''/url/''.$forum_config[''o_sef''].''.php''))\n				require $ext_info[''path''].''/url/''.$forum_config[''o_sef''].''.php'';\n			else\n				require $ext_info[''path''].''/url/Default.php'';', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('re_rewrite_rules', 'pun_pm', '$forum_rewrite_rules[''/^pun_pm[\\/_-]?send(\\.html?|\\/)?$/i''] = ''misc.php?action=pun_pm_send'';\n			$forum_rewrite_rules[''/^pun_pm[\\/_-]?compose[\\/_-]?([0-9]+)(\\.html?|\\/)?$/i''] = ''misc.php?section=pun_pm&pmpage=compose&receiver_id=$1'';\n			$forum_rewrite_rules[''/^pun_pm(\\.html?|\\/)?$/i''] = ''misc.php?section=pun_pm'';\n			$forum_rewrite_rules[''/^pun_pm[\\/_-]?([0-9a-z]+)(\\.html?|\\/)?$/i''] = ''misc.php?section=pun_pm&pmpage=$1'';\n			$forum_rewrite_rules[''/^pun_pm[\\/_-]?([0-9a-z]+)[\\/_-]?(p|page\\/)([0-9]+)(\\.html?|\\/)?$/i''] = ''misc.php?section=pun_pm&pmpage=$1&p=$3'';\n			$forum_rewrite_rules[''/^pun_pm[\\/_-]?([0-9a-z]+)[\\/_-]?([0-9]+)(\\.html?|\\/)?$/i''] = ''misc.php?section=pun_pm&pmpage=$1&message_id=$2'';\n\n			($hook = get_hook(''pun_pm_after_rewrite_rules_set'')) ? eval($hook) : null;', 1561680139, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('agr_start', 'pun_attachment', 'require $ext_info[''path''].''/include/attach_func.php'';\n			if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n				require $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n			else\n				require $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('agr_add_edit_group_flood_fieldset_end', 'pun_attachment', '?>\n\n	<div class="content-head">\n		<h3 class="hn"><span><?php echo $lang_attach[''Group attach part''] ?></span></h3>\n	</div>\n	<fieldset class="mf-set set<?php echo ++$forum_page[''item_count''] ?>">\n		<legend><span><?php echo $lang_attach[''Attachment rules''] ?></span></legend>\n		<div class="mf-box">\n			<div class="mf-item">\n				<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[''fld_count''] ?>" name="download" value="1"<?php if ($group[''g_pun_attachment_allow_download''] == ''1'') echo '' checked="checked"'' ?> /></span>\n				<label for="fld<?php echo $forum_page[''fld_count''] ?>"><?php echo $lang_attach[''Download'']?></label>\n			</div>\n			<div class="mf-item">\n				<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[''fld_count''] ?>" name="upload" value="1"<?php if ($group[''g_pun_attachment_allow_upload''] == ''1'') echo '' checked="checked"'' ?> /></span>\n				<label for="fld<?php echo $forum_page[''fld_count''] ?>"><?php echo $lang_attach[''Upload''] ?></label>\n			</div>\n			<div class="mf-item">\n				<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[''fld_count''] ?>" name="delete" value="1"<?php if ($group[''g_pun_attachment_allow_delete''] == ''1'') echo '' checked="checked"'' ?> /></span>\n				<label for="fld<?php echo $forum_page[''fld_count''] ?>"><?php echo $lang_attach[''Delete''] ?></label>\n			</div>\n			<div class="mf-item">\n				<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[''fld_count''] ?>" name="owner_delete" value="1"<?php if ($group[''g_pun_attachment_allow_delete_own''] == ''1'') echo '' checked="checked"'' ?> /></span>\n				<label for="fld<?php echo $forum_page[''fld_count''] ?>"><?php echo $lang_attach[''Owner delete''] ?></label>\n			</div>\n		</div>\n	</fieldset>\n	<div class="sf-set set<?php echo ++$forum_page[''item_count''] ?>">\n		<div class="sf-box text">\n			<label for="fld<?php echo ++$forum_page[''fld_count''] ?>"><span><?php echo $lang_attach[''Size''] ?></span> <small><?php echo $lang_attach[''Size comment''] ?></small></label><br />\n			<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[''fld_count''] ?>" name="max_size" size="15" maxlength="15" value="<?php echo $group[''g_pun_attachment_upload_max_size''] ?>" /></span>\n		</div>\n		<div class="sf-box text">\n			<label for="fld<?php echo ++$forum_page[''fld_count''] ?>"><span><?php echo $lang_attach[''Per post''] ?></span></label><br />\n			<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[''fld_count''] ?>" name="per_post" size="4" maxlength="5" value="<?php echo $group[''g_pun_attachment_files_per_post''] ?>" /></span>\n		</div>\n		<div class="sf-box text">\n			<label for="fld<?php echo ++$forum_page[''fld_count''] ?>"><span><?php echo $lang_attach[''Allowed files''] ?></span><small><?php echo $lang_attach[''Allowed comment''] ?></small></label><br />\n			<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[''fld_count''] ?>" name="file_ext" size="80" maxlength="80" value="<?php echo $group[''g_pun_attachment_disallowed_extensions''] ?>" /></span>\n		</div>\n	</div>\n\n<?php', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('agr_add_edit_end_validation', 'pun_attachment', '$group_id = isset($_POST[''group_id'']) ? intval($_POST[''group_id'']) : '''';\n			if ($_POST[''mode''] == ''add'' || (!empty($group_id) && $group_id != FORUM_ADMIN))\n			{\n				$allow_down = isset($_POST[''download'']) && $_POST[''download''] == ''1'' ? ''1'' : ''0'';\n				$allow_upl = isset($_POST[''upload'']) && $_POST[''upload''] == ''1'' ? ''1'' : ''0'';\n				$allow_del = isset($_POST[''delete'']) && $_POST[''delete''] == ''1'' ? ''1'' : ''0'';\n				$allow_del_own = isset($_POST[''owner_delete'']) && $_POST[''owner_delete''] == ''1'' ? ''1'' : ''0'';\n\n				$size = isset($_POST[''max_size'']) ? intval($_POST[''max_size'']) : ''0'';\n				$upload_max_filesize = get_bytes(ini_get(''upload_max_filesize''));\n				$post_max_size = get_bytes(ini_get(''post_max_size''));\n				if ($size > $upload_max_filesize ||  $size > $post_max_size)\n					$size = min($upload_max_filesize, $post_max_size);\n\n				$per_post = isset($_POST[''per_post'']) ? intval($_POST[''per_post'']) : ''1'';\n				$file_ext = isset($_POST[''file_ext'']) ? trim($_POST[''file_ext'']) : '''';\n\n				if (!empty($file_ext))\n				{\n					$file_ext = preg_replace(''/\\s/'', '''', $file_ext);\n					$match = preg_match(''/(^[a-zA-Z0-9])+(([a-zA-Z0-9]+\\,)|([a-zA-Z0-9]))+([a-zA-Z0-9]+$)/'', $file_ext);\n\n					if (!$match)\n						message($lang_attach[''Wrong allowed'']);\n				}\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('agr_add_end_qr_add_group', 'pun_attachment', '$query[''INSERT''] .= '', g_pun_attachment_allow_download, g_pun_attachment_allow_upload, g_pun_attachment_allow_delete, g_pun_attachment_allow_delete_own, g_pun_attachment_upload_max_size, g_pun_attachment_files_per_post, g_pun_attachment_disallowed_extensions'';\n			$query[''VALUES''] .= '', ''.implode('','', array($allow_down, $allow_upl, $allow_del, $allow_del_own, $size, $per_post, ''\\''''.$forum_db->escape($file_ext).''\\''''));', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('agr_edit_end_qr_update_group', 'pun_attachment', 'if (isset($allow_down))\n				$query[''SET''] .= '', g_pun_attachment_allow_download = ''.$allow_down.'', g_pun_attachment_allow_upload = ''.$allow_upl.'', g_pun_attachment_allow_delete = ''.$allow_del.'', g_pun_attachment_allow_delete_own = ''.$allow_del_own.'', g_pun_attachment_upload_max_size = ''.$size.'', g_pun_attachment_files_per_post = ''.$per_post.'', g_pun_attachment_disallowed_extensions = \\''''.$forum_db->escape($file_ext).''\\'''';', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('hd_head', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''] && in_array(FORUM_PAGE, array(''viewtopic'', ''postedit'', ''attachment-preview'')))\n			{\n				if ($forum_user[''style''] != ''Oxygen'' && is_dir($ext_info[''path''].''/css/''.$forum_user[''style'']))\n					$forum_loader->add_css($ext_info[''url''].''/css/''.$forum_user[''style''].''/pun_attachment.min.css'', array(''type'' => ''url''));\n				else\n					$forum_loader->add_css($ext_info[''url''].''/css/Oxygen/pun_attachment.min.css'', array(''type'' => ''url''));\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('po_start', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				require $ext_info[''path''].''/include/attach_func.php'';\n				if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n					require $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n				else\n					require $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n				require $ext_info[''path''].''/url.php'';\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('po_qr_get_topic_forum_info', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				$query[''SELECT''] .= '', g_pun_attachment_allow_upload, g_pun_attachment_upload_max_size, g_pun_attachment_files_per_post, g_pun_attachment_disallowed_extensions, g_pun_attachment_allow_delete_own'';\n				$query[''JOINS''][] = array(''LEFT JOIN'' => ''groups AS g'', ''ON'' => ''g.g_id = ''.$forum_user[''g_id'']);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('po_qr_get_forum_info', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				$query[''SELECT''] .= '', g_pun_attachment_allow_upload, g_pun_attachment_upload_max_size, g_pun_attachment_files_per_post, g_pun_attachment_disallowed_extensions, g_pun_attachment_allow_delete_own'';\n				$query[''JOINS''][] = array(''LEFT JOIN'' => ''groups AS g'', ''ON'' => ''g.g_id = ''.$forum_user[''g_id'']);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('po_form_submitted', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				$attach_secure_str = $forum_user[''id''].($tid ? ''t''.$tid : ''f''.$fid);\n				$attach_query = array(\n					''SELECT''	=>	''id, owner_id, post_id, topic_id, filename, file_ext, file_mime_type, file_path, size, download_counter, uploaded_at, secure_str'',\n					''FROM''		=>	''attach_files'',\n					''WHERE''		=>	''secure_str = \\''''.$forum_db->escape($attach_secure_str).''\\''''\n				);\n\n				$attach_result = $forum_db->query_build($attach_query) or error(__FILE__, __LINE__);\n\n				$uploaded_list = array();\n				while ($cur_attach = $forum_db->fetch_assoc($attach_result))\n				{\n					$uploaded_list[] = $cur_attach;\n				}\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('po_end_validation', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				foreach (array_keys($_POST) as $key)\n				{\n					if (preg_match(''~delete_(\\d+)~'', $key, $matches))\n					{\n						$attach_delete_id = $matches[1];\n						break;\n					}\n				}\n\n				if (isset($attach_delete_id))\n				{\n					foreach ($uploaded_list as $attach_index => $attach)\n					{\n						if ($attach[''id''] == $attach_delete_id)\n						{\n							$delete_attach = $attach;\n							$attach_delete_index = $attach_index;\n							break;\n						}\n					}\n\n					if (isset($delete_attach) && ($forum_user[''g_id''] == FORUM_ADMIN || $cur_posting[''g_pun_attachment_allow_delete_own'']))\n					{\n						$attach_query = array(\n							''DELETE''	=>	''attach_files'',\n							''WHERE''		=>	''id = ''.$delete_attach[''id'']\n						);\n						$forum_db->query_build($attach_query) or error(__FILE__, __LINE__);\n						unset($uploaded_list[$attach_delete_index]);\n						if ($forum_config[''attach_create_orphans''] == ''0'')\n							unlink($forum_config[''attach_basefolder''].$delete_attach[''file_path'']);\n					}\n					else\n						$errors[] = $lang_attach[''Del perm error''];\n\n					$_POST[''preview''] = 1;\n				}\n				else if (isset($_POST[''add_file'']))\n				{\n					attach_create_attachment($attach_secure_str, $cur_posting);\n					$_POST[''preview''] = 1;\n				}\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('po_pre_redirect', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''] && isset($_POST[''submit_button'']))\n			{\n				$attach_query = array(\n					''UPDATE''	=>	''attach_files'',\n					''SET''		=>	''owner_id = ''.$forum_user[''id''].'', topic_id = ''.(isset($new_tid) ? $new_tid : $tid).'', post_id = ''.$new_pid.'', secure_str = NULL'',\n					''WHERE''		=>	''secure_str = \\''''.$forum_db->escape($attach_secure_str).''\\''''\n				);\n				$forum_db->query_build($attach_query) or error(__FILE__, __LINE__);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('po_pre_header_load', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n				$forum_page[''form_attributes''][''enctype''] = ''enctype="multipart/form-data"'';', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('po_pre_req_info_fieldset_end', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n				show_attachments(isset($uploaded_list) ? $uploaded_list : array(), $cur_posting);', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('vt_start', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				require $ext_info[''path''].''/include/attach_func.php'';\n				if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n					require $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n				else\n					require $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n				require $ext_info[''path''].''/url.php'';\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('vt_qr_get_topic_info', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				$query[''SELECT''] .= '', g_pun_attachment_allow_download'';\n				$query[''JOINS''][] = array(''LEFT JOIN'' => ''groups AS g'', ''ON'' => ''g.g_id = ''.$forum_user[''g_id'']);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('vt_main_output_start', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				$attach_query = array(\n					''SELECT''	=>	''id, post_id, filename, file_ext, file_mime_type, size, download_counter, uploaded_at, file_path'',\n					''FROM''		=>	''attach_files'',\n					''WHERE''		=>	''topic_id = ''.$id,\n					''ORDER BY''	=>	''filename''\n				);\n				$attach_result = $forum_db->query_build($attach_query) or error(__FILE__, __LINE__);\n				$attach_list = array();\n				while ($cur_attach = $forum_db->fetch_assoc($attach_result))\n				{\n					if (!isset($attach_list[$cur_attach[''post_id'']]))\n						$attach_list[$cur_attach[''post_id'']] = array();\n					$attach_list[$cur_attach[''post_id'']][] = $cur_attach;\n				}\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('vt_row_pre_display', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''] && isset($attach_list[$cur_post[''id'']]))\n			{\n				if (isset($forum_page[''message''][''signature'']))\n					$forum_page[''message''][''signature''] = show_attachments_post($attach_list[$cur_post[''id'']], $cur_post[''id''], $cur_topic).$forum_page[''message''][''signature''];\n				else\n					$forum_page[''message''][''attachments''] = show_attachments_post($attach_list[$cur_post[''id'']], $cur_post[''id''], $cur_topic);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('ed_start', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				require $ext_info[''path''].''/include/attach_func.php'';\n				if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n					require $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n				else\n					require $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n				require $ext_info[''path''].''/url.php'';\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('ed_qr_get_post_info', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				$query[''SELECT''] .= '', g_pun_attachment_allow_upload, g_pun_attachment_upload_max_size, g_pun_attachment_files_per_post, g_pun_attachment_disallowed_extensions, g_pun_attachment_allow_delete_own, g_pun_attachment_allow_delete'';\n				$query[''JOINS''][] = array(''LEFT JOIN'' => ''groups AS g'', ''ON'' => ''g.g_id = ''.$forum_user[''g_id'']);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('ed_post_selected', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				$attach_secure_str = $forum_user[''id''].''t''.$cur_post[''tid''];\n\n				$attach_query = array(\n					''SELECT''	=>	''id, owner_id, post_id, topic_id, filename, file_ext, file_mime_type, file_path, size, download_counter, uploaded_at, secure_str'',\n					''FROM''		=>	''attach_files'',\n					''WHERE''		=>	''post_id = ''.$id.'' OR secure_str = \\''''.$attach_secure_str.''\\'''',\n					''ORDER BY''	=>	''filename''\n				);\n\n				$attach_result = $forum_db->query_build($attach_query) or error(__FILE__, __LINE__);\n\n				$uploaded_list = array();\n				while ($cur_attach = $forum_db->fetch_assoc($attach_result))\n					$uploaded_list[] = $cur_attach;\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('ed_end_validation', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				foreach (array_keys($_POST) as $key)\n				{\n					if (preg_match(''~delete_(\\d+)~'', $key, $matches))\n					{\n						$attach_delete_id = $matches[1];\n						break;\n					}\n				}\n				if (isset($attach_delete_id))\n				{\n					foreach ($uploaded_list as $attach_index => $attach)\n						if ($attach[''id''] == $attach_delete_id)\n						{\n							$delete_attach = $attach;\n							$attach_delete_index = $attach_index;\n							break;\n						}\n					if (isset($delete_attach) && ($forum_user[''g_id''] == FORUM_ADMIN || $cur_post[''g_pun_attachment_allow_delete''] || ($cur_post[''g_pun_attachment_allow_delete_own''] && $forum_user[''id''] == $delete_attach[''owner_id''])))\n					{\n						$attach_query = array(\n							''DELETE''	=>	''attach_files'',\n							''WHERE''		=>	''id = ''.$delete_attach[''id'']\n						);\n						$forum_db->query_build($attach_query) or error(__FILE__, __LINE__);\n						unset($uploaded_list[$attach_delete_index]);\n						if ($forum_config[''attach_create_orphans''] == ''0'')\n							unlink($forum_config[''attach_basefolder''].$delete_attach[''file_path'']);\n					}\n					else\n						$errors[] = $lang_attach[''Del perm error''];\n					$_POST[''preview''] = 1;\n				}\n				else if (isset($_POST[''add_file'']))\n				{\n					attach_create_attachment($attach_secure_str, $cur_post);\n					$_POST[''preview''] = 1;\n				}\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('ed_pre_redirect', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''] && isset($_POST[''submit_button'']))\n			{\n				$attach_query = array(\n					''UPDATE''	=>	''attach_files'',\n					''SET''		=>	''owner_id = ''.$forum_user[''id''].'', topic_id = ''.$cur_post[''tid''].'', post_id = ''.$id.'', secure_str = NULL'',\n					''WHERE''		=>	''secure_str = \\''''.$forum_db->escape($attach_secure_str).''\\''''\n				);\n				$forum_db->query_build($attach_query) or error(__FILE__, __LINE__);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('ed_pre_header_load', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n				$forum_page[''form_attributes''][''enctype''] = ''enctype="multipart/form-data"'';', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('ed_pre_main_fieldset_end', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n				show_attachments(isset($uploaded_list) ? $uploaded_list : array(), $cur_post);', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('aop_start', 'pun_attachment', 'require $ext_info[''path''].''/include/attach_func.php'';\n			if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n				require $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n			else\n				require $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n			require $ext_info[''path''].''/url.php'';\n\n			$section = isset($_GET[''section'']) ? $_GET[''section''] : null;\n\n			if (isset($_POST[''apply'']) && ($section == ''list_attach'') && isset($_POST[''form_sent'']))\n				unset($_POST[''form_sent'']);', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('aop_new_section', 'pun_attachment', 'if ($section == ''pun_attach'')\n				require $ext_info[''path''].''/pun_attach.php'';\n			else if ($section == ''pun_list_attach'')\n				require $ext_info[''path''].''/pun_list_attach.php'';', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('ca_fn_generate_admin_menu_new_sublink', 'pun_attachment', 'require $ext_info[''path''].''/url.php'';\n			if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n				require $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n			else\n				require $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n\n			if ((FORUM_PAGE_SECTION == ''management'') && ($forum_user[''g_id''] == FORUM_ADMIN))\n				$forum_page[''admin_submenu''][''pun_attachment_management''] = ''<li class="''.((FORUM_PAGE == ''admin-attachment-manage'') ? ''active'' : ''normal'').((empty($forum_page[''admin_menu''])) ? '' first-item'' : '''').''"><a href="''.forum_link($attach_url[''admin_attachment_manage'']).''">''.$lang_attach[''Attachment''].''</a></li>'';\n			if ((FORUM_PAGE_SECTION == ''settings'') && ($forum_user[''g_id''] == FORUM_ADMIN))\n				$forum_page[''admin_submenu''][''pun_attachment_settings''] = ''<li class="''.((FORUM_PAGE == ''admin-options-attach'') ? ''active'' : ''normal'').((empty($forum_page[''admin_menu''])) ? '' first-item'' : '''').''"><a href="''.forum_link($attach_url[''admin_options_attach'']).''">''.$lang_attach[''Attachment''].''</a></li>'';', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('aop_pre_update_configuration', 'pun_attachment', 'if ($section == ''pun_attach'')\n			{\n				while (list($key, $input) = @each($form))\n				{\n					if ($forum_config[''attach_''.$key] != $input)\n					{\n						if ($input != '''' || is_int($input))\n							$value = ''\\''''.$forum_db->escape($input).''\\'''';\n						else\n							$value = ''NULL'';\n\n						$query = array(\n							''UPDATE''	=> ''config'',\n							''SET''		=> ''conf_value=''.$value,\n							''WHERE''		=> ''conf_name=\\''attach_''.$key.''\\''''\n						);\n\n						$forum_db->query_build($query) or error(__FILE__,__LINE__);\n					}\n				}\n\n				require_once FORUM_ROOT.''include/cache.php'';\n				generate_config_cache();\n\n				redirect(forum_link($attach_url[''admin_options_attach'']), $lang_admin_settings[''Settings updated''].'' ''.$lang_admin_common[''Redirect'']);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('aop_pre_redirect', 'pun_attachment', 'if ($section == ''pun_attach'')\n			{\n				redirect(forum_link($attach_url[''admin_options_attach'']), $lang_admin_settings[''Settings updated''].'' ''.$lang_admin_common[''Redirect'']);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('aop_new_section_validation', 'pun_attachment', 'if ($section == ''pun_attach'')\n{\n	if (!isset($form[''use_icon'']) || $form[''use_icon''] != ''1'') $form[''use_icon''] = ''0'';\n	if (!isset($form[''create_orphans'']) || $form[''create_orphans''] != ''1'') $form[''create_orphans''] = ''0'';\n	if (!isset($form[''disable_attach'']) || $form[''disable_attach''] != ''1'') $form[''disable_attach''] = ''0'';\n	if (!isset($form[''disp_small'']) || $form[''disp_small''] != ''1'') $form[''disp_small''] = ''0'';\n\n	if ($form[''always_deny''])\n	{\n		$form[''always_deny''] = preg_replace(''/\\s/'','''',$form[''always_deny'']);\n		$match = preg_match(''/(^[a-zA-Z0-9])+(([a-zA-Z0-9]+\\,)|([a-zA-Z0-9]))+([a-zA-Z0-9]+$)/'',$form[''always_deny'']);\n\n		if (!$match)\n			message($lang_attach[''Wrong deny'']);\n	}\n\n	if (preg_match(''/^[0-9]+$/'', $form[''small_height'']))\n		$form[''small_height''] = intval($form[''small_height'']);\n	else\n		$form[''small_height''] = $forum_config[''attach_small_height''];\n\n	if (preg_match(''/^[0-9]+$/'',$form[''small_width'']))\n		$form[''small_width''] = intval($form[''small_width'']);\n	else\n		$form[''small_width''] = $forum_config[''attach_small_width''];\n\n	$names = explode('','', $forum_config[''attach_icon_name'']);\n	$icons = explode('','', $forum_config[''attach_icon_extension'']);\n\n	$num_icons = count($icons);\n	for ($i = 0; $i < $num_icons; $i++)\n	{\n		if (!empty($_POST[''attach_ext_''.$i]) && !empty($_POST[''attach_ico_''.$i]))\n		{\n			if (!preg_match("/^[a-zA-Z0-9]+$/", forum_trim($_POST[''attach_ext_''.$i])) && !preg_match("/^([a-zA-Z0-9]+\\.+(png|gif|jpeg|jpg|ico))+$/", forum_trim($_POST[''attach_ico_''.$i])))\n				message($lang_attach[''Wrong icon/name'']);\n\n			$icons[$i] = trim($_POST[''attach_ext_''.$i]);\n			$names[$i] = trim($_POST[''attach_ico_''.$i]);\n		}\n	}\n\n	if (isset($_POST[''add_field_icon'']) && isset($_POST[''add_field_file'']))\n	{\n		if (!empty($_POST[''add_field_icon'']) && !empty($_POST[''add_field_file'']))\n		{\n			if (!(preg_match("/^[a-zA-Z0-9]+$/",trim($_POST[''add_field_icon''])) && preg_match("/^([a-zA-Z0-9]+\\.+(png|gif|jpeg|jpg|ico))+$/",trim($_POST[''add_field_file'']))))\n				message ($lang_attach[''Wrong icon/name'']);\n\n			$icons[] = trim($_POST[''add_field_icon'']);\n			$names[] = trim($_POST[''add_field_file'']);\n		}\n	}\n\n	$icons = implode('','', $icons);\n	$icons = preg_replace(''/\\,{2,}/'','','',$icons);\n	$icons = preg_replace(''/\\,{1,}+$/'','''',$icons);\n\n	$names = implode('','', $names);\n	$names = preg_replace(''/\\,{2,}/'','','',$names);\n	$names = preg_replace(''/\\,{1,}+$/'','''',$names);\n\n	$query = array(\n		''UPDATE''	=> ''config'',\n		''SET''		=> ''conf_value=\\''''.$forum_db->escape($icons).''\\'''',\n		''WHERE''		=> ''conf_name = \\''attach_icon_extension\\''''\n	);\n	$result = $forum_db->query_build($query) or error (__FILE__, __LINE__);\n\n	$query = array(\n		''UPDATE''	=> ''config'',\n		''SET''		=> ''conf_value=\\''''.$forum_db->escape($names).''\\'''',\n		''WHERE''		=> ''conf_name=\\''attach_icon_name\\''''\n	);\n	$result = $forum_db->query_build($query) or error (__FILE__, __LINE__);\n	}\n\n	if ($section == ''list_attach'')\n	{\n	$query = array(\n		''SELECT''	=> ''COUNT(id) AS num_attach'',\n		''FROM''		=> ''attach_files''\n	);\n\n	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);\n	$num_attach = $forum_db->fetch_assoc($result);\n\n	if (!is_null($num_attach) && $num_attach !== false)\n	{\n		for ($i = 0; $i < $num_attach[''num_attach'']; $i++)\n		{\n			if (isset($_POST[''attach_''.$i]))\n			{\n				if (isset($_POST[''attach_to_post_''.$i]) && !empty($_POST[''attach_to_post_''.$i]))\n				{\n					$post_id = intval($_POST[''attach_to_post_''.$i]);\n					$attach_id = intval($_POST[''attachment_''.$i]);\n					$query = array(\n						''SELECT''	=> ''id, topic_id, poster_id'',\n						''FROM''		=> ''posts'',\n						''WHERE''		=> ''id=''.$post_id\n					);\n					$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);\n\n					$info = $forum_db->fetch_assoc($result);\n					if (is_null($info) || $info === false)\n						message ($lang_attach[''Wrong post'']);\n\n					$query = array(\n						''UPDATE''	=> ''attach_files'',\n						''SET''		=> ''post_id=''.intval($info[''id'']).'', topic_id=''.intval($info[''topic_id'']).'', owner_id=''.intval($info[''poster_id'']),\n						''WHERE''		=> ''id=''.$attach_id\n					);\n					$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);\n\n					redirect(forum_link($attach_url[''admin_attachment_manage'']), $lang_attach[''Attachment added'']);\n				}\n				else\n					message ($lang_attach[''Wrong post'']);\n			}\n		}\n	}\n}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('mi_new_action', 'pun_attachment', 'if ($action == ''pun_attachment'' && !$forum_config[''attach_disable_attach''] && isset($_GET[''item'']))\n			{\n				$attach_item = intval($_GET[''item'']);\n				if ($attach_item < 1)\n					message($lang_common[''Bad request'']);\n\n				if (isset($_GET[''secure_str'']))\n				{\n					preg_match(''~(\\d+)f(\\d+)~'', $_GET[''secure_str''], $match);\n					if (isset($match[0]))\n					{\n						$query = array(\n							''SELECT''	=>	''a.id, a.post_id, a.topic_id, a.owner_id, a.filename, a.file_ext, a.file_mime_type, a.size, a.file_path, a.secure_str'',\n							''FROM''		=>	''attach_files AS a'',\n							''JOINS''		=>	array(\n								array(\n									''INNER JOIN'' => ''forums AS f'',\n									''ON''		=> ''f.id = ''.$match[2]\n								),\n								array(\n									''LEFT JOIN''	=> ''forum_perms AS fp'',\n									''ON''		=> ''(fp.forum_id = f.id AND fp.group_id = ''.$forum_user[''g_id''].'')''\n								)\n							),\n							''WHERE''		=> ''a.id = ''.$attach_item.'' AND (fp.read_forum IS NULL OR fp.read_forum = 1) AND secure_str = \\''''.$match[0].''\\''''\n						);\n					}\n					else\n					{\n						preg_match(''~(\\d+)t(\\d+)~'', $_GET[''secure_str''], $match);\n						if (isset($match[0]))\n						{\n							$query = array(\n								''SELECT''	=>	''a.id, a.post_id, a.topic_id, a.owner_id, a.filename, a.file_ext, a.file_mime_type, a.size, a.file_path, a.secure_str'',\n								''FROM''		=>	''attach_files AS a'',\n								''JOINS''		=>	array(\n									array(\n										''INNER JOIN''	=> ''topics AS t'',\n										''ON''		=> ''t.id = ''.$match[2]\n									),\n									array(\n										''INNER JOIN''	=> ''forums AS f'',\n										''ON''		=> ''f.id = t.forum_id''\n									),\n									array(\n										''LEFT JOIN''		=> ''forum_perms AS fp'',\n										''ON''		=> ''(fp.forum_id = f.id AND fp.group_id = ''.$forum_user[''g_id''].'')''\n									)\n								),\n								''WHERE''		=> ''a.id = ''.$attach_item.'' AND (fp.read_forum IS NULL OR fp.read_forum = 1) AND secure_str = \\''''.$match[0].''\\''''\n							);\n						}\n						else\n							message($lang_common[''Bad request'']);\n					}\n					if ($forum_user[''id''] != $match[1])\n						message($lang_common[''Bad request'']);\n				} else {\n					$query = array(\n						''SELECT''	=> ''a.id, a.post_id, a.topic_id, a.owner_id, a.filename, a.file_ext, a.file_mime_type, a.size, a.file_path, a.secure_str'',\n						''FROM''		=> ''attach_files AS a'',\n						''JOINS''		=> array(\n							array(\n								''INNER JOIN''	=> ''topics AS t'',\n								''ON''			=> ''t.id = a.topic_id''\n							),\n							array(\n								''INNER JOIN''	=> ''forums AS f'',\n								''ON''			=> ''f.id = t.forum_id''\n							),\n							array(\n								''LEFT JOIN''		=> ''forum_perms AS fp'',\n								''ON''			=> ''(fp.forum_id = f.id AND fp.group_id = ''.$forum_user[''g_id''].'')''\n							)\n						),\n						''WHERE''		=> ''a.id = ''.$attach_item.'' AND (fp.read_forum IS NULL OR fp.read_forum = 1)''\n					);\n				}\n\n				$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);\n				$attach_info = $forum_db->fetch_assoc($result);\n\n				if (!$attach_info)\n					message($lang_common[''Bad request'']);\n\n				$query = array(\n					''SELECT''	=> ''g_pun_attachment_allow_download'',\n					''FROM''		=> ''groups'',\n					''WHERE''		=> ''g_id = ''.$forum_user[''group_id'']\n				);\n				$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);\n				$perms = $forum_db->fetch_assoc($result);\n\n				if (!$perms) {\n					message($lang_common[''No permission'']);\n				}\n\n				if ($forum_user[''g_id''] != FORUM_ADMIN && !$perms[''g_pun_attachment_allow_download'']) {\n					message($lang_common[''No permission'']);\n				}\n\n				if (isset($_GET[''preview'']) && in_array($attach_info[''file_ext''], array(''png'', ''jpg'', ''gif'', ''tiff'')))\n				{\n					if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n						require $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n					else\n						require $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';\n					require $ext_info[''path''].''/url.php'';\n\n					$forum_page = array();\n					$forum_page[''download_link''] = !empty($attach_info[''secure_str'']) ? forum_link($attach_url[''misc_download_secure''], array($attach_item, $attach_info[''secure_str''])) : forum_link($attach_url[''misc_download''], $attach_item);\n					$forum_page[''view_link''] = !empty($attach_info[''secure_str'']) ? forum_link($attach_url[''misc_view_secure''], array($attach_item, $attach_info[''secure_str''])) : forum_link($attach_url[''misc_view''], $attach_info[''id'']);\n\n					// Setup breadcrumbs\n					$forum_page[''crumbs''] = array(\n						array($forum_config[''o_board_title''], forum_link($forum_url[''index''])),\n						$lang_attach[''Image preview'']\n					);\n\n					define(''FORUM_PAGE'', ''attachment-preview'');\n					require FORUM_ROOT.''header.php'';\n\n					// START SUBST - <!// forum_main -->\n					ob_start();\n\n					?>\n					<div class="main-head">\n						<h2 class="hn"><span><?php echo $lang_attach[''Image preview'']; ?></span></h2>\n					</div>\n\n					<div class="main-content main-frm">\n						<div class="content-head">\n							<h2 class="hn"><span><?php echo $attach_info[''filename'']; ?></span></h2>\n						</div>\n						<fieldset class="frm-group group1">\n							<span class="show-image"><img src="<?php echo $forum_page[''view_link'']; ?>" alt="<?php echo forum_htmlencode($attach_info[''filename'']); ?>" /></span>\n							<p><?php echo $lang_attach[''Download:'']; ?> <a href="<?php echo $forum_page[''download_link'']; ?>"><?php echo forum_htmlencode($attach_info[''filename'']); ?></a></p>\n						</fieldset>\n					</div>\n					<?php\n\n					$tpl_temp = trim(ob_get_contents());\n					$tpl_main = str_replace(''<!// forum_main -->'', $tpl_temp, $tpl_main);\n					ob_end_clean();\n					// END SUBST - <!// forum_main -->\n\n					require FORUM_ROOT.''footer.php'';\n				}\n				else\n				{\n					$fp = fopen($forum_config[''attach_basefolder''].$attach_info[''file_path''], ''rb'');\n\n					if (!$fp)\n						message($lang_common[''Bad request'']);\n					else\n					{\n						header(''Content-Disposition: attachment; filename="''.$attach_info[''filename''].''"'');\n						header(''Content-Type: ''.$attach_info[''file_mime_type'']);\n						header(''Pragma: no-cache'');\n						header(''Expires: 0'');\n						header(''Connection: close'');\n						header(''Content-Length: ''.$attach_info[''size'']);\n\n						fpassthru($fp);\n\n						if (isset($_GET[''download'']) && intval($_GET[''download'']) == 1) {\n							$query = array(\n								''UPDATE''	=> ''attach_files'',\n								''SET''		=> ''download_counter=download_counter+1'',\n								''WHERE''		=> ''id=''.$attach_item\n							);\n							$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);\n						}\n\n\n						// End the transaction\n						$forum_db->end_transaction();\n\n						// Close the db connection (and free up any result data)\n						$forum_db->close();\n\n						exit();\n					}\n				}\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('dl_start', 'pun_attachment', 'require $ext_info[''path''].''/include/attach_func.php'';\n			if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n				require $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n			else\n				require $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('mr_start', 'pun_attachment', 'require $ext_info[''path''].''/include/attach_func.php'';\n			if (file_exists($ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php''))\n				require $ext_info[''path''].''/lang/''.$forum_user[''language''].''/''.$ext_info[''id''].''.php'';\n			else\n				require $ext_info[''path''].''/lang/English/''.$ext_info[''id''].''.php'';', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('dl_qr_get_post_info', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				$query[''SELECT''] .= '', g_pun_attachment_allow_upload, g_pun_attachment_upload_max_size, g_pun_attachment_files_per_post, g_pun_attachment_disallowed_extensions, g_pun_attachment_allow_delete_own, g_pun_attachment_allow_delete'';\n				$query[''JOINS''][] = array(''LEFT JOIN'' => ''groups AS g'', ''ON'' => ''g.g_id = ''.$forum_user[''g_id'']);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('dl_form_submitted', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				$attach_query = array(\n					''SELECT''	=>	''id, file_path, owner_id'',\n					''FROM''		=>	''attach_files''\n				);\n				$attach_query[''WHERE''] = $cur_post[''is_topic''] ? ''post_id != 0 AND topic_id = ''.$cur_post[''tid''] : ''post_id = ''.$id;\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('dl_topic_deleted_pre_redirect', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				remove_attachments($attach_query, $cur_post);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('dl_post_deleted_pre_redirect', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				remove_attachments($attach_query, $cur_post);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('mr_qr_get_forum_data', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				$query[''SELECT''] .= '', g_pun_attachment_allow_upload, g_pun_attachment_upload_max_size, g_pun_attachment_files_per_post, g_pun_attachment_disallowed_extensions, g_pun_attachment_allow_delete_own, g_pun_attachment_allow_delete'';\n				$query[''JOINS''][] = array(''LEFT JOIN'' => ''groups AS g'', ''ON'' => ''g.g_id = ''.$forum_user[''g_id'']);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('mr_confirm_delete_posts_pre_redirect', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				$attach_query = array(\n					''SELECT''	=>	''id, file_path, owner_id'',\n					''FROM''		=>	''attach_files'',\n					''WHERE''		=>	isset($posts) ? ''post_id IN(''.implode('','', $posts).'')'' : ''topic_id IN(''.implode('','', $topics).'')''\n				);\n				$forum_page[''is_admmod''] = true;\n				remove_attachments($attach_query, $cur_forum);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('mr_confirm_delete_topics_pre_redirect', 'pun_attachment', 'if (!$forum_config[''attach_disable_attach''])\n			{\n				$attach_query = array(\n					''SELECT''	=>	''id, file_path, owner_id'',\n					''FROM''		=>	''attach_files'',\n					''WHERE''		=>	isset($posts) ? ''post_id IN(''.implode('','', $posts).'')'' : ''topic_id IN(''.implode('','', $topics).'')''\n				);\n				$forum_page[''is_admmod''] = true;\n				remove_attachments($attach_query, $cur_forum);\n			}', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('mr_confirm_split_posts_pre_redirect', 'pun_attachment', '$attach_query = array(\n				''UPDATE''	=>	''attach_files'',\n				''SET''		=>	''topic_id=''.$new_tid,\n				''WHERE''		=>	''post_id IN (''.implode('','', $posts).'')''\n			);\n			$forum_db->query_build($attach_query) or error(__FILE__, __LINE__);', 1561751453, 5);");
mysqli_query("INSERT INTO `PLA_extension_hooks` VALUES('mr_confirm_merge_topics_pre_redirect', 'pun_attachment', '$attach_query = array(\n				''UPDATE''	=>	''attach_files'',\n				''SET''		=>	''topic_id=''.$merge_to_tid,\n				''WHERE''		=>	''topic_id IN(''.implode('','', $topics).'')''\n			);\n			$forum_db->query_build($attach_query) or error(__FILE__, __LINE__);', 1561751453, 5);");

// ------------------------------------------------------
// Table structure for table `PLA_forums`

mysqli_query("CREATE TABLE`PLA_forums` (
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

mysqli_query("CREATE TABLE`PLA_forum_perms` (
  `group_id` int(10) NOT NULL default '0',
  `forum_id` int(10) NOT NULL default '0',
  `read_forum` tinyint(1) NOT NULL default '1',
  `post_replies` tinyint(1) NOT NULL default '1',
  `post_topics` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`group_id`,`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
// Dumping data for table `PLA_forum_perms`

mysqli_query("INSERT INTO `PLA_forum_perms` VALUES(2, 5, 0, 0, 0);");
mysqli_query("INSERT INTO `PLA_forum_perms` VALUES(3, 5, 0, 0, 0);");
mysqli_query("INSERT INTO `PLA_forum_perms` VALUES(2, 6, 0, 0, 0);");
mysqli_query("INSERT INTO `PLA_forum_perms` VALUES(3, 6, 0, 0, 0);");

// ------------------------------------------------------
// Table structure for table `PLA_forum_subscriptions`

mysqli_query("CREATE TABLE`PLA_forum_subscriptions` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `forum_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
// Dumping data for table `PLA_forum_subscriptions`


// ------------------------------------------------------
// Table structure for table `PLA_groups`

mysqli_query("CREATE TABLE`PLA_groups` (
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

mysqli_query("INSERT INTO `PLA_groups` VALUES(1, 'Administrators', 'Administrator', 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 0, -1, '');");
mysqli_query("INSERT INTO `PLA_groups` VALUES(2, 'Guest', NULL, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 60, 30, 0, 0, 0, 0, 0, 0, 0, '');");
mysqli_query("INSERT INTO `PLA_groups` VALUES(3, 'Members', NULL, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 60, 30, 60, 1, 1, 0, 1, 2000000, 1, NULL);");
mysqli_query("INSERT INTO `PLA_groups` VALUES(4, 'Moderators', 'Moderator', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 2000000, 1, NULL);");
mysqli_query("INSERT INTO `PLA_groups` VALUES(5, 'Affiliate', NULL, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 30, 30, 60, 1, 1, 0, 1, 2000000, 1, NULL);");

// ------------------------------------------------------
// Table structure for table `PLA_online`

mysqli_query("CREATE TABLE`PLA_online` (
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

mysqli_query("CREATE TABLE`PLA_posts` (
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

mysqli_query("CREATE TABLE`PLA_pun_pm_messages` (
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

mysqli_query("CREATE TABLE`PLA_ranks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `rank` varchar(50) NOT NULL default '',
  `min_posts` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
");
// Dumping data for table `PLA_ranks`

mysqli_query("INSERT INTO `PLA_ranks` VALUES(1, 'New member', 0);");
mysqli_query("INSERT INTO `PLA_ranks` VALUES(2, 'Member', 10);");

// ------------------------------------------------------
// Table structure for table `PLA_reports`

mysqli_query("CREATE TABLE`PLA_reports` (
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

mysqli_query("CREATE TABLE`PLA_search_cache` (
  `id` int(10) unsigned NOT NULL default '0',
  `ident` varchar(200) NOT NULL default '',
  `search_data` text,
  PRIMARY KEY  (`id`),
  KEY `PLA_search_cache_ident_idx` (`ident`(8))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
// ------------------------------------------------------
// Table structure for table `PLA_search_matches`

mysqli_query("CREATE TABLE`PLA_search_matches` (
  `post_id` int(10) unsigned NOT NULL default '0',
  `word_id` int(10) unsigned NOT NULL default '0',
  `subject_match` tinyint(1) NOT NULL default '0',
  KEY `PLA_search_matches_word_id_idx` (`word_id`),
  KEY `PLA_search_matches_post_id_idx` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");

// ------------------------------------------------------
// Table structure for table `PLA_search_words`

mysqli_query("CREATE TABLE`PLA_search_words` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `word` varchar(20) character set utf8 collate utf8_bin NOT NULL default '',
  PRIMARY KEY  (`word`),
  KEY `PLA_search_words_id_idx` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=670 ;
");

// ------------------------------------------------------
// Table structure for table `PLA_subscriptions`

mysqli_query("CREATE TABLE`PLA_subscriptions` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `topic_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");

// ------------------------------------------------------
// Table structure for table `PLA_topics`

mysqli_query("CREATE TABLE`PLA_topics` (
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

mysqli_query("CREATE TABLE`PLA_users` (
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

mysqli_query("INSERT INTO `PLA_users` VALUES(3, 1, 'Admin', 'f783bbf4f634dab1bb57acdfcb50c2ce', NULL, 'arcade@MyDomain.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, 0, 1, 1, 0, -5, 1, 0, 0, 'English', 'Oxygen', 4, 1561823556, NULL, NULL, 1561663153, '127.0.0.1', 1564407011, NULL, NULL, NULL, 1, 60, 60, 1, 1);");
mysqli_query("INSERT INTO `PLA_users` VALUES(4, 3, 'user', '68f32b5f0943904f5eac13096f25d756', NULL, 'arcade@MyDomain.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 'English', 'Oxygen', 4, 1562273690, NULL, NULL, 1561663153, '127.0.0.1', 1564352562, NULL, NULL, NULL, 2, 60, 60, NULL, 1);");

// Writing to the conf.
$conf=@fopen('arcade_conf.php', 'w');

$goforit = @fwrite($conf,"<?php\n\$maintenance='0';\n\$notinstalled='0';\n\$settings['enable_onlinelist']='1';\n\$settings['enable_passrecovery']='1';\n\$settings['enable_shoutbox']='1';\n\$settings['enable_logo']='0';\n\$settings['enable_timer']='0';\n\$settings['allow_comments']='1';\n\$settings['show_announcement']='0';\n\$settings['show_stats_table']='1';\n\$settings['disable_reg']='0';\n\$settings['enable_validation']='0';\n\$settings['use_cheat_protect']='0';\n\$settings['upload_av_max_size']='0';\n\$settings['use_seccode']='1';\n\$settings['allow_guests']='1';\n\$settings['override_userprefs']='0';\n\$settings['arcade_title']='Practical Lightning Arcade [PLA v1.0 beta]';\n\$settings['datestamp']='jS F Y - h:i A';\n\$settings['online_list_dur']='60';\n\$settings['timezone']='-5';\n\$settings['num_pages_of']='10';\n\$settings['ng_num']='20';\n\$settings['ls_num']='14';\n\$settings['bp_num']='10';\n\$settings['catdiv']='80';\n\$settings['catimg']='60';\n\$settings['banned_mails']='';\n\$settings['banned_usernames']='Tasos,TasosP13';\n\$settings['upload_av_max_size']='200000';\n\$phpmyadminloc='';\n\$textloc='flat';\n\$AnnounceFile='announce.php';\n\$imgloc='images';\n\$catloc='categories';\n\$avatarloc='avatars';\n\$useravasloc='useravatars';\n\$smiliesloc='emoticons';\n\$bannerloc='images/banners';\n\$themesloc='skins';\n\$gamesloc='arcade';\n\$arcurl='".$SiteURL."';\n\$arcgreet='Welcome to the Practical Lightning Arcade (BETA)';\n\$ResetTime ='2025,02,31,20,01,0';\n\$toetag='mornoovening-sm.gif';\n\$adminplayas='admin';\n\$siteemail='arcade@MyNewArcade.tld';\n\$BCCcatchall='ArcadeMember@MyNewArcade.tld';\n\$dbhost='".$dbhost."';\n\$dbuser='".$dbuser."';\n\$dbpass='".$dbpass."';\n\$dbname='".$dbname."';\n?>");

if(!$goforit) { 
message("arcade_conf.php could not be opened for writing. Please check the permissions.","Failed to write to conf");
}else{
message("Your new arcade is installed! Congratulations! <a href='index.php'>Click here to get started</a>. <br /><br /><br /><font color='red'>Login with the name: <u>admin</u> and password of: <u>admin</u>. <i>Change this password</i> when you login! You may also change your name if you like.</font><br /><br /><H1>DELETE THIS INSTALL.PHP NOW</H1>","Complete");
}
}

?>
<form action='PLArcade_v1.0-Install.php?step=2' method='POST'>
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
