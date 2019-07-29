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
# Section: acpi Place: tar_import - Administrator Control Panel   Modified: 7/29/2019   By: MaSoDo

{
$plattype = 'FL';
$thecat="21";
if(isset($_GET['cat'])) $thecat=htmlspecialchars($_GET['cat']);
if(isset($_GET['untar'])) {
vsess();
$tarfile=$_GET['untar'];
$tarfile_name=str_replace(".tar", "", $tarfile);
$tarfile_name=str_replace("game_", "", $tarfile_name);
function untar($file, $dest) {
	if (!is_readable($file)) return false;
	$filesize = filesize($file);
	// Minimum 4 blocks
	if ($filesize <= 512*4) return false;
	if (!preg_match("/\/$/", $dest)) {
		// Force trailing slash
		$dest .= "/";
	}

    $phar = new PharData($file);
    $phar->extractTo($dest); // extract all files

}

// Function to remove folders and files 
    function rrmdir($dir) {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file)
                if ($file != "." && $file != "..") rrmdir("$dir/$file");
            rmdir($dir);
        }
        else if (file_exists($dir)) unlink($dir);
    }

    // Function to Copy folders and files       
    function rcopy($src, $dst) {
        if (file_exists ( $dst ))
            rrmdir ( $dst );
        if (is_dir ( $src )) {
            mkdir ( $dst );
            $files = scandir ( $src );
            foreach ( $files as $file )
                if ($file != "." && $file != "..")
                    rcopy ( "$src/$file", "$dst/$file" );
        } else if (file_exists ( $src ))
            copy ( $src, $dst );
    }


// untar ALL the crap
untar("./tars/$tarfile", "./tars/");
@rename("./tars/$tarfile_name.swf","./arcade/$tarfile_name.swf");
@rename("./tars/{$tarfile_name}1.gif","./arcade/pics/{$tarfile_name}.gif");
@unlink("./tars/{$tarfile_name}2.gif");
if(file_exists("./tars/$tarfile_name.php")) {
require("./tars/$tarfile_name.php");
} else {
message("The tar file is corrupted or invalid, and the game cannot be added, sorry.");
}
if(file_exists("./tars/gamedata/$tarfile_name/$tarfile_name.txt")) {
$scoretype = 'HI';
@mkdir("./arcade/gamedata/$tarfile_name", 0777);
rcopy("./tars/gamedata/{$tarfile_name}" , "./arcade/gamedata/{$tarfile_name}" );
}
@unlink("./tars/{$tarfile_name}.php");
rrmdir("./tars/gamedata/{$tarfile_name}");
//comment out line below to prevent deletion of game file after install
if (file_exists("./tars/" . $tarfile)) unlink("./tars/" . $tarfile);
global $remoteurl, $champ, $champs;
$gamename = $config['gtitle'];
$about = htmlspecialchars($config['gwords'], ENT_QUOTES);
$gameheight = $config['gheight'];
$gamewidth = $config['gwidth'];
$idname = $config['gname'];
if (isset($config['highscore_type'])) {
$scoretype = $config['highscore_type'];
if ($scoretype == 'high')$scoretype='HI';
if ($scoretype == 'low')$scoretype='LO';
} else {
$scoretype = 'HI';
}
$idname = htmlspecialchars($idname, ENT_QUOTES);

$addedalready = mysqli_fetch_array(run_iquery("SELECT * FROM phpqa_games WHERE gameid='$idname'"));
if (!$addedalready) {
$champ = '';
$champs = '';
$atime = '';
if($idname !="") {
run_iquery("INSERT INTO phpqa_games (game,gameid,gameheight,gamewidth,about,gamecat,remotelink,Champion_name,Champion_score,times_played,platform,scoring) VALUES ('$gamename','$idname','$gameheight','$gamewidth','$about','$thecat','$remoteurl','$champ','$champs','','$plattype','$scoretype')");
if ($thecat != 23){ 
$atime = time();
$NewGtext = "[color=green][i]New Game Added![/i] [/color][size=16] [url=".$arcurl."/index.php?play=".$idname."#playzone][b]".$gamename."[/b][/url][/size]  [color=green][i]Enjoy![/i][/color] [:D]";
run_iquery("INSERT INTO phpqa_shoutbox (name,shout,ipa,tstamp) VALUES ('Admin','" . $NewGtext . "','localhost','" . $atime . "')", 1);
}}
} else {
}
}
?>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width='60%' align='center' class='headertableblock' colspan='2'> Adding Game</td><tr>
<?php
if ($handle = opendir('./tars/')) {
   while (false !== ($file = readdir($handle))) { 
       if ($file != "." && $file != ".." && $file != "gamedata") {
$tarfile_name=str_replace(".tar", "", $file);
$idname=str_replace("game_", "", $tarfile_name);
       $addedalready = mysqli_fetch_array(run_iquery("SELECT * FROM phpqa_games WHERE gameid='$idname'"));
?>
<tr><td class='arcade1' align='center'><?php echo $file; ?></td><td class='arcade1' align='center'>[ <?php if(!$addedalready) { ?><a href='?cpiarea=tar_import&untar=<?php echo $file; ?>&cat=<?php echo $thecat; ?>&akey=<?php echo $key; ?>'>Install</a> <?php }  else { echo "Added"; } ?> | <a href='?cpiarea=tar_import&untar=<?php echo $file; ?>&cat=<?php echo $thecat; ?>&akey=<?php echo $key; ?>'>Reupload</a> ]</td></tr>
 <?php
       } 
   }
   closedir($handle); 
}
?>
<tr><td class='arcade1' align='center' colspan='2'><b>Choose A Category</b></td>
<form action='' method='GET' enctype="multipart/form-data">
<tr><td class='arcade1' align='left'><b>Category Option:</b></td><td class='arcade1' align='center'><select name='cat'>
<?php
$catquery=run_iquery("SELECT * FROM phpqa_cats");
 while ($catlist= mysqli_fetch_array($catquery)) {
 
if( $_GET['cat'] == $catlist[0] ) {
echo  "<option value='$catlist[0]' selected='selected'>$catlist[1]</option>";
} else {
echo  "<option value='$catlist[0]'>$catlist[1]</option>";
}

}
?>
</select>
<tr><td class='headertableblock' colspan='2'><div align=center><input type='hidden' name='cpiarea' value='tar_import'><input type='Submit' name='addgame' value='Set Category'></div></td></tr>
</form>
</table>
</div>
<br />
<?php
} 
?>
