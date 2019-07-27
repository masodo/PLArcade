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
# Section: acpi Place: games - Administrator Control Panel   Modified: 7/27/2019   By: MaSoDo


{
?>
<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1' align='center'>Sort: 
<?php
echo "<br /><br />";

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #1
$catquery=run_iquery("SELECT * FROM phpqa_cats");
 while ($catlist= mysqli_fetch_array($catquery)) {
echo  "[ <a href='?cpiarea=games&cat=$catlist[0]'>$catlist[1]</a> ]";
} 
//END UpdatedFunction Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?> 
<a href='?cpiarea=games&showall=1'>Show All</a> &middot; <a href='?cpiarea=games&hotlink=1'>Check Hotlinked</a><br /><br />
<form action='' method='GET'><input type='hidden' name='cpiarea' value='games'><input type='text' name='search' value=''><input type='Submit' value='Search'></form>
</td></tr></table></div><br />
<form action='' method='POST'>
<input type='hidden' name='akey' value='<?php echo $key; ?>'>
<?php
if (isset($_POST['gselect']))$gselect = $_POST['gselect'];
$dowhat = '';
if (isset($_POST['dowhat']))$dowhat = htmlspecialchars($_POST['dowhat'], ENT_QUOTES);
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//		  Admin Actions
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (!is_numeric($dowhat)) {
if ($dowhat == 'deletegame') {
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
vsess();
for($x=0;$x<=count($gselect)-1;$x++){
rrmdir("./arcade/gamedata/$gselect[$x]");
@unlink("./arcade/$gselect[$x].swf");
@unlink("./arcade/pics/$gselect[$x].gif");
$f=htmlspecialchars($gselect[$x], ENT_QUOTES);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #2
run_iquery("DELETE FROM phpqa_games WHERE gameid='$f'");
}
}
if ($dowhat == 'clearscores') {
vsess();
for($x=0;$x<=count($gselect)-1;$x++){
$f=htmlspecialchars($gselect[$x], ENT_QUOTES);
run_iquery("DELETE FROM phpqa_scores WHERE gameidname = '$f'");
run_iquery("DELETE FROM phpqa_leaderboard WHERE gamename = '$f'");
run_iquery("UPDATE phpqa_games SET Champion_name = '' WHERE gameid='$f'");
run_iquery("UPDATE phpqa_games SET Champion_score = '' WHERE gameid='$f'");
}
}

} else {
vsess();
for($x=0;$x<=count($gselect)-1;$x++){
$f=htmlspecialchars($gselect[$x], ENT_QUOTES);
run_iquery("UPDATE phpqa_games SET gamecat = '$dowhat' WHERE gameid='$f'");
}
}
//END UpdatedFunction Block #2
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//		  Game index display
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if (isset($_GET['cat'])) {
$choice = htmlspecialchars($_GET['cat'], ENT_QUOTES);
if(is_numeric($_GET['cat']))$glist = run_iquery("SELECT gameid,game,about,gamecat,Champion_name,Champion_score FROM phpqa_games WHERE gamecat ='$choice' ORDER BY id DESC");
} elseif(isset($_GET['search'])) {
$search=htmlspecialchars($_GET['search'], ENT_QUOTES);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #3
$glist = run_iquery("SELECT gameid,game,about,gamecat,Champion_name,Champion_score from phpqa_games WHERE game like \"%$search%\"  
  order by id");
} elseif(isset($_GET['showall'])) {
	$glist = run_iquery("SELECT gameid,game,about,gamecat,remotelink,Champion_name,Champion_score FROM phpqa_games ORDER BY id DESC");
} elseif(isset($_GET['hotlink'])) {
	$glist = run_iquery("SELECT gameid,game,about,gamecat,remotelink,Champion_name,Champion_score FROM phpqa_games ORDER BY id DESC");
} else {
	$glist = run_iquery("SELECT gameid,game,about,gamecat,remotelink,Champion_name,Champion_score FROM phpqa_games ORDER BY id DESC LIMIT 0,10");
}
//END UpdatedFunction Block #3
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// games function
function displaygames() {
global $g;
if ($g['Champion_score']==""){
$g['Champion_score'] = "------------";
}
if ($g['Champion_name']==""){
$g['Champion_name'] = "--------";
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #4
	$cname = mysqli_fetch_array(run_iquery("SELECT * FROM phpqa_cats WHERE id ='$g[3]'"));
	echo "<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1' class='gameview'><tr><td width='5%' align='center' class='headertableblock'></td><td width='60%' align='center' class='headertableblock'>$g[1]</td><td width='20%' align='center' class='headertableblock'>Top Score</td><td width='15%' align='center' class='headertableblock'>In Category: </td><td width='2%' align='center' class='headertableblock'></td></tr><tr><td class='arcade1' valign='top' align='center'>
<a href='index.php?play=$g[0]'><img height='50' width='50' alt='$g[0]' border='0' src='arcade/pics/$g[0].gif' /></a><br /></td><td class='arcade1'  align='center'>$g[2]<br /><br /><a href='index.php?play=$g[0]'>[Play]</a> <a href='?cpiarea=addgames&method=edit&game=$g[0]'>[Edit Game]</a></td><td class='arcade1' valign='top' align='center'><img alt='image' src='skins/Default/crown1.gif' /><br /><b>$g[Champion_score]</b><br /><a href='index.php?action=profile&amp;user=$g[Champion_name]'>$g[Champion_name]</a><br /><a href='index.php?id=$g[0]'>View Highscores</a></td><td class='arcade1' valign='top' align='center'><a href='index.php?cpiarea=games&cat=$g[3]'>$cname[cat]</a></td><td class='arcade1' valign='top' align='center'><input type='checkbox' name=gselect[] value='$g[0]'></td></tr></table></div><br />";
}
// games function
	while($g=mysqli_fetch_array($glist)){ 	
//END UpdatedFunction Block #4
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// Select from the scores table....
if (isset($_GET['hotlink'])) {
if ($g['remotelink'] != "") {
$quickcheck = @fopen("$g[remotelink]", "r");
if ($quickcheck) {
echo "<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1'>Link check: <a href='$g[remotelink]'>$g[remotelink]</a> (<b><font color='green'>ONLINE</font></b>)</td></tr></table></div>";
} else {
echo "<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1'>Link check <b><font color='red'>DOWN</font></b></td></tr></table></div>";
}
echo "<br />";
displaygames();
}
} else {
displaygames();
}
}
?>
<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1'>
Move to/Perform:<select size="1" name="dowhat">
<optgroup label="Preform Action on Game(s):">
<option value='clearscores'>Clear Scores</option>
<option value='deletegame'>Delete</option>
<optgroup label="Place Game(s) In Category:">
<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #5
$catquery=run_iquery("SELECT * FROM phpqa_cats");
 while ($catlist= mysqli_fetch_array($catquery)) {
//END UpdatedFunction Block #5
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
echo  "<option value='$catlist[0]'>$catlist[1]</option>";
} 
?>
</select>
<input type='Submit' value='Go'>
</td><td width='1px' class='arcade1'><input type='checkbox' onclick="c=document.getElementsByTagName('input');for(x=0;x<c.length;x++) if (c[x].type.toLowerCase()=='checkbox') c[x].checked=this.checked"></td></tr></table></div><br /></form>
<?php
	}

?>
