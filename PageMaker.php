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
# Section: PageMaker.php  Function: Makes Pages/Paging   Modified: 5/31/2019   By: MaSoDo

// =====================
// Makes pages
// You know what? I'm not even sure WHAT I just did here, 
// but it works. :)
// =====================
if(!empty($_GET['plat'])) $plat = $_GET['plat'];
if(!empty($_GET['cat'])) $cat = $_GET['cat'];
if(isset($_GET['fav'])) $favstuff='&fav=1';
if(!isset($_GET['page']))$_GET['page']=1;
$total=$arcadetotalcat/$num_pages_of;
$pagnam=explode(".",$total);
if(count($pagnam)==2) $total=$pagnam[0]+1;
$pgn_sub=$_GET['page']-2;
if($pgn_sub == 0 || $pgn_sub < 0) $pgn_sub=1;
$pag_lim=$pgn_sub*$num_pages_of;
unset($first_p);
unset($next_p);
unset($pag_next);
unset($pagN_lim);
unset($last_p);
unset($all_pag);
if($_GET['page'] > 3) {
global $plat;
global $cat;
$first_p="<a href='index.php?" . (!empty($_GET['plat']) ?"plat=".$plat."&amp;":"") . (!empty($_GET['cat']) ?"cat=".$cat."&amp;":"") . "limit=0&amp;show=$num_pages_of&amp;page=1&arcade=1{$favstuff}'>&laquo First </a>... ";
$pag_next=2;
$pagN_lim = $num_pages_of;
}
for($pag_gen=$pgn_sub;$pag_gen<$total+1;$pag_gen++) {
global $page_gen;
$pgl_real=$pag_lim-$num_pages_of;
$pgn_real=$page_gen+1;
if(isset($_GET['page']) && $_GET['page']== "$pag_gen") {
$pag_next = $pag_gen +1; 
$pagN_lim = $pag_gen * $num_pages_of;
global $all_pag;
$all_pag.="[ $pag_gen ] ";
} else {
global $plat;
global $cat;
global $all_pag;
global $pag_next;
global $pagN_lim;
$all_pag.="<a href='index.php?" . (!empty($_GET['plat']) ?"plat=".$plat."&amp;":"") . (!empty($_GET['cat']) ?"cat=".$cat."&amp;":"") . "limit=$pgl_real&amp;show=$num_pages_of&amp;page=$pag_gen&arcade=1{$favstuff}'>$pag_gen</a> ";
}
$pag_lim+=$num_pages_of;
$next_p="<br /><a href='index.php?" . (!empty($_GET['plat']) ?"plat=".$plat."&amp;":"") . (!empty($_GET['cat']) ?"cat=".$cat."&amp;":"") . "limit=".$pagN_lim."&amp;show=".$num_pages_of."&amp;page=".$pag_next."&arcade=1{$favstuff}'><b>[&nbsp;NEXT&nbsp;]</b> &raquo</a>";
if($pgn+2 == $pag_gen)  {
global $plat;
global $cat;
$lastlim=$arcadetotalcat-1;
$last_p="<a href='index.php?" . (!empty($_GET['plat']) ?"plat=".$plat."&amp;":"") . (!empty($_GET['cat']) ?"cat=".$cat."&amp;":"") . "limit=".$lastlim."&amp;show=".$num_pages_of."&amp;page=".$total."&arcade=1{$favstuff}'>Last &raquo</a>";break;
}
}
$pagination='';
if($total!=1) {
global $first_p;
global $all_pag;
global $next_p;
global $last_p;
$pagination="Pages: ($total) $first_p $all_pag $next_p $last_p"; 
}
if (isset($_GET['plat']) && $_GET['plat'] == 'FL')$arcadetotalcat=$CPF;
if (isset($_GET['plat']) && $_GET['plat'] == 'H5')$arcadetotalcat=$CPH;
if (!isset($_GET['action'])&&!isset($_GET['play'])&&!isset($_GET['id'])&&!isset($_GET['cparea'])&&!isset($_GET['cpiarea'])&&!isset($_GET['modcparea'])&&!isset($_GET['shoutbox'])) echo "<div class='tableborder'><table width='100%' cellpadding='1' cellspacing='1'><tr><td class='arcade1' align='center'><table width='100%'><tr><td style='text-align:left;width:250px;'>$pagination</td><td style='text-align:center'>There are ".($arcadetotalcat)." games in this category</td><td style='text-align:right;width:150px;'></td></tr></table></td></tr></table></div><br />";
?>
