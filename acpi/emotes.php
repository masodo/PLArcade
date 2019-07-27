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
# Section: acpi Place: emotes - Administrator Control Panel   Modified: 7/27/2019   By: MaSoDo

{ ?>
<?php
if (isset($_GET['remove'])) {
vsess();
$remove = $_GET['remove'];

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #1
run_iquery("delete FROM phpqa_emotes where filename='".$remove."'");
}
if (isset($_POST['face']))$face = $_POST['face'];
if (isset($_POST['pic']))$pic = $_POST['pic'];
if (isset($_POST['description']))$description = $_POST['description'];
if (isset($_POST['face'])) {
vsess();
run_iquery("INSERT into phpqa_emotes (id,filename,code,description) VALUES ('','".$pic."','".$face."','".$description."')");
}
$emotesdata = run_iquery("SELECT * FROM phpqa_emotes");
?>
<br>
<?php
echo "<div class='tableborder'><table width=50% cellpadding='4' cellspacing='1'><td width=20% align=center class=headertableblock>Face</td><td width=500% align=center class=headertableblock>Description</td><td width=10% align=center class=headertableblock>Preview</td><td width=60% align=center class=headertableblock>Remove</td>";
	// display
while($smils=mysqli_fetch_array($emotesdata)){
//END UpdatedFunction Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo "<tr><td class=arcade1>".$smils['code']."</td><td class=arcade1><div align=center>".$smils['description']."</div></td><td class=arcade1><div align=center><img src='".$smiliesloc."/".$smils['filename']."'></div></td><td class=arcade1><a href='?cpiarea=emotes&remove=".$smils['filename']."'>Remove</a></td></tr>";
}
echo "</table><p>&nbsp;</p></div>";
?>
<form action='index.php?cpiarea=emotes' method='POST'>
<input type='hidden' name='akey' value='<?php echo $key; ?>'>
<br />
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=60% align=center class=headertableblock>Add Emoticon</td><tr><td class=arcade1>
<div align=center>Code:<input type='text' name='face'> Description:<input type='text' name='description'>
Image: 
	    <select name="pic">
<?php
echo "<option value=':)' selected>Select an image</option>";
$dir = "./".$smiliesloc."/";
   if ($dh = opendir($dir)) {
       while (($file = readdir($dh)) !== false) {
 if ($file == "." || $file == "..") continue;
echo "<option value='".$file."'>".$file."</option>";
       }
       closedir($dh);
   }
?>
</select>
<input type='Submit' name='Submit' value='Add Emoticon'></div>
</td></tr></table></div>
</form>
<?php
}
echo "<h2>Hover over image below to see it's filename. Find it to select above.</h2>";
$dir2 = "./".$smiliesloc."/";
   if ($dh2 = opendir($dir)) {
       while (($file = readdir($dh2)) !== false) {
 if ($file == "." || $file == "..") continue;
 echo "<a title='".$file."'><img src='".$smiliesloc."/".$file."' /></a></option>";
 }
       closedir($dh2);
 
}
?>
