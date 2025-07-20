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
# Section: ScoringOption.php  Function: Highscore Collection/Submission   Modified: 7-20-2025  By: MaSoDo
//Major Overhaul thanks to Claude AI & MaSoDo
// Initialize variables
$thescore = '';
$id = '';

// Consolidate score handling - check for all possible parameter names
$thescore = $_POST['thescore'] ?? $_POST['gscore'] ?? $_POST['enscore'] ?? '';
// Handle autocom submissions
if (isset($_GET['autocom'])) {
    $id = htmlspecialchars($_COOKIE['gname'] ?? '', ENT_QUOTES);
}

// Handle newscore submissions  
if (isset($_GET['do']) && $_GET['do'] == 'newscore') {
    if (isset($_POST['gname'])) {
        $id = htmlspecialchars($_POST['gname'], ENT_QUOTES);
    }
}


// Play sound for ANY score submission
if (!empty($thescore)) {
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
 
// Check if this is a new champion (either first score ever OR beats existing top score)
if (!isset($checkTOPscore[2]) || $thescore > $checkTOPscore[2]) {
    $WINNERTAG = ' ';
    
    
    // BUILD and SHOW the exact SQL query
    $champion_sql = "UPDATE phpqa_games SET Champion_name = '$safe_user', Champion_score = '$safe_score' WHERE gameid='$safe_id'";
    
    // Execute the query
    $result = run_iquery($champion_sql);
    
    // Check if the update actually worked
    
    // VERIFY: Check if the update actually happened
    $verify_query = "SELECT Champion_name, Champion_score FROM phpqa_games WHERE gameid='$safe_id'";
    
    $verify_result = @mysqli_fetch_array(run_iquery($verify_query));
    
    if (isset($checkHOFscore['HOF_score']) && $thescore > $checkHOFscore['HOF_score']) { 
        $WINNERTAG = ' HALL OF FAME ';
        run_iquery("UPDATE phpqa_games SET HOF_name = '$safe_user',HOF_score = '$safe_score' WHERE gameid='$safe_id'");   
    }
} else {
//DEBUG     echo "<div style='background:red; color:white; padding:5px;'>CHAMPION UPDATE SKIPPED - Score $thescore not better than existing " . ($checkTOPscore[2] ?? 'none') . "</div>";
}
 
 //
 $gameinfo = mysqli_fetch_array(run_iquery("SELECT gameid,game,about,Champion_name,Champion_score,times_played,gamecat,exclusiv FROM phpqa_games WHERE gameid = '$id'"));
 if (!$gameinfo) {
header("Location: index.php");
die();
 } 
 if ($gameinfo['gamecat'] == '2' || $gameinfo['gamecat'] == '23') {
message("<b>Successfully Submitted Score!</b><br />Game: ".$id."<br />Score: ".$thescore."<br />Player: ".isset($_COOKIE['phpqa_user_c'])."");
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
$key='';
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
//          Score Submission - SECURE VERSION
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Improved sanitization functions
function safe_sql_string($input) {
    if ($input === null) return '';
    
    // Use proper escaping if mysqli connection available
    global $mysqli_connection;
    if (isset($mysqli_connection) && $mysqli_connection) {
        return mysqli_real_escape_string($mysqli_connection, trim($input));
    }
    
    // Fallback sanitization
    $input = str_replace(array("'", '"', "\\", "\0", "\n", "\r", "\x1a"), 
                        array("''", '""', "\\\\", "\\0", "\\n", "\\r", "\\Z"), 
                        trim($input));
    return $input;
}

function safe_display($input) {
    return htmlspecialchars($input ?? '', ENT_QUOTES, 'UTF-8');
}

function safe_number($input, $type = 'int') {
    if (!is_numeric($input)) return 0;
    return ($type === 'float') ? (float)$input : (int)$input;
}

function safe_email($input) {
    return filter_var($input, FILTER_SANITIZE_EMAIL);
}

// Only proceed if user is authenticated
if (isset($_COOKIE['phpqa_user_c'])) {
    
    // Initialize variables early and safely
    $time = time();
    $id = safe_sql_string($_GET['id'] ?? $_POST['gname'] ?? '');
    $key = safe_sql_string($_GET['key'] ?? $_POST['akey'] ?? '');
    $thescore = $_POST['thescore'] ?? $_POST['gscore'] ?? '';
    $ipa = safe_sql_string($_SERVER['REMOTE_ADDR'] ?? '');
    
    // Handle comment submission
    if (isset($_GET['c']) && $_GET['c'] == '1' && !isset($_POST['sb'])) {
        vsess();
        global $senttext, $phpqa_user_cookie, $adminplayas;
        
        $safe_senttext = safe_sql_string($senttext ?? $_POST['senttext'] ?? '');
        
        // Admin Play As handling
        $post_user_cookie = $phpqa_user_cookie;
        if ($post_user_cookie == 'Admin' && isset($adminplayas)) {
            $post_user_cookie = $adminplayas;
        }
        
        $safe_user = safe_sql_string($post_user_cookie);
        
        run_iquery("UPDATE phpqa_scores SET comment = '$safe_senttext' WHERE gameidname='$id' AND username='$safe_user'"); 
    }

    // Score processing logic
    if((isset($_GET['do']) || !empty($thescore)) && !empty($id)) {
        $safe_id = safe_display($id);
        $safe_key = safe_display($key);
        $safe_score_display = safe_display($thescore);
        
        // Comment form for new high scores
        $commentthing = "<form name='postbox' action='index.php?id=$safe_id&amp;c=1' method='POST'>
    <input type='hidden' name='akey' value='$safe_key'>
    <div class='tableborder'>
        <table width='100%'>
            <td class='arcade1' width='100%' align='center'>
                Congratulations, new best score, your final score was: <b>$safe_score_display</b>.<br /><br />
                <input type='text' name='senttext' maxlength='255'>
                <input type='submit' name='gocomment' value='Send Comment'>
            </td>
        </table>
    </div><br/>" . (function_exists('displayemotes') ? displayemotes() : '') . "</form><br /><br />";
    
        $gameidname = $id;
        
        if (isset($thescore) && !empty($thescore)) {
            
            // Check if account is still in validation
            global $exist;
            if (isset($exist[6]) && $exist[6] == "Validating") {
                $display_score = safe_display(str_replace('-', '', $thescore));
                echo "<div class='tableborder'><table width='100%'><td class='arcade1' width='100%' align='center'>Your score was: <b>$display_score</b>... <br /><br /></td></table></div><br /><br />";
                message("!ALERT!: Sorry, your account is still in validation. This means you cannot: submit your highscores, shout on the shoutbox, or edit your profile. Please wait for an admin to validate your account, then you'll be ready to play.");
                die();
            }
            
            // Handle low score games
            $checkscoring = @mysqli_fetch_array(run_iquery("SELECT scoring FROM phpqa_games WHERE gameid ='$id'"));
            if (isset($checkscoring['scoring']) && $checkscoring['scoring'] == 'LO') {
                $thescore = -abs($thescore); // Ensure negative for low score games
            }
            
            // Admin Play As handling
            global $phpqa_user_cookie, $adminplayas;
            $post_user_cookie = $phpqa_user_cookie;
            if ($post_user_cookie == 'Admin' && isset($adminplayas)) {
                $post_user_cookie = $adminplayas;
            }
            
            // Sanitize all variables for database operations
            $safe_user = safe_sql_string($post_user_cookie);
            $safe_score = safe_number($thescore, 'float');
            $safe_time = safe_number($time);
            
            // Get current scores and game info
            $checkTOPscore = @mysqli_fetch_array(run_iquery("SELECT * FROM phpqa_scores WHERE gameidname='$id' ORDER BY thescore DESC LIMIT 0,1"));
            $checkHOFscore = @mysqli_fetch_array(run_iquery("SELECT HOF_score FROM phpqa_games WHERE gameid='$id'"));
            $checkscore = @mysqli_fetch_array(run_iquery("SELECT * FROM phpqa_scores WHERE gameidname='$id' AND username='$safe_user' ORDER BY thescore DESC"));
            
            global $gameinfo;
            $safe_game_name = safe_sql_string($gameinfo['game'] ?? '');
            
            if ($checkscore) { // User has existing score
                if ($checkscore['thescore'] < $thescore) { // New score is better
                    
                    // Update existing score
                    run_iquery("UPDATE phpqa_scores SET 
                        thescore = '$safe_score', 
                        gamename = '$safe_game_name', 
                        phpdate = '$safe_time', 
                        ip = '$ipa' 
                        WHERE gameidname='$id' AND username='$safe_user'");
                    
                    $is_new_high_score = true;
                    
                } else {
                    // Score not improved
                    $display_score = safe_display(str_replace('-', '', $thescore));
                    echo "<div class='tableborder'><table width='100%'><td class='arcade1' width='100%' align='center'>Your score was: <b>$display_score</b>...";
                    echo "<br /><br />Try again.</td></table></div><br /><br />";
                    $is_new_high_score = false;
                }
            } else {
                // First time playing this game
                $safe_gameidname = safe_sql_string($gameidname);
                
                run_iquery("INSERT INTO phpqa_scores (username, thescore, ip, comment, phpdate, gameidname, gamename) 
                    VALUES ('$safe_user', '$safe_score', '$ipa', '', '$safe_time', '$safe_gameidname', '$safe_game_name')");
                
                $is_new_high_score = true;
            }
            
            // Check if this is a new champion (only if score was improved/new)
            if ($is_new_high_score && (!isset($checkTOPscore['thescore']) || $thescore > $checkTOPscore['thescore'])) {
                
                $WINNERTAG = ' ';
                
                // Update champion in games table
                run_iquery("UPDATE phpqa_games SET Champion_name = '$safe_user', Champion_score = '$safe_score' WHERE gameid='$id'");
                
                // Update leaderboard
                run_iquery("DELETE FROM phpqa_leaderboard WHERE gamename='$id'");
                run_iquery("INSERT INTO phpqa_leaderboard (username, thescore, gamename) VALUES ('$safe_user', '$safe_score', '$id')");
                
                // Check for Hall of Fame
                if (isset($checkHOFscore['HOF_score']) && $thescore > $checkHOFscore['HOF_score']) { 
                    $WINNERTAG = ' HALL OF FAME ';
                    run_iquery("UPDATE phpqa_games SET HOF_name = '$safe_user', HOF_score = '$safe_score' WHERE gameid='$id'");   
                }
                
                // Email notification to previous champion
                global $settings, $siteemail, $exist;
                if(isset($settings['email_scores']) && $settings['email_scores']=='1') {
                    if(isset($checkTOPscore['username']) && $checkTOPscore['username'] != "" && $checkTOPscore['username'] != $post_user_cookie) {
                        
                        $safe_top_user = safe_sql_string($checkTOPscore['username']);
                        $person_to_mail = mysqli_fetch_array(run_iquery("SELECT email, settings FROM phpqa_accounts WHERE name='$safe_top_user'"));
                        
                        if ($person_to_mail && isset($person_to_mail['email'])) {
                            $psettings = explode("|", $person_to_mail['settings'] ?? '');
                            
                            // Check if user wants email notifications
                            if(isset($psettings[4]) && $psettings[4] != "No" && 
                               $person_to_mail['email'] != ($exist['email'] ?? '')) { 
                                
                                // Construct secure email
                                $safe_host = safe_display($_SERVER['HTTP_HOST']);
                                $safe_self = safe_display($_SERVER['PHP_SELF']);
                                $safe_gameid = urlencode($gameidname);
                                $SiteDomain = "https://$safe_host$safe_self?id=$safe_gameid";
                                
                                $hd = safe_email($siteemail ?? ('noreply@' . $_SERVER['HTTP_HOST']));
                                $safe_arcade_title = safe_display($settings['arcade_title'] ?? 'Arcade');
                                $safe_game_name_display = safe_display($gameinfo['game'] ?? 'Game');
                                $safe_username = safe_display($checkTOPscore['username']);
                                
                                $mailsub = "Message from $safe_arcade_title - Top $safe_game_name_display score defeated!";
                                $mailbody = "Hello $safe_username,\n\nOh no! Someone has taken your top score for the game: $safe_game_name_display at $safe_arcade_title!\nBetter get back in there and reclaim your score!\n\nVisit the link below to view the scoreboard:\n$SiteDomain\n\nThank you for your participation!\n$safe_arcade_title Admin\n\nIf you do not want to receive these email notices, please login and update your email preferences.";
                                
                                $headers = "From: $hd\r\n";
                                $headers .= "Reply-To: $hd\r\n";
                                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
                                $headers .= "X-Mailer: PHP/" . phpversion();
                                
                                @mail($person_to_mail['email'], $mailsub, $mailbody, $headers);
                            }
                        }
                    }
                }
                
                // Display congratulations message
                echo "<div class='tableborder'><table width='100%'><td class='arcade1' width='100%' align='center'><h2>Congratulations, you are the NEW " . $WINNERTAG . "Champion!</h2></td></table></div><br /><br />";
                
            } // End champion check
            
            // Show comment form if appropriate
            if ($is_new_high_score && isset($settings['allow_comments']) && $settings['allow_comments'] == '1') {
                echo $commentthing;
            }
            
        } // End thescore check
    } // End score processing
} // End cookie check

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
