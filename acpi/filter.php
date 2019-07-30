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
# Section: acpi Place: filter - Administrator Control Panel   Modified: 7/29/2019   By: MaSoDo

{ ?>
<div class='tableborder'>
<div class='arcade1'><center>
<table width='50%' border='0' cellspacing='0' cellpadding='4'>
<tr><td class='arcade1' width='100%' >
<div class="tableborder" style="padding: 0px;">
<table border="0" cellpadding="1" cellspacing="1" width="100%">
    <tr>
        <td class="arcade1" style="padding: 8px 8px 8px; width: 100%">
<?php
if (isset($_POST['editban'])) {
vsess();
$slash = stripslashes($_POST['cssforarcade']);
$ARCADECSS = "badwords.txt";
$ArcadeCSSOpen = fopen($ARCADECSS,"w") or die ("Error editing.");
fputs($ArcadeCSSOpen,$slash);
fclose($ArcadeCSSOpen) or die ("Error Closing File!");
}
?>
<form method='post' action="?cpiarea=filter">
<input type='hidden' name='akey' value='<?php echo $key; ?>'>
Add new word filters here. Put one word per line in the textbox below.<br /><br />They are not case sensitive, and the filter is loose. <br /><br />For example, censoring "hell" will also censor "hellhole", "hellish", etc.<br /><br />
<textarea rows="10" cols="40" name="cssforarcade">
<?
// Implode CSS
$ARCADECSS = "badwords.txt";
print (implode("",file($ARCADECSS)));
?>
</textarea><br />
                <br />
	<input type="submit" value="Edit filters" name="editban">
	</form></table></table></div></div><br>
<?php } 
?>
