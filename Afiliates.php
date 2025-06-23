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
# Section: Afiliates.php  Function: Scrolling Afiliate Banner   Modified: 6/26/2024   By: MaSoDo


$getaffil = run_iquery("SELECT * FROM phpqa_affiliate ORDER BY sort ASC");
echo "<div style='width:80%; height:85px; background-color:black; border:inset; margin-left: auto; margin-right:auto; padding-top: 5px; margin-bottom:25px; color:navy;'>";
echo "<div id='scroller_container4'><div class='jscroller2_left jscroller2_speed-40' style='white-space:nowrap; margin: 0;'>";

while($useaffil = mysqli_fetch_array($getaffil)) {
if ($useaffil['active'] == 1){
echo "<span style='color:silver; font-size: 30px;'> &bull;  &bull;  &bull; </span>";
echo "<a href='".$useaffil['url']."' title='".$useaffil['tag']."' target='_blank'><img src='".$arcurl."/".$bannerloc."/".$useaffil['img']."' border='0' width='400' height='75' /></a>";
}}
echo '<span style="color:silver; font-size: 30px;"> &bull;  &bull;  &bull; </span>';
echo '</marquee>';
echo '</div>';
?>
