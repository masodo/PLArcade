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
# Section: Categories.php  Function: Display Categories w/Icons   Modified: 6/5/2019   By: MaSoDo
global $catquery;
$c=@mysql_data_seek($catquery,0);
if($c) {
 echo "<div style='text-align: center; margin-bottom: 5px; margin-top: 5px;'>";
 //Begin Collapse #3
 echo "<a title='Open/Close The Category Selections'><img id='btn3' src='$imgloc/$collimg3' type='button' alt='&#8595; Categories: Collapse/Expand &#8595;' onclick='return CollapseExpand3()' style='font-size:16px; font-weight:bold; color:silver;' /></a></div><div id='MyDiv3' class='" . $collapset3 . "'>";
 echo "<table width='100%' cellpadding='4' cellspacing='1' class='tableborder'><tr><td class='headertableblock' style='font-weight:bold; text-align:center;'>Categories:</td><tr><td><div style='width:100%;height:auto;'>";
while ($c = mysql_fetch_array($catquery)) {
if ($c[0] != '2') {
echo  "<div style='width: 55px; height: 55px; padding: 10px; float: left; margin-right: 5px; margin-bottom: 5px; text-align:center;' class='arcade1'><a href='index.php?cat=$c[0]' title='$c[1]'><img src='$catloc/$c[1].png' style='width:35px; height:35px;' /><br />$c[1]</a></div>";
} }
echo"</div></td></tr></div></table><br />";
// End Collapse #3
echo "</div>";
}
?>
