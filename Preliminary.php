<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 2.0 (BETA) based on PHP-Quick-Arcade 3.0 Â© Jcink.com
//Tournaments & JS By: SeanJ. - Heavily Modified by PracticalLightning Web Design
//Michael S. DeBurger [DeBurger Photo Image & Design]
//-----------------------------------------------------------------------------------/
//  phpQuickArcade v3.0.x Â© Jcink 2005-2010 quickarcade.jcink.com                        
//
//  Version: 3.0.23 Final. Released: Sunday, May 02, 2010
//-----------------------------------------------------------------------------------/
// Thanks to (Sean) http://seanj.jcink.com 
// for: Tournies, JS, and more
// ---------------------------------------------------------------------------------/
# Section: Preliminary.php  Function: Session Start and Loading Preliminary Functions   Modified: [6-26-25 working w/ClaudeAI] 10/14/2019   By: MaSoDo
session_start();
if(isset($_GET['captcha'])){
    // Set the correct content type header first
    header("Content-type: image/png");
    
    $im = imagecreatefrompng("captchabg.png");
    
    // Fix the color allocation - values should be 0-255, not just 333
    $textcolor = imagecolorallocate($im, 51, 51, 51); // Dark gray
    
    imagestring($im, 4, rand(0,240), rand(0,20), "{$_SESSION['captcha']}", $textcolor);
    
    // Output the image BEFORE destroying it
    imagepng($im);
    
    // Clean up the resource
    imagedestroy($im);
    
    die();
}
//uncomment below to report ALL errors
error_reporting(E_ALL);
//uncomment below to report NO errors
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_STRICT);
// function to convert bbcode, and smiles to html

