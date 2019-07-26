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
# Section: PageMakerB.php  Function: Makes Pages/Paging Bottom  Modified: 7/26/2019   By: MaSoDo
global $total;
if($total!=1) {
global $first_p;
global $all_pag;
global $next_p;
global $last_p;
$pagination="Pages: ($total) $first_p $all_pag $next_p $last_p"; 
}
if (isset($_GET['plat']) && $_GET['plat'] == 'FL')$arcadetotalcat=$CPF;
if (isset($_GET['plat']) && $_GET['plat'] == 'H5')$arcadetotalcat=$CPH;
if (!isset($_GET['action'])&&!isset($_GET['play'])&&!isset($_GET['id'])&&!isset($_GET['cparea'])&&!isset($_GET['cpiarea'])&&!isset($_GET['modcparea'])&&!isset($_GET['shoutbox'])) echo "<div class='tableborder'><table width='100%' cellpadding='1' cellspacing='1'><tr><td class='arcade1' align='center'><table width='100%'><tr><td style='text-align:left;width:225px;'>$pagination</td><td style='text-align:center'>There are ".($arcadetotalcat)." games in this category</td><td style='text-align:right;width:150px;'></td></tr></table></td></tr></table></div><br />";
?>
