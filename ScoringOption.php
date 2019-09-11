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
# Section: ScoringOption.php  Function: Highscore Collection/Submission   Modified: 9/11/2019  By: MaSoDo

if (isset($_POST['thescore']))$thescore = $_POST['thescore'];
if (isset($_GET['autocom'])) {
$id=htmlspecialchars($_COOKIE['gname'], ENT_QUOTES);
$thescore = $_POST['gscore'];
}
//if ($_GET['autocom'] && $_GET['do'] == "savescore") {
//$id=htmlspecialchars($_COOKIE['gname'], ENT_QUOTES);
//$thescore = $_POST['enscore'];
//echo "<script>alert('Score (enscore): [" . $thescore . "]');</script>";
//}
 if (isset($_GET['do']) == 'newscore') {
  $id=htmlspecialchars($_POST['gname'], ENT_QUOTES);
  $thescore = $_POST['gscore'];
  //Play Sound at Game Over
?>
<audio controls autoplay="true" style="display: none;">
<source src="sounds/GameOverYeah.mp3" type="audio/mpeg">
<source src="sounds/GameOverYeah.ogg" type="audio/ogg">
</audio> 
<?php
 }
 // highscores. UpGraded. ^.<;;
 // Architect : Don't do that gay wink <_> 
 // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 //	Get highscores list of a game when on the id= page
 // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 $gameinfo = mysqli_fetch_array(run_iquery("SELECT gameid,game,about,Champion_name,Champion_score,times_played,gamecat,exclusiv FROM phpqa_games WHERE gameid = '$id'"));
 if (!$gameinfo) {
header("Location: index.php");
die();
 } 
 if ($gameinfo['gamecat'] == '2' || $gameinfo['gamecat'] == '23') {
message("<b>Successfully Submitted Score!</b><br />Game: ".$id."<br />Score: ".$thescore."<br />Player: ".$_COOKIE['phpqa_user_c']."");
die();
 } 
 else {
 $showcat=mysqli_fetch_array(run_iquery("SELECT cat FROM phpqa_cats WHERE id='{$gameinfo['gamecat']}'"));	
 }
?>
 <div class='tableborder'>
 <a name='playzone'></a>
 <table width='100%' cellpadding='4' cellspacing='1'>
 <tr>
 <td width='5%' align='center' class='headertableblock'></td>
 <td width='60%' align='center' class='headertableblock'><?php echo $gameinfo['game']; ?></td>
 <td width='20%' align='center' class='headertableblock'>Top Score</td>
 </tr>
 <tr>
 <td class='arcade1' valign='top'><a href='index.php?play=<?php echo $id ?>#playzone'><img alt='image' border='0' src='<?php echo $gamesloc; ?>/pics/<?php echo $id ?>.gif' /></a><br /></td>
<?php //FSmod EDIT ?>
 <td class='arcade1' align='center'><a href='./index.php?cat=<?php echo $gameinfo['gamecat'] ?>' title='<?php echo $showcat[0] ?>'><img src='<?php echo $arcurl ?>/<?php echo $catloc ?>/<?php echo $showcat[0] ?>.png'  height='25' width='25' alt='<?php echo $showcat[0] ?>' style='float:left; margin-left:10px; margin-top:15px; clear: both;' /></a><?php echo $gameinfo['about']; ?><br /><br /><a href='index.php?play=<?php echo $id ?>#playzone' class='navigation'> Play </a><a href='index.php?fullscreen=<?php echo $id ?>' class='navigation'> Full </a><?php if (isset($exist[6])&&$exist[6] == "Admin") { echo "<a href='index.php?cpiarea=addgames&method=edit&game=".$id."' title='Edit Game Settings' class='navigation'>EDIT</a>";} ?> <div class='viewedtimes' style='float: right; font-size: 8px;'><?php echo "Played ".$gameinfo['times_played']." Time".($gameinfo['times_played']!=1?"s":""); ?>
 <?php
