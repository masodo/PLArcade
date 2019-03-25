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
# Section: ShoutBox.php  Function: ShoutBox Block   Modified: 3/25/2019   By: MaSoDo

if($settings['enable_shoutbox']) {
if (!isset($acct_setting[1]) || $acct_setting[1] !="No") {
// Begin Collapse #2 ---
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//				JShoutBox
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (isset($_COOKIE['phpqa_user_c'])) {
if (isset($_POST['submitter2'])) {
if($exist[6] != "Validating") {
if ($_POST['senttext'] != "") {
vsess();
run_query("INSERT INTO `phpqa_shoutbox` (`name`,`shout`,`ipa`) VALUES ('".$phpqa_user_cookie."','".$senttext."','".$ipa."')", 1);
}
}
}
}
?>
<div style="text-align:center; margin-bottom: 5px; margin-top: 5px;"><a title="Open/Close The Shoutbox Section"><img src="<?php echo $imgloc; ?>/<?php echo $collimg2; ?>" id="btn2" alt="&#8595; Shoutbox: Collapse/Expand &#8595;" onclick="return CollapseExpand2()" style="font-size:16px; font-weight:bold; color:silver;" /></a></div><div id="MyDiv2" class="<?php echo $collapset2; ?>">
<div class="tableborder">
<table width="100%" cellpadding="4" cellspacing="1">
<tr>
<td width="5%" align="center" class="headertableblock" colspan="2" >Shoutbox</td>
</tr>
<tr>
<td class="arcade1" width="25%" align="left"><form action="" method="post" name="boxform"><input type="hidden" name="sb" value="1"><input type="hidden" name="akey" value="<?php echo $key; ?>"><input type="hidden" name="usersarcadename" class="Shoutbox" size="0"  value="<?php echo $phpqa_user_cookie; ?>" readonly="readonly" />Message:  <br /><textarea rows="6" cols="35" maxlength="1024" name="senttext" class="Shoutbox" /></textarea><br /><input type="submit" value="Shout" name="submitter2" /> <input type="button" value="Refresh" onclick="window.top.location=window.top.location" /> [ <a href="javascript:window.open('index.php?action=emotes', 'Emoticons', 'width=400,height=400,directories=no,location=no,menubar=no,resizable=no,scrollbars=yes,status=no,toolbar=no');void(0);">Emoticons</a> ]<br />
</form>
</td><td class="arcade1" width="75%"><div style="position:absolute;display:none;margin-left:-110px;margin-top:20px" id="shoutboxpopup"><img /></div>
<div id="scroll3" style="width:100%;height:225px;overflow:auto;overflow-x:hidden; margin-left:-2px;" align="left">
<?php
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
$qqq=run_query("SELECT `name`,`avatar` FROM `phpqa_accounts` WHERE `name`='".implode($userss,"' OR `name`='")."'");
while($ggg=mysql_fetch_array($qqq)) { 
$avatars[$ggg['name']]="$ggg[avatar]";
}
$toppost = print_r($dataa[0], true);
foreach($dataa as $qashoutbox){
$postsofsomething = $qashoutbox[1];
$i=-1;
while ($i <= $csmile) {
$i++;
$postsofsomething = bbcodeHtml($postsofsomething);
if (isset($smilies[$i])) $postsofsomething = str_replace(rtrim($smilies[$i]), "<img src='emoticons/".$smiliesp[$i]."' />", $postsofsomething);
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
if ($qashoutbox[5] == ''){ $qashoutbox[5] = $avatarloc.'/man.gif'; }
$posted = gmdate($datestamp, strtotime($qashoutbox[4])+3600*$settings['timezone']) ;
 echo "<a title='".$posted."'><img src='".$imgloc."/clockin.png' alt='posted time' height='10' width='10' /></a>&nbsp; <u><b><a href='?action=profile&user=".$qashoutbox[0]."'".($qashoutbox[5]?" onmouseover=\"s=document.getElementById('shoutboxpopup');s.style.display='';s.getElementsByTagName('img')[0].src='".$qashoutbox[5]."';\" onmousemove=\"s=document.getElementById('shoutboxpopup').style;s.top=document.body.scrollTop+2+event.clientY;s.left=document.body.scrollLeft+event.clientX;\" onmouseout=\"document.getElementById('shoutboxpopup').style.display='none'":"")."\">".$qashoutbox[0]."</a></b></u>: ".$postsofsomething."<br /><hr />";
}
}
 ?>
</div>
</td>
</tr>
</table>
</div>
<?php // End Collapse #2 ?></div>
<br />
<?php if (isset($exist[6]) && $exist[6]=="Moderator" || isset($exist[6]) && $exist[6]=="Admin") {
//echo "<a href='$arcurl/index.php?cparea=idx'><b>[[ ADMIN LINK ]]</b></a> || <a href='$arcurl/index.php?action=logout'><b>[[ LogOut ]]</b></a>";
//echo  "<i>Latest Shout (RAW):</i> " . $toppost;
} ?>
<?php }} ?>
<br />
