<?php
if (isset($_GET['dofull'])) 
{
$BigGame = $_GET['dofull'];
$H = $_GET['H'];
$W = $_GET['W'];
$H = ($H * 2);
$W = ($W * 2);
}
//echo "<div style='width:100%; height:100%;'><iframe src='arcade/" . $BigGame . "' class='iframe' scrolling='no' frameborder='0' ></iframe></div>";
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="100%" height="100%" align="middle"> <param name="movie" value="arcade/<?php echo "". $BigGame ."" ?>"><param name="quality" value="high"> <param name="allowScriptAccess" value="sameDomain"> <param name="menu" value="false"> <embed src="<?php echo "arcade/". $BigGame ."" ?>" quality="high" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" menu="false" type="application/x-shockwave-flash" width="100%" height="100%" align="middle"></object>
