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
# Section: acpi Place: epoch - Administrator Control Panel   Modified: 2/28/2019   By: MaSoDo
$epoch = '';
$showepoch = time();
if (isset($_GET['hh'])) {
$hour = $_GET['hh'];
$minute = $_GET['mn'];
$second = $_GET['ss'];
$month= $_GET['mm'];
$day = $_GET['dd'];
$year = $_GET['yyyy'];
date_default_timezone_set('EST');  // optional
$epoch = mktime ( $hour, $minute, $second, $month, $day, $year );
}
?>
<div style="text-align:center; width:180px; height;150px; float:left; border-right: solid silver; color: white;">
<form name="hf" id="hf" method="get" action="epoch.php">
<table style="color:white;">
<tbody><tr><td>Mon</td><td>Day</td><td>Yr </td></tr>
<tr><td><input size="2" maxlength="2" value="1" name="mm" type="text">&nbsp;/&nbsp;</td>
<td><input size="2" maxlength="2" value="1" name="dd" type="text">&nbsp;/&nbsp;</td>
<td><input size="4" maxlength="4" value="2019" name="yyyy" type="text">&nbsp;</td> </tr></tbody></table>
<table class="tool" style="color:white;"><tbody>
<tr><td>Hr</td><td>Min</td><td>Sec </td></tr>
<tr><td><input size="2" maxlength="2" value="0" name="hh" type="text">&nbsp;:&nbsp;</td><td><input size="2" maxlength="2" value="0" name="mn" type="text">&nbsp;:&nbsp;</td>
<td><input size="2" maxlength="2" value="0" name="ss" type="text">&nbsp;</td>
</tr></tbody></table><table><tbody>
<tr><td>&nbsp;<br><button type="submit" title="Human to EPOCH">Human to EPOCH</button></td>
</tr></tbody></table></div>
<div style="text-align:center; width:300px; height;150px; float:right; padding-top: 15px;">
<div style="color: silver; margin-bottom: 15px; font-size:12px;">Current EPOCH STAMP:<br /><span style="font-size:28px;"><?php echo($showepoch); ?></span></div>
<div style="color: green; margin-bottom: 15px; font-size:12px;">Requested EPOCH STAMP:<br /><span style="font-size:42px;"><?php echo($epoch); ?></span></div>
</div>
</form>

