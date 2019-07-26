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
# Section: fullout.php  Function: Play Flash Games Fullscreen   Modified: 7/26/2019   By: MaSoDo
if (isset($_GET['dofull'])) 
{
$BigGame = $_GET['dofull'];
$H = $_GET['H'];
$W = $_GET['W'];
$H = ($H * 2);
$W = ($W * 2);
}
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="100%" height="100%" align="middle"> <param name="movie" value="arcade/<?php echo "". $BigGame ."" ?>"><param name="quality" value="high"> <param name="allowScriptAccess" value="sameDomain"> <param name="menu" value="false"> <embed src="<?php echo "arcade/". $BigGame ."" ?>" quality="high" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" menu="false" type="application/x-shockwave-flash" width="100%" height="100%" align="middle"></object>
