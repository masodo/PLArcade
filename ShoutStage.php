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
# Section: ShoutStage.php  Function: Shout Box Display Mechanics   Modified: 6/19/2019   By: MaSoDo
//-----------------------------------------------------------------------------------/
if(isset($_GET['shoutbox'])) $limit=0;
if(isset($_GET['shoutbox'])) $show=$num_pages_of;
if (isset($_COOKIE['phpqa_user_c'])) {
if(!isset($_GET['shoutbox'])) {
	$selectfrom = run_query("SELECT `name`,`shout`,`id`,`ipa`,`tstamp` FROM `phpqa_shoutbox` ORDER BY id DESC LIMIT 0,".$num_pages_of."");
} else {
	$selectfrom = run_query("SELECT `name`,`shout`,`id`,`ipa`,`tstamp` FROM `phpqa_shoutbox` ORDER BY id DESC LIMIT ".$limit.",".$show."");
}
	$shouttotal = mysql_fetch_array(run_query("SHOW TABLE STATUS LIKE 'phpqa_shoutbox'"));

echo "<div align='center'>";
if(!isset($_GET['arcade'])) { 
if ($limit > 0) {
if ($limnm < 0) {
echo "<a href='index.php?limit=0&amp;show=".$num_pages_of."&amp;page=1&shoutbox=1'>Previous Page (".$pgnm.")</a> ";
} else {
echo "<a href='index.php?limit=".$limnm."&amp;show=".$num_pages_of."&amp;page=".$pgnm."&shoutbox=1'>Previous Page (".$pgnm.")</a> ";
}}
}
echo ":: Total Shouts: " . $shouttotal['Rows'] . " :: ";
if(!isset($_GET['arcade'])) {
if (isset($shouttotal['Rows']) && $shouttotal['Rows'] >= $limn && $shouttotal['Rows'] != $limn) {
if (!isset($_GET['cat'])) {
if (isset($_GET['plat'])) {
echo "<a href='index.php?plat=".$plat."&amp;limit=".$limn."&amp;show=".$num_pages_of."&amp;page=".$pgn."&shoutbox=1'>Next Page (".$pgn.")</a>"; 
} else  {
echo "<a href='index.php?limit=".$limn."&amp;show=".$num_pages_of."&amp;page=".$pgn."&shoutbox=1'>Next Page (".$pgn.")</a>"; 
} } else  {
echo "<a href='index.php?cat=".$cat."&amp;limit=".$limn."&amp;show=".$num_pages_of."&amp;page=".$pgn."&shoutbox=1'>Next Page (".$pgn.")</a>"; 
}
}
} else {
echo "<a href='index.php'>View Pages</a>";
}
echo "<hr></div>";
if($shouttotal['Rows'] > 0) {
$badwords= file($textloc."/badwords.txt");
$tb=count($badwords);
while($f=@mysql_fetch_array($selectfrom)) $dataa[]=$f;
if($dataa == "") die();
foreach($dataa as $vv) $userss[]=$vv[0];
$userss=array_flip(array_flip($userss));
$qqq=run_query("SELECT `name`,`avatar`,`group` FROM `phpqa_accounts` WHERE `name`='".implode($userss,"' OR `name`='")."'");
while($ggg=mysql_fetch_array($qqq)) { 
$avatars[$ggg['name']]="$ggg[avatar]";
$thisgroup[$ggg['name']]="$ggg[group]";
}
$toppost = print_r($dataa[0], true);
foreach($dataa as $qashoutbox){
$postsofsomething = $qashoutbox[1];
$i=-1;
$emotesdata = run_query("SELECT * FROM `phpqa_emotes`");
while($smils=mysql_fetch_array($emotesdata)){
$postsofsomething = bbcodeHtml($postsofsomething);
if (isset($smils['code'])) $postsofsomething = str_replace(rtrim($smils['code']), "<img src='".$smiliesloc."/".$smils['filename']."' />", $postsofsomething);
}
for($gx=-1;$gx<$tb;$gx++) {
if(isset($badwords[$gx]) && $badwords[$gx] != "") {
$checkbadwords = rtrim($badwords[$gx]);
$postsofsomething= preg_replace("/$checkbadwords/i", "@!&^*%", $postsofsomething);
} 
}
if (isset($exist[6]) && $exist[6]=="Moderator" || isset($exist[6]) && $exist[6]=="Admin") {
echo "<a href='javascript:if (confirm(\"Are you sure?\")) document.location=\"index.php?shoutdel=$qashoutbox[2]&akey=$key\"'>[x]</a><a href=\"?modcparea=IPscan&serv=$qashoutbox[3]\">[?]</a> ";
}
$qashoutbox[5]=$avatars[$qashoutbox[0]];
$qashoutbox[6]=$thisgroup[$qashoutbox[0]];
if ($qashoutbox[5] == ''){ $qashoutbox[5] = $avatarloc.'/man.gif'; }
$parse_stamp = date($datestamp, $qashoutbox[4] );
echo "<a title='".$parse_stamp."'><img src='".$imgloc."/clockin.png' alt='posted time' height='10' width='10' /></a>&nbsp; <u><b><a href='?action=profile&user=".$qashoutbox[0]."'".($qashoutbox[5]?" onmouseover=\"s=document.getElementById('shoutboxpopup');s.style.display='';s.getElementsByTagName('img')[0].src='".$qashoutbox[5]."';\" onmousemove=\"s=document.getElementById('shoutboxpopup').style;s.top=document.body.scrollTop+2+event.clientY;s.left=document.body.scrollLeft+event.clientX;\" onmouseout=\"document.getElementById('shoutboxpopup').style.display='none'":"")."\" class='".$qashoutbox[6]."Look'>".$qashoutbox[0]."</a></b></u>: ".$postsofsomething."<br /><hr />";
}
}} else {echo "<h2>Sorry, No Guest Shouts!</h2>Please <a href='index.php?action=register#registration'>Register</a> or <a href=\"javascript:tog('login_form')\">Login</a>";}
 ?>