function bbcodeHtml($str) {
  // delete 'http://' because will be added when convert the code
  $str = str_replace('[url=http://', '[url=', $str);
  $str = str_replace('[url]http://', '[url]', $str);
  $str = str_replace('[url=https://', '[url=', $str);
  $str = str_replace('[url]https://', '[url]', $str);
  // Array with RegExp to recognize the code that must be converted
  $bbcode_smiles = array(
    // RegExp for [b]...[/b], [i]...[/i], [u]...[/u], [block]...[/block], [color=code]...[/color], [br]
    '/\[b\](.*?)\[\/b\]/is',
    '/\[i\](.*?)\[\/i\]/is',
    '/\[u\](.*?)\[\/u\]/is',
    '/\[block\](.*?)\[\/block\]/is',
    '/\[color=(.*?)\](.*?)\[\/color\]/is',
    '/\[br\]/is',
    // RegExp for [url=link_address]..link_name..[/url], or [url]..link_address..[/url]
    '/\[url\=(.*?)\](.*?)\[\/url\]/is',
    '/\[url\](.*?)\[\/url\]/is',
    // RegExp for [img=image_address]..image_title[/img], or [img]..image_address..[/img]
    '/\[img\=(.*?)\](.*?)\[\/img\]/is',
    '/\[img\](.*?)\[\/img\]/is',
    '/\[code\](.*?)\[\/code\]/is',
    '/\[size\=(.*?)\](.*?)\[\/size\]/is',
    // RegExp for sets of characters for smiles: :), :(, :P, :P, ...
     // '/:\)/i', '/:\(/i', '/:P/i', '/:S/i', '/:O/i', '/=D\>/i', '/\>:D\</i', '/:D/i', '/:-\*/i'
 );
  // Array with HTML that will replace the bbcode tags, defined inthe same order
  $html_tags = array(
    // <b>...</b>, <i>...</i>, <u>...</u>, <blockquote>...</blockquote>, <span>...</span>, <br/>
    '<b>$1</b>',
    '<i>$1</i>',
    '<u>$1</u>',
    '<blockquote>$1</blockquote>',
    '<span style="color:$1;">$2</span>',
    '<br />',
    // a href...>...</a>, and <img />
    '<a target="_blank" href="http://$1">$2</a>',
    '<a target="_blank" href="http://$1">$1</a>',
    '<img src="$1" alt="$2" />',
    '<img src="$1" alt="$1" />',
    '<br /><b>CODE:</><br /><div style="font-style:italic; color: yellow; background-color: navy; padding:10px; margin-right: 20px; margin-left: 20px; border: thick inset;">$1</div>',
    '<span style="font-size:$1px">$2</span>',
    // The HTML to replace smiles. Here you must add the address of the images with smiles
    //'<img src="icos/1.gif" alt=":)" border="0" />',
    //'<img src="icos/2.gif" alt=":(" border="0" />',
    //'<img src="icos/3.gif" alt=":P" border="0" />',
    //'<img src="icos/4.gif" alt=":S" border="0" />',
    //'<img src="icos/5.gif" alt=":O" border="0" />',
   // '<img src="icos/6.gif" alt="=D&gt;" border="0" />',
   // '<img src="icos/7.gif" alt="&gt;: D&lt;" border="0" />',
   // '<img src="icos/8.gif" alt=": D" border="0" />',
   // '<img src="icos/9.gif" alt=":-*" border="0" />'
  );
  // replace the bbcode
  $str = preg_replace($bbcode_smiles, $html_tags, $str);
  return $str;
}
if (isset($_COOKIE['PHPSESSID'])) {
$key=htmlspecialchars($_COOKIE['PHPSESSID'], ENT_QUOTES);
}
function vsess() {
global $key;
if(isset($_REQUEST['akey']) && $_REQUEST['akey'] != $key) { die("Authorization Mismatch"); }
}
// for compatibility?
if(isset($_GET['do']) && $_GET['do'] == "verifyscore") {
print "&randchar=1&randchar2=2&savescore=1&blah=OK";
  die();
}
if(isset($_GET['play'])) {
setcookie("gname", $_GET['play']);
}
ob_start();
if (isset($_GET['cparea']) == "settings" && isset($_POST['SettingsUpdate'])) header("Location: ?cparea=settings");
$mtime=explode(" ",microtime());
$useTZ = '';
$new_datetime = '';
require("./arcade_conf.php");
$ngnum = '';
$lsnum = '';
$bpnum = '';
if($notinstalled) die("<a href='PLArcade_v2.0-Install.php'>Begin installation</a>");
if($maintenance) die("<h1>Down for maintenance - We'll be back up and running soon!</h1>");
$useTZ = $settings['timezone'];
date_default_timezone_set("$useTZ");
$datestamp=$settings['datestamp'];
$modcpcheck=$acpcheck='ok';
function is_email($text) { 
$g = explode("@", $text);
if(count($g) == 2) return true;
}
function after_decimal($i,$l) {
$t = explode(".",$i);
$r = $t[0];
if (isset($t[1])) $r.= "." . substr($t[1],0,$l);
return $r;
}
function ordsuf($num) { 
$long = "";
if (strlen($num)>1) $long = true; 
$f = substr($num,-1); 
if ($long && $f == "0" || $long && substr($num,-2,1) == "1" || substr($num,-1,1) > 3) return $num."th"; elseif ($f=="1") return $num."st"; elseif ($f=="2") return $num."nd"; elseif($f==3) return $num."rd";
}

