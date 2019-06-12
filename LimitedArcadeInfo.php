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
# Section: ArcadeInfo.php  Function: Latest Site Info Block   Modified: 6/11/2019   By: MaSoDo
?>
<br />
<div align="center">
<table>
<td colspan="3" class="arcade1" align="center">
<?php
if (!isset($_COOKIE['phpqa_user_c'])) {
// begin nav buttons
?>
<div style="width: 100%; text-align: center; margin-left: auto; margin-right: auto;"><a name="Login"></a><div class="navigation">Logged off: [ <a href="javascript:tog('login_form')">Login</a> ]</div><div class="navigation">[ <a href="index.php?action=register#registration">Register</a> ] </div><div class="navigation"><a href="http://DeBurger.com">DeBurger.com</a></div>
<div style="display:none" id="login_form" name="tog_collect"><br /><br /><br /><form method="post" action="?action=login"> Name: <input type="text" name="userID" style="font-size: 80%;" /> <font style="font-size: 80%;"></font> Pass: <input type="password" name="pword" style="font-size: 80%;" /> <input type="submit" value="Login" style="font-size: 80%;" /><br /><input type="checkbox" name="cookiescheck" />Remember Login? | <a href="index.php?action=register#registration"><b>Register to play!</b></a><br /><a href="index.php?action=forgotpass"><i>Forgot Password?</i></a></form></div></div>
<?php
}
// end nav buttons
?>
</td>
</tr></table>
