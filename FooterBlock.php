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
# Section: FooterBlock.php  Function: Bottom of Pages   Modified: 2/28/2019   By: MaSoDo

if(isset($settings['enable_onlinelist'])) {
require "./OnlineListOption.php";
}
?>
<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1'><?php echo date("md")=="0401"?"Gilligans Arcade":"<a href='https://github.com/masodo/PLArcade' target='_blank' style='color:white;'><b>Practical-Lightning-Arcade [PLA] 1.0 </b> (BETA)</a>"; ?> based on <b>PHP-Quick-Arcade 3.0</b> &copy; <a href='http://Jcink.com'>Jcink.com</a><br />Tournaments & JS By: <a href='http://seanj.jcink.com'>SeanJ</a>. -  Heavily Modified by <font size="2" face="Lucida Console"><b><a href="http://www.practicallightning.com" target="_blank">practical<sub><img src="http://infinitelyremote.dynu.net/image-box/PL_logo_sm.gif" alt="PracticalLightning.com" border="0"></sub>lightning</a></b></font> Web Design [<i><a title='DeBurger Photo Image &amp; Design'>DPI&ampD</a></i>]</td><td class='arcade1'><?php $mtime2=explode(" ",microtime()); echo "Execution Time: ".($mtime2[1]-$mtime[1]).substr($mtime2[0]-$mtime[0],1)."</td><td class='arcade1'>Queries Used: ".count(run_query());?></td></tr></table></div></div><br />
<?php
include "Afiliates.php";
?>
<p align="center"><a href="<?php echo $arcurl; ?>/index.php?action=leaderboards" title="Join the hunt!"><img src="<?php echo $imgloc; ?>/<?php echo $toetag; ?>" alt="Its A Good Day!" style="padding:5px; background-color:silver;" /></a></p>
<?php ob_end_flush(); ?><a name="bottom" id="bottom"></a>
</body>
</html>