function displayemotes() { 
$g = "";
global $textloc;
global $smiliesloc;
$emotesdata = run_iquery("SELECT * FROM phpqa_emotes");
while($smils=mysqli_fetch_array($emotesdata)){ 
$trim = rtrim($smils['code']);
$g.= "<a title='".$smils['description']."'><img src=\"".$smiliesloc."/".$smils['filename']."\" onclick=\"document.forms['postbox'].elements['senttext'].value=document.forms['postbox'].elements['senttext'].value+&#39;".$trim."&#39;\"></a> ";
}
return $g;
}
function run_iquery($sql=false, $no_inj_protect=""){
require("./arcade_conf.php");
$iconnect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
static $queries=Array();
if ($sql) $queries[]=$sql;
// Inject protection, filters queries to stop injections
// don't want it / need something here? Then set the flag to 1.
$sql=preg_replace("/--/i", "", $sql);
if(!$no_inj_protect) {
$sql=preg_replace("/UNION/i", "", $sql);
$sql=preg_replace("/concat/i", "", $sql);
$sql=preg_replace("/pass/i", "", $sql);
}
if($sql !="") $r_q=mysqli_query($iconnect,$sql);
$h=htmlspecialchars(mysqli_connect_errno(), ENT_QUOTES);
if($h) { 
$sql=htmlspecialchars($sql, ENT_QUOTES);	
echo "<script language='Javascript'>
alert('Database Error: ".$h."');
alert('Query used: ".$sql."');
</script>"; 
}
return $sql?$r_q:$queries;
}

if (isset($_GET['id'])) $id = htmlspecialchars($_GET['id'], ENT_QUOTES);
if (isset($_GET['user'])) $user = htmlspecialchars ($_GET['user'], ENT_QUOTES);
if (isset($_GET['cat'])&&!is_numeric($_GET['cat'])) die();
if (isset($_GET['cat'])) $cat = $_GET['cat'];
if (isset($_GET['plat'])) $plat = $_GET['plat'];
if (isset($_GET['action']) && $_GET['action'] == "logout") {
echo "<script language='Javascript'> alert('Did You Hear Me Say LOGOUT?'); </script>"; 
setcookie("phpqa_user_c",FALSE,time()-1);
setcookie("phpqa_user_p",FALSE,time()-1);
setcookie("DeAnn",FALSE,time()-1);
header("Location: ?");
}
$ipa = $_SERVER['REMOTE_ADDR'];
if (isset($_COOKIE['phpqa_user_c'])) {
$phpqa_user_cookie = htmlspecialchars($_COOKIE['phpqa_user_c'], ENT_QUOTES);
}
if (isset($_COOKIE['phpqa_user_p'])) $phpqa_user_p = htmlspecialchars($_COOKIE['phpqa_user_p'], ENT_QUOTES);
if (isset($_POST['senttext'])) $senttext = htmlspecialchars($_POST['senttext'], ENT_QUOTES);

function message($info) {
echo "<div align='center'><div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=60% align=center class=headertableblock>Message:</td><tr><td class=arcade1 valign=top><div align='center' style='background-color:gray; color:white; font-size:20px; padding:20px;'>$info</div></td></table></div><br />";
}
//require("integ.php") //call for custom website integration script (InfinitelyRemote.com use)
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// 	Rather than do 10 million checks, this check is run always 
//	at the top of the page.
//	Never take this out or move this!
//                   NEVER!
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ReportID = 4;
$exist='';
//declare some variables would be nice
$plat = "";
$cat = "";
$favstuff = "";
$arcadetotalcat = "";
$favslist = "";
$first_p = "";
$all_pag = "";
$last_pag = "";
$last_p = "";
$pag_next = ""; 
$pagN_lim = "";
$PlatWord = "";
$PlatImg = "";
$IDXV = "";
$SortOrd = "";
$SortDir = "";
$acct_setting = "";
empty($show);
$name = "unregistered";
//$catquer = null;
$catquer = ""; // try this fix
$collimg1 = 'open.png';
$collimg2 = 'open.png';
$collimg3 = 'open.png';
$collimg4 = 'open.png';
if (!isset($collapset1)) $collapset1 = "";
if (!isset($collapset2)) $collapset2 = "";
if (!isset($collapset3)) $collapset3 = "";
if (!isset($collapset4)) $collapset4 = "";


