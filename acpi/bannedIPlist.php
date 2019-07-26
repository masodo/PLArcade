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
# Section: acpi Place: bannedIPlist - Administrator Control Panel   Modified: 7/26/2019   By: MaSoDo

{ 
message("Ban one IP below per line. You can also range ban by only putting part of the IP, e.g. 123.45.67.89 -> 123.45");
?>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><tr><td width=30% align=center class=headertableblock>Banned IP addrresses</td></tr><tr><td class='arcade1' align='center'>
<?php
if (isset($_POST['editban'])) {
	vsess();
$ArcadeBAN = fopen("./".$textloc."/banned.txt","w");
fputs($ArcadeBAN,htmlspecialchars($_POST['cssforarcade'], ENT_QUOTES));
}
?>
 	<form method=post action="?cpiarea=bannedIPlist">
	<?php echo "<input type='hidden' name='akey' value='$key'>"; ?>
<textarea rows="40" cols="60" name="cssforarcade">
<?php
// Implode CSS
print (implode("",file("./".$textloc."/banned.txt")));
?>
</textarea><br /><input type="submit" value="Edit Banned IPs" name="editban">
	</form></td></tr></table></div><br />
<?php 
} 
?>
