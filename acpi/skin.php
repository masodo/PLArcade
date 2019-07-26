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
# Section: acpi Place: skin - Administrator Control Panel   Modified: 7/26/2019   By: MaSoDo

 {
if (isset($_GET['skinremove'])) {
vsess();
if ($_GET['skinremove'] == "Default.css") {
message("You cannot remove the default skin.");
} else {
@unlink("./skins/".$_GET['skinremove']);
}
}
?>
<div align='center'>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=60% align=center class=headertableblock>Skin Name</td><td width=10% align=center class=headertableblock>Delete</td><td width=60% align=center class=headertableblock>Modify</td><td align='center' class='headertableblock'>Preview</td><tr>
<?php 
if (isset($_POST['addcssfile'])) {
	vsess();
$fp = fopen("./skins/".$_POST['skincssfilename'].".css","w+");
}
?>
<div align=center><?php
if ($handle = opendir('./skins/')) {
   while (false !== ($file = readdir($handle))) { 
       if ($file != "." && $file != "..") {
if (!is_dir("./skins/$file")) {
           echo "<td class=arcade1>$file</td><td class=arcade1><a href='index.php?cpiarea=skin&skinremove=$file&akey=$key'><div align=center>[X]</div></a></td><td class=arcade1 align='center'><a href='index.php?skin=$file&cpiarea=editor'>[Edit CSS]</a></td><td class='arcade1'><a href='javascript:document.getElementsByTagName(\"link\")[0].href=\"skins/$file\";void(0);'>[Preview]</a></td></tr>"; 
}
       } 
   }
   closedir($handle); 
}?></table></div><br>
<div align='center'><div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9><b><font size=-5>Make new CSS File</font></b></td></tr><td width=50%% align=center class=arcade1><font size=-5>New CSS File name (leave out .css)</font></td><td width=10% align=center class=arcade1><font size=-5>Action</font></td></div><tr><td class=arcade1> <form method=post action="?cpiarea=skin"><input type='hidden' name='akey' value='<?php echo $key; ?>'><div align=center><input type=text name=skincssfilename></center> </div></td><td class=arcade1><div align=center><input type='submit' value='Add' name='addcssfile'></div></td></table></div></form><br />
<?php } 


?>
