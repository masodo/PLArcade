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
# Section: Categories.php  Function: Display Categories w/Icons   Modified: 6/26/2019   By: MaSoDo
global $catquery;
$c=@mysql_data_seek($catquery,0);
$catcell = '';
$caticon = '';
$catcnt = '';
(isset($settings['catdiv'])&&$settings['catdiv']!='')?$catcell = $settings['catdiv']:$catcell = '80';
(isset($settings['catimg'])&&$settings['catimg']!='')?$caticon = $settings['catimg']:$caticon = '60';
if($c) {
 echo "<div style='text-align: center; margin-bottom: 5px; margin-top: 5px;'>";
 //Begin Collapse #3
 echo "<a title='Open/Close The Category Selections'><img id='btn3' src='$imgloc/$collimg3' type='button' alt='&#8595; Categories: Collapse/Expand &#8595;' onclick='return CollapseExpand3()' style='font-size:16px; font-weight:bold; color:silver;' /></a></div><div id='MyDiv3' class='" . $collapset3 . "'>";
 echo "<table width='100%' cellpadding='4' cellspacing='1' class='tableborder'><tr><td class='headertableblock' style='font-weight:bold; text-align:center;'>Categories:</td><tr><td><div style='width:100%;height:auto;'>";
while ($c = mysql_fetch_array($catquery)) {
$catcnt = run_query("(SELECT COUNT(*) as total FROM `phpqa_games` WHERE `gamecat` = ".$c[0].")");
$dcat=mysql_fetch_assoc($catcnt);
if (($c[0] != '2')&&($c[0] != '23')) {
echo  "<div style='width: ".$catcell."px; height: ".$catcell."px; padding: 10px; float: left; margin-right: 5px; margin-bottom: 5px; text-align:center;' class='arcade1'><a href='index.php?cat=".$c[0]."' title='".$c[1]." (".$dcat['total'].")'><img src='".$catloc."/".$c[1].".png' style='width:".$caticon."px; height:".$caticon."px;' /><br />$c[1]</a><br /><span style='font-size:9px; color:#000;'>(".$dcat['total'].")</span></div>";
} }
if (isset($exist[6])&&$exist[6] == "Admin") {
echo  "<div style='width: ".$catcell."px; height: ".$catcell."px; padding: 10px; float: left; margin-right: 5px; margin-bottom: 5px; text-align:center;' class='arcade1'><a href='index.php?cat=2' title='Dead (".$dcat['total'].")'><img src='".$catloc."/Dead.png' style='width:".$caticon."px; height:".$caticon."px;' /><br />Dead</a><br /><span style='font-size:9px; color:#000;'>(".$dcat['total'].")</span></div>";
echo  "<div style='width: ".$catcell."px; height: ".$catcell."px; padding: 10px; float: left; margin-right: 5px; margin-bottom: 5px; text-align:center;' class='arcade1'><a href='index.php?cat=23' title='Testing (".$dcat['total'].")'><img src='".$catloc."/Testing.png' style='width:".$caticon."px; height:".$caticon."px;' /><br />Testing</a><br /><span style='font-size:9px; color:#000;'>(".$dcat['total'].")</span></div>";

}
echo"</div></td></tr></div></table><br />";
// End Collapse #3
echo "</div>";
}
?>
