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
# Section: acpi Place: editor - Administrator Control Panel   Modified: 2/28/2019   By: MaSoDo

{ 
$skin=htmlspecialchars($_GET['skin'], ENT_QUOTES);
$skin=str_replace("..","", $skin);
if (isset($_POST['skinedit'])) {
vsess();
// IPB 1.3 skin allowance
$_POST['cssforarcade']=str_replace("maintitle","headertableblock", $_POST['cssforarcade']);
$_POST['cssforarcade']=str_replace("row1","arcade1", $_POST['cssforarcade']);
$acss = @fopen("./skins/$skin","w");
fwrite($acss,stripslashes($_POST['cssforarcade']));
if($acss) { message("Changes written successfully"); } else { message("Changes failed to be written. Please check permissions on your skin files and folder."); }
}
$ARCADECSS = @file_get_contents("./skins/$skin");
if($ARCADECSS=="") $ARCADECSS="File not found";
 message("<form method='post' action='?cpiarea=editor&skin=$skin'><input type='hidden' name='akey' value='$key'><textarea rows='40' cols='60' name='cssforarcade'>$ARCADECSS</textarea><br /><input type='submit' name='skinedit' value='Edit Stylesheet'></form>");
} 


?>