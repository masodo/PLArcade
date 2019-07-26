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
# Section: GetGame.php - Download Game Script   Modified: 7/26/2019   By: MaSoDo

if (isset($_COOKIE['PHPSESSID'])) {
$key=htmlspecialchars($_COOKIE['PHPSESSID'], ENT_QUOTES);
}
function vsess() {
global $key;
if(isset($_REQUEST['akey']) && $_REQUEST['akey'] != $key) { die("Authorization Mismatch"); }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Updated Function Block #1
//Replacement function for php7 compatibility
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
//END Replacement function for php7 compatibility
//END Updated Function Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function recurse_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 
function rrmdir($dirgone) { 
   if (is_dir($dirgone)) { 
     $objects = scandir($dirgone); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (is_dir($dirgone."/".$object))
           rrmdir($dirgone."/".$object);
         else
           unlink($dirgone."/".$object); 
       } 
     }
     rmdir($dirgone); 
   } 
 }
$mtime=explode(" ",microtime());
require("./arcade_conf.php");

 
try {
vsess();
  //make sure the script has enough time to run (300 seconds  = 5 minutes)
  ini_set('max_execution_time', '300');
  ini_set('set_time_limit', '0');
$gameid = isset($_GET['GID']) ? htmlspecialchars($_GET['GID'], ENT_QUOTES) : '';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Updated Function Block #3
$g = mysqli_fetch_array(run_iquery("SELECT * FROM phpqa_games WHERE gameid='".$gameid."'")); 
//END Updated Function Block #3
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$gcat = $g['gamecat'];
$gheight = $g['gameheight'];
$gname = $g['gameid'];
$gtitle = $g['game'];
$gwidth = $g['gamewidth'];
$gwords = $g['about'];
$hs_type = $g['scoring'];
$object = $g['about'];
$hs_type == 'HI' ? $highscore_type = 'high' : $highscore_type = 'low'; 
$DLtime =  date('Y-m-d H:i:s');
 
 $configfile = "<?php\n/*--------------------------------------------------*/\n/* File Created by PracticalLightning Arcade 1.0!	    */\n/* File Generated:     ".$DLtime."                             */\n/*--------------------------------------------------*/\n\n\$config = array(\n	'active'			=> '1',\n	'bgcolor'			=> '000000',\n	'gcat'			=> '".$gcat."',\n	'gheight'			=> '".$gheight."',\n	'gkeys'			=> '',\n	'gname'			=> '".$gname."',\n	'gtitle'			=> '".$gtitle."',\n	'gwidth'			=> '".$gwidth."',\n	'gwords'			=> '".$gwords."',\n	'highscore_type'			=> '".$highscore_type."',\n	'object'			=> '".$object."',\n	'snggame'			=> '0',\n);\n?>";


$target = "tmp/".$gameid.".tar";
$dir = "tmp/TMP-".$gameid."";
if (!file_exists('tmp/TMP-'.$gameid.''))mkdir('tmp/TMP-'.$gameid.'', 0755);
if (!file_exists('tmp/TMP-'.$gameid.'/gamedata'))mkdir('tmp/TMP-'.$gameid.'/gamedata', 0755);
if (!file_exists('tmp/TMP-'.$gameid.'/gamedata/'.$gameid.''))mkdir('tmp/TMP-'.$gameid.'/gamedata/'.$gameid.'', 0755);
if (file_exists('arcade/gamedata/'.$gameid.'/index.html')) {
recurse_copy('arcade/gamedata/'.$gameid.'','tmp/TMP-'.$gameid.'/gamedata/'.$gameid.'');
}
  $phar = new PharData($target);
  $phar->buildFromDirectory($dir);
  $phar->addFromString($gameid.'.php', $configfile);
  if (file_exists('arcade/'.$gameid.'.swf')) $phar->addFromString($gameid.'.swf',file_get_contents('arcade/'.$gameid.'.swf'));
  $phar->addFromString($gameid.'1.gif',file_get_contents('arcade/pics/'.$gameid.'.gif'));
  
  rrmdir($dir);
} catch (Exception $e) {
  // handle errors
  echo 'An error has occured, details: ';
  echo $e->getMessage();
}

      if(file_exists($target)) {
      
      $file = __DIR__ . "/" .$target;
 
header('Pragma: public');
header('Expires: -1');
header('Cache-Control: public, must-revalidate, post-check=0, pre-check=0');
header('Content-Transfer-Encoding: binary');
header("Content-Disposition: attachment; filename=game_".$gameid.".tar");
header("Content-Type: application/tar");
header("Content-Length: " . filesize($file));
header("Content-Description: File Transfer");
 
if ($fp = fopen($file, 'rb')) {
    ob_end_clean();
 
    while (!feof($fp) and (connection_status() == 0)) {
        print(fread($fp, 8192));
        flush();
    }
 
    @fclose($fp);
    unlink($target);
} }
?>
