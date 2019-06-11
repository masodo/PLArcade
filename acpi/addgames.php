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
# Section: acpi place: addgames Administrator Control Panel   Modified: 6/11/2019   By: MaSoDo
{
// The different methods
if (!isset($_GET['method'])) {
?>
<div class='tableborder' align='left'><table width=100% cellpadding='4' cellspacing='1'><td width='20%' align='center' class='headertableblock' colspan='2'>Adding a new game - Click on a method</td><tr>
<tr><td class='arcade1' align='left'><b><a href='index.php?cpiarea=tar_importH5'>Import HTML5 from Tar Method</b><br></td><td class='arcade1'>Add HTML5 games using IbProArcade tars. <i>(must already be uploaded into &quot;tarsH5&quot; folder)</i></td></tr>
<tr><td class='arcade1' align='left'><b><a href='index.php?cpiarea=tar_import'>Tar Method</b> FLASH<br></td><td class='arcade1'>Add FLASH games using IbProArcade tars.  <i>(must already be uploaded into &quot;tars&quot; folder)</i></td></tr>
<tr><td class='arcade1' align='left'><hr /></td><td class='arcade1' align='left'><hr /></td></tr>
<tr><td class='arcade1' align='left'><b><a href='index.php?cpiarea=addgames&method=upload'>Upload Method</b><br></td><td class='arcade1'>Attach the game files using upload from your browser.</td></tr>
<tr><td class='arcade1' align='left'><b><a href='index.php?cpiarea=addgames&method=ftp'>FTP Method</b><br></td><td class='arcade1'>Use this method if you have uploaded the game files with "FTP" and now want to add the game.</td></tr>
<tr><td class='arcade1' align='left'><b><a href='index.php?cpiarea=addgames&method=hotlink'>Manual Linking Method</b><br></td><td class='arcade1'>HTML5 locally or hotlink remote game.</td></tr>
</div>
 </td>
</table>
</div>
<br>
<?php
} elseif(isset($_GET['method']))  {
	// ===============================================================
	// 
	//     ************* Adder Queries and Stuff *****************
	//
	// ===============================================================
if(isset($_POST['addgame'])) {
vsess();
if (isset($_POST['swf']))$swf = $_POST['swf'];
if (isset($_POST['gif']))$gif = $_POST['gif'];
if (isset($_GET['game']))$game = $_GET['game'];
if (isset($_POST['gamename'])&&$_POST['gamename']!='') { 
// if they posted a game name make it take the info from the.
// input rather than the importer file.
$gamename = htmlspecialchars($_POST['gamename'], ENT_QUOTES);
$idname = htmlspecialchars($_POST['idname'], ENT_QUOTES);
$gameheight = htmlspecialchars($_POST['height'], ENT_QUOTES);
$gamewidth = htmlspecialchars($_POST['width'], ENT_QUOTES);
$about = htmlspecialchars($_POST['desc'], ENT_QUOTES);
$gamecat = htmlspecialchars($_POST['gamecat'], ENT_QUOTES);
if (isset($_POST['plattype'])) {
$platform = htmlspecialchars($_POST['plattype'], ENT_QUOTES);
}
$scoretype = htmlspecialchars($_POST['scoretype'], ENT_QUOTES);
} else { // If gamename wasn't posted, then do the importer stuff.
$uploadphp = @move_uploaded_file($_FILES['php']['tmp_name'], "./imports/".$_FILES['php']['name']) ;
if ($uploadphp) { 
// Did the upload fail? If not require in that importer file.
require("./imports/".$_FILES['php']['name']);
$gamename = $config['gtitle'];
$about = $config['gwords'];
$gameheight = $config['gheight'];
$gamewidth = $config['gwidth'];
$idname = $config['gname'];
$platform = 'FL';
$scoretype = $config['highscore_type'];
if ($scoretype == 'high')$scoretype='HI';
if ($scoretype == 'low')$scoretype='LO';
$gamecat = htmlspecialchars($_POST['gamecat'], ENT_QUOTES);
unlink("./imports/".$_FILES['php']['name']);
} else { 
// Failure, display message.
message("The Importer file failed to upload. Check to make sure the imports folder is CHMOD 777.");
}
}
// Method check
$remoteurl = '';
if (isset($_GET['method'])&&$_GET['method']=="upload") {
//==================================
// Uploadable method
//==================================
$gifsend = @move_uploaded_file($_FILES['uploadgif']['tmp_name'], "./arcade/pics/".$_FILES['uploadgif']['name']) ;
$swfsend = @move_uploaded_file($_FILES['uploadswf']['tmp_name'], "./arcade/".$_FILES['uploadswf']['name']);
$plattype = 'FL';
if ($swfsend) { $swf_ok = "Yes"; } 
else { message("The SWF file failed to upload. Make sure the arcade folder <a href=\"arcade/\" target='_new'>exists</a> and is CHMOD 777."); 
}
if ($gifsend) {
$gif_ok = "Yes"; 
} else { 
message("The GIF file failed to upload. Make sure the pics folder <a href=\"arcade/pics\" target='_new'>exists</a> and is CHMOD 777."); 
}
}
//==================================
// End uploadable method , start FTP
//==================================
if (isset($_GET['method'])&&$_GET['method']=="ftp") {
$swf_ok = "Yes";
$gif_ok = "Yes";
$plattype = 'FL';
}
//==================================
// End FTP method , HotLink
//==================================
if (isset($_GET['method'])&&$_GET['method']=="hotlink") {
$swf_ok = "Yes";
$remoteurl = $swf;
$plattype = 'H5';
$gifsend = @move_uploaded_file($_FILES['uploadgif']['tmp_name'], "./arcade/pics/".$_FILES['uploadgif']['name']) ;
if ($gifsend) {
$gif_ok = "Yes"; 
} else { 
message("The GIF file failed to upload. Make sure the pics folder <a href=\"arcade/pics\" target='_new'>exists</a> and is CHMOD 777."); 
}
}
// ============================
// Start Edit
// ============================
$champ='';
$champs='';
$found_swf='';
if (isset($_GET['method'])&&$_GET['method']=="edit") {
global $game;
$editgame = mysql_fetch_array(run_query("SELECT * FROM phpqa_games WHERE gameid='$idname'"));
$champ=$editgame['Champion_name'];
$champs=$editgame['Champion_score'];
$plattype=$editgame['platform'];
run_query("DELETE FROM phpqa_games WHERE gameid='$game'");
$remoteurl = $swf;
$swf_ok = 'Yes';
$gif_ok = 'Yes';
$found_swf = 'Yes';
}
if ($remoteurl == '') {
global $idname;
if (file_exists('./arcade/'.$idname.'.swf')) { 
$found_swf = "Yes";
} else { 
message("The .swf file couldn't be found. You may have uploaded it successfully, but got the games idname wrong."); 
}
} else {
$found_swf = 'Yes';
}
if ($gif_ok == 'Yes' && $swf_ok == 'Yes' && $found_swf == 'Yes') {
global $idname;
if (!isset($plattype))$plattype='FL';
$idname = htmlspecialchars($idname, ENT_QUOTES);
$addedalready = mysql_fetch_array(run_query("SELECT * FROM phpqa_games WHERE gameid='$idname'"));
if (empty($addedalready)) {
$atime = '';
message("Game added/edited. <br>[ <a href='index.php?cpiarea=idx'>Arcade CP Home</a> | <a href='index.php?cpiarea=addgames&method=".$_GET['method']."'>Add Another</a> ]");
run_query("INSERT INTO phpqa_games (game,gameid,gameheight,gamewidth,about,gamecat,remotelink,Champion_name,Champion_score,times_played,platform,scoring) VALUES ('$gamename','$idname','$gameheight','$gamewidth','$about','$gamecat','$remoteurl','$champ','$champs','','$plattype','$scoretype')");
if (!isset($_GET['game'])){
$atime = time();
$NewGtext = "[color=green][i]New Game Added![/i] [/color][size=16] [url=".$arcurl."/index.php?play=".$idname."#playzone][b]".$gamename."[/b][/url][/size]  [color=green][i]Enjoy![/i][/color] [:D]";
run_query("INSERT INTO phpqa_shoutbox (`name`,`shout`,`ipa`,`tstamp`) VALUES ('Admin','" . $NewGtext . "','localhost','".$atime."')", 1);}
} else {
message("This game is already added, or the idname conflicts with an existing game. Please delete the game, or change the idname to correct the problem.");
}
}
}
?>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width='60%' align='center' class='headertableblock' colspan='2'> Adding Game</td><tr>
<form action='' method='POST' enctype="multipart/form-data">
<input type='hidden' name='akey' value='<?php echo $key; ?>'>
<tr><td class='arcade1' align='center' colspan='2'><b>Method: <?php echo $_GET['method']; ?></b></td>
<?php
$what="Add";
//
// What method?
//
if (isset($_GET['method'])&&$_GET['method'] == "upload") {
?>
<tr><td class='arcade1' align='left'><b>Game .SWF file:</b></td>
<td class='arcade1' align='center'><input type='file' name='uploadswf'></td></tr>
<tr><td class='arcade1' align='left'><b>Game .GIF file:</b></td>
<td class='arcade1' align='center'><input type='file' name='uploadgif'></td></tr>
<?php
} elseif(isset($_GET['method'])&&$_GET['method']== "server") {
?>
<tr><td class='arcade1' align='left'><b>Game .SWF file URL:</b></td>
<td class='arcade1' align='center'><input type='text' name='swf'></td></tr>
<tr><td class='arcade1' align='left'><b>Game .GIF file URL:</b></td>
<td class='arcade1' align='center'><input type='text' name='gif'></td></tr>
<?php
} elseif(isset($_GET['method'])&&$_GET['method']== "hotlink") {
?>
<tr><td class='arcade1' align='left'><b>Game File Location (URL):</b></td>
<td class='arcade1' align='center'><input type='text' name='swf' value='./arcade/gamedata/'></td></tr>
<tr><td class='arcade1' align='left'><b>GIF file:</b></td>
<td class='arcade1' align='center'><input type='file' name='uploadgif'></td></tr>
<?php
} elseif(isset($_GET['method'])&&$_GET['method']== "ftp") {
?>
<tr><td class='arcade1' align='left' colspan='2'>The game files have already been uploaded via FTP; now use the form to import or type the details manually.</td></tr>
<?php
} elseif(isset($_GET['method'])&&$_GET['method']== "edit") {
$what = "Edit";
$game=htmlspecialchars($_GET['game'], ENT_QUOTES);
$editgame = mysql_fetch_array(run_query("SELECT * FROM phpqa_games WHERE gameid='$game'"));
if ($editgame['remotelink'] != "") {
?>
<tr><td class='arcade1' align='left'><b>Game File Location (URL): <a href="javascript:alert('This is the link location for the HTML5 index.html for the game');">[?]</a></b></td>
<td class='arcade1' align='center'><input type='text' name='swf' value='<?php echo $editgame['remotelink']; ?>'></td></tr>
<?php
} else {
?>
<tr><td class='arcade1' align='left'><b>.SWF file Status:</b></td>
<td class='arcade1' align='center'>
<?php
$check = file_exists("./arcade/$game.swf");
if ($check) { 
echo "<font color='green'>OK:</font> The swf file is found on your server."; 
} else {
echo "<font color='red'>BAD:</font> The swf file is not found on your server. Please try reuploading it, or correct the idname.";
}
//do we even need this? vvVVvv
?>
<tr><td class='arcade1' align='left'><b>.SWF file URL Hotlink? (do you EVER use this option? addgames.php line: 220) <a href="javascript:alert('Hotlinking means to loads a game from a remote server. If you wish to start hotlinking from another host rather than use the hosting the arcade is on, paste the URL in the box.');">[?]</a></b></td>
<td class='arcade1' align='center'><input type='text' name='swf' value='<?php echo $editgame['remotelink']; ?>'></td></tr>
</td></tr>
<?php
//do we even need this? ''^^``
}
}
?>
<?php
if(isset($_GET['method']) && $_GET['method'] != 'edit') {
global $editgame;
?>
<tr><td class='arcade1' align='center' colspan='2'><b>Attach Importer</b></td>
<tr><td class='arcade1' align='left'><b>Game .PHP file:</b></td>
<td class='arcade1' align='center'><input type='file' name='php'></td></tr>
<tr><td class='arcade1' align='center' colspan='2'><b>or... Enter Game Details</b></td></tr>
<?php
}
?>
<tr>
<td class='arcade1' align='left'><b>Game Name:</b></td>
<td class='arcade1' align='center'><input type='text' name='gamename' value='<?php echo $editgame['game']; ?>'></td></tr>
<tr><td class='arcade1' align='left'><b>Height:</b></td>
<td class='arcade1' align='center'><input type='text' name='height' value='<?php echo $editgame['gameheight']; ?>'></td></tr>
<tr><td class='arcade1' align='left'><b>Width:</b></td>
<td class='arcade1' align='center'><input type='text' name='width' value='<?php echo $editgame['gamewidth']; ?>'></td></tr>
<tr><td class='arcade1' align='left'><b>Idname:</b></td>
<td class='arcade1' align='center'>
<?php if($editgame['gameid']  == '') { 
echo "<input type='text' name='idname' value=''>";
} else { 
echo "<input type='hidden' name='idname' value='".$editgame['gameid']."'> ".$editgame['gameid']."";
} ?>
</td></tr>
<tr><td class='arcade1' align='left'><b>Description:</b></td>
<td class='arcade1' align='center'><textarea rows='5' cols='60' name='desc'><?php echo $editgame['about']; ?></textarea></td></tr>
<!-- added for LO score MOD -->
<tr><td class='arcade1' align='left'><b>Scoring Type:</b></td>
<td class='arcade1' align='center'>
<select size='1' name='scoretype'>
<?php if( isset($editgame['scoring']) && $editgame['scoring'] == 'HI' ) { ?>
<option value='HI' selected>High Score</option>
<option value='LO'>Low Score</option>
<?php } else {?>
<option value='HI'>High Score</option>
<option value='LO' selected>Low Score</option>
<?php }?>
</select>
</td>
</tr>
<tr><td class='arcade1' align='center' colspan='2'><b>Choose A Category</b></td>
<tr><td class='arcade1' align='left'><b>Category Options :</b></td><td class='arcade1' align='center'><select name='gamecat'>
<?php
$catquery=run_query("SELECT * FROM phpqa_cats");
while ($catlist=mysql_fetch_array($catquery)) {
if( isset($editgame['gamecat']) && $editgame['gamecat'] == $catlist[0] ) {
echo  "<option value='".$catlist[0]."' selected='selected'>".$catlist[1]."</option>";
} else {
echo  "<option value='".$catlist[0]."'>".$catlist[1]."</option>";
}
}
?>
</select>
</td></tr>
<tr><td class='headertableblock' colspan='2'><div align=center><input type='Submit' name='addgame' value='<?php echo $what; ?> Game'></div></td></tr>
</form>
</table>
</div>
<br>
<?php
}
}
?>
