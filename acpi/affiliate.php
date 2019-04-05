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
# Section: acpi Place: affiliates - Control Panel   Modified: 4/5/2019   By: MaSoDo

{
message("Affiliate Manager:");

}

$affiliatedata=run_query("SELECT * FROM phpqa_affiliate ORDER BY `sort` ASC"); 

?>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><tr><td width=30% align=center class=headertableblock>URL</td><td width=20% align=center class=headertableblock>BANNER</td><td width=70% align=center class=headertableblock>TAG</td><td width=20% align=center class=headertableblock>IMAGE</td><td width=20% align=center class=headertableblock>SORT</td><td width=60% align=center class=headertableblock>KEY</td></tr>
<?php
	while($A=mysql_fetch_array($affiliatedata)){ 
?>
<tr><td class=arcade1 align='left'><a href='<?php echo $A['url']; ?>'><?php echo $A['url']; ?></a></td><td class=arcade1 align='center'><img src='<?php echo($arcurl)?>/<?php echo($bannerloc)?>/<?php echo($A['img'])?>' border='0' width='100' height='20' /></td><td class=arcade1><div align=center><?php echo $A['tag']; ?></td><td class=arcade1><div align=center><?php echo $A['img']; ?></td><td class=arcade1><div align=center><?php echo $A['sort']; ?></td><td class=arcade1><div align=center><?php echo $A['key']; ?></td></tr>
<?php } ?>
<tr><td class='headertableblock' colspan='5'><div align=center>Hello World!</div></td></tr>
</table></div><br>
