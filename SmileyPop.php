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
# Section: SmileyPop.php  Function: Emoticon Picker Popup   Modified: 3/18/2019   By: MaSoDo

if(isset($_GET['action']) && $_GET['action']=="emotes") {
echo "<div class='tableborder' width='75%' style='margin-top: 10px; margin-right: auto; margin-left: auto; margin-bottom: 10px;'><table width='100%' cellpadding='4' cellspacing='1'><tr><td width='60%' align='center' class='headertableblock'>Emote</td><td width='60%' align='center' class='headertableblock'>Symbol</td></tr><tr>";
for($x=1;$x<count($smilies);$x++) {
$trim = htmlspecialchars(trim($smilies[$x]),ENT_QUOTES);
echo "\n<tr onclick=\"window.opener.document.forms['boxform'].elements['senttext'].value+='$trim'\"><td class='arcade1' align='left'><img src=\"emoticons/$smiliesp[$x]\"><br /></td><td class='arcade1' align='center'>$trim</td></tr>";
}
echo "</table></div>";
die();
}
?>
