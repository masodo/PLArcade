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
# Section: acpi Place: cats - Administrator Control Panel   Modified: 7/29/2019   By: MaSoDo
{ 
if(isset($_GET['do'])&&$_GET['do']=="delete") {
vsess();
if(!is_numeric($_POST['gamecat'])) die ();

run_iquery("DELETE FROM phpqa_cats WHERE id = '$_POST[gamecat]'");
}
?>
<div align='center'><div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9><b><font size=-5>Categories</font></b></td></tr><td class=arcade1 align='center'>
<form action='?cpiarea=cats&do=delete' method='POST'>
<input type='hidden' name='akey' value='<?php echo $key; ?>'>
Manage game cats below. Note: if you delete a cat, all the games within that cat will not be deleted.<br /> <br />
<select name='gamecat'>
<?php
$newcatname=htmlspecialchars($_POST['newcatname'], ENT_QUOTES);
if(isset($_GET['do'])&&$_GET['do']=="create") { 
global $newcatname;
echo "<script>alert('New: ".$newcatname."')</script>";
	vsess();
	run_iquery("INSERT INTO phpqa_cats (cat) VALUES ('$newcatname')");
}
$catquery=run_iquery("SELECT * FROM phpqa_cats");
 while ($catlist= mysqli_fetch_array($catquery)) {
 
echo  "<option value='$catlist[0]'>$catlist[1]</option>";
}
?>
</select><input type='submit' name='erase' value='Delete'>
</form>
<br /><br />
<form action='?cpiarea=cats&do=create' method='POST'>
<input type='hidden' name='akey' value='<?php echo $key; ?>'>
<input type='text' name='newcatname'>
<input type='submit' name='create' value='Add Category'>
</form>
</div></div></td></table></div><br />
<?php }
?>