$fav_action='';
$DL_action='';
if(isset($_COOKIE['phpqa_user_c'])) {
$fav_action="<a href='index.php?action=fav&game=".$gameinfo['gameid']."&favtype=add&akey=".$key."&fav=1' title='Add Game To Favorites'><img src='".$imgloc."/favorite.png' alt='[Add to favorites]' width='25' height='25' /></a>";
if(isset($_GET['fav'])) $fav_action="<a href='index.php?action=fav&game=".$g['gameid']."&favtype=remove&akey=".$key."&fav=1' title='Remove Game From Favorites'><img src='".$imgloc."/remove.png' alt='[Remove favorite]' width='25' height='25' /></a>";
}
if ((isset($exist[6])&&$exist[6] == "Admin") || (isset($exist[6])&&$exist[6] ==  "Affiliate")) { 
    if (((null !== $showcat[0] && $showcat[0] == "Testing") || (null !== $gameinfo['exclusiv']) && $gameinfo['exclusiv'] == 1) && ($exist[6] ==  "Affiliate")){
        if($gameinfo['exclusiv'] == 1){
        $DL_action="<a title='Exclusive Game - Sorry, No Download'><img src='".$arcurl."/".$imgloc."/exclusiv.png' height='25' width='25' alt='Exclusive Game - Sorry, No Download' /></a>";
        }} else {
$DL_action="<a href='GetGame.php?GID=".$gameinfo['gameid']."' title='Download Game TAR'><img src='".$arcurl."/".$imgloc."/DL.png' height='25' width='25' alt='Download Game .tar' /></a>&nbsp;";
}}
?>
<?php echo $DL_action.$fav_action ?></div></td>
 <td class='arcade1' valign='top' align='center'><img alt='image' src='<?php echo $crowndir; ?>/crown1.gif' /><br /><b><?php echo $gameinfo['Champion_name']?$gameinfo['Champion_name']:""; ?></b><br /><?php echo $gameinfo['Champion_score']?Beautify(str_replace('-', '', $gameinfo['Champion_score'])):"-------------"; ?><br /><a href='index.php?id=<?php echo $id; ?>'>View Highscores</a>
 </td>
 </tr>
 </table>
 </div>
 <br />
 <?php
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// 			Score Submission
	//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//////////////////////////////////////////////////////////////////////////////////////////
