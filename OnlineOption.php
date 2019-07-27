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
# Section: OnlineOption.php  Function: Show User Activity   Modified: 7/27/2019   By: MaSoDo
?>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width=30% align=center class=headertableblock>User</td><td width=40% align=center class=headertableblock>Last Refresh</td><td width=50% align=center class=headertableblock>Location</td>
<?php
$how='name';
if(isset($_GET['method']) && $_GET['method'] != "name") $how='time';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #1
$online=run_iquery("SELECT * FROM phpqa_sessions ORDER by $how DESC");
while($g=mysqli_fetch_array($online)){ 
	$onnow = run_iquery("SELECT `group` FROM `phpqa_accounts` WHERE `name` = '" . $g['name'] . "'");
        $onnowGrp=mysqli_fetch_array($onnow);
if($g['location']=="") $g['location']="Viewing Arcade Index";
$parse_stamp = date($datestamp, $g['time']);
echo "<tr><td class=arcade1><a href='?action=profile&user=$g[name]' title='' class='".$onnowGrp['group']."Look'>$g[name]</a></td><td class=arcade1><div align=center>".$parse_stamp."</div></td><td class=arcade1>";
if (preg_match("/Playing Game/i", $g['location'])) { 
$nameandid=explode("Playing Game: ", $g['location']);
$id=explode("|",$nameandid[1]);
echo "Playing Game: <a href='index.php?play=".$id[1]."'>".$id[1]."</a>";
} else {
echo $g['location'];
}
echo "</td></tr>";
}
//END UpdatedFunction Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>
</td></tr></table></div><br />
