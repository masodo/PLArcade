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
# Section: SmileyPop.php  Function: Emoticon Picker Popup   Modified: 7/27/2019   By: MaSoDo

if(isset($_GET['action']) && $_GET['action']=="emotes") {
echo "<div class='tableborder' width='75%' style='margin-top: 10px; margin-right: auto; margin-left: auto;'><table width='100%' cellpadding='4' cellspacing='1'><tr><td width='60%' align='center' class='headertableblock'>Emote</td><td width='60%' align='center' class='headertableblock'>Symbol</td></tr><tr>";

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #1
$emotesdata = run_iquery("SELECT * FROM phpqa_emotes");
while($smils=mysqli_fetch_array($emotesdata)){ 
echo "\n<tr onclick=\"window.opener.document.forms['boxform'].elements['senttext'].value+='".$smils['code']."'\"><td class='arcade1' align='left'><a title='".$smils['description']."'><img src=\"".$smiliesloc."/".$smils['filename']."\"></a><br /></td><td class='arcade1' align='center'>".$smils['code']."</td></tr>";
}
echo "</table></div>";
die();
}
//END UpdatedFunction Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_GET['action']) && $_GET['action']=="allshouts") {
$badwords= file($textloc."/badwords.txt");
$tb=count($badwords);
echo "<div class='tableborder' width='75%' style='margin-top: 10px; margin-right: auto; margin-left: auto;'><table width='100%' cellpadding='4' cellspacing='1'><tr><td width='60%' align='center' class='headertableblock'>Shout Scrollback</td></tr><tr><td>";

//All Shouts Display
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #2
$selectshouts = run_iquery("SELECT name,shout,id,ipa,tstamp FROM phpqa_shoutbox ORDER BY id DESC");
while($shts=mysqli_fetch_array($selectshouts)){ 
$emotesdata = run_iquery("SELECT * FROM phpqa_emotes");
while($smilS=mysqli_fetch_array($emotesdata)){
$shts[1] = bbcodeHtml($shts[1]);
if (isset($smilS['code'])) $shts[1] = str_replace(rtrim($smilS['code']), "<img src='".$smiliesloc."/".$smilS['filename']."' />", $shts[1]);
}
for($gx=-1;$gx<$tb;$gx++) {
if(isset($badwords[$gx]) && $badwords[$gx] != "") {
$checkbadwords = rtrim($badwords[$gx]);
$shts[1]= preg_replace("/$checkbadwords/i", "@!&^*%", $shts[1]);
} 
}
$parse_stamp = date($datestamp, $shts[4] );
$GtGp=run_iquery("SELECT `group` FROM phpqa_accounts WHERE name='".$shts[0]."'");
$HvGp=mysqli_fetch_array($GtGp);
echo "<a title='".$parse_stamp."'><img src='".$imgloc."/clockin.png' alt='posted time' height='10' width='10' /></a>&nbsp; <u><b><a href='?action=profile&user=".$shts[0]."' class='".$HvGp[0]."Look'>".$shts[0]."</a></b></u>: ".$shts[1]."<br /><hr />";}
echo "</td></tr></table></div>";
die();
}
//END UpdatedFunction Block #2
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