// Removed Tourney Code 3/11/2019 MSD
//////////////////////////////////////////////////////////////////////////////////////////
 if (isset($_COOKIE['phpqa_user_c'])) { // Only if the cookie is set....
  if (isset($_GET['c']) == 1 && !isset($_POST['sb'])) { // Ah well, so what that anyone can edit their comment <_<
  vsess();
  global $senttext;
// Admin Play As
 $post_user_cookie = $phpqa_user_cookie;
if ($post_user_cookie == 'Admin') {
global $adminplayas;
$post_user_cookie = $adminplayas;
}
//End Admin Play As
  run_iquery("UPDATE phpqa_scores SET comment = '".$senttext."' WHERE gameidname='".$id."' && username='".$post_user_cookie."'"); 
}
 if(isset($_GET['do']) || isset($_POST['thescore'])) $commentthing =  "<form name='postbox' action='index.php?id=$id&amp;c=1' method='POST'><input type='hidden' name='akey' value='".$key."'><div class='tableborder'><table width='100%'><td class='arcade1' width='100%' align='center'>Congratulations, new best score, your final score was: <b>".$thescore."</b>.<br /><br /><input type='text' name='senttext'><input type='submit' name='gocomment' value='Send Comment'></form><br/>".displayemotes()."</td></table></div><br /><br />";
  $time = time();
 $gameidname = $id;
  if (isset($thescore)) {
   if(!is_numeric($thescore)) die();
   if($exist[6] == "Validating") {
   echo "<div class='tableborder'><table width='100%'><td class='arcade1' width='100%' align='center'>Your score score was: <b>" . str_replace('-', '', $thescore) . "</b>... <br /><br /></td></table></div><br /><br />";
   message("!ALERT!: Sorry, your account is still in validation. This means you cannot: submit your highscores, shout on the shoutbox, or edit your profile. Please wait for an admin to validate your account, then you'll be ready to play.");
   die();
   }
   // Low Score Logic
$checkscoring = @mysqli_fetch_array(run_iquery("SELECT scoring FROM phpqa_games WHERE gameid ='$id'"));
if ($checkscoring['scoring'] == 'LO') {
$thescore = -$thescore;
}
// Admin Play As
$post_user_cookie = $phpqa_user_cookie;
if ($post_user_cookie == 'Admin') {
global $adminplayas, $post_user_cookie;
$post_user_cookie = $adminplayas;
}
//End Admin Play As
   $checkTOPscore = @mysqli_fetch_array(run_iquery("SELECT * FROM phpqa_scores WHERE gameidname='".$id."' ORDER BY thescore DESC LIMIT 0,1"));
   $checkHOFscore = @mysqli_fetch_array(run_iquery("SELECT HOF_score FROM phpqa_games WHERE gameid='".$id."'"));
   $checkscore = @mysqli_fetch_array(run_iquery("SELECT * FROM phpqa_scores WHERE gameidname='".$id."' && username='".$post_user_cookie."' ORDER BY thescore DESC"));
   if ($checkscore) { // a score already exists by this person.
    if ($checkscore['thescore'] < $thescore) { // if checkscore is greater than thescore....
    //UpDated!
    
// Admin Play As
$post_user_cookie = $phpqa_user_cookie;
if ($post_user_cookie == 'Admin') {
global $adminplayas, $post_user_cookie;
$post_user_cookie = $adminplayas;
}
//End Admin Play As
     run_iquery("UPDATE phpqa_scores SET thescore = '".$thescore."', gamename = '".$gameinfo['game']."', phpdate = '".$time."',ip = '".$ipa."' WHERE gameidname='".$id."' && username='".$post_user_cookie."'");
     if($settings['allow_comments']) echo $commentthing;
  } else {
    echo "<div class='tableborder'><table width='100%'><td class='arcade1' width='100%' align='center'>Your score score was: <b>" . str_replace('-', '', $thescore) . "</b>...";
   echo "<br /><br />Try again.</td></table></div><br /><br />";
   }
 } else {
 
// Admin Play As
 $post_user_cookie = $phpqa_user_cookie;
if ($post_user_cookie == 'Admin') {
global $adminplayas, $post_user_cookie;
$post_user_cookie = $adminplayas;
}
//End Admin Play As
  // First time, submit it in.
   run_iquery("INSERT INTO phpqa_scores (username,thescore,ip,comment,phpdate,gameidname,gamename) VALUES ('".$post_user_cookie."','".$thescore."','".$ipa."','','".$time."','".$gameidname."','".$gameinfo['game']."')");
  if(null !== ($settings['allow_comments'])&&($settings['allow_comments']=='1')) echo $commentthing;
 }
 if ($thescore > $checkTOPscore[2]) { // We have a champion!
 $WINNERTAG = ' ';
 if ($thescore > $checkHOFscore['HOF_score']) { // We have a New HOF champion!
 $WINNERTAG = ' HALL OF FAME ';
 run_iquery("UPDATE phpqa_games SET HOF_name = '".$post_user_cookie."',HOF_score = '".$thescore."' WHERE gameid='".$id."'");   
 }

// ---------------
// Email the loser
// ---------------
if(isset($settings['email_scores'])&&$settings['email_scores']=='1') {
if($checkTOPscore['username'] !="") {
if($checkTOPscore['username'] != $post_user_cookie) {
$psettings = array();
$person_to_mail=mysqli_fetch_array(run_iquery("SELECT email,settings FROM phpqa_accounts WHERE name='".$checkTOPscore['username']."'"));
$psettings = explode("|", $person_to_mail['settings']);
if($psettings[4] != "No" && $person_to_mail['email'] !=$exist['email']) { 
$SiteDomain = "http://".htmlspecialchars($_SERVER['HTTP_HOST']).htmlspecialchars($_SERVER['PHP_SELF'])."?id={$gameidname}";
//$hd="admin@{$_SERVER[HTTP_HOST]}";
$hd=$siteemail;
$mailsub = "Message from ".$settings['arcade_title']." - Top {$gameinfo['game']} score defeated!";
$mailbody = "Hello {$checkTOPscore['username']}, \n\r\n\r Oh no! Someone has taken your top score for the game: -- {$gameinfo['game']} -- at {$settings['arcade_title']}!\n\rBetter get back in there and take your score! \n\r\n\r Visit the link below to view the scoreboard for {$gameinfo['game']}: \n\r ----------------------------------------------- \n\r ".$SiteDomain." \n\r\n\r-----------------------------------------------\n\rThank you for your participation!\n\r{$settings['arcade_title']} Admin\n\r\n\r If you do not want to recieve these email notices:\n\rplease login, visit settings >> preferences >> and set Allow other members/the admin to contact you by Email? to NO.";
$headers = "From: $hd\n";
@mail($person_to_mail['email'],$mailsub,$mailbody,$headers);
}
}
}
				}
				
// Admin Play As
$post_user_cookie = $phpqa_user_cookie;
if ($post_user_cookie == 'Admin') {
global $adminplayas;
$post_user_cookie = $adminplayas;
}
//End Admin Play As
echo "<div class='tableborder'><table width='100%'><td class='arcade1' width='100%' align='center'><h2>Congratulations, you are the NEW " . $WINNERTAG . "Champion!</h2></td></table></div><br /><br />";
   run_iquery("DELETE FROM phpqa_leaderboard WHERE gamename='".$id."'");
   run_iquery("INSERT INTO phpqa_leaderboard (username,thescore,gamename) VALUES ('".$post_user_cookie."','".$thescore."','".$id."')"); 
   run_iquery("UPDATE phpqa_games SET Champion_name = '".$post_user_cookie."',Champion_score = '".$thescore."' WHERE gameid='".$id."'");
   // Update the date and IP
  run_iquery("UPDATE phpqa_scores SET ip = '".$ipa."',phpdate = '".$time."' WHERE gameidname='".$id."' && username='".$post_user_cookie."'");
  }
 }
 // end set check
}
//=================
// 				comments
//==================
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//		  Highscore display for index.php?id=$id
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 // select...
global $key;
echo "<form action='' method='POST'><input type='hidden' name='akey' value='$key'><div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1' class='highscore'><tr><td width='15%' class='headertableblock' align='center'>Username</td><td width='15%' class='headertableblock' align='center'>Score</td><td width='30%' class='headertableblock' align='center'>Comments</td><td width='30%' class='headertableblock' align='center'>Time &amp; Date</td>";
isset($exist[6]) ? $exist[6] : null;
if(isset($exist[6]) && $exist[6] == "Moderator" || isset($exist[6]) && $exist[6] == "Admin") {
echo "<td width='20%' class='headertableblock' align='center'>IP Address</td><td width='2%' class='headertableblock' align='center'>";
?>
<input type='checkbox' onclick="s=document.getElementsByTagName('input');for(x=0;x<s.length;x++) if (s[x].type=='checkbox') s[x].checked=this.checked" />
<?php
echo "</td>";
}
echo "</tr>";
$selectfrom=run_iquery("SELECT * FROM phpqa_scores WHERE gameidname='$id' ORDER BY thescore DESC,phpdate ASC");
	while($g=mysqli_fetch_array($selectfrom)){ 
$parse_stamp = date($datestamp, $g[5]);
$postsofsomething = $g[4];
$i=-1;
$thisGuy = $g['username'];
$findGroup = run_iquery("SELECT `group` FROM phpqa_accounts WHERE name = '".$thisGuy."'");
$thisGroup = mysqli_fetch_array($findGroup);
$emotesdata = run_iquery("SELECT * FROM phpqa_emotes");
while($smils=mysqli_fetch_array($emotesdata)){
$postsofsomething = bbcodeHtml($postsofsomething);
if (isset($smils['code'])) $postsofsomething = str_replace(rtrim($smils['code']), "<img src='".$smiliesloc."/".$smils['filename']."' />", $postsofsomething);
}
global $tb;
for($gx=-1;$gx<$tb;$gx++) {
if(isset($badwords[$gx]) && $badwords[$gx] != "") {
$checkbadwords = rtrim($badwords[$gx]);
$postsofsomething= preg_replace("/$checkbadwords/i", "@!&^*%", $postsofsomething);
} 
}
echo "<tr><td class='arcade1' align='center'><a href='index.php?action=profile&amp;user=".$g[1]."' class='".$thisGroup['group']."Look'>".$g[1]."</a></td><td class='arcade1' align='center'>" . Beautify(str_replace('-', '', $g[2])) . "</td><td class='arcade1' width='40%' align='center'>".$postsofsomething."</td><td class='arcade1' width='20%' align='center'>".$parse_stamp."</td>";
isset($exist[6]) ? $exist[6] : null;
if(isset($exist[6]) && $exist[6] == "Moderator" || isset($exist[6]) && $exist[6] == "Admin") {
echo "<td width='20%' class='arcade1' align='center'><a href='?modcparea=IPscan&serv=".$g[3]."'>".$g[3]."</a></td><td width='2%' class='arcade1' align='center'><input type='checkbox' name='score_m[]' value='".$g[0]."'></td>";
}
echo "</tr>";
	}
isset($exist[6]) ? $exist[6] : null;
if(isset($exist[6]) && $exist[6] == "Moderator" || isset($exist[6]) && $exist[6] == "Admin") {
echo "<tr><td class='headertableblock' colspan='6'><div align=center><select name='dowhat_m'><option value='erase'>Delete Score</option><option value='comment'>Delete Comment</option><input type='submit' name='scoreaction' value='Go'></div></td></tr>";
}
echo "</table></div><br /></form>";
?>
