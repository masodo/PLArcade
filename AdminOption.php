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
# Section: AdminOption.php  Function: Call To Administrator Control Panel   Modified: 7/29/2019   By: MaSoDo

if ($exist['group'] == "Admin") { 

if(isset($_GET['cpiarea'])) {
//echo "<script>alert('Experimental')</script>";
require("acpi.php");
}
} else {
message("Only administratiors may access the admin CP");
}
?>