if (isset($_COOKIE['phpqa_user_c'])) { // Is the username cookie set...
$query = run_iquery("SELECT * FROM phpqa_accounts WHERE name='$phpqa_user_cookie'");
$exist = mysqli_fetch_array($query);
$acct_setting = explode("|", $exist[8]);
//Collapse 1 happens in "ArcadeInfo.php"
$collapset1 = isset($acct_setting[6]) ? $acct_setting[6] : null;
if ($collapset1 == '') {
$collapset1 = 'divVisible';
$collimg1 = 'open.png';
}
if ($collapset1 == 'divHidden') {
$collimg1 = 'closed.png';
} else { $collimg1 = 'open.png'; }
//Collapse 2 happens in "ShoutBox.php"
$collapset2 = isset($acct_setting[7]) ? $acct_setting[7] : null;
if ($collapset2 == '') {
$collapset2 = 'divVisible';
$collimg2 = 'open.png';
}
if ($collapset2 == 'divHidden') {
$collimg2 = 'closed.png';
} else { $collimg2 = 'open.png'; }
//Collapse 3 happens in "Categories.php"
$collapset3 = isset($acct_setting[8]) ? $acct_setting[8] : null;
if ($collapset3 == '') {
$collapset3 = 'divVisible';
}
if ($collapset3 == 'divHidden') {
$collimg3 = 'closed.png';
} else { $collimg3 = 'open.png'; }
//Collapse 4 happens in "IndexOptions.php"
$collapset4 = isset($acct_setting[9]) ? $acct_setting[9] : null;
if ($collapset4 == '') {
$collapset4 = 'divVisible';
$collimg4 = 'open.png';
}
if ($collapset4 == 'divHidden') {
$collimg4 = 'closed.png';
} else { $collimg4 = 'open.png'; }
if($settings['override_userprefs']) $acct_setting='';
if (!$exist) die("You are now logged out. This has occurred due to a username/password mismatch. <a href='index.php?action=logout'>Click here to reset.</a>.");
    if (isset($_COOKIE['phpqa_user_p']) && ($_COOKIE['phpqa_user_p'] != rtrim($exist[2]))) { // Compare passwords - it does exist
die();
}
}
if (isset($exist[6]) && $exist[6]=="Moderator" || isset($exist[6]) && $exist[6]=="Admin") {
if(!isset($_GET['modcparea'])) {
require("acpmoderate.php");
}
}
// Over Ride The Admins Default Setting.
$num_pages_of=$settings['num_pages_of'];
if (isset($acct_setting[2]) && $acct_setting[2] != 0) $num_pages_of=$acct_setting[2];
if (!is_numeric($num_pages_of)) $num_pages_of=10;
if(isset($_GET['limit'])) $limit = $_GET['limit'];
if(isset($_GET['show'])) $show = $_GET['show'];
// ---------------------------
// Get for Pages
// ---------------------------
if (isset($_GET['show'])) $sw = $_GET['show'];
if (isset($_GET['page'])) $page = $_GET['page'];
if (isset($page)) {if ($page<1) $page=1;
$pgn = $page + 1; 
$pgnm = $page - 1;
} else {
$pgn = 1; 
$pgnm = 1;
}
// ---------------------------
// Get for the LIMIT
// ---------------------------
if (isset($_GET['limit'])) $lim = $_GET['limit'];
if (isset($limit)) {
$limn = ($limit) + ($num_pages_of); 
$limnm = ($limit) - ($num_pages_of); 
} else { 
$limn = 1;
$limnm = 1;
}
// ---------------------------
// ---------------------------
// Get for the SHOW
// ---------------------------
if (isset($_GET['show'])) $sw = $_GET['show'];
if (isset($page)) {
$swn = $show + $num_pages_of; 
$swnm = $show - $num_pages_of;
} 
// ---------------------------
// ---------------------------
// get READY to go! OOOH 
// We're gonna rock! ROCK! ROCK!
// JCINK IS A ROCKA!
// ---------------------------
if (!isset($limit)) $limit=0;  // No limit?
if ( !is_numeric($limit) ) die();
if (!isset($show)) $show=$num_pages_of;
if ( !is_numeric($show) ) die();
if (isset($_GET['action']) && $_GET['action'] == "login") {
if(isset($_GET['recovery'])) {
$userID = htmlspecialchars(($_GET['userID']), ENT_QUOTES);
$pword = htmlspecialchars(($_GET['pword']), ENT_QUOTES);
} else {
$userID = htmlspecialchars(($_POST['userID']), ENT_QUOTES);
$pword = htmlspecialchars(($_POST['pword']), ENT_QUOTES);
$name = $userID;
}
$query = run_iquery("SELECT * FROM phpqa_accounts WHERE name='$userID'");
$exist = mysqli_fetch_array($query);
if ($exist) { 	// M&Ms commercial - He DOES exist! D'Ooh
if(isset($exist[6]) && $exist[6]=='Banned') { message("You have been banned from this arcade.<br />Contact ".$siteemail." if you feel this to be in error.");
die();
}
$thepassword_in_db = md5(sha1($pword));
if(isset($_GET['recovery'])) $thepassword_in_db = $pword;
if (rtrim($exist[2]) == $thepassword_in_db) {
if(!isset($_POST['cookiescheck'])) {
$authorized = true;
setcookie("phpqa_user_c", "".$exist[1]."");
//setcookie("phpqa_user_p", $thepassword_in_db, 0, ""."; HttpOnly'");
setcookie("phpqa_user_p", $thepassword_in_db, 0, "/", "", false, true); // ClaudeAI fix MSD 6/26/2025
} else {
$authorized = true;
setcookie("phpqa_user_c", "{$exist[1]}", time()+2592000);
//setcookie("phpqa_user_p", $thepassword_in_db, time()+2592000, ""."; HttpOnly"); 
setcookie("phpqa_user_p", $thepassword_in_db, time()+2592000, "/", "", false, true); // ClaudeAI fix MSD 6/26/2025
}
// Count the logins here:
$time = time();

run_iquery("UPDATE phpqa_accounts SET logins=".++$exist['logins'].", vtstamp=".$time." WHERE name='" . $userID ."'"); 

if (isset($exist['logins'])&&$exist['logins'] =='1' ) {
header("Location: index.php");
$welcometext = "[color=green][i]Welcome to[/i] [b]".$settings['arcade_title']."[/b][/color] [url=".$arcurl."/index.php?action=profile&user=".$exist['name']."][size=18][b]".$exist['name']."[/b][/size][/url] [wavey] [i]Thanks for joining us![/i]";

run_iquery("INSERT INTO phpqa_shoutbox (name,shout,ipa,tstamp) VALUES ('Admin','" . $welcometext . "','localhost','" . $time ."')", 1);

}
//then load the page:
header("Location: index.php");
exit();
} else {
echo "Sorry, the password you entered for the account, <b>$userID</b> is incorrect. Please try again.<br /><br /><a href='index.php?action=forgotpass'>Forgot Password?</a>";
die();
}
} else {
echo "Sorry, that username, <b>".$name."</b>  doesn't appear to exist. <a href='index.php'>Please go back and try again</a><br /><br />Did you mistype it? Are you <a href='index.php?action=register'>Registered?</a><br /><br /><a href='index.php?action=forgotpass'>Forgot Password?</a>";
die();
}
}
//check the view
if (isset($acct_setting[10]) && $acct_setting[10] == 'CV'){ 
$IDXV = 'CV';
} else {$IDXV = 'GV';}
//check the sort
if (isset($acct_setting[11]) && $acct_setting[11] == 'sid'){ 
$SortOrd = 'id';
$SortDir = 'DESC';
} else {
$SortOrd = 'game';
$SortDir = 'ASC';
}
//check
if (!isset($exist[7]) || (isset($exist[7]) && $exist[7] =="")) { 
if (!isset($defCSS)||(isset($defCSS)&&$defCSS=="")){
$pic="BlackDefault"; 
} else {
$pic=$defCSS;
}
} else { 
$pic=$exist[7]; 
} 
if(file_exists("./".$themesloc."/".$pic."/crown1.gif")){
$crowndir="./".$themesloc."/".$pic."";
} else {
$crowndir="./".$themesloc."/Default/";
}
//end
?>
