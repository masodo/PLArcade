<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 1.0 (ALPHA) based on PHP-Quick-Arcade 3.0 © Jcink.com
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
# Section: MembersOption.php  Function: Show the Members List   Modified: 2/28/2019   By: MaSoDo

$q=run_query("SELECT `name`,`group`,`skin` FROM phpqa_accounts ORDER BY name ASC");
echo "<table class='tableborder'><tr><td class='headertableblock'>Username</td><td class='headertableblock'>Group</td><td class='headertableblock'>Skin</td></tr>";
while ($f=mysql_fetch_array($q)) echo "<tr><td class='arcade1'><a href='?action=profile&amp;user=".$f[0]."'>".$f[0]."</a></td><td class='arcade1'>".$f[1]."</td><td class='arcade1'>".$f[2]."</td></tr>";
$total=mysql_num_rows($q);
echo "</table><br /><table width='100%' cellpadding='4' cellspacing='1'class='tableborder'><tr><td class='arcade1'>Total Registered Members: $total</td></tr></table><br /><div align='center'>";
?>
