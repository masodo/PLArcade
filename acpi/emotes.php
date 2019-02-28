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
# Section: acpi Place: emotes - Administrator Control Panel   Modified: 2/28/2019   By: MaSoDo

{ ?>
<?php
$remove=isset($_GET['remove']);
if (isset($_GET['remove'])) {
$file = $textloc."/emotes_faces.txt";
$array=file($file); 
$file2=fopen($file, "w"); 
foreach($array as $k=>$v){ 
if ($k == $remove || $v == "" ){ 
continue; 
} 
fwrite($file2, $v); 
} 
fclose($file2); 
$file = $textloc."/emotes_pics.txt";
$array=file($file); 
$file2=fopen($file, "w"); 
foreach($array as $k=>$v){ 
if ($k == $remove || $v == "" ){ 
continue; 
} 
fwrite($file2, $v); 
} 
fclose($file2);
}
if (isset($_POST['face']))$face = $_POST['face'];
if (isset($_POST['pic']))$pic = $_POST['pic'];
if (isset($_POST['face'])) {
vsess();
$smilefile = fopen($textloc."/emotes_faces.txt", "a");
fwrite($smilefile,  "$face\n" );
$imagefile = fopen($textloc."/emotes_pics.txt", "a");
fwrite($imagefile,  "$pic\n" );
}
$smilies = file($textloc."/emotes_faces.txt");
$smiliesp = file($textloc."/emotes_pics.txt");
?>
<br>
<?php
echo "<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=60% align=center class=headertableblock>Face</td><td width=10% align=center class=headertableblock>Preview</td><td width=60% align=center class=headertableblock>Remove</td>";
	// display
for($x=1;$x<count($smilies);$x++) {
echo "<tr><td class=arcade1>$smilies[$x]</td><td class=arcade1><div align=center><img src='emoticons/$smiliesp[$x]'></div></td><td class=arcade1><a href='?cpiarea=emotes&remove=$x'>Remove</a></td></tr>";
}
echo "</table></div>";
?>
<form action='index.php?cpiarea=emotes' method='POST'>
<input type='hidden' name='akey' value='<?php echo $key; ?>'>
<br />
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=60% align=center class=headertableblock>Add Emoticon</td><tr><td class=arcade1>
<div align=center>Face/action:<input type=text name=face>
Image: 
	    <select name="pic">
<?php
echo "<option value=':)' selected>Select an image</option>";
$dir = "./emoticons/";
   if ($dh = opendir($dir)) {
       while (($file = readdir($dh)) !== false) {
 if ($file == "." || $file == "..") continue;
echo "<option value='$file'>$file</option>";
       }
       closedir($dh);
   }
?>
</select>
<input type='Submit' name='Submit' value='Add Emoticon'></div>
</td></tr></table></div>
</form>
<?php } 


?>
