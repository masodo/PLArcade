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
# Section: ShoutBox.php  Function: ShoutBox Block   Modified: 7/27/2019   By: MaSoDo

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
$time = time();

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #1
run_iquery("INSERT INTO phpqa_shoutbox (name,shout,ipa,tstamp) VALUES ('".$phpqa_user_cookie."','".$senttext."','".$ipa."','".$time."')", 1);
//END UpdatedFunction Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


}
}
}
}
?>

<div style="text-align:center; margin-bottom: 5px; margin-top: 5px;"><a title="Open/Close The Shoutbox Section"><img src="<?php echo $imgloc; ?>/<?php echo $collimg2; ?>" id="btn2" alt="&#8595; Shoutbox: Collapse/Expand &#8595;" onclick="return CollapseExpand2()" style="font-size:16px; font-weight:bold; color:silver;" /></a></div><div id="MyDiv2" class="<?php echo $collapset2; ?>">
<?php
//comment out the following line if you are running announcements above arcade info block
require('Announcement.php');
?>
<div class="tableborder">
<table width="100%" cellpadding="4" cellspacing="1">
<tr>
<td width="5%" align="center" class="headertableblock" colspan="2" >Shoutbox</td>
</tr>
<tr>
<td class="arcade1" width="25%" align="left"><input type="hidden" name="sb" value="1"><div id="boxform"><form name="boxform"><input type="hidden" name="akey" id="akey" value="<?php echo $key; ?>"><input type="hidden" name="usersarcadename" id="usersarcadename" class="Shoutbox" size="0"  value="<?php echo $phpqa_user_cookie; ?>" readonly="readonly" />Message:  <br /><textarea rows="6" cols="35" maxlength="1024" name="senttext" id="senttext" class="Shoutbox" /></textarea><br /><input type="button" id="SendShout" name="SendShout" value="Shout" /> <input type="button" value="Refresh" id="ChangePanel" /> [ <a href="javascript:window.open('index.php?action=emotes', 'Emoticons', 'width=400,height=400,directories=no,location=no,menubar=no,resizable=no,scrollbars=yes,status=no,toolbar=no');void(0);">Emoticons</a> ]<br />
</td><td class="arcade1" width="75%"><div style="position:absolute;display:none;margin-left:-110px;margin-top:20px" id="shoutboxpopup"><img /></div></form></div>
<div id="scroll3" style="width:100%;height:225px;overflow:auto;overflow-x:hidden; margin-left:-2px;" align="left">
<div id="theater">
<div id="stage">
<?php include('ShoutStage.php'); ?>
</div>
</div>
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
