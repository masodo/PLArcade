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
# Section: acpi place: idx.php Administrator Control Panel   Modified: 7/26/2019   By: MaSoDo

{
message("Welcome to the Admin CP, <b>$phpqa_user_cookie</b>.");
?>
<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'><tr><td class='headertableblock' align='left' colspan=9><b><font size=-5>Add New Games</font></b></td></tr><td class='arcade1' align='left'>Add new games to your arcade using a variety of methods.<br><br>[ <a href='index.php?cpiarea=addgames'>Add Games</a> ]</div></td></table></div>
<br />
<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'><tr><td class='headertableblock' align='left' colspan=9><b><font size=-5>Edit/Create Cats</font></b></td></tr><td class='arcade1' align='left'>Manage Arcade categories.<br><br>[ <a href='index.php?cpiarea=cats'>Manage</a> ]</div></td></table></div>
<br />
<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'><tr><td class='headertableblock' align='left' colspan=9><b><font size=-5>Skin Control</font></b></td></tr><td class='arcade1' align='left'>Create new skin files, edit, and delete.<br><br>[ <a href='index.php?cpiarea=skin'>Manage</a> ]</div></td></table></div>
<br />
<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'><tr><td class='headertableblock' align='left' colspan=9><b><font size=-5>Games manager</font></b></td></tr><td class='arcade1' align='left'>Sort, delete and edit existing games in your arcade's library.<br><br>[ <a href='index.php?cpiarea=games'>Manage</a> ]</div></td></table></div>
<br />
<div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9 align='left'><b><font size=-5>Emoticons</font></b></td></tr><td class=arcade1 align='left'>Add smilies to your arcade. To make the smiley images appear in the dropdown, upload them to the emoticons folder.<br><br>[ <a href='index.php?cpiarea=emotes'>Manage</a> ]</div></td></table></div>
<br />
<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'><tr><td class='headertableblock' align='left' colspan=9><b><font size=-5>MySQL Toolbox</font></b></td></tr><td class='arcade1' align='left'>Backup, restore, repair, and optimize your databse.<br><br>[ <a href='index.php?cpiarea=mysql'>Manager</a> ]</div></td></table></div>
<br />
<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'><tr><td class='headertableblock' align='left' colspan=9><b><font size=-5>JavaScript Beautify</font></b></td></tr><td class='arcade1' align='left'>Beautify, unpack or deobfuscate JavaScript and HTML, make JSON/JSONP readable, etc.<br><br>[ <a href='index.php?cpiarea=JSbeauty'>Beautify</a> ]</div></td></table></div>

<br />

<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'><tr><td class='headertableblock' align='left' colspan=9><b><font size=-5>Member Editor</font></b></td></tr><td class='arcade1' align='left'>Edit members. Avatar, and profile info, erase members... also get IP address on date of registration, make moderators and admins, etc. 
<br><br>[ <a href='index.php?cpiarea=members'>Manager</a> ] [ <a href='?cpiarea=members&act=Validating'>Validating Users</a> ]</div></td></table></div>
<br />
<div align='center'><div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9><b><font size=-5>Arcade Announcement</font></b></td></tr><td class=arcade1>Edit announcement message file.<br><br>[ <a href='?cpiarea=editor&announce=<?php echo($AnnounceFile) ?>'>Edit</a> ]</div></td></table></div>
<br />
<div align='center'><div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9><b><font size=-5>Affiliated Arcades</font></b></td></tr><td class=arcade1>Data Management for Bottom Page Banner Marquee<br><br>[ <a href='?cpiarea=affiliates'>Manage</a> ]</div></td></table></div>
<br />
<div align='center'><div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9><b><font size=-5>Banned IP addresses</font></b></td></tr><td class=arcade1>Banned IP address list.<br><br>[ <a href='?cpiarea=bannedIPlist'>Manage</a> ]</div></td></table></div>
<br />
<!-- 
06/01/09
What can I say? This is a stupid section that was never fully finished; and there's never going to be a way to protect these games.
Cheat protection is a joke; http_referer is so easily faked it's not even funny. It's just not worth having. As long as the games
can be decompiled, and http is as 'vulnerable' as it is, it cannot be beat 100%, and certainly not in a platform like this. Maybe
at some point in the future this will change, but not for now.
<div align='center'><div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9><b><font size=-5>Blocked Cheating Attempts</font></b></td></tr><td class=arcade1>Check logs for cheating.<br><br>[ <a href='?cpiarea=Cheating_Attempts'>Manage</a> ]</div></td></table></div>
<br /> 
-->
<div align='center'><div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9><b><font size=-5>Settings</font></b></td></tr><td class=arcade1>Edit your arcade's settings. Enable validation, enable shoutbox, disable features etc <br><br>[ <a href='?cpiarea=settings'>Manage</a> ]</div></td></table></div>
<br />
<div align='center'><div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9><b><font size=-5>Post Office</font></b></td></tr><td class=arcade1>Send an email to all members. Note: requires hosting to have the mail(); feature on.<br><br>[ <a href='?cpiarea=Email'>Manage</a> ]</div></td></table></div>
<br />
<div align='center'><div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9><b><font size=-5>Word Filters</font></b></td></tr><td class=arcade1>Modify badword filters.<br><br>[ <a href='?cpiarea=filter'>Manage</a> ]</div></td></table></div>
<br />
<div align='center'><div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9><b><font size=-5>Snapshot</font></b></td></tr><td class=arcade1>Wall of Fame SnapShot<br><br>[ <a href='?cpiarea=snapshot'>Lock Champion SnapShot</a> ]</div></td></table></div>
<br />
<?php
}
?>
